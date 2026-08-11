@extends('layouts.master')
@section('title') Edit Leave Type @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Edit Leave Type</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('home') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('leave-types.index') }}" class="text-slate-400 dark:text-zink-200">Leave Types</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Edit Leave Type</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Edit Leave Type Information</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        <form action="{{ route('leave-types.update', $leaveType) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-3">Leave Type Name <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input w-full @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name', $leaveType->name) }}" placeholder="e.g., Sick Leave" required>
                                    @error('name')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-3">Sort Order</label>
                                    <input type="number" class="form-input w-full @error('sort_order') border-red-500 @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $leaveType->sort_order) }}" min="0">
                                    <div class="text-xs text-slate-500 dark:text-zink-400 mt-1">Lower numbers appear first in lists</div>
                                    @error('sort_order')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="description" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-3">Description</label>
                                <textarea class="form-input w-full @error('description') border-red-500 @enderror" id="description" name="description" rows="3" placeholder="Brief description of this leave type...">{{ old('description', $leaveType->description) }}</textarea>
                                @error('description')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
                                <div>
                                    <label for="max_days" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-3">Maximum Days</label>
                                    <input type="number" class="form-input w-full @error('max_days') border-red-500 @enderror" id="max_days" name="max_days" value="{{ old('max_days', $leaveType->max_days) }}" placeholder="Leave empty for unlimited" min="1" max="365">
                                    <div class="text-xs text-slate-500 dark:text-zink-400 mt-1">Maximum number of days allowed for this leave type</div>
                                    @error('max_days')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-3">Sort Order</label>
                                    <input type="number" class="form-input w-full @error('sort_order') border-red-500 @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $leaveType->sort_order) }}" min="0">
                                    <div class="text-xs text-slate-500 dark:text-zink-400 mt-1">Lower numbers appear first in lists</div>
                                    @error('sort_order')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="form-checkbox h-4 w-4 text-custom-500 @error('requires_approval') border-red-500 @enderror" id="requires_approval" name="requires_approval" {{ old('requires_approval', $leaveType->requires_approval) ? 'checked' : '' }}>
                                        <label for="requires_approval" class="ml-2 block text-sm text-slate-700 dark:text-zink-300">
                                            Requires Approval
                                        </label>
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-zink-400 mt-1">Leave requests of this type need supervisor approval</div>
                                    @error('requires_approval')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="form-checkbox h-4 w-4 text-custom-500 @error('is_active') border-red-500 @enderror" id="is_active" name="is_active" {{ old('is_active', $leaveType->is_active) ? 'checked' : '' }}>
                                        <label for="is_active" class="ml-2 block text-sm text-slate-700 dark:text-zink-300">
                                            Active
                                        </label>
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-zink-400 mt-1">Make this leave type available for selection</div>
                                    @error('is_active')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex gap-3 mt-8">
                                <button type="submit" class="btn bg-custom-500 text-white btn-md">
                                    <i data-lucide="save" class="inline-block size-4 me-1"></i> Update Leave Type
                                </button>
                                <a href="{{ route('leave-types.index') }}" class="btn bg-slate-200 text-slate-800 btn-md">
                                    <i data-lucide="arrow-left" class="inline-block size-4 me-1"></i> Back to Leave Types
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Current Information</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Leave Type</label>
                                <div class="flex items-center">
                                    <span class="text-slate-700 dark:text-zink-300 font-medium">{{ $leaveType->name }}</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Description</label>
                                <div>
                                    <span class="text-slate-700 dark:text-zink-300">{{ $leaveType->description ?? 'No description' }}</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Max Days</label>
                                <div>
                                    @if($leaveType->max_days)
                                        <span class="badge bg-info-subtle text-info">{{ $leaveType->max_days }} {{ Str::plural('day', $leaveType->max_days) }}</span>
                                    @else
                                        <span class="text-slate-500 dark:text-zink-400">Unlimited</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Approval Required</label>
                                <div>
                                    @if($leaveType->requires_approval)
                                        <span class="badge bg-yellow-100 text-yellow-600">Yes</span>
                                    @else
                                        <span class="badge bg-green-100 text-green-600">No</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Status</label>
                                <div>
                                    @if($leaveType->is_active)
                                        <span class="badge bg-green-100 text-green-600">Active</span>
                                    @else
                                        <span class="badge bg-red-100 text-red-600">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Sort Order</label>
                                <div>
                                    <span class="text-slate-700 dark:text-zink-300">{{ $leaveType->sort_order }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-6">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Usage Statistics</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-zink-300">Total Leaves</span>
                                <span class="text-sm font-medium text-slate-900 dark:text-zink-100">{{ $leaveType->leaves()->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-zink-300">Pending</span>
                                <span class="text-sm font-medium text-yellow-600">{{ $leaveType->leaves()->where('status', 'Pending')->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-zink-300">Approved</span>
                                <span class="text-sm font-medium text-green-600">{{ $leaveType->leaves()->where('status', 'Approved')->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-zink-300">Rejected</span>
                                <span class="text-sm font-medium text-red-600">{{ $leaveType->leaves()->where('status', 'Rejected')->count() }}</span>
                            </div>
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
