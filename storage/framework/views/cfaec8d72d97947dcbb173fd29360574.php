<?php $__env->startSection('title'); ?> Submissions <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Submissions</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('home')); ?>" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Submissions</li>
            </ul>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2"><?php echo e($stats['total']); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Submissions</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">All submissions today</p>
                        <div class="flex items-center justify-center text-blue-500 dark:text-blue-400 text-sm">
                            <i data-lucide="file-text" class="w-4 h-4 mr-1"></i>
                            <span>Complete list</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2"><?php echo e(\Carbon\Carbon::parse($stats['date'])->format('d')); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Selected Date</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3"><?php echo e(\Carbon\Carbon::parse($stats['date'])->format('M Y')); ?></p>
                        <div class="flex items-center justify-center text-green-500 dark:text-green-400 text-sm">
                            <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                            <span><?php echo e(\Carbon\Carbon::parse($stats['date'])->format('D')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2"><?php echo e($stats['total'] > 0 ? round($stats['total'] / 8) : 0); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Avg per Hour</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Submissions per hour</p>
                        <div class="flex items-center justify-center text-purple-500 dark:text-purple-400 text-sm">
                            <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                            <span>Rate</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2"><?php echo e($stats['total'] > 0 ? '100' : '0'); ?>%</h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Completion</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Daily target progress</p>
                        <div class="flex items-center justify-center text-orange-500 dark:text-orange-400 text-sm">
                            <i data-lucide="target" class="w-4 h-4 mr-1"></i>
                            <span>Goal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Submissions List</h6>
                        <p class="text-slate-500 dark:text-zink-200">Manage and view submissions</p>
                    </div>
                    
                    <?php
                        $uniqueDids = collect($submissions)->where('submission_type', 'verification')->pluck('did')->filter()->unique()->values();
                        $uniqueCampaigns = collect($submissions)->pluck('campaign')->filter()->unique()->sort()->values();
                    ?>

                    <div class="flex items-center gap-3 overflow-x-auto pb-2 whitespace-nowrap scrollbar-thin scrollbar-thumb-slate-300 dark:scrollbar-thumb-zink-500">
                        <div class="flex items-center gap-2">
                            <label for="dateFilter" class="text-sm font-medium text-gray-700 dark:text-gray-300 hidden xl:block">Date:</label>
                            <input type="date" id="dateFilter" value="<?php echo e($selectedDate); ?>" 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 text-sm"
                                   onchange="filterByDate()">
                            
                            <select id="campaignFilter" class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 text-sm">
                                <option value="">All Campaigns</option>
                                <?php $__currentLoopData = $uniqueCampaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($campaign); ?>"><?php echo e($campaign); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <select id="typeFilter" class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 text-sm">
                                <option value="">All Types</option>
                                <option value="csr">CSR</option>
                                <option value="verification">Verification</option>
                                <option value="regular">Regular</option>
                            </select>

                            <?php if(auth()->user()->isVerificationOfficer() || auth()->user()->isAdmin() || auth()->user()->isFloorManager() || auth()->user()->isTeamLead()): ?>
                            <select id="didFilter" class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 text-sm">
                                <option value="">All DIDs</option>
                                <?php $__currentLoopData = $uniqueDids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $did): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($did); ?>"><?php echo e($did); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php endif; ?>
                        </div>
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search submissions..." class="form-input ltr:pl-10 rtl:pr-10">
                            <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-3 rtl:pr-3 pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="submissionsTable" class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-zink-600">
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                    Employee
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                    Team Lead
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                    Campaign
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                    Phone
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                    Submitted
                                </th>
                                <?php if(auth()->user()->isVerificationOfficer() || auth()->user()->isAdmin() || auth()->user()->isFloorManager() || auth()->user()->isTeamLead()): ?>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                    DID
                                </th>
                                <?php endif; ?>
                                <?php if(auth()->user()->user_type !== 'agent'): ?>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <?php endif; ?>
                                <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zink-700 divide-y divide-slate-200 dark:divide-zink-500">
                            <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-zink-600">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-slate-200 dark:bg-zink-600 flex items-center justify-center">
                                                <span class="text-sm font-medium text-slate-600 dark:text-zink-300">
                                                    <?php
                                                    $fullName = $submission->employee_name;
                                                        $parts = explode(' ', $fullName);
                                                        $initials = '';
                                                        foreach ($parts as $part) {
                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                        }
                                                    ?>
                                                    <?php echo e($initials); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900 dark:text-zink-100">
                                                <?php echo e($submission->employee_name); ?>

                                            </div>
                                            <div class="text-sm text-slate-500 dark:text-zink-400">
                                                <?php echo e($submission->employee_id); ?>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                    <?php echo e($submission->team_lead_name); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                    <?php echo e($submission->campaign); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($submission->submission_type === 'csr'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400">
                                            CSR
                                        </span>
                                    <?php elseif($submission->submission_type === 'verification'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">
                                            Verification
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-400">
                                            Regular
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                    <?php if(auth()->user()->isAdmin()): ?>
                                        <?php echo e($submission->phone); ?>

                                    <?php else: ?>
                                        <?php echo e($submission->masked_phone); ?>

                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-zink-400">
                                    <?php echo e($submission->created_at->format('M d, Y H:i')); ?>

                                </td>
                                <?php if(auth()->user()->isVerificationOfficer() || auth()->user()->isAdmin() || auth()->user()->isFloorManager() || auth()->user()->isTeamLead()): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                    <?php if($submission->submission_type === 'verification' && isset($submission->did)): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-500/20 dark:text-purple-400">
                                            <?php echo e($submission->did); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <?php if(auth()->user()->user_type !== 'agent'): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-zink-400">
                                    <?php if(isset($submission->submission_type) && $submission->submission_type === 'csr'): ?>
                                        <?php if($submission->is_sale): ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">Sale</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-slate-400">Not Sale</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-slate-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <?php if(auth()->user()->isAdmin()): ?>
                                        <a href="<?php echo e(route('submissions.edit', ['submission' => $submission->id, 'type' => $submission->submission_type])); ?>" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </a>
                                        
                                        <form action="<?php echo e(route('submissions.destroy', ['submission' => $submission->id, 'type' => $submission->submission_type])); ?>" method="POST" class="inline-block m-0 p-0" onsubmit="return confirm('Are you sure you want to delete this submission?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 align-middle" title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo e(route('submissions.show', ['submission' => $submission->id, 'type' => $submission->submission_type])); ?>" class="text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300" title="View">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e(auth()->user()->user_type === 'agent' ? '6' : (auth()->user()->isVerificationOfficer() || auth()->user()->isAdmin() || auth()->user()->isFloorManager() || auth()->user()->isTeamLead() ? '8' : '7')); ?>" class="px-6 py-4 text-center text-slate-500 dark:text-zink-400">
                                    No submissions found for the selected date.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <!-- Pagination handled by TableManager -->
            </div>
        </div>
    </div>
</div>

<script>
function filterByDate() {
    const dateInput = document.getElementById('dateFilter');
    const selectedDate = dateInput.value;
    
    if (selectedDate) {
        // Redirect to the same page with the selected date as a query parameter
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('date', selectedDate);
        window.location.href = currentUrl.toString();
    }
}

// Search functionality replaced by TableManager

document.addEventListener('DOMContentLoaded', function() {
    new TableManager({
        tableId: 'submissionsTable',
        searchInputId: 'searchInput',
        filterInputs: ['#campaignFilter', '#typeFilter', '#didFilter'],
        rowsPerPage: 10
    });
});
</script>

<?php echo $__env->make('components.table-manager-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- End Page-content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/submissions/index.blade.php ENDPATH**/ ?>