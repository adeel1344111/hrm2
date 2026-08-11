@extends('layouts.master')
@section('title') Leave Type Details @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Leave Type Details</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('home') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('leave-types.index') }}" class="text-slate-400 dark:text-zink-200">Leave Types</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Leave Type Details</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h5 class="card-title mb-0 text-lg font-semibold">Leave Type Information</h5>
                            <div class="flex gap-2">
                                <a href="{{ route('leave-types.edit', $leaveType) }}" class="btn bg-warning-500 text-white btn-sm">
                                    <i data-lucide="edit" class="inline-block size-4 me-1"></i> Edit
                                </a>
                                <form action="{{ route('leave-types.destroy', $leaveType) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this leave type?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn bg-red-500 text-white btn-sm">
                                        <i data-lucide="trash-2" class="inline-block size-4 me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Leave Type Name</label>
                                <div class="flex items-center">
                                    <h6 class="mb-0 text-lg font-semibold">{{ $leaveType->name }}</h6>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Status</label>
                                <div>
                                    @if($leaveType->is_active)
                                        <span class="badge bg-green-100 text-green-600 fs-6">Active</span>
                                    @else
                                        <span class="badge bg-red-100 text-red-600 fs-6">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Description</label>
                            <div class="border border-slate-200 dark:border-zink-500 rounded-lg p-4 bg-slate-50 dark:bg-zink-600">
                                <p class="mb-0 text-slate-700 dark:text-zink-300">{{ $leaveType->description ?? 'No description provided' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Maximum Days</label>
                                <div>
                                    @if($leaveType->max_days)
                                        <span class="badge bg-info-subtle text-info fs-6">{{ $leaveType->max_days }} {{ Str::plural('day', $leaveType->max_days) }}</span>
                                    @else
                                        <span class="text-slate-500 dark:text-zink-400">Unlimited</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Approval Required</label>
                                <div>
                                    @if($leaveType->requires_approval)
                                        <span class="badge bg-yellow-100 text-yellow-600 fs-6">Yes</span>
                                    @else
                                        <span class="badge bg-green-100 text-green-600 fs-6">No</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Sort Order</label>
                                <div>
                                    <span class="text-slate-700 dark:text-zink-300">{{ $leaveType->sort_order }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Created On</label>
                                <div>
                                    <span class="text-slate-700 dark:text-zink-300">{{ $leaveType->created_at->format('M d, Y g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Leaves -->
                <div class="card mt-6">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Recent Leave Requests</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        @if($leaveType->leaves()->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-slate-200 dark:border-zink-500">
                                <thead class="bg-slate-50 dark:bg-zink-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border-b border-slate-200 dark:border-zink-500">Employee</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border-b border-slate-200 dark:border-zink-500">Dates</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border-b border-slate-200 dark:border-zink-500">Days</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border-b border-slate-200 dark:border-zink-500">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border-b border-slate-200 dark:border-zink-500">Applied On</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-zink-700 divide-y divide-slate-200 dark:divide-zink-500">
                                    @foreach($leaveType->leaves()->latest()->limit(5)->get() as $leave)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-zink-600 transition-colors">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-slate-900 dark:text-zink-100">{{ $leave->user->name }}</div>
                                            <div class="text-sm text-slate-500 dark:text-zink-400">{{ $leave->user->employee_id ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                            {{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="badge bg-info-subtle text-info">{{ $leave->total_days }} {{ Str::plural('day', $leave->total_days) }}</span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="badge {{ $leave->status_color }}">{{ $leave->status }}</span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                            {{ $leave->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <div class="flex flex-col items-center justify-center text-slate-500 dark:text-zink-400">
                                <i data-lucide="calendar-x" class="inline-block size-12 mb-4 text-slate-300 dark:text-zink-600"></i>
                                <h6 class="text-lg font-medium mb-2">No leave requests found</h6>
                                <p class="text-sm">No leave requests have been made using this leave type yet.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <!-- Statistics -->
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Usage Statistics</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="space-y-6">
                            <div class="text-center">
                                <h6 class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['total_leaves'] }}</h6>
                                <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Leaves</p>
                                <p class="text-xs text-slate-500 dark:text-zink-400">All requests</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <h6 class="text-2xl font-bold text-yellow-600 mb-1">{{ $stats['pending_leaves'] }}</h6>
                                    <p class="text-xs text-slate-500 dark:text-zink-400">Pending</p>
                                </div>
                                <div class="text-center">
                                    <h6 class="text-2xl font-bold text-green-600 mb-1">{{ $stats['approved_leaves'] }}</h6>
                                    <p class="text-xs text-slate-500 dark:text-zink-400">Approved</p>
                                </div>
                                <div class="text-center">
                                    <h6 class="text-2xl font-bold text-red-600 mb-1">{{ $stats['rejected_leaves'] }}</h6>
                                    <p class="text-xs text-slate-500 dark:text-zink-400">Rejected</p>
                                </div>
                                <div class="text-center">
                                    <h6 class="text-2xl font-bold text-blue-600 mb-1">{{ $stats['total_leaves'] - $stats['pending_leaves'] - $stats['approved_leaves'] - $stats['rejected_leaves'] }}</h6>
                                    <p class="text-xs text-slate-500 dark:text-zink-400">Cancelled</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mt-6">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Quick Actions</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="d-grid gap-2">
                            <a href="{{ route('leave-types.index') }}" class="btn btn-outline-primary">
                                <i data-lucide="arrow-left" class="inline-block size-4 me-1"></i> Back to Leave Types
                            </a>
                            <a href="{{ route('leave-types.edit', $leaveType) }}" class="btn btn-outline-warning">
                                <i data-lucide="edit" class="inline-block size-4 me-1"></i> Edit Leave Type
                            </a>
                            <a href="{{ route('leaves.create') }}" class="btn btn-outline-success">
                                <i data-lucide="plus" class="inline-block size-4 me-1"></i> Request Leave
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
