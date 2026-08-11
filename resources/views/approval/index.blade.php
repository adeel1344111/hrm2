@extends('layouts.master')
@section('title') Approval @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Approval</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('home') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Approval</li>
            </ul>
        </div>
        
        <!-- Approval Form -->
        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Phone Number Approval</h6>
                        <p class="text-slate-500 dark:text-zink-200">Enter phone numbers to check against submissions</p>
                    </div>
                </div>

                <form action="{{ route('approval.process') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-5 lg:grid-cols-4">
                        <!-- Date Range -->
                        <div>
                            <label for="from_date" class="inline-block mb-2 text-base font-medium">From Date <span class="text-red-500">*</span></label>
                            <input type="date" id="from_date" name="from_date" value="{{ old('from_date', $fromDate ?? '') }}" 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" required>
                            @error('from_date')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="to_date" class="inline-block mb-2 text-base font-medium">To Date <span class="text-red-500">*</span></label>
                            <input type="date" id="to_date" name="to_date" value="{{ old('to_date', $toDate ?? '') }}" 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" required>
                            @error('to_date')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Designation -->
                        <div>
                            <label for="designation" class="inline-block mb-2 text-base font-medium">Designation <span class="text-red-500">*</span></label>
                            <select id="designation" name="designation" 
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" required>
                                <option value="">Select Designation</option>
                                <option value="Verification Officer" {{ (old('designation', $designation ?? '') === 'Verification Officer') ? 'selected' : '' }}>Verification Officer</option>
                                <option value="CSR" {{ (old('designation', $designation ?? '') === 'CSR') ? 'selected' : '' }}>CSR</option>
                                <option value="Outsource" {{ (old('designation', $designation ?? '') === 'Outsource') ? 'selected' : '' }}>Outsource</option>
                            </select>
                            @error('designation')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="campaign" class="inline-block mb-2 text-base font-medium">Campaign <span class="text-red-500">*</span></label>
                            <select id="campaign" name="campaign" 
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" required>
                                <option value="">Select Campaign</option>
                                @foreach($campaigns as $campaignOption)
                                <option value="{{ $campaignOption }}" {{ (old('campaign', $campaign ?? '') === $campaignOption) ? 'selected' : '' }}>
                                    {{ $campaignOption }}
                                </option>
                                @endforeach
                            </select>
                            @error('campaign')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone Numbers Input -->
                    <div class="mt-5">
                        <label for="phone_numbers" class="inline-block mb-2 text-base font-medium">Phone Numbers <span class="text-red-500">*</span></label>
                        <textarea id="phone_numbers" name="phone_numbers" rows="8" 
                                  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                  placeholder="Enter phone numbers (one per line):&#10;1234567890&#10;1234567890&#10;1234567890" required>{{ old('phone_numbers', $phoneNumbersText ?? '') }}</textarea>
                        <p class="mt-1 text-sm text-slate-500 dark:text-zink-400">Enter one phone number per line</p>
                        @error('phone_numbers')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap gap-2 mt-6">
                        <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            <i data-lucide="search" class="w-4 h-4 mr-1"></i>
                            Process Numbers
                        </button>
                        <button type="submit"
                                formaction="{{ route('approval.stats') }}"
                                formnovalidate
                                class="text-white btn bg-emerald-500 border-emerald-500 hover:text-white hover:bg-emerald-600 hover:border-emerald-600 focus:text-white focus:bg-emerald-600 focus:border-emerald-600 focus:ring focus:ring-emerald-100 active:text-white active:bg-emerald-600 active:border-emerald-600 active:ring active:ring-emerald-100 dark:ring-emerald-400/20">
                            <i data-lucide="bar-chart-3" class="w-4 h-4 mr-1"></i>
                            Check Stats
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(!empty($showStats) && isset($stats))
        <!-- Submission Stats Section -->
        <div class="card mt-6" id="approval-stats-card">
            <div class="card-body">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
                    <div>
                        <h6 class="text-lg font-semibold text-slate-800 dark:text-zink-100 flex items-center">
                            <i data-lucide="bar-chart-3" class="w-5 h-5 mr-2 text-emerald-500"></i>
                            Submission Stats
                        </h6>
                        <p class="text-sm text-slate-500 dark:text-zink-300 mt-1">
                            {{ $designation }} · {{ $campaign }} · {{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }}
                            @if($fromDate !== $toDate)
                                – {{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                    <button type="button" id="toggle-approval-stats"
                            class="btn bg-slate-100 border-slate-200 text-slate-700 hover:bg-slate-200 dark:bg-zink-600 dark:border-zink-500 dark:text-zink-100 dark:hover:bg-zink-500">
                        <i data-lucide="eye-off" class="w-4 h-4 mr-1" id="toggle-approval-stats-icon"></i>
                        <span id="toggle-approval-stats-label">Hide</span>
                    </button>
                </div>

                <div id="approval-stats-body">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
                        <div class="card border border-slate-200 dark:border-zink-500 shadow-none">
                            <div class="card-body text-center">
                                <h6 class="text-3xl font-bold text-emerald-600 mb-1">{{ $stats['total_forms'] }}</h6>
                                <p class="text-slate-600 dark:text-zink-300 font-medium">Total Forms</p>
                                <p class="text-xs text-slate-500 dark:text-zink-400 mt-1">Submitted in range</p>
                            </div>
                        </div>
                        <div class="card border border-slate-200 dark:border-zink-500 shadow-none">
                            <div class="card-body text-center">
                                <h6 class="text-3xl font-bold text-blue-600 mb-1">{{ $stats['unique_phones'] }}</h6>
                                <p class="text-slate-600 dark:text-zink-300 font-medium">Unique Phones</p>
                                <p class="text-xs text-slate-500 dark:text-zink-400 mt-1">Distinct numbers</p>
                            </div>
                        </div>
                        <div class="card border border-slate-200 dark:border-zink-500 shadow-none">
                            <div class="card-body text-center">
                                <h6 class="text-3xl font-bold text-yellow-600 mb-1">{{ $stats['duplicate_phones'] }}</h6>
                                <p class="text-slate-600 dark:text-zink-300 font-medium">Duplicate Phones</p>
                                <p class="text-xs text-slate-500 dark:text-zink-400 mt-1">Phones with 2+ forms</p>
                            </div>
                        </div>
                        <div class="card border border-slate-200 dark:border-zink-500 shadow-none">
                            <div class="card-body text-center">
                                <h6 class="text-3xl font-bold text-purple-600 mb-1">{{ $stats['unique_agents'] }}</h6>
                                <p class="text-slate-600 dark:text-zink-300 font-medium">{{ ($designation ?? '') === 'Outsource' ? 'Agents / Dialers' : 'Employees' }}</p>
                                <p class="text-xs text-slate-500 dark:text-zink-400 mt-1">Who submitted</p>
                            </div>
                        </div>
                    </div>

                    @if($stats['by_agent']->count() > 0)
                    <div class="mb-6">
                        <h6 class="text-sm font-semibold text-slate-700 dark:text-zink-200 mb-3">Top submitters</h6>
                        <div class="flex flex-wrap gap-2">
                            @foreach($stats['by_agent'] as $agentKey => $count)
                                @php
                                    $parts = explode('|', $agentKey, 2);
                                    $label = trim(($parts[0] ?? '') . ' — ' . ($parts[1] ?? ''));
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700 dark:bg-zink-600 dark:text-zink-100">
                                    {{ $label }} <strong class="ml-1">{{ $count }}</strong>
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($stats['truncated']))
                    <div class="mb-4 text-sm text-amber-600 dark:text-amber-400">
                        Showing first 2,000 forms. Narrow the date range if you need more.
                    </div>
                    @endif

                    <div class="flex items-center justify-between mb-3">
                        <h6 class="text-sm font-semibold text-slate-700 dark:text-zink-200">
                            All submitted forms ({{ $stats['total_forms'] }})
                        </h6>
                        <button type="button" id="toggle-approval-stats-table"
                                class="text-sm text-custom-500 hover:text-custom-600 dark:text-custom-400">
                            Hide table
                        </button>
                    </div>

                    <div id="approval-stats-table-wrap" class="overflow-x-auto max-h-[32rem] overflow-y-auto border border-slate-200 dark:border-zink-500 rounded-md">
                        <table class="w-full text-sm">
                            <thead class="sticky top-0">
                                <tr class="bg-slate-100 dark:bg-zink-600">
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">#</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Phone</th>
                                    @if(($designation ?? '') === 'Outsource')
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Dialer ID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Agent Name</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Company</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">State</th>
                                    @else
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">DID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Employee ID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Employee</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Team Lead</th>
                                    @endif
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Campaign</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Comment</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['submissions'] as $i => $submission)
                                <tr class="border-b border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600/50">
                                    <td class="px-4 py-3 text-slate-700 dark:text-zink-300">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-slate-900 dark:text-zink-100">{{ $submission->phone }}</td>
                                    @if(($designation ?? '') === 'Outsource')
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->dialer_id ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->company ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->state ?? 'N/A' }}</td>
                                    @else
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->did ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->employee_id }}</td>
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->employee_name }}</td>
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->team_lead_name }}</td>
                                    @endif
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->campaign }}</td>
                                    <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ Str::limit($submission->comment, 40) }}</td>
                                    <td class="px-4 py-3 text-slate-500 dark:text-zink-400">{{ $submission->created_at?->format('M d, Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-8 text-center text-slate-500 dark:text-zink-400">
                                        No forms found for this date / campaign / designation.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            (function () {
                const body = document.getElementById('approval-stats-body');
                const toggleBtn = document.getElementById('toggle-approval-stats');
                const label = document.getElementById('toggle-approval-stats-label');
                const tableWrap = document.getElementById('approval-stats-table-wrap');
                const tableToggle = document.getElementById('toggle-approval-stats-table');
                if (!body || !toggleBtn) return;

                let sectionOpen = true;
                let tableOpen = true;

                toggleBtn.addEventListener('click', function () {
                    sectionOpen = !sectionOpen;
                    body.classList.toggle('hidden', !sectionOpen);
                    label.textContent = sectionOpen ? 'Hide' : 'Show';
                    if (window.lucide) window.lucide.createIcons();
                });

                if (tableToggle && tableWrap) {
                    tableToggle.addEventListener('click', function () {
                        tableOpen = !tableOpen;
                        tableWrap.classList.toggle('hidden', !tableOpen);
                        tableToggle.textContent = tableOpen ? 'Hide table' : 'Show table';
                    });
                }
            })();
        </script>
        @endif

        @if(isset($results))
        <!-- Results Section -->
        <div class="mt-6">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
                <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-3xl font-bold text-blue-600 mb-2">{{ $results['total_input'] }}</h6>
                            <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Input</p>
                            <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Phone numbers entered</p>
                            <div class="flex items-center justify-center text-blue-500 text-sm">
                                <i data-lucide="phone" class="w-4 h-4 mr-1"></i>
                                <span>Input</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-3xl font-bold text-green-600 mb-2">{{ $results['total_found'] }}</h6>
                            <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Found</p>
                            <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Numbers in submissions</p>
                            <div class="flex items-center justify-center text-green-500 text-sm">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                                <span>{{ $results['total_input'] > 0 ? round(($results['total_found'] / $results['total_input']) * 100) : 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-3xl font-bold text-yellow-600 mb-2">{{ $results['total_duplicates'] }}</h6>
                            <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Duplicates</p>
                            <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Repeated numbers</p>
                            <div class="flex items-center justify-center text-yellow-500 text-sm">
                                <i data-lucide="copy" class="w-4 h-4 mr-1"></i>
                                <span>Duplicates</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-3xl font-bold text-red-600 mb-2">{{ $results['total_unmatched'] }}</h6>
                            <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Unmatched</p>
                            <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Not found in submissions</p>
                            <div class="flex items-center justify-center text-red-500 text-sm">
                                <i data-lucide="x-circle" class="w-4 h-4 mr-1"></i>
                                <span>{{ $results['total_input'] > 0 ? round(($results['total_unmatched'] / $results['total_input']) * 100) : 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Found Numbers Section -->
            @if($results['found_submissions']->count() > 0)
            <div class="card mt-6">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <h6 class="text-lg font-semibold text-green-600 dark:text-green-400 flex items-center">
                            <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                            Found Numbers ({{ $results['total_found'] }})
                        </h6>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-zink-600">
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">#</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Phone Number</th>
                                    @if(($designation ?? '') === 'Outsource')
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Dialer ID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Agent Name</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Company</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">State</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Zip</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Age</th>
                                    @else
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">DID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Jornaya ID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Employee ID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Employee</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Team Lead</th>
                                    @endif
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Campaign</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Comment</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1; @endphp
                                @foreach($results['found_submissions'] as $phone => $submissions)
                                    @foreach($submissions as $submission)
                                    <tr class="border-b border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600/50">
                                        <td class="px-4 py-3 text-slate-700 dark:text-zink-300">{{ $index++ }}</td>
                                        <td class="px-4 py-3">
                                            <span class="font-medium text-green-600 dark:text-green-400">{{ $phone }}</span>
                                        </td>
                                        @if(($designation ?? '') === 'Outsource')
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->dialer_id ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->company ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->state ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->zip ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->age ?? 'N/A' }}</td>
                                        @else
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->did ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ Str::limit($submission->jornaya_id ?? 'N/A', 20) }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->employee_id }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->employee_name }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->team_lead_name }}</td>
                                        @endif
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->campaign }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ Str::limit($submission->comment, 50) }}</td>
                                        <td class="px-4 py-3 text-slate-500 dark:text-zink-400">{{ $submission->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Duplicate Numbers Section -->
            @if($results['duplicate_numbers']->count() > 0)
            <div class="card mt-6">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <h6 class="text-lg font-semibold text-yellow-600 dark:text-yellow-400 flex items-center">
                            <i data-lucide="copy" class="w-5 h-5 mr-2"></i>
                            Duplicate Numbers ({{ $results['total_duplicates'] }})
                        </h6>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-zink-600">
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">#</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Phone Number</th>
                                    @if(($designation ?? '') === 'Outsource')
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Dialer ID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Agent Name</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Company</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">State</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Zip</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Age</th>
                                    @else
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">DID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Jornaya ID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Employee ID</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Employee</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Team Lead</th>
                                    @endif
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Campaign</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Comment</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1; @endphp
                                @foreach($results['duplicate_numbers'] as $phone => $submissions)
                                    @foreach($submissions as $submission)
                                    <tr class="border-b border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600/50">
                                        <td class="px-4 py-3 text-slate-700 dark:text-zink-300">{{ $index++ }}</td>
                                        <td class="px-4 py-3">
                                            <span class="font-medium text-yellow-600 dark:text-yellow-400">{{ $phone }}</span>
                                        </td>
                                        @if(($designation ?? '') === 'Outsource')
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->dialer_id ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->company ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->state ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->zip ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->age ?? 'N/A' }}</td>
                                        @else
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->did ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ Str::limit($submission->jornaya_id ?? 'N/A', 20) }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->employee_id }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->employee_name }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->team_lead_name }}</td>
                                        @endif
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ $submission->campaign }}</td>
                                        <td class="px-4 py-3 text-slate-900 dark:text-zink-100">{{ Str::limit($submission->comment, 50) }}</td>
                                        <td class="px-4 py-3 text-slate-500 dark:text-zink-400">{{ $submission->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Unmatched Numbers Section -->
            @if(count($results['unmatched_numbers']) > 0)
            <div class="card mt-6">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <h6 class="text-lg font-semibold text-red-600 dark:text-red-400 flex items-center">
                            <i data-lucide="x-circle" class="w-5 h-5 mr-2"></i>
                            Unmatched Numbers ({{ $results['total_unmatched'] }})
                        </h6>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-zink-600">
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">#</th>
                                    <th class="px-4 py-3 text-left text-slate-700 dark:text-zink-300 font-semibold">Phone Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results['unmatched_numbers'] as $index => $phone)
                                <tr class="border-b border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600/50">
                                    <td class="px-4 py-3 text-slate-700 dark:text-zink-300">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <span class="font-medium text-red-600 dark:text-red-400">{{ $phone }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
<!-- End Page-content -->
@endsection
