<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Designation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgentInfoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isFloorManager()) {
            abort(403, 'You do not have permission to access this page.');
        }

        $agents = User::where('status', 'active')
            ->whereIn('designation', ['CSR', 'Verification Officer'])
            ->with(['floorManager', 'teamLead'])
            ->orderByRaw("CAST(SUBSTRING(COALESCE(employee_id, ''), 3) AS UNSIGNED)")
            ->orderBy('employee_id')
            ->get();

        // Dropdowns: only users with designation Floor Manager / Team Lead (not user_type)
        $floorManagers = User::where('designation', 'Floor Manager')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $teamLeads = User::where('designation', 'Team Lead')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Agent designation options: CSR / Verification Officer only
        $designations = Designation::where('status', 'active')
            ->whereIn('name', ['CSR', 'Verification Officer'])
            ->orderBy('name')
            ->get();

        return view('agent_info.index', compact(
            'agents',
            'floorManagers',
            'teamLeads',
            'designations'
        ));
    }

    public function update(Request $request, $id)
    {
        $authUser = auth()->user();
        if (!$authUser->isAdmin() && !$authUser->isFloorManager()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'contact_number' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'cnic' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'appointment_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'floor_manager_id' => 'nullable|exists:users,id',
            'team_lead_id' => 'nullable|exists:users,id',
        ]);

        try {
            $employee = User::findOrFail($id);

            $employee->contact_number = $request->contact_number;
            $employee->emergency_contact = $request->emergency_contact;
            $employee->cnic = $request->cnic;
            $employee->designation = $request->designation;
            $employee->appointment_date = $request->appointment_date ?: null;
            $employee->status = $request->status;
            $employee->floor_manager_id = $request->floor_manager_id ?: null;
            $employee->team_lead_id = $request->team_lead_id ?: null;
            $employee->save();

            $stillVisible = $employee->status === 'active'
                && in_array($employee->designation, ['CSR', 'Verification Officer'], true);

            return response()->json([
                'success' => true,
                'message' => 'Agent updated successfully',
                'remove_row' => !$stillVisible,
                'data' => [
                    'contact_number' => $employee->contact_number,
                    'emergency_contact' => $employee->emergency_contact,
                    'cnic' => $employee->cnic,
                    'designation' => $employee->designation,
                    'appointment_date' => $employee->appointment_date ? Carbon::parse($employee->appointment_date)->format('Y-m-d') : '',
                    'status' => $employee->status,
                    'floor_manager_id' => $employee->floor_manager_id,
                    'team_lead_id' => $employee->team_lead_id,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating agent: ' . $e->getMessage(),
            ], 500);
        }
    }
}
