@extends('layouts.master')
@section('title') User Settings @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">User Settings</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('home') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Settings</li>
            </ul>
        </div>

        @if(session('success'))
        <div class="px-4 py-3 mb-4 text-sm text-green-500 border border-green-200 rounded-md bg-green-50 dark:bg-green-400/20 dark:border-green-500/50" role="alert">
            <span class="font-bold">Success!</span> {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="px-4 py-3 mb-4 text-sm text-red-500 border border-red-200 rounded-md bg-red-50 dark:bg-red-400/20 dark:border-red-500/50" role="alert">
            <span class="font-bold">Error!</span>
            <ul class="mt-2 ml-4 list-disc">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-12">
            <!-- Profile Information -->
            <div class="xl:col-span-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-4 text-15">Profile Information</h6>
                        <form action="{{ route('settings.update-profile') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="name" class="inline-block mb-2 text-base font-medium">Full Name</label>
                                <input type="text" id="name" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" value="{{ $user->name }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="employee_id" class="inline-block mb-2 text-base font-medium">Employee ID</label>
                                <input type="text" id="employee_id" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" value="{{ $user->employee_id }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="contact_number" class="inline-block mb-2 text-base font-medium">Contact Number</label>
                                <input type="text" id="contact_number" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" value="{{ $user->contact_number }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="emergency_contact" class="inline-block mb-2 text-base font-medium">Emergency Contact</label>
                                <input type="text" id="emergency_contact" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" value="{{ $user->emergency_contact }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="dob" class="inline-block mb-2 text-base font-medium">Date of Birth <span class="text-red-500">*</span></label>
                                <input type="date" id="dob" name="dob" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" value="{{ old('dob', $user->dob ? $user->dob->format('Y-m-d') : '') }}" required>
                                <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">This is the only field you can update</p>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                    <i data-lucide="save" class="inline-block size-4 mr-1"></i> Update Date of Birth
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="xl:col-span-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-4 text-15">Change Password</h6>
                        <form action="{{ route('settings.update-password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="current_password" class="inline-block mb-2 text-base font-medium">Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="inline-block mb-2 text-base font-medium">New Password</label>
                                <input type="password" id="new_password" name="new_password" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" required>
                                <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">Minimum 8 characters</p>
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation" class="inline-block mb-2 text-base font-medium">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" required>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                    <i data-lucide="key" class="inline-block size-4 mr-1"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-15">Account Information</h6>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 dark:text-zink-200">User Type</span>
                                <span class="font-medium">{{ ucfirst($user->user_type) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 dark:text-zink-200">Department</span>
                                <span class="font-medium">{{ $user->department ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 dark:text-zink-200">Designation</span>
                                <span class="font-medium">{{ $user->designation ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 dark:text-zink-200">Join Date</span>
                                <span class="font-medium">{{ $user->join_date ? $user->join_date->format('M d, Y') : 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 dark:text-zink-200">Status</span>
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded border {{ $user->status == 'active' ? 'bg-green-100 border-green-200 text-green-500' : 'bg-red-100 border-red-200 text-red-500' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
