@extends('layouts.master')
@section('title') Attendance Report @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Attendance Report</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="#!" class="text-slate-400 dark:text-zink-200">Attendance</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Report</li>
            </ul>
        </div>
        
        <!-- Filters -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <input type="month" id="report-month" value="{{ $selectedMonth }}" class="form-input dark:bg-zink-700 dark:border-zink-500 dark:text-zink-200">
                </div>
                <div class="relative">
                    <select id="designation-filter" class="form-select dark:bg-zink-700 dark:border-zink-500 dark:text-zink-200">
                        <option value="all">All Designations</option>
                        <option value="CSR">CSR</option>
                        <option value="Verification Officer">Verification Officer</option>
                        <option value="Management">Management</option>
                        <option value="Admin Staff">Admin Staff</option>
                    </select>
                </div>
                <div class="relative">
                    <select id="employee-filter" class="form-select dark:bg-zink-700 dark:border-zink-500 dark:text-zink-200">
                        <option value="">All Employees</option>
                        @foreach($allEmployees as $employee)
                            <option value="{{ $employee->id }}"
                                data-designation="{{ $employee->designation ?? '' }}"
                                data-user-type="{{ $employee->user_type ?? '' }}"
                                {{ $selectedEmployee == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }} ({{ $employee->employee_id ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="exportReport()" class="btn bg-green-500 text-white border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                    Export Report
                </button>
            </div>
        </div>
            
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center">
                                <i data-lucide="calendar" class="w-6 h-6 text-blue-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 ms-3">
                            <p class="text-slate-500 dark:text-zink-400 text-sm font-medium">Total Days</p>
                            <h3 class="text-slate-900 dark:text-slate-200 text-xl font-semibold">{{ round($monthlyStats['total_days']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-500/20 flex items-center justify-center">
                                <i data-lucide="user-check" class="w-6 h-6 text-green-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 ms-3">
                            <p class="text-slate-500 dark:text-zink-400 text-sm font-medium">Present Days</p>
                            <h3 class="text-slate-900 dark:text-slate-200 text-xl font-semibold">{{ $monthlyStats['present'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center">
                                <i data-lucide="user-x" class="w-6 h-6 text-red-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 ms-3">
                            <p class="text-slate-500 dark:text-zink-400 text-sm font-medium">Absent Days</p>
                            <h3 class="text-slate-900 dark:text-slate-200 text-xl font-semibold">{{ $monthlyStats['absent'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-500/20 flex items-center justify-center">
                                <i data-lucide="trending-up" class="w-6 h-6 text-purple-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 ms-3">
                            <p class="text-slate-500 dark:text-zink-400 text-sm font-medium">Attendance Rate</p>
                            <h3 class="text-slate-900 dark:text-slate-200 text-xl font-semibold">{{ $monthlyStats['attendance_rate'] }}%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Report Table -->
        <div class="card">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500 dark:text-zink-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-zink-600 dark:text-zink-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">Employee</th>
                                <th scope="col" class="px-6 py-3">Present</th>
                                <th scope="col" class="px-6 py-3">Absent</th>
                                <th scope="col" class="px-6 py-3">Half Day</th>
                                <th scope="col" class="px-6 py-3">Unpaid</th>
                                <th scope="col" class="px-6 py-3">NCNS</th>
                                <th scope="col" class="px-6 py-3">Holiday</th>
                                <th scope="col" class="px-6 py-3">Total Days</th>
                                <th scope="col" class="px-6 py-3">Attendance Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                @php
                                    $employeeAttendances = $attendances->get($employee->id, collect());
                                    $present = $employeeAttendances->where('status', 'P')->count();
                                    $absent = $employeeAttendances->where('status', 'A')->count();
                                    $halfDay = $employeeAttendances->where('status', 'H')->count();
                                    $unpaid = $employeeAttendances->where('status', 'U')->count();
                                    $ncns = $employeeAttendances->where('status', 'NCNS')->count();
                                    $holiday = $employeeAttendances->where('status', 'HOLIDAY')->count();
                                    $totalDays = $employeeAttendances->count();
                                    $attendanceRate = $totalDays > 0 ? round(($present / $totalDays) * 100, 2) : 0;
                                @endphp
                                <tr class="bg-white border-b dark:bg-zink-700 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600 report-row"
                                    data-designation="{{ $employee->designation ?? '' }}"
                                    data-user-type="{{ $employee->user_type ?? '' }}"
                                    data-employee-id="{{ $employee->id }}">
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
                                                <div class="text-sm font-medium text-slate-900 dark:text-zink-100">
                                                    {{ $employee->name }}
                                                </div>
                                                <div class="text-sm text-slate-500 dark:text-zink-400">
                                                    {{ $employee->employee_id ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-green-600 bg-green-100 dark:bg-green-500/20 dark:text-green-400">
                                            {{ $present }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-red-600 bg-red-100 dark:bg-red-500/20 dark:text-red-400">
                                            {{ $absent }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-yellow-600 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-400">
                                            {{ $halfDay }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-orange-600 bg-orange-100 dark:bg-orange-500/20 dark:text-orange-400">
                                            {{ $unpaid }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-purple-600 bg-purple-100 dark:bg-purple-500/20 dark:text-purple-400">
                                            {{ $ncns }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-blue-600 bg-blue-100 dark:bg-blue-500/20 dark:text-blue-400">
                                            {{ $holiday }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-slate-900 dark:text-zink-100">
                                            {{ $totalDays }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attendanceRate >= 80 ? 'text-green-600 bg-green-100 dark:bg-green-500/20 dark:text-green-400' : ($attendanceRate >= 60 ? 'text-yellow-600 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-400' : 'text-red-600 bg-red-100 dark:bg-red-500/20 dark:text-red-400') }}">
                                            {{ $attendanceRate }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-slate-500 dark:text-zink-400">
                                        No attendance data found for the selected period
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <!-- Daily Attendance Detail -->
        <div class="card mt-6">
            <div class="card-body">
                <h6 class="mb-4 text-15 dark:text-zink-100">Daily Attendance Detail</h6>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500 dark:text-zink-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-zink-600 dark:text-zink-300">
                            <tr>
                                <th scope="col" class="px-6 py-3 min-w-[200px] sticky left-0 z-10 bg-slate-50 dark:bg-zink-600 border border-slate-200 dark:border-zink-500">Employee</th>
                                @php
                                    $daysInMonth = $endDate->day;
                                    $currentMonth = $startDate->format('Y-m');
                                @endphp
                                @for($i = 1; $i <= $daysInMonth; $i++)
                                    <th scope="col" class="px-2 py-3 text-center min-w-[72px] border border-slate-200 dark:border-zink-500 whitespace-nowrap">
                                        {{ $i }} {{ $startDate->format('M') }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                @php
                                    // Key attendances by date (Y-m-d) for O(1) lookup
                                    $employeeAttendances = $attendances->get($employee->id, collect());
                                    $attendanceMap = [];
                                    foreach($employeeAttendances as $att) {
                                        // Ensure attendance_date is a string 'Y-m-d'
                                        $dateKey = \Carbon\Carbon::parse($att->attendance_date)->format('j'); // Day of month (1-31)
                                        $attendanceMap[$dateKey] = $att;
                                    }
                                @endphp
                                <tr class="bg-white border-b dark:bg-zink-700 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600 report-row"
                                    data-designation="{{ $employee->designation ?? '' }}"
                                    data-user-type="{{ $employee->user_type ?? '' }}"
                                    data-employee-id="{{ $employee->id }}">
                                    <td class="px-6 py-4 sticky left-0 z-10 bg-white dark:bg-zink-700 border border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-8 h-8">
                                                <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-zink-600 flex items-center justify-center">
                                                    <span class="text-xs font-medium text-slate-800 dark:text-zink-200">
                                                        @php
                                                            $initials = collect(explode(' ', $employee->name))->map(fn($part) => strtoupper(substr($part, 0, 1)))->join('');
                                                        @endphp
                                                        {{ $initials }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ms-2">
                                                <div class="text-xs font-medium text-slate-900 dark:text-zink-100">
                                                    {{ $employee->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @for($i = 1; $i <= $daysInMonth; $i++)
                                        @php
                                            $att = $attendanceMap[$i] ?? null;
                                            $currentDate = \Carbon\Carbon::createFromDate($startDate->year, $startDate->month, $i);
                                            $isSaturday = $currentDate->isSaturday();
                                            $isSunday = $currentDate->isSunday();
                                            
                                            $status = $att ? $att->status : '-';
                                            $colorClass = '';
                                            switch($status) {
                                                case 'P': $colorClass = 'text-green-600 bg-green-100 dark:bg-green-500/20 dark:text-green-400'; break;
                                                case 'A': $colorClass = 'text-red-600 bg-red-100 dark:bg-red-500/20 dark:text-red-400'; break;
                                                case 'H': $colorClass = 'text-yellow-600 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-400'; break;
                                                case 'U': $colorClass = 'text-orange-600 bg-orange-100 dark:bg-orange-500/20 dark:text-orange-400'; break;
                                                case 'NCNS': $colorClass = 'text-purple-600 bg-purple-100 dark:bg-purple-500/20 dark:text-purple-400'; break;
                                                case 'HOLIDAY': $colorClass = 'text-blue-600 bg-blue-100 dark:bg-blue-500/20 dark:text-blue-400'; $status = 'HOL'; break;
                                            }
                                        @endphp
                                        <td class="px-2 py-4 border border-slate-200 dark:border-zink-500">
                                            <div class="flex items-center justify-center w-full h-full">
                                                @if($att)
                                                    @php
                                                        $checkInTime = $att->check_in_input;
                                                        $showTime = $checkInTime !== '';
                                                        $statusLabel = match($att->status) {
                                                            'P' => 'Present',
                                                            'A' => 'Absent',
                                                            'H' => 'Half Day',
                                                            'U' => 'Unpaid',
                                                            'NCNS' => 'NCNS',
                                                            'HOLIDAY', 'HOL' => 'Holiday',
                                                            default => $status
                                                        };
                                                        $cellText = $showTime ? $checkInTime : $statusLabel;
                                                        $cellTitle = $showTime
                                                            ? trim(($att->attendance_date ?? '') . ' · ' . $statusLabel . ' · in ' . $checkInTime)
                                                            : trim(($att->attendance_date ?? '') . ' · ' . $statusLabel);
                                                    @endphp
                                                    <span class="flex items-center justify-center px-2 py-1 rounded text-[10px] font-bold whitespace-nowrap {{ $colorClass }}" title="{{ $cellTitle }}">
                                                        {{ $cellText }}
                                                    </span>
                                                @elseif($isSaturday)
                                                    <span class="text-slate-400 dark:text-zink-400 font-medium text-xs">Sat</span>
                                                @elseif($isSunday)
                                                    <span class="text-red-400 dark:text-red-400/80 font-medium text-xs">Sun</span>
                                                @else
                                                    <span class="text-slate-300 dark:text-zink-500">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $daysInMonth + 1 }}" class="px-6 py-4 text-center text-slate-500 dark:text-zink-400">
                                        No employees found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
@endsection

@section('script')
<script>
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

    function applyReportFilters() {
        const designation = document.getElementById('designation-filter')?.value || 'all';
        const employeeId = document.getElementById('employee-filter')?.value || '';

        // Filter employee dropdown options by designation group
        document.querySelectorAll('#employee-filter option[data-user-type], #employee-filter option[data-designation]').forEach((opt) => {
            if (!opt.value) return;
            const matchDes = matchesAttendanceGroup(
                designation,
                opt.getAttribute('data-designation') || '',
                opt.getAttribute('data-user-type') || ''
            );
            opt.hidden = !matchDes;
        });

        document.querySelectorAll('.report-row').forEach((row) => {
            const rowDes = row.getAttribute('data-designation') || '';
            const rowType = row.getAttribute('data-user-type') || '';
            const rowEmp = row.getAttribute('data-employee-id') || '';
            const matchDes = matchesAttendanceGroup(designation, rowDes, rowType);
            const matchEmp = !employeeId || rowEmp === employeeId;
            row.classList.toggle('hidden', !(matchDes && matchEmp));
        });
    }

    // Month change handler
    document.getElementById('report-month').addEventListener('change', function() {
        const month = this.value;
        const employee = document.getElementById('employee-filter').value;
        const url = new URL(window.location);
        url.searchParams.set('month', month);
        if (employee) {
            url.searchParams.set('employee_id', employee);
        } else {
            url.searchParams.delete('employee_id');
        }
        window.location.href = url.toString();
    });

    // Employee filter change handler
    document.getElementById('employee-filter').addEventListener('change', function() {
        applyReportFilters();
    });

    document.getElementById('designation-filter')?.addEventListener('change', function() {
        // Clear employee selection if it no longer matches designation
        const empSelect = document.getElementById('employee-filter');
        const selected = empSelect.options[empSelect.selectedIndex];
        if (selected && selected.value && selected.hidden) {
            empSelect.value = '';
        }
        applyReportFilters();
    });

    applyReportFilters();

    // Export report function
    function exportReport() {
        const month = document.getElementById('report-month').value;
        const employee = document.getElementById('employee-filter').value;
        
        let url = '{{ route("attendance.report") }}?export=1&month=' + month;
        if (employee) {
            url += '&employee_id=' + employee;
        }
        
        window.open(url, '_blank');
    }
</script>
@endsection
