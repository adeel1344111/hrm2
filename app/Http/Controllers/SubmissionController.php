<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Designation;
use Carbon\Carbon;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedDate = $request->get('date', now()->format('Y-m-d'));
        
        $submissions = $this->getFilteredSubmissions($user, $selectedDate);
        $stats = $this->getSubmissionStats($user, $selectedDate);

        // CSR = Sale when same phone exists in verification_submissions for that day
        $salePhones = \Illuminate\Support\Facades\DB::table('verification_submissions')
            ->whereDate('created_at', $selectedDate)
            ->pluck('phone')
            ->map(fn ($p) => preg_replace('/\D+/', '', (string) $p))
            ->filter()
            ->flip();

        $submissions->transform(function ($submission) use ($user, $salePhones) {
            $submission->masked_phone = $this->maskPhoneNumber($submission->phone, $user);
            $digits = preg_replace('/\D+/', '', (string) $submission->phone);
            $submission->is_sale = ($submission->submission_type === 'csr') && $salePhones->has($digits);
            return $submission;
        });

        return view('submissions.index', compact('submissions', 'stats', 'selectedDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $campaigns = $this->getCampaigns();
        $teamLeads = User::teamLeadRole()->get();
        
        // Get last campaign from both tables
        $lastCsrSubmission = (new Submission)->setTable('csr_submissions')
            ->where('submitted_by', $user->id)
            ->latest()
            ->first();
        $lastVerificationSubmission = (new Submission)->setTable('verification_submissions')
            ->where('submitted_by', $user->id)
            ->latest()
            ->first();
        
        // Get the most recent one
        $lastCampaign = null;
        if ($lastCsrSubmission && $lastVerificationSubmission) {
            $lastCampaign = $lastCsrSubmission->created_at > $lastVerificationSubmission->created_at 
                ? $lastCsrSubmission->campaign 
                : $lastVerificationSubmission->campaign;
        } elseif ($lastCsrSubmission) {
            $lastCampaign = $lastCsrSubmission->campaign;
        } elseif ($lastVerificationSubmission) {
            $lastCampaign = $lastVerificationSubmission->campaign;
        }
        
        // Get team lead name for the current user
        $teamLeadName = null;
        if ($user->teamLead) {
            $teamLeadName = $user->teamLead->name;
        }
        
        return view('submissions.create', compact('campaigns', 'teamLeads', 'user', 'lastCampaign', 'teamLeadName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Base validation rules
        $rules = [
            'employee_id' => 'required|string|max:255',
            'employee_name' => 'required|string|max:255',
            'team_lead_name' => 'required|string|max:255',
            'campaign' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'comment' => 'nullable|string|max:1000',
        ];
        
        // Add role-specific validation
        if ($user->isCsr()) {
            $rules['state'] = 'required|string|max:255';
            $rules['zip_code'] = 'required|string|max:20';
            $rules['age'] = 'nullable|integer|min:18|max:120';
            $rules['jornaya_id'] = 'nullable|string|max:255';
        } elseif ($user->isVerificationOfficer()) {
            $rules['jornaya_id'] = 'required|string|max:255';
            $rules['did'] = 'required|string|max:255';
        }
        
        $request->validate($rules);

        // Get team lead name for the current user
        $teamLeadName = $user->teamLead ? $user->teamLead->name : 'Not Assigned';

        // Prepare common data
        $data = [
            'employee_id' => $user->employee_id,
            'employee_name' => $user->name,
            'team_lead_name' => $teamLeadName,
            'campaign' => $request->campaign,
            'phone' => $this->cleanPhoneNumber($request->phone),
            'comment' => $request->comment,
            'submitted_by' => $user->id,
        ];
        
        // Add role-specific fields
        if ($user->isCsr()) {
            $data['state'] = $request->state;
            $data['zip_code'] = $request->zip_code;
            $data['jornaya_id'] = $request->jornaya_id;
        } elseif ($user->isVerificationOfficer()) {
            $data['jornaya_id'] = $request->jornaya_id;
            $data['did'] = $request->did;
        }

        // Determine table based on designation
        $tableName = 'csr_submissions';
        if ($user->isVerificationOfficer()) {
            $tableName = 'verification_submissions';
        }

        // Check for existing submission for same phone, same user, same day
        $existingSubmission = (new Submission)->setTable($tableName)
            ->where('submitted_by', $user->id)
            ->where('phone', $data['phone']) // Use cleaned phone number
            ->whereRaw('DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) = ?', [now()->subHours(6)->toDateString()])
            ->first();

        if ($existingSubmission) {
            // Update existing submission
            $existingSubmission->update($data);
            $submission = $existingSubmission;
            $message = 'Submission updated successfully';
            $isNew = false;
        } else {
            // Create new submission
            $submission = Submission::createByDesignation($data, $user);
            $message = 'Submission created successfully';
            $isNew = true;
        }
        
        // Notify team lead and floor manager about new submission
        $notifyUsers = collect();
        
        if ($user->teamLead) {
            $notifyUsers->push($user->teamLead);
        }
        
        if ($user->floorManager) {
            $notifyUsers->push($user->floorManager);
        }
        
        if ($isNew) {
            $submissionType = $user->isVerificationOfficer() ? 'Verification' : 'CSR';
            
            foreach ($notifyUsers as $notifyUser) {
                Notification::create([
                    'user_id' => $notifyUser->id,
                    'type' => 'submission',
                    'title' => 'New Submission',
                    'message' => "{$user->name} submitted a new {$submissionType} submission for {$request->campaign}",
                    'data' => [
                        'submission_id' => $submission->id,
                        'employee_id' => $user->id,
                        'employee_name' => $user->name,
                        'campaign' => $request->campaign,
                        'submission_type' => $submissionType,
                    ],
                ]);
            }
        }

        return redirect()->route('submissions.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $user = Auth::user();
        $type = $request->query('type', 'csr');
        $submission = $this->findSubmissionByType($id, $type);
        
        if (!$submission) {
            abort(404, 'Submission not found.');
        }

        // Authorization check: Agents can only view their own submissions
        if ($user->isAgent() && $submission->submitted_by !== $user->id) {
            abort(403, 'You do not have permission to view this submission.');
        }

        // Team Leads can only view submissions from their team
        if ($user->isTeamLead()) {
            $teamAgentIds = $user->agents()->pluck('id')->push($user->id);
            if (!$teamAgentIds->contains($submission->submitted_by)) {
                abort(403, 'You do not have permission to view this submission.');
            }
        }

        // Floor Managers can only view submissions from their teams
        if ($user->isFloorManager()) {
            $allAgentIds = $user->allAgents()->pluck('id')->push($user->id);
            $teamLeadIds = $user->teamLeads()->pluck('id');
            $allowedIds = $allAgentIds->merge($teamLeadIds);
            if (!$allowedIds->contains($submission->submitted_by)) {
                abort(403, 'You do not have permission to view this submission.');
            }
        }

        // Add masked phone number and type
        $submission->masked_phone = $this->maskPhoneNumber($submission->phone);
        $submission->submission_type = $type;

        return view('submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        
        // Only admins can edit submissions
        if (!$user->isAdmin()) {
            abort(403, 'You do not have permission to edit submissions.');
        }
        
        $type = $request->query('type', 'csr');
        $submission = $this->findSubmissionByType($id, $type);
        
        if (!$submission) {
            abort(404, 'Submission not found.');
        }

        $campaigns = $this->getCampaigns();
        $teamLeads = User::teamLeadRole()->get();
        
        // Add masked phone number and type
        $submission->masked_phone = $this->maskPhoneNumber($submission->phone);
        $submission->submission_type = $type;
        
        return view('submissions.edit', compact('submission', 'campaigns', 'teamLeads'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        // Only admins can update
        if (!$user->isAdmin()) {
            abort(403, 'You do not have permission to update submissions.');
        }
        
        $type = $request->query('type', $request->input('submission_type', 'csr'));
        $submission = $this->findSubmissionByType($id, $type);
        
        if (!$submission) {
            abort(404, 'Submission not found.');
        }

        // Base validation rules
        $rules = [
            'employee_id' => 'required|string|max:255',
            'employee_name' => 'required|string|max:255',
            'team_lead_name' => 'required|string|max:255',
            'campaign' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'comment' => 'nullable|string|max:1000',
        ];
        
        // Add role-specific validation based on submission type
        if ($submission->submission_type === 'csr') {
            $rules['state'] = 'required|string|max:255';
            $rules['zip_code'] = 'required|string|max:20';
            $rules['jornaya_id'] = 'nullable|string|max:255';
        } elseif ($submission->submission_type === 'verification') {
            $rules['jornaya_id'] = 'required|string|max:255';
            $rules['did'] = 'required|string|max:255';
        }
        
        $request->validate($rules);

        // Clean phone number before updating
        $updateData = $request->except(['_token', '_method', 'submission_type']);
        $updateData['phone'] = $this->cleanPhoneNumber($request->phone);
        
        // Remove submission_type attribute from model (set in edit method)
        unset($submission->submission_type);
        
        // Use fill() and save() to only update fillable attributes
        $submission->fill($updateData);
        $submission->save();

        return redirect()->route('submissions.index')->with('success', 'Submission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        
        // Only admins can delete
        if (!$user->isAdmin()) {
            abort(403, 'You do not have permission to delete submissions.');
        }
        
        $type = $request->query('type', 'csr');
        $submission = $this->findSubmissionByType($id, $type);
        
        if (!$submission) {
            abort(404, 'Submission not found.');
        }

        $submission->delete();

        return redirect()->route('submissions.index')->with('success', 'Submission deleted successfully.');
    }

    /**
     * Display submission report (List View)
     */
    public function report(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Get filter parameters from request
            $startDate = $request->get('start_date', now()->startOfWeek()->format('Y-m-d'));
            $endDate = $request->get('end_date', now()->endOfWeek()->format('Y-m-d'));
            $designationId = $request->get('designation');
            $agentId = $request->get('agent_id');
            
            // Resolve designation name from ID if provided
            $designationName = null;
            if ($designationId) {
                $designation = Designation::find($designationId);
                if ($designation) {
                    $designationName = $designation->name;
                }
            }
            
            // Get submissions list for the date range
            $submissions = $this->getFilteredSubmissionsRange($user, $startDate, $endDate, $designationName, $agentId);
            
            // Get all possible agents for the current user (to populate the dropdown via JS)
            $allAgents = $this->getFilteredAgents($user);
            
            // Get designations for filter
            $designations = Designation::where('status', 'active')->get();
            
            return view('submissions.report', compact('allAgents', 'designations', 'startDate', 'endDate', 'submissions', 'designationId', 'agentId'));
        } catch (\Exception $e) {
            \Log::error('Submission report error: ' . $e->getMessage());
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display monthly submission matrix report
     */
    public function monthlyReport(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Default to current month
            $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
            $designationId = $request->get('designation');
            $agentId = $request->get('agent_id');
            
            // Resolve designation name from ID if provided
            $designationName = null;
            if ($designationId) {
                $designation = Designation::find($designationId);
                if ($designation) {
                    $designationName = $designation->name;
                }
            }
            
            // Get agents based on user type and designation filter
            $agents = $this->getFilteredAgents($user, $designationName);

            // If a specific agent is selected, filter the agents collection
            if ($agentId) {
                $agents = $agents->where('id', $agentId);
            }
            
            // Get submissions data for the date range and designation
            $reportData = $this->getReportData($user, $startDate, $endDate, $agents, $designationName);
            
            // Get all possible agents for the current user (to populate the dropdown via JS)
            $allAgents = $this->getFilteredAgents($user);
            
            // Get designations for filter
            $designations = Designation::where('status', 'active')->get();
            
            return view('submissions.monthly_report', compact('reportData', 'agents', 'allAgents', 'designations', 'startDate', 'endDate', 'designationId', 'agentId'));
        } catch (\Exception $e) {
            \Log::error('Monthly submission report error: ' . $e->getMessage());
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get filtered submissions for a date range (used on report page list)
     */
    private function getFilteredSubmissionsRange($user, $startDate, $endDate, $designation = null, $agentId = null)
    {
        $start = \Carbon\Carbon::parse($startDate)->startOfDay();
        $end = \Carbon\Carbon::parse($endDate)->endOfDay();

        $csrQuery = Submission::query()->from('csr_submissions')
            ->with(['submittedBy'])
            ->whereBetween('created_at', [$start, $end]);

        $verificationQuery = Submission::query()->from('verification_submissions')
            ->with(['submittedBy'])
            ->whereBetween('created_at', [$start, $end]);

        if ($user->isAdmin()) {
            // No additional filtering
        } elseif ($user->isFloorManager()) {
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');

            $agentIds = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->pluck('id');

            $allIds = $teamLeadIds->merge($agentIds);
            $csrQuery->whereIn('submitted_by', $allIds);
            $verificationQuery->whereIn('submitted_by', $allIds);
        } elseif ($user->isTeamLead()) {
            $agentIds = User::where('team_lead_id', $user->id)
                ->where('user_type', 'agent')
                ->pluck('id');

            $csrQuery->whereIn('submitted_by', $agentIds);
            $verificationQuery->whereIn('submitted_by', $agentIds);
        } else {
            $csrQuery->where('submitted_by', $user->id);
            $verificationQuery->where('submitted_by', $user->id);
        }

        // Apply agent filter if specified
        if ($agentId) {
            $csrQuery->where('submitted_by', $agentId);
            $verificationQuery->where('submitted_by', $agentId);
        }

        $results = collect();

        if (!$designation || $designation === 'CSR') {
            $csr = $csrQuery->get()->map(function ($item) {
                $item->submission_type = 'csr';
                return $item;
            });
            $results = $results->concat($csr);
        }

        if (!$designation || $designation === 'Verification Officer') {
            $verification = $verificationQuery->get()->map(function ($item) {
                $item->submission_type = 'verification';
                return $item;
            });
            $results = $results->concat($verification);
        }

        return $results->sortByDesc('created_at')->values();
    }


    /**
     * Get filtered submissions based on user type
     */
    private function getFilteredSubmissions($user, $selectedDate)
    {
        // Initialize queries for both tables using from() to ensure correct table target
        $csrQuery = Submission::query()->from('csr_submissions')
            ->with(['submittedBy'])
            ->whereDate('created_at', $selectedDate);
            
        $verificationQuery = Submission::query()->from('verification_submissions')
            ->with(['submittedBy'])
            ->whereDate('created_at', $selectedDate);
            
        // Apply filters based on user role
        if ($user->isAdmin()) {
            // No additional filtering needed for admin
        } elseif ($user->isFloorManager()) {
            // Floor manager can see submissions from their team leads and agents
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');
            
            $agentIds = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->pluck('id');
            
            $allIds = $teamLeadIds->merge($agentIds);
            
            $csrQuery->whereIn('submitted_by', $allIds);
            
            // For verification, allow if submitted by team OR if it verifies a team sale (matching phone)
            // Get phones from team's CSR submissions today
            $teamPhones = (clone $csrQuery)->pluck('phone');
            
            $verificationQuery->where(function($q) use ($allIds, $teamPhones) {
                $q->whereIn('submitted_by', $allIds)
                  ->orWhereIn('phone', $teamPhones);
            });
            
        } elseif ($user->isTeamLead()) {
            // Team lead can see submissions from their agents
            $agentIds = User::where('team_lead_id', $user->id)
                ->where('user_type', 'agent')
                ->pluck('id');
            
            $csrQuery->whereIn('submitted_by', $agentIds);

            // Get phones from team's CSR submissions today
            $teamPhones = (clone $csrQuery)->pluck('phone');
            
            $verificationQuery->where(function($q) use ($agentIds, $teamPhones) {
                $q->whereIn('submitted_by', $agentIds)
                  ->orWhereIn('phone', $teamPhones);
            });
            
        } else {
            // Agents can only see their own submissions
            $csrQuery->where('submitted_by', $user->id);
            $verificationQuery->where('submitted_by', $user->id);
        }
        
        // Execute queries and set type
        $csr = $csrQuery->get()->map(function ($item) {
            $item->submission_type = 'csr';
            return $item;
        });
        
        $verification = $verificationQuery->get()->map(function ($item) {
            $item->submission_type = 'verification';
            return $item;
        });
        
        // Merge collections and sort by created_at
        $allSubmissions = $csr->concat($verification)
            ->sortByDesc('created_at')
            ->values();


        return $allSubmissions;
    }

    /**
     * Get submission statistics
     */
    private function getSubmissionStats($user, $selectedDate)
    {
        $csrQuery = (new Submission)->setTable('csr_submissions')->whereDate('created_at', $selectedDate);
        $verificationQuery = (new Submission)->setTable('verification_submissions')->whereDate('created_at', $selectedDate);

        if ($user->isAdmin()) {
            // Admin can see all stats
        } elseif ($user->isFloorManager()) {
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');
            
            $agentIds = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->pluck('id');
            
            $allIds = $teamLeadIds->merge($agentIds);
            $csrQuery->whereIn('submitted_by', $allIds);
            $verificationQuery->whereIn('submitted_by', $allIds);
        } elseif ($user->isTeamLead()) {
            $agentIds = User::where('team_lead_id', $user->id)
                ->where('user_type', 'agent')
                ->pluck('id');
            $csrQuery->whereIn('submitted_by', $agentIds);
            $verificationQuery->whereIn('submitted_by', $agentIds);
        } else {
            $csrQuery->where('submitted_by', $user->id);
            $verificationQuery->where('submitted_by', $user->id);
        }

        $csrCount = $csrQuery->count();
        $verificationCount = $verificationQuery->count();

        return [
            'total' => $csrCount + $verificationCount,
            'csr' => $csrCount,
            'verification' => $verificationCount,
            'date' => $selectedDate,
        ];
    }

    /**
     * Mask phone number for non-admin users
     */
    private function maskPhoneNumber($phoneNumber, $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }
        
        // Only admins can see full phone numbers
        if ($user->isAdmin()) {
            return $phoneNumber;
        }
        
        // For other users, show only last 5 digits with asterisks
        if (strlen($phoneNumber) > 5) {
            $maskedLength = strlen($phoneNumber) - 5;
            return str_repeat('*', $maskedLength) . substr($phoneNumber, -5);
        }
        
        return $phoneNumber;
    }

    /**
     * Get available campaigns from database
     */
    private function getCampaigns()
    {
        return Campaign::where('status', 'active')
                      ->orderBy('name')
                      ->pluck('name')
                      ->toArray();
    }

    /**
     * Check if user can view submission
     */
    private function canViewSubmission($submission)
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return true;
        } elseif ($user->isFloorManager()) {
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');
            
            $agentIds = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->pluck('id');
            
            $allIds = $teamLeadIds->merge($agentIds);
            return $allIds->contains($submission->submitted_by);
        } elseif ($user->isTeamLead()) {
            $agentIds = User::where('team_lead_id', $user->id)
                ->where('user_type', 'agent')
                ->pluck('id');
            return $agentIds->contains($submission->submitted_by);
        } else {
            return $submission->submitted_by === $user->id;
        }
    }

    /**
     * Check if user can edit submission
     */
    private function canEditSubmission($submission)
    {
        $user = Auth::user();
        
        // Only admins can edit submissions
        return $user->isAdmin();
    }

    /**
     * Check if user can delete submission
     */
    private function canDeleteSubmission($submission)
    {
        $user = Auth::user();
        
        // Only admins can delete submissions
        return $user->isAdmin();
    }

    /**
     * Get filtered agents based on user type
     */
    private function getFilteredAgents($user, $designation = null)
    {
        $query = User::where('user_type', 'agent')
            ->where('status', 'active');

        if ($designation) {
            $query->where('designation', $designation);
        }

        if ($user->isAdmin()) {
            // Admin can see all agents
            return $query->orderBy('name')->get();
        } elseif ($user->isFloorManager()) {
            // Floor manager can see agents from their team leads
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');
            
            return $query->whereIn('team_lead_id', $teamLeadIds)
                ->orderBy('name')
                ->get();
        } elseif ($user->isTeamLead()) {
            // Team lead can see their agents
            return $query->where('team_lead_id', $user->id)
                ->orderBy('name')
                ->get();
        } else {
            // Agent can only see themselves
            if ($designation && $user->designation !== $designation) {
                return collect();
            }
            return collect([$user]);
        }
    }

    /**
     * Get report data for the matrix view
     */
    private function getReportData($user, $startDate, $endDate, $agents, $designation = null)
    {
        $reportData = [];
        $dates = $this->generateDateRange($startDate, $endDate);
        
        foreach ($agents as $agent) {
            $agentData = [
                'agent' => $agent,
                'submissions' => []
            ];
            
            foreach ($dates as $date) {
                $totalCount = 0;

                if (!$designation || $designation === 'CSR') {
                    $totalCount += (new Submission)->setTable('csr_submissions')
                        ->where('submitted_by', $agent->id)
                        ->whereDate('created_at', $date)
                        ->count();
                }

                if (!$designation || $designation === 'Verification Officer') {
                    $totalCount += (new Submission)->setTable('verification_submissions')
                        ->where('submitted_by', $agent->id)
                        ->whereDate('created_at', $date)
                        ->count();
                }
                
                $agentData['submissions'][$date] = $totalCount;
            }
            
            $reportData[] = $agentData;
        }
        
        return $reportData;
    }

    /**
     * Generate date range array
     */
    private function generateDateRange($startDate, $endDate)
    {
        $dates = [];
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        while ($current->lte($end)) {
            $dates[] = $current->format('Y-m-d');
            $current->addDay();
        }
        
        return $dates;
    }

    /**
     * Find submission from any of the three tables
     */
    private function findSubmission($id)
    {
        return Submission::findInAnyTable($id);
    }

    /**
     * Find submission by ID and type
     */
    private function findSubmissionByType($id, $type)
    {
        $table = $type === 'verification' ? 'verification_submissions' : 'csr_submissions';
        $submission = (new Submission)->setTable($table)->find($id);
        
        if ($submission) {
            $submission->submission_type = $type;
        }
        
        return $submission;
    }

    /**
     * Clean phone number by removing all non-numeric characters
     */
    private function cleanPhoneNumber($phone)
    {
        // Remove all non-numeric characters (spaces, dashes, parentheses, dots, etc.)
        return preg_replace('/[^0-9]/', '', $phone);
    }
}
