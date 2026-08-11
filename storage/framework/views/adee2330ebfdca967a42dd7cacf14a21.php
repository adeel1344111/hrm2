


<?php $__env->startSection('content'); ?>
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
    <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
        <div class="grow">
            <h5 class="text-16">Teams View</h5>
        </div>
        <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
            <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                <a href="<?php echo e(route('home')); ?>" class="text-slate-400 dark:text-zink-200">Dashboard</a>
            </li>
            <li class="text-slate-700 dark:text-zink-100">
                Teams
            </li>
        </ul>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $teamLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teamLead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="card mb-5">
        <div class="card-body">
            <h6 class="mb-4 text-15 text-custom-500"><?php echo e($teamLead->name); ?> (Team Lead)</h6>
            
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">S.NO</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Employee Name</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Employee ID</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Contact Number</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Emergency Contact</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">CNIC</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Basic Salary</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Appointment Date</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Tenure</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">Referred By</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-zink-200">HRM Password</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200 dark:bg-zink-700 dark:divide-zink-500">
                        <?php $__empty_2 = true; $__currentLoopData = $teamLead->agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e($loop->iteration); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e($agent->name); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e($agent->employee_id); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e($agent->contact_number ?? $agent->phone); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e($agent->emergency_contact); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e($agent->cnic); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e(number_format($agent->basic_salary)); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e($agent->appointment_date ? \Carbon\Carbon::parse($agent->appointment_date)->format('d-M-Y') : '-'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-zink-400">
                                    <?php if($agent->appointment_date): ?>
                                        <?php
                                            $diff = \Carbon\Carbon::parse($agent->appointment_date)->diff(\Carbon\Carbon::now());
                                            $parts = [];
                                            if ($diff->y > 0) $parts[] = $diff->y . ' Year' . ($diff->y > 1 ? 's' : '');
                                            if ($diff->m > 0) $parts[] = $diff->m . ' Month' . ($diff->m > 1 ? 's' : '');
                                            if ($diff->d > 0) $parts[] = $diff->d . ' Day' . ($diff->d > 1 ? 's' : '');
                                            echo implode(' ', $parts) ?: 'Just joined';
                                        ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e($agent->referred_by); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100"><?php echo e($agent->password); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-zink-400">No agents assigned to this team lead.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-slate-500 dark:text-zink-200">No active Team Leads found.</p>
        </div>
    </div>
    <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/teams/index.blade.php ENDPATH**/ ?>