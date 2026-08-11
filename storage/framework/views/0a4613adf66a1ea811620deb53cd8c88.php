
<?php $__env->startSection('title'); ?> Payroll Management <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <!-- Header -->
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Payroll Management</h5>
                <p class="text-slate-500 dark:text-zink-200">Manage employee bonuses, deductions, and payroll adjustments.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('payroll.management.bulk')); ?>" class="btn bg-custom-500 text-white hover:bg-custom-600 border-custom-500 hover:border-custom-600 focus:ring focus:ring-custom-100 flex items-center">
                    <i data-lucide="upload" class="w-4 h-4 mr-1"></i>
                    Bulk Add
                </a>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="<?php echo e(route('payroll.index')); ?>" class="text-slate-400 dark:text-zink-200">Payroll</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">Management</li>
                </ul>
            </div>
        </div>

        <?php if(session('success')): ?>
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                <span class="text-green-600 font-medium"><?php echo e(session('success')); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <div class="flex items-center">
                <i data-lucide="x-circle" class="w-5 h-5 text-red-600 mr-2"></i>
                <span class="text-red-600 font-medium"><?php echo e(session('error')); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Add New Entry Form -->
        <div class="card mb-6">
            <div class="card-body">
                <h6 class="text-15 mb-4">Add Payroll Entry</h6>
                <form action="<?php echo e(route('payroll.management.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="employee_id" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Employee</label>
                            <select id="employee_id" name="employee_id" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Select Employee</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>" <?php echo e(old('employee_id') == $employee->id ? 'selected' : ''); ?>>
                                    <?php echo e($employee->name); ?> (<?php echo e($employee->employee_id); ?>)
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="month" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Month</label>
                            <select id="month" name="month" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 <?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Select Month</option>
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo e(date('F Y', mktime(0, 0, 0, $i, 1, date('Y')))); ?>" <?php echo e(old('month') == date('F Y', mktime(0, 0, 0, $i, 1, date('Y'))) ? 'selected' : ''); ?>>
                                    <?php echo e(date('F Y', mktime(0, 0, 0, $i, 1, date('Y')))); ?>

                                </option>
                                <?php endfor; ?>
                            </select>
                            <?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="dock_value" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Dock Value</label>
                            <input type="number" id="dock_value" name="dock_value" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 <?php $__errorArgs = ['dock_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('dock_value', 0)); ?>">
                            <?php $__errorArgs = ['dock_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="bonus" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Bonus</label>
                            <input type="number" id="bonus" name="bonus" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 <?php $__errorArgs = ['bonus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('bonus', 0)); ?>">
                            <?php $__errorArgs = ['bonus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="ref_bonus" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Ref Bonus</label>
                            <input type="number" id="ref_bonus" name="ref_bonus" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 <?php $__errorArgs = ['ref_bonus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('ref_bonus', 0)); ?>">
                            <?php $__errorArgs = ['ref_bonus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="plan" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Plan</label>
                            <input type="number" id="plan" name="plan" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 <?php $__errorArgs = ['plan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('plan', 0)); ?>">
                            <?php $__errorArgs = ['plan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="advance" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Advance</label>
                            <input type="number" id="advance" name="advance" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 <?php $__errorArgs = ['advance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('advance', 0)); ?>">
                            <?php $__errorArgs = ['advance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="btn bg-custom-500 text-white hover:bg-custom-600 w-full">
                                <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                                Add Entry
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payroll Management Table -->
        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Payroll Management Records</h6>
                        <p class="text-slate-500 dark:text-zink-200">Manage employee payroll adjustments and bonuses</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-zink-600">
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Employee Name
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Employee ID
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Dock Value
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Bonus
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Ref Bonus
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Plan
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Advance
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Month
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zink-700 divide-y divide-gray-200 dark:divide-gray-700">
                            <?php $__empty_1 = true; $__currentLoopData = \App\Models\PayrollManagement::with('employee')->orderBy('month', 'desc')->orderBy('employee_id')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-zink-600">
                                <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <?php echo e($payroll->employee->name); ?>

                                </td>
                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <?php echo e($payroll->employee->employee_id); ?>

                                </td>
                                <td class="px-4 py-3 text-center text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($payroll->dock_value > 0 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-slate-100 text-slate-800 dark:bg-slate-900 dark:text-slate-300'); ?>">
                                        <?php echo e(number_format($payroll->dock_value, 2)); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($payroll->bonus > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-slate-100 text-slate-800 dark:bg-slate-900 dark:text-slate-300'); ?>">
                                        <?php echo e(number_format($payroll->bonus, 2)); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($payroll->ref_bonus > 0 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-slate-100 text-slate-800 dark:bg-slate-900 dark:text-slate-300'); ?>">
                                        <?php echo e(number_format($payroll->ref_bonus, 2)); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($payroll->plan > 0 ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 'bg-slate-100 text-slate-800 dark:bg-slate-900 dark:text-slate-300'); ?>">
                                        <?php echo e(number_format($payroll->plan, 2)); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($payroll->advance > 0 ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300' : 'bg-slate-100 text-slate-800 dark:bg-slate-900 dark:text-slate-300'); ?>">
                                        <?php echo e(number_format($payroll->advance, 2)); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                        <?php echo e($payroll->month); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="editPayroll(<?php echo e($payroll->id); ?>)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button onclick="deletePayroll(<?php echo e($payroll->id); ?>)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-slate-500 dark:text-zink-400 border border-slate-200 dark:border-zink-500">
                                    <div class="flex flex-col items-center">
                                        <i data-lucide="file-text" class="w-12 h-12 text-slate-400 mb-2"></i>
                                        <p>No payroll management records found.</p>
                                        <p class="text-sm">Add your first payroll entry using the form above.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-zink-700 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h6 class="text-15">Edit Payroll Entry</h6>
                    <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <form id="editForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_employee_id" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Employee</label>
                            <select id="edit_employee_id" name="employee_id" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500" required>
                                <option value="">Select Employee</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>">
                                    <?php echo e($employee->name); ?> (<?php echo e($employee->employee_id); ?>)
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div>
                            <label for="edit_month" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Month</label>
                            <select id="edit_month" name="month" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500" required>
                                <option value="">Select Month</option>
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo e(date('F Y', mktime(0, 0, 0, $i, 1, date('Y')))); ?>">
                                    <?php echo e(date('F Y', mktime(0, 0, 0, $i, 1, date('Y')))); ?>

                                </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div>
                            <label for="edit_dock_value" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Dock Value</label>
                            <input type="number" id="edit_dock_value" name="dock_value" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                        </div>

                        <div>
                            <label for="edit_bonus" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Bonus</label>
                            <input type="number" id="edit_bonus" name="bonus" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                        </div>

                        <div>
                            <label for="edit_ref_bonus" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Ref Bonus</label>
                            <input type="number" id="edit_ref_bonus" name="ref_bonus" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                        </div>

                        <div>
                            <label for="edit_plan" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Plan</label>
                            <input type="number" id="edit_plan" name="plan" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                        </div>

                        <div>
                            <label for="edit_advance" class="inline-block mb-2 text-slate-500 dark:text-zink-200">Advance</label>
                            <input type="number" id="edit_advance" name="advance" step="0.01" min="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-200 dark:border-zink-600">
                        <button type="button" onclick="closeEditModal()" class="btn btn-sm bg-slate-500 text-white hover:bg-slate-600">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-sm bg-custom-500 text-white hover:bg-custom-600">
                            <i data-lucide="save" class="w-4 h-4 mr-1"></i>
                            Update Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-zink-700 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h6 class="text-15">Confirm Delete</h6>
                    <button onclick="closeDeleteModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <p class="text-slate-600 dark:text-zink-300 mb-6">
                    Are you sure you want to delete this payroll entry? This action cannot be undone.
                </p>
                
                <div class="flex items-center justify-end gap-3">
                    <button onclick="closeDeleteModal()" class="btn btn-sm bg-slate-500 text-white hover:bg-slate-600">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm bg-red-500 text-white hover:bg-red-600">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                            Delete Entry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
let currentEditId = null;
let currentDeleteId = null;

function editPayroll(id) {
    currentEditId = id;
    
    // Fetch payroll data
    fetch(`<?php echo e(url('payroll/management')); ?>/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate form fields
                document.getElementById('edit_employee_id').value = data.data.employee_id;
                document.getElementById('edit_month').value = data.data.month;
                document.getElementById('edit_dock_value').value = data.data.dock_value;
                document.getElementById('edit_bonus').value = data.data.bonus;
                document.getElementById('edit_ref_bonus').value = data.data.ref_bonus;
                document.getElementById('edit_plan').value = data.data.plan;
                document.getElementById('edit_advance').value = data.data.advance;
                
                // Update form action
                document.getElementById('editForm').action = `<?php echo e(url('payroll/management')); ?>/${id}`;
                
                // Show modal
                document.getElementById('editModal').classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading payroll data');
        });
}

function deletePayroll(id) {
    currentDeleteId = id;
    
    // Update form action
    document.getElementById('deleteForm').action = `<?php echo e(url('payroll/management')); ?>/${id}`;
    
    // Show modal
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    currentEditId = null;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    currentDeleteId = null;
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === editModal) {
        closeEditModal();
    }
    
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEditModal();
        closeDeleteModal();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/payroll/management.blade.php ENDPATH**/ ?>