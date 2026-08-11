@extends('layouts.master')
@section('title') Department Details @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Department Details</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('departments.index') }}" class="text-slate-400 dark:text-zink-200">Departments</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">{{ $department->name }}</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
            <!-- Department Information -->
            <div class="xl:col-span-8">
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                                <i data-lucide="building-2" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <h6 class="text-15">{{ $department->name }}</h6>
                                <p class="text-slate-500 dark:text-zink-200">Department Information</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Department Code</label>
                                <div class="flex items-center p-3 bg-slate-50 dark:bg-zink-700 rounded-lg">
                                    <span class="text-slate-900 dark:text-zink-100 font-medium">{{ $department->code }}</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Status</label>
                                <div class="flex items-center p-3 bg-slate-50 dark:bg-zink-700 rounded-lg">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($department->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @endif">
                                        {{ ucfirst($department->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($department->description)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-1">Description</label>
                            <div class="p-3 bg-slate-50 dark:bg-zink-700 rounded-lg">
                                <p class="text-slate-900 dark:text-zink-100">{{ $department->description }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="xl:col-span-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-15 mb-4">Actions</h6>
                        
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('departments.edit', $department) }}" 
                               class="btn bg-custom-500 text-white border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                                Edit Department
                            </a>
                            
                            <a href="{{ route('departments.index') }}" 
                               class="btn bg-slate-200 text-slate-500 border-slate-200 hover:text-slate-500 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-500 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-500 active:bg-slate-300 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-600 dark:hover:bg-zink-500 dark:text-zink-200 dark:ring-zink-400/50">
                                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
