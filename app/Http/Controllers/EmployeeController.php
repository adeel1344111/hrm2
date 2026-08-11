<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Designation;
use App\Models\Department;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = $this->getFilteredEmployees();
        
        $stats = $this->getFilteredStats();
        
        return view('employees.index', compact('employees', 'stats'));
    }

    public function create()
    {
        // Only admin and floor managers can create employees
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isFloorManager()) {
            abort(403, 'You do not have permission to create employees.');
        }
        
        $floorManagers = User::floorManagerRole()->where('status', 'active')->orderBy('name')->get();
        $teamLeads = User::teamLeadRole()->where('status', 'active')->orderBy('name')->get();
        $designations = Designation::where('status', 'active')->orderBy('name')->get();
        $departments = Department::where('status', 'active')->orderBy('name')->get();
        
        return view('employees.create', compact('floorManagers', 'teamLeads', 'designations', 'departments'));
    }

    public function getNextEmployeeId()
    {
        // Get the last employee ID from the database
        $lastEmployee = User::whereNotNull('employee_id')
            ->where('employee_id', 'LIKE', 'MK%')
            ->orderByRaw('CAST(SUBSTRING(employee_id, 3) AS UNSIGNED) DESC')
            ->first();

        if ($lastEmployee && preg_match('/^MK(\d+)$/', $lastEmployee->employee_id, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = 1; // Start from MK1 if no employees exist
        }

        return response()->json(['next_id' => 'MK' . $nextNumber]);
    }

    public function store(Request $request)
    {
        // Only admin and floor managers can create employees
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isFloorManager()) {
            abort(403, 'You do not have permission to create employees.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'required|string|unique:users,employee_id',
            'contact_number' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'cnic' => 'nullable|string|max:20',
            'referred_by' => 'nullable|string|max:255',
            'user_type' => 'required|in:agent,team_lead,floor_manager,admin,management',
            'department' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'appointment_date' => 'nullable|date',
            'left_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'floor_manager_id' => 'nullable|exists:users,id',
            'team_lead_id' => 'nullable|exists:users,id',
            'basic_salary' => 'nullable|numeric|min:0',
            'punctuality' => 'nullable|numeric|min:0',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create employee
        $employeeData = $request->except(['basic_salary', 'punctuality', 'password_confirmation', 'profile_picture']);
        
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = 'profile-pictures/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('assets/images/profile-pictures');
            if (!file_exists($destinationPath)) {
                @mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, basename($filename));
            $employeeData['profile_picture'] = $filename;
        }
        

        
        if ($request->filled('password')) {
            $employeeData['password'] = $request->password;
        }

        $employee = User::create($employeeData);

        // Handle salary information
        if ($request->has('basic_salary') || $request->has('punctuality')) {
            $this->createEmployeeSalary($employee, $request);
        }

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(User $employee)
    {
        // Check if user has permission to view this employee
        if (!$this->canViewEmployee($employee)) {
            abort(403, 'You do not have permission to view this employee.');
        }
        
        // Load the current salary relationship
        $employee->load('currentSalary');
        
        return view('employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        // Check if user has permission to edit this employee
        if (!$this->canEditEmployee($employee)) {
            abort(403, 'You do not have permission to edit this employee.');
        }
        
        // Load the current salary relationship
        $employee->load('currentSalary');
        
        $floorManagers = User::floorManagerRole()->where('status', 'active')->orderBy('name')->get();
        $teamLeads = User::teamLeadRole()->where('status', 'active')->orderBy('name')->get();
        $designations = Designation::where('status', 'active')->orderBy('name')->get();
        $departments = Department::where('status', 'active')->orderBy('name')->get();
        
        return view('employees.edit', compact('employee', 'floorManagers', 'teamLeads', 'designations', 'departments'));
    }

    public function update(Request $request, User $employee)
    {
        // Check if user has permission to edit this employee
        if (!$this->canEditEmployee($employee)) {
            abort(403, 'You do not have permission to edit this employee.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
// Email is immutable and not in form
            // 'email' => 'required|email|unique:users,email,' . $employee->id,
            'employee_id' => 'required|string|unique:users,employee_id,' . $employee->id,

            'contact_number' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'cnic' => 'nullable|string|max:20',
            'referred_by' => 'nullable|string|max:255',
            'user_type' => 'required|in:agent,team_lead,floor_manager,admin,management',
            'department' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'appointment_date' => 'nullable|date',
            'left_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'floor_manager_id' => 'nullable|exists:users,id',
            'team_lead_id' => 'nullable|exists:users,id',
            'basic_salary' => 'nullable|numeric|min:0',
            'punctuality' => 'nullable|numeric|min:0',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update employee information
        $employeeData = $request->except(['basic_salary', 'punctuality', 'password', 'password_confirmation', 'profile_picture']);
        
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($employee->profile_picture && file_exists(public_path('assets/images/' . $employee->profile_picture))) {
                @unlink(public_path('assets/images/' . $employee->profile_picture));
            }
            
            // Store new profile picture
            $image = $request->file('profile_picture');
            $filename = 'profile-pictures/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('assets/images/profile-pictures');
            if (!file_exists($destinationPath)) {
                @mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, basename($filename));
            $employeeData['profile_picture'] = $filename;
        }
        
        // Handle password update if provided
        if ($request->filled('password')) {
            $employeeData['password'] = $request->password;
        }
        
        $employee->update($employeeData);

        // Handle salary information
        if ($request->has('basic_salary') || $request->has('punctuality')) {
            $this->updateEmployeeSalary($employee, $request);
        }

        // Prepare success message
        $message = 'Employee updated successfully.';
        if ($request->filled('password')) {
            $message .= ' Password has been changed.';
        }

        return redirect()->route('employees.index')->with('success', $message);
    }

    public function destroy(User $employee)
    {
        // Only admin can delete employees
        $user = auth()->user();
        if (!$user->isAdmin()) {
            abort(403, 'You do not have permission to delete employees.');
        }
        
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function active()
    {
        $employees = $this->getFilteredEmployees('active');
        
        $stats = $this->getFilteredStats('active');
        
        return view('employees.active', compact('employees', 'stats'));
    }

    public function inactive()
    {
        $employees = $this->getFilteredEmployees('inactive');
        
        $stats = $this->getFilteredStats('inactive');
        
        return view('employees.inactive', compact('employees', 'stats'));
    }

    public function all()
    {
        $employees = $this->getFilteredEmployees();
        
        $stats = $this->getFilteredStats();
        
        return view('employees.all', compact('employees', 'stats'));
    }

    public function toggleStatus(Request $request, User $employee)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $employee->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Employee status updated successfully.']);
    }

    public function export()
    {
        // Placeholder for export logic
        return response()->json(['success' => true, 'message' => 'Export functionality not yet implemented.']);
    }

    /**
     * Get filtered employees based on user role
     */
    private function getFilteredEmployees($status = null)
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin can see all employees
            $query = User::with('currentSalary')->orderBy('name');
            if ($status) {
                $query->where('status', $status);
            }
            return $query->get();
        } elseif ($user->isFloorManager()) {
            // Floor manager can see team leads and agents under those team leads
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');
            
            $agentIds = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->pluck('id');
            
            $allIds = $teamLeadIds->merge($agentIds);
            
            $query = User::with('currentSalary')->whereIn('id', $allIds)->orderBy('name');
            if ($status) {
                $query->where('status', $status);
            }
            return $query->get();
        } elseif ($user->isTeamLead()) {
            // Team lead can only see agents under them
            $query = User::with('currentSalary')->where('team_lead_id', $user->id)
                ->where('user_type', 'agent')
                ->orderBy('name');
            if ($status) {
                $query->where('status', $status);
            }
            return $query->get();
        } else {
            // Agent can only see themselves
            $query = User::with('currentSalary')->where('id', $user->id)->orderBy('name');
            if ($status) {
                $query->where('status', $status);
            }
            return $query->get();
        }
    }

    /**
     * Get filtered stats based on user role
     */
    private function getFilteredStats($status = null)
    {
        $user = auth()->user();
        $baseQuery = $this->getBaseQueryForRole($user);
        
        if ($status) {
            $baseQuery = $baseQuery->where('status', $status);
        }
        
        $total = (clone $baseQuery)->count();
        $active = (clone $baseQuery)->where('status', 'active')->count();
        $inactive = (clone $baseQuery)->where('status', 'inactive')->count();
        $agents = (clone $baseQuery)->where('user_type', 'agent')->count();
        $teamLeads = (clone $baseQuery)->where(function ($q) {
            $q->where('user_type', 'team_lead')
                ->orWhere(function ($q2) {
                    $q2->where('user_type', 'management')->where('designation', 'Team Lead');
                });
        })->count();
        $floorManagers = (clone $baseQuery)->where(function ($q) {
            $q->where('user_type', 'floor_manager')
                ->orWhere(function ($q2) {
                    $q2->where('user_type', 'management')->where('designation', 'Floor Manager');
                });
        })->count();
        $management = (clone $baseQuery)->where('user_type', 'management')->count();

        $activeCsr = (clone $baseQuery)->where('status', 'active')->where('designation', 'CSR')->count();
        $activeVerifiers = (clone $baseQuery)->where('status', 'active')->where('designation', 'Verification Officer')->count();
        $inactiveCsr = (clone $baseQuery)->where('status', 'inactive')->where('designation', 'CSR')->count();
        $inactiveVerifiers = (clone $baseQuery)->where('status', 'inactive')->where('designation', 'Verification Officer')->count();
        
        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'agents' => $agents,
            'team_leads' => $teamLeads,
            'floor_managers' => $floorManagers,
            'management' => $management,
            'active_csr' => $activeCsr,
            'active_verifiers' => $activeVerifiers,
            'inactive_csr' => $inactiveCsr,
            'inactive_verifiers' => $inactiveVerifiers,
        ];
    }

    /**
     * Get base query for user role
     */
    private function getBaseQueryForRole($user)
    {
        if ($user->isAdmin()) {
            return User::query();
        } elseif ($user->isFloorManager()) {
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');
            
            $agentIds = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->pluck('id');
            
            $allIds = $teamLeadIds->merge($agentIds);
            
            return User::whereIn('id', $allIds);
        } elseif ($user->isTeamLead()) {
            return User::where('team_lead_id', $user->id)
                ->where('user_type', 'agent');
        } else {
            return User::where('id', $user->id);
        }
    }

    /**
     * Check if user can view specific employee
     */
    private function canViewEmployee($employee)
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return true; // Admin can view all employees
        } elseif ($user->isFloorManager()) {
            // Floor manager can view team leads under them and agents under those team leads
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');
            
            $agentIds = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->pluck('id');
            
            $allIds = $teamLeadIds->merge($agentIds);
            
            return $allIds->contains($employee->id);
        } elseif ($user->isTeamLead()) {
            // Team lead can only view agents under them
            return $employee->team_lead_id === $user->id && $employee->user_type === 'agent';
        } else {
            // Agent can only view themselves
            return $employee->id === $user->id;
        }
    }

    /**
     * Check if user can edit specific employee
     */
    private function canEditEmployee($employee)
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return true; // Admin can edit all employees
        } elseif ($user->isFloorManager()) {
            // Floor manager can edit team leads under them and agents under those team leads
            $teamLeadIds = User::where('floor_manager_id', $user->id)
                ->teamLeadRole()
                ->pluck('id');
            
            $agentIds = User::whereIn('team_lead_id', $teamLeadIds)
                ->where('user_type', 'agent')
                ->pluck('id');
            
            $allIds = $teamLeadIds->merge($agentIds);
            
            return $allIds->contains($employee->id);
        } elseif ($user->isTeamLead()) {
            // Team lead can only edit agents under them
            return $employee->team_lead_id === $user->id && $employee->user_type === 'agent';
        } else {
            // Agent can only edit themselves
            return $employee->id === $user->id;
        }
    }

    /**
     * Create employee salary information
     */
    private function createEmployeeSalary($employee, $request)
    {
        $basicSalary = $request->input('basic_salary');
        $punctuality = $request->input('punctuality');

        // Create salary record
        \App\Models\Salary::create([
            'employee_id' => $employee->id,
            'basic_salary' => $basicSalary ?? 0,
            'punctuality' => $punctuality ?? 0,
            'effective_date' => $employee->appointment_date ?? $employee->join_date ?? now(),
            'status' => 'active',
            'notes' => 'Initial salary upon employee creation',
        ]);
    }

    /**
     * Update employee salary information
     */
    private function updateEmployeeSalary($employee, $request)
    {
        $basicSalary = $request->input('basic_salary');
        $punctuality = $request->input('punctuality');

        // If both values are provided, update or create salary record
        if ($basicSalary !== null || $punctuality !== null) {
            $currentSalary = $employee->currentSalary;
            
            if ($currentSalary) {
                // Update existing salary record
                $currentSalary->update([
                    'basic_salary' => $basicSalary ?? $currentSalary->basic_salary,
                    'punctuality' => $punctuality ?? $currentSalary->punctuality,
                ]);
            } else {
                // Create new salary record
                \App\Models\Salary::create([
                    'employee_id' => $employee->id,
                    'basic_salary' => $basicSalary ?? 0,
                    'punctuality' => $punctuality ?? 0,
                    'effective_date' => now(),
                    'status' => 'active',
                    'notes' => 'Salary updated via employee edit',
                ]);
            }
        }
    }
}
