@extends('layouts.master')
@section('title') Bulk Payroll Management @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <!-- Header -->
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Bulk Payroll Management</h5>
                <p class="text-slate-500 dark:text-zink-200">Bulk add bonuses, deductions, and other adjustments.</p>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('payroll.index') }}" class="text-slate-400 dark:text-zink-200">Payroll</a>
                </li>
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('payroll.management') }}" class="text-slate-400 dark:text-zink-200">Management</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Bulk Add</li>
            </ul>
        </div>

        @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <div class="flex items-center">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-2"></i>
                <span class="text-red-600 font-medium">Please correct the following errors:</span>
            </div>
            <ul class="list-disc list-inside text-red-600 mt-2 ml-7">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h6 class="text-15 mb-4">Bulk Import Form</h6>
                <form action="{{ route('payroll.management.bulk-store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="month" class="inline-block mb-2 text-slate-500 dark:text-zink-200 font-medium">Select Month <span class="text-red-500">*</span></label>
                            <select id="month" name="month" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500" required>
                                <option value="">Select Month</option>
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ date('F Y', mktime(0, 0, 0, $i, 1, date('Y'))) }}" {{ old('month', date('F Y')) == date('F Y', mktime(0, 0, 0, $i, 1, date('Y'))) ? 'selected' : '' }}>
                                    {{ date('F Y', mktime(0, 0, 0, $i, 1, date('Y'))) }}
                                </option>
                                @endfor
                            </select>
                            <p class="text-slate-400 text-xs mt-1">The payroll month these adjustments apply to.</p>
                        </div>

                        <div>
                            <label for="type" class="inline-block mb-2 text-slate-500 dark:text-zink-200 font-medium">Adjustment Type <span class="text-red-500">*</span></label>
                            <select id="type" name="type" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500" required>
                                <option value="">Select Type</option>
                                <option value="bonus" {{ old('type') == 'bonus' ? 'selected' : '' }}>Bonus</option>
                                <option value="dock_value" {{ old('type') == 'dock_value' ? 'selected' : '' }}>Dock Value</option>
                                <option value="ref_bonus" {{ old('type') == 'ref_bonus' ? 'selected' : '' }}>Referral Bonus</option>
                                <option value="advance" {{ old('type') == 'advance' ? 'selected' : '' }}>Advance</option>
                                <option value="plan" {{ old('type') == 'plan' ? 'selected' : '' }}>Plan</option>
                            </select>
                            <p class="text-slate-400 text-xs mt-1">Select what kind of value you are uploading.</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="bulk_data" class="inline-block mb-2 text-slate-500 dark:text-zink-200 font-medium">Data Input <span class="text-red-500">*</span></label>
                        <textarea id="bulk_data" name="bulk_data" rows="10" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 font-mono" placeholder="Mk994 3000&#10;Mk993 5000&#10;Mk884 9899" required>{{ old('bulk_data') }}</textarea>
                        <div class="mt-2 text-sm text-slate-500 dark:text-zink-400 bg-slate-50 dark:bg-zink-600 p-3 rounded-md">
                            <p class="font-medium mb-1">Format Instructions:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>One entry per line.</li>
                                <li>Format: <strong>EmployeeID</strong> [space] <strong>Amount</strong></li>
                                <li>Example: <code>MK123 5000</code></li>
                                <li>Amounts can contain commas (e.g., <code>1,000</code>) but will be stripped.</li>
                                <li>Employee ID must match exactly with the system record.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('payroll.management') }}" class="btn bg-slate-200 text-slate-600 hover:bg-slate-300">
                            Cancel
                        </a>
                        <button type="submit" class="btn bg-custom-500 text-white hover:bg-custom-600">
                            <i data-lucide="upload-cloud" class="w-4 h-4 mr-1"></i>
                            Process Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
