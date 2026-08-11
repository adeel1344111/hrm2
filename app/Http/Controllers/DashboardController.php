<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Submission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Preload relationships to prevent N+1 queries
        $dashboardData = $this->getDashboardData($user);
        
        return view('dashboard.home', compact('dashboardData'));
    }
    
    private function getDashboardData($user)
    {
        $data = [];
        
        if ($user->isAdmin()) {
            $data = $this->getAdminDashboardData();
        } elseif ($user->isFloorManager()) {
            $data = $this->getFloorManagerDashboardData($user);
        } elseif ($user->isTeamLead()) {
            $data = $this->getTeamLeadDashboardData($user);
        } elseif ($user->isManagement()) {
            $data = $this->getManagementDashboardData($user);
        } elseif ($user->isAgent()) {
            $data = $this->getAgentDashboardData($user);
        }
        
        return $data;
    }

    private function getManagementDashboardData($user)
    {
        $today = now()->subHours(6)->toDateString();
        $todayAttendance = $user->attendances()
            ->whereRaw('DATE(DATE_SUB(attendance_date, INTERVAL 6 HOUR)) = ?', [$today])
            ->first();

        $attendanceThisWeek = $user->attendances()
            ->whereBetween('attendance_date', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')])
            ->where('status', 'P')
            ->count();

        $pendingLeaves = $user->leaves()->where('status', 'Pending')->count();
        $approvedLeaves = $user->leaves()->where('status', 'Approved')->count();
        $totalLeaves = $user->leaves()->count();

        return [
            'todayAttendance' => $todayAttendance,
            'attendanceThisWeek' => $attendanceThisWeek,
            'pendingLeaves' => $pendingLeaves,
            'approvedLeaves' => $approvedLeaves,
            'totalLeaves' => $totalLeaves,
            'employeeId' => $user->employee_id,
            'department' => $user->department ?? 'Management',
            'designation' => $user->designation ?? 'Management',
        ];
    }
    
    private function getAdminDashboardData()
    {
        // Count submissions from both tables with 6-hour offset to match business day
        $today = now()->subHours(6)->toDateString();
        $csrCount = (new Submission)->setTable('csr_submissions')->whereRaw('DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) = ?', [$today])->count();
        $verificationCount = (new Submission)->setTable('verification_submissions')->whereRaw('DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) = ?', [$today])->count();
        
        return [
            'totalUsers' => User::where('status', 'active')->count(),
            'todayAttendance' => Attendance::whereRaw('DATE(DATE_SUB(attendance_date, INTERVAL 6 HOUR)) = ?', [$today])->where('status', 'P')->count(),
            'pendingLeaves' => Leave::where('status', 'pending')->count(),
            'todaySubmissions' => $csrCount + $verificationCount,
            'userDistribution' => [
                'admins' => User::where('user_type', 'admin')->where('status', 'active')->count(),
                'floorManagers' => User::floorManagerRole()->where('status', 'active')->count(),
                'teamLeads' => User::teamLeadRole()->where('status', 'active')->count(),
                'agents' => User::where('user_type', 'agent')->where('status', 'active')->count(),
            ],
            'weeklyAttendance' => $this->getWeeklyAttendanceData(),
            'recentActivities' => $this->getRecentActivities(),
        ];
    }
    
    private function getFloorManagerDashboardData($user)
    {
        $teamLeads = $user->teamLeads()->with(['agents' => function($query) {
            $query->with(['attendances' => function($q) {
                $today = now()->subHours(6)->toDateString();
                $q->whereRaw('DATE(DATE_SUB(attendance_date, INTERVAL 6 HOUR)) = ?', [$today]);
            }]);
        }])->get();
        
        $totalAgents = $teamLeads->sum(function($teamLead) {
            return $teamLead->agents->count();
        });
        
        $presentToday = $teamLeads->sum(function($teamLead) {
            return $teamLead->agents->where('attendances.status', 'P')->count();
        });
        
        $agentIds = $user->allAgents()->pluck('users.id');
        $today = now()->subHours(6)->toDateString();
        $csrCount = (new Submission)->setTable('csr_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereRaw('DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) = ?', [$today])
            ->count();
        $verificationCount = (new Submission)->setTable('verification_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereRaw('DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) = ?', [$today])
            ->count();

        $csrCounts = \DB::table('csr_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereMonth('created_at', now()->month)
            ->select('submitted_by', \DB::raw('count(*) as aggregate'))
            ->groupBy('submitted_by')
            ->pluck('aggregate', 'submitted_by');

        $verCounts = \DB::table('verification_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereMonth('created_at', now()->month)
            ->select('submitted_by', \DB::raw('count(*) as aggregate'))
            ->groupBy('submitted_by')
            ->pluck('aggregate', 'submitted_by');

        return [
            'stats' => [
                'total_team_leads' => $teamLeads->count(),
                'total_agents' => $totalAgents,
                'active_now' => $presentToday,
                'total_submissions' => $csrCount + $verificationCount,
            ],
            'todaySubmissions' => $csrCount + $verificationCount,
            'department' => $user->department ?? 'N/A',
            'employeeId' => $user->employee_id,
            'teamLeads' => $teamLeads,
            'recentActivities' => $this->getRecentActivities($user),
            'userDistribution' => [
                'admins' => User::where('user_type', 'admin')->where('status', 'active')->count(),
                'floorManagers' => User::floorManagerRole()->where('status', 'active')->count(),
                'teamLeads' => User::teamLeadRole()->where('status', 'active')->count(),
                'agents' => User::where('user_type', 'agent')->where('status', 'active')->count(),
            ],
            'teamPerformancePie' => [
                'labels' => $teamLeads->pluck('name')->toArray(),
                'data' => $teamLeads->map(function ($teamLead) use ($csrCounts, $verCounts) {
                    $sum = 0;
                    foreach ($teamLead->agents as $agent) {
                        $sum += ($csrCounts[$agent->id] ?? 0) + ($verCounts[$agent->id] ?? 0);
                    }
                    return $sum;
                })->toArray(),
            ],
        ];
    }
    
    private function getTeamLeadDashboardData($user)
    {
        $today = now()->subHours(6)->toDateString();
        $agents = $user->agents()->with(['attendances' => function($query) use ($today) {
            $query->whereRaw('DATE(DATE_SUB(attendance_date, INTERVAL 6 HOUR)) = ?', [$today]);
        }])->get();
        
        $presentToday = $agents->where('attendances.status', 'P')->count();
        
        // Count from both tables
        $agentIds = $agents->pluck('id');
        $today = now()->subHours(6)->toDateString();
        $csrCount = (new Submission)->setTable('csr_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereRaw('DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) = ?', [$today])
            ->count();
        $verificationCount = (new Submission)->setTable('verification_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereRaw('DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) = ?', [$today])
            ->count();
        
        
        // Get all team leads and their submission counts for comparison
        $allTeamLeads = User::teamLeadRole()
            ->with('agents:id,team_lead_id')
            ->where('status', 'active')
            ->get();
            
        $allSystemAgentIds = $allTeamLeads->flatMap(function($tl) { return $tl->agents->pluck('id'); })->unique();

        $sysCsrCounts = \DB::table('csr_submissions')
            ->whereIn('submitted_by', $allSystemAgentIds)
            ->whereMonth('created_at', now()->month)
            ->select('submitted_by', \DB::raw('count(*) as aggregate'))
            ->groupBy('submitted_by')
            ->pluck('aggregate', 'submitted_by');

        $sysVerCounts = \DB::table('verification_submissions')
            ->whereIn('submitted_by', $allSystemAgentIds)
            ->whereMonth('created_at', now()->month)
            ->select('submitted_by', \DB::raw('count(*) as aggregate'))
            ->groupBy('submitted_by')
            ->pluck('aggregate', 'submitted_by');
        
        $teamComparisonData = $allTeamLeads->map(function ($teamLead) use ($user, $sysCsrCounts, $sysVerCounts) {
            $sum = 0;
            foreach ($teamLead->agents as $agent) {
                $sum += ($sysCsrCounts[$agent->id] ?? 0) + ($sysVerCounts[$agent->id] ?? 0);
            }
            return [
                'name' => $teamLead->name,
                'count' => $sum,
                'is_current_user' => $teamLead->id === $user->id
            ];
        })->sortByDesc('count')->values();
        
        return [
            'stats' => [
                'total_agents' => $agents->count(),
                'present_today' => $presentToday,
                'month_submissions' => $this->getTeamMonthSubmissions($user),
                'pending_approvals' => \App\Models\Leave::whereIn('user_id', $agentIds)->where('status', 'pending')->count(),
            ],
            'todaySubmissions' => $csrCount + $verificationCount,
            'floorManager' => $user->floorManager ? $user->floorManager->name : 'N/A',
            'todaySubmissions' => $csrCount + $verificationCount,
            'agents' => $agents,
            'weeklySubmissions' => $this->getTeamWeeklySubmissions($user),
            'recentActivities' => $this->getRecentActivities($user),
            'userDistribution' => [
                'admins' => User::where('user_type', 'admin')->where('status', 'active')->count(),
                'floorManagers' => User::floorManagerRole()->where('status', 'active')->count(),
                'teamLeads' => User::teamLeadRole()->where('status', 'active')->count(),
                'agents' => User::where('user_type', 'agent')->where('status', 'active')->count(),
            ],
            'teamPerformancePie' => [
                'labels' => $teamComparisonData->pluck('name')->toArray(),
                'data' => $teamComparisonData->pluck('count')->toArray(),
                'currentUserIndex' => $teamComparisonData->search(function($item) use ($user) {
                    return $item['is_current_user'];
                })
            ],
        ];
    }
    
    private function getAgentDashboardData($user)
    {
        $today = now()->subHours(6)->toDateString();
        $todayAttendance = $user->attendances()->whereRaw('DATE(DATE_SUB(attendance_date, INTERVAL 6 HOUR)) = ?', [$today])->first();
        $totalSubmissions = $user->submissions()->count();
        $todaySubmissions = $user->submissions()->whereRaw('DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) = ?', [$today])->count();
        $attendanceThisWeek = $user->attendances()
            ->whereBetween('attendance_date', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')])
            ->where('status', 'P')
            ->count();
        $pendingLeaves = $user->leaves()->where('status', 'pending')->count();
        
        return [
            'todayAttendance' => $todayAttendance,
            'totalSubmissions' => $totalSubmissions,
            'teamLead' => $user->teamLead ? $user->teamLead->name : 'N/A',
            'employeeId' => $user->employee_id,
            'department' => $user->department ?? 'Agent',
            'todaySubmissions' => $todaySubmissions,
            'attendanceThisWeek' => $attendanceThisWeek,
            'pendingLeaves' => $pendingLeaves,
            'weeklySubmissions' => $this->getPersonalWeeklySubmissions($user),
        ];
    }

    private function getWeeklyAttendanceData()
    {
        $startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = now()->startOfWeek()->addDays(6)->format('Y-m-d');

        $counts = Attendance::whereBetween('attendance_date', [$startOfWeek, $endOfWeek])
            ->whereIn('status', ['P', 'A'])
            ->select('attendance_date', 'status', \DB::raw('count(*) as aggregate'))
            ->groupBy('attendance_date', 'status')
            ->get();

        $data = [];
        for ($i = 0; $i < 7; $i++) {
            $date = now()->startOfWeek()->addDays($i);
            $dateStr = $date->format('Y-m-d');
            
            $present = $counts->where('attendance_date', $dateStr)->where('status', 'P')->first()->aggregate ?? 0;
            $absent = $counts->where('attendance_date', $dateStr)->where('status', 'A')->first()->aggregate ?? 0;
            
            $data[] = [
                'date' => $date->format('D'),
                'present' => $present,
                'absent' => $absent,
            ];
        }
        return $data;
    }
    
    private function getRecentActivities($user = null)
    {
        $activities = collect();
        $limit = 5;

        // Determine scope
        $agentIds = [];
        if ($user) {
            if ($user->isFloorManager()) {
                $agentIds = $user->allAgents()->pluck('users.id')->toArray();
            } elseif ($user->isTeamLead()) {
                $agentIds = $user->agents()->pluck('id')->toArray();
            }
        }
        
        // 1. Submissions
        $csrQuery = (new Submission)->setTable('csr_submissions')->with('submittedBy');
        $verQuery = (new Submission)->setTable('verification_submissions')->with('submittedBy');

        if (!empty($agentIds)) {
            $csrQuery->whereIn('submitted_by', $agentIds);
            $verQuery->whereIn('submitted_by', $agentIds);
        }

        $csrSubmissions = $csrQuery->latest()->take($limit)->get();
        $verificationSubmissions = $verQuery->latest()->take($limit)->get();
        $recentSubmissions = $csrSubmissions->concat($verificationSubmissions)->sortByDesc('created_at')->take($limit);
        
        foreach($recentSubmissions as $submission) {
            $activities->push([
                'type' => 'submission',
                'message' => $submission->submittedBy->name . ' submitted ' . $submission->campaign,
                'time' => $submission->created_at,
                'icon' => 'file-text',
                'color' => 'blue'
            ]);
        }
        
        // 2. Leaves (showing requests from team members)
        $leaveQuery = Leave::with('user');
        if (!empty($agentIds)) {
            $leaveQuery->whereIn('user_id', $agentIds);
        }
        $recentLeaves = $leaveQuery->latest()->take($limit)->get();

        foreach($recentLeaves as $leave) {
            $activities->push([
                'type' => 'leave',
                'message' => $leave->user->name . ' requested ' . $leave->leave_type . ' leave',
                'time' => $leave->created_at,
                'icon' => 'calendar',
                'color' => 'orange'
            ]);
        }
        
        // 3. Attendance (showing team member status changes)
        $attendanceQuery = Attendance::with('user');
        if (!empty($agentIds)) {
            $attendanceQuery->whereIn('user_id', $agentIds);
        }
        $recentAttendance = $attendanceQuery->latest()->take($limit)->get();

        foreach($recentAttendance as $attendance) {
            $activities->push([
                'type' => 'attendance',
                'message' => $attendance->user->name . ' marked ' . ($attendance->status == 'P' ? 'Present' : 'Absent'),
                'time' => $attendance->created_at,
                'icon' => 'user-check',
                'color' => $attendance->status == 'P' ? 'green' : 'red'
            ]);
        }
        
        return $activities->sortByDesc('time')->take($limit);
    }
    
    private function getTeamWeeklySubmissions($user)
    {
        $agentIds = $user->agents()->pluck('id');
        $startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = now()->startOfWeek()->addDays(6)->format('Y-m-d');

        $csrCounts = \DB::table('csr_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereBetween(\DB::raw('DATE(created_at)'), [$startOfWeek, $endOfWeek])
            ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as aggregate'))
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->pluck('aggregate', 'date');

        $verCounts = \DB::table('verification_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereBetween(\DB::raw('DATE(created_at)'), [$startOfWeek, $endOfWeek])
            ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as aggregate'))
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->pluck('aggregate', 'date');

        $data = [];
        for ($i = 0; $i < 7; $i++) {
            $date = now()->startOfWeek()->addDays($i)->format('Y-m-d');
            $data[] = ($csrCounts[$date] ?? 0) + ($verCounts[$date] ?? 0);
        }
        return $data;
    }

    private function getTeamMonthSubmissions($user)
    {
        $agentIds = $user->agents()->pluck('id');
        $csrCount = (new Submission)->setTable('csr_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereMonth('created_at', now()->month)
            ->count();
        $verificationCount = (new Submission)->setTable('verification_submissions')
            ->whereIn('submitted_by', $agentIds)
            ->whereMonth('created_at', now()->month)
            ->count();
        return $csrCount + $verificationCount;
    }
    
    private function getPersonalWeeklySubmissions($user)
    {
        $startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = now()->startOfWeek()->addDays(6)->format('Y-m-d');

        $csrCounts = \DB::table('csr_submissions')
            ->where('submitted_by', $user->id)
            ->whereBetween(\DB::raw('DATE(created_at)'), [$startOfWeek, $endOfWeek])
            ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as aggregate'))
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->pluck('aggregate', 'date');

        $verCounts = \DB::table('verification_submissions')
            ->where('submitted_by', $user->id)
            ->whereBetween(\DB::raw('DATE(created_at)'), [$startOfWeek, $endOfWeek])
            ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as aggregate'))
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->pluck('aggregate', 'date');

        $data = [];
        for ($i = 0; $i < 7; $i++) {
            $date = now()->startOfWeek()->addDays($i)->format('Y-m-d');
            $data[] = ($csrCounts[$date] ?? 0) + ($verCounts[$date] ?? 0);
        }
        return $data;
    }
}
