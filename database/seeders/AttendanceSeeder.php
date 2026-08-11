<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('user_type', '!=', 'admin')->get();
        $statuses = ['P', 'A', 'H', 'U', 'NCNS'];
        $markedBy = User::where('user_type', 'admin')->first()?->id ?? 1;

        // Generate attendance for the last 30 days
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays($i);
            
            // Skip weekends (Saturday = 6, Sunday = 0)
            if ($date->dayOfWeek == 0 || $date->dayOfWeek == 6) {
                continue;
            }

            foreach ($users as $user) {
                // Skip some random days for variety
                if (rand(1, 20) == 1) {
                    continue;
                }

                $status = $statuses[array_rand($statuses)];
                $checkIn = null;
                $checkOut = null;
                $remarks = null;

                switch ($status) {
                    case 'P':
                        $checkIn = $date->copy()->setTime(rand(8, 10), rand(0, 59));
                        $checkOut = $date->copy()->setTime(rand(17, 19), rand(0, 59));
                        $remarks = 'Regular attendance';
                        break;
                    case 'U':
                        $checkIn = $date->copy()->setTime(rand(10, 12), rand(0, 59));
                        $checkOut = $date->copy()->setTime(rand(18, 20), rand(0, 59));
                        $remarks = 'Arrived late due to traffic';
                        break;
                    case 'H':
                        $checkIn = $date->copy()->setTime(rand(8, 10), rand(0, 59));
                        $checkOut = $date->copy()->setTime(rand(12, 14), rand(0, 59));
                        $remarks = 'Half day leave - personal work';
                        break;
                    case 'A':
                        $remarks = 'Sick leave';
                        break;
                    case 'NCNS':
                        $remarks = 'No call no show';
                        break;
                }

                Attendance::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'attendance_date' => $date->toDateString(),
                    ],
                    [
                        'status' => $status,
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                        'remarks' => $remarks,
                        'marked_by' => $markedBy,
                    ]
                );
            }
        }

        // Generate some additional random attendance records
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $date = Carbon::now()->subDays(rand(1, 60));
            
            // Skip weekends
            if ($date->dayOfWeek == 0 || $date->dayOfWeek == 6) {
                continue;
            }

            $status = $statuses[array_rand($statuses)];
            $checkIn = null;
            $checkOut = null;
            $remarks = null;

            switch ($status) {
                case 'P':
                    $checkIn = $date->copy()->setTime(rand(8, 10), rand(0, 59));
                    $checkOut = $date->copy()->setTime(rand(17, 19), rand(0, 59));
                    $remarks = 'Regular attendance';
                    break;
                case 'U':
                    $checkIn = $date->copy()->setTime(rand(10, 12), rand(0, 59));
                    $checkOut = $date->copy()->setTime(rand(18, 20), rand(0, 59));
                    $remarks = 'Arrived late';
                    break;
                case 'H':
                    $checkIn = $date->copy()->setTime(rand(8, 10), rand(0, 59));
                    $checkOut = $date->copy()->setTime(rand(12, 14), rand(0, 59));
                    $remarks = 'Half day';
                    break;
                case 'A':
                    $remarks = 'Absent';
                    break;
                case 'NCNS':
                    $remarks = 'No call no show';
                    break;
            }

            Attendance::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'attendance_date' => $date->toDateString(),
                ],
                [
                    'status' => $status,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'remarks' => $remarks,
                    'marked_by' => $markedBy,
                ]
            );
        }
    }
}