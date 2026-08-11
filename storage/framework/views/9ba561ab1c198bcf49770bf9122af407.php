<?php $__env->startSection('title'); ?> Departments <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Departments</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="#!" class="text-slate-400 dark:text-zink-200">Organization</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Departments</li>
            </ul>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-blue-600 mb-2"><?php echo e($departments->count()); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Departments</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">All departments in system</p>
                        <div class="flex items-center justify-center text-green-500 text-sm">
                            <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                            <span>+12%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-green-600 mb-2"><?php echo e($departments->where('status', 'active')->count()); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Active Departments</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Currently operational</p>
                        <div class="flex items-center justify-center text-green-500 text-sm">
                            <i data-lucide="activity" class="w-4 h-4 mr-1"></i>
                            <span><?php echo e($departments->count() > 0 ? round(($departments->where('status', 'active')->count() / $departments->count()) * 100) : 0); ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-red-600 mb-2"><?php echo e($departments->where('status', 'inactive')->count()); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Inactive Departments</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Temporarily disabled</p>
                        <div class="flex items-center justify-center text-red-500 text-sm">
                            <i data-lucide="alert-triangle" class="w-4 h-4 mr-1"></i>
                            <span><?php echo e($departments->where('status', 'inactive')->count() > 0 ? 'Needs attention' : 'All good'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-purple-600 mb-2"><?php echo e(\App\Models\User::count()); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Employees</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Across all departments</p>
                        <div class="flex items-center justify-center text-blue-500 text-sm">
                            <i data-lucide="user-plus" class="w-4 h-4 mr-1"></i>
                            <span>+5 this month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Department Management</h6>
                        <p class="text-slate-500 dark:text-zink-200">Manage your organization's departments</p>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100" onclick="exportDepartments()">
                            <i data-lucide="file-down" class="w-4 h-4 mr-1"></i>
                            Export Departments
                        </button>
                        <a href="<?php echo e(route('departments.create')); ?>" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            <i data-lucide="plus-circle" class="w-4 h-4 mr-1"></i>
                            Add Department
                        </a>
                    </div>
                </div>

                <?php if(session('success')): ?>
                    <div class="px-4 py-3 mb-4 text-sm text-green-500 border border-green-200 rounded-md bg-green-50 dark:bg-green-400/20 dark:border-green-500/50">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <!-- Search and Filter Section -->
                <div class="flex flex-col gap-4 mb-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search departments..." 
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
                    <table class="w-full whitespace-nowrap" id="departmentsTable">
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
                            <?php $__empty_1 = true; $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="border-b border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600 transition-colors" data-department-id="<?php echo e($department->id); ?>">
                                    <td class="px-3.5 py-2.5">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-10 h-10 text-white bg-purple-500 rounded-full">
                                                <i data-lucide="briefcase" class="w-5 h-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-15 font-semibold"><?php echo e($department->name); ?></h6>
                                                <p class="text-xs text-slate-500 dark:text-zink-200">ID: <?php echo e($department->id); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <span class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full dark:bg-blue-500/20 dark:text-blue-400">
                                            <?php echo e($department->code); ?>

                                        </span>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="max-w-xs">
                                            <span class="text-slate-500 dark:text-zink-200">
                                                <?php echo e($department->description ? Str::limit($department->description, 60) : 'No description'); ?>

                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="flex items-center gap-2">
                                            <?php if($department->status === 'active'): ?>
                                                <span class="px-3 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-full dark:bg-green-500/20 dark:text-green-400">
                                                    <i data-lucide="check-circle" class="w-3 h-3 inline mr-1"></i>
                                                    Active
                                                </span>
                                            <?php else: ?>
                                                <span class="px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full dark:bg-red-500/20 dark:text-red-400">
                                                    <i data-lucide="x-circle" class="w-3 h-3 inline mr-1"></i>
                                                    Inactive
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="flex items-center gap-1">
                                            <span class="px-2 py-1 text-xs font-medium text-purple-600 bg-purple-100 rounded-full dark:bg-purple-500/20 dark:text-purple-400">
                                                <?php echo e(\App\Models\User::where('department', $department->name)->count()); ?> users
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="text-sm text-slate-500 dark:text-zink-200">
                                            <?php echo e($department->created_at->format('M d, Y')); ?>

                                            <br>
                                            <span class="text-xs"><?php echo e($department->created_at->diffForHumans()); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="text-blue-500 hover:text-blue-600 p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-500/20" onclick="viewDepartment(<?php echo e($department->id); ?>)" title="View Details">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </button>
                                            <a href="<?php echo e(route('departments.edit', $department)); ?>" class="text-green-500 hover:text-green-600 p-1 rounded hover:bg-green-50 dark:hover:bg-green-500/20" title="Edit">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </a>
                                            <button type="button" class="text-orange-500 hover:text-orange-600 p-1 rounded hover:bg-orange-50 dark:hover:bg-orange-500/20" onclick="toggleStatus(<?php echo e($department->id); ?>, '<?php echo e($department->status); ?>')" title="Toggle Status">
                                                <i data-lucide="<?php echo e($department->status === 'active' ? 'pause' : 'play'); ?>" class="w-4 h-4"></i>
                                            </button>
                                            <form action="<?php echo e(route('departments.destroy', $department)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this department? This action cannot be undone.')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-500 hover:text-red-600 p-1 rounded hover:bg-red-50 dark:hover:bg-red-500/20" title="Delete">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-3.5 py-12 text-center text-slate-500 dark:text-zink-200">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="flex items-center justify-center w-16 h-16 text-slate-300 bg-slate-100 rounded-full dark:bg-zink-600 dark:text-zink-400">
                                                <i data-lucide="building" class="w-8 h-8"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-lg font-semibold text-slate-600 dark:text-zink-200">No departments found</h6>
                                                <p class="text-sm">Get started by creating your first department</p>
                                            </div>
                                            <a href="<?php echo e(route('departments.create')); ?>" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600">
                                                <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                                                Create Department
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Loaded all records for client-side search -->
            </div>
        </div>
    </div>
</div>

<!-- Department Details Modal -->
<div id="departmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal()"></div>
        <div class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl dark:bg-zink-700 border border-slate-200 dark:border-zink-600">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-zink-100">Department Details</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-zink-200">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div id="departmentDetails" class="space-y-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- End Page-content -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
let currentSort = { column: '', direction: 'asc' };

// Initialized via TableManager
// Old search/filter event listeners removed


function sortTable(column) {
    const table = document.getElementById('departmentsTable');
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

function viewDepartment(id) {
    // Load department details via AJAX
    fetch(`/departments/${id}`, {
        headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(response => response.json())
        .then(data => {
            const createdAt = new Date(data.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const statusBadge = data.status === 'active' 
                ? '<span class="px-3 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-full dark:bg-green-500/20 dark:text-green-400"><i data-lucide="check-circle" class="w-3 h-3 inline mr-1"></i>Active</span>'
                : '<span class="px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full dark:bg-red-500/20 dark:text-red-400"><i data-lucide="x-circle" class="w-3 h-3 inline mr-1"></i>Inactive</span>';

            document.getElementById('departmentDetails').innerHTML = `
                <div class="space-y-6">
                    <div class="flex items-center gap-5 p-4 bg-slate-50 dark:bg-zink-600/50 rounded-xl">
                        <div class="flex items-center justify-center w-16 h-16 text-white bg-custom-500 shadow-lg shadow-custom-500/20 rounded-xl">
                            <i data-lucide="briefcase" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-slate-800 dark:text-white">${data.name}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2.5 py-0.5 rounded text-xs font-medium bg-slate-200 text-slate-600 dark:bg-zink-500 dark:text-zink-100">Code: ${data.code}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-4 border border-dashed rounded-lg border-slate-200 dark:border-zink-500">
                            <label class="block mb-2 text-xs font-medium uppercase text-slate-500 dark:text-zink-200">Current Status</label>
                            <div>${statusBadge}</div>
                        </div>
                        <div class="p-4 border border-dashed rounded-lg border-slate-200 dark:border-zink-500">
                            <label class="block mb-2 text-xs font-medium uppercase text-slate-500 dark:text-zink-200">Date Created</label>
                            <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-zink-50">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                                ${createdAt}
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 rounded-lg bg-orange-50 dark:bg-orange-500/10 dark:text-orange-200">
                        <label class="flex items-center gap-2 mb-2 text-sm font-semibold text-orange-700 dark:text-orange-400">
                            <i data-lucide="file-text" class="w-4 h-4"></i> Description
                        </label>
                        <p class="text-sm leading-relaxed text-slate-600 dark:text-zink-100 opacity-90">
                            ${data.description || 'No description provided for this department.'}
                        </p>
                    </div>
                </div>
            `;
            document.getElementById('departmentModal').classList.remove('hidden');
            lucide.createIcons();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading department details');
        });
}

function closeModal() {
    document.getElementById('departmentModal').classList.add('hidden');
}

function toggleStatus(id, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this department?`)) {
        // Implement status toggle via AJAX
        fetch(`/departments/${id}/toggle-status`, {
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

function exportDepartments() {
    // Implement export functionality
    window.open('/departments/export', '_blank');
}

function refreshTable() {
    location.reload();
}

// Initialize tooltips and other UI enhancements
<?php echo $__env->make('components.table-manager-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Table Manager
        new TableManager({
            tableId: 'departmentsTable',
            searchInputId: 'searchInput',
            filterInputs: ['#statusFilter'],
            rowsPerPage: 10
        });

        // Add hover effects and animations
        const rows = document.querySelectorAll('#departmentsTable tbody tr');
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/departments/index.blade.php ENDPATH**/ ?>