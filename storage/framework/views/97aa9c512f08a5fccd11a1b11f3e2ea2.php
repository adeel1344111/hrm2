
<?php $__env->startSection('title'); ?> Payroll Management <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Payroll Management</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('home')); ?>" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Payroll</li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h6 class="text-15">Payroll Calculations</h6>
                            <p class="text-slate-500 dark:text-zink-200">View and manage employee payroll calculations</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('payroll.index', ['last_month' => !$lastMonth])); ?>" 
                                   class="btn <?php echo e($lastMonth ? 'bg-custom-500 text-white border-custom-500' : 'bg-slate-100 border-slate-200 text-slate-500'); ?> hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                    <i data-lucide="<?php echo e($lastMonth ? 'calendar' : 'calendar-check'); ?>" class="w-4 h-4 mr-1"></i>
                                    <?php echo e($lastMonth ? 'Current Month' : 'Last Month'); ?>

                                </a>
                                <a href="<?php echo e(route('payroll.export', ['last_month' => $lastMonth])); ?>" 
                                   class="btn bg-green-500 text-white border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                                    <i data-lucide="download" class="w-4 h-4 mr-1"></i>
                                    Export CSV
                                </a>
                                <button type="button" onclick="openCustomExportModal()" 
                                   class="btn bg-purple-500 text-white border-purple-500 hover:text-white hover:bg-purple-600 hover:border-purple-600 focus:text-white focus:bg-purple-600 focus:border-purple-600 focus:ring focus:ring-purple-100 active:text-white active:bg-purple-600 active:border-purple-600 active:ring active:ring-purple-100 dark:ring-purple-400/20">
                                    <i data-lucide="file-spreadsheet" class="w-4 h-4 mr-1"></i>
                                    Custom Export
                                </button>
                            </div>
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Search employees..." class="form-input ltr:pl-10 rtl:pr-10" onkeyup="searchTable()">
                                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-3 rtl:pr-3 pointer-events-none">
                                    <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if(count($payrolls) > 0): ?>
                        <!-- ... (existing table code) ... -->
                        <div class="overflow-x-auto">
                            <table id="payrollTable" class="w-full text-sm text-left text-slate-500 dark:text-zink-200">
                                <!-- ... -->
                                <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-zink-600 dark:text-zink-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Employee</th>
                                        <th scope="col" class="px-6 py-3">Working Days</th>
                                        <th scope="col" class="px-6 py-3">Total Salary</th>
                                        <th scope="col" class="px-6 py-3">Bonus</th>
                                        <th scope="col" class="px-6 py-3">Dec Salary</th>
                                        <th scope="col" class="px-6 py-3">Training Bonus</th>
                                        <th scope="col" class="px-6 py-3">Dock</th>
                                        <th scope="col" class="px-6 py-3">Late Count</th>
                                        <th scope="col" class="px-6 py-3">Presents</th>
                                        <th scope="col" class="px-6 py-3">Absent</th>
                                        <th scope="col" class="px-6 py-3">Unpaids</th>
                                        <th scope="col" class="px-6 py-3">NCNS</th>
                                        <th scope="col" class="px-6 py-3">Half Days</th>
                                        <th scope="col" class="px-6 py-3">Final Salary</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="bg-white border-b border-slate-200 dark:bg-zink-700 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-600">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-zink-600 flex items-center justify-center mr-3">
                                                        <span class="text-sm font-medium text-slate-800 dark:text-zink-200">
                                                            <?php echo e(implode('', array_map(function($word) { return strtoupper(substr($word, 0, 1)); }, explode(' ', $payroll['name'])))); ?>

                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-slate-900 dark:text-zink-100"><?php echo e($payroll['name']); ?></div>
                                                        <div class="text-sm text-slate-500 dark:text-zink-400"><?php echo e($payroll['employee_code']); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium"><?php echo e($payroll['total_working_days']); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium">PKR <?php echo e(number_format($payroll['basic_salary'] + $payroll['punctuality'])); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium">PKR <?php echo e(number_format($payroll['bonus'])); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium">PKR <?php echo e(number_format($payroll['arrears_amount'] ?? 0)); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium">PKR <?php echo e(number_format($payroll['training_bonus'])); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium">PKR <?php echo e(number_format($payroll['dock'])); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium"><?php echo e($payroll['late_count']); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium text-green-600 dark:text-green-400"><?php echo e($payroll['presents']); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium text-red-600 dark:text-red-400"><?php echo e($payroll['absent_count']); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium text-orange-600 dark:text-orange-400"><?php echo e($payroll['unpaid_count']); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium text-purple-600 dark:text-purple-400"><?php echo e($payroll['ncns_count']); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-medium text-blue-600 dark:text-blue-400"><?php echo e($payroll['half_days']); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-bold text-lg text-custom-500 dark:text-custom-400">
                                                    PKR <?php echo e(number_format($payroll['final_salary'])); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <a href="<?php echo e(route('payroll.show', $payroll['employee_code'])); ?>?last_month=<?php echo e($lastMonth); ?>" 
                                                       class="text-custom-500 hover:text-custom-600 dark:text-custom-400 dark:hover:text-custom-300">
                                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Cards -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mt-8">
                            <!-- ... existing summary cards ... -->
                            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h6 class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2"><?php echo e(count($payrolls)); ?></h6>
                                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Employees</p>
                                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">In payroll system</p>
                                        <div class="flex items-center justify-center text-blue-500 dark:text-blue-400 text-sm">
                                            <i data-lucide="users" class="w-4 h-4 mr-1"></i>
                                            <span>Active</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h6 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2"><?php echo e(number_format(array_sum(array_column($payrolls, 'final_salary')) / 1000, 0)); ?>K</h6>
                                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Payroll</p>
                                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">PKR <?php echo e(number_format(array_sum(array_column($payrolls, 'final_salary')))); ?></p>
                                        <div class="flex items-center justify-center text-green-500 dark:text-green-400 text-sm">
                                            <i data-lucide="dollar-sign" class="w-4 h-4 mr-1"></i>
                                            <span>Amount</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h6 class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2"><?php echo e($payrolls[0]['period'] ?? 'N/A'); ?></h6>
                                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Payroll Period</p>
                                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Current month</p>
                                        <div class="flex items-center justify-center text-purple-500 dark:text-purple-400 text-sm">
                                            <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                            <span>Period</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h6 class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2"><?php echo e(count($payrolls) > 0 ? round(array_sum(array_column($payrolls, 'final_salary')) / count($payrolls)) : 0); ?></h6>
                                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Average Salary</p>
                                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Per employee</p>
                                        <div class="flex items-center justify-center text-orange-500 dark:text-orange-400 text-sm">
                                            <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                                            <span>Average</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-zink-600 flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="calculator" class="w-8 h-8 text-slate-400 dark:text-zink-500"></i>
                            </div>
                            <h6 class="text-lg font-semibold text-slate-900 dark:text-zink-100 mb-2">No Payroll Data</h6>
                            <p class="text-slate-500 dark:text-zink-400">No payroll calculations found for the selected period.</p>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Custom Export Modal -->
<div id="custom-export-modal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-xl dark:bg-zink-700">
            <h5 class="text-lg font-semibold text-slate-800 dark:text-zink-100 mb-4">Custom Payroll Export</h5>
            <form action="<?php echo e(route('payroll.custom-export')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Employee IDs
                        <span class="text-xs font-normal text-slate-500 dark:text-slate-400 ml-1">Paste IDs separated by new lines. Order will be preserved.</span>
                    </label>
                    <textarea name="employee_ids" class="form-textarea w-full border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 font-mono text-sm" rows="6" placeholder="e.g.&#10;MK884&#10;MK883&#10;MK444" required></textarea>
                </div>
                
                <div class="mb-4">
                     <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="last_month" value="1" class="form-checkbox border-slate-200 dark:border-zink-500 text-custom-500 focus:ring-0" <?php echo e($lastMonth ? 'checked' : ''); ?>>
                        <span class="ml-2 text-sm text-slate-600 dark:text-zink-200">Export for Last Month</span>
                    </label>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                        Columns to Include
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="export_columns[]" value="bonus" class="form-checkbox border-slate-200 dark:border-zink-500 text-custom-500 focus:ring-0" checked>
                            <span class="ml-2 text-sm text-slate-600 dark:text-zink-200">Bonus</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="export_columns[]" value="dec_salary" class="form-checkbox border-slate-200 dark:border-zink-500 text-custom-500 focus:ring-0" checked>
                            <span class="ml-2 text-sm text-slate-600 dark:text-zink-200">Dec Salary</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="export_columns[]" value="training_bonus" class="form-checkbox border-slate-200 dark:border-zink-500 text-custom-500 focus:ring-0" checked>
                            <span class="ml-2 text-sm text-slate-600 dark:text-zink-200">Training Bonus</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="export_columns[]" value="dock" class="form-checkbox border-slate-200 dark:border-zink-500 text-custom-500 focus:ring-0" checked>
                            <span class="ml-2 text-sm text-slate-600 dark:text-zink-200">Dock</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="export_columns[]" value="late_count" class="form-checkbox border-slate-200 dark:border-zink-500 text-custom-500 focus:ring-0" checked>
                            <span class="ml-2 text-sm text-slate-600 dark:text-zink-200">Late Count</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeCustomExportModal()" class="btn bg-slate-200 text-slate-800 border-slate-200 hover:bg-slate-300 hover:border-slate-300 focus:bg-slate-300 focus:border-slate-300 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100">
                        Cancel
                    </button>
                    <button type="submit" class="btn bg-purple-500 text-white border-purple-500 hover:text-white hover:bg-purple-600 hover:border-purple-600 focus:text-white focus:bg-purple-600 focus:border-purple-600 focus:ring focus:ring-purple-100 active:text-white active:bg-purple-600 active:border-purple-600 active:ring active:ring-purple-100 dark:ring-purple-400/20">
                        Export CSV
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal functions
function openCustomExportModal() {
    document.getElementById('custom-export-modal').classList.remove('hidden');
}

function closeCustomExportModal() {
    document.getElementById('custom-export-modal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('custom-export-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCustomExportModal();
    }
});

// Search functionality
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('payrollTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        row.style.display = found ? '' : 'none';
    }
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/payroll/index.blade.php ENDPATH**/ ?>