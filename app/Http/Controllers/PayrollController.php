<?php

namespace App\Http\Controllers;

use App\Services\PayrollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    protected $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    /**
     * Display a listing of payroll calculations
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Agents / management only see their own payroll
        if ($user->isAgent() || $user->isManagement()) {
            return redirect()->route('payroll.show', $user->employee_id);
        }
        
        $lastMonth = $request->get('last_month', false);
        $teamLeadId = null;

        // If user is a team lead, only show their team members
        if ($user->isTeamLead()) {
            $teamLeadId = $user->id;
        }

        $payrolls = $this->payrollService->calculateSalaries(null, $lastMonth, $teamLeadId);

        return view('payroll.index', compact('payrolls', 'lastMonth'));
    }

    /**
     * Display payroll details for a specific employee
     */
    public function show(Request $request, $employeeId)
    {
        $user = Auth::user();
        
        // Agents / management should see last month by default unless explicitly requesting current month
        if (($user->isAgent() || $user->isManagement()) && !$request->has('last_month')) {
            $lastMonth = true;
        } else {
            $lastMonth = $request->get('last_month', false);
        }
        
        // Get the employee by employee_id
        $employee = \App\Models\User::where('employee_id', $employeeId)->first();
        
        if (!$employee) {
            if ($user->isAgent() || $user->isManagement()) {
                return view('payroll.show', [
                    'payroll' => null,
                    'lastMonth' => $lastMonth,
                    'error' => 'Employee not found.'
                ]);
            }
            return redirect()->route('payroll.index')->with('error', 'Employee not found.');
        }
        
        // Agents / management may only view their own payroll
        if (($user->isAgent() || $user->isManagement()) && $user->id != $employee->id) {
            abort(403, 'Unauthorized access.');
        }
        
        // Always generate payroll data using the user's database ID
        $payrolls = $this->payrollService->calculateSalaries($employee->id, $lastMonth);
        
        // If still empty, create a basic payroll structure with 0s
        if (empty($payrolls)) {
            // Create a basic payroll structure with 0s
            $payroll = [
                'employee_id' => $employee->id,
                'employee_code' => $employee->employee_id,
                'name' => $employee->name,
                'user_type' => $employee->user_type,
                'department' => $employee->department->name ?? 'N/A',
                'basic_salary' => $employee->salary ?? 0,
                'punctuality' => 0,
                'presents' => 0,
                'absent_count' => 0,
                'ncns_count' => 0,
                'half_days' => 0,
                'unpaid_count' => 0,
                'holiday_count' => 0,
                'total_working_days' => date('t'), // Days in current month
                'late_count' => 0,
                'late_deduction' => 0,
                'dock' => 0,
                'bonus' => 0,
                'ref_bonus' => 0,
                'training_bonus' => 0,
                'saturday_bonus' => 0,
                'final_salary' => 0,
                'period' => $lastMonth ? date('F Y', strtotime('-1 month')) : date('F Y'),
            ];
        } else {
            $payroll = $payrolls[0];
        }

        return view('payroll.show', compact('payroll', 'lastMonth'));
    }

    /**
     * Display payroll management page
     */
    public function management()
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $employees = \App\Models\User::where('user_type', 'agent')
            ->orWhere('user_type', 'team_lead')
            ->orWhere('user_type', 'floor_manager')
            ->orderBy('name')
            ->get();

        return view('payroll.management', compact('employees'));
    }

    /**
     * Store payroll management data
     */
    public function storeManagement(Request $request)
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'dock_value' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'ref_bonus' => 'nullable|numeric|min:0',
            'plan' => 'nullable|numeric|min:0',
            'advance' => 'nullable|numeric|min:0',
            'month' => 'required|string',
        ]);

        // Store the payroll management data
        \App\Models\PayrollManagement::updateOrCreate(
            [
                'employee_id' => $request->employee_id,
                'month' => $request->month,
            ],
            [
                'dock_value' => $request->dock_value ?? 0,
                'bonus' => $request->bonus ?? 0,
                'ref_bonus' => $request->ref_bonus ?? 0,
                'plan' => $request->plan ?? 0,
                'advance' => $request->advance ?? 0,
            ]
        );

        return redirect()->route('payroll.management')->with('success', 'Payroll data updated successfully.');
    }

    /**
     * Edit payroll management entry
     */
    public function editManagement($id)
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $payrollManagement = \App\Models\PayrollManagement::with('employee')->findOrFail($id);
        $employees = \App\Models\User::where('user_type', 'agent')
            ->orWhere('user_type', 'team_lead')
            ->orWhere('user_type', 'floor_manager')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $payrollManagement->id,
                'employee_id' => $payrollManagement->employee_id,
                'employee_name' => $payrollManagement->employee->name,
                'employee_id_code' => $payrollManagement->employee->employee_id,
                'dock_value' => $payrollManagement->dock_value,
                'bonus' => $payrollManagement->bonus,
                'ref_bonus' => $payrollManagement->ref_bonus,
                'plan' => $payrollManagement->plan,
                'advance' => $payrollManagement->advance,
                'month' => $payrollManagement->month,
            ]
        ]);
    }

    /**
     * Update payroll management entry
     */
    public function updateManagement(Request $request, $id)
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'dock_value' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'ref_bonus' => 'nullable|numeric|min:0',
            'plan' => 'nullable|numeric|min:0',
            'advance' => 'nullable|numeric|min:0',
            'month' => 'required|string',
        ]);

        $payrollManagement = \App\Models\PayrollManagement::findOrFail($id);
        
        $payrollManagement->update([
            'employee_id' => $request->employee_id,
            'dock_value' => $request->dock_value ?? 0,
            'bonus' => $request->bonus ?? 0,
            'ref_bonus' => $request->ref_bonus ?? 0,
            'plan' => $request->plan ?? 0,
            'advance' => $request->advance ?? 0,
            'month' => $request->month,
        ]);

        return redirect()->route('payroll.management')->with('success', 'Payroll entry updated successfully.');
    }

    /**
     * Delete payroll management entry
     */
    public function destroyManagement($id)
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $payrollManagement = \App\Models\PayrollManagement::findOrFail($id);
        $payrollManagement->delete();

        return redirect()->route('payroll.management')->with('success', 'Payroll entry deleted successfully.');
    }

    /**
     * Export payroll data
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isAgent() || $user->isManagement()) {
            abort(403, 'Unauthorized access.');
        }
        
        $lastMonth = $request->get('last_month', false);
        $teamLeadId = null;

        if ($user->isTeamLead()) {
            $teamLeadId = $user->id;
        }

        $payrolls = $this->payrollService->calculateSalaries(null, $lastMonth, $teamLeadId);
        $selectedColumns = $request->get('export_columns', ['bonus', 'dec_salary', 'training_bonus', 'dock', 'late_count']);

        return $this->generateCsvResponse($payrolls, $lastMonth, $selectedColumns, 'payroll');
    }

    /**
     * Export payroll data based on custom list of employee IDs
     */
    public function customExport(Request $request)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isFloorManager()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'employee_ids' => 'required|string',
            'last_month' => 'nullable|boolean'
        ]);

        $lastMonth = $request->boolean('last_month');
        // If it's a POST and export_columns is missing, it means none were selected
        $selectedColumns = $request->input('export_columns', []);
        if (!$request->has('export_columns') && !$request->isMethod('post')) {
            $selectedColumns = ['bonus', 'dec_salary', 'training_bonus', 'dock', 'late_count'];
        }
        
        $rawIds = preg_split('/[\r\n,]+/', $request->employee_ids, -1, PREG_SPLIT_NO_EMPTY);
        $targetIds = array_map('trim', $rawIds);
        $targetIds = array_unique(array_filter($targetIds));

        if (empty($targetIds)) {
            return back()->with('error', 'No valid Employee IDs provided.');
        }

        $allPayrolls = $this->payrollService->calculateSalaries(null, $lastMonth);

        $payrollMap = [];
        foreach ($allPayrolls as $p) {
            $payrollMap[strtoupper(trim($p['employee_code']))] = $p;
        }

        $sortedPayrolls = [];
        foreach ($targetIds as $code) {
            $upperCode = strtoupper($code);
            if (isset($payrollMap[$upperCode])) {
                $sortedPayrolls[] = $payrollMap[$upperCode];
            }
        }

        if (empty($sortedPayrolls)) {
            return back()->with('error', 'No matching employees found for the provided IDs.');
        }

        return $this->generateCsvResponse($sortedPayrolls, $lastMonth, $selectedColumns, 'payroll_custom');
    }

    /**
     * Helper to generate CSV response
     */
    private function generateCsvResponse($payrolls, $lastMonth, $selectedColumns, $prefix)
    {
        $handle = fopen('php://temp', 'r+');
        
        $header = ['Employee ID', 'Name', 'Working Days', 'Total Salary'];
        if (in_array('bonus', $selectedColumns)) $header[] = 'Bonus';
        if (in_array('dec_salary', $selectedColumns)) $header[] = 'Dec Salary';
        if (in_array('training_bonus', $selectedColumns)) $header[] = 'Training Bonus';
        if (in_array('dock', $selectedColumns)) $header[] = 'Dock';
        if (in_array('late_count', $selectedColumns)) $header[] = 'Late Count';
        $header = array_merge($header, ['Presents', 'Absent', 'Unpaids', 'NCNS', 'Half Days', 'Final Salary']);

        fputcsv($handle, $header);
        
        foreach ($payrolls as $payroll) {
            // Recalculate Final Salary based on selected columns
            // We start from the full final_salary and adjust what's not selected
            $adjustedFinalSalary = $payroll['final_salary'];
            
            // If "Bonus" is NOT selected, subtract it
            if (!in_array('bonus', $selectedColumns)) {
                $adjustedFinalSalary -= $payroll['bonus'];
            }
            
            // If "Dec Salary" (Arrears) is NOT selected, subtract it
            if (!in_array('dec_salary', $selectedColumns)) {
                $adjustedFinalSalary -= $payroll['arrears_amount'];
            }
            
            // If "Training Bonus" is NOT selected, subtract it
            if (!in_array('training_bonus', $selectedColumns)) {
                $adjustedFinalSalary -= $payroll['training_bonus'];
            }
            
            // If "Dock" is NOT selected, add it back (since it was subtracted)
            if (!in_array('dock', $selectedColumns)) {
                $adjustedFinalSalary += $payroll['dock'];
            }
            
            // If "Late Count" is NOT selected, add back the late_deduction
            if (!in_array('late_count', $selectedColumns)) {
                $adjustedFinalSalary += $payroll['late_deduction'];
            }
            
            // Round and ensure non-negative
            $adjustedFinalSalary = max(0, $this->applyRounding($adjustedFinalSalary));

            $row = [
                $payroll['employee_code'],
                $payroll['name'],
                $payroll['total_working_days'],
                round($payroll['basic_salary'] + $payroll['punctuality'])
            ];

            if (in_array('bonus', $selectedColumns)) $row[] = round($payroll['bonus']);
            if (in_array('dec_salary', $selectedColumns)) $row[] = round($payroll['arrears_amount'] ?? 0);
            if (in_array('training_bonus', $selectedColumns)) $row[] = round($payroll['training_bonus']);
            if (in_array('dock', $selectedColumns)) $row[] = round($payroll['dock']);
            if (in_array('late_count', $selectedColumns)) $row[] = $payroll['late_count'];

            $row = array_merge($row, [
                $payroll['presents'],
                $payroll['absent_count'],
                $payroll['unpaid_count'],
                $payroll['ncns_count'],
                $payroll['half_days'],
                round($adjustedFinalSalary)
            ]);

            fputcsv($handle, $row);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        $filename = $prefix . '_' . ($lastMonth ? 'last_month' : 'current') . '_' . date('Y-m-d_H-i-s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Round salary to nearest 500 or 1000 (matching service logic)
     */
    private function applyRounding($salary)
    {
        $salary = (int)$salary;
        $lastThreeDigits = $salary % 1000;
        $base = floor($salary / 1000) * 1000;

        if ($lastThreeDigits <= 249) {
            return $base;
        } elseif ($lastThreeDigits <= 499) {
            return $base + 500;
        } elseif ($lastThreeDigits <= 749) {
            return $base + 500;
        } else {
            return $base + 1000;
        }
    }

    /**
     * Show bulk management form
     */
    public function bulkManagement()
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        return view('payroll.bulk-management');
    }

    /**
     * Store bulk management data
     */
    public function storeBulkManagement(Request $request)
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'bulk_data' => 'required|string',
            'type' => 'required|in:bonus,dock_value,ref_bonus,advance,plan',
            'month' => 'required|string',
        ]);

        $lines = explode("\n", $request->bulk_data);
        $successCount = 0;
        $failCount = 0;
        $processedIds = []; // Track processed IDs

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Split by whitespace
            $parts = preg_split('/\s+/', $line, 2); // Limit to 2 parts (ID + Amount)
            if (count($parts) < 2) {
                // Try splitting by tab just in case
                $parts = explode("\t", $line);
                if (count($parts) < 2) {
                     $failCount++;
                     continue;
                }
            }

            $employeeCode = trim($parts[0]);
            // Remove any commas and non-numeric chars except dot
            $amountStr = preg_replace('/[^0-9.]/', '', $parts[1]);
            $amount = floatval($amountStr);

            $user = \App\Models\User::where('employee_id', $employeeCode)->first();
            if (!$user) {
                $failCount++;
                continue;
            }

            // Find existing or create new
            $payroll = \App\Models\PayrollManagement::firstOrNew([
                'employee_id' => $user->id,
                'month' => $request->month
            ]);

            // Set the specific field
            $payroll->{$request->type} = $amount;
            
            // Ensure other fields are set to defaults if new, but firstOrNew handles checking existence.
            // If it's new, the other attributes are null. In DB they might have defaults.
            // Eloquent won't autoset defaults on 'new' instance unless defined in $attributes property or DB.
            // Let's ensure integer fields are 0 if null.
            if (!$payroll->exists) {
                $defaults = ['dock_value', 'bonus', 'ref_bonus', 'plan', 'advance'];
                foreach ($defaults as $field) {
                    if ($field !== $request->type && $payroll->$field === null) {
                        $payroll->$field = 0;
                    }
                }
            }

            $payroll->save();
            $successCount++;
            $processedIds[] = $employeeCode;
        }

        return redirect()->route('payroll.management')->with('success', "Processed bulk upload: $successCount updated, $failCount failed.");
    }
}