@extends('layouts.master')
@section('title') Create Employee @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Create New Employee</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('employees.index') }}" class="text-slate-400 dark:text-zink-200">Employees</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Create</li>
            </ul>
        </div>
        
        <div class="grid grid-cols-1 gap-6">
            <div class="card">
                <div class="card-header px-6 py-4">
                    <h5 class="card-title mb-0 text-lg font-semibold">Employee Information</h5>
                </div>
                <div class="card-body px-6 py-6">
                    @if ($errors->any())
                        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-300" role="alert">
                            <div class="font-medium">Please fix the following errors:</div>
                            <ul class="mt-1 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Basic Information -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                       class="form-input w-full @error('name') border-red-500 @enderror" 
                                       placeholder="Enter full name" required>
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="employee_id" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Employee ID <span class="text-red-500">*</span></label>
                                <input type="text" id="employee_id" name="employee_id" value="{{ old('employee_id') }}" 
                                       class="form-input w-full @error('employee_id') border-red-500 @enderror" 
                                       placeholder="Enter employee ID" required>
                                @error('employee_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="user_type" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">User Type <span class="text-red-500">*</span></label>
                                <select id="user_type" name="user_type" 
                                        class="form-input w-full @error('user_type') border-red-500 @enderror" required>
                                    <option value="">Select User Type</option>
                                    <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="management" {{ old('user_type') == 'management' ? 'selected' : '' }}>Management</option>
                                    <option value="floor_manager" {{ old('user_type') == 'floor_manager' ? 'selected' : '' }}>Floor Manager</option>
                                    <option value="team_lead" {{ old('user_type') == 'team_lead' ? 'selected' : '' }}>Team Lead</option>
                                    <option value="agent" {{ old('user_type') == 'agent' ? 'selected' : '' }}>Agent</option>
                                </select>
                                @error('user_type')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="contact_number" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Contact Number</label>
                                <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" 
                                       class="form-input w-full @error('contact_number') border-red-500 @enderror" 
                                       placeholder="Enter contact number">
                                @error('contact_number')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="emergency_contact" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Emergency Contact</label>
                                <input type="text" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" 
                                       class="form-input w-full @error('emergency_contact') border-red-500 @enderror" 
                                       placeholder="Enter emergency contact">
                                @error('emergency_contact')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="cnic" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">CNIC</label>
                                <input type="text" id="cnic" name="cnic" value="{{ old('cnic') }}" 
                                       class="form-input w-full @error('cnic') border-red-500 @enderror" 
                                       placeholder="Enter CNIC">
                                @error('cnic')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="department" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Department</label>
                                <select id="department" name="department" 
                                        class="form-input w-full @error('department') border-red-500 @enderror">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->name }}" {{ old('department') == $department->name ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="designation" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Designation</label>
                                <select id="designation" name="designation" 
                                        class="form-input w-full @error('designation') border-red-500 @enderror">
                                    <option value="">Select Designation</option>
                                    @foreach($designations as $designation)
                                    <option value="{{ $designation->name }}" {{ old('designation') == $designation->name ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('designation')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="appointment_date" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Appointment Date</label>
                                <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" 
                                       class="form-input w-full @error('appointment_date') border-red-500 @enderror">
                                @error('appointment_date')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="dob" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Date of Birth</label>
                                <input type="date" id="dob" name="dob" value="{{ old('dob') }}" 
                                       class="form-input w-full @error('dob') border-red-500 @enderror">
                                @error('dob')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Status <span class="text-red-500">*</span></label>
                                <select id="status" name="status" 
                                        class="form-input w-full @error('status') border-red-500 @enderror" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="floor_manager_id" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Floor Manager</label>
                                <select id="floor_manager_id" name="floor_manager_id" 
                                        class="form-input w-full @error('floor_manager_id') border-red-500 @enderror">
                                    <option value="">Select Floor Manager</option>
                                    @foreach($floorManagers as $fm)
                                    <option value="{{ $fm->id }}" {{ old('floor_manager_id') == $fm->id ? 'selected' : '' }}>
                                        {{ $fm->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('floor_manager_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="team_lead_id" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Team Lead</label>
                                <select id="team_lead_id" name="team_lead_id" 
                                        class="form-input w-full @error('team_lead_id') border-red-500 @enderror">
                                    <option value="">Select Team Lead</option>
                                    @foreach($teamLeads as $tl)
                                    <option value="{{ $tl->id }}" {{ old('team_lead_id') == $tl->id ? 'selected' : '' }}>
                                        {{ $tl->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('team_lead_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Profile Picture Upload -->
                            <div>
                                <label for="profile_picture" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Profile Picture</label>
                                <input type="file" id="profile_picture" name="profile_picture" 
                                       class="form-input w-full border-slate-200 dark:border-zink-500 cursor-pointer text-sm text-slate-500 dark:text-zink-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 dark:file:bg-zink-600 dark:file:text-zink-200"
                                       accept="image/*">
                                @error('profile_picture')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="mt-8">
                            <h6 class="text-lg font-semibold mb-4 flex items-center">
                                <i data-lucide="lock" class="w-5 h-5 mr-2 text-red-500"></i>
                                Password Setup
                            </h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Password <span class="text-red-500">*</span></label>
                                    <input type="password" id="password" name="password" 
                                           class="form-input w-full @error('password') border-red-500 @enderror" 
                                           placeholder="Enter password" minlength="8" required>
                                    @error('password')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" 
                                           class="form-input w-full @error('password_confirmation') border-red-500 @enderror" 
                                           placeholder="Confirm password" minlength="8" required>
                                    @error('password_confirmation')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Salary Information -->
                        <div class="mt-8">
                            <h6 class="text-lg font-semibold mb-4 flex items-center">
                                <i data-lucide="dollar-sign" class="w-5 h-5 mr-2 text-green-500"></i>
                                Salary Information
                            </h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="basic_salary" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Basic Salary</label>
                                    <input type="number" id="basic_salary" name="basic_salary" value="{{ old('basic_salary') }}" 
                                           class="form-input w-full @error('basic_salary') border-red-500 @enderror" 
                                           placeholder="Enter basic salary" step="0.01" min="0">
                                    @error('basic_salary')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="punctuality" class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">Punctuality Bonus</label>
                                    <input type="number" id="punctuality" name="punctuality" value="{{ old('punctuality') }}" 
                                           class="form-input w-full @error('punctuality') border-red-500 @enderror" 
                                           placeholder="Enter punctuality bonus" step="0.01" min="0">
                                    @error('punctuality')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-3 mt-8 justify-end">
                            <a href="{{ route('employees.index') }}" class="btn inline-flex items-center justify-center gap-1 bg-slate-200 text-slate-800 btn-md">
                                <i data-lucide="x" class="w-4 h-4"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn inline-flex items-center justify-center gap-1 bg-custom-500 text-white btn-md">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Create Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page-content -->
@endsection

@section('script')
<script>
    // Initialize Lucide icons
    lucide.createIcons();


    // Auto-generate employee ID from next available number
    document.addEventListener('DOMContentLoaded', function() {
        const employeeIdField = document.getElementById('employee_id');
        
        // Fetch next employee ID on page load
        fetch('/api/next-employee-id')
            .then(response => response.json())
            .then(data => {
                if (data.next_id && !employeeIdField.value) {
                    employeeIdField.value = data.next_id;
                }
            })
            .catch(error => console.error('Error fetching next employee ID:', error));
    });
</script>
@endsection
