@extends('layouts.master')
@section('title') Leave Request Details @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Leave Request Details</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('home') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('leaves.index') }}" class="text-slate-400 dark:text-zink-200">Leave Management</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Leave Details</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h5 class="card-title mb-0 text-lg font-semibold">Leave Request Information</h5>
                            <div class="flex gap-2">
                                @if($leave->user_id === auth()->user()->id && $leave->status === 'Pending')
                                    @if(!auth()->user()->isAgent())
                                    <a href="{{ route('leaves.edit', $leave) }}" class="btn bg-warning-500 text-white btn-sm">
                                        <i data-lucide="edit" class="inline-block size-4 me-1"></i> Edit
                                    </a>
                                    @endif
                                <form action="{{ route('leaves.destroy', $leave) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this leave request?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn bg-red-500 text-white btn-sm">
                                        <i data-lucide="trash-2" class="inline-block size-4 me-1"></i> Cancel
                                    </button>
                                </form>
                                @endif
                                @if(($leave->status === 'Pending') && (auth()->user()->canApproveLeaves()))
                                <form action="{{ route('leaves.approve', $leave) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to approve this leave request?')">
                                    @csrf
                                    <button type="submit" class="btn bg-green-500 text-white btn-sm">
                                        <i data-lucide="check" class="inline-block size-4 me-1"></i> Approve
                                    </button>
                                </form>
                                <button type="button" class="btn bg-red-500 text-white btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i data-lucide="x" class="inline-block size-4 me-1"></i> Reject
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Employee</label>
                                <div class="flex items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="avatar-title rounded-circle bg-slate-200 dark:bg-zink-600 text-slate-800 dark:text-zink-200">
                                            @php
                                            $fullName = $leave->user->name;
                                                $parts = explode(' ', $fullName);
                                                $initials = '';
                                                foreach ($parts as $part) {
                                                    $initials .= strtoupper(substr($part, 0, 1));
                                                }
                                            @endphp
                                            {{ $initials }}
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ $leave->user->name }}</h6>
                                        <div class="text-sm text-slate-500 dark:text-zink-400">{{ $leave->user->employee_id ?? 'N/A' }} • {{ ucfirst($leave->user->user_type) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Leave Type</label>
                                <div>
                                    <span class="badge {{ $leave->leave_type_color }} fs-6">{{ $leave->leave_type }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Start Date</label>
                                <div>
                                    <h6 class="mb-0">{{ $leave->start_date->format('l, M d, Y') }}</h6>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">End Date</label>
                                <div>
                                    <h6 class="mb-0">{{ $leave->end_date->format('l, M d, Y') }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Total Days</label>
                                <div>
                                    <span class="badge bg-info-subtle text-info fs-6">{{ $leave->total_days }} {{ Str::plural('day', $leave->total_days) }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Status</label>
                                <div>
                                    <span class="badge {{ $leave->status_color }} fs-6">{{ $leave->status }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Reason</label>
                            <div class="border border-slate-200 dark:border-zink-500 rounded-lg p-4 bg-slate-50 dark:bg-zink-600">
                                <p class="mb-0 text-slate-700 dark:text-zink-300">{{ $leave->reason }}</p>
                            </div>
                        </div>

                        @if($leave->admin_remarks)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Admin Remarks</label>
                            <div class="border border-slate-200 dark:border-zink-500 rounded-lg p-4 bg-slate-50 dark:bg-zink-600">
                                <p class="mb-0 text-slate-700 dark:text-zink-300">{{ $leave->admin_remarks }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Applied On</label>
                                <div>
                                    <h6 class="mb-0">{{ $leave->created_at->format('M d, Y g:i A') }}</h6>
                                </div>
                            </div>
                            @if($leave->approved_at)
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Processed On</label>
                                <div>
                                    <h6 class="mb-0">{{ $leave->approved_at->format('M d, Y g:i A') }}</h6>
                                    @if($leave->approvedBy)
                                    <div class="text-sm text-slate-500 dark:text-zink-400">by {{ $leave->approvedBy->name }}</div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
            </div>
        </div>

            <div class="lg:col-span-1">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Timeline</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-custom-500"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Leave Request Submitted</h6>
                                    <p class="text-slate-500 dark:text-zink-400 mb-0">{{ $leave->created_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                            
                            @if($leave->status !== 'Pending')
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $leave->status === 'Approved' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Request {{ $leave->status }}</h6>
                                    <p class="text-slate-500 dark:text-zink-400 mb-0">{{ $leave->approved_at->format('M d, Y g:i A') }}</p>
                                    @if($leave->approvedBy)
                                    <p class="text-slate-500 dark:text-zink-400 mb-0">by {{ $leave->approvedBy->name }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-6">
                <div class="card-header px-6 py-4">
                    <h5 class="card-title mb-0 text-lg font-semibold">Quick Actions</h5>
                </div>
                <div class="card-body px-6 py-6">
                    <div class="d-grid gap-2">
                        <a href="{{ route('leaves.index') }}" class="btn btn-outline-primary">
                            <i data-lucide="arrow-left" class="inline-block size-4 me-1"></i> Back to Leaves
                        </a>
                        @if($leave->user_id === auth()->user()->id && $leave->status === 'Pending')
                            @if(!auth()->user()->isAgent())
                            <a href="{{ route('leaves.edit', $leave) }}" class="btn btn-outline-warning">
                                <i data-lucide="edit" class="inline-block size-4 me-1"></i> Edit Request
                            </a>
                            @endif
                        @endif
                        @if(($leave->status === 'Pending') && (auth()->user()->canApproveLeaves()))
                        <button type="button" class="btn btn-outline-success" onclick="document.querySelector('form[action*=\"approve\"]').submit()">
                            <i data-lucide="check" class="inline-block size-4 me-1"></i> Approve Request
                        </button>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i data-lucide="x" class="inline-block size-4 me-1"></i> Reject Request
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
@if(($leave->status === 'Pending') && (auth()->user()->canApproveLeaves()))
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Leave Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('leaves.reject', $leave) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="admin_remarks" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="admin_remarks" name="admin_remarks" rows="3" placeholder="Please provide a reason for rejecting this leave request..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
</div>

@endsection

@section('script')
<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content h6 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
}

.timeline-content p {
    font-size: 12px;
    margin-bottom: 0;
}
</style>
@endsection
