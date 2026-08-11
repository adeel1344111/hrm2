@extends('layouts.master')
@section('title') Leave Management @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Leave Management</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('home') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Leave Management</li>
            </ul>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ $stats['total'] }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Leaves</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">All leave requests</p>
                        <div class="flex items-center justify-center text-blue-500 dark:text-blue-400 text-sm">
                            <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                            <span>Complete list</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mb-2">{{ $stats['pending'] }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Pending</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Awaiting approval</p>
                        <div class="flex items-center justify-center text-yellow-500 dark:text-yellow-400 text-sm">
                            <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                            <span>Under review</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">{{ $stats['approved'] }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Approved</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Accepted requests</p>
                        <div class="flex items-center justify-center text-green-500 dark:text-green-400 text-sm">
                            <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                            <span>Confirmed</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-red-600 dark:text-red-400 mb-2">{{ $stats['rejected'] }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Rejected</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Declined requests</p>
                        <div class="flex items-center justify-center text-red-500 dark:text-red-400 text-sm">
                            <i data-lucide="x-circle" class="w-4 h-4 mr-1"></i>
                            <span>Not approved</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Leave Management</h6>
                        <p class="text-slate-500 dark:text-zink-200">Manage employee leave requests</p>
                    </div>
                            <div class="flex items-center gap-3">
                    @if(auth()->user()->isAgent() || auth()->user()->isTeamLead() || auth()->user()->isFloorManager() || auth()->user()->isAdmin() || auth()->user()->isManagement())
                        <a href="{{ route('leaves.create') }}" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            <i data-lucide="plus-circle" class="w-4 h-4 mr-1"></i>
                            Request Leave
                        </a>
                    @endif
                                <div class="relative">
                                    <input type="text" id="searchInput" placeholder="Search leaves..." class="form-input ltr:pl-10 rtl:pr-10">
                                    <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-3 rtl:pr-3 pointer-events-none">
                                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                    <table id="leavesTable" class="w-full text-sm text-left text-slate-500 dark:text-zink-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-zink-600 dark:text-zink-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">Employee</th>
                                <th scope="col" class="px-6 py-3">Leave Type</th>
                                <th scope="col" class="px-6 py-3">Start Date</th>
                                <th scope="col" class="px-6 py-3">End Date</th>
                                <th scope="col" class="px-6 py-3">Days</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Applied On</th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zink-700 divide-y divide-slate-200 dark:divide-zink-500">
                                @forelse($leaves as $leave)
                                <tr class="hover:bg-slate-50 dark:hover:bg-zink-600 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-slate-200 dark:bg-zink-600 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-slate-800 dark:text-zink-200">
                                                        @php
                                                        $fullName = $leave->user->name;
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
                                                <div class="text-sm font-medium text-slate-900 dark:text-zink-100">{{ $leave->user->name }}</div>
                                                <div class="text-sm text-slate-500 dark:text-zink-400">{{ $leave->user->employee_id ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $leave->leave_type_color }}">{{ $leave->leave_type }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">{{ $leave->start_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">{{ $leave->end_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full dark:bg-blue-500/20 dark:text-blue-400">{{ $leave->total_days }} {{ Str::plural('day', $leave->total_days) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $leave->status_color }}">{{ $leave->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">{{ $leave->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            {{-- View button - show for own leaves or if admin/manager --}}
                                            @if($leave->user_id === auth()->user()->id || auth()->user()->canApproveLeaves() || auth()->user()->isTeamLead())
                                            <a href="{{ route('leaves.show', $leave) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View Details">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            @endif
                                            @if($leave->user_id === auth()->user()->id && $leave->status === 'Pending')
                                                {{-- Hide edit button for agents --}}
                                                @if(!auth()->user()->isAgent())
                                                <a href="{{ route('leaves.edit', $leave) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Edit">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                                </a>
                                                @endif
                                            <form action="{{ route('leaves.destroy', $leave) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this leave request?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Cancel">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @if(($leave->status === 'Pending') && (auth()->user()->canApproveLeaves()))
                                            <form action="{{ route('leaves.approve', $leave) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to approve this leave request?')">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Approve">
                                                    <i data-lucide="check" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('leaves.reject', $leave) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to reject this leave request?')">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Reject">
                                                    <i data-lucide="x" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-slate-500 dark:text-zink-200">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="flex items-center justify-center w-16 h-16 text-slate-300 bg-slate-100 rounded-full dark:bg-zink-600 dark:text-zink-400">
                                                <i data-lucide="calendar-x" class="w-8 h-8"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-lg font-semibold text-slate-600 dark:text-zink-200">No leave requests found</h6>
                                            <p class="text-sm">There are no leave requests to display at the moment.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination handled by TableManager -->
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

@include('components.table-manager-script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Table Manager
        new TableManager({
            tableId: 'leavesTable',
            searchInputId: 'searchInput',
            filterInputs: [],
            rowsPerPage: 10
        });
    });
</script>
@endsection
