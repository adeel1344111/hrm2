
<?php $__env->startSection('title'); ?> Payroll Details <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Payroll Details</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('home')); ?>" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('payroll.index')); ?>" class="text-slate-400 dark:text-zink-200">Payroll</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Details</li>
            </ul>
        </div>

        <?php if(isset($error) || !$payroll): ?>
            <div class="card">
                <div class="card-body">
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="mb-4">
                            <i data-lucide="alert-circle" class="w-16 h-16 text-red-500"></i>
                        </div>
                        <h5 class="mb-2 text-xl font-semibold text-slate-900 dark:text-zink-100">No Payroll Data Found</h5>
                        <p class="text-slate-500 dark:text-zink-400 mb-6"><?php echo e($error ?? 'No payroll data found for this employee.'); ?></p>
                        <?php if(auth()->user()->isAgent()): ?>
                            <p class="text-sm text-slate-400 dark:text-zink-300 mb-4">Please contact your administrator if you believe this is an error.</p>
                        <?php else: ?>
                            <a href="<?php echo e(route('payroll.index')); ?>" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600">
                                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                                Back to Payroll List
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
        <div class="card">
            <div class="card-body">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h6 class="text-15">Payroll Details</h6>
                            <p class="text-slate-500 dark:text-zink-200">Detailed breakdown of salary calculation for <?php echo e($payroll['name']); ?></p>
                        </div>
                        <div class="flex gap-2">
                            <?php if(!auth()->user()->isAgent()): ?>
                            <a href="<?php echo e(route('payroll.index', ['last_month' => $lastMonth])); ?>" 
                               class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100">
                                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                                Back to Payroll
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Employee Information -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-8">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-15 font-semibold text-slate-900 dark:text-zink-100 mb-4">Employee Information</h6>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-zink-600 flex items-center justify-center mr-4">
                                            <span class="text-lg font-medium text-slate-800 dark:text-zink-200">
                                                <?php echo e(implode('', array_map(function($word) { return strtoupper(substr($word, 0, 1)); }, explode(' ', $payroll['name'])))); ?>

                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="font-semibold text-slate-900 dark:text-zink-100"><?php echo e($payroll['name']); ?></h6>
                                            <p class="text-sm text-slate-500 dark:text-zink-400"><?php echo e($payroll['employee_code']); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">User Type:</span>
                                        <span class="font-medium"><?php echo e(ucfirst(str_replace('_', ' ', $payroll['user_type']))); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Department:</span>
                                        <span class="font-medium"><?php echo e($payroll['department'] ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Period:</span>
                                        <span class="font-medium"><?php echo e($payroll['period']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-15 font-semibold text-slate-900 dark:text-zink-100 mb-4">Salary Summary</h6>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Basic Salary:</span>
                                        <span class="font-medium">PKR <?php echo e(number_format($payroll['basic_salary'])); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Punctuality:</span>
                                        <span class="font-medium">PKR <?php echo e(number_format($payroll['punctuality'])); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Working Days:</span>
                                        <span class="font-medium"><?php echo e($payroll['total_working_days']); ?></span>
                                    </div>
                                    <div class="flex justify-between border-t border-slate-200 dark:border-zink-500 pt-3">
                                        <span class="text-lg font-semibold text-slate-900 dark:text-zink-100">Final Salary:</span>
                                        <span class="text-lg font-bold text-custom-500 dark:text-custom-400">PKR <?php echo e(number_format($payroll['final_salary'])); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Details -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-8">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-15 font-semibold text-slate-900 dark:text-zink-100 mb-4">Attendance Details</h6>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Present Days:</span>
                                        <span class="font-medium text-green-600 dark:text-green-400"><?php echo e($payroll['presents']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Absent Days:</span>
                                        <span class="font-medium text-red-600 dark:text-red-400"><?php echo e($payroll['absent_count']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">NCNS Days:</span>
                                        <span class="font-medium text-orange-600 dark:text-orange-400"><?php echo e($payroll['ncns_count']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Half Days:</span>
                                        <span class="font-medium text-blue-600 dark:text-blue-400"><?php echo e($payroll['half_days']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Holidays:</span>
                                        <span class="font-medium text-purple-600 dark:text-purple-400"><?php echo e($payroll['holiday_count']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500 dark:text-zink-400">Unpaid Days:</span>
                                        <span class="font-medium text-gray-600 dark:text-gray-400"><?php echo e($payroll['unpaid_count']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-15 font-semibold text-slate-900 dark:text-zink-100 mb-4">Deductions & Bonuses</h6>
                                <div class="space-y-3">
                                    <?php if($payroll['late_deduction'] > 0): ?>
                                        <div class="flex justify-between">
                                            <span class="text-slate-500 dark:text-zink-400">Late Deduction:</span>
                                            <span class="font-medium text-red-600 dark:text-red-400">-PKR <?php echo e(number_format($payroll['late_deduction'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($payroll['dock'] > 0): ?>
                                        <div class="flex justify-between">
                                            <span class="text-slate-500 dark:text-zink-400">Dock:</span>
                                            <span class="font-medium text-red-600 dark:text-red-400">-PKR <?php echo e(number_format($payroll['dock'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($payroll['training_bonus'] > 0): ?>
                                        <div class="flex justify-between">
                                            <span class="text-slate-500 dark:text-zink-400">Training Bonus:</span>
                                            <span class="font-medium text-green-600 dark:text-green-400">+PKR <?php echo e(number_format($payroll['training_bonus'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(isset($payroll['arrears_amount']) && $payroll['arrears_amount'] > 0): ?>
                                        <div class="flex justify-between">
                                            <span class="text-slate-500 dark:text-zink-400">Dec Salary Arrears:</span>
                                            <span class="font-medium text-green-600 dark:text-green-400">+PKR <?php echo e(number_format($payroll['arrears_amount'])); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($payroll['bonus'] > 0): ?>
                                        <div class="flex justify-between">
                                            <span class="text-slate-500 dark:text-zink-400">Performance Bonus:</span>
                                            <span class="font-medium text-green-600 dark:text-green-400">+PKR <?php echo e(number_format($payroll['bonus'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($payroll['ref_bonus'] > 0): ?>
                                        <div class="flex justify-between">
                                            <span class="text-slate-500 dark:text-zink-400">Referral Bonus:</span>
                                            <span class="font-medium text-green-600 dark:text-green-400">+PKR <?php echo e(number_format($payroll['ref_bonus'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($payroll['late_deduction'] == 0 && $payroll['dock'] == 0 && $payroll['training_bonus'] == 0 && $payroll['bonus'] == 0 && $payroll['ref_bonus'] == 0): ?>
                                        <div class="text-center text-slate-500 dark:text-zink-400 py-4">
                                            No deductions or bonuses applied
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calculation Breakdown -->
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-15 font-semibold text-slate-900 dark:text-zink-100 mb-4">Calculation Breakdown</h6>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-slate-500 dark:text-zink-200">
                                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-zink-600 dark:text-zink-300">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Component</th>
                                            <th scope="col" class="px-6 py-3">Calculation</th>
                                            <th scope="col" class="px-6 py-3">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b border-slate-200 dark:bg-zink-700 dark:border-zink-500">
                                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-zink-100">Daily Salary</td>
                                            <td class="px-6 py-4"><?php echo e(number_format($payroll['basic_salary'])); ?> ÷ <?php echo e($payroll['total_working_days']); ?></td>
                                            <td class="px-6 py-4">PKR <?php echo e(number_format($payroll['basic_salary'] / $payroll['total_working_days'])); ?></td>
                                        </tr>
                                        <tr class="bg-white border-b border-slate-200 dark:bg-zink-700 dark:border-zink-500">
                                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-zink-100">Present Days Pay</td>
                                            <td class="px-6 py-4"><?php echo e(number_format($payroll['basic_salary'] / $payroll['total_working_days'])); ?> × <?php echo e($payroll['presents']); ?></td>
                                            <td class="px-6 py-4">PKR <?php echo e(number_format(($payroll['basic_salary'] / $payroll['total_working_days']) * $payroll['presents'])); ?></td>
                                        </tr>
                                        <tr class="bg-white border-b border-slate-200 dark:bg-zink-700 dark:border-zink-500">
                                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-zink-100">Half Days Pay</td>
                                            <td class="px-6 py-4"><?php echo e(number_format($payroll['basic_salary'] / $payroll['total_working_days'])); ?> × <?php echo e($payroll['half_days']); ?></td>
                                            <td class="px-6 py-4">PKR <?php echo e(number_format(($payroll['basic_salary'] / $payroll['total_working_days']) * $payroll['half_days'])); ?></td>
                                        </tr>
                                        <tr class="bg-white border-b border-slate-200 dark:bg-zink-700 dark:border-zink-500">
                                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-zink-100">Holiday Pay</td>
                                            <td class="px-6 py-4"><?php echo e(number_format($payroll['basic_salary'] / $payroll['total_working_days'])); ?> × <?php echo e($payroll['holiday_count']); ?></td>
                                            <td class="px-6 py-4">PKR <?php echo e(number_format(($payroll['basic_salary'] / $payroll['total_working_days']) * $payroll['holiday_count'])); ?></td>
                                        </tr>
                                        <?php if(isset($payroll['arrears_amount']) && $payroll['arrears_amount'] > 0): ?>
                                            <tr class="bg-white border-b border-slate-200 dark:bg-zink-700 dark:border-zink-500">
                                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-zink-100">Dec Salary Arrears</td>
                                                <td class="px-6 py-4">Salary for Dec 21-31</td>
                                                <td class="px-6 py-4 font-medium text-green-600 dark:text-green-400">+PKR <?php echo e(number_format($payroll['arrears_amount'])); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr class="bg-white border-b border-slate-200 dark:bg-zink-700 dark:border-zink-500">
                                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-zink-100">Punctuality Bonus</td>
                                            <td class="px-6 py-4">Base punctuality amount</td>
                                            <td class="px-6 py-4">
                                                <?php if(isset($payroll['actual_punctuality']) && $payroll['actual_punctuality'] < $payroll['punctuality']): ?>
                                                    <span class="text-red-500 line-through mr-2">PKR <?php echo e(number_format($payroll['punctuality'])); ?></span>
                                                    <span>PKR <?php echo e(number_format($payroll['actual_punctuality'])); ?></span>
                                                <?php else: ?>
                                                    PKR <?php echo e(number_format($payroll['punctuality'])); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php if($payroll['late_count'] > 0): ?>
                                            <tr class="bg-white border-b border-slate-200 dark:bg-zink-700 dark:border-zink-500">
                                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-zink-100">Late Arrivals</td>
                                                <td class="px-6 py-4"><?php echo e($payroll['late_count']); ?> times</td>
                                                <td class="px-6 py-4 text-red-600 dark:text-red-400">-PKR <?php echo e(number_format($payroll['late_deduction'])); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr class="bg-slate-50 dark:bg-zink-600">
                                            <td class="px-6 py-4 font-bold text-slate-900 dark:text-zink-100">Final Salary</td>
                                            <td class="px-6 py-4">After all adjustments</td>
                                            <td class="px-6 py-4 font-bold text-custom-500 dark:text-custom-400">PKR <?php echo e(number_format($payroll['final_salary'])); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/payroll/show.blade.php ENDPATH**/ ?>