<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryInfoController extends Controller
{
    public function index()
    {
        // Fetch all users with their current active salary
        $users = User::whereIn('user_type', ['agent', 'team_lead', 'floor_manager', 'management']) // Filter relevant roles
            ->with(['salaries' => function($query) {
                // We want all salaries to determine 'last salary'
                $query->orderBy('effective_date', 'desc');
            }])
            ->get()
            ->map(function ($user) {
                $activeSalary = $user->salaries->where('status', 'active')->first();
                // If no active, try the most recent one
                if (!$activeSalary) {
                    $activeSalary = $user->salaries->first();
                }

                // Determine previous/last salary
                // If active matches first, then last is second.
                $lastSalary = null;
                $lastTotalSalary = null;
                if ($user->salaries->count() > 1) {
                    $lastSalary = $user->salaries->values()->get(1); // Get the second item
                    $lastTotalSalary = ($lastSalary->basic_salary ?? 0) + ($lastSalary->punctuality ?? 0);
                }

                $user->current_salary = $activeSalary;
                $user->last_salary_record = $lastSalary;
                $user->last_total_salary = $lastTotalSalary;
                
                return $user;
            });

        return view('salary_info.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'basic_salary' => 'required|numeric|min:0',
            'punctuality' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $salary = Salary::where('employee_id', $id)->where('status', 'active')->first();

            if (!$salary) {
                // Create new if strictly active not found, or maybe just update latest? 
                // Let's assume we create a new active record if none exists
                $salary = new Salary();
                $salary->employee_id = $id;
                $salary->status = 'active';
                $salary->effective_date = now();
            } else {
                // Check if values actually changed to create history?
                // User asked to "update without refresh", implying simple edit. 
                // For a proper system, we might want versioning, but for now let's just update the record
                // to match the "Action" button simplificity.
            }

            $currentBasic = $salary->basic_salary;
            
            // If basic salary changed significantly, we might want to archive old and create new
            // But for simple "Edit", let's update in place for now unless instructed otherwise.
            // Wait, "Last Salary" column implies history. 
            // If I just update, "Last Salary" won't change or exist. 
            // Let's implement a Logic: If Basic Salary changes, Archive old as inactive, Create new active.
            
            if ($salary->exists && $currentBasic != $request->basic_salary) {
                 // Archive current
                 $salary->status = 'inactive';
                 $salary->end_date = now();
                 $salary->save();
                 
                 // Create new
                 $newSalary = new Salary();
                 $newSalary->employee_id = $id;
                 $newSalary->basic_salary = $request->basic_salary;
                 $newSalary->punctuality = $request->punctuality;
                 $newSalary->status = 'active';
                 $newSalary->effective_date = now();
                 $newSalary->save();
            } else {
                // Just update fields if just punctuality or if new record
                $salary->basic_salary = $request->basic_salary;
                $salary->punctuality = $request->punctuality;
                $salary->save();
            }

            DB::commit();

            // Fetch updated last salary for response
            $user = User::with(['salaries' => function($query) {
                $query->orderBy('effective_date', 'desc');
            }])->find($id);
            
            $lastTotalSalary = null;
            if ($user && $user->salaries->count() > 1) {
                $lastSalary = $user->salaries->values()->get(1);
                $lastTotalSalary = ($lastSalary->basic_salary ?? 0) + ($lastSalary->punctuality ?? 0);
            }

            return response()->json([
                'success' => true, 
                'message' => 'Salary updated successfully',
                'data' => [
                    'basic_salary' => number_format($request->basic_salary),
                    'punctuality' => number_format($request->punctuality),
                    'last_salary' => $lastTotalSalary ? number_format($lastTotalSalary) : '-',
                    'last_updated' => now()->diffForHumans()
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error updating salary: ' . $e->getMessage()], 500);
        }
    }

    public function bulkTempSalary(Request $request)
    {
        $request->validate([
            'employee_ids' => 'required|string',
            'temp_salary' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Parse employee IDs (split by newline, comma, or spaces)
            $ids = preg_split('/[\r\n,]+/', $request->employee_ids, -1, PREG_SPLIT_NO_EMPTY);
            $ids = array_filter(array_map('trim', $ids));

            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'No valid employee IDs provided.'], 400);
            }

            // Find users by their custom employee_id field
            $users = User::whereIn('employee_id', $ids)->get();

            if ($users->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No employees found with the provided IDs.'], 404);
            }

            $userIds = $users->pluck('id')->toArray();

            // Update active salaries for these users
            $tempSalaryValue = $request->filled('temp_salary') ? $request->temp_salary : null;

            Salary::whereIn('employee_id', $userIds)
                ->where('status', 'active')
                ->update(['temp_salary' => $tempSalaryValue]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Temporary salaries updated successfully.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error updating temporary salaries: ' . $e->getMessage()], 500);
        }
    }
}
