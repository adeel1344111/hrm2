
<?php $__env->startSection('title'); ?> Performance Report <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Performance Report</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('submissions.index')); ?>" class="text-slate-400 dark:text-zink-200">Submissions</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Performance Report</li>
            </ul>
        </div>
        
        <!-- Performance Info Card -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h6 class="text-15">Day Shift Performance</h6>
                        <p class="text-slate-500 dark:text-zink-200"><?php echo e($shiftData['period_label']); ?></p>
                        <p class="text-sm text-slate-600 dark:text-zink-300">Showing submissions from 6:00 AM to 6:00 PM</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="exportToExcel()" class="text-white btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                            <i data-lucide="download" class="w-4 h-4 mr-1"></i>
                            Export Excel
                        </button>
                        <button onclick="window.print()" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100">
                            <i data-lucide="printer" class="w-4 h-4 mr-1"></i>
                            Print
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Hourly Performance Matrix</h6>
                        <p class="text-slate-500 dark:text-zink-200">
                            Submission counts by agent for each hour (6:00 AM - 6:00 PM)
                        </p>
                    </div>
                </div>

                <?php if(count($performanceData) > 0): ?>
                
                <?php $__currentLoopData = $performanceData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaignName => $agentsData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-8 bg-white dark:bg-zink-700 rounded-md shadow-sm border border-slate-200 dark:border-zink-500 overflow-hidden">
                    <div class="p-4 bg-slate-50 dark:bg-zink-600 border-b border-slate-200 dark:border-zink-500">
                        <h5 class="text-16 font-semibold"><?php echo e($campaignName); ?></h5>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse performance-table">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-zink-600">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                        Agent Name
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                        Employee ID
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500 bg-blue-50 dark:bg-blue-500/10">
                                        Total
                                    </th>
                                    <?php if(auth()->user()->user_type !== 'agent'): ?>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500 bg-green-50 dark:bg-green-500/10">
                                        Sales
                                    </th>
                                    <?php endif; ?>
                                    
                                    <?php $__currentLoopData = $hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="px-3 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                        <?php echo e($hour); ?>

                                    </th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zink-700 divide-y divide-slate-200 dark:divide-zink-500">
                                <?php $__currentLoopData = $agentsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $agent = $data['agent'];
                                    $hourlySubmissions = $data['hourly_submissions'];
                                    $total = $data['total_submissions'];
                                    $sales = $data['sales_count'] ?? 0;
                                ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-zink-600">
                                    <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                        <?php echo e($agent->name); ?>

                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                        <?php echo e($agent->employee_id); ?>

                                    </td>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-blue-50 dark:bg-blue-500/10">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300">
                                            <?php echo e($total); ?>

                                        </span>
                                    </td>
                                    <?php if(auth()->user()->user_type !== 'agent'): ?>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-green-50 dark:bg-green-500/10">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">
                                            <?php echo e($sales); ?>

                                        </span>
                                    </td>
                                    <?php endif; ?>
                                    <?php $__currentLoopData = $hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="px-3 py-3 text-center text-sm border border-slate-200 dark:border-zink-500">
                                        <?php if($hourlySubmissions[$hour] > 0): ?>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">
                                                <?php echo e($hourlySubmissions[$hour]); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-slate-400 dark:text-zink-500">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-slate-100 dark:bg-zink-600">
                                    <td class="px-4 py-3 text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500" colspan="2">
                                        Hourly Total
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-blue-50 dark:bg-blue-500/10">
                                        <?php
                                            $grandTotal = 0;
                                            foreach($agentsData as $data) {
                                                $grandTotal += $data['total_submissions'];
                                            }
                                        ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300">
                                            <?php echo e($grandTotal); ?>

                                        </span>
                                    </td>
                                    <?php if(auth()->user()->user_type !== 'agent'): ?>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-green-50 dark:bg-green-500/10">
                                        <?php
                                            $totalSales = 0;
                                            foreach($agentsData as $data) {
                                                $totalSales += ($data['sales_count'] ?? 0);
                                            }
                                        ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">
                                            <?php echo e($totalSales); ?>

                                        </span>
                                    </td>
                                    <?php endif; ?>
                                    <?php $__currentLoopData = $hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $hourlyTotal = 0;
                                        foreach($agentsData as $data) {
                                            $hourlyTotal += $data['hourly_submissions'][$hour];
                                        }
                                    ?>
                                    <td class="px-3 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-500/20 dark:text-purple-300">
                                            <?php echo e($hourlyTotal); ?>

                                        </span>
                                    </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <i data-lucide="file-x" class="w-16 h-16 mx-auto text-slate-400 dark:text-zink-500 mb-4"></i>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-zink-100 mb-2">No Performance Data</h3>
                    <p class="text-slate-500 dark:text-zink-400">No submissions found for the current day shift period.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function exportToExcel() {
    let csvContent = '';
    
    // Get all campaign containers
    const containers = document.querySelectorAll('.card .mb-8');
    
    // If no specific containers, check for the single table just in case (fallback)
    const tables = document.querySelectorAll('.performance-table');
    
    if (containers.length > 0) {
        containers.forEach(container => {
            // Get campaign name
            const campaignName = container.querySelector('h5').textContent.trim();
            csvContent += `"${campaignName}"\n`; // Add campaign name as header
            
            const table = container.querySelector('table');
            if (table) {
                const rows = Array.from(table.rows);
                rows.forEach((row, index) => {
                    const cells = Array.from(row.cells);
                    const rowData = cells.map(cell => {
                        const text = cell.textContent.trim();
                        return text.includes(',') ? `"${text.replace(/"/g, '""')}"` : text;
                    });
                    csvContent += rowData.join(',') + '\n';
                });
                csvContent += '\n'; // Add empty line between campaigns
            }
        });
    } else if (tables.length > 0) {
        // Fallback for when there are tables but no container structure (or just one table)
         tables.forEach(table => {
            const rows = Array.from(table.rows);
            rows.forEach((row, index) => {
                const cells = Array.from(row.cells);
                const rowData = cells.map(cell => {
                    const text = cell.textContent.trim();
                    return text.includes(',') ? `"${text.replace(/"/g, '""')}"` : text;
                });
                csvContent += rowData.join(',') + '\n';
            });
            csvContent += '\n';
        });
    }

    // Create and download file
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'performance_report_<?php echo e(now()->format('Y-m-d_H-i')); ?>.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
<!-- End Page-content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/performance/report.blade.php ENDPATH**/ ?>