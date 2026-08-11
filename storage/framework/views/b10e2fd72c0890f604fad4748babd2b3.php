
<?php $__env->startSection('title'); ?> Leave Types Management <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Leave Types Management</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('home')); ?>" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('leaves.index')); ?>" class="text-slate-400 dark:text-zink-200">Leave Management</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Leave Types</li>
            </ul>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-blue-600 mb-2"><?php echo e($stats['total']); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Total Types</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">All leave types</p>
                        <div class="flex items-center justify-center text-blue-500 text-sm">
                            <i data-lucide="list" class="w-4 h-4 mr-1"></i>
                            <span>Complete list</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-green-600 mb-2"><?php echo e($stats['active']); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Active</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Currently available</p>
                        <div class="flex items-center justify-center text-green-500 text-sm">
                            <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                            <span>In use</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-gray-600 mb-2"><?php echo e($stats['inactive']); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">Inactive</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Disabled types</p>
                        <div class="flex items-center justify-center text-gray-500 text-sm">
                            <i data-lucide="x-circle" class="w-4 h-4 mr-1"></i>
                            <span>Disabled</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer group">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-3xl font-bold text-purple-600 mb-2"><?php echo e($stats['with_max_days']); ?></h6>
                        <p class="text-slate-600 dark:text-zink-300 font-medium mb-1">With Limits</p>
                        <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">Have max days set</p>
                        <div class="flex items-center justify-center text-purple-500 text-sm">
                            <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                            <span>Limited</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Leave Types Management</h6>
                        <p class="text-slate-500 dark:text-zink-200">Manage different types of leave</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="<?php echo e(route('leave-types.create')); ?>" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            <i data-lucide="plus-circle" class="w-4 h-4 mr-1"></i>
                            Add Leave Type
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500 dark:text-zink-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-zink-600 dark:text-zink-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="px-6 py-3">Max Days</th>
                                <th scope="col" class="px-6 py-3">Approval</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zink-700 divide-y divide-slate-200 dark:divide-zink-500">
                            <?php $__empty_1 = true; $__currentLoopData = $leaveTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-zink-600 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900 dark:text-zink-100"><?php echo e($leaveType->name); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900 dark:text-zink-100"><?php echo e($leaveType->description ?? 'No description'); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($leaveType->max_days): ?>
                                        <span class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full dark:bg-blue-500/20 dark:text-blue-400"><?php echo e($leaveType->max_days); ?> <?php echo e(Str::plural('day', $leaveType->max_days)); ?></span>
                                    <?php else: ?>
                                        <span class="text-slate-500 dark:text-zink-400">Unlimited</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($leaveType->requires_approval): ?>
                                        <span class="px-3 py-1 text-xs font-medium text-yellow-600 bg-yellow-100 rounded-full dark:bg-yellow-500/20 dark:text-yellow-400">Required</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-full dark:bg-green-500/20 dark:text-green-400">Not Required</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($leaveType->is_active): ?>
                                        <span class="px-3 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-full dark:bg-green-500/20 dark:text-green-400">Active</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full dark:bg-red-500/20 dark:text-red-400">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="<?php echo e(route('leave-types.show', $leaveType)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View Details">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <a href="<?php echo e(route('leave-types.edit', $leaveType)); ?>" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </a>
                                        <form action="<?php echo e(route('leave-types.destroy', $leaveType)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this leave type?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-zink-200">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="flex items-center justify-center w-16 h-16 text-slate-300 bg-slate-100 rounded-full dark:bg-zink-600 dark:text-zink-400">
                                            <i data-lucide="list-x" class="w-8 h-8"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-lg font-semibold text-slate-600 dark:text-zink-200">No leave types found</h6>
                                            <p class="text-sm">There are no leave types to display at the moment.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if($leaveTypes->hasPages()): ?>
                    <?php if (isset($component)) { $__componentOriginal41032d87daf360242eb88dbda6c75ed1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41032d87daf360242eb88dbda6c75ed1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pagination','data' => ['paginator' => $leaveTypes]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($leaveTypes)]); ?>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/leave-types/index.blade.php ENDPATH**/ ?>