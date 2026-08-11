@extends('layouts.master')
@section('title') Attendance Management @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Attendance Management</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="#!" class="text-slate-400 dark:text-zink-200">Attendance</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Management</li>
            </ul>
        </div>
        
        <!-- Date Picker and Actions -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
            <div class="flex flex-wrap items-center gap-3">
                <input type="date" id="attendance-date" value="{{ $selectedDate }}" class="form-input">
                <select id="designation-filter" class="form-select dark:bg-zink-700 dark:border-zink-500 dark:text-zink-200">
                    <option value="all">All Designations</option>
                    <option value="CSR">CSR</option>
                    <option value="Verification Officer">Verification Officer</option>
                    <option value="Management">Management</option>
                    <option value="Admin Staff">Admin Staff</option>
                </select>
            </div>
            <div class="flex items-center gap-3">
                @if(Auth::user()->isAdmin())
                <button type="button" id="cleanup-btn" class="btn bg-red-500 text-white border-red-500 hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-red-400/20 mr-2">
                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                    Cleanup Invalid
                </button>
                @endif
                <button type="button" id="mark-selected-btn" class="btn bg-green-500 text-white border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <i data-lucide="check-check" class="w-4 h-4 mr-2"></i>
                    Mark Selected (<span id="selected-count">0</span>)
                </button>
                <button type="button" id="bulk-mark-btn" class="btn bg-custom-500 text-white border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                    <i data-lucide="check-square" class="w-4 h-4 mr-2"></i>
                    Bulk Mark
                </button>
            </div>
        </div>

        <!-- Selected mark bar -->
        <div id="selected-mark-bar" class="hidden card mb-4 border border-green-200 dark:border-green-500/30 bg-green-50/60 dark:bg-green-500/10">
            <div class="card-body py-3">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <div class="text-sm font-medium text-slate-700 dark:text-zink-100">
                        Mark <span id="selected-count-bar">0</span> selected employee(s) for <span id="selected-date-label">{{ $selectedDate }}</span>
                        <span class="block text-xs text-slate-500 dark:text-zink-300 mt-1">Select All only includes currently visible rows (respects designation / management filter).</span>
                    </div>
                    <div class="flex flex-wrap items-end gap-2">
                        <div>
                            <label class="block text-xs mb-1 text-slate-500">Status</label>
                            <select id="selected-status" class="form-select w-32">
                                <option value="P">Present</option>
                                <option value="A">Absent</option>
                                <option value="H">Half Day</option>
                                <option value="U">Unpaid</option>
                                <option value="NCNS">NCNS</option>
                                <option value="HOLIDAY">Holiday</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs mb-1 text-slate-500">Check In</label>
                            <input type="time" id="selected-check-in" class="form-input w-32">
                        </div>
                        <div>
                            <label class="block text-xs mb-1 text-slate-500">Check Out</label>
                            <input type="time" id="selected-check-out" class="form-input w-32">
                        </div>
                        <div>
                            <label class="block text-xs mb-1 text-slate-500">Remarks</label>
                            <input type="text" id="selected-remarks" class="form-input w-40" placeholder="Optional">
                        </div>
                        <button type="button" id="confirm-mark-selected-btn" class="btn bg-green-500 text-white border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 active:text-white active:bg-green-600 active:border-green-600 shadow-sm whitespace-nowrap">
                            Confirm Mark
                        </button>
                    </div>
                </div>
            </div>
        </div>
            
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-green-600 mb-2">{{ $stats['present'] }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Present</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Employees marked present</p>
                        <div class="flex items-center justify-center text-green-500 text-sm">
                            <i data-lucide="user-check" class="w-4 h-4 mr-1"></i>
                            <span>{{ $stats['total'] > 0 ? round(($stats['present'] / $stats['total']) * 100) : 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-red-600 mb-2">{{ $stats['absent'] }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Absent</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Employees marked absent</p>
                        <div class="flex items-center justify-center text-red-500 text-sm">
                            <i data-lucide="user-x" class="w-4 h-4 mr-1"></i>
                            <span>{{ $stats['total'] > 0 ? round(($stats['absent'] / $stats['total']) * 100) : 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-yellow-600 mb-2">{{ $stats['half_day'] }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Half Day</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Partial attendance</p>
                        <div class="flex items-center justify-center text-yellow-500 text-sm">
                            <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                            <span>{{ $stats['total'] > 0 ? round(($stats['half_day'] / $stats['total']) * 100) : 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-gray-600 mb-2">{{ $stats['not_marked'] }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Not Marked</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Pending attendance</p>
                        <div class="flex items-center justify-center text-gray-500 text-sm">
                            <i data-lucide="user-minus" class="w-4 h-4 mr-1"></i>
                            <span>{{ $stats['total'] > 0 ? round(($stats['not_marked'] / $stats['total']) * 100) : 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="card">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500 dark:text-zink-400">
                                <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-zink-600 dark:text-zink-300">
                                    <tr>
                                        <th scope="col" class="px-3 py-3 w-12">
                                            <input type="checkbox" id="select-all-attendance" class="size-4 rounded border-slate-300 text-custom-500 focus:ring-custom-500" title="Select all visible">
                                        </th>
                                        <th scope="col" class="px-6 py-3">Employee</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                        <th scope="col" class="px-6 py-3">Check In</th>
                                        <th scope="col" class="px-6 py-3">Check Out</th>
                                        <th scope="col" class="px-6 py-3">Remarks</th>
                                        <th scope="col" class="px-6 py-3">Marked By</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employees as $employee)
                                        @php
                                            $attendance = $attendances->get($employee->id);
                                            $des = trim((string) ($employee->designation ?? ''));
                                            $roleLabel = $des !== '' ? $des : match ($employee->user_type ?? '') {
                                                'team_lead' => 'Team Lead',
                                                'floor_manager' => 'Floor Manager',
                                                'management' => 'Management',
                                                'admin' => 'Admin Staff',
                                                default => 'Management',
                                            };
                                        @endphp
                                        <tr class="bg-white border-b dark:bg-zink-700 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600 attendance-row"
                                            data-designation="{{ $des }}"
                                            data-user-type="{{ $employee->user_type ?? '' }}"
                                            data-user-id="{{ $employee->id }}"
                                            data-employee-code="{{ $employee->employee_id ?? '' }}">
                                            <td class="px-3 py-4">
                                                <input type="checkbox"
                                                    class="row-select size-4 rounded border-slate-300 text-custom-500 focus:ring-custom-500"
                                                    value="{{ $employee->id }}"
                                                    data-employee-id="{{ $employee->employee_id ?? '' }}">
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-10 h-10">
                                                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-zink-600 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-slate-800 dark:text-zink-200">
                                                                @php
                                                                $fullName = $employee->name;
                                                                    $parts = explode(' ', $fullName);
                                                                    $initials = '';
                                                                    foreach ($parts as $part) {
                                                                        $initials .= strtoupper(substr($part, 0, 1));
                                                                    }
                                                                @endphp
                                                                {{ $initials }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ms-3">
                                                        <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                            {{ $employee->name }}
                                                        </div>
                                                        <div class="text-sm text-slate-500 dark:text-slate-400">
                                                            {{ $employee->employee_id ?? 'N/A' }} · {{ $roleLabel }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($attendance)
                                                    @php
                                                        $statusCheckIn = $attendance->check_in_input;
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium whitespace-nowrap {{ $attendance->status_color }}">
                                                        @if($statusCheckIn !== '')
                                                            {{ $statusCheckIn }}
                                                        @else
                                                            {{ $attendance->status_label }}
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium whitespace-nowrap text-gray-600 bg-gray-100">
                                                        Not Marked
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="time" 
                                                       class="form-input w-32" 
                                                       value="{{ $attendance ? $attendance->check_in_input : '' }}"
                                                       data-user-id="{{ $employee->id }}"
                                                       data-field="check_in">
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="time" 
                                                       class="form-input w-32" 
                                                       value="{{ $attendance ? $attendance->check_out_input : '' }}"
                                                       data-user-id="{{ $employee->id }}"
                                                       data-field="check_out">
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="text" 
                                                       class="form-input w-40" 
                                                       placeholder="Remarks"
                                                       value="{{ $attendance ? $attendance->remarks : '' }}"
                                                       data-user-id="{{ $employee->id }}"
                                                       data-field="remarks">
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($attendance && $attendance->markedBy)
                                                    <span class="text-sm text-slate-600 dark:text-slate-300">
                                                        {{ $attendance->markedBy->name }}
                                                    </span>
                                                @else
                                                    <span class="text-sm text-slate-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <select class="form-select w-32" 
                                                            data-user-id="{{ $employee->id }}"
                                                            data-field="status">
                                                        <option value="P" {{ $attendance && $attendance->status === 'P' ? 'selected' : '' }}>Present</option>
                                                        <option value="A" {{ $attendance && $attendance->status === 'A' ? 'selected' : '' }}>Absent</option>
                                                        <option value="H" {{ $attendance && $attendance->status === 'H' ? 'selected' : '' }}>Half Day</option>
                                                        <option value="U" {{ $attendance && $attendance->status === 'U' ? 'selected' : '' }}>Unpaid</option>
                                                        <option value="NCNS" {{ $attendance && $attendance->status === 'NCNS' ? 'selected' : '' }}>NCNS</option>
                                                        <option value="HOLIDAY" {{ $attendance && $attendance->status === 'HOLIDAY' ? 'selected' : '' }}>Holiday</option>
                                                    </select>
                                                    <button type="button" 
                                                            class="btn bg-custom-500 text-white border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20"
                                                            onclick="markAttendance({{ $employee->id }})">
                                                        <i data-lucide="check" class="w-4 h-4"></i>
                                                    </button>
                                                    @if($attendance)
                                                    <button type="button" 
                                                            class="btn bg-red-500 text-white border-red-500 hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-red-400/20"
                                                            onclick="deleteAttendance({{ $attendance->id }})">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-slate-500 dark:text-zink-400">
                                                No employees found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Bulk Mark Modal -->
<div id="bulk-mark-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-500 bg-opacity-75" onclick="closeBulkMarkModal()"></div>
        <div class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg dark:bg-zink-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-slate-900 dark:text-white">Bulk Mark Attendance</h3>
                <button type="button" onclick="closeBulkMarkModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-zink-200">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <form id="bulk-mark-form">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">From Date</label>
                        <input type="date" id="bulk-from-date" class="form-input w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">To Date <span class="text-xs text-slate-400">(optional — leave empty to mark only the From Date)</span></label>
                        <input type="date" id="bulk-to-date" class="form-input w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Select Status</label>
                    <select id="bulk-status" class="form-select w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                        <option value="P">Present</option>
                        <option value="A">Absent</option>
                        <option value="H">Half Day</option>
                        <option value="U">Unpaid</option>
                        <option value="NCNS">NCNS</option>
                        <option value="HOLIDAY">Holiday</option>
                        <option value="DELETE" class="text-red-500 font-bold">Delete Records</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Designation Filter</label>
                    <select id="bulk-designation-filter" class="form-select w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                        <option value="all">All Designations</option>
                        <option value="CSR">CSR</option>
                        <option value="Verification Officer">Verification Officer</option>
                        <option value="Management">Management</option>
                        <option value="Admin Staff">Admin Staff</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Employee IDs (Optional)
                        <span class="text-xs font-normal text-slate-500 dark:text-slate-400 ml-1">Paste IDs separated by new lines or commas. Leave empty to mark ALL (respects designation filter).</span>
                    </label>
                    <textarea id="bulk-employee-ids" class="form-textarea w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 font-mono text-sm" rows="4" placeholder="e.g.&#10;MK344&#10;MK454&#10;MK564"></textarea>
                    <div id="matched-employees-container" class="flex flex-wrap gap-2 mt-2"></div>
                </div>
                
                <div class="mb-4" id="bulk-time-fields">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Check In Time</label>
                        <input type="time" id="bulk-check-in" class="form-input w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Check Out Time</label>
                        <input type="time" id="bulk-check-out" class="form-input w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Remarks</label>
                        <textarea id="bulk-remarks" class="form-textarea w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" rows="3" placeholder="Enter remarks (optional)"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeBulkMarkModal()" class="btn bg-slate-200 text-slate-800 border-slate-200 hover:bg-slate-300 hover:border-slate-300 focus:bg-slate-300 focus:border-slate-300 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100">
                        Cancel
                    </button>
                    <button type="submit" class="btn bg-custom-500 text-white border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                        Mark All
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Cleanup Modal -->
    <div id="cleanup-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-slate-500 bg-opacity-75" onclick="closeCleanupModal()"></div>
            <div class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg dark:bg-zink-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white">Cleanup Invalid Records</h3>
                    <button type="button" onclick="closeCleanupModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-zink-200">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <div class="mb-4">
                    <p class="text-slate-600 dark:text-slate-300 mb-2">The following records violate appointment or leaving date rules. Please review before proceeding.</p>
                    <div class="overflow-x-auto border rounded-md max-h-96 overflow-y-auto">
                        <table class="w-full text-sm text-left text-slate-500 dark:text-zink-400">
                            <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-zink-600 dark:text-zink-200 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2">Employee</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Reason</th>
                                </tr>
                            </thead>
                            <tbody id="cleanup-list-body" class="bg-white divide-y divide-slate-200 dark:bg-zink-700 dark:divide-zink-600">
                                <!-- Dynamic Content -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeCleanupModal()" class="btn bg-slate-200 text-slate-800 border-slate-200 hover:bg-slate-300 hover:border-slate-300 focus:bg-slate-300 focus:border-slate-300 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100">
                        Cancel
                    </button>
                    <button type="button" id="confirm-cleanup-btn" class="btn bg-red-500 text-white border-red-500 hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-red-400/20">
                        Proceed & Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Date change handler
    document.getElementById('attendance-date').addEventListener('change', function() {
        const date = this.value;
        window.location.href = `{{ route('attendance.index') }}?date=${date}`;
    });

    // Designation filter (CSR / Verification / Management / Admin Staff)
    function matchesAttendanceGroup(filter, designation, userType) {
        const des = String(designation || '').trim();
        const type = String(userType || '').trim();
        if (filter === 'all') return true;
        if (filter === 'CSR') return des === 'CSR';
        if (filter === 'Verification Officer') return des === 'Verification Officer';
        if (filter === 'Admin Staff') return type === 'admin';
        if (filter === 'Management') {
            if (type === 'admin') return false;
            if (type === 'management') return true;
            if (des === 'CSR' || des === 'Verification Officer') return false;
            return true;
        }
        return des === filter;
    }

    function getVisibleRows() {
        return Array.from(document.querySelectorAll('.attendance-row')).filter(row => !row.classList.contains('hidden'));
    }

    function updateSelectionUI() {
        const checked = Array.from(document.querySelectorAll('.row-select:checked')).filter(cb => {
            const row = cb.closest('.attendance-row');
            return row && !row.classList.contains('hidden');
        });
        const count = checked.length;
        const countEls = [document.getElementById('selected-count'), document.getElementById('selected-count-bar')];
        countEls.forEach(el => { if (el) el.textContent = String(count); });

        const markBtn = document.getElementById('mark-selected-btn');
        if (markBtn) markBtn.disabled = count === 0;

        const bar = document.getElementById('selected-mark-bar');
        if (bar) bar.classList.toggle('hidden', count === 0);

        const dateLabel = document.getElementById('selected-date-label');
        if (dateLabel) dateLabel.textContent = document.getElementById('attendance-date')?.value || '';

        const visibleChecks = getVisibleRows().map(row => row.querySelector('.row-select')).filter(Boolean);
        const selectAll = document.getElementById('select-all-attendance');
        if (selectAll) {
            const allChecked = visibleChecks.length > 0 && visibleChecks.every(cb => cb.checked);
            const someChecked = visibleChecks.some(cb => cb.checked);
            selectAll.checked = allChecked;
            selectAll.indeterminate = someChecked && !allChecked;
        }
    }

    function applyDesignationFilter() {
        const designation = document.getElementById('designation-filter')?.value || 'all';
        document.querySelectorAll('.attendance-row').forEach((row) => {
            const rowDes = row.getAttribute('data-designation') || '';
            const rowType = row.getAttribute('data-user-type') || '';
            const match = matchesAttendanceGroup(designation, rowDes, rowType);
            row.classList.toggle('hidden', !match);
            // Uncheck rows that are hidden by filter
            if (!match) {
                const cb = row.querySelector('.row-select');
                if (cb) cb.checked = false;
            }
        });
        updateSelectionUI();
    }
    document.getElementById('designation-filter')?.addEventListener('change', applyDesignationFilter);

    // Select all visible only
    document.getElementById('select-all-attendance')?.addEventListener('change', function() {
        const checked = this.checked;
        getVisibleRows().forEach((row) => {
            const cb = row.querySelector('.row-select');
            if (cb) cb.checked = checked;
        });
        updateSelectionUI();
    });

    document.querySelectorAll('.row-select').forEach((cb) => {
        cb.addEventListener('change', updateSelectionUI);
    });

    updateSelectionUI();

    function getSelectedUserIds() {
        return Array.from(document.querySelectorAll('.row-select:checked'))
            .filter(cb => {
                const row = cb.closest('.attendance-row');
                return row && !row.classList.contains('hidden');
            })
            .map(cb => Number(cb.value));
    }

    document.getElementById('mark-selected-btn')?.addEventListener('click', function() {
        const bar = document.getElementById('selected-mark-bar');
        if (bar) {
            bar.classList.remove('hidden');
            bar.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });

    document.getElementById('confirm-mark-selected-btn')?.addEventListener('click', function() {
        const userIds = getSelectedUserIds();
        if (!userIds.length) {
            showAlert('error', 'No employees selected');
            return;
        }

        const date = document.getElementById('attendance-date').value;
        const status = document.getElementById('selected-status').value;
        const checkIn = document.getElementById('selected-check-in').value;
        const checkOut = document.getElementById('selected-check-out').value;
        const remarks = document.getElementById('selected-remarks').value;
        const btn = this;
        const original = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Marking...';

        fetch('{{ route("attendance.bulk-mark") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                from_date: date,
                to_date: '',
                attendances: userIds.map(user_id => ({
                    user_id,
                    status,
                    check_in: checkIn || null,
                    check_out: checkOut || null,
                    remarks: remarks || null,
                })),
                _token: '{{ csrf_token() }}'
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.success || `Marked ${userIds.length} employee(s)`);
                setTimeout(() => window.location.reload(), 700);
            } else {
                showAlert('error', data.error || 'Failed to mark selected attendance');
            }
        })
        .catch(err => {
            console.error(err);
            showAlert('error', 'An error occurred while marking selected attendance');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = original;
        });
    });

    // Mark individual attendance
    function markAttendance(userId) {
        const status = document.querySelector(`select[data-user-id="${userId}"][data-field="status"]`).value;
        const checkIn = document.querySelector(`input[data-user-id="${userId}"][data-field="check_in"]`).value;
        const checkOut = document.querySelector(`input[data-user-id="${userId}"][data-field="check_out"]`).value;
        const remarks = document.querySelector(`input[data-user-id="${userId}"][data-field="remarks"]`).value;
        const date = document.getElementById('attendance-date').value;

        const data = {
            user_id: userId,
            attendance_date: date,
            status: status,
            check_in: checkIn || null,
            check_out: checkOut || null,
            remarks: remarks || null,
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route("attendance.mark") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
                if (data.success) {
                showAlert('success', 'Attendance marked successfully');
                
                // Update specific row elements (checkbox column shifted indices by +1)
                const row = document.querySelector(`select[data-user-id="${userId}"][data-field="status"]`).closest('tr');
                if (row) {
                    // Update Status Badge — show check-in time when present
                    const statusCell = row.cells[2];
                    const statusText = (data.attendance.check_in && String(data.attendance.check_in).trim() !== '')
                        ? String(data.attendance.check_in).substring(0, 5)
                        : data.attendance.status_label;
                    statusCell.innerHTML = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium whitespace-nowrap ${data.attendance.status_color}">
                                                ${statusText}
                                            </span>`;
                    
                    // Update Marked By
                    const markedByCell = row.cells[6];
                    markedByCell.innerHTML = `<span class="text-sm text-slate-600 dark:text-slate-300">${data.attendance.marked_by}</span>`;
                }
            } else {
                showAlert('error', data.error || 'Failed to mark attendance');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while marking attendance');
        });
    }

    // Prefill bulk modal employee IDs from table selection when opening Bulk Mark
    document.getElementById('bulk-mark-btn').addEventListener('click', function() {
        const currentDate = document.getElementById('attendance-date').value;
        document.getElementById('bulk-from-date').value = currentDate;
        // Leave "To Date" empty by default so only the From Date is marked unless a range is chosen.
        document.getElementById('bulk-to-date').value = '';
        const mainFilter = document.getElementById('designation-filter')?.value || 'all';
        const bulkFilter = document.getElementById('bulk-designation-filter');
        if (bulkFilter) bulkFilter.value = mainFilter;

        const selectedCodes = Array.from(document.querySelectorAll('.row-select:checked'))
            .filter(cb => {
                const row = cb.closest('.attendance-row');
                return row && !row.classList.contains('hidden');
            })
            .map(cb => cb.getAttribute('data-employee-id'))
            .filter(Boolean);
        const idsBox = document.getElementById('bulk-employee-ids');
        if (idsBox && selectedCodes.length) {
            idsBox.value = selectedCodes.join('\n');
            idsBox.dispatchEvent(new Event('input'));
        }

        document.getElementById('bulk-mark-modal').classList.remove('hidden');
    });

    function closeBulkMarkModal() {
        document.getElementById('bulk-mark-modal').classList.add('hidden');
    }

    // Global employee list
    const allEmployees = [
        @foreach($allEmployees ?? $employees as $employee)
        {
            user_id: {{ $employee->id }},
            employee_id: "{{ $employee->employee_id ?? '' }}",
            name: @json($employee->name),
            designation: @json($employee->designation ?? ''),
            user_type: @json($employee->user_type ?? '')
        },
        @endforeach
    ];

    function getDesignationFilteredEmployees() {
        const designation = document.getElementById('bulk-designation-filter')?.value
            || document.getElementById('designation-filter')?.value
            || 'all';
        if (designation === 'all') return allEmployees;
        return allEmployees.filter(emp => matchesAttendanceGroup(designation, emp.designation, emp.user_type));
    }

    // Real-time Employee filtering
    document.getElementById('bulk-employee-ids').addEventListener('input', function() {
        const input = this.value;
        const targetIds = input.split(/[\n, ]+/).map(id => id.trim()).filter(id => id);
        const container = document.getElementById('matched-employees-container');
        
        container.innerHTML = '';
        
        if (targetIds.length > 0) {
            const lowerTargetIds = targetIds.map(id => id.toLowerCase());
            const pool = getDesignationFilteredEmployees();
            
            // Find matches (case-insensitive)
            const matchedEmployees = pool.filter(emp => 
                emp.employee_id && lowerTargetIds.includes(emp.employee_id.toLowerCase())
            );
            
            matchedEmployees.forEach(emp => {
                const badge = document.createElement('div');
                badge.className = 'px-3 py-1 text-xs font-medium text-blue-600 bg-blue-500/10 backdrop-blur-sm rounded-full border border-blue-500/20 dark:text-blue-400 dark:bg-blue-500/20';
                badge.textContent = `${emp.name} (${emp.employee_id})`;
                container.appendChild(badge);
            });
            
            if (matchedEmployees.length === 0) {
                 const noMatch = document.createElement('span');
                 noMatch.className = 'text-xs text-slate-500 italic';
                 noMatch.textContent = 'No matching employees found';
                 container.appendChild(noMatch);
            }
        }
    });

    document.getElementById('bulk-designation-filter')?.addEventListener('change', function() {
        document.getElementById('bulk-employee-ids').dispatchEvent(new Event('input'));
    });

    // Handle status change to hide/show fields
    document.getElementById('bulk-status').addEventListener('change', function() {
        if(this.value === 'DELETE') {
            document.getElementById('bulk-time-fields').style.display = 'none';
            document.querySelector('#bulk-mark-form button[type="submit"]').textContent = 'Delete Records';
            document.querySelector('#bulk-mark-form button[type="submit"]').classList.replace('bg-custom-500', 'bg-red-500');
            document.querySelector('#bulk-mark-form button[type="submit"]').classList.replace('border-custom-500', 'border-red-500');
        } else {
            document.getElementById('bulk-time-fields').style.display = 'block';
            document.querySelector('#bulk-mark-form button[type="submit"]').textContent = 'Mark All';
            document.querySelector('#bulk-mark-form button[type="submit"]').classList.replace('bg-red-500', 'bg-custom-500');
            document.querySelector('#bulk-mark-form button[type="submit"]').classList.replace('border-red-500', 'border-custom-500');
        }
    });

    // Bulk mark form handler
    document.getElementById('bulk-mark-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const status = document.getElementById('bulk-status').value;
        const confirmMsg = status === 'DELETE' ? 'Are you sure you want to DELETE attendance records for the selected range?' : null;
        
        if (confirmMsg && !confirm(confirmMsg)) return;

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnContent = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i> Processing...';
        submitBtn.disabled = true;
        if (typeof lucide !== 'undefined') lucide.createIcons();

        const fromDate = document.getElementById('bulk-from-date').value;
        const toDate = document.getElementById('bulk-to-date').value;
        const employeeIdsInput = document.getElementById('bulk-employee-ids').value;
        const targetIds = employeeIdsInput.split(/[\n, ]+/).map(id => id.trim()).filter(id => id);
        
        // Filter employees if IDs are provided, otherwise use designation-filtered pool
        let filteredEmployees = getDesignationFilteredEmployees();
        
        if (targetIds.length > 0) {
            const lowerTargetIds = targetIds.map(id => id.toLowerCase());
            filteredEmployees = filteredEmployees.filter(emp => 
                emp.employee_id && lowerTargetIds.includes(emp.employee_id.toLowerCase())
            );
        }

        if (filteredEmployees.length === 0) {
            showAlert('error', 'No matching employees found for the selected filter/IDs');
            submitBtn.innerHTML = originalBtnContent;
            submitBtn.disabled = false;
            if (typeof lucide !== 'undefined') lucide.createIcons();
            return;
        }

        let url, body;

        if (status === 'DELETE') {
            url = '{{ route("attendance.bulk-delete") }}';
            body = {
                from_date: fromDate,
                to_date: toDate,
                user_ids: filteredEmployees.map(emp => emp.user_id),
                _token: '{{ csrf_token() }}'
            };
        } else {
            const checkIn = document.getElementById('bulk-check-in').value;
            const checkOut = document.getElementById('bulk-check-out').value;
            const remarks = document.getElementById('bulk-remarks').value;

            url = '{{ route("attendance.bulk-mark") }}';
            body = {
                from_date: fromDate,
                to_date: toDate,
                attendances: filteredEmployees.map(emp => ({
                    user_id: emp.user_id,
                    status: status,
                    check_in: checkIn || null,
                    check_out: checkOut || null,
                    remarks: remarks || null
                })),
                _token: '{{ csrf_token() }}'
            };
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(body)
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.innerHTML = originalBtnContent;
            submitBtn.disabled = false;
            if (typeof lucide !== 'undefined') lucide.createIcons();

            if (data.success) {
                if (data.warnings && data.warnings.length > 0) {
                    let warningMsg = `${data.success}<br><br><strong>Warning: Some employees were skipped:</strong><ul class="list-disc pl-5 mt-2 text-left text-sm text-yellow-700 bg-yellow-50 p-2 rounded max-h-40 overflow-y-auto">`;
                    data.warnings.forEach(w => {
                        warningMsg += `<li>${w}</li>`;
                    });
                    warningMsg += '</ul>';
                    
                    const alertDiv = document.createElement('div');
                    alertDiv.className = `fixed top-4 right-4 z-[60] p-6 rounded-md shadow-lg bg-white border border-yellow-400 text-slate-800 max-w-md`;
                    alertDiv.innerHTML = warningMsg + '<button class="absolute top-2 right-2 text-slate-400 hover:text-slate-600" onclick="this.parentElement.remove()"><i data-lucide="x" class="w-4 h-4"></i></button>';
                    document.body.appendChild(alertDiv);
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                } else {
                    showAlert('success', data.success);
                    // Also show a temporary success message in the modal itself for better visibility
                    const modalBody = document.querySelector('#bulk-mark-modal .bg-white');
                    const successMsg = document.createElement('div');
                    successMsg.className = 'mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm flex items-center';
                    successMsg.innerHTML = '<i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Attendance marked successfully!';
                    if(modalBody) {
                        const form = document.getElementById('bulk-mark-form');
                        modalBody.insertBefore(successMsg, form);
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                        setTimeout(() => successMsg.remove(), 3000);
                    }
                }
                
                // Do NOT close modal or reload page as requested
            } else {
                showAlert('error', data.error || 'Failed to mark attendance');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while marking attendance');
            submitBtn.innerHTML = originalBtnContent;
            submitBtn.disabled = false;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    });

    // Alert function
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        alertDiv.textContent = message;
        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
    // Cleanup Invalid Records Button
    const cleanupBtn = document.getElementById('cleanup-btn');
    if (cleanupBtn) {
        cleanupBtn.addEventListener('click', function() {
            const btn = this; // Capture this explicitly
            const originalContent = btn.innerHTML;
            
            // Show loading
            btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i> Checking...';
            btn.disabled = true;
            if (typeof lucide !== 'undefined') lucide.createIcons();

            fetch("{{ route('attendance.invalid-records') }}")
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                btn.innerHTML = originalContent;
                btn.disabled = false;
                if (typeof lucide !== 'undefined') lucide.createIcons();

                if (data.success) {
                    if (data.records.length === 0) {
                        showAlert('success', 'No invalid records found!');
                        return;
                    }

                    // Populate modal
                    const tbody = document.getElementById('cleanup-list-body');
                    if (tbody) {
                        tbody.innerHTML = '';
                        data.records.forEach(record => {
                            tbody.innerHTML += `
                                <tr>
                                    <td class="px-4 py-2 font-medium text-slate-900 dark:text-white">${record.name} (${record.employee_id})</td>
                                    <td class="px-4 py-2">${record.attendance_date}</td>
                                    <td class="px-4 py-2 text-red-500">${record.reason}</td>
                                </tr>
                            `;
                        });
                    }

                    // Show modal
                    const modal = document.getElementById('cleanup-modal');
                    if (modal) modal.classList.remove('hidden');
                } else {
                    showAlert('error', data.error || 'Failed to fetch records');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'An error occurred. Check console for details.');
                btn.innerHTML = originalContent;
                btn.disabled = false;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        });
    }

    function closeCleanupModal() {
        const modal = document.getElementById('cleanup-modal');
        if (modal) modal.classList.add('hidden');
    }

    // Confirm Cleanup Proceed
    const confirmCleanupBtn = document.getElementById('confirm-cleanup-btn');
    if (confirmCleanupBtn) {
        confirmCleanupBtn.addEventListener('click', function() {
            const btn = this;
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i> Deleting...';
            btn.disabled = true;
            if (typeof lucide !== 'undefined') lucide.createIcons();

            fetch("{{ route('attendance.cleanup') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeCleanupModal();
                    showAlert('success', data.message);
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showAlert('error', data.error || 'Failed to cleanup records');
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'An error occurred during cleanup');
                btn.innerHTML = originalContent;
                btn.disabled = false;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        });
    }

    function deleteAttendance(id) {
        if(confirm('Are you sure you want to delete this attendance record?')) {
            fetch(`/attendance/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showAlert('success', 'Attendance deleted successfully');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showAlert('error', data.error || 'Failed to delete attendance');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'An error occurred');
            });
        }
    }
</script>
@endsection
