@extends('layouts.master')
@section('title') Campaign Details @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Campaign Details</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('campaigns.index') }}" class="text-slate-400 dark:text-zink-200">Campaigns</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Details</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Campaign Details -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <h6 class="text-15">Campaign Information</h6>
                                <p class="text-slate-500 dark:text-zink-200">View campaign details and information</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('campaigns.edit', $campaign) }}" class="btn bg-green-500 text-white border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i>
                                    Edit Campaign
                                </a>
                                <a href="{{ route('campaigns.index') }}" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100">
                                    <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                                    Back to Campaigns
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Campaign Name</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    {{ $campaign->name }}
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Description</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200 min-h-[100px]" readonly>
                                    {{ $campaign->description ?: 'No description provided' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Status</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $campaign->status_color }}">
                                        {{ $campaign->status_label }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Created By</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    {{ $campaign->created_by ?: 'System' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-500 dark:text-zink-400 mb-2">Created At</label>
                                <div class="form-input bg-slate-100 dark:bg-zink-600 border-slate-300 dark:border-zink-500 text-slate-500 dark:text-zink-200" readonly>
                                    {{ $campaign->created_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Summary -->
            <div class="lg:col-span-1">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-6">
                            <h6 class="text-15">Campaign Summary</h6>
                            <p class="text-slate-500 dark:text-zink-200">Quick overview of campaign details</p>
                        </div>
                        
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 rounded-full bg-purple-100 dark:bg-purple-900/20 flex items-center justify-center mx-auto mb-3">
                                <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ substr($campaign->name, 0, 2) }}</span>
                            </div>
                            <h6 class="font-semibold text-lg mb-2">{{ $campaign->name }}</h6>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $campaign->status_color }}">
                                {{ $campaign->status_label }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-zink-600 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="user" class="w-4 h-4 text-purple-500"></i>
                                    <span class="text-sm font-medium">Created By</span>
                                </div>
                                <span class="text-sm font-semibold">{{ $campaign->created_by ?: 'System' }}</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-200 dark:border-zink-500">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('campaigns.edit', $campaign) }}" class="btn bg-custom-500 text-white border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20 w-full">
                                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i>
                                    Edit Campaign
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
