@extends('layouts.outsource-master')

@section('title', 'Outsource Dashboard')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Dashboard</h5>
                <p class="text-slate-500 dark:text-zink-200">{{ $company }} · {{ $periodLabel }}</p>
            </div>
            <a href="{{ route('outsource.submissions') }}" class="text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600">View Today Submissions</a>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3 mb-6">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-sm text-slate-500 dark:text-zink-300 mb-1">Total Submissions Today</p>
                    <h6 class="text-3xl font-bold text-slate-800 dark:text-zink-50">{{ $totalSubmissions }}</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-sm text-slate-500 dark:text-zink-300 mb-1">Total Sales Today</p>
                    <h6 class="text-3xl font-bold text-green-600">{{ $totalSales }}</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-sm text-slate-500 dark:text-zink-300 mb-1">Conversion</p>
                    <h6 class="text-3xl font-bold text-custom-500">{{ $conversion }}%</h6>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
