@extends('layouts.master')

@section('title') QA Compliance @endsection

@section('content')
@php
    $fmtSales = fn ($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.') ?: '0';
    $showPhone = function ($phone) use ($maskPhone) {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '') return '—';
        if ($maskPhone) return '******' . substr($digits, -4);
        return $digits;
    };
@endphp
<style>
    /* One row: selects + buttons same height / baseline */
    .qa-compliance-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 0.75rem;
    }
    .qa-compliance-filters .qa-filter-field {
        flex: 1 1 11rem;
        min-width: 10rem;
    }
    .qa-compliance-filters .qa-filter-field label {
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.25rem;
    }
    .qa-compliance-filters .form-input,
    .qa-compliance-filters .btn {
        box-sizing: border-box;
        height: 2.5rem;
        min-height: 2.5rem;
        margin: 0;
        padding: 0 1rem;
        font-size: 0.875rem;
        line-height: 1.25;
        display: inline-flex;
        align-items: center;
        vertical-align: middle;
    }
    .qa-compliance-filters .form-input {
        width: 100%;
    }
    .qa-compliance-filters .qa-filter-actions {
        flex: 0 0 auto;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0;
    }
    .qa-result-badge {
        display: inline-block;
        padding: 0.125rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1.25rem;
        border-radius: 9999px;
    }
    .qa-result-badge.is-pass {
        background-color: #dcfce7;
        color: #166534 !important;
    }
    .qa-result-badge.is-fail {
        background-color: #fef9c3;
        color: #854d0e !important;
    }
    .qa-result-badge.is-critical {
        background-color: #fee2e2;
        color: #991b1b !important;
    }
    .qa-btn-reset {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        border-color: #e2e8f0 !important;
    }
    .qa-btn-reset:hover {
        background-color: #e2e8f0 !important;
        color: #1e293b !important;
    }
    .qa-btn-view-comment {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
        border-color: #bfdbfe !important;
    }
    .qa-btn-view-comment:hover {
        background-color: #dbeafe !important;
        color: #1e40af !important;
    }
    [data-mode="dark"] .qa-result-badge.is-pass,
    html.dark .qa-result-badge.is-pass {
        background-color: rgba(34, 197, 94, 0.2) !important;
        color: #4ade80 !important;
    }
    [data-mode="dark"] .qa-result-badge.is-fail,
    html.dark .qa-result-badge.is-fail {
        background-color: rgba(234, 179, 8, 0.2) !important;
        color: #facc15 !important;
    }
    [data-mode="dark"] .qa-result-badge.is-critical,
    html.dark .qa-result-badge.is-critical {
        background-color: rgba(239, 68, 68, 0.2) !important;
        color: #f87171 !important;
    }
    [data-mode="dark"] .qa-btn-reset,
    html.dark .qa-btn-reset {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }
    [data-mode="dark"] .qa-btn-reset:hover,
    html.dark .qa-btn-reset:hover {
        background-color: #475569 !important;
        color: #f8fafc !important;
    }
    [data-mode="dark"] .qa-btn-view-comment,
    html.dark .qa-btn-view-comment {
        background-color: rgba(59, 130, 246, 0.15) !important;
        color: #93c5fd !important;
        border-color: rgba(59, 130, 246, 0.35) !important;
    }
    [data-mode="dark"] .qa-btn-view-comment:hover,
    html.dark .qa-btn-view-comment:hover {
        background-color: rgba(59, 130, 246, 0.28) !important;
        color: #bfdbfe !important;
    }
    /* Popup stays inside main content column only (not over sidebar / topbar) */
    .qa-comment-modal {
        top: 4.375rem; /* header */
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 40;
    }
    @media (min-width: 768px) {
        html[data-sidebar-size="lg"] .qa-comment-modal,
        html:not([data-sidebar-size]) .qa-comment-modal {
            left: 16.25rem; /* vertical-menu */
        }
        html[data-sidebar-size="md"] .qa-comment-modal {
            left: 10.3125rem; /* vertical-menu-md */
        }
        html[data-sidebar-size="sm"] .qa-comment-modal {
            left: 4.375rem; /* vertical-menu-sm */
        }
        html[dir="rtl"][data-sidebar-size="lg"] .qa-comment-modal,
        html[dir="rtl"]:not([data-sidebar-size]) .qa-comment-modal {
            left: 0;
            right: 16.25rem;
        }
        html[dir="rtl"][data-sidebar-size="md"] .qa-comment-modal {
            left: 0;
            right: 10.3125rem;
        }
        html[dir="rtl"][data-sidebar-size="sm"] .qa-comment-modal {
            left: 0;
            right: 4.375rem;
        }
    }
    .qa-comment-modal-inner {
        position: relative;
        z-index: 1;
        min-height: 100%;
    }
    .qa-comment-modal-backdrop {
        z-index: 0;
    }
    .qa-comment-modal-panel {
        z-index: 1;
    }
</style>
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">QA Compliance</h5>
                <p class="text-sm text-slate-500 dark:text-zink-400 mt-1">
                    {{ $roleLabel }} · Showing <strong>{{ $periodLabel }}</strong> (Phoenix)
                    @unless($isManager)
                        · Logged in as <strong>{{ $user->name }}</strong> ({{ $user->employee_id }})
                    @endunless
                </p>
            </div>
        </div>

        @unless($isManager)
        <div class="card mb-6 border border-custom-200 bg-custom-50 dark:bg-zink-600">
            <div class="card-body">
                <p class="text-base font-semibold text-slate-800 dark:text-zink-50 mb-1">
                    Your evaluations this month: <span class="text-custom-600">{{ $evalStats['total'] }}</span>
                </p>
                <p class="text-sm text-slate-600 dark:text-zink-300">
                    Phone numbers are masked. Sales penalties / mistakes appear only when QA applied a penalty on a NO answer.
                </p>
            </div>
        </div>
        @endunless

        {{-- Filters --}}
        <div class="card mb-6">
            <div class="card-body">
                <form method="GET" action="{{ route('qa-compliance.index') }}" class="qa-compliance-filters">
                    @if($isAdmin)
                    <div class="qa-filter-field">
                        <label>Month</label>
                        <select name="month" class="form-input border-slate-200 dark:border-zink-500">
                            @foreach($monthOptions as $key => $label)
                                <option value="{{ $key }}" @selected($periodKey === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    @elseif($isManager)
                    <div class="qa-filter-field">
                        <label>Period</label>
                        <select name="period" class="form-input border-slate-200 dark:border-zink-500">
                            @foreach($monthOptions as $key => $label)
                                <option value="{{ $key }}" @selected($periodKey === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <div class="qa-filter-field">
                        <label>Period</label>
                        <input type="text" class="form-input border-slate-200 dark:border-zink-500 bg-slate-50" value="{{ $periodLabel }} (current month)" disabled>
                    </div>
                    @endif

                    @if($isManager && $agentsForFilter->count())
                    <div class="qa-filter-field">
                        <label>Agent</label>
                        <select name="agent_id" class="form-input border-slate-200 dark:border-zink-500">
                            <option value="">All agents ({{ $agentsForFilter->count() }})</option>
                            @foreach($agentsForFilter as $agent)
                                <option value="{{ $agent->id }}" @selected((string) $filterAgentId === (string) $agent->id)>
                                    {{ $agent->name }}{{ $agent->employee_id ? ' ('.$agent->employee_id.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    @if($isManager)
                    <div class="qa-filter-field">
                        <label>Score</label>
                        <select name="score" class="form-input border-slate-200 dark:border-zink-500">
                            <option value="" @selected($filterScore === '')>All scores</option>
                            <option value="under_100" @selected($filterScore === 'under_100')>Under 100%</option>
                        </select>
                    </div>
                    @endif

                    <div class="qa-filter-actions">
                        <button type="submit" class="btn bg-custom-500 text-white border-custom-500 hover:bg-custom-600">Apply</button>
                        @if($filterAgentId || $filterScore || ($isAdmin && $periodKey !== now('America/Phoenix')->format('Y-m')) || ($isManager && !$isAdmin && $periodKey !== 'current'))
                        <a href="{{ route('qa-compliance.index') }}" class="btn qa-btn-reset border">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Summary cards for selected period --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-3xl font-bold text-slate-800 dark:text-zink-50 mb-1">{{ $evalStats['total'] }}</h6>
                    <p class="text-sm text-slate-600 dark:text-zink-300">Evaluations ({{ $periodLabel }})</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-3xl font-bold text-green-600 mb-1">{{ $evalStats['pass'] }}</h6>
                    <p class="text-sm text-slate-600 dark:text-zink-300">Pass</p>
                    <p class="text-xs text-slate-400 mt-1">Avg score: {{ $evalStats['avg_score'] !== null ? $evalStats['avg_score'].'%' : '—' }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-3xl font-bold text-orange-600 mb-1">{{ $evalStats['mistakes'] }}</h6>
                    <p class="text-sm text-slate-600 dark:text-zink-300">Mistakes (applied)</p>
                    <p class="text-xs text-slate-400 mt-1">This mo {{ $mistakesThisMonth }} · Last mo {{ $mistakesLastMonth }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-3xl font-bold text-red-700 mb-1">{{ $fmtSales($evalStats['sales_penalty']) }}</h6>
                    <p class="text-sm text-slate-600 dark:text-zink-300">Sales penalty (period)</p>
                    <p class="text-xs text-slate-400 mt-1">Lifetime: {{ $fmtSales($lifetimeSales) }}</p>
                </div>
            </div>
        </div>

        {{-- Evaluations from QMS --}}
        <div class="card mb-6">
            <div class="card-body">
                <h6 class="mb-4 text-15 font-semibold">
                    QMS Evaluations — {{ $periodLabel }}
                    @if($filterScore === 'under_100')
                        <span class="text-orange-500 font-semibold">(Under 100% only)</span>
                    @endif
                </h6>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-slate-200 dark:divide-zink-500">
                        <thead class="bg-slate-50 dark:bg-zink-600">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Call date</th>
                                @if($isManager)
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Agent</th>
                                @endif
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Phone</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">DID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Score</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Result</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Mistakes</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Sales −</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">UID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-zink-500">
                            @forelse($evaluations as $ev)
                            <tr class="hover:bg-slate-50 dark:hover:bg-zink-600">
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    {{ optional($ev->call_date)->format('Y-m-d H:i') ?? '—' }}
                                </td>
                                @if($isManager)
                                <td class="px-4 py-3 text-sm">{{ $ev->user->name ?? $ev->agent_name ?? 'N/A' }}</td>
                                @endif
                                <td class="px-4 py-3 text-sm font-mono">{{ $showPhone($ev->phone_number) }}</td>
                                <td class="px-4 py-3 text-sm">{{ $ev->did ?: '—' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $ev->final_score !== null ? $ev->final_score.'%' : '—' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($ev->is_critical_failure)
                                        <span class="qa-result-badge is-critical">Critical Fail</span>
                                    @elseif($ev->is_pass)
                                        <span class="qa-result-badge is-pass">Pass</span>
                                    @else
                                        <span class="qa-result-badge is-fail">Fail</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $ev->mistakes_count }}</td>
                                <td class="px-4 py-3 text-sm">{{ $fmtSales($ev->sales_deduction_total) }}</td>
                                <td class="px-4 py-3 text-sm text-xs text-slate-500">{{ $ev->evaluation_uid }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($ev->final_score !== null && (float) $ev->final_score < 100)
                                        <button
                                            type="button"
                                            class="btn qa-btn-view-comment border text-xs px-2 py-1 h-auto min-h-0"
                                            data-uid="{{ $ev->evaluation_uid }}"
                                            data-score="{{ $ev->final_score }}"
                                            data-comment="{{ $ev->qa_comments ?? '' }}"
                                            onclick="openQaCommentModal(this)"
                                        >View Comment</button>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $isManager ? 10 : 9 }}" class="px-4 py-8 text-center text-sm text-slate-500">
                                    No QMS evaluations found for {{ $periodLabel }}.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Penalties in period --}}
        <div class="card mb-6">
            <div class="card-body">
                <h6 class="mb-4 text-15 font-semibold">Sales penalties — {{ $periodLabel }}</h6>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-slate-200 dark:divide-zink-500">
                        <thead class="bg-slate-50 dark:bg-zink-600">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Date</th>
                                @if($isManager)
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Agent</th>
                                @endif
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Phone</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Decision</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Sales</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-zink-500">
                            @forelse($penaltiesInPeriod as $row)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ optional($row->occurred_at)->format('Y-m-d') ?? '—' }}</td>
                                @if($isManager)
                                <td class="px-4 py-3 text-sm">{{ $row->user->name ?? 'N/A' }}</td>
                                @endif
                                <td class="px-4 py-3 text-sm font-mono">{{ $showPhone($row->phone_number) }}</td>
                                <td class="px-4 py-3 text-sm">{{ strtoupper(str_replace('_', ' ', $row->violation_category)) }}</td>
                                <td class="px-4 py-3 text-sm">{{ $row->penalty_decision === 'apply' ? 'Applied' : 'Approved by TL' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($row->penalty_outcome === 'termination') Termination
                                    @elseif($row->penalty_outcome === 'sale_rejected') Sale rejected
                                    @elseif($row->penalty_outcome === 'tl_responsible') 0 (TL)
                                    @else {{ $fmtSales($row->sales_deduction) }}
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $isManager ? 6 : 5 }}" class="px-4 py-6 text-center text-sm text-slate-500">
                                    No sales penalties in this period.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- QA Comment popup: confined to main content (does not cover sidebar/topbar) --}}
<div id="qaCommentModal"
     class="qa-comment-modal fixed hidden overflow-y-auto"
     aria-hidden="true">
    <div class="qa-comment-modal-inner flex items-center justify-center min-h-full px-4 py-6 text-center">
        <div class="qa-comment-modal-backdrop absolute inset-0 bg-slate-900/40" onclick="closeQaCommentModal()"></div>
        <div class="qa-comment-modal-panel relative w-full max-w-lg p-6 text-left bg-white shadow-xl rounded-2xl dark:bg-zink-700 border border-slate-200 dark:border-zink-600">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-zink-100">QA Comment</h3>
                <button type="button" onclick="closeQaCommentModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-zink-200" aria-label="Close">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <p class="text-xs text-slate-500 dark:text-zink-400 mb-3">
                <span id="qaCommentMetaUid"></span>
                <span id="qaCommentMetaScore" class="ml-2"></span>
            </p>
            <div id="qaCommentBody" class="text-sm text-slate-800 dark:text-zink-100 whitespace-pre-wrap break-words max-h-80 overflow-y-auto leading-relaxed min-h-[4rem] p-3 rounded-lg bg-slate-50 dark:bg-zink-600 border border-slate-200 dark:border-zink-500"></div>
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="closeQaCommentModal()" class="btn qa-btn-reset border">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function decodeHtmlEntities(str) {
    if (!str) return '';
    const t = document.createElement('textarea');
    t.innerHTML = str;
    return t.value;
}

function openQaCommentModal(btn) {
    const modal = document.getElementById('qaCommentModal');
    const body = document.getElementById('qaCommentBody');
    const uidEl = document.getElementById('qaCommentMetaUid');
    const scoreEl = document.getElementById('qaCommentMetaScore');
    if (!modal || !body) return;

    const uid = btn.getAttribute('data-uid') || '';
    const score = btn.getAttribute('data-score') || '';
    const comment = decodeHtmlEntities((btn.getAttribute('data-comment') || '').trim());

    if (uidEl) uidEl.textContent = uid ? ('UID: ' + uid) : '';
    if (scoreEl) scoreEl.textContent = score !== '' ? ('Score: ' + score + '%') : '';
    body.textContent = comment || 'No comment provided by QA.';

    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');
    if (window.lucide && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons();
    }
}

function closeQaCommentModal() {
    const modal = document.getElementById('qaCommentModal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeQaCommentModal();
});
</script>
@endsection
