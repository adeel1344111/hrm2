@extends('layouts.master')
@section('title') Create Submission @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Create Submission</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('submissions.index') }}" class="text-slate-400 dark:text-zink-200">Submissions</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Create</li>
            </ul>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h6 class="text-15">Create New Submission</h6>
                        <p class="text-slate-500 dark:text-zink-200">Fill in the details to create a new submission</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('submissions.index') }}" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                            Back to Submissions
                        </a>
                    </div>
                </div>

                <form action="{{ route('submissions.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                        <!-- Basic Information -->
                        <div class="lg:col-span-2">
                            <h6 class="text-lg font-semibold mb-4 flex items-center">
                                <i data-lucide="file-text" class="w-5 h-5 mr-2 text-blue-500"></i>
                                Submission Information
                            </h6>
                        </div>

                        <div>
                            <label for="employee_id" class="inline-block mb-2 text-base font-medium">Employee ID <span class="text-red-500">*</span></label>
                            <input type="text" id="employee_id" name="employee_id" value="{{ old('employee_id', $user->employee_id) }}" 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                   placeholder="Employee ID" readonly>
                            @error('employee_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="employee_name" class="inline-block mb-2 text-base font-medium">Employee Name <span class="text-red-500">*</span></label>
                            <input type="text" id="employee_name" name="employee_name" value="{{ old('employee_name', $user->name) }}" 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                   placeholder="Employee Name" readonly>
                            @error('employee_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="team_lead_name" class="inline-block mb-2 text-base font-medium">Team Lead Name <span class="text-red-500">*</span></label>
                            <input type="text" id="team_lead_name" name="team_lead_name" value="{{ old('team_lead_name', $teamLeadName ?? 'Not Assigned') }}" 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                   placeholder="Team Lead Name" readonly>
                            @error('team_lead_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="campaign" class="inline-block mb-2 text-base font-medium">Campaign <span class="text-red-500">*</span></label>
                            <select id="campaign" name="campaign" 
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" required>
                                <option value="">Select Campaign</option>
                                @if(count($campaigns) > 0)
                                    @foreach($campaigns as $campaign)
                                    <option value="{{ $campaign }}" {{ (old('campaign', $lastCampaign) === $campaign) ? 'selected' : '' }}>
                                        {{ $campaign }}
                                    </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No active campaigns available</option>
                                @endif
                            </select>
                            @error('campaign')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            @if(count($campaigns) == 0)
                                <p class="mt-1 text-sm text-orange-500">No active campaigns found. Please contact your administrator to add campaigns.</p>
                            @endif
                        </div>

                        <div>
                            <label for="phone" class="inline-block mb-2 text-base font-medium">Phone <span class="text-red-500">*</span></label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                   placeholder="Enter phone number" required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        @if(!$user->designation)
                            {{-- Show both forms for users without designation --}}
                            
                            {{-- CSR Form Section --}}
                            <div class="lg:col-span-2">
                                <div class="p-4 mb-4 border-2 border-blue-200 rounded-lg bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800">
                                    <h6 class="text-lg font-semibold mb-3 flex items-center text-blue-700 dark:text-blue-400">
                                        <i data-lucide="user-check" class="w-5 h-5 mr-2"></i>
                                        CSR Form Fields
                                    </h6>
                                    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                                        <div class="lg:col-span-2">
                                            <label for="jornaya_id" class="inline-block mb-2 text-base font-semibold text-blue-700 dark:text-blue-400">JORAYA ID (Self Closer)</label>
                                            <input type="text" id="jornaya_id" name="jornaya_id" value="{{ old('jornaya_id') }}" 
                                                   class="form-input border-blue-300 dark:border-blue-800 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-blue-50/50 dark:bg-blue-900/10"
                                                   placeholder="Enter Joraya ID here">
                                            <p class="mt-1 text-sm font-medium text-blue-600 dark:text-blue-400">Important: Only fill this if you are a "Self Closer". Otherwise, leave it blank.</p>
                                            @error('jornaya_id')
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="state" class="inline-block mb-2 text-base font-medium">State</label>
                                            <input type="text" id="state" name="state" value="{{ old('state') }}" 
                                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                                   placeholder="Enter state">
                                            @error('state')
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="zip_code" class="inline-block mb-2 text-base font-medium">ZIP Code</label>
                                            <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" 
                                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                                   placeholder="Enter ZIP code">
                                            @error('zip_code')
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="age" class="inline-block mb-2 text-base font-medium">Age</label>
                                            <input type="number" id="age" name="age" value="{{ old('age') }}" 
                                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                                   placeholder="Enter age" min="18" max="120">
                                            @error('age')
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Verification Officer Form Section --}}
                            <div class="lg:col-span-2">
                                <div class="p-4 mb-4 border-2 border-green-200 rounded-lg bg-green-50 dark:bg-green-900/20 dark:border-green-800">
                                    <h6 class="text-lg font-semibold mb-3 flex items-center text-green-700 dark:text-green-400">
                                        <i data-lucide="shield-check" class="w-5 h-5 mr-2"></i>
                                        Verification Officer Form Fields
                                    </h6>
                                    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                                        <div>
                                            <label for="jornaya_id" class="inline-block mb-2 text-base font-medium">Jornaya ID</label>
                                            <input type="text" id="jornaya_id" name="jornaya_id" value="{{ old('jornaya_id') }}" 
                                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                                   placeholder="Enter Jornaya ID">
                                            @error('jornaya_id')
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="did" class="inline-block mb-2 text-base font-medium">DID</label>
                                            <input type="text" id="did" name="did" value="{{ old('did') }}" 
                                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                                   placeholder="Enter DID">
                                            @error('did')
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Show only relevant fields for users with designation --}}
                            @if(auth()->user()->designation == 'CSR' || auth()->user()->isCsr())
                                <div class="lg:col-span-2">
                                    <label for="jornaya_id" class="inline-block mb-2 text-base font-semibold text-blue-700 dark:text-blue-400">JORAYA ID (Self Closer)</label>
                                    <input type="text" id="jornaya_id" name="jornaya_id" value="{{ old('jornaya_id') }}" 
                                           class="form-input border-blue-300 dark:border-blue-800 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-blue-50/50 dark:bg-blue-900/10"
                                           placeholder="Enter Joraya ID here">
                                    <p class="mt-1 text-sm font-medium text-blue-600 dark:text-blue-400">Important: Only fill this if you are a "Self Closer". Otherwise, leave it blank.</p>
                                    @error('jornaya_id')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="state" class="inline-block mb-2 text-base font-medium">State <span class="text-red-500">*</span></label>
                                    <input type="text" id="state" name="state" value="{{ old('state') }}" 
                                           class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                           placeholder="Enter state" required>
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="zip_code" class="inline-block mb-2 text-base font-medium">ZIP Code <span class="text-red-500">*</span></label>
                                    <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" 
                                           class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                           placeholder="Enter ZIP code" required>
                                    @error('zip_code')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            @if($user->isVerificationOfficer())
                                <div>
                                    <label for="jornaya_id" class="inline-block mb-2 text-base font-medium">Jornaya ID <span class="text-red-500">*</span></label>
                                    <input type="text" id="jornaya_id" name="jornaya_id" value="{{ old('jornaya_id') }}" 
                                           class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                           placeholder="Enter Jornaya ID" required>
                                    @error('jornaya_id')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="did_extension" class="inline-block mb-2 text-base font-medium">DID <span class="text-red-500">*</span></label>
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-4 py-2 text-base font-medium text-slate-500 bg-slate-100 border border-r-0 border-slate-300 rounded-l-md dark:bg-zink-600 dark:text-zink-200 dark:border-zink-500">
                                            D
                                        </span>
                                        <input type="text" id="did_extension" 
                                               class="rounded-l-none form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                               placeholder="Enter number (e.g. 5)"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, ''); document.getElementById('did').value = 'D' + this.value;"
                                               value="{{ old('did') ? substr(old('did'), 1) : '' }}" required>
                                    </div>
                                    <input type="hidden" id="did" name="did" value="{{ old('did') }}">
                                    @error('did')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        @endif

                        <div class="lg:col-span-2">
                            <label for="comment" class="inline-block mb-2 text-base font-medium">Comment</label>
                            <textarea id="comment" name="comment" rows="4" 
                                      class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                      placeholder="Enter your comment (optional)">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-2 mt-6">
                        <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                            <i data-lucide="save" class="w-4 h-4 mr-1"></i>
                            Create Submission
                        </button>
                        <a href="{{ route('submissions.index') }}" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Page-content -->

<script src="{{ URL::asset('assets/js/pages/submission-google-sheets.js') }}"></script>
@endsection
