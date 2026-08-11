@extends('layouts.master')
@section('title') Active Employees @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Active Employees</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="#!" class="text-slate-400 dark:text-zink-200">Employees</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Active</li>
            </ul>
        </div>
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
                <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-3xl font-bold text-green-600 mb-2">{{ $stats['active_csr'] }}</h6>
                            <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Active CSR</p>
                            <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Customer Service</p>
                            <div class="flex items-center justify-center text-green-500 text-sm">
                                <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                                <span>+5%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['active_verifiers'] }}</h6>
                            <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Active Verifiers</p>
                            <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Verification Officers</p>
                            <div class="flex items-center justify-center text-blue-500 text-sm">
                                <i data-lucide="users" class="w-4 h-4 mr-1"></i>
                                <span>{{ $stats['total'] > 0 ? round(($stats['active_verifiers'] / $stats['total']) * 100) : 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-3xl font-bold text-purple-600 mb-2">{{ $stats['team_leads'] }}</h6>
                            <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Team Leads</p>
                            <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Supervisors</p>
                            <div class="flex items-center justify-center text-purple-500 text-sm">
                                <i data-lucide="user-check" class="w-4 h-4 mr-1"></i>
                                <span>{{ $stats['total'] > 0 ? round(($stats['team_leads'] / $stats['total']) * 100) : 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-3xl font-bold text-orange-600 mb-2">{{ $stats['floor_managers'] }}</h6>
                            <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Floor Managers</p>
                            <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Department heads</p>
                            <div class="flex items-center justify-center text-orange-500 text-sm">
                                <i data-lucide="shield-check" class="w-4 h-4 mr-1"></i>
                                <span>{{ $stats['total'] > 0 ? round(($stats['floor_managers'] / $stats['total']) * 100) : 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <button type="button" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100" onclick="exportEmployees()">
                        <i data-lucide="file-down" class="w-4 h-4 mr-1"></i>
                        Export Active Employees
                    </button>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Search employees..." class="form-input ltr:pl-10 rtl:pr-10">
                        <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-3 rtl:pr-3 pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                        </div>
                    </div>
                    
                    <select id="filterSelect" class="form-select">
                        <option value="">All Designations</option>
                        <option value="CSR">CSR</option>
                        <option value="Verification Officer">Verification Officer</option>
                    </select>
                </div>
            </div>

            <!-- Employees Table -->
            <div class="card">
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-slate-200 dark:divide-zink-500" id="employeesTable">
                            <thead class="bg-slate-50 dark:bg-zink-600">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider cursor-pointer" onclick="sortTable(0)">
                                        Employee <i data-lucide="chevron-up-down" class="w-4 h-4 inline ml-1"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider cursor-pointer" onclick="sortTable(1)">
                                        Employee ID <i data-lucide="chevron-up-down" class="w-4 h-4 inline ml-1"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider cursor-pointer" onclick="sortTable(2)">
                                        Designation <i data-lucide="chevron-up-down" class="w-4 h-4 inline ml-1"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider cursor-pointer" onclick="sortTable(3)">
                                        Appointment Date <i data-lucide="chevron-up-down" class="w-4 h-4 inline ml-1"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider cursor-pointer" onclick="sortTable(4)">
                                        Contact <i data-lucide="chevron-up-down" class="w-4 h-4 inline ml-1"></i>
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider cursor-pointer" onclick="sortTable(5)">
                                        Salary <i data-lucide="chevron-up-down" class="w-4 h-4 inline ml-1"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zink-700 divide-y divide-slate-200 dark:divide-zink-500">
                                @forelse($employees as $employee)
                                <tr class="hover:bg-slate-50 dark:hover:bg-zink-600">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-slate-200 dark:bg-zink-600 flex items-center justify-center">
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
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-slate-900 dark:text-zink-100">{{ $employee->name }}</div>
                                                <div class="text-sm text-slate-500 dark:text-zink-400">{{ $employee->employee_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                        {{ $employee->employee_id ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($employee->user_type === 'agent') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @elseif($employee->user_type === 'team_lead') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                            @elseif($employee->user_type === 'floor_manager') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                                            @elseif($employee->user_type === 'management') bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300
                                            @elseif($employee->user_type === 'admin') bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                            @endif">
                                            {{ $employee->designation ?: ($employee->user_type === 'management' ? 'Management' : ucfirst(str_replace('_', ' ', $employee->user_type))) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                        {{ $employee->appointment_date ? \Carbon\Carbon::parse($employee->appointment_date)->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                        {{ $employee->contact_number ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                        @if($employee->currentSalary)
                                            PKR {{ number_format((float)($employee->currentSalary->basic_salary ?? 0) + (float)($employee->currentSalary->punctuality ?? 0), 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                     <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                         <div class="flex items-center space-x-2">
                                             <a href="{{ route('employees.show', $employee) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View Details">
                                                 <i data-lucide="eye" class="w-4 h-4"></i>
                                             </a>
                                             @if(auth()->user()->isAdmin() || auth()->user()->isFloorManager() || (auth()->user()->isTeamLead() && $employee->team_lead_id === auth()->user()->id) || $employee->id === auth()->user()->id)
                                             <a href="{{ route('employees.edit', $employee) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Edit Employee">
                                                 <i data-lucide="edit" class="w-4 h-4"></i>
                                             </a>
                                             @endif
                                             <span id="status-container-{{ $employee->id }}">
                                                 <button onclick="toggleEmployeeStatus({{ $employee->id }}, 'inactive')" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" title="Deactivate">
                                                     <i data-lucide="pause-circle" class="w-4 h-4"></i>
                                                 </button>
                                              </span>
                                         </div>
                                     </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-slate-500 dark:text-zink-400">
                                        No active employees found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <!-- Pagination handled by TableManager -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Employee Details Modal -->
<div id="employeeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-slate-900 dark:text-zink-100">Employee Details</h3>
                <button onclick="closeEmployeeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div id="employeeDetails" class="space-y-3">
                <!-- Employee details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
// Initialized via TableManager
// Old search/filter functions removed

// Sort functionality
let sortDirection = {};
function sortTable(columnIndex) {
    const table = document.getElementById('employeesTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    
    const isAscending = sortDirection[columnIndex] !== 'asc';
    sortDirection = {}; // Reset other columns
    sortDirection[columnIndex] = isAscending ? 'asc' : 'desc';
    
    rows.sort((a, b) => {
        const aText = a.getElementsByTagName('td')[columnIndex].textContent.trim();
        const bText = b.getElementsByTagName('td')[columnIndex].textContent.trim();
        
        if (isAscending) {
            return aText.localeCompare(bText);
        } else {
            return bText.localeCompare(aText);
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

// View employee details
function viewEmployee(id) {
    // This would typically make an AJAX call to get employee details
    document.getElementById('employeeDetails').innerHTML = `
        <div class="text-center text-slate-500 dark:text-zink-400">
            <p>Loading employee details...</p>
            <p class="text-sm">Employee ID: ${id}</p>
        </div>
    `;
    document.getElementById('employeeModal').classList.remove('hidden');
}

// Close employee modal
function closeEmployeeModal() {
    document.getElementById('employeeModal').classList.add('hidden');
}

// Toggle employee status
function toggleEmployeeStatus(id, status) {
    const action = status === 'active' ? 'activate' : 'deactivate';
    fetch(`/employees/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Since we are on the Active Employees page, 
            // if we deactivate an employee, we should remove the row
            const container = document.getElementById(`status-container-${id}`);
            if (container) {
                const row = container.closest('tr');
                if (row) {
                    row.style.transition = 'opacity 0.3s ease';
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 300);
                }
            }
        } else {
            alert('Error: ' + (data.message || 'Unknown error occurred'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating status. Please try again.');
    });
}

// Export functionality
function exportEmployees() {
    alert('Export functionality will be implemented soon.');
}

// Initialize Lucide icons
</script>

@include('components.table-manager-script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Initialize Table Manager
        new TableManager({
            tableId: 'employeesTable',
            searchInputId: 'searchInput',
            filterInputs: ['#filterSelect'],
            rowsPerPage: 10
        });
    });
</script>
@endsection
