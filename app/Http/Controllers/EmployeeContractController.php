<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeContractController extends Controller
{
    public function index()
    {
        // Fetch all employees (excluding admin if needed)
        $employees = User::whereIn('user_type', ['agent', 'team_lead', 'floor_manager', 'management'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employee_contracts.index', compact('employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'nullable|date',
            'left_date' => 'nullable|date|after_or_equal:appointment_date',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        try {
            $employee = User::findOrFail($id);
            
            $employee->appointment_date = $request->appointment_date;
            $employee->left_date = $request->left_date;
            $employee->status = $request->status;
            $employee->save();

            return response()->json([
                'success' => true,
                'message' => 'Employee contract updated successfully',
                'data' => [
                    'appointment_date' => $employee->appointment_date ? Carbon::parse($employee->appointment_date)->format('d/m/Y') : '-',
                    'left_date' => $employee->left_date ? Carbon::parse($employee->left_date)->format('d/m/Y') : '-',
                    'status' => $employee->status,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating contract: ' . $e->getMessage()], 500);
        }
    }
}
