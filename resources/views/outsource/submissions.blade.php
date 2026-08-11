@extends('layouts.outsource-master')

@section('title', 'Today Submissions')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Today Submissions</h5>
                <p class="text-slate-500 dark:text-zink-200">{{ $company }} · {{ $periodLabel }} · {{ $submissions->count() }} leads · {{ $totalSales ?? 0 }} sales</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm whitespace-nowrap">
                        <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                            <tr>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">#</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Dialer ID</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Name</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Phone</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Campaign</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">State</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">ZIP</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Age</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Sale</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $i => $row)
                            <tr class="border-b border-slate-200 dark:border-zink-500">
                                <td class="px-3.5 py-2.5">{{ $i + 1 }}</td>
                                <td class="px-3.5 py-2.5 font-mono">{{ $row->dialer_id }}</td>
                                <td class="px-3.5 py-2.5">{{ $row->name }}</td>
                                <td class="px-3.5 py-2.5 font-mono">{{ $row->phone }}</td>
                                <td class="px-3.5 py-2.5">{{ $row->campaign }}</td>
                                <td class="px-3.5 py-2.5">{{ $row->state ?: '—' }}</td>
                                <td class="px-3.5 py-2.5">{{ $row->zip ?: '—' }}</td>
                                <td class="px-3.5 py-2.5">{{ $row->age ?? '—' }}</td>
                                <td class="px-3.5 py-2.5">
                                    @if($row->is_sale)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">Sale</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-slate-400">Not Sale</span>
                                    @endif
                                </td>
                                <td class="px-3.5 py-2.5 whitespace-nowrap">{{ optional($row->created_at)->format('Y-m-d H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-3.5 py-10 text-center text-slate-500 dark:text-zink-200">No submissions in today’s window.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
