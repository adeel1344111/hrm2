<?php $__env->startSection('title'); ?> Edit Employee <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Edit Employee: <?php echo e($employee->name); ?></h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="<?php echo e(route('employees.index')); ?>" class="text-slate-400 dark:text-zink-200">Employees</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Edit</li>
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
                                <img src="<?php echo e(asset('images/' . $employee->profile_picture)); ?>" alt="Profile Picture" 
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
                            <a href="<?php echo e(route('employees.show', $employee)); ?>" class="btn inline-flex items-center justify-center gap-1 bg-blue-500 text-white btn-sm w-full">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            View Details
                        </a>
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
                        <h5 class="card-title mb-0 text-lg font-semibold">Edit Employee Information</h5>
                    </div>
                    <div class="card-body px-6 py-6">
                <form action="<?php echo e(route('employees.update', $employee)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Basic Information -->
                        <div>
                                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="<?php echo e(old('name', $employee->name)); ?>" 
                                           class="form-input w-full <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Enter full name" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                    <label for="employee_id" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Employee ID <span class="text-red-500">*</span></label>
                            <input type="text" id="employee_id" name="employee_id" value="<?php echo e(old('employee_id', $employee->employee_id)); ?>" 
                                           class="form-input w-full <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Enter employee ID" required>
                            <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                    <label for="user_type" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">User Type <span class="text-red-500">*</span></label>
                                    <select id="user_type" name="user_type" 
                                            class="form-input w-full <?php $__errorArgs = ['user_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Select User Type</option>
                                        <option value="admin" <?php echo e(old('user_type', $employee->user_type) == 'admin' ? 'selected' : ''); ?>>Admin</option>
                                        <option value="management" <?php echo e(old('user_type', $employee->user_type) == 'management' ? 'selected' : ''); ?>>Management</option>
                                        <option value="floor_manager" <?php echo e(old('user_type', $employee->user_type) == 'floor_manager' ? 'selected' : ''); ?>>Floor Manager</option>
                                        <option value="team_lead" <?php echo e(old('user_type', $employee->user_type) == 'team_lead' ? 'selected' : ''); ?>>Team Lead</option>
                                        <option value="agent" <?php echo e(old('user_type', $employee->user_type) == 'agent' ? 'selected' : ''); ?>>Agent</option>
                                    </select>
                                    <?php $__errorArgs = ['user_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                    <label for="contact_number" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Contact Number</label>
                            <input type="text" id="contact_number" name="contact_number" value="<?php echo e(old('contact_number', $employee->contact_number)); ?>" 
                                           class="form-input w-full <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Enter contact number">
                            <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                    <label for="emergency_contact" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Emergency Contact</label>
                            <input type="text" id="emergency_contact" name="emergency_contact" value="<?php echo e(old('emergency_contact', $employee->emergency_contact)); ?>" 
                                           class="form-input w-full <?php $__errorArgs = ['emergency_contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Enter emergency contact">
                            <?php $__errorArgs = ['emergency_contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                    <label for="cnic" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">CNIC</label>
                            <input type="text" id="cnic" name="cnic" value="<?php echo e(old('cnic', $employee->cnic)); ?>" 
                                           class="form-input w-full <?php $__errorArgs = ['cnic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Enter CNIC">
                            <?php $__errorArgs = ['cnic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                    <label for="department" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Department</label>
                                    <select id="department" name="department" 
                                            class="form-input w-full <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Select Department</option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->name); ?>" <?php echo e(old('department', $employee->department) == $department->name ? 'selected' : ''); ?>>
                                            <?php echo e($department->name); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="designation" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Designation</label>
                            <select id="designation" name="designation" 
                                    class="form-input w-full <?php $__errorArgs = ['designation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Select Designation</option>
                                <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($designation->name); ?>" <?php echo e(old('designation', $employee->designation) == $designation->name ? 'selected' : ''); ?>>
                                    <?php echo e($designation->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['designation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                    <label for="appointment_date" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Appointment Date</label>
                                    <input type="date" id="appointment_date" name="appointment_date" value="<?php echo e(old('appointment_date', $employee->appointment_date ? \Carbon\Carbon::parse($employee->appointment_date)->format('Y-m-d') : '')); ?>" 
                                           class="form-input w-full <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                    <label for="dob" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Date of Birth</label>
                                    <input type="date" id="dob" name="dob" value="<?php echo e(old('dob', $employee->dob ? \Carbon\Carbon::parse($employee->dob)->format('Y-m-d') : '')); ?>" 
                                           class="form-input w-full <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                    <label for="status" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Status <span class="text-red-500">*</span></label>
                                    <select id="status" name="status" 
                                            class="form-input w-full <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Select Status</option>
                                        <option value="active" <?php echo e(old('status', $employee->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                                        <option value="inactive" <?php echo e(old('status', $employee->status) == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="floor_manager_id" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Floor Manager</label>
                            <select id="floor_manager_id" name="floor_manager_id" 
                                    class="form-input w-full <?php $__errorArgs = ['floor_manager_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Select Floor Manager</option>
                                <?php $__currentLoopData = $floorManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($fm->id); ?>" <?php echo e(old('floor_manager_id', $employee->floor_manager_id) == $fm->id ? 'selected' : ''); ?>>
                                    <?php echo e($fm->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['floor_manager_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="team_lead_id" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Team Lead</label>
                            <select id="team_lead_id" name="team_lead_id" 
                                    class="form-input w-full <?php $__errorArgs = ['team_lead_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Select Team Lead</option>
                                <?php $__currentLoopData = $teamLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tl->id); ?>" <?php echo e(old('team_lead_id', $employee->team_lead_id) == $tl->id ? 'selected' : ''); ?>>
                                    <?php echo e($tl->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['team_lead_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Profile Picture Upload -->
                        <div>
                            <label for="profile_picture" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Profile Picture Update</label>
                            <input type="file" id="profile_picture" name="profile_picture" 
                                   class="form-input w-full border-slate-200 dark:border-zink-500 cursor-pointer text-sm text-slate-500 dark:text-zink-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 dark:file:bg-zink-600 dark:file:text-zink-200"
                                   accept="image/*">
                            <?php $__errorArgs = ['profile_picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        </div>

                        <!-- Password Section -->
                        <div class="mt-8">
                            <h6 class="text-lg font-semibold mb-4 flex items-center">
                                <i data-lucide="lock" class="w-5 h-5 mr-2 text-red-500"></i>
                                Change Password
                            </h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">New Password</label>
                                    <input type="password" id="password" name="password" 
                                           class="form-input w-full <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Enter new password" minlength="8">
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <p class="text-xs text-slate-500 dark:text-zink-400 mt-1">Leave blank to keep current password</p>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Confirm New Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" 
                                           class="form-input w-full <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Confirm new password" minlength="8">
                                    <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                        <label for="basic_salary" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Basic Salary</label>
                                        <input type="number" id="basic_salary" name="basic_salary" value="<?php echo e(old('basic_salary', $employee->currentSalary->basic_salary)); ?>" 
                                               class="form-input w-full <?php $__errorArgs = ['basic_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Enter basic salary" step="0.01" min="0">
                            <?php $__errorArgs = ['basic_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                                        <label for="punctuality" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Punctuality Bonus</label>
                                        <input type="number" id="punctuality" name="punctuality" value="<?php echo e(old('punctuality', $employee->currentSalary->punctuality)); ?>" 
                                               class="form-input w-full <?php $__errorArgs = ['punctuality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Enter punctuality bonus" step="0.01" min="0">
                            <?php $__errorArgs = ['punctuality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                            </div>
                            <?php endif; ?>

                            <!-- Form Actions -->
                            <div class="flex gap-3 mt-8">
                                <button type="submit" class="btn inline-flex items-center justify-center gap-1 bg-custom-500 text-white btn-md">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Update Employee
                        </button>
                                <a href="<?php echo e(route('employees.show', $employee)); ?>" class="btn inline-flex items-center justify-center gap-1 bg-slate-200 text-slate-800 btn-md">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                            Cancel
                        </a>
                    </div>
                </form>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/employees/edit.blade.php ENDPATH**/ ?>