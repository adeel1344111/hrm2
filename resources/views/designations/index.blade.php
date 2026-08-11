@extends('layouts.master')
@section('title') Designations @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Designations</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="#!" class="text-slate-400 dark:text-zink-200">Organization</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Designations</li>
            </ul>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-purple-600 mb-2">{{ $designations->total() }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Designations</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">All job positions</p>
                        <div class="flex items-center justify-center text-green-500 text-sm">
                            <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                            <span>+8%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-green-600 mb-2">{{ $designations->where('status', 'active')->count() }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Active Designations</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Currently hiring</p>
                        <div class="flex items-center justify-center text-green-500 text-sm">
                            <i data-lucide="activity" class="w-4 h-4 mr-1"></i>
                            <span>{{ $designations->total() > 0 ? round(($designations->where('status', 'active')->count() / $designations->total()) * 100) : 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-red-600 mb-2">{{ $designations->where('status', 'inactive')->count() }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Inactive Designations</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Not currently hiring</p>
                        <div class="flex items-center justify-center text-red-500 text-sm">
                            <i data-lucide="alert-triangle" class="w-4 h-4 mr-1"></i>
                            <span>{{ $designations->where('status', 'inactive')->count() > 0 ? 'Review needed' : 'All active' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-blue-600 mb-2">{{ \App\Models\User::where('user_type', 'agent')->count() }}</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Active Employees</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">With designations</p>
                        <div class="flex items-center justify-center text-blue-500 text-sm">
                            <i data-lucide="user-plus" class="w-4 h-4 mr-1"></i>
                            <span>+3 this week</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Designation Management</h6>
                        <p class="text-slate-500 dark:text-zink-200">Manage your organization's designations</p>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100" onclick="exportDesignations()">
                            <i data-lucide="file-down" class="w-4 h-4 mr-1"></i>
                            Export Designations
                        </button>
                        <a href="{{ route('designations.create') }}" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            <i data-lucide="plus-circle" class="w-4 h-4 mr-1"></i>
                            Add Designation
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="px-4 py-3 mb-4 text-sm text-green-500 border border-green-200 rounded-md bg-green-50 dark:bg-green-400/20 dark:border-green-500/50">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Search and Filter Section -->
                <div class="flex flex-col gap-4 mb-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search designations..." 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 w-64">
                            <i data-lucide="search" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        </div>
                        
                        <select id="statusFilter" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="button" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100" onclick="refreshTable()">
                            <i data-lucide="refresh-cw" class="w-4 h-4 mr-1"></i>
                            Refresh
                        </button>
                    </div>
                </div>


                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap" id="designationsTable">
                        <thead class="ltr:text-left rtl:text-right">
                            <tr class="border-b border-slate-200 dark:border-zink-500">
                                <th class="px-3.5 py-2.5 font-semibold cursor-pointer hover:text-custom-500" onclick="sortTable('name')">
                                    Name <i data-lucide="arrow-up-down" class="w-3 h-3 inline ml-1"></i>
                                </th>
                                <th class="px-3.5 py-2.5 font-semibold cursor-pointer hover:text-custom-500" onclick="sortTable('code')">
                                    Code <i data-lucide="arrow-up-down" class="w-3 h-3 inline ml-1"></i>
                                </th>
                                <th class="px-3.5 py-2.5 font-semibold">Description</th>
                                <th class="px-3.5 py-2.5 font-semibold cursor-pointer hover:text-custom-500" onclick="sortTable('status')">
                                    Status <i data-lucide="arrow-up-down" class="w-3 h-3 inline ml-1"></i>
                                </th>
                                <th class="px-3.5 py-2.5 font-semibold">Users</th>
                                <th class="px-3.5 py-2.5 font-semibold">Created</th>
                                <th class="px-3.5 py-2.5 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($designations as $designation)
                                <tr class="border-b border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600 transition-colors" data-designation-id="{{ $designation->id }}">
                                    <td class="px-3.5 py-2.5">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-10 h-10 text-white bg-purple-500 rounded-full">
                                                <i data-lucide="briefcase" class="w-5 h-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-15 font-semibold">{{ $designation->name }}</h6>
                                                <p class="text-xs text-slate-500 dark:text-zink-200">ID: {{ $designation->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <span class="px-3 py-1 text-xs font-medium text-purple-600 bg-purple-100 rounded-full dark:bg-purple-500/20 dark:text-purple-400">
                                            {{ $designation->code }}
                                        </span>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="max-w-xs">
                                            <span class="text-slate-500 dark:text-zink-200">
                                                {{ $designation->description ? Str::limit($designation->description, 60) : 'No description' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="flex items-center gap-2">
                                            @if($designation->status === 'active')
                                                <span class="px-3 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-full dark:bg-green-500/20 dark:text-green-400">
                                                    <i data-lucide="check-circle" class="w-3 h-3 inline mr-1"></i>
                                                    Active
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full dark:bg-red-500/20 dark:text-red-400">
                                                    <i data-lucide="x-circle" class="w-3 h-3 inline mr-1"></i>
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="flex items-center gap-1">
                                            <span class="px-2 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full dark:bg-blue-500/20 dark:text-blue-400">
                                                {{ \App\Models\User::where('user_type', 'agent')->count() }} users
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="text-sm text-slate-500 dark:text-zink-200">
                                            {{ $designation->created_at->format('M d, Y') }}
                                            <br>
                                            <span class="text-xs">{{ $designation->created_at->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="text-blue-500 hover:text-blue-600 p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-500/20" onclick="viewDesignation({{ $designation->id }})" title="View Details">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </button>
                                            <a href="{{ route('designations.edit', $designation) }}" class="text-green-500 hover:text-green-600 p-1 rounded hover:bg-green-50 dark:hover:bg-green-500/20" title="Edit">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </a>
                                            <button type="button" class="text-orange-500 hover:text-orange-600 p-1 rounded hover:bg-orange-50 dark:hover:bg-orange-500/20" onclick="toggleStatus({{ $designation->id }}, '{{ $designation->status }}')" title="Toggle Status">
                                                <i data-lucide="{{ $designation->status === 'active' ? 'pause' : 'play' }}" class="w-4 h-4"></i>
                                            </button>
                                            <form action="{{ route('designations.destroy', $designation) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this designation? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-600 p-1 rounded hover:bg-red-50 dark:hover:bg-red-500/20" title="Delete">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3.5 py-12 text-center text-slate-500 dark:text-zink-200">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="flex items-center justify-center w-16 h-16 text-slate-300 bg-slate-100 rounded-full dark:bg-zink-600 dark:text-zink-400">
                                                <i data-lucide="briefcase" class="w-8 h-8"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-lg font-semibold text-slate-600 dark:text-zink-200">No designations found</h6>
                                                <p class="text-sm">Get started by creating your first designation</p>
                                            </div>
                                            <a href="{{ route('designations.create') }}" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600">
                                                <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                                                Create Designation
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($designations->hasPages())
                    <x-pagination :paginator="$designations" />
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Designation Details Modal -->
<div id="designationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal()"></div>
        <div class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl dark:bg-zink-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-zink-100">Designation Details</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-zink-200">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div id="designationDetails" class="space-y-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- End Page-content -->

@section('script')
<script>
let currentSort = { column: '', direction: 'asc' };

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#designationsTable tbody tr');
    
    rows.forEach(row => {
        const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const code = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const description = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || code.includes(searchTerm) || description.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Status filter
document.getElementById('statusFilter').addEventListener('change', function(e) {
    const status = e.target.value;
    const rows = document.querySelectorAll('#designationsTable tbody tr');
    
    rows.forEach(row => {
        if (!status) {
            row.style.display = '';
            return;
        }
        
        const statusCell = row.querySelector('td:nth-child(5)');
        const isActive = statusCell.textContent.includes('Active');
        
        if ((status === 'active' && isActive) || (status === 'inactive' && !isActive)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});


function sortTable(column) {
    const table = document.getElementById('designationsTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    const direction = currentSort.column === column && currentSort.direction === 'asc' ? 'desc' : 'asc';
    currentSort = { column, direction };
    
    rows.sort((a, b) => {
        let aVal, bVal;
        
        switch(column) {
            case 'name':
                aVal = a.querySelector('td:nth-child(2)').textContent.trim();
                bVal = b.querySelector('td:nth-child(2)').textContent.trim();
                break;
            case 'code':
                aVal = a.querySelector('td:nth-child(3)').textContent.trim();
                bVal = b.querySelector('td:nth-child(3)').textContent.trim();
                break;
            case 'status':
                aVal = a.querySelector('td:nth-child(5)').textContent.includes('Active') ? 'active' : 'inactive';
                bVal = b.querySelector('td:nth-child(5)').textContent.includes('Active') ? 'active' : 'inactive';
                break;
            default:
                return 0;
        }
        
        if (direction === 'asc') {
            return aVal.localeCompare(bVal);
        } else {
            return bVal.localeCompare(aVal);
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

function viewDesignation(id) {
    // Load designation details via AJAX
    fetch(`/designations/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('designationDetails').innerHTML = `
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-16 h-16 text-white bg-purple-500 rounded-full">
                            <i data-lucide="briefcase" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold">${data.name}</h4>
                            <p class="text-sm text-gray-500">Code: ${data.code}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Status</label>
                            <p class="text-sm">${data.status}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Created</label>
                            <p class="text-sm">${data.created_at}</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="text-sm">${data.description || 'No description provided'}</p>
                    </div>
                </div>
            `;
            document.getElementById('designationModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading designation details');
        });
}

function closeModal() {
    document.getElementById('designationModal').classList.add('hidden');
}

function toggleStatus(id, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this designation?`)) {
        // Implement status toggle via AJAX
        fetch(`/designations/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating status');
        });
    }
}

function exportDesignations() {
    // Implement export functionality
    window.open('/designations/export', '_blank');
}

function refreshTable() {
    location.reload();
}

// Initialize tooltips and other UI enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects and animations
    const rows = document.querySelectorAll('#designationsTable tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>
@endsection
@endsection
