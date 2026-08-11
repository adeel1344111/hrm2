
<?php $__env->startSection('title'); ?> Campaigns <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Campaigns</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="#!" class="text-slate-400 dark:text-zink-200">System Settings</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Campaigns</li>
            </ul>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-purple-600 mb-2"><?php echo e($campaigns->total()); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Campaigns</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">All campaigns in system</p>
                        <div class="flex items-center justify-center text-green-500 text-sm">
                            <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                            <span>+15%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-green-600 mb-2"><?php echo e($campaigns->where('status', 'active')->count()); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Active Campaigns</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Currently running</p>
                        <div class="flex items-center justify-center text-green-500 text-sm">
                            <i data-lucide="activity" class="w-4 h-4 mr-1"></i>
                            <span><?php echo e($campaigns->total() > 0 ? round(($campaigns->where('status', 'active')->count() / $campaigns->total()) * 100) : 0); ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-blue-600 mb-2"><?php echo e($campaigns->where('status', 'completed')->count()); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Completed Campaigns</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Successfully finished</p>
                        <div class="flex items-center justify-center text-blue-500 text-sm">
                            <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                            <span><?php echo e($campaigns->total() > 0 ? round(($campaigns->where('status', 'completed')->count() / $campaigns->total()) * 100) : 0); ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-orange-600 mb-2"><?php echo e($campaigns->where('status', 'inactive')->count()); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Inactive Campaigns</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Paused or stopped</p>
                        <div class="flex items-center justify-center text-orange-500 text-sm">
                            <i data-lucide="pause-circle" class="w-4 h-4 mr-1"></i>
                            <span><?php echo e($campaigns->total() > 0 ? round(($campaigns->where('status', 'inactive')->count() / $campaigns->total()) * 100) : 0); ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campaigns Table -->
        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Campaigns Management</h6>
                        <p class="text-slate-500 dark:text-zink-200">Manage all campaigns in the system</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="<?php echo e(route('campaigns.create')); ?>" class="btn bg-custom-500 text-white border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                            Add Campaign
                        </a>
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search campaigns..." class="form-input ltr:pl-10 rtl:pr-10" onkeyup="searchTable()">
                            <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-3 rtl:pr-3 pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if(session('success')): ?>
                    <div class="px-4 py-3 mb-4 text-sm text-green-500 border border-green-200 rounded-md bg-green-50 dark:bg-green-400/20 dark:border-green-500/50">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <div class="overflow-x-auto">
                    <table id="campaignsTable" class="w-full text-sm text-left text-slate-500 dark:text-zink-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-zink-600 dark:text-zink-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">Campaign Name</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Created By</th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zink-700 divide-y divide-slate-200 dark:divide-zink-500">
                            <?php $__empty_1 = true; $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-zink-600 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900/20 flex items-center justify-center">
                                                <span class="text-sm font-medium text-purple-600 dark:text-purple-400">
                                                    <?php echo e(substr($campaign->name, 0, 2)); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <div class="text-sm font-medium text-slate-900 dark:text-zink-100"><?php echo e($campaign->name); ?></div>
                                            <div class="text-sm text-slate-500 dark:text-zink-400"><?php echo e(Str::limit($campaign->description, 50)); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($campaign->status_color); ?>">
                                        <?php echo e($campaign->status_label); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-zink-100">
                                    <?php echo e($campaign->created_by ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="<?php echo e(route('campaigns.show', $campaign)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View Details">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <a href="<?php echo e(route('campaigns.edit', $campaign)); ?>" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Edit Campaign">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </a>
                                        <form action="<?php echo e(route('campaigns.destroy', $campaign)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete Campaign">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-slate-500 dark:text-zink-400">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i data-lucide="target" class="w-12 h-12 text-slate-400 dark:text-zink-500 mb-2"></i>
                                        <p class="text-sm">No campaigns found</p>
                                        <p class="text-xs text-slate-400 dark:text-zink-500">Create your first campaign to get started</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($campaigns->hasPages()): ?>
                    <?php if (isset($component)) { $__componentOriginal41032d87daf360242eb88dbda6c75ed1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41032d87daf360242eb88dbda6c75ed1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pagination','data' => ['paginator' => $campaigns]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($campaigns)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41032d87daf360242eb88dbda6c75ed1)): ?>
<?php $attributes = $__attributesOriginal41032d87daf360242eb88dbda6c75ed1; ?>
<?php unset($__attributesOriginal41032d87daf360242eb88dbda6c75ed1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41032d87daf360242eb88dbda6c75ed1)): ?>
<?php $component = $__componentOriginal41032d87daf360242eb88dbda6c75ed1; ?>
<?php unset($__componentOriginal41032d87daf360242eb88dbda6c75ed1); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('campaignsTable');
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/campaigns/index.blade.php ENDPATH**/ ?>