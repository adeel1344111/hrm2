<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Only allow Team Leads, Floor Managers, and Admins to access attendance
        if (!$user->isAdmin() && !$user->isFloorManager() && !$user->isTeamLead()) {
            abort(403, 'Unauthorized access to attendance management.');
        }

        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        $employees = $this->getFilteredEmployees($user, $selectedDate);
        $allEmployees = $this->getFilteredEmployees($user, $selectedDate, true); // Get all for filtering (inactive included)

        // Get attendance records for the selected date
        $attendances = Attendance::whereIn('user_id', $employees->pluck('id'))
            ->where('attendance_date', $selectedDate)
            ->with(['user', 'markedBy'])
            ->get()
            ->keyBy('user_id');

        // Get statistics
        $stats = $this->getAttendanceStats($employees, $selectedDate);

        return view('attendance.index', compact('employees', 'allEmployees', 'attendances', 'selectedDate', 'stats'));
    }

    public function markAttendance(Request $request)
    {
        $user = Auth::user();

        // Only allow Team Leads, Floor Managers, and Admins to mark attendance
        if (!$user->isAdmin() && !$user->isFloorManager() && !$user->isTeamLead()) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:P,A,H,U,NCNS,HOLIDAY',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Check if user can mark attendance for this employee
        $employee = User::findOrFail($request->user_id);
        if (!$this->canMarkAttendanceFor($user, $employee)) {
            return response()->json(['error' => 'You are not authorized to mark attendance for this employee'], 403);
        }

        // Validate Appointment Date
        if ($employee->appointment_date && Carbon::parse($request->attendance_date)->lt(Carbon::parse($employee->appointment_date))) {
            return response()->json(['error' => 'Attendance cannot be marked before appointment date (' . $employee->appointment_date->format('Y-m-d') . ')'], 422);
        }

        // Validate Left Date
        if ($employee->left_date && Carbon::parse($request->attendance_date)->gte(Carbon::parse($employee->left_date))) {
            return response()->json(['error' => 'Attendance cannot be marked on or after date of leaving (' . $employee->left_date->format('Y-m-d') . ')'], 422);
        }

        // Check if attendance already exists for this date
        $attendance = Attendance::where('user_id', $request->user_id)
            ->where('attendance_date', $request->attendance_date)
            ->first();

        if ($attendance) {
            // Update existing attendance
            $attendance->update([
                'status' => $request->status,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'remarks' => $request->remarks,
                'marked_by' => $user->id,
            ]);
        }
        else {
            // Create new attendance
            $attendance = Attendance::create([
                'user_id' => $request->user_id,
                'attendance_date' => $request->attendance_date,
                'status' => $request->status,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'remarks' => $request->remarks,
                'marked_by' => $user->id,
            ]);
        }

        return response()->json([
            'success' => 'Attendance marked successfully',
            'attendance' => [
                'status' => $request->status,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'remarks' => $request->remarks,
                'marked_by' => $user->name,
                'status_label' => $attendance->status_label ?? ($request->status === 'P' ? 'Present' : ($request->status === 'A' ? 'Absent' : ($request->status === 'H' ? 'Half Day' : ($request->status === 'U' ? 'Unpaid' : ($request->status === 'NCNS' ? 'NCNS' : 'Holiday'))))),
                'status_color' => $attendance->status_color ?? ($request->status === 'P' ? 'text-green-500 bg-green-100' : ($request->status === 'A' ? 'text-red-500 bg-red-100' : ($request->status === 'H' ? 'text-yellow-500 bg-yellow-100' : ($request->status === 'U' ? 'text-gray-500 bg-gray-100' : ($request->status === 'NCNS' ? 'text-orange-500 bg-orange-100' : 'text-purple-500 bg-purple-100')))))
            ]
        ]);
    }

    public function bulkMarkAttendance(Request $request)
    {
        $user = Auth::user();

        // Only allow Team Leads, Floor Managers, and Admins to mark attendance
        if (!$user->isAdmin() && !$user->isFloorManager() && !$user->isTeamLead()) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'attendances' => 'required|array',
            'attendances.*.user_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:P,A,H,U,NCNS,HOLIDAY',
            'attendances.*.check_in' => 'nullable|date_format:H:i',
            'attendances.*.check_out' => 'nullable|date_format:H:i',
            'attendances.*.remarks' => 'nullable|string|max:500',
        ]);

        $employees = $this->getFilteredEmployees($user, $request->from_date, true); // Include inactive to allow marking
        $employeeIds = $employees->pluck('id')->toArray();

        $startDate = Carbon::parse($request->from_date);
        // If no end date is provided, only mark attendance for the start date.
        $endDate = $request->filled('to_date') ? Carbon::parse($request->to_date) : $startDate->copy();

        // Limit the range to prevent performance issues (e.g., max 31 days)
        if ($startDate->diffInDays($endDate) > 31) {
            return response()->json(['error' => 'Date range cannot exceed 31 days'], 422);
        }

        $warnings = [];
        $successCount = 0;

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dateString = $currentDate->format('Y-m-d');

            foreach ($request->attendances as $attendanceData) {
                // Check if user can mark attendance for this employee
                if (!in_array($attendanceData['user_id'], $employeeIds)) {
                    continue; // Skip unauthorized employees
                }

                // Get employee object (optimized: rely on $employees collection keyed by id or find from collection)
                $employee = $employees->firstWhere('id', $attendanceData['user_id']);

                if (!$employee)
                    continue;

                // Validate Appointment Date
                if ($employee->appointment_date && $currentDate->lt($employee->appointment_date)) {
                    $warnings[] = "{$employee->name} ({$employee->employee_id}): Cannot mark for {$dateString} (Before appointment date " . $employee->appointment_date->format('Y-m-d') . ")";
                    continue;
                }

                // Validate Left Date
                if ($employee->left_date && $currentDate->gte($employee->left_date)) {
                    $warnings[] = "{$employee->name} ({$employee->employee_id}): Cannot mark for {$dateString} (After leaving date " . $employee->left_date->format('Y-m-d') . ")";
                    continue;
                }

                $attendance = Attendance::where('user_id', $attendanceData['user_id'])
                    ->where('attendance_date', $dateString)
                    ->first();

                if ($attendance) {
                    $attendance->update([
                        'status' => $attendanceData['status'],
                        'check_in' => $attendanceData['check_in'] ?? null,
                        'check_out' => $attendanceData['check_out'] ?? null,
                        'remarks' => $attendanceData['remarks'] ?? null,
                        'marked_by' => $user->id,
                    ]);
                }
                else {
                    Attendance::create([
                        'user_id' => $attendanceData['user_id'],
                        'attendance_date' => $dateString,
                        'status' => $attendanceData['status'],
                        'check_in' => $attendanceData['check_in'] ?? null,
                        'check_out' => $attendanceData['check_out'] ?? null,
                        'remarks' => $attendanceData['remarks'] ?? null,
                        'marked_by' => $user->id,
                    ]);
                }
                $successCount++;
            }

            $currentDate->addDay();
        }

        return response()->json([
            'success' => "Attendance marked successfully for $successCount records.",
            'warnings' => $warnings
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $user = Auth::user();

        // Authorization check
        if (!$user->isAdmin() && !$user->isFloorManager() && !$user->isTeamLead()) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $startDate = Carbon::parse($request->from_date);
        $endDate = Carbon::parse($request->to_date);

        // Limit range
        if ($startDate->diffInDays($endDate) > 31) {
            return response()->json(['error' => 'Date range cannot exceed 31 days'], 422);
        }

        $employees = $this->getFilteredEmployees($user, $request->from_date);
        $authorizedEmployeeIds = $employees->pluck('id')->toArray();

        $targetUserIds = array_intersect($request->user_ids, $authorizedEmployeeIds);

        if (empty($targetUserIds)) {
            return response()->json(['error' => 'No authorized employees selected for deletion'], 422);
        }

        $deletedCount = Attendance::whereIn('user_id', $targetUserIds)
            ->whereBetween('attendance_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->delete();

        return response()->json([
            'success' => "Successfully deleted $deletedCount attendance records.",
            'count' => $deletedCount
        ]);
    }

    public function report(Request $request)
    {
        $user = Auth::user();

        // Team Leads, Floor Managers, Admins, and Management (own report)
        if (!$user->isAdmin() && !$user->isFloorManager() && !$user->isTeamLead() && !$user->isManagement()) {
            abort(403, 'Unauthorized access to attendance reports.');
        }

        $selectedMonth = $request->get('month', Carbon::now()->format('Y-m'));
        $selectedEmployee = $request->get('employee_id');

        // Get attendance data for the selected month
        $startDate = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $selectedMonth)->endOfMonth();

        $allEmployees = $this->getFilteredEmployees($user, $startDate);

        $query = Attendance::whereIn('user_id', $allEmployees->pluck('id'))
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->with(['user', 'markedBy']);

        if ($selectedEmployee) {
            $query->where('user_id', $selectedEmployee);
        }

        $attendances = $query->get()->groupBy('user_id');

        // Filter employees to only those who have attendance records
        $employees = $allEmployees->whereIn('id', $attendances->keys());

        // Calculate monthly statistics
        $monthlyStats = $this->getMonthlyStats($employees, $startDate, $endDate, $selectedEmployee);

        return view('attendance.report', compact('employees', 'allEmployees', 'attendances', 'selectedMonth', 'selectedEmployee', 'monthlyStats', 'startDate', 'endDate'));
    }

    private function getFilteredEmployees($user, $dateContext = null, $includeAllInactive = false)
    {
        // Determine the date range for the "active in this month" check
        $date = $dateContext ?Carbon::parse($dateContext) : Carbon::today();
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $isToday = $date->isToday();

        $inactiveFilter = function ($query) use ($startOfMonth, $endOfMonth, $isToday) {
            $query->where('status', 'active');
            if (!$isToday) {
                $query->orWhereHas('attendances', function ($q) use ($startOfMonth, $endOfMonth) {
                            $q->whereBetween('attendance_date', [$startOfMonth, $endOfMonth]);
                        }
                        );
                    }
                };

        if ($user->isAdmin()) {
            // Admin: agents (CSR/VO) + management (TL / FM / management / admin) for office attendance
            return User::whereIn('user_type', ['agent', 'team_lead', 'floor_manager', 'management', 'admin'])
                ->when(!$includeAllInactive, function ($q) use ($inactiveFilter) {
                $q->where($inactiveFilter);
            })
                ->orderBy('employee_id')
                ->get();
        }
        elseif ($user->isManagement()) {
            // Management: own attendance only
            return User::where('id', $user->id)->get();
        }
        elseif ($user->isFloorManager()) {
            // Floor manager: their team leads + agents under those team leads
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->where('status', 'active')
                ->pluck('id');

            $teamLeads = User::whereIn('id', $teamLeadIds)
                ->when(!$includeAllInactive, function ($q) use ($inactiveFilter) {
                $q->where($inactiveFilter);
            })
                ->get();

            $agents = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->when(!$includeAllInactive, function ($q) use ($inactiveFilter) {
                $q->where($inactiveFilter);
            })
                ->get();

            return $teamLeads->merge($agents)->sortBy('employee_id')->values();
        }
        elseif ($user->isTeamLead()) {
            // Team lead can only see agents under them (active or inactive with history IN THIS MONTH)
            return User::where('team_lead_id', $user->id)
                ->where('user_type', 'agent')
                ->when(!$includeAllInactive, function ($q) use ($inactiveFilter) {
                $q->where($inactiveFilter);
            })
                ->orderBy('employee_id')
                ->get();
        }

        return collect();
    }

    private function canMarkAttendanceFor($user, $employee)
    {
        if ($user->isAdmin()) {
            return true; // Admin can mark attendance for all employees
        }
        elseif ($user->isFloorManager()) {
            // Floor manager can mark attendance for team leads under them and agents under those team leads
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');

            $agentIds = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->pluck('id');

            $allIds = $teamLeadIds->merge($agentIds);

            return $allIds->contains($employee->id);
        }
        elseif ($user->isTeamLead()) {
            // Team lead can only mark attendance for agents under them
            return $employee->team_lead_id === $user->id && $employee->user_type === 'agent';
        }

        return false;
    }

    private function getAttendanceStats($employees, $date)
    {
        $totalEmployees = $employees->count();

        $attendanceCounts = Attendance::whereIn('user_id', $employees->pluck('id'))
            ->where('attendance_date', $date)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $present = $attendanceCounts['P'] ?? 0;
        $absent = $attendanceCounts['A'] ?? 0;
        $halfDay = $attendanceCounts['H'] ?? 0;
        $unpaid = $attendanceCounts['U'] ?? 0;
        $ncns = $attendanceCounts['NCNS'] ?? 0;
        $holiday = $attendanceCounts['HOLIDAY'] ?? 0;
        $notMarked = $totalEmployees - array_sum($attendanceCounts);

        return [
            'total' => $totalEmployees,
            'present' => $present,
            'absent' => $absent,
            'half_day' => $halfDay,
            'unpaid' => $unpaid,
            'ncns' => $ncns,
            'holiday' => $holiday,
            'not_marked' => $notMarked,
        ];
    }
    public function destroy($id)
    {
        $user = Auth::user();
        $attendance = Attendance::findOrFail($id);

        // Authorization check: Admin can delete any. FM/TL can delete if they can mark attendance for that user.
        // Reusing basic permission logic or strict hierarchy check.
        // For simplicity and matching current flow:
        if (!$user->isAdmin() && !$user->isFloorManager() && !$user->isTeamLead()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Ideally add deeper check: can this TL actually manage this attendance's user?
        // Using existing helper or logic:
        $attendanceUser = $attendance->user;
        if (!$this->canMarkAttendanceFor($user, $attendanceUser)) {
            return response()->json(['error' => 'Unauthorized to delete attendance for this employee'], 403);
        }

        $attendance->delete();

        return response()->json(['success' => 'Attendance deleted successfully']);
    }

    public function getInvalidRecords()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Before Appointment
        $beforeAppointment = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->whereNotNull('users.appointment_date')
            ->whereColumn('attendances.attendance_date', '<', 'users.appointment_date')
            ->select('attendances.id', 'users.name', 'users.employee_id', 'attendances.attendance_date', 'users.appointment_date')
            ->get()
            ->map(function ($record) {
            $record->reason = 'Before Appointment Date (' . $record->appointment_date . ')';
            return $record;
        });

        // After Left
        $afterLeft = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->whereNotNull('users.left_date')
            ->whereColumn('attendances.attendance_date', '>=', 'users.left_date')
            ->select('attendances.id', 'users.name', 'users.employee_id', 'attendances.attendance_date', 'users.left_date')
            ->get()
            ->map(function ($record) {
            $record->reason = 'On/After Leaving Date (' . $record->left_date . ')';
            return $record;
        });

        $invalidRecords = $beforeAppointment->merge($afterLeft);

        return response()->json([
            'success' => true,
            'records' => $invalidRecords
        ]);
    }

    public function cleanupInvalidRecords()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $invalidCount = 0;

        // Find records before appointment date
        $beforeAppointment = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->whereNotNull('users.appointment_date')
            ->whereColumn('attendances.attendance_date', '<', 'users.appointment_date')
            ->pluck('attendances.id');

        // Find records after or on leaving date
        $afterLeft = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->whereNotNull('users.left_date')
            ->whereColumn('attendances.attendance_date', '>=', 'users.left_date')
            ->pluck('attendances.id');

        $allInvalidIds = $beforeAppointment->merge($afterLeft)->unique();
        $invalidCount = $allInvalidIds->count();

        if ($invalidCount > 0) {
            Attendance::whereIn('id', $allInvalidIds)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully deleted {$invalidCount} invalid attendance records.",
            'count' => $invalidCount
        ]);
    }
    private function getMonthlyStats($employees, $startDate, $endDate, $selectedEmployee = null)
    {
        $query = Attendance::whereIn('user_id', $employees->pluck('id'))
            ->whereBetween('attendance_date', [$startDate, $endDate]);

        if ($selectedEmployee) {
            $query->where('user_id', $selectedEmployee);
        }

        $attendanceCounts = $query->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Use calendar days in month — avoid Carbon float diffInDays(startOfMonth, endOfMonth)
        // which yields ~30.999… + 1 ≈ 32 after round() for 31-day months.
        $totalDays = (int) $startDate->daysInMonth;
        $totalEmployees = $selectedEmployee ? 1 : $employees->count();
        $totalRecords = array_sum($attendanceCounts);

        return [
            'total_days' => $totalDays,
            'total_employees' => $totalEmployees,
            'total_records' => $totalRecords,
            'present' => $attendanceCounts['P'] ?? 0,
            'absent' => $attendanceCounts['A'] ?? 0,
            'half_day' => $attendanceCounts['H'] ?? 0,
            'unpaid' => $attendanceCounts['U'] ?? 0,
            'ncns' => $attendanceCounts['NCNS'] ?? 0,
            'holiday' => $attendanceCounts['HOLIDAY'] ?? 0,
            'attendance_rate' => $totalRecords > 0 ? round((($attendanceCounts['P'] ?? 0) / $totalRecords) * 100, 2) : 0,
        ];
    }
}