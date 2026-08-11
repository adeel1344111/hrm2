@extends('layouts.master')
@section('title') Settings - Goal Management @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <!-- Header -->
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Goal Settings</h5>
                <p class="text-slate-500 dark:text-zink-200">Manage daily, weekly, and monthly submission goals for agents.</p>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="#!" class="text-slate-400 dark:text-zink-200">Settings</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Goal Management</li>
            </ul>
        </div>

        <!-- Settings Form -->
        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 lg:col-span-8">
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center justify-between mb-6">
                            <h6 class="text-15">Performance Goals Configuration</h6>
                            <div class="flex gap-2">
                                <button type="button" onclick="resetSettings()" class="btn btn-sm bg-slate-500 text-white hover:bg-slate-600">
                                    <i data-lucide="refresh-cw" class="w-4 h-4 mr-1"></i>
                                    Reset to Default
                                </button>
                            </div>
                        </div>

                        @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="flex items-center">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                                <span class="text-green-600 font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <div class="flex items-center">
                                <i data-lucide="x-circle" class="w-5 h-5 text-red-600 mr-2"></i>
                                <span class="text-red-600 font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('goal-settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Daily Goal -->
                                <div class="space-y-4">
                                    <div class="text-center p-6 bg-blue-50 dark:bg-zink-700 rounded-lg border border-blue-200 dark:border-blue-500/30">
                                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i data-lucide="calendar" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <h6 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-2">Daily Goal</h6>
                                        <p class="text-sm text-slate-500 dark:text-zink-400 mb-4">Submissions per day</p>
                                        
                                        <div class="relative">
                                            <input type="number" 
                                                   name="daily_goal" 
                                                   value="{{ old('daily_goal', $settings['daily_goal']) }}"
                                                   min="1" 
                                                   max="50"
                                                   class="form-input text-center text-2xl font-bold text-blue-600 dark:text-blue-400 dark:bg-zink-700 border-blue-200 dark:border-blue-800 focus:border-blue-500 dark:focus:border-blue-400 @error('daily_goal') border-red-500 @enderror"
                                                   required>
                                            @error('daily_goal')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Weekly Goal -->
                                <div class="space-y-4">
                                    <div class="text-center p-6 bg-green-50 dark:bg-zink-700 rounded-lg border border-green-200 dark:border-green-500/30">
                                        <div class="w-16 h-16 bg-green-100 dark:bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i data-lucide="calendar-days" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
                                        </div>
                                        <h6 class="text-lg font-semibold text-green-600 dark:text-green-400 mb-2">Weekly Goal</h6>
                                        <p class="text-sm text-slate-500 dark:text-zink-400 mb-4">Submissions per week</p>
                                        
                                        <div class="relative">
                                            <input type="number" 
                                                   name="weekly_goal" 
                                                   value="{{ old('weekly_goal', $settings['weekly_goal']) }}"
                                                   min="1" 
                                                   max="200"
                                                   class="form-input text-center text-2xl font-bold text-green-600 dark:text-green-400 dark:bg-zink-700 border-green-200 dark:border-green-800 focus:border-green-500 dark:focus:border-green-400 @error('weekly_goal') border-red-500 @enderror"
                                                   required>
                                            @error('weekly_goal')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Monthly Goal -->
                                <div class="space-y-4">
                                    <div class="text-center p-6 bg-purple-50 dark:bg-zink-700 rounded-lg border border-purple-200 dark:border-purple-500/30">
                                        <div class="w-16 h-16 bg-purple-100 dark:bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i data-lucide="calendar-range" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
                                        </div>
                                        <h6 class="text-lg font-semibold text-purple-600 dark:text-purple-400 mb-2">Monthly Goal</h6>
                                        <p class="text-sm text-slate-500 dark:text-zink-400 mb-4">Submissions per month</p>
                                        
                                        <div class="relative">
                                            <input type="number" 
                                                   name="monthly_goal" 
                                                   value="{{ old('monthly_goal', $settings['monthly_goal']) }}"
                                                   min="1" 
                                                   max="1000"
                                                   class="form-input text-center text-2xl font-bold text-purple-600 dark:text-purple-400 dark:bg-zink-700 border-purple-200 dark:border-purple-800 focus:border-purple-500 dark:focus:border-purple-400 @error('monthly_goal') border-red-500 @enderror"
                                                   required>
                                            @error('monthly_goal')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-zink-600">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('home') }}" class="btn btn-sm bg-slate-500 text-white hover:bg-slate-600">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-sm bg-custom-500 text-white hover:bg-custom-600">
                                        <i data-lucide="save" class="w-4 h-4 mr-1"></i>
                                        Save Settings
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Information Panel -->
            <div class="col-span-12 lg:col-span-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-15 mb-4">Goal Management Information</h6>
                        
                        <div class="space-y-4">
                            <div class="p-4 bg-blue-50 dark:bg-zink-700 border dark:border-blue-500/20 rounded-lg">
                                <div class="flex items-start">
                                    <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 mt-0.5"></i>
                                    <div>
                                        <h6 class="font-medium text-blue-600 dark:text-blue-400 mb-1">Daily Goals</h6>
                                        <p class="text-xs text-blue-500 dark:text-blue-300">Set the minimum number of submissions agents should complete each day. This affects performance tracking and dashboard indicators.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-green-50 dark:bg-zink-700 border dark:border-green-500/20 rounded-lg">
                                <div class="flex items-start">
                                    <i data-lucide="target" class="w-5 h-5 text-green-600 dark:text-green-400 mr-3 mt-0.5"></i>
                                    <div>
                                        <h6 class="font-medium text-green-600 dark:text-green-400 mb-1">Weekly Goals</h6>
                                        <p class="text-xs text-green-500 dark:text-green-300">Define weekly targets for agents. Used in performance reports and team comparisons.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-purple-50 dark:bg-zink-700 border dark:border-purple-500/20 rounded-lg">
                                <div class="flex items-start">
                                    <i data-lucide="trending-up" class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-3 mt-0.5"></i>
                                    <div>
                                        <h6 class="font-medium text-purple-600 dark:text-purple-400 mb-1">Monthly Goals</h6>
                                        <p class="text-xs text-purple-500 dark:text-purple-300">Set monthly targets for long-term performance tracking and annual reviews.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-orange-50 dark:bg-zink-700 border dark:border-orange-500/20 rounded-lg">
                                <div class="flex items-start">
                                    <i data-lucide="alert-triangle" class="w-5 h-5 text-orange-600 dark:text-orange-400 mr-3 mt-0.5"></i>
                                    <div>
                                        <h6 class="font-medium text-orange-600 dark:text-orange-400 mb-1">Performance Indicators</h6>
                                        <p class="text-xs text-orange-500 dark:text-orange-300">Agents who don't meet their daily goals will be highlighted in red in performance reports and team comparisons.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page-content -->
@endsection

@section('script')
<script>
function resetSettings() {
    if (confirm('Are you sure you want to reset all settings to default values?')) {
        window.location.href = '{{ route("goal-settings.reset") }}';
    }
}

// Add input validation
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="number"]');
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.getAttribute('min'));
            const max = parseInt(this.getAttribute('max'));
            
            if (value < min) {
                this.value = min;
            } else if (value > max) {
                this.value = max;
            }
        });
    });
});
</script>
@endsection
