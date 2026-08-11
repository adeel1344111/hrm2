<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ZkAttendanceController extends Controller
{
    public function health()
    {
        return response()->json([
            'ok' => true,
            'service' => 'hrm2-zk-attendance',
            'app' => 'hrm2',
            'timezone' => config('app.timezone'),
        ]);
    }

    public function ingest(Request $request)
    {
        $records = $request->input('records', []);
        $users = $request->input('users', []);

        if (!is_array($records)) $records = [];
        if (!is_array($users)) $users = [];

        if (count($records) === 0 && count($users) === 0) {
            return response()->json(['error' => 'No records or users provided'], 400);
        }

        $this->ensureSupportTables();

        $usersUpserted = 0;
        foreach ($users as $u) {
            if (!isset($u['userId'])) continue;
            $zkId = (string) $u['userId'];
            $name = trim((string) ($u['name'] ?? ''));
            DB::table('zk_device_users')->updateOrInsert(
                ['zk_user_id' => $zkId],
                [
                    'name' => $name !== '' ? $name : ('User '.$zkId),
                    'uid' => $u['uid'] ?? null,
                    'raw' => json_encode($u),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
            $usersUpserted++;
        }

        // HRM2 app timezone (currently America/Phoenix)
        $appTz = config('app.timezone', 'America/Phoenix');
        // Device wall clock is Pakistan office time
        $deviceTz = env('ZK_DEVICE_TIMEZONE', 'Asia/Karachi');

        $markedBy = $this->zkMarkerId();
        $byDay = [];
        $insertedPunches = 0;
        $unmapped = [];

        foreach ($records as $row) {
            if (empty($row['userId']) || empty($row['timestamp'])) continue;

            $zkId = (string) $row['userId'];
            $user = $this->resolveUser($zkId);
            if (!$user) {
                $unmapped[$zkId] = true;
                continue;
            }

            try {
                $hrmLocal = $this->toHrmLocal($row['timestamp'], $deviceTz, $appTz);
            } catch (\Throwable $e) {
                continue;
            }

            $date = $hrmLocal->toDateString();
            $time = $hrmLocal->format('H:i:s');
            $punch = (int) ($row['punch'] ?? $row['status'] ?? 0);
            $key = $zkId.'|'.$date.'|'.$time.'|'.$punch;

            $exists = DB::table('zk_punches')->where('punch_key', $key)->exists();
            if (!$exists) {
                DB::table('zk_punches')->insert([
                    'punch_key' => $key,
                    'user_id' => $user->id,
                    'zk_user_id' => $zkId,
                    'punch_at' => $hrmLocal->format('Y-m-d H:i:s'),
                    'attendance_date' => $date,
                    'punch' => $punch,
                    'device_id' => $request->input('deviceId'),
                    'device_ip' => $request->input('deviceIp'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $insertedPunches++;
            }

            $bucketKey = $user->id.'|'.$date;
            if (!isset($byDay[$bucketKey])) {
                $byDay[$bucketKey] = [
                    'user_id' => $user->id,
                    'date' => $date,
                    'first_at' => $hrmLocal->copy(),
                ];
            } elseif ($hrmLocal->lt($byDay[$bucketKey]['first_at'])) {
                $byDay[$bucketKey]['first_at'] = $hrmLocal->copy();
            }
        }

        $attendanceUpserted = 0;
        foreach ($byDay as $bucket) {
            /** @var Carbon $firstAt */
            $firstAt = $bucket['first_at'];
            $checkIn = $firstAt->format('H:i');

            $existing = Attendance::where('user_id', $bucket['user_id'])
                ->where('attendance_date', $bucket['date'])
                ->first();

            if ($existing) {
                $existingCheckIn = $existing->check_in
                    ? Carbon::parse($bucket['date'].' '.$existing->check_in, $appTz)
                    : null;

                $shouldUpdateCheckIn = !$existingCheckIn || $firstAt->lt($existingCheckIn);

                $status = in_array($existing->status, ['HOLIDAY', 'U', 'NCNS'], true)
                    ? $existing->status
                    : 'P';

                $update = [
                    'status' => $status,
                    'check_out' => null,
                    'remarks' => null,
                    'marked_by' => $markedBy,
                ];

                if ($shouldUpdateCheckIn) {
                    $update['check_in'] = $checkIn;
                }

                $existing->update($update);
            } else {
                Attendance::create([
                    'user_id' => $bucket['user_id'],
                    'attendance_date' => $bucket['date'],
                    'status' => 'P',
                    'check_in' => $checkIn,
                    'check_out' => null,
                    'remarks' => null,
                    'marked_by' => $markedBy,
                ]);
            }
            $attendanceUpserted++;
        }

        return response()->json([
            'ok' => true,
            'received' => count($records),
            'inserted' => $insertedPunches,
            'attendanceUpserted' => $attendanceUpserted,
            'usersUpserted' => $usersUpserted,
            'unmappedUserIds' => array_keys($unmapped),
            'rule' => 'first_punch_of_day_only',
            'deviceTimezone' => $deviceTz,
            'hrmTimezone' => $appTz,
            'markedBy' => 'ZK device',
            'total' => DB::table('zk_punches')->count(),
            'totalUsers' => DB::table('zk_device_users')->count(),
        ]);
    }

    /**
     * Convert a device punch timestamp into HRM2 local time.
     * Office ZK clock is Asia/Karachi; HRM2 APP_TIMEZONE may differ (e.g. America/Phoenix).
     */
    private function toHrmLocal(string $timestamp, string $deviceTz, string $appTz): Carbon
    {
        // Prefer true instant if agent sent real ISO UTC
        if (str_ends_with($timestamp, 'Z') || preg_match('/[+-]\d{2}:\d{2}$/', $timestamp)) {
            return Carbon::parse($timestamp)->utc()->timezone($appTz);
        }

        // Naive timestamp: treat as device local wall clock
        return Carbon::parse($timestamp, $deviceTz)->timezone($appTz);
    }

    public function pendingNameSync()
    {
        $this->ensureSupportTables();
        $rows = DB::table('zk_device_users')
            ->where('pending_name_sync', 1)
            ->get(['zk_user_id as userId', 'uid', 'name', 'note']);

        return response()->json([
            'ok' => true,
            'count' => $rows->count(),
            'users' => $rows,
        ]);
    }

    public function ackNameSync(Request $request)
    {
        $this->ensureSupportTables();
        $results = $request->input('results', []);
        if (!is_array($results) || count($results) === 0) {
            return response()->json(['error' => 'No results provided'], 400);
        }

        $cleared = 0;
        $failed = 0;
        foreach ($results as $row) {
            $zkId = (string) ($row['userId'] ?? '');
            if ($zkId === '') continue;
            if (!empty($row['ok'])) {
                $update = [
                    'pending_name_sync' => 0,
                    'device_sync_error' => null,
                    'device_synced_at' => now(),
                    'updated_at' => now(),
                ];
                if (!empty($row['name'])) {
                    $update['name'] = $row['name'];
                }
                DB::table('zk_device_users')->where('zk_user_id', $zkId)->update($update);
                $cleared++;
            } else {
                DB::table('zk_device_users')->where('zk_user_id', $zkId)->update([
                    'device_sync_error' => $row['error'] ?? 'Device update failed',
                    'updated_at' => now(),
                ]);
                $failed++;
            }
        }

        return response()->json(['ok' => true, 'cleared' => $cleared, 'failed' => $failed]);
    }

    public function updateUser(Request $request, string $employeeKey)
    {
        $this->ensureSupportTables();
        $zkId = (string) $employeeKey;
        $name = trim((string) $request->input('name', ''));
        $note = $request->input('note');

        if ($name === '') {
            return response()->json(['error' => 'Name cannot be empty'], 400);
        }
        if (strlen($name) > 24) {
            return response()->json(['error' => 'Name must be 24 characters or fewer (machine limit)'], 400);
        }

        $pending = $request->boolean('nameLocked') === false ? 0 : 1;

        DB::table('zk_device_users')->updateOrInsert(
            ['zk_user_id' => $zkId],
            [
                'name' => $name,
                'note' => is_string($note) ? trim($note) : null,
                'name_locked' => 1,
                'pending_name_sync' => $pending,
                'device_sync_error' => null,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $user = $this->resolveUser($zkId);
        if ($user && $request->boolean('updateHrmName')) {
            $user->name = $name;
            $user->save();
        }

        $row = DB::table('zk_device_users')->where('zk_user_id', $zkId)->first();

        return response()->json([
            'ok' => true,
            'user' => [
                'userId' => $zkId,
                'name' => $row->name,
                'note' => $row->note,
                'nameLocked' => (bool) $row->name_locked,
                'pendingDeviceSync' => (bool) $row->pending_name_sync,
            ],
            'message' => 'Saved. Office sync will write this name to the machine.',
        ]);
    }

    private function resolveUser(string $zkUserId): ?User
    {
        if (Schema::hasColumn('users', 'zk_user_id')) {
            $direct = User::where('zk_user_id', $zkUserId)->first();
            if ($direct) return $direct;
        }

        $users = User::query()
            ->whereNotNull('employee_id')
            ->get(['id', 'employee_id', 'name', 'status', 'appointment_date', 'left_date']);

        foreach ($users as $user) {
            $numeric = preg_replace('/\D+/', '', (string) $user->employee_id);
            $numeric = ltrim((string) $numeric, '0');
            $zkNorm = ltrim($zkUserId, '0');
            if ($numeric !== '' && $numeric === $zkNorm) {
                return User::find($user->id);
            }
            if ((string) $user->employee_id === $zkUserId) {
                return User::find($user->id);
            }
        }

        return null;
    }

    private function zkMarkerId(): int
    {
        $existing = User::where('employee_id', 'ZK-DEVICE')->value('id');
        if ($existing) {
            return (int) $existing;
        }

        return (int) DB::table('users')->insertGetId([
            'name' => 'ZK device',
            'password' => Hash::make(bin2hex(random_bytes(16))),
            'user_type' => 'admin',
            'employee_id' => 'ZK-DEVICE',
            'status' => 'inactive',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function ensureSupportTables(): void
    {
        if (!Schema::hasTable('zk_punches')) {
            Schema::create('zk_punches', function ($table) {
                $table->id();
                $table->string('punch_key')->unique();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('zk_user_id')->index();
                $table->dateTime('punch_at');
                $table->date('attendance_date')->index();
                $table->unsignedTinyInteger('punch')->default(0);
                $table->string('device_id')->nullable();
                $table->string('device_ip')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('zk_device_users')) {
            Schema::create('zk_device_users', function ($table) {
                $table->id();
                $table->string('zk_user_id')->unique();
                $table->string('name')->nullable();
                $table->unsignedInteger('uid')->nullable();
                $table->string('note')->nullable();
                $table->boolean('name_locked')->default(false);
                $table->boolean('pending_name_sync')->default(false);
                $table->string('device_sync_error')->nullable();
                $table->timestamp('device_synced_at')->nullable();
                $table->json('raw')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('users', 'zk_user_id')) {
            Schema::table('users', function ($table) {
                $table->string('zk_user_id')->nullable()->unique()->after('employee_id');
            });
        }
    }
}
