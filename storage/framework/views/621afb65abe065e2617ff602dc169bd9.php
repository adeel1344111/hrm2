
<?php $__env->startSection('title'); ?> My Profile <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">My Profile</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('home')); ?>" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">My Profile</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Profile Picture Section -->
            <div class="lg:col-span-1">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Profile Picture</h5>
                    </div>
                    <div class="card-body px-6 py-6 text-center">
                        <div class="mb-4">
                            <?php if($user->profile_picture): ?>
                                <img src="<?php echo e(asset('assets/images/' . $user->profile_picture)); ?>" alt="Profile Picture" 
                                     class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-slate-200 dark:border-zink-500">
                            <?php else: ?>
                                <div class="w-32 h-32 rounded-full mx-auto bg-slate-200 dark:bg-zink-600 flex items-center justify-center border-4 border-slate-200 dark:border-zink-500">
                                    <span class="text-4xl font-semibold text-slate-800 dark:text-zink-200">
                                        <?php
                                        $fullName = $user->name;
                                            $parts = explode(' ', $fullName);
                                            $initials = '';
                                            foreach ($parts as $part) {
                                                $initials .= strtoupper(substr($part, 0, 1));
                                            }
                                        ?>
                                        <?php echo e($initials); ?>

                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="space-y-2">
                            <!-- Upload New Picture -->
                            <form action="<?php echo e(route('profile.update-picture')); ?>" method="POST" enctype="multipart/form-data" class="inline-block">
                                <?php echo csrf_field(); ?>
                                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="hidden" onchange="this.form.submit()">
                                <label for="profile_picture" class="btn bg-custom-500 text-white btn-sm cursor-pointer">
                                    <i data-lucide="upload" class="w-4 h-4 mr-1"></i>
                                    Upload Picture
                                </label>
                            </form>
                            
                            <?php if($user->profile_picture): ?>
                            <!-- Remove Picture -->
                            <form action="<?php echo e(route('profile.remove-picture')); ?>" method="POST" class="inline-block">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn bg-red-500 text-white btn-sm" onclick="return confirm('Are you sure you want to remove your profile picture?')">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                    Remove Picture
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mt-4 text-xs text-slate-500 dark:text-zink-400">
                            <p>Supported formats: JPG, PNG, GIF</p>
                            <p>Maximum size: 2MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Section -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Profile Information</h5>
                        <p class="text-sm text-slate-500 dark:text-zink-400 mt-1">Your profile information is read-only. Contact your administrator to make changes.</p>
                    </div>
                    <div class="card-body px-6 py-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Basic Information -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Full Name</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($user->name); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Employee ID</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($user->employee_id); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">User Type</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e(ucfirst(str_replace('_', ' ', $user->user_type))); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Contact Number</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($user->contact_number ?? 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Emergency Contact</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($user->emergency_contact ?? 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">CNIC</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($user->cnic ?? 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Department</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($user->department ?? 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Appointment Date</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($user->appointment_date ? \Carbon\Carbon::parse($user->appointment_date)->format('M d, Y') : 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Join Date</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($user->join_date ? \Carbon\Carbon::parse($user->join_date)->format('M d, Y') : 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Status</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <span class="badge <?php echo e($user->status === 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'); ?>">
                                        <?php echo e(ucfirst($user->status)); ?>

                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Account Created</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($user->created_at ? $user->created_at->format('M d, Y') : 'N/A'); ?>

                                </div>
                            </div>
                        </div>

                        <!-- Salary Information -->
                        <?php if($user->currentSalary): ?>
                        <div class="mt-8">
                            <h6 class="text-lg font-semibold mb-4 flex items-center">
                                <i data-lucide="dollar-sign" class="w-5 h-5 mr-2 text-green-500"></i>
                                Salary Information
                            </h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Basic Salary</label>
                                    <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                        PKR <?php echo e(number_format($user->currentSalary->basic_salary, 2)); ?>

                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Punctuality Bonus</label>
                                    <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                        PKR <?php echo e(number_format((float)($user->currentSalary->punctuality ?? 0), 2)); ?>

                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Total Salary</label>
                                    <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                        PKR <?php echo e(number_format((float)($user->currentSalary->basic_salary ?? 0) + (float)($user->currentSalary->punctuality ?? 0), 2)); ?>

                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Effective Date</label>
                                    <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                        <?php echo e($user->currentSalary->effective_date ? \Carbon\Carbon::parse($user->currentSalary->effective_date)->format('M d, Y') : 'N/A'); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/profile/show.blade.php ENDPATH**/ ?>