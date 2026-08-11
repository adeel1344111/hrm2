@extends('layouts.master')
@section('title') Edit Campaign @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Edit Campaign</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('campaigns.index') }}" class="text-slate-400 dark:text-zink-200">Campaigns</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Edit</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Campaign Form -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <h6 class="text-15">Edit Campaign</h6>
                                <p class="text-slate-500 dark:text-zink-200">Update the campaign details</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('campaigns.index') }}" class="text-slate-500 btn bg-slate-100 border-slate-200 hover:text-slate-600 hover:bg-slate-200 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-200 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-200 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-500 dark:text-zink-200 dark:border-zink-500 dark:hover:bg-zink-400 dark:hover:text-zink-100 dark:focus:bg-zink-400 dark:focus:text-zink-100 dark:focus:ring-zink-100 dark:active:bg-zink-400 dark:active:text-zink-100 dark:active:ring-zink-100">
                                    <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                                    Back to Campaigns
                                </a>
        </div>
    </div>

                        <form action="{{ route('campaigns.update', $campaign) }}" method="POST" id="campaignForm">
                        @csrf
                        @method('PUT')
                        
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label for="name" class="inline-block mb-2 text-base font-medium">
                                        Campaign Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $campaign->name) }}" 
                                           class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                           placeholder="Enter campaign name" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="description" class="inline-block mb-2 text-base font-medium">Description</label>
                                    <textarea id="description" name="description" rows="4" 
                                              class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                              placeholder="Enter campaign description">{{ old('description', $campaign->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                            </div>

                                <div>
                                    <label for="status" class="inline-block mb-2 text-base font-medium">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status" name="status" 
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status', $campaign->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $campaign->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="completed" {{ old('status', $campaign->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mt-6">
                                <button type="submit" class="btn bg-custom-500 text-white border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                    <i data-lucide="save" class="w-4 h-4 mr-1"></i>
                                    Update Campaign
                                </button>
                                <a href="{{ route('campaigns.index') }}" class="btn bg-slate-500 text-white border-slate-500 hover:text-white hover:bg-slate-600 hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:border-slate-600 active:ring active:ring-slate-100 dark:ring-slate-400/20">
                                    <i data-lucide="x" class="w-4 h-4 mr-1"></i>
                                    Cancel
                                </a>
                            </div>
                        </form>
                                </div>
                            </div>
                        </div>

            <!-- Preview Card -->
            <div class="lg:col-span-1">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-6">
                            <h6 class="text-15">Campaign Preview</h6>
                            <p class="text-slate-500 dark:text-zink-200">Live preview of your campaign</p>
                        </div>

                        <div id="previewContent" class="space-y-4">
                            <div class="text-center">
                                <div class="w-16 h-16 rounded-full bg-purple-100 dark:bg-purple-900/20 flex items-center justify-center mx-auto mb-3">
                                    <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ substr($campaign->name, 0, 2) }}</span>
                                </div>
                                <h6 class="font-semibold text-lg">{{ $campaign->name }}</h6>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $campaign->status_color }}">
                                    {{ $campaign->status_label }}
                                </span>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="file-text" class="w-4 h-4 text-blue-500"></i>
                                    <span class="font-medium">Description:</span>
                                    <span class="text-sm">{{ $campaign->description ?: 'No description provided' }}</span>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
function updatePreview() {
    const previewContent = document.getElementById('previewContent');
    const formData = new FormData(document.getElementById('campaignForm'));
    
    const name = formData.get('name') || 'Campaign Name';
    const description = formData.get('description') || 'No description provided';
    const status = formData.get('status') || 'active';
    
    const statusColors = {
        'active': 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
        'inactive': 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
        'completed': 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400'
    };
    
    previewContent.innerHTML = `
        <div class="space-y-4">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-purple-100 dark:bg-purple-900/20 flex items-center justify-center mx-auto mb-3">
                    <span class="text-lg font-bold text-purple-600 dark:text-purple-400">${name.substring(0, 2).toUpperCase()}</span>
                </div>
                <h6 class="font-semibold text-lg">${name}</h6>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[status] || statusColors['active']}">
                    ${status.charAt(0).toUpperCase() + status.slice(1)}
                </span>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-blue-500"></i>
                    <span class="font-medium">Description:</span>
                    <span class="text-sm">${description}</span>
                </div>
            </div>
        </div>
    `;
}

// Update preview on form changes
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('campaignForm');
    const inputs = form.querySelectorAll('input, textarea, select');
    
    inputs.forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });
    
    // Initial preview update
    updatePreview();
});
</script>
@endsection
@endsection
