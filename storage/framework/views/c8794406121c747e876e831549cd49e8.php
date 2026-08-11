<?php $__env->startSection('title', 'Submissions Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center md:justify-between print:hidden">
            <div class="grow">
                <h5 class="text-16">Submissions Report</h5>
                <p class="text-slate-500 dark:text-zink-200"><?php echo e($company); ?> · <?php echo e($submissions->count()); ?> records · <?php echo e($totalSales ?? 0); ?> sales</p>
            </div>
            <form method="GET" action="<?php echo e(route('outsource.report')); ?>" class="flex flex-wrap gap-2 items-end">
                <div>
                    <label class="inline-block mb-2 text-base font-medium">From</label>
                    <input type="date" name="start_date" value="<?php echo e($start_date); ?>" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                </div>
                <div>
                    <label class="inline-block mb-2 text-base font-medium">To</label>
                    <input type="date" name="end_date" value="<?php echo e($end_date); ?>" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                </div>
                <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600">Apply</button>
            </form>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm whitespace-nowrap" id="reportTable">
                        <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                            <tr>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">#</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Dialer ID</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Name</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Phone</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Campaign</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">State</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">ZIP</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Age</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Sale</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b border-slate-200 dark:border-zink-500">
                                <td class="px-3.5 py-2.5"><?php echo e($i + 1); ?></td>
                                <td class="px-3.5 py-2.5 font-mono"><?php echo e($row->dialer_id); ?></td>
                                <td class="px-3.5 py-2.5"><?php echo e($row->name); ?></td>
                                <td class="px-3.5 py-2.5 font-mono"><?php echo e($row->phone); ?></td>
                                <td class="px-3.5 py-2.5"><?php echo e($row->campaign); ?></td>
                                <td class="px-3.5 py-2.5"><?php echo e($row->state ?: '—'); ?></td>
                                <td class="px-3.5 py-2.5"><?php echo e($row->zip ?: '—'); ?></td>
                                <td class="px-3.5 py-2.5"><?php echo e($row->age ?? '—'); ?></td>
                                <td class="px-3.5 py-2.5">
                                    <?php if($row->is_sale): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">Sale</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-slate-400">Not Sale</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-3.5 py-2.5 whitespace-nowrap"><?php echo e(optional($row->created_at)->format('Y-m-d H:i')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="px-3.5 py-10 text-center text-slate-500 dark:text-zink-200">No submissions for this date range.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.outsource-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/outsource/report.blade.php ENDPATH**/ ?>