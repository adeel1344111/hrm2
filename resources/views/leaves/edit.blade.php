@extends('layouts.master')
@section('title') Edit Leave Request @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Edit Leave Request</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('home') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('leaves.index') }}" class="text-slate-400 dark:text-zink-200">Leave Management</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Edit Leave Request</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Edit Leave Request</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        <form action="{{ route('leaves.update', $leave) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label for="leave_type" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Leave Type <span class="text-red-500">*</span></label>
                                    <select class="form-input w-full @error('leave_type') border-red-500 @enderror" id="leave_type" name="leave_type" required>
                                        <option value="">Select Leave Type</option>
                                        @foreach($leaveTypes as $leaveType)
                                            <option value="{{ $leaveType->name }}" {{ old('leave_type', $leave->leave_type) == $leaveType->name ? 'selected' : '' }}>
                                                {{ $leaveType->name }}
                                                @if($leaveType->max_days)
                                                    (Max: {{ $leaveType->max_days }} days)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('leave_type')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="total_days" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Total Days</label>
                                    <input type="text" class="form-input w-full bg-slate-100 dark:bg-zink-600" id="total_days" readonly>
                                    <div class="text-xs text-slate-500 dark:text-zink-400 mt-1">This will be calculated automatically based on your selected dates.</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mt-4">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Start Date <span class="text-red-500">*</span></label>
                                    <input type="date" class="form-input w-full @error('start_date') border-red-500 @enderror" id="start_date" name="start_date" value="{{ old('start_date', $leave->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">End Date <span class="text-red-500">*</span></label>
                                    <input type="date" class="form-input w-full @error('end_date') border-red-500 @enderror" id="end_date" name="end_date" value="{{ old('end_date', $leave->end_date->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="reason" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Reason <span class="text-red-500">*</span></label>
                                <textarea class="form-input w-full @error('reason') border-red-500 @enderror" id="reason" name="reason" rows="4" placeholder="Please provide a detailed reason for your leave request..." required>{{ old('reason', $leave->reason) }}</textarea>
                                @error('reason')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex gap-3 mt-6">
                                <button type="submit" class="btn bg-custom-500 text-white btn-md">
                                    <i data-lucide="save" class="inline-block size-4 me-1"></i> Update Request
                                </button>
                                <a href="{{ route('leaves.index') }}" class="btn bg-slate-200 text-slate-800 btn-md">
                                    <i data-lucide="arrow-left" class="inline-block size-4 me-1"></i> Back to Leaves
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Current Request Details</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="flex items-center mb-4">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <div class="avatar-title bg-custom-100 text-custom-500 rounded fs-3">
                                    <i data-lucide="calendar" class="inline-block size-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Request Information</h6>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Leave Type</label>
                                <div>
                                    <span class="badge {{ $leave->leave_type_color }}">{{ $leave->leave_type }}</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Duration</label>
                                <div>
                                    <span class="text-slate-700 dark:text-zink-300">{{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Total Days</label>
                                <div>
                                    <span class="badge bg-info-subtle text-info">{{ $leave->total_days }} {{ Str::plural('day', $leave->total_days) }}</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Status</label>
                                <div>
                                    <span class="badge {{ $leave->status_color }}">{{ $leave->status }}</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Applied On</label>
                                <div>
                                    <span class="text-slate-700 dark:text-zink-300">{{ $leave->created_at->format('M d, Y g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-6">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Edit Guidelines</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="flex items-center mb-4">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <div class="avatar-title bg-warning-100 text-warning-500 rounded fs-3">
                                    <i data-lucide="alert-triangle" class="inline-block size-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Important Notes</h6>
                            </div>
                        </div>
                        
                        <ul class="space-y-3 mb-0">
                            <li class="flex items-start">
                                <i data-lucide="info" class="inline-block size-4 text-blue-500 me-2 mt-0.5"></i>
                                <span class="text-sm text-slate-600 dark:text-zink-300">You can only edit pending requests</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="info" class="inline-block size-4 text-blue-500 me-2 mt-0.5"></i>
                                <span class="text-sm text-slate-600 dark:text-zink-300">Start date cannot be in the past</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="info" class="inline-block size-4 text-blue-500 me-2 mt-0.5"></i>
                                <span class="text-sm text-slate-600 dark:text-zink-300">End date must be after start date</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="info" class="inline-block size-4 text-blue-500 me-2 mt-0.5"></i>
                                <span class="text-sm text-slate-600 dark:text-zink-300">Changes will be reviewed by your supervisor</span>
                            </li>
                        </ul>
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

    // Calculate total days
    function calculateDays() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            
            document.getElementById('total_days').value = diffDays + ' day' + (diffDays > 1 ? 's' : '');
        }
    }

    // Add event listeners
    document.getElementById('start_date').addEventListener('change', calculateDays);
    document.getElementById('end_date').addEventListener('change', calculateDays);

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').setAttribute('min', today);
    document.getElementById('end_date').setAttribute('min', today);

    // Update end date minimum when start date changes
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').setAttribute('min', this.value);
    });

    // Calculate days on page load
    calculateDays();
</script>
@endsection