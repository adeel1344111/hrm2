<?php $__env->startSection('title'); ?> <?php echo e($employee->name); ?> - Employee Details <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16"><?php echo e($employee->name); ?> - Employee Profile</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('employees.index')); ?>" class="text-slate-400 dark:text-zink-200">Employees</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100"><?php echo e($employee->name); ?></li>
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
                            <?php if($employee->profile_picture): ?>
                                <img src="<?php echo e(asset('assets/images/' . $employee->profile_picture)); ?>" alt="Profile Picture" 
                                     class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-slate-200 dark:border-zink-500">
                            <?php else: ?>
                                <div class="w-32 h-32 rounded-full mx-auto bg-slate-200 dark:bg-zink-600 flex items-center justify-center border-4 border-slate-200 dark:border-zink-500">
                                    <span class="text-4xl font-semibold text-slate-800 dark:text-zink-200">
                                        <?php
                                        $fullName = $employee->name;
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
                        
                        <!-- Status Badge -->
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                <?php if($employee->status === 'active'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                <?php else: ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                <?php endif; ?>">
                                <i data-lucide="<?php echo e($employee->status === 'active' ? 'check-circle' : 'x-circle'); ?>" class="w-4 h-4 mr-1"></i>
                                <?php echo e(ucfirst($employee->status)); ?>

                            </span>
                        </div>

                        <!-- User Type Badge -->
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                <?php if($employee->user_type === 'agent'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                <?php elseif($employee->user_type === 'team_lead'): ?> bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                <?php elseif($employee->user_type === 'floor_manager'): ?> bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                                <?php elseif($employee->user_type === 'management'): ?> bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300
                                <?php elseif($employee->user_type === 'admin'): ?> bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-300
                                <?php else: ?> bg-slate-100 text-slate-800 dark:bg-zink-600 dark:text-zink-300
                                <?php endif; ?>">
                                <i data-lucide="user" class="w-4 h-4 mr-1"></i>
                                <?php echo e($employee->user_type === 'management' ? 'Management' : ucfirst(str_replace('_', ' ', $employee->user_type))); ?>

                            </span>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="space-y-2">
                            <?php if(auth()->user()->isAdmin() || auth()->user()->isFloorManager() || (auth()->user()->isTeamLead() && $employee->team_lead_id === auth()->user()->id) || $employee->id === auth()->user()->id): ?>
                            <a href="<?php echo e(route('employees.edit', $employee)); ?>" class="btn inline-flex items-center justify-center gap-1 bg-custom-500 text-white btn-sm w-full">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                                Edit Employee
                            </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('employees.index')); ?>" class="btn inline-flex items-center justify-center gap-1 bg-slate-200 text-slate-800 btn-sm w-full">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                Back to Employees
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Information Section -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header px-6 py-4">
                        <h5 class="card-title mb-0 text-lg font-semibold">Employee Information</h5>
                                </div>
                    <div class="card-body px-6 py-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Basic Information -->
                                <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Full Name</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->name); ?>

                                </div>
                                </div>
                                
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Employee ID</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->employee_id); ?>

                                </div>
                                </div>
                                
                        <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">User Type</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e(ucfirst(str_replace('_', ' ', $employee->user_type))); ?>

                                </div>
                                </div>
                                
                                <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Contact Number</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->contact_number ?? 'N/A'); ?>

                                </div>
                            </div>
                            
                                <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Emergency Contact</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->emergency_contact ?? 'N/A'); ?>

                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">CNIC</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->cnic ?? 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Department</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->department ?? 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Appointment Date</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->appointment_date ? \Carbon\Carbon::parse($employee->appointment_date)->format('M d, Y') : 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Designation</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->designation ?? 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Date of Birth</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->dob ? \Carbon\Carbon::parse($employee->dob)->format('M d, Y') : 'N/A'); ?>

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Status</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <span class="badge <?php echo e($employee->status === 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'); ?>">
                                        <?php echo e(ucfirst($employee->status)); ?>

                                    </span>
                                </div>
                            </div>

                            <?php if(auth()->user()->isAdmin()): ?>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">HRM Password</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->password ?? 'N/A'); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($employee->floorManager): ?>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Floor Manager</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->floorManager->name); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($employee->teamLead): ?>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Team Lead</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->teamLead->name); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Account Created</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <?php echo e($employee->created_at ? $employee->created_at->format('M d, Y') : 'N/A'); ?>

                                </div>
                            </div>
                        </div>

                        <!-- Salary Information -->
                        <?php if($employee->currentSalary): ?>
                        <div class="mt-8">
                            <h6 class="text-lg font-semibold mb-4 flex items-center">
                                <i data-lucide="dollar-sign" class="w-5 h-5 mr-2 text-green-500"></i>
                                Salary Information
                            </h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Basic Salary</label>
                                    <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                        PKR <?php echo e(number_format((float)($employee->currentSalary->basic_salary ?? 0), 2)); ?>

                    </div>
                </div>

                            <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Punctuality Bonus</label>
                                    <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                        PKR <?php echo e(number_format((float)($employee->currentSalary->punctuality ?? 0), 2)); ?>

                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Total Salary</label>
                                    <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                        PKR <?php echo e(number_format((float)($employee->currentSalary->basic_salary ?? 0) + (float)($employee->currentSalary->punctuality ?? 0), 2)); ?>

                            </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Effective Date</label>
                                    <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                        <?php echo e($employee->currentSalary->effective_date ? \Carbon\Carbon::parse($employee->currentSalary->effective_date)->format('M d, Y') : 'N/A'); ?>

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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/employees/show.blade.php ENDPATH**/ ?>