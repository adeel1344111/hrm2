@extends('layouts.master')
@section('title') HRM Dashboard @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <!-- Header -->
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">{{ ucfirst(str_replace('_', ' ', auth()->user()->user_type)) }} Dashboard</h5>
                <p class="text-slate-500 dark:text-zink-200">Welcome back, {{ auth()->user()->name }}! Here's what's happening today.</p>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="#!" class="text-slate-400 dark:text-zink-200">Dashboards</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">HRM</li>
            </ul>
        </div>

        <!-- Dashboard Content -->
        <div class="grid grid-cols-12 gap-5">
            @auth
                @if(auth()->user()->hasOrgWideAccess())
                    <!-- Admin Dashboard -->
                    
                    <!-- Statistics Cards -->
                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Total Users</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ $dashboardData['totalUsers'] }}</h4>
                                    <p class="text-xs text-green-500 mt-1">
                                        <i data-lucide="trending-up" class="w-3 h-3 inline mr-1"></i>
                                        All Active Users
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="users" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Today's Attendance</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ $dashboardData['todayAttendance'] }}</h4>
                                    <p class="text-xs text-green-500 mt-1">
                                        <i data-lucide="check-circle" class="w-3 h-3 inline mr-1"></i>
                                        Present Today
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="user-check" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Pending Leaves</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ $dashboardData['pendingLeaves'] }}</h4>
                                    <p class="text-xs text-orange-500 mt-1">
                                        <i data-lucide="clock" class="w-3 h-3 inline mr-1"></i>
                                        Awaiting Approval
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="calendar-clock" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Recent Submissions</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ $dashboardData['todaySubmissions'] }}</h4>
                                    <p class="text-xs text-purple-500 mt-1">
                                        <i data-lucide="file-text" class="w-3 h-3 inline mr-1"></i>
                                        Today's Submissions
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="file-plus" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Distribution Chart -->
                    <div class="col-span-12 lg:col-span-8 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">User Distribution</h6>
                                <div class="flex gap-2">
                                    <button class="btn btn-sm bg-blue-500 text-white">View All</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="text-center p-4 bg-blue-50 dark:bg-blue-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $dashboardData['userDistribution']['admins'] }}</h4>
                                    <p class="text-sm text-blue-600 dark:text-blue-400">Admins</p>
                                </div>
                                <div class="text-center p-4 bg-green-50 dark:bg-green-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-green-600 dark:text-green-400">{{ $dashboardData['userDistribution']['floorManagers'] }}</h4>
                                    <p class="text-sm text-green-600 dark:text-green-400">Floor Managers</p>
                                </div>
                                <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-yellow-600 dark:text-yellow-400">{{ $dashboardData['userDistribution']['teamLeads'] }}</h4>
                                    <p class="text-sm text-yellow-600 dark:text-yellow-400">Team Leads</p>
                                </div>
                                <div class="text-center p-4 bg-red-50 dark:bg-red-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-red-600 dark:text-red-400">{{ $dashboardData['userDistribution']['agents'] }}</h4>
                                    <p class="text-sm text-red-600 dark:text-red-400">Agents</p>
                                </div>
                            </div>
                            <!-- Pie Chart -->
                            <div class="h-80">
                                <canvas id="userDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Department Overview -->
                    <div class="col-span-12 lg:col-span-4 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">Department Overview</h6>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs text-green-500">Live</span>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                @php
                                    $departments = \App\Models\User::select('department')
                                        ->whereNotNull('department')
                                        ->where('department', '!=', '')
                                        ->groupBy('department')
                                        ->selectRaw('department, count(*) as count')
                                        ->orderBy('count', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp
                                
                                @forelse($departments as $dept)
                                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-zink-600 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                                            <i data-lucide="building" class="w-5 h-5 text-purple-600"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-medium text-sm">{{ $dept->department }}</h6>
                                            <p class="text-xs text-slate-500 dark:text-zink-400">{{ $dept->count }} employees</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center gap-2">
                                            <div class="w-16 bg-slate-200 dark:bg-zink-600 rounded-full h-2">
                                                @php
                                                    $totalUsers = \App\Models\User::count();
                                                    $percentage = $totalUsers > 0 ? round(($dept->count / $totalUsers) * 100) : 0;
                                                @endphp
                                                <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="text-xs font-medium text-slate-700 dark:text-zink-300">{{ $percentage }}%</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8">
                                    <i data-lucide="building" class="w-12 h-12 mx-auto text-slate-400 dark:text-zink-500 mb-2"></i>
                                    <p class="text-sm text-slate-500 dark:text-zink-400">No departments found</p>
                                </div>
                                @endforelse
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-slate-200 dark:border-zink-600">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-500 dark:text-zink-400">Total Departments</span>
                                    <span class="font-medium text-slate-700 dark:text-zink-300">{{ $departments->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm mt-1">
                                    <span class="text-slate-500 dark:text-zink-400">Total Employees</span>
                                    <span class="font-medium text-slate-700 dark:text-zink-300">{{ \App\Models\User::count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Attendance Trend -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">Weekly Attendance Trend</h6>
                                <div class="flex gap-2">
                                    <span class="text-xs text-green-500">↑ {{ \App\Models\Attendance::whereDate('attendance_date', today())->where('status', 'P')->count() }} Present Today</span>
                                </div>
                            </div>
                            <div class="h-64">
                                <canvas id="attendanceTrendChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">Recent Activities</h6>
                                <span class="text-xs text-blue-500">Live Updates</span>
                            </div>
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @forelse($dashboardData['recentActivities'] as $activity)
                                <div class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-zink-600 rounded-lg">
                                    <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="{{ $activity['icon'] }}" class="w-4 h-4 text-{{ $activity['color'] }}-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900 dark:text-zink-100">{{ $activity['message'] }}</p>
                                        <p class="text-xs text-slate-500 dark:text-zink-400">{{ $activity['time']->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8">
                                    <i data-lucide="activity" class="w-12 h-12 mx-auto text-slate-400 dark:text-zink-500 mb-2"></i>
                                    <p class="text-sm text-slate-500 dark:text-zink-400">No recent activities</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- System Status & Quick Actions -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">System Status</h6>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs text-green-500">All Systems Operational</span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="text-center p-4 bg-green-50 dark:bg-green-500/20 rounded-lg">
                                    <i data-lucide="server" class="w-6 h-6 text-green-600 dark:text-green-400 mx-auto mb-2"></i>
                                    <p class="text-xs text-green-600 dark:text-green-400 font-medium">Database</p>
                                    <p class="text-xs text-green-600 dark:text-green-400">Online</p>
                                </div>
                                <div class="text-center p-4 bg-blue-50 dark:bg-blue-500/20 rounded-lg">
                                    <i data-lucide="cloud" class="w-6 h-6 text-blue-600 dark:text-blue-400 mx-auto mb-2"></i>
                                    <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">Cloud Sync</p>
                                    <p class="text-xs text-blue-600 dark:text-blue-400">Active</p>
                                </div>
                                <div class="text-center p-4 bg-purple-50 dark:bg-purple-500/20 rounded-lg">
                                    <i data-lucide="shield" class="w-6 h-6 text-purple-600 dark:text-purple-400 mx-auto mb-2"></i>
                                    <p class="text-xs text-purple-600 dark:text-purple-400 font-medium">Security</p>
                                    <p class="text-xs text-purple-600 dark:text-purple-400">Protected</p>
                                </div>
                                <div class="text-center p-4 bg-orange-50 dark:bg-orange-500/20 rounded-lg">
                                    <i data-lucide="backup" class="w-6 h-6 text-orange-600 dark:text-orange-400 mx-auto mb-2"></i>
                                    <p class="text-xs text-orange-600 dark:text-orange-400 font-medium">Backup</p>
                                    <p class="text-xs text-orange-600 dark:text-orange-400">Updated</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <h6 class="text-15 text-slate-700 dark:text-zink-100 mb-4">Quick Actions</h6>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('employees.create') }}" class="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-500/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-500/30 transition-colors">
                                    <i data-lucide="user-plus" class="w-6 h-6 text-blue-600 dark:text-blue-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Add Employee</span>
                                </a>
                                <a href="{{ route('attendance.index') }}" class="flex flex-col items-center p-4 bg-green-50 dark:bg-green-500/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-500/30 transition-colors">
                                    <i data-lucide="calendar" class="w-6 h-6 text-green-600 dark:text-green-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Mark Attendance</span>
                                </a>
                                <a href="{{ route('leaves.index') }}" class="flex flex-col items-center p-4 bg-orange-50 dark:bg-orange-500/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-500/30 transition-colors">
                                    <i data-lucide="calendar-check" class="w-6 h-6 text-orange-600 dark:text-orange-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Review Leaves</span>
                                </a>
                                <a href="{{ route('submissions.report') }}" class="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-500/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-500/30 transition-colors">
                                    <i data-lucide="bar-chart" class="w-6 h-6 text-purple-600 dark:text-purple-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">View Reports</span>
                                </a>
                            </div>
                        </div>
                    </div>

                @elseif(auth()->user()->isFloorManager())
                    <!-- Floor Manager Dashboard -->
                    
                    <!-- Statistics Cards -->
                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">My Team Leads</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ auth()->user()->teamLeads()->count() }}</h4>
                                    <p class="text-xs text-blue-500 dark:text-blue-400 mt-1">
                                        <i data-lucide="users" class="w-3 h-3 inline mr-1"></i>
                                        Direct Reports
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="user-check" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Total Agents</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ auth()->user()->allAgents()->count() }}</h4>
                                    <p class="text-xs text-green-500 dark:text-green-400 mt-1">
                                        <i data-lucide="trending-up" class="w-3 h-3 inline mr-1"></i>
                                        Under Management
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="users" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Today's Attendance</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ auth()->user()->allAgents()->whereHas('attendances', function($q) { $q->whereDate('attendance_date', today())->where('status', 'P'); })->count() }}</h4>
                                    <p class="text-xs text-green-500 dark:text-green-400 mt-1">
                                        <i data-lucide="check-circle" class="w-3 h-3 inline mr-1"></i>
                                        Present Today
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="calendar-check" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Today's Submissions</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ $dashboardData['todaySubmissions'] }}</h4>
                                    <p class="text-xs text-orange-500 dark:text-orange-400 mt-1">
                                        <i data-lucide="file-text" class="w-3 h-3 inline mr-1"></i>
                                        Floor Submissions
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="file-plus" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Team Performance Overview Chart -->
                    <div class="col-span-12 lg:col-span-8 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">Team Performance Overview</h6>
                                <div class="flex gap-2">
                                    <button class="btn btn-sm bg-blue-500 text-white">View Report</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="text-center p-4 bg-blue-50 dark:bg-blue-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $dashboardData['stats']['total_team_leads'] }}</h4>
                                    <p class="text-sm text-blue-600 dark:text-blue-400">Team Leads</p>
                                </div>
                                <div class="text-center p-4 bg-green-50 dark:bg-green-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-green-600 dark:text-green-400">{{ $dashboardData['stats']['total_agents'] }}</h4>
                                    <p class="text-sm text-green-600 dark:text-green-400">Total Agents</p>
                                </div>
                                <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-yellow-600 dark:text-yellow-400">{{ $dashboardData['stats']['active_now'] }}</h4>
                                    <p class="text-sm text-yellow-600 dark:text-yellow-400">Active Now</p>
                                </div>
                                <div class="text-center p-4 bg-red-50 dark:bg-red-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-red-600 dark:text-red-400">{{ $dashboardData['stats']['total_submissions'] }}</h4>
                                    <p class="text-sm text-red-600 dark:text-red-400">Submissions</p>
                                </div>
                            </div>
                            <!-- Pie Chart -->
                            <div class="h-80">
                                <canvas id="userDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="col-span-12 lg:col-span-4 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15 text-slate-700 dark:text-zink-100">Recent Activities</h6>
                                <span class="text-xs text-slate-500 dark:text-zink-400">Live Updates</span>
                            </div>
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @forelse($dashboardData['recentActivities'] as $activity)
                                <div class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-zink-600 rounded-lg">
                                    <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="{{ $activity['icon'] }}" class="w-4 h-4 text-{{ $activity['color'] }}-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-slate-700 dark:text-zink-100 font-medium truncate">{{ $activity['message'] }}</p>
                                        <p class="text-xs text-slate-500 dark:text-zink-400">{{ $activity['time']->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <p class="text-sm text-slate-500 dark:text-zink-400">No recent activities</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Team Attendance Summary -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">Team Attendance Summary</h6>
                                <span class="text-xs text-blue-500 dark:text-blue-400">Today's Overview</span>
                            </div>
                            <div class="space-y-3">
                                @forelse(auth()->user()->teamLeads as $teamLead)
                                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-zink-600 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                            <i data-lucide="users" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-medium text-sm">{{ $teamLead->name }}</h6>
                                            <p class="text-xs text-slate-500 dark:text-zink-400">{{ $teamLead->agents()->count() }} agents</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $presentCount = $teamLead->agents()->whereHas('attendances', function($q) { $q->whereDate('attendance_date', today())->where('status', 'P'); })->count();
                                            $totalCount = $teamLead->agents()->count();
                                            $percentage = $totalCount > 0 ? round(($presentCount / $totalCount) * 100) : 0;
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="w-16 bg-slate-200 dark:bg-zink-600 rounded-full h-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="text-xs font-medium text-slate-700 dark:text-zink-300">{{ $percentage }}%</span>
                                        </div>
                                        <p class="text-xs text-slate-500 dark:text-zink-400">{{ $presentCount }}/{{ $totalCount }} present</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8">
                                    <i data-lucide="users" class="w-12 h-12 mx-auto text-slate-400 dark:text-zink-500 mb-2"></i>
                                    <p class="text-sm text-slate-500 dark:text-zink-400">No team leads assigned</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <h6 class="text-15 text-slate-700 dark:text-zink-100 mb-4">Quick Actions</h6>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('attendance.index') }}" class="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-500/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-500/30 transition-colors">
                                    <i data-lucide="calendar" class="w-6 h-6 text-blue-600 dark:text-blue-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Mark Attendance</span>
                                </a>
                                <a href="{{ route('leaves.index') }}" class="flex flex-col items-center p-4 bg-orange-50 dark:bg-orange-500/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-500/30 transition-colors">
                                    <i data-lucide="calendar-check" class="w-6 h-6 text-orange-600 dark:text-orange-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Approve Leaves</span>
                                </a>
                                <a href="{{ route('submissions.report') }}" class="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-500/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-500/30 transition-colors">
                                    <i data-lucide="bar-chart" class="w-6 h-6 text-purple-600 dark:text-purple-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">View Reports</span>
                                </a>
                                <a href="{{ route('performance.report') }}" class="flex flex-col items-center p-4 bg-green-50 dark:bg-green-500/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-500/30 transition-colors">
                                    <i data-lucide="trending-up" class="w-6 h-6 text-green-600 dark:text-green-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Performance Report</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Submissions Table -->
                    <div class="col-span-12 card">
                        <div class="card-body">
                            <h6 class="text-15 text-slate-700 dark:text-zink-100 mb-4">Floor Submissions Overview</h6>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-slate-50 dark:bg-zink-600">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-200 uppercase tracking-wider">Agent</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-200 uppercase tracking-wider">Team Lead</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-200 uppercase tracking-wider">Campaign</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-200 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-200 uppercase tracking-wider">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 dark:divide-zink-500">
                                        @php
                                            $floorSubmissions = \App\Models\Submission::whereIn('submitted_by', auth()->user()->allAgents()->pluck('users.id'))
                                                ->latest()
                                                ->take(5)
                                                ->get();
                                        @endphp
                                        @forelse($floorSubmissions as $submission)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-zink-100">{{ $submission->submittedBy->name }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500 dark:text-zink-400">{{ $submission->submittedBy->teamLead->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500 dark:text-zink-400">{{ $submission->campaign }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">
                                                    {{ $submission->status ?? 'Submitted' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500 dark:text-zink-400">{{ $submission->created_at->format('M d, H:i') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-3 text-center text-sm text-slate-500 dark:text-zink-400">No recent submissions found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                @elseif(auth()->user()->isTeamLead())
                    <!-- Team Lead Dashboard -->
                    
                    <!-- Statistics Cards -->
                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">My Agents</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ auth()->user()->agents()->count() }}</h4>
                                    <p class="text-xs text-blue-500 dark:text-blue-400 mt-1">
                                        <i data-lucide="users" class="w-3 h-3 inline mr-1"></i>
                                        Direct Reports
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="user-check" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Active Today</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ auth()->user()->agents()->whereHas('attendances', function($q) { $q->whereDate('attendance_date', today())->where('status', 'P'); })->count() }}</h4>
                                    <p class="text-xs text-green-500 dark:text-green-400 mt-1">
                                        <i data-lucide="check-circle" class="w-3 h-3 inline mr-1"></i>
                                        Present Today
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="calendar-check" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Pending Leaves</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ \App\Models\Leave::whereIn('user_id', auth()->user()->agents()->pluck('id'))->where('status', 'pending')->count() }}</h4>
                                    <p class="text-xs text-purple-500 dark:text-purple-400 mt-1">
                                        <i data-lucide="clock" class="w-3 h-3 inline mr-1"></i>
                                        Applications Waiting
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="calendar-clock" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Today's Submissions</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ \App\Models\Submission::whereIn('submitted_by', auth()->user()->agents()->pluck('id'))->whereDate('created_at', today())->count() }}</h4>
                                    <p class="text-xs text-orange-500 dark:text-orange-400 mt-1">
                                        <i data-lucide="file-text" class="w-3 h-3 inline mr-1"></i>
                                        Team Submissions
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="file-plus" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Team Performance Overview Chart -->
                    <div class="col-span-12 lg:col-span-8 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">Team Performance Overview</h6>
                                <div class="flex gap-2">
                                    <button class="btn btn-sm bg-blue-500 text-white">View Report</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="text-center p-4 bg-blue-50 dark:bg-blue-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $dashboardData['stats']['total_agents'] }}</h4>
                                    <p class="text-sm text-blue-600 dark:text-blue-400">My Agents</p>
                                </div>
                                <div class="text-center p-4 bg-green-50 dark:bg-green-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-green-600 dark:text-green-400">{{ $dashboardData['stats']['present_today'] }}</h4>
                                    <p class="text-sm text-green-600 dark:text-green-400">Present Today</p>
                                </div>
                                <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-yellow-600 dark:text-yellow-400">{{ $dashboardData['stats']['month_submissions'] }}</h4>
                                    <p class="text-sm text-yellow-600 dark:text-yellow-400">Month Submissions</p>
                                </div>
                                <div class="text-center p-4 bg-red-50 dark:bg-red-500/20 rounded-lg">
                                    <h4 class="text-xl font-bold text-red-600 dark:text-red-400">{{ $dashboardData['stats']['pending_approvals'] }}</h4>
                                    <p class="text-sm text-red-600 dark:text-red-400">Pending Approvals</p>
                                </div>
                            </div>
                            <!-- Pie Chart -->
                            <div class="h-80">
                                <canvas id="userDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="col-span-12 lg:col-span-4 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15 text-slate-700 dark:text-zink-100">Recent Activities</h6>
                                <span class="text-xs text-blue-500 dark:text-blue-400">Live Updates</span>
                            </div>
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @forelse($dashboardData['recentActivities'] as $activity)
                                <div class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-zink-600 rounded-lg">
                                    <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="{{ $activity['icon'] }}" class="w-4 h-4 text-{{ $activity['color'] }}-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-slate-700 dark:text-zink-100 font-medium truncate">{{ $activity['message'] }}</p>
                                        <p class="text-xs text-slate-500 dark:text-zink-400">{{ $activity['time']->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <p class="text-sm text-slate-500 dark:text-zink-400">No recent activities</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Submissions Chart -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15 text-slate-700 dark:text-zink-100">Weekly Team Submissions</h6>
                                <span class="text-xs text-blue-500 dark:text-blue-400">Last 7 Days</span>
                            </div>
                            <div class="h-64">
                                <canvas id="weeklySubmissionsChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <h6 class="text-15 text-slate-700 dark:text-zink-100 mb-4">Quick Actions</h6>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('attendance.index') }}" class="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-500/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-500/30 transition-colors">
                                    <i data-lucide="calendar" class="w-6 h-6 text-blue-600 dark:text-blue-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Mark Attendance</span>
                                </a>
                                <a href="{{ route('leaves.index') }}" class="flex flex-col items-center p-4 bg-orange-50 dark:bg-orange-500/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-500/30 transition-colors">
                                    <i data-lucide="calendar-check" class="w-6 h-6 text-orange-600 dark:text-orange-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Approve Leaves</span>
                                </a>
                                <a href="{{ route('submissions.create') }}" class="flex flex-col items-center p-4 bg-green-50 dark:bg-green-500/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-500/30 transition-colors">
                                    <i data-lucide="file-plus" class="w-6 h-6 text-green-600 dark:text-green-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Create Submission</span>
                                </a>
                                <a href="{{ route('performance.report') }}" class="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-500/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-500/30 transition-colors">
                                    <i data-lucide="trending-up" class="w-6 h-6 text-purple-600 dark:text-purple-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center text-slate-700 dark:text-zink-100">Performance Report</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Submissions Table -->
                    <div class="col-span-12 card">
                        <div class="card-body">
                            <h6 class="text-15 text-slate-700 dark:text-zink-100 mb-4">Team Submissions Overview</h6>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-slate-50 dark:bg-zink-600">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-200 uppercase tracking-wider">Agent</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-200 uppercase tracking-wider">Campaign</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-200 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-200 uppercase tracking-wider">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 dark:divide-zink-500">
                                        @php
                                            $teamSubmissions = \App\Models\Submission::whereIn('submitted_by', auth()->user()->agents()->pluck('id'))
                                                ->latest()
                                                ->take(5)
                                                ->get();
                                        @endphp
                                        @forelse($teamSubmissions as $submission)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-zink-100">{{ $submission->submittedBy->name }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500 dark:text-zink-400">{{ $submission->campaign }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">
                                                    {{ $submission->status ?? 'Submitted' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500 dark:text-zink-400">{{ $submission->created_at->format('M d, H:i') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-3 text-center text-sm text-slate-500 dark:text-zink-400">No recent submissions found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                @elseif(auth()->user()->isAgent() || auth()->user()->isManagement())
                    <!-- Agent / Management Dashboard -->
                    
                    <!-- Statistics Cards -->
                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Today's Status</h6>
                                    @php
                                        $todayAttendance = auth()->user()->attendances()->whereDate('attendance_date', today())->first();
                                    @endphp
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">
                                        @if($todayAttendance)
                                            @php
                                                $statusMap = [
                                                    'P' => 'Present',
                                                    'A' => 'Absent',
                                                    'H' => 'Holiday',
                                                    'L' => 'Leave',
                                                ];
                                            @endphp
                                            {{ $statusMap[$todayAttendance->status] ?? $todayAttendance->status }}
                                        @else
                                            Not Marked
                                        @endif
                                    </h4>
                                    <p class="text-xs {{ $todayAttendance && $todayAttendance->status == 'P' ? 'text-green-500' : 'text-red-500' }} mt-1">
                                        <i data-lucide="{{ $todayAttendance && $todayAttendance->status == 'P' ? 'check-circle' : 'x-circle' }}" class="w-3 h-3 inline mr-1"></i>
                                        {{ $todayAttendance ? 'Marked' : 'Pending' }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 {{ $todayAttendance && $todayAttendance->status == 'P' ? 'bg-green-100 dark:bg-green-500/20' : 'bg-red-100 dark:bg-red-500/20' }} rounded-lg flex items-center justify-center">
                                    <i data-lucide="{{ $todayAttendance && $todayAttendance->status == 'P' ? 'check-circle' : 'x-circle' }}" class="w-6 h-6 {{ $todayAttendance && $todayAttendance->status == 'P' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    @if(auth()->user()->isManagement())
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">My Leaves</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ $dashboardData['totalLeaves'] ?? auth()->user()->leaves()->count() }}</h4>
                                    <p class="text-xs text-blue-500 dark:text-blue-400 mt-1">
                                        <i data-lucide="calendar-days" class="w-3 h-3 inline mr-1"></i>
                                        {{ $dashboardData['pendingLeaves'] ?? 0 }} Pending
                                    </p>
                                    @else
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">My Submissions</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ auth()->user()->submissions()->count() }}</h4>
                                    <p class="text-xs text-blue-500 dark:text-blue-400 mt-1">
                                        <i data-lucide="file-text" class="w-3 h-3 inline mr-1"></i>
                                        Total Submitted
                                    </p>
                                    @endif
                                </div>
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="{{ auth()->user()->isManagement() ? 'calendar-days' : 'file-plus' }}" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Current Month Salary</h6>
                                    @php
                                        $payrollService = app(\App\Services\PayrollService::class);
                                        $currentPayroll = $payrollService->calculateSalaries(auth()->id(), false);
                                        $monthlySalary = !empty($currentPayroll) ? $currentPayroll[0]['final_salary'] : 0;
                                    @endphp
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">PKR {{ number_format($monthlySalary) }}</h4>
                                    <p class="text-xs text-green-500 dark:text-green-400 mt-1">
                                        <i data-lucide="trending-up" class="w-3 h-3 inline mr-1"></i>
                                        {{ date('F Y') }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="wallet" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6 lg:col-span-3 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-slate-500 dark:text-zink-200 mb-1">Employee ID</h6>
                                    <h4 class="text-2xl font-bold text-slate-900 dark:text-zink-100">{{ auth()->user()->employee_id }}</h4>
                                    <p class="text-xs text-green-500 dark:text-green-400 mt-1">
                                        <i data-lucide="badge" class="w-3 h-3 inline mr-1"></i>
                                        {{ auth()->user()->department ?? (auth()->user()->isManagement() ? 'Management' : 'Agent') }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="user" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if(auth()->user()->isManagement())
                    <div class="col-span-12 card">
                        <div class="card-body">
                            <h6 class="mb-4 text-15">Quick Actions</h6>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                <a href="{{ route('leaves.create') }}" class="flex items-center gap-3 p-4 rounded-md border border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600">
                                    <div class="w-10 h-10 bg-teal-100 dark:bg-teal-500/20 rounded-lg flex items-center justify-center">
                                        <i data-lucide="calendar-plus" class="w-5 h-5 text-teal-600 dark:text-teal-400"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800 dark:text-zink-100">Apply Leave</div>
                                        <div class="text-xs text-slate-500 dark:text-zink-300">Submit a leave request</div>
                                    </div>
                                </a>
                                <a href="{{ route('leaves.index') }}" class="flex items-center gap-3 p-4 rounded-md border border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-500/20 rounded-lg flex items-center justify-center">
                                        <i data-lucide="list-checks" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800 dark:text-zink-100">Leave Status</div>
                                        <div class="text-xs text-slate-500 dark:text-zink-300">Track your requests</div>
                                    </div>
                                </a>
                                <a href="{{ route('attendance.report') }}" class="flex items-center gap-3 p-4 rounded-md border border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600">
                                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-500/20 rounded-lg flex items-center justify-center">
                                        <i data-lucide="clock" class="w-5 h-5 text-orange-600 dark:text-orange-400"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800 dark:text-zink-100">Attendance Report</div>
                                        <div class="text-xs text-slate-500 dark:text-zink-300">View your attendance</div>
                                    </div>
                                </a>
                                <a href="{{ route('payroll.show', auth()->user()->employee_id) }}" class="flex items-center gap-3 p-4 rounded-md border border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600 sm:col-span-3 lg:col-span-1">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-500/20 rounded-lg flex items-center justify-center">
                                        <i data-lucide="wallet" class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800 dark:text-zink-100">My Payroll</div>
                                        <div class="text-xs text-slate-500 dark:text-zink-300">View salary details</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(!auth()->user()->isManagement())
                    <!-- Personal Performance Chart -->
                    <div class="col-span-12 lg:col-span-8 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">My Performance (Last 7 Days)</h6>
                                <div class="flex gap-2">
                                    <span class="text-xs text-blue-500 dark:text-blue-400">Total: {{ auth()->user()->submissions()->count() }} submissions</span>
                                </div>
                            </div>
                            <div class="h-80">
                                <canvas id="personalPerformanceChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Insights -->
                    <div class="col-span-12 lg:col-span-4 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">Performance Insights</h6>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs text-blue-500 dark:text-blue-400">Live</span>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                @php
                                    $todaySubmissions = auth()->user()->submissions()->whereDate('created_at', today())->count();
                                    $weekSubmissions = auth()->user()->submissions()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
                                    $monthSubmissions = auth()->user()->submissions()->whereMonth('created_at', now()->month)->count();
                                    $avgDaily = $weekSubmissions > 0 ? round($weekSubmissions / 7, 1) : 0;
                                    
                                    // Calculate performance trend
                                    $lastWeekSubmissions = auth()->user()->submissions()->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
                                    $trend = $lastWeekSubmissions > 0 ? round((($weekSubmissions - $lastWeekSubmissions) / $lastWeekSubmissions) * 100) : 0;
                                @endphp
                                
                                <!-- Today's Performance -->
                                <div class="p-4 bg-blue-50 dark:bg-blue-500/10 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <i data-lucide="zap" class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2"></i>
                                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Today's Work</span>
                                        </div>
                                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $todaySubmissions }}</span>
                                    </div>
                                    <div class="text-xs text-blue-500 dark:text-blue-300">
                                        @if($todaySubmissions > $avgDaily)
                                            <i data-lucide="trending-up" class="w-3 h-3 inline mr-1"></i>
                                            Above average ({{ $avgDaily }})
                                        @elseif($todaySubmissions == $avgDaily)
                                            <i data-lucide="minus" class="w-3 h-3 inline mr-1"></i>
                                            On track
                                        @else
                                            <i data-lucide="trending-down" class="w-3 h-3 inline mr-1"></i>
                                            Below average ({{ $avgDaily }})
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Weekly Trend -->
                                <div class="p-4 bg-green-50 dark:bg-green-500/20 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <i data-lucide="trending-up" class="w-5 h-5 text-green-600 dark:text-green-400 mr-2"></i>
                                            <span class="text-sm font-medium text-green-600 dark:text-green-400">Weekly Trend</span>
                                        </div>
                                        <span class="text-lg font-bold {{ $trend >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $trend >= 0 ? '+' : '' }}{{ $trend }}%
                                        </span>
                                    </div>
                                    <div class="text-xs text-green-500 dark:text-green-300">
                                        vs last week ({{ $lastWeekSubmissions }} submissions)
                                    </div>
                                </div>
                                
                                <!-- Monthly Progress -->
                                <div class="p-4 bg-purple-50 dark:bg-purple-500/20 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <i data-lucide="calendar" class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-2"></i>
                                            <span class="text-sm font-medium text-purple-600 dark:text-purple-400">This Month</span>
                                        </div>
                                        <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $monthSubmissions }}</span>
                                    </div>
                                    <div class="text-xs text-purple-500 dark:text-purple-300">
                                        @php
                                            $daysInMonth = now()->daysInMonth;
                                            $daysPassed = now()->day;
                                            $projectedMonthly = $daysPassed > 0 ? round(($monthSubmissions / $daysPassed) * $daysInMonth) : 0;
                                        @endphp
                                        Projected: {{ $projectedMonthly }} submissions
                                    </div>
                                </div>
                                
                                <!-- Performance Rating -->
                                <div class="p-4 bg-orange-50 dark:bg-orange-500/20 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <i data-lucide="star" class="w-5 h-5 text-orange-600 dark:text-orange-400 mr-2"></i>
                                            <span class="text-sm font-medium text-orange-600 dark:text-orange-400">Performance Rating</span>
                                        </div>
                                        <div class="flex items-center">
                                            @php
                                                $rating = 0;
                                                if($weekSubmissions >= 20) $rating = 5;
                                                elseif($weekSubmissions >= 15) $rating = 4;
                                                elseif($weekSubmissions >= 10) $rating = 3;
                                                elseif($weekSubmissions >= 5) $rating = 2;
                                                else $rating = 1;
                                            @endphp
                                            @for($i = 1; $i <= 5; $i++)
                                                <i data-lucide="star" class="w-4 h-4 {{ $i <= $rating ? 'text-orange-500 dark:text-orange-400 fill-current' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="text-xs text-orange-500 dark:text-orange-300">
                                        @if($rating >= 4)
                                            Excellent performance!
                                        @elseif($rating >= 3)
                                            Good work, keep it up!
                                        @elseif($rating >= 2)
                                            Room for improvement
                                        @else
                                            Focus on increasing submissions
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-slate-200 dark:border-zink-600">
                                <div class="text-center">
                                    <a href="{{ route('submissions.create') }}" class="btn btn-sm bg-blue-500 text-white w-full">
                                        <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                                        Add New Submission
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Activity Summary -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">My Activity Summary</h6>
                                <span class="text-xs text-blue-500">This Week</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-4 bg-blue-50 dark:bg-blue-500/20 rounded-lg">
                                    <i data-lucide="target" class="w-6 h-6 text-blue-600 dark:text-blue-400 mx-auto mb-2"></i>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ auth()->user()->submissions()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}</p>
                                    <p class="text-xs text-blue-600 dark:text-blue-400">Submissions</p>
                                </div>
                                <div class="text-center p-4 bg-green-50 dark:bg-green-500/20 rounded-lg">
                                    @php
                                        $attendanceThisWeek = auth()->user()->attendances()->whereBetween('attendance_date', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')])->where('status', 'P')->count();
                                    @endphp
                                    <i data-lucide="calendar-check" class="w-6 h-6 text-green-600 dark:text-green-400 mx-auto mb-2"></i>
                                    <p class="text-lg font-bold text-green-600 dark:text-green-400">{{ $attendanceThisWeek }}</p>
                                    <p class="text-xs text-green-600 dark:text-green-400">Present Days</p>
                                </div>
                                <div class="text-center p-4 bg-orange-50 dark:bg-orange-500/20 rounded-lg">
                                    @php
                                        $pendingLeaves = auth()->user()->leaves()->where('status', 'pending')->count();
                                    @endphp
                                    <i data-lucide="clock" class="w-6 h-6 text-orange-600 dark:text-orange-400 mx-auto mb-2"></i>
                                    <p class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $pendingLeaves }}</p>
                                    <p class="text-xs text-orange-600 dark:text-orange-400">Pending Leaves</p>
                                </div>
                                <div class="text-center p-4 bg-purple-50 dark:bg-purple-500/20 rounded-lg">
                                    @php
                                        $todaySubmissions = auth()->user()->submissions()->whereDate('created_at', today())->count();
                                    @endphp
                                    <i data-lucide="zap" class="w-6 h-6 text-purple-600 dark:text-purple-400 mx-auto mb-2"></i>
                                    <p class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $todaySubmissions }}</p>
                                    <p class="text-xs text-purple-600 dark:text-purple-400">Today's Work</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <h6 class="text-15 text-slate-700 dark:text-zink-100 mb-4">Quick Actions</h6>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('submissions.create') }}" class="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-500/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors">
                                    <i data-lucide="file-plus" class="w-6 h-6 text-blue-600 dark:text-blue-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center dark:text-zink-100">Create Submission</span>
                                </a>
                                <a href="{{ route('submissions.index') }}" class="flex flex-col items-center p-4 bg-green-50 dark:bg-green-500/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-500/20 transition-colors">
                                    <i data-lucide="file-text" class="w-6 h-6 text-green-600 dark:text-green-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center dark:text-zink-100">My Submissions</span>
                                </a>
                                <a href="{{ route('leaves.create') }}" class="flex flex-col items-center p-4 bg-orange-50 dark:bg-orange-500/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-500/20 transition-colors">
                                    <i data-lucide="calendar-plus" class="w-6 h-6 text-orange-600 dark:text-orange-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center dark:text-zink-100">Request Leave</span>
                                </a>
                                <a href="{{ route('performance.report') }}" class="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-500/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-500/20 transition-colors">
                                    <i data-lucide="bar-chart" class="w-6 h-6 text-purple-600 dark:text-purple-400 mb-2"></i>
                                    <span class="text-sm font-medium text-center dark:text-zink-100">Performance Report</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Submissions -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15 text-slate-700 dark:text-zink-100">Recent Submissions</h6>
                                <a href="{{ route('submissions.index') }}" class="text-xs text-blue-500 hover:text-blue-600">View All</a>
                            </div>
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @forelse(auth()->user()->submissions()->latest()->take(5)->get() as $submission)
                                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-zink-600 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                            <i data-lucide="file-text" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-medium text-sm">{{ $submission->campaign }}</h6>
                                            <p class="text-xs text-slate-500 dark:text-zink-400">{{ $submission->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">
                                            {{ $submission->status ?? 'Completed' }}
                                        </span>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8">
                                    <i data-lucide="file-text" class="w-12 h-12 mx-auto text-slate-400 dark:text-zink-500 mb-2"></i>
                                    <p class="text-sm text-slate-500 dark:text-zink-400">No submissions yet</p>
                                    <a href="{{ route('submissions.create') }}" class="text-xs text-blue-500 hover:text-blue-600 mt-2 inline-block">Create your first submission</a>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Goals & Progress -->
                    <div class="col-span-12 lg:col-span-6 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15 text-slate-700 dark:text-zink-100">Weekly Goals & Progress</h6>
                                <span class="text-xs text-green-500">Live Tracking</span>
                            </div>
                            
                            @php
                                $dailyGoal = \App\Models\Setting::getDailyGoal();
                                $weeklyGoal = \App\Models\Setting::getWeeklyGoal();
                                $monthlyGoal = \App\Models\Setting::getMonthlyGoal();
                                $currentWeekSubmissions = auth()->user()->submissions()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
                                $progressPercentage = $weeklyGoal > 0 ? min(round(($currentWeekSubmissions / $weeklyGoal) * 100), 100) : 0;
                                $daysRemaining = now()->endOfWeek()->diffInDays(now()) + 1;
                                $dailyTarget = $daysRemaining > 0 ? round(($weeklyGoal - $currentWeekSubmissions) / $daysRemaining) : 0;
                            @endphp
                            
                            <div class="space-y-4">
                                <!-- Weekly Progress -->
                                <div class="p-4 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-500/20 dark:to-purple-500/20 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <i data-lucide="target" class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2"></i>
                                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Weekly Target</span>
                                        </div>
                                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $currentWeekSubmissions }}/{{ $weeklyGoal }}</span>
                                    </div>
                                    <div class="w-full bg-slate-200 dark:bg-zink-600 rounded-full h-3 mb-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-3 rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%"></div>
                                    </div>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-500 dark:text-zink-400">{{ $progressPercentage }}% Complete</span>
                                        <span class="text-slate-500 dark:text-zink-400">{{ $daysRemaining }} days left</span>
                                    </div>
                                </div>
                                
                                <!-- Daily Target -->
                                <div class="p-4 bg-green-50 dark:bg-green-500/20 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <i data-lucide="calendar" class="w-5 h-5 text-green-600 dark:text-green-400 mr-2"></i>
                                            <span class="text-sm font-medium text-green-600 dark:text-green-400">Daily Target</span>
                                        </div>
                                        <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ max($dailyTarget, 0) }}</span>
                                    </div>
                                    <div class="text-xs text-green-500 dark:text-green-300">
                                        @if($dailyTarget > 0)
                                            Need {{ $dailyTarget }} submissions per day to reach weekly goal
                                        @elseif($currentWeekSubmissions >= $weeklyGoal)
                                            🎉 Weekly goal achieved!
                                        @else
                                            Goal already met for the week
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Performance Streak -->
                                <div class="p-4 bg-orange-50 dark:bg-orange-500/20 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <i data-lucide="flame" class="w-5 h-5 text-orange-600 dark:text-orange-400 mr-2"></i>
                                            <span class="text-sm font-medium text-orange-600 dark:text-orange-400">Current Streak</span>
                                        </div>
                                        <span class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                            @php
                                                $streak = 0;
                                                $currentDate = now();
                                                while($currentDate->gte(now()->startOfWeek())) {
                                                    $daySubmissions = auth()->user()->submissions()->whereDate('created_at', $currentDate)->count();
                                                    if($daySubmissions > 0) {
                                                        $streak++;
                                                        $currentDate = $currentDate->subDay();
                                                    } else {
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            {{ $streak }} days
                                        </span>
                                    </div>
                                    <div class="text-xs text-orange-500 dark:text-orange-300">
                                        @if($streak >= 5)
                                            🔥 Amazing streak! Keep it up!
                                        @elseif($streak >= 3)
                                            Great consistency!
                                        @elseif($streak >= 1)
                                            Good start, build momentum!
                                        @else
                                            Start your streak today!
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Team Performance Comparison -->
                    <div class="col-span-12 card">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-15">Team Performance Comparison</h6>
                                <span class="text-xs text-blue-500">This Week</span>
                            </div>
                            
                            @php
                                $teamLead = auth()->user()->teamLead;
                                $teamMembers = $teamLead ? $teamLead->agents()->where('status', 'active')->with('submissions')->get() : collect();
                                $myWeeklySubmissions = auth()->user()->submissions()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
                                $dailyGoal = \App\Models\Setting::getDailyGoal();
                                $weeklyGoal = \App\Models\Setting::getWeeklyGoal();
                            @endphp
                            
                            @if($teamMembers->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($teamMembers as $member)
                                @php
                                    // Count submissions from both CSR and Verification tables
                                    $csrWeekly = \DB::table('csr_submissions')
                                        ->where('submitted_by', $member->id)
                                        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                        ->count();
                                    $verificationWeekly = \DB::table('verification_submissions')
                                        ->where('submitted_by', $member->id)
                                        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                        ->count();
                                    $memberWeeklySubmissions = $csrWeekly + $verificationWeekly;
                                    
                                    $csrDaily = \DB::table('csr_submissions')
                                        ->where('submitted_by', $member->id)
                                        ->whereDate('created_at', today())
                                        ->count();
                                    $verificationDaily = \DB::table('verification_submissions')
                                        ->where('submitted_by', $member->id)
                                        ->whereDate('created_at', today())
                                        ->count();
                                    $memberDailySubmissions = $csrDaily + $verificationDaily;
                                    
                                    $isCurrentUser = $member->id === auth()->id();
                                    $meetsDailyGoal = $memberDailySubmissions >= $dailyGoal;
                                    $meetsWeeklyGoal = $memberWeeklySubmissions >= $weeklyGoal;
                                    $cardColor = $isCurrentUser ? 'blue' : ($meetsDailyGoal && $meetsWeeklyGoal ? 'green' : 'red');
                                @endphp
                                <div class="p-4 {{ $isCurrentUser ? 'bg-blue-50 dark:bg-blue-500/20 border-2 border-blue-200 dark:border-blue-500/50' : ($meetsDailyGoal && $meetsWeeklyGoal ? 'bg-green-50 dark:bg-green-500/20 border border-green-200 dark:border-green-500/50' : 'bg-red-50 dark:bg-red-500/20 border border-red-200 dark:border-red-500/50') }} rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 {{ $isCurrentUser ? 'bg-blue-100 dark:bg-blue-500/20' : ($meetsDailyGoal && $meetsWeeklyGoal ? 'bg-green-100 dark:bg-green-500/20' : 'bg-red-100 dark:bg-red-500/20') }} rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-xs font-medium {{ $isCurrentUser ? 'text-blue-600 dark:text-blue-400' : ($meetsDailyGoal && $meetsWeeklyGoal ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400') }}">
                                                    {{ substr($member->name, 0, 2) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="font-medium text-sm {{ $isCurrentUser ? 'text-blue-600 dark:text-blue-400' : ($meetsDailyGoal && $meetsWeeklyGoal ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400') }}">
                                                    {{ $member->name }}
                                                    @if($isCurrentUser)
                                                        <span class="text-xs text-blue-500 dark:text-blue-400">(You)</span>
                                                    @elseif(!$meetsDailyGoal || !$meetsWeeklyGoal)
                                                        <span class="text-xs text-red-500 dark:text-red-400">⚠️</span>
                                                    @endif
                                                </h6>
                                                <p class="text-xs text-slate-500 dark:text-zink-400">{{ $member->employee_id }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-lg font-bold {{ $isCurrentUser ? 'text-blue-600 dark:text-blue-400' : ($meetsDailyGoal && $meetsWeeklyGoal ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400') }}">
                                                {{ $memberWeeklySubmissions }}
                                            </span>
                                            <p class="text-xs text-slate-500 dark:text-zink-400">submissions</p>
                                            @if(!$meetsDailyGoal || !$meetsWeeklyGoal)
                                            <p class="text-xs text-red-500 dark:text-red-400 font-medium">
                                                @if(!$meetsDailyGoal)
                                                    Daily: {{ $memberDailySubmissions }}/{{ $dailyGoal }}
                                                @endif
                                                @if(!$meetsWeeklyGoal)
                                                    Weekly: {{ $memberWeeklySubmissions }}/{{ $weeklyGoal }}
                                                @endif
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($memberWeeklySubmissions > 0)
                                    <div class="w-full bg-slate-200 dark:bg-zink-600 rounded-full h-2">
                                        @php
                                            $maxTeamSubmissions = $teamMembers->max(function($m) {
                                                return $m->submissions()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
                                            });
                                            $memberPercentage = $maxTeamSubmissions > 0 ? round(($memberWeeklySubmissions / $maxTeamSubmissions) * 100) : 0;
                                        @endphp
                                        <div class="{{ $isCurrentUser ? 'bg-blue-500' : ($meetsDailyGoal && $meetsWeeklyGoal ? 'bg-green-500' : 'bg-red-500') }} h-2 rounded-full transition-all duration-500" style="width: {{ $memberPercentage }}%"></div>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8">
                                <i data-lucide="users" class="w-12 h-12 mx-auto text-slate-400 dark:text-zink-500 mb-2"></i>
                                <p class="text-sm text-slate-500 dark:text-zink-400">No team members found</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    @endif {{-- !isManagement: hide agent performance widgets --}}

                @endif
            @endauth
        </div>
    </div>
</div>
<!-- End Page-content -->
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get theme colors
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#e2e8f0' : '#334155';
    const gridColor = isDark ? '#374151' : '#e5e7eb';

    // Add smooth animations to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Add hover effects to statistics cards
    const statCards = document.querySelectorAll('.card-body .flex.items-center.justify-between');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'transform 0.2s ease-in-out';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Auto-refresh dashboard data every 30 seconds
    setInterval(() => {
        // Refresh statistics without full page reload
        fetch(window.location.href, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                // Update any dynamic content if needed
                console.log('Dashboard data refreshed');
            }
        }).catch(error => {
            console.log('Dashboard refresh failed:', error);
        });
    }, 30000);

    @auth
        @if(auth()->user()->hasOrgWideAccess())
            // User Distribution Pie Chart
            const userDistributionCtx = document.getElementById('userDistributionChart');
            if (userDistributionCtx) {
                new Chart(userDistributionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Admins', 'Floor Managers', 'Team Leads', 'Agents'],
                        datasets: [{
                            data: [
                                {{ $dashboardData['userDistribution']['admins'] }},
                                {{ $dashboardData['userDistribution']['floorManagers'] }},
                                {{ $dashboardData['userDistribution']['teamLeads'] }},
                                {{ $dashboardData['userDistribution']['agents'] }}
                            ],
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                            borderWidth: 2,
                            borderColor: isDark ? '#1f2937' : '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 2000
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor,
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: isDark ? '#1f2937' : '#ffffff',
                                titleColor: textColor,
                                bodyColor: textColor,
                                borderColor: isDark ? '#374151' : '#e5e7eb',
                                borderWidth: 1
                            }
                        }
                    }
                });
            }

            // Weekly Attendance Trend Chart
            const attendanceTrendCtx = document.getElementById('attendanceTrendChart');
            if (attendanceTrendCtx) {
                new Chart(attendanceTrendCtx, {
                    type: 'line',
                    data: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        datasets: [{
                            label: 'Present',
                            data: [
                                @foreach($dashboardData['weeklyAttendance'] as $day)
                                    {{ $day['present'] }},
                                @endforeach
                            ],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        }, {
                            label: 'Absent',
                            data: [
                                @foreach($dashboardData['weeklyAttendance'] as $day)
                                    {{ $day['absent'] }},
                                @endforeach
                            ],
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: textColor
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: gridColor
                                },
                                ticks: {
                                    color: textColor
                                }
                            },
                            x: {
                                grid: {
                                    color: gridColor
                                },
                                ticks: {
                                    color: textColor
                                }
                            }
                        }
                    }
                });
            }

        @elseif(auth()->user()->isFloorManager())
            // Team Performance Overview Chart (Donut)
            const userDistributionCtx = document.getElementById('userDistributionChart');
            if (userDistributionCtx) {
                new Chart(userDistributionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($dashboardData['teamPerformancePie']['labels']),
                        datasets: [{
                            data: @json($dashboardData['teamPerformancePie']['data']),
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#6366f1', '#14b8a6'],
                            borderWidth: 2,
                            borderColor: isDark ? '#1f2937' : '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 2000
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor,
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: isDark ? '#1f2937' : '#ffffff',
                                titleColor: textColor,
                                bodyColor: textColor,
                                borderColor: isDark ? '#374151' : '#e5e7eb',
                                borderWidth: 1
                            }
                        }
                    }
                });
            }

        @elseif(auth()->user()->isTeamLead())
            // Team Performance Overview Chart (Donut)
            const userDistributionCtx = document.getElementById('userDistributionChart');
            if (userDistributionCtx) {
                new Chart(userDistributionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($dashboardData['teamPerformancePie']['labels']),
                        datasets: [{
                            data: @json($dashboardData['teamPerformancePie']['data']),
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#6366f1', '#14b8a6'],
                            borderWidth: 2,
                            borderColor: isDark ? '#1f2937' : '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 2000
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor,
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: isDark ? '#1f2937' : '#ffffff',
                                titleColor: textColor,
                                bodyColor: textColor,
                                borderColor: isDark ? '#374151' : '#e5e7eb',
                                borderWidth: 1
                            }
                        }
                    }
                });
            }

        @elseif(auth()->user()->isAgent())
            // Personal Performance Chart - Modern Design
            const personalPerformanceCtx = document.getElementById('personalPerformanceChart');
            if (personalPerformanceCtx) {
                // Get performance data
                const performanceData = [
                                {{ auth()->user()->submissions()->whereDate('created_at', now()->startOfWeek()->addDays(0))->count() }},
                                {{ auth()->user()->submissions()->whereDate('created_at', now()->startOfWeek()->addDays(1))->count() }},
                                {{ auth()->user()->submissions()->whereDate('created_at', now()->startOfWeek()->addDays(2))->count() }},
                                {{ auth()->user()->submissions()->whereDate('created_at', now()->startOfWeek()->addDays(3))->count() }},
                                {{ auth()->user()->submissions()->whereDate('created_at', now()->startOfWeek()->addDays(4))->count() }},
                                {{ auth()->user()->submissions()->whereDate('created_at', now()->startOfWeek()->addDays(5))->count() }},
                                {{ auth()->user()->submissions()->whereDate('created_at', now()->startOfWeek()->addDays(6))->count() }}
                ];
                
                const maxValue = Math.max(...performanceData);
                const avgValue = performanceData.reduce((a, b) => a + b, 0) / performanceData.length;
                
                new Chart(personalPerformanceCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        datasets: [{
                            label: 'Daily Submissions',
                            data: performanceData,
                            backgroundColor: performanceData.map((value, index) => {
                                if (value >= avgValue * 1.2) return '#10b981'; // Green - Excellent
                                if (value >= avgValue) return '#3b82f6'; // Blue - Good
                                if (value >= avgValue * 0.7) return '#f59e0b'; // Yellow - Average
                                return '#ef4444'; // Red - Below Average
                            }),
                            borderColor: performanceData.map((value, index) => {
                                if (value >= avgValue * 1.2) return '#059669';
                                if (value >= avgValue) return '#2563eb';
                                if (value >= avgValue * 0.7) return '#d97706';
                                return '#dc2626';
                            }),
                            borderWidth: 2,
                            borderRadius: {
                                topLeft: 8,
                                topRight: 8,
                                bottomLeft: 0,
                                bottomRight: 0
                            },
                            borderSkipped: false,
                            // Add gradient effect
                            backgroundImage: performanceData.map((value, index) => {
                                const canvas = personalPerformanceCtx;
                                const ctx = canvas.getContext('2d');
                                const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
                                if (value >= avgValue * 1.2) {
                                    gradient.addColorStop(0, '#10b981');
                                    gradient.addColorStop(1, '#059669');
                                } else if (value >= avgValue) {
                                    gradient.addColorStop(0, '#3b82f6');
                                    gradient.addColorStop(1, '#2563eb');
                                } else if (value >= avgValue * 0.7) {
                                    gradient.addColorStop(0, '#f59e0b');
                                    gradient.addColorStop(1, '#d97706');
                                } else {
                                    gradient.addColorStop(0, '#ef4444');
                                    gradient.addColorStop(1, '#dc2626');
                                }
                                return gradient;
                            })
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart',
                            delay: (context) => {
                                let delay = 0;
                                if (context.type === 'data' && context.mode === 'default') {
                                    delay = context.dataIndex * 200 + context.datasetIndex * 100;
                                }
                                return delay;
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: isDark ? '#1f2937' : '#ffffff',
                                titleColor: textColor,
                                bodyColor: textColor,
                                borderColor: isDark ? '#374151' : '#e5e7eb',
                                borderWidth: 1,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    title: function(context) {
                                        const dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                        return dayNames[context[0].dataIndex];
                                    },
                                    label: function(context) {
                                        const value = context.parsed.y;
                                        const percentage = avgValue > 0 ? Math.round((value / avgValue) * 100) : 0;
                                        let status = '';
                                        if (value >= avgValue * 1.2) status = '🔥 Excellent';
                                        else if (value >= avgValue) status = '✅ Good';
                                        else if (value >= avgValue * 0.7) status = '⚠️ Average';
                                        else status = '📈 Needs Improvement';
                                        
                                        return [
                                            `${value} submissions`,
                                            `${percentage}% of weekly average`,
                                            status
                                        ];
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: Math.max(maxValue * 1.2, 10),
                                grid: {
                                    color: gridColor,
                                    drawBorder: false,
                                    lineWidth: 1
                                },
                                ticks: {
                                    color: textColor,
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    },
                                    callback: function(value) {
                                        return value === 0 ? '0' : value;
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: textColor,
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    }
                                }
                            }
                        },
                        elements: {
                            bar: {
                                hoverBackgroundColor: function(context) {
                                    const value = context.parsed.y;
                                    if (value >= avgValue * 1.2) return '#059669';
                                    if (value >= avgValue) return '#2563eb';
                                    if (value >= avgValue * 0.7) return '#d97706';
                                    return '#dc2626';
                                },
                                hoverBorderColor: function(context) {
                                    const value = context.parsed.y;
                                    if (value >= avgValue * 1.2) return '#047857';
                                    if (value >= avgValue) return '#1d4ed8';
                                    if (value >= avgValue * 0.7) return '#b45309';
                                    return '#b91c1c';
                                },
                                hoverBorderWidth: 3
                            }
                        }
                    }
                });
            }
        @endif
    @endauth
});
</script>
@endsection