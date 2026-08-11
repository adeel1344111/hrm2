<?php $__env->startSection('title'); ?> QA Compliance <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $fmtSales = fn ($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.') ?: '0';
    $showPhone = function ($phone) use ($maskPhone) {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '') return '—';
        if ($maskPhone) return '******' . substr($digits, -4);
        return $digits;
    };
?>
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
                    <?php echo e($roleLabel); ?> · Showing <strong><?php echo e($periodLabel); ?></strong> (Phoenix)
                    <?php if (! ($isManager)): ?>
                        · Logged in as <strong><?php echo e($user->name); ?></strong> (<?php echo e($user->employee_id); ?>)
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <?php if (! ($isManager)): ?>
        <div class="card mb-6 border border-custom-200 bg-custom-50 dark:bg-zink-600">
            <div class="card-body">
                <p class="text-base font-semibold text-slate-800 dark:text-zink-50 mb-1">
                    Your evaluations this month: <span class="text-custom-600"><?php echo e($evalStats['total']); ?></span>
                </p>
                <p class="text-sm text-slate-600 dark:text-zink-300">
                    Phone numbers are masked. Sales penalties / mistakes appear only when QA applied a penalty on a NO answer.
                </p>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="card mb-6">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('qa-compliance.index')); ?>" class="qa-compliance-filters">
                    <?php if($isAdmin): ?>
                    <div class="qa-filter-field">
                        <label>Month</label>
                        <select name="month" class="form-input border-slate-200 dark:border-zink-500">
                            <?php $__currentLoopData = $monthOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php if($periodKey === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php elseif($isManager): ?>
                    <div class="qa-filter-field">
                        <label>Period</label>
                        <select name="period" class="form-input border-slate-200 dark:border-zink-500">
                            <?php $__currentLoopData = $monthOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php if($periodKey === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php else: ?>
                    <div class="qa-filter-field">
                        <label>Period</label>
                        <input type="text" class="form-input border-slate-200 dark:border-zink-500 bg-slate-50" value="<?php echo e($periodLabel); ?> (current month)" disabled>
                    </div>
                    <?php endif; ?>

                    <?php if($isManager && $agentsForFilter->count()): ?>
                    <div class="qa-filter-field">
                        <label>Agent</label>
                        <select name="agent_id" class="form-input border-slate-200 dark:border-zink-500">
                            <option value="">All agents (<?php echo e($agentsForFilter->count()); ?>)</option>
                            <?php $__currentLoopData = $agentsForFilter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($agent->id); ?>" <?php if((string) $filterAgentId === (string) $agent->id): echo 'selected'; endif; ?>>
                                    <?php echo e($agent->name); ?><?php echo e($agent->employee_id ? ' ('.$agent->employee_id.')' : ''); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <?php if($isManager): ?>
                    <div class="qa-filter-field">
                        <label>Score</label>
                        <select name="score" class="form-input border-slate-200 dark:border-zink-500">
                            <option value="" <?php if($filterScore === ''): echo 'selected'; endif; ?>>All scores</option>
                            <option value="under_100" <?php if($filterScore === 'under_100'): echo 'selected'; endif; ?>>Under 100%</option>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div class="qa-filter-actions">
                        <button type="submit" class="btn bg-custom-500 text-white border-custom-500 hover:bg-custom-600">Apply</button>
                        <?php if($filterAgentId || $filterScore || ($isAdmin && $periodKey !== now('America/Phoenix')->format('Y-m')) || ($isManager && !$isAdmin && $periodKey !== 'current')): ?>
                        <a href="<?php echo e(route('qa-compliance.index')); ?>" class="btn qa-btn-reset border">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-3xl font-bold text-slate-800 dark:text-zink-50 mb-1"><?php echo e($evalStats['total']); ?></h6>
                    <p class="text-sm text-slate-600 dark:text-zink-300">Evaluations (<?php echo e($periodLabel); ?>)</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-3xl font-bold text-green-600 mb-1"><?php echo e($evalStats['pass']); ?></h6>
                    <p class="text-sm text-slate-600 dark:text-zink-300">Pass</p>
                    <p class="text-xs text-slate-400 mt-1">Avg score: <?php echo e($evalStats['avg_score'] !== null ? $evalStats['avg_score'].'%' : '—'); ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-3xl font-bold text-orange-600 mb-1"><?php echo e($evalStats['mistakes']); ?></h6>
                    <p class="text-sm text-slate-600 dark:text-zink-300">Mistakes (applied)</p>
                    <p class="text-xs text-slate-400 mt-1">This mo <?php echo e($mistakesThisMonth); ?> · Last mo <?php echo e($mistakesLastMonth); ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-3xl font-bold text-red-700 mb-1"><?php echo e($fmtSales($evalStats['sales_penalty'])); ?></h6>
                    <p class="text-sm text-slate-600 dark:text-zink-300">Sales penalty (period)</p>
                    <p class="text-xs text-slate-400 mt-1">Lifetime: <?php echo e($fmtSales($lifetimeSales)); ?></p>
                </div>
            </div>
        </div>

        
        <div class="card mb-6">
            <div class="card-body">
                <h6 class="mb-4 text-15 font-semibold">
                    QMS Evaluations — <?php echo e($periodLabel); ?>

                    <?php if($filterScore === 'under_100'): ?>
                        <span class="text-orange-500 font-semibold">(Under 100% only)</span>
                    <?php endif; ?>
                </h6>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-slate-200 dark:divide-zink-500">
                        <thead class="bg-slate-50 dark:bg-zink-600">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Call date</th>
                                <?php if($isManager): ?>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Agent</th>
                                <?php endif; ?>
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
                            <?php $__empty_1 = true; $__currentLoopData = $evaluations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-zink-600">
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <?php echo e(optional($ev->call_date)->format('Y-m-d H:i') ?? '—'); ?>

                                </td>
                                <?php if($isManager): ?>
                                <td class="px-4 py-3 text-sm"><?php echo e($ev->user->name ?? $ev->agent_name ?? 'N/A'); ?></td>
                                <?php endif; ?>
                                <td class="px-4 py-3 text-sm font-mono"><?php echo e($showPhone($ev->phone_number)); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo e($ev->did ?: '—'); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo e($ev->final_score !== null ? $ev->final_score.'%' : '—'); ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <?php if($ev->is_critical_failure): ?>
                                        <span class="qa-result-badge is-critical">Critical Fail</span>
                                    <?php elseif($ev->is_pass): ?>
                                        <span class="qa-result-badge is-pass">Pass</span>
                                    <?php else: ?>
                                        <span class="qa-result-badge is-fail">Fail</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-sm"><?php echo e($ev->mistakes_count); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo e($fmtSales($ev->sales_deduction_total)); ?></td>
                                <td class="px-4 py-3 text-sm text-xs text-slate-500"><?php echo e($ev->evaluation_uid); ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <?php if($ev->final_score !== null && (float) $ev->final_score < 100): ?>
                                        <button
                                            type="button"
                                            class="btn qa-btn-view-comment border text-xs px-2 py-1 h-auto min-h-0"
                                            data-uid="<?php echo e($ev->evaluation_uid); ?>"
                                            data-score="<?php echo e($ev->final_score); ?>"
                                            data-comment="<?php echo e($ev->qa_comments ?? ''); ?>"
                                            onclick="openQaCommentModal(this)"
                                        >View Comment</button>
                                    <?php else: ?>
                                        <span class="text-slate-400">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e($isManager ? 10 : 9); ?>" class="px-4 py-8 text-center text-sm text-slate-500">
                                    No QMS evaluations found for <?php echo e($periodLabel); ?>.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="card mb-6">
            <div class="card-body">
                <h6 class="mb-4 text-15 font-semibold">Sales penalties — <?php echo e($periodLabel); ?></h6>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-slate-200 dark:divide-zink-500">
                        <thead class="bg-slate-50 dark:bg-zink-600">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Date</th>
                                <?php if($isManager): ?>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Agent</th>
                                <?php endif; ?>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Phone</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Decision</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Sales</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-zink-500">
                            <?php $__empty_1 = true; $__currentLoopData = $penaltiesInPeriod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-4 py-3 text-sm"><?php echo e(optional($row->occurred_at)->format('Y-m-d') ?? '—'); ?></td>
                                <?php if($isManager): ?>
                                <td class="px-4 py-3 text-sm"><?php echo e($row->user->name ?? 'N/A'); ?></td>
                                <?php endif; ?>
                                <td class="px-4 py-3 text-sm font-mono"><?php echo e($showPhone($row->phone_number)); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo e(strtoupper(str_replace('_', ' ', $row->violation_category))); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo e($row->penalty_decision === 'apply' ? 'Applied' : 'Approved by TL'); ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <?php if($row->penalty_outcome === 'termination'): ?> Termination
                                    <?php elseif($row->penalty_outcome === 'sale_rejected'): ?> Sale rejected
                                    <?php elseif($row->penalty_outcome === 'tl_responsible'): ?> 0 (TL)
                                    <?php else: ?> <?php echo e($fmtSales($row->sales_deduction)); ?>

                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e($isManager ? 6 : 5); ?>" class="px-4 py-6 text-center text-sm text-slate-500">
                                    No sales penalties in this period.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/hrm2/resources/views/qa_compliance/index.blade.php ENDPATH**/ ?>