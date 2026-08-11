<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $leaves = $this->getFilteredLeaves($user, $request);
        $stats = $this->getLeaveStats($user, $request);

        // Get filter options
        $leaveTypes = LeaveType::where('is_active', true)->pluck('name')->toArray();
        $userTypes = ['admin', 'management', 'floor_manager', 'team_lead', 'agent'];
        $statuses = ['Pending', 'Approved', 'Rejected', 'Cancelled'];

        return view('leaves.index', compact('leaves', 'stats', 'leaveTypes', 'userTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Only allow employees to create leave requests
        if (!$user->isAgent() && !$user->isTeamLead() && !$user->isFloorManager() && !$user->isAdmin() && !$user->isManagement()) {
            abort(403, 'Unauthorized access.');
        }

        $leaveTypes = LeaveType::where('is_active', true)->get();

        return view('leaves.create', compact('leaveTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Get valid leave types from database
        $validLeaveTypes = LeaveType::where('is_active', true)->pluck('name')->toArray();
        
        $request->validate([
            'leave_type' => 'required|string|in:' . implode(',', $validLeaveTypes),
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        $leave = Leave::create([
            'user_id' => $user->id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'status' => 'Pending',
        ]);
        
        // Notify floor manager and admin about new leave request
        $managers = User::floorManagerRole()->get();
        $admins = User::where('user_type', 'admin')->get();
        $notifyUsers = $managers->merge($admins);
        
        foreach ($notifyUsers as $notifyUser) {
            Notification::create([
                'user_id' => $notifyUser->id,
                'type' => 'leave_request',
                'title' => 'New Leave Request',
                'message' => "{$user->name} requested {$request->leave_type} leave from {$startDate->format('M d')} to {$endDate->format('M d, Y')}",
                'data' => [
                    'leave_id' => $leave->id,
                    'employee_id' => $user->id,
                    'employee_name' => $user->name,
                    'leave_type' => $request->leave_type,
                ],
            ]);
        }

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find leave with relationships
        $leave = Leave::with(['user', 'approvedBy'])->find($id);
        
        // Check if leave exists
        if (!$leave) {
            abort(404, 'Leave request not found.');
        }
        
        // Check if user relationship exists (data integrity)
        if (!$leave->user) {
            abort(404, 'Leave request data is incomplete.');
        }
        
        return view('leaves.show', compact('leave'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        $user = Auth::user();
        
        // Only allow editing if it's the user's own leave and status is Pending
        if ($leave->user_id !== $user->id || $leave->status !== 'Pending') {
            abort(403, 'Unauthorized access.');
        }

        $leaveTypes = LeaveType::where('is_active', true)->get();

        return view('leaves.edit', compact('leave', 'leaveTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        $user = Auth::user();
        
        // Only allow updating if it's the user's own leave and status is Pending
        if ($leave->user_id !== $user->id || $leave->status !== 'Pending') {
            abort(403, 'Unauthorized access.');
        }

        // Get valid leave types from database
        $validLeaveTypes = LeaveType::where('is_active', true)->pluck('name')->toArray();
        
        $request->validate([
            'leave_type' => 'required|string|in:' . implode(',', $validLeaveTypes),
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        $leave->update([
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        $user = Auth::user();
        
        // Only allow deleting if it's the user's own leave and status is Pending
        if ($leave->user_id !== $user->id || $leave->status !== 'Pending') {
            abort(403, 'Unauthorized access.');
        }

        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Leave request cancelled successfully.');
    }

    /**
     * Approve a leave request
     */
    public function approve(Leave $leave)
    {
        $user = Auth::user();
        
        // Only Admin and Floor Manager can approve leaves
        if (!$user->canApproveLeaves()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if user can approve this leave
        if (!$this->canApproveLeave($leave, $user)) {
            abort(403, 'Unauthorized access.');
        }

        $leave->update([
            'status' => 'Approved',
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);
        
        // Notify employee about approval
        Notification::create([
            'user_id' => $leave->user_id,
            'type' => 'leave_approved',
            'title' => 'Leave Request Approved',
            'message' => "Your {$leave->leave_type} leave request has been approved by {$user->name}",
            'data' => [
                'leave_id' => $leave->id,
                'approved_by' => $user->name,
                'leave_type' => $leave->leave_type,
            ],
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request approved successfully.');
    }

    /**
     * Reject a leave request
     */
    public function reject(Request $request, Leave $leave)
    {
        $user = Auth::user();
        
        // Only Admin and Floor Manager can reject leaves
        if (!$user->canApproveLeaves()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if user can approve this leave
        if (!$this->canApproveLeave($leave, $user)) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'admin_remarks' => 'nullable|string|max:500',
        ]);

        $leave->update([
            'status' => 'Rejected',
            'admin_remarks' => $request->admin_remarks ?? 'Leave request rejected.',
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);
        
        // Notify employee about rejection
        Notification::create([
            'user_id' => $leave->user_id,
            'type' => 'leave_rejected',
            'title' => 'Leave Request Rejected',
            'message' => "Your {$leave->leave_type} leave request has been rejected. Reason: {$leave->admin_remarks}",
            'data' => [
                'leave_id' => $leave->id,
                'rejected_by' => $user->name,
                'leave_type' => $leave->leave_type,
                'reason' => $leave->admin_remarks,
            ],
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request rejected successfully.');
    }

    /**
     * Get filtered leaves based on user role
     */
    private function getFilteredLeaves($user, $request)
    {
        $query = Leave::with(['user', 'approvedBy']);

        // Apply role-based filtering
        if ($user->isAdmin() || $user->hasOrgWideAccess()) {
            // Admin / management can see all leaves
        } elseif ($user->isFloorManager()) {
            // Floor Manager can see leaves from their team leads and agents
            $teamLeadIds = $user->teamLeads()->pluck('id');
            $agentIds = $user->allAgents()->pluck('id');
            $userIds = $teamLeadIds->merge($agentIds)->push($user->id);
            $query->whereIn('user_id', $userIds);
        } elseif ($user->isTeamLead()) {
            // Team Lead can see leaves from their agents and their own
            $agentIds = $user->agents()->pluck('id');
            $userIds = $agentIds->push($user->id);
            $query->whereIn('user_id', $userIds);
        } else {
            // Agent can only see their own leaves
            $query->where('user_id', $user->id);
        }

        // Apply filters from request
        if ($request->has('leave_type') && $request->leave_type) {
            $query->where('leave_type', $request->leave_type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_type') && $request->user_type) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('user_type', $request->user_type);
            });
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->where('start_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('end_date', '<=', $request->date_to);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get leave statistics based on user role
     */
    private function getLeaveStats($user, $request)
    {
        $baseQuery = Leave::query();

        // Apply role-based filtering
        if ($user->isAdmin() || $user->hasOrgWideAccess()) {
            // Admin / management sees all leave stats
        } elseif ($user->isFloorManager()) {
            $teamLeadIds = $user->teamLeads()->pluck('id');
            $agentIds = $user->allAgents()->pluck('id');
            $userIds = $teamLeadIds->merge($agentIds)->push($user->id);
            $baseQuery->whereIn('user_id', $userIds);
        } elseif ($user->isTeamLead()) {
            $agentIds = $user->agents()->pluck('id');
            $userIds = $agentIds->push($user->id);
            $baseQuery->whereIn('user_id', $userIds);
        } else {
            $baseQuery->where('user_id', $user->id);
        }

        // Apply same filters as main query for consistent stats
        if ($request->has('leave_type') && $request->leave_type) {
            $baseQuery->where('leave_type', $request->leave_type);
        }

        if ($request->has('user_type') && $request->user_type) {
            $baseQuery->whereHas('user', function($q) use ($request) {
                $q->where('user_type', $request->user_type);
            });
        }

        if ($request->has('date_from') && $request->date_from) {
            $baseQuery->where('start_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $baseQuery->where('end_date', '<=', $request->date_to);
        }

        return [
            'total' => $baseQuery->count(),
            'pending' => $baseQuery->clone()->where('status', 'Pending')->count(),
            'approved' => $baseQuery->clone()->where('status', 'Approved')->count(),
            'rejected' => $baseQuery->clone()->where('status', 'Rejected')->count(),
        ];
    }

    /**
     * Check if user can view a specific leave request
     */
    private function canViewLeave($leave, $user)
    {
        // User can always view their own leave
        if ($leave->user_id === $user->id) {
            return true;
        }
        
        // Admin / management can view all leaves
        if ($user->isAdmin() || $user->hasOrgWideAccess()) {
            return true;
        }
        
        // Floor Manager can view leaves from their team
        if ($user->isFloorManager()) {
            $teamLeadIds = $user->teamLeads()->pluck('id');
            $agentIds = $user->allAgents()->pluck('id');
            $userIds = $teamLeadIds->merge($agentIds);
            return $userIds->contains($leave->user_id);
        }
        
        // Team Lead can view leaves from their agents
        if ($user->isTeamLead()) {
            $agentIds = $user->agents()->pluck('id');
            return $agentIds->contains($leave->user_id);
        }
        
        return false;
    }

    /**
     * Check if user can approve a specific leave request
     */
    private function canApproveLeave($leave, $user)
    {
        if ($user->canApproveLeaves()) {
            if ($user->isAdmin() || $user->hasOrgWideAccess()) {
                return true;
            }
            if ($user->isFloorManager()) {
                $teamLeadIds = $user->teamLeads()->pluck('id');
                $agentIds = $user->allAgents()->pluck('id');
                $userIds = $teamLeadIds->merge($agentIds)->push($user->id);
                return $userIds->contains($leave->user_id);
            }
        }
        
        return false;
    }
}