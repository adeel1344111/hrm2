@extends('layouts.master')
@section('title') Team Performance Report @endsection
@section('content')
<!-- Page-content -->
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Team Performance Report</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                    <a href="{{ route('submissions.index') }}" class="text-slate-400 dark:text-zink-200">Submissions</a>
                </li>
                <li class="text-slate-700 dark:text-zink-100">Team Report</li>
            </ul>
        </div>
        
        <!-- Info Card -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h6 class="text-15">Team Night Shift Performance</h6>
                        <p class="text-slate-500 dark:text-zink-200">{{ $shiftData['period_label'] }}</p>
                        <p class="text-sm text-slate-600 dark:text-zink-300">Aggregated stats by Team Lead (6:00 PM - 6:00 AM)</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="exportToExcel()" class="text-white btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                            <i data-lucide="download" class="w-4 h-4 mr-1"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if(count($teamPerformanceData) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="teamPerformanceTable">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-zink-600">
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500">
                                    Team Lead
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500 bg-blue-50 dark:bg-blue-500/10">
                                    Total Submissions
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 dark:text-zink-400 uppercase tracking-wider border border-slate-200 dark:border-zink-500 bg-green-50 dark:bg-green-500/10">
                                    Sales
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zink-700 divide-y divide-slate-200 dark:divide-zink-500">
                            @foreach($teamPerformanceData as $data)
                            <tr class="hover:bg-slate-50 dark:hover:bg-zink-600">
                                <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    {{ $data['team_lead']->name }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-blue-50 dark:bg-blue-500/10">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300">
                                        {{ $data['total_submissions'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-green-50 dark:bg-green-500/10">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">
                                        {{ $data['sales_count'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-slate-100 dark:bg-zink-600">
                                <td class="px-4 py-3 text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500">
                                    Grand Total
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-blue-50 dark:bg-blue-500/10">
                                    @php
                                        $grandTotal = array_sum(array_column($teamPerformanceData, 'total_submissions'));
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300">
                                        {{ $grandTotal }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-slate-900 dark:text-zink-100 border border-slate-200 dark:border-zink-500 bg-green-50 dark:bg-green-500/10">
                                    @php
                                        $totalSales = array_sum(array_column($teamPerformanceData, 'sales_count'));
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300">
                                        {{ $totalSales }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-12">
                    <i data-lucide="users" class="w-16 h-16 mx-auto text-slate-400 dark:text-zink-500 mb-4"></i>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-zink-100 mb-2">No Team Data</h3>
                    <p class="text-slate-500 dark:text-zink-400">No active Team Leads found.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function exportToExcel() {
    const table = document.getElementById('teamPerformanceTable');
    if (!table) return;
    
    const rows = Array.from(table.rows);
    let csvContent = '';
    
    rows.forEach((row, index) => {
        const cells = Array.from(row.cells);
        const rowData = cells.map(cell => {
            const text = cell.textContent.trim();
            return text.includes(',') ? `"${text.replace(/"/g, '""')}"` : text;
        });
        csvContent += rowData.join(',') + '\n';
    });
    
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'team_performance_report_{{ now()->format('Y-m-d_H-i') }}.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endsection
