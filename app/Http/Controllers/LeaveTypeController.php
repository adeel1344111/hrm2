<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::ordered()->paginate(10);
        
        $stats = [
            'total' => LeaveType::count(),
            'active' => LeaveType::where('is_active', true)->count(),
            'inactive' => LeaveType::where('is_active', false)->count(),
            'with_max_days' => LeaveType::whereNotNull('max_days')->count(),
        ];

        return view('leave-types.index', compact('leaveTypes', 'stats'));
    }

    public function create()
    {
        return view('leave-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:leave_types,name',
            'description' => 'nullable|string|max:500',
            'max_days' => 'nullable|integer|min:1|max:365',
            'requires_approval' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        LeaveType::create([
            'name' => $request->name,
            'description' => $request->description,
            'max_days' => $request->max_days,
            'requires_approval' => $request->has('requires_approval'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('leave-types.index')->with('success', 'Leave type created successfully.');
    }

    public function show(LeaveType $leaveType)
    {
        $leaveType->load('leaves.user');
        
        $stats = [
            'total_leaves' => $leaveType->leaves()->count(),
            'pending_leaves' => $leaveType->leaves()->where('status', 'Pending')->count(),
            'approved_leaves' => $leaveType->leaves()->where('status', 'Approved')->count(),
            'rejected_leaves' => $leaveType->leaves()->where('status', 'Rejected')->count(),
        ];

        return view('leave-types.show', compact('leaveType', 'stats'));
    }

    public function edit(LeaveType $leaveType)
    {
        return view('leave-types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:leave_types,name,' . $leaveType->id,
            'description' => 'nullable|string|max:500',
            'max_days' => 'nullable|integer|min:1|max:365',
            'requires_approval' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $leaveType->update([
            'name' => $request->name,
            'description' => $request->description,
            'max_days' => $request->max_days,
            'requires_approval' => $request->has('requires_approval'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('leave-types.index')->with('success', 'Leave type updated successfully.');
    }

    public function destroy(LeaveType $leaveType)
    {
        // Check if leave type is being used
        if ($leaveType->leaves()->count() > 0) {
            return redirect()->route('leave-types.index')->with('error', 'Cannot delete leave type that is being used by existing leave requests.');
        }

        $leaveType->delete();

        return redirect()->route('leave-types.index')->with('success', 'Leave type deleted successfully.');
    }
}