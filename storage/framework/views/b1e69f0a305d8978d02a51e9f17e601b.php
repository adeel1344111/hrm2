<?php $__env->startSection('title'); ?> Submissions Report <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Submissions Report</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('submissions.index')); ?>" class="text-slate-400 dark:text-zink-200">Submissions</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Report</li>
            </ul>
        </div>
        
        <!-- Date Range Filter -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h6 class="text-15">Date Range Filter</h6>
                        <p class="text-slate-500 dark:text-zink-200">Select date range to view submissions report</p>
                    </div>
                    <form method="GET" action="<?php echo e(route('submissions.report')); ?>" class="flex flex-wrap items-center gap-x-4 gap-y-3">
                        <div class="flex items-center gap-2">
                            <label for="start_date" class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">From:</label>
                            <input type="date" id="start_date" name="start_date" value="<?php echo e($startDate); ?>" 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                        </div>
                        <div class="flex items-center gap-2">
                            <label for="end_date" class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">To:</label>
                            <input type="date" id="end_date" name="end_date" value="<?php echo e($endDate); ?>" 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                        </div>
                        <div class="flex items-center gap-2">
                            <label for="designation" class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Designation:</label>
                            <select id="designation" name="designation" 
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                                <option value="">All Designations</option>
                                <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($designation->id); ?>" <?php echo e($designationId == $designation->id ? 'selected' : ''); ?>><?php echo e($designation->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="flex items-center gap-2" id="agent_filter_container" style="<?php echo e($designationId ? 'display: flex;' : 'display: none;'); ?>">
                            <label for="agent_id" class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Agent:</label>
                            <select id="agent_id" name="agent_id" 
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                                <option value="">All Agents</option>
                                <?php $__currentLoopData = $allAgents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        // Find designation ID for this agent's designation string
                                        $agentDesignation = $designations->where('name', $agent->designation)->first();
                                        $agentDesignationId = $agentDesignation ? $agentDesignation->id : '';
                                    ?>
                                    <option value="<?php echo e($agent->id); ?>" data-designation="<?php echo e($agentDesignationId); ?>" <?php echo e((isset($agentId) && $agentId == $agent->id) ? 'selected' : ''); ?> <?php echo e(($designationId && $agentDesignationId != $designationId) ? 'style=display:none' : ''); ?>>
                                        <?php echo e($agent->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn bg-blue-500 border-blue-500 text-white hover:bg-blue-600 hover:border-blue-600 px-4 py-2 rounded-md font-medium flex items-center gap-2" style="background-color: #3b82f6; border-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 500; cursor: pointer;">
                            <i data-lucide="search" class="w-4 h-4"></i>
                            Generate Report
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Submissions List (above matrix) -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Submissions List</h6>
                        <p class="text-slate-500 dark:text-zink-200">
                            Report Period: <?php echo e(\Carbon\Carbon::parse($startDate)->format('M d, Y')); ?> - <?php echo e(\Carbon\Carbon::parse($endDate)->format('M d, Y')); ?>

                        </p>
                    </div>
                    <div class="text-sm text-slate-500 dark:text-zink-400">
                        Total: <?php echo e(isset($submissions) ? $submissions->count() : 0); ?>

                    </div>
                </div>

                <?php if(isset($submissions) && $submissions->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-zink-600">
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">Employee</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">Campaign</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">Phone</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">Submitted</th>
                                <?php if(auth()->user()->isVerificationOfficer() || auth()->user()->isAdmin() || auth()->user()->isFloorManager() || auth()->user()->isTeamLead()): ?>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">DID</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zink-700 divide-y divide-gray-200 dark:divide-gray-700">
                            <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-zink-600">
                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <div class="font-medium"><?php echo e($submission->employee_name ?? ($submission->submittedBy->name ?? '-')); ?></div>
                                    <div class="text-xs text-slate-500 dark:text-zink-400"><?php echo e($submission->employee_id ?? '-'); ?></div>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <?php echo e($submission->campaign ?? '-'); ?>

                                </td>
                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 dark:bg-zink-600 dark:text-zink-200">
                                        <?php echo e(strtoupper($submission->submission_type ?? '-')); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <?php echo e($submission->phone ?? '-'); ?>

                                </td>
                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <?php echo e(\Carbon\Carbon::parse($submission->created_at)->format('M d, Y h:i A')); ?>

                                </td>
                                <?php if(auth()->user()->isVerificationOfficer() || auth()->user()->isAdmin() || auth()->user()->isFloorManager() || auth()->user()->isTeamLead()): ?>
                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    <?php echo e($submission->did ?? '-'); ?>

                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-10">
                    <i data-lucide="file-x" class="w-12 h-12 mx-auto text-slate-400 dark:text-zink-500 mb-3"></i>
                    <p class="text-slate-500 dark:text-zink-400">No submissions found for the selected date range.</p>
                </div>
                <?php endif; ?>
            </div>
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
</script>
<!-- End Page-content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/submissions/report.blade.php ENDPATH**/ ?>