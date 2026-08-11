<?php $__env->startSection('title'); ?>
    Monthly Submissions Matrix Report
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <!-- Page Title -->
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">Monthly Submissions Matrix Report</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <a href="<?php echo e(route('home')); ?>" class="text-slate-400 dark:text-zink-200">Dashboards</a>
        </li>
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <a href="<?php echo e(route('submissions.index')); ?>" class="text-slate-400 dark:text-zink-200">Submissions</a>
        </li>
        <li class="text-slate-700 dark:text-zink-100">
            Monthly Matrix Report
        </li>
    </ul>
</div>

<div class="grid grid-cols-1 gap-x-5 print:p-0">
    <!-- Filter Card -->
    <div class="card print:hidden">
        <div class="card-body">
            <form action="<?php echo e(route('submissions.monthly-report')); ?>" method="GET">
                <div class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label for="start_date" class="block mb-2 text-sm font-medium text-slate-700 dark:text-zink-100">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="<?php echo e($startDate); ?>" class="w-full form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:text-zink-100">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label for="end_date" class="block mb-2 text-sm font-medium text-slate-700 dark:text-zink-100">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="<?php echo e($endDate); ?>" class="w-full form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:text-zink-100">
                    </div>
                    
                    <!-- Designation Filter -->
                    <div class="flex-1 min-w-[200px]">
                        <label for="designation" class="block mb-2 text-sm font-medium text-slate-700 dark:text-zink-100">Designation</label>
                        <select name="designation" id="designation" class="w-full form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                            <option value="">All Designations</option>
                            <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($designation->id); ?>" <?php echo e($designationId == $designation->id ? 'selected' : ''); ?>><?php echo e($designation->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Agent Filter (Dependent on Designation) -->
                    <div class="flex-1 min-w-[200px]" id="agent_filter_container" style="<?php echo e($designationId ? 'display: flex; flex-direction: column;' : 'display: none;'); ?>">
                        <label for="agent_id" class="block mb-2 text-sm font-medium text-slate-700 dark:text-zink-100">Agent</label>
                        <select name="agent_id" id="agent_id" class="w-full form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                            <option value="">All Agents</option>
                            <?php $__currentLoopData = $allAgents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $agentDesignation = $designations->where('name', $agent->designation)->first();
                                    $agentDesignationId = $agentDesignation ? $agentDesignation->id : '';
                                ?>
                                <option value="<?php echo e($agent->id); ?>" data-designation="<?php echo e($agentDesignationId); ?>" <?php echo e((isset($agentId) && $agentId == $agent->id) ? 'selected' : ''); ?> style="<?php echo e(($designationId && $agentDesignationId != $designationId) ? 'display: none;' : ''); ?>">
                                    <?php echo e($agent->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="shrink-0">
                        <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            <i data-lucide="search" class="w-4 h-4 mr-1"></i>
                            Filter
                        </button>
                        <a href="<?php echo e(route('submissions.monthly-report')); ?>" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Matrix Report Card -->
    <div class="card">
        <div class="card-body">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h6 class="text-15">Submissions Matrix Report</h6>
                    <p class="text-slate-500 dark:text-zink-200">
                        Report Period: <?php echo e(\Carbon\Carbon::parse($startDate)->format('M d, Y')); ?> - <?php echo e(\Carbon\Carbon::parse($endDate)->format('M d, Y')); ?>

                    </p>
                    <div class="flex flex-wrap items-center gap-4 mt-2 print:hidden">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                Goal Met
                            </span>
                            <span class="text-xs text-slate-500 dark:text-zink-400">Daily: ≥<?php echo e(\App\Models\Setting::getDailyGoal()); ?>, Monthly: ≥<?php echo e(\App\Models\Setting::getMonthlyGoal()); ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                Goal Not Met
                            </span>
                            <span class="text-xs text-slate-500 dark:text-zink-400">Below target</span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 print:hidden">
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

            <?php if(count($reportData) > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="reportTable">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-zink-600">
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                Agent Name
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                Employee ID
                            </th>
                            <?php
                                $dates = [];
                                if (count($reportData) > 0) {
                                    $dates = array_keys($reportData[0]['submissions']);
                                }
                            ?>
                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                <?php echo e(\Carbon\Carbon::parse($date)->format('M d')); ?>

                            </th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500 bg-blue-50 dark:bg-blue-900/20">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zink-700 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $agent = $data['agent'];
                            $submissions = $data['submissions'];
                            $total = array_sum($submissions);
                        ?>
                        <tr class="hover:bg-slate-50 dark:hover:bg-zink-600">
                            <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                <?php echo e($agent->name); ?>

                            </td>
                            <td class="px-4 py-3 text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                <?php echo e($agent->employee_id); ?>

                            </td>
                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $dailyGoal = \App\Models\Setting::getDailyGoal();
                                $meetsDailyGoal = $submissions[$date] >= $dailyGoal;
                            ?>
                            <td class="px-4 py-3 text-center text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                <?php if($submissions[$date] > 0): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($meetsDailyGoal ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'); ?>">
                                        <?php echo e($submissions[$date]); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-slate-400 dark:text-zink-500">0</span>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-blue-50 dark:bg-blue-900/20">
                                <?php
                                    $monthlyGoal = \App\Models\Setting::getMonthlyGoal();
                                    $meetsMonthlyGoal = $total >= $monthlyGoal;
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($meetsMonthlyGoal ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'); ?>">
                                    <?php echo e($total); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-100 dark:bg-zink-600">
                            <td class="px-4 py-3 text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500" colspan="2">
                                Daily Total
                            </td>
                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $dailyTotal = 0;
                                foreach($reportData as $data) {
                                    $dailyTotal += $data['submissions'][$date];
                                }
                            ?>
                            <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                    <?php echo e($dailyTotal); ?>

                                </span>
                            </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-blue-50 dark:bg-blue-900/20">
                                <?php
                                    $grandTotal = 0;
                                    foreach($reportData as $data) {
                                        $grandTotal += array_sum($data['submissions']);
                                    }
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                    <?php echo e($grandTotal); ?>

                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-12">
                <i data-lucide="file-x" class="w-16 h-16 mx-auto text-slate-400 dark:text-zink-500 mb-4"></i>
                <h3 class="text-lg font-medium text-slate-900 dark:text-zink-100 mb-2">No Data Available</h3>
                <p class="text-slate-500 dark:text-zink-400">No submissions found for the selected date range.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.getElementById('designation').addEventListener('change', function() {
    const designation = this.value;
    const agentContainer = document.getElementById('agent_filter_container');
    const agentSelect = document.getElementById('agent_id');
    const options = agentSelect.querySelectorAll('option');
    
    if (designation) {
        agentContainer.style.display = 'flex';
        agentContainer.style.flexDirection = 'column';
        // Reset and filter options
        agentSelect.value = "";
        options.forEach(option => {
            if (option.value === "") {
                option.style.display = 'block';
            } else if (option.getAttribute('data-designation') === designation) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    } else {
        agentContainer.style.display = 'none';
        agentSelect.value = "";
    }
});

function exportToExcel() {
    // Get the table data
    const table = document.getElementById('reportTable');
    const rows = Array.from(table.rows);
    
    // Create CSV content
    let csvContent = '';
    
    rows.forEach((row, index) => {
        const cells = Array.from(row.cells);
        const rowData = cells.map(cell => {
            // Remove HTML tags and get text content
            const text = cell.textContent.trim();
            // Escape quotes and wrap in quotes if contains comma
            return text.includes(',') ? `"${text.replace(/"/g, '""')}"` : text;
        });
        csvContent += rowData.join(',') + '\n';
    });
    
    // Create and download file
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'monthly_submissions_report_<?php echo e($startDate); ?>_to_<?php echo e($endDate); ?>.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/submissions/monthly_report.blade.php ENDPATH**/ ?>