<?php

namespace App\Http\Controllers;

use App\Models\QaEvaluation;
use App\Models\QaSalesPenalty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class QaComplianceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$this->canAccessQaCompliance($user)) {
            abort(403, 'You do not have access to QA Compliance.');
        }

        $isAdmin = $user->isAdmin();
        $isManager = $this->isManagerView($user);
        $maskPhone = $user->isAgent(); // agents never see full numbers

        $scopeAgents = $this->scopedAgents($user);
        $scopedUserIds = $scopeAgents->pluck('id')->values();

        // Agent filter (managers + admin)
        $filterAgentId = null;
        if ($isManager && $request->filled('agent_id')) {
            $candidate = (int) $request->input('agent_id');
            if ($scopedUserIds->contains($candidate)) {
                $filterAgentId = $candidate;
                $scopedUserIds = collect([$candidate]);
            }
        }

        // Score filter — TL / FM / Admin: only leads scoring under 100%
        $filterScore = '';
        if ($isManager) {
            $scoreRaw = (string) $request->input('score', '');
            if (in_array($scoreRaw, ['under_100'], true)) {
                $filterScore = $scoreRaw;
            }
        }

        $viewerIds = $scopedUserIds->isEmpty() ? collect([-1]) : $scopedUserIds;

        // Month period
        // - Agent: always current month
        // - TL / FM: current | last
        // - Admin: any YYYY-MM (month picker)
        $period = $this->resolvePeriod($request, $user);
        [$rangeStart, $rangeEnd, $periodKey, $periodLabel, $monthOptions] = $period;

        $evaluations = collect();
        $evalStats = [
            'total' => 0,
            'pass' => 0,
            'fail' => 0,
            'critical' => 0,
            'avg_score' => null,
            'mistakes' => 0,
            'sales_penalty' => 0,
        ];

        if (Schema::hasTable('qa_evaluations')) {
            $evalQuery = QaEvaluation::with('user')
                ->whereIn('user_id', $viewerIds)
                ->where(function ($q) use ($rangeStart, $rangeEnd) {
                    $q->whereBetween('call_date', [$rangeStart, $rangeEnd])
                        ->orWhere(function ($q2) use ($rangeStart, $rangeEnd) {
                            $q2->whereNull('call_date')
                                ->whereBetween('submitted_at', [$rangeStart, $rangeEnd]);
                        });
                });

            if ($filterScore === 'under_100') {
                $evalQuery->whereNotNull('final_score')->where('final_score', '<', 100);
            }

            $evaluations = $evalQuery
                ->orderByDesc('call_date')
                ->orderByDesc('id')
                ->limit(500)
                ->get();

            $evalStats['total'] = $evaluations->count();
            $evalStats['pass'] = $evaluations->where('is_pass', true)->count();
            $evalStats['fail'] = $evaluations->where('is_pass', false)->count();
            $evalStats['critical'] = $evaluations->where('is_critical_failure', true)->count();
            $evalStats['mistakes'] = (int) $evaluations->sum('mistakes_count');
            $evalStats['sales_penalty'] = (float) $evaluations->sum('sales_deduction_total');
            if ($evaluations->count()) {
                $evalStats['avg_score'] = round((float) $evaluations->avg('final_score'), 1);
            }
        }

        // Lifetime sales (all time, scoped) — always shown
        $lifetimeSales = 0.0;
        $mistakesThisMonth = 0;
        $mistakesLastMonth = 0;
        if (Schema::hasTable('qa_sales_penalties')) {
            $tz = 'America/Phoenix';
            $now = Carbon::now($tz);
            $thisStart = $now->copy()->startOfMonth();
            $lastStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
            $lastEnd = $thisStart->copy()->subSecond();

            $base = QaSalesPenalty::query()->whereIn('user_id', $viewerIds);

            $lifetimeSales = (float) (clone $base)
                ->where('penalty_decision', 'apply')
                ->where(function ($q) {
                    $q->where('penalty_outcome', 'sales')->orWhereNull('penalty_outcome');
                })
                ->sum('sales_deduction');

            $mistakesThisMonth = (clone $base)
                ->where('penalty_decision', 'apply')
                ->whereBetween('occurred_at', [$thisStart, $now])
                ->count();

            $mistakesLastMonth = (clone $base)
                ->where('penalty_decision', 'apply')
                ->whereBetween('occurred_at', [$lastStart, $lastEnd])
                ->count();
        }

        $penaltiesInPeriod = collect();
        if (Schema::hasTable('qa_sales_penalties')) {
            $penaltiesInPeriod = QaSalesPenalty::with('user')
                ->whereIn('user_id', $viewerIds)
                ->whereBetween('occurred_at', [$rangeStart, $rangeEnd])
                ->orderByDesc('occurred_at')
                ->limit(100)
                ->get();
        }

        $roleLabel = match (true) {
            $isAdmin => 'All agents',
            $user->isFloorManager() => 'Your floor agents',
            $user->isTeamLead() => 'Your team agents',
            default => 'Your QA evaluations',
        };

        $agentsForFilter = $isManager ? $scopeAgents : collect();

        $response = response()->view('qa_compliance.index', compact(
            'evaluations',
            'evalStats',
            'penaltiesInPeriod',
            'lifetimeSales',
            'mistakesThisMonth',
            'mistakesLastMonth',
            'roleLabel',
            'isManager',
            'isAdmin',
            'maskPhone',
            'agentsForFilter',
            'filterAgentId',
            'filterScore',
            'periodKey',
            'periodLabel',
            'monthOptions',
            'rangeStart',
            'rangeEnd',
            'user'
        ));

        // Prevent stale browser/proxy cache of this dashboard
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');

        return $response;
    }

    /**
     * @return array{0: Carbon, 1: Carbon, 2: string, 3: string, 4: array}
     */
    private function resolvePeriod(Request $request, User $user): array
    {
        $tz = 'America/Phoenix';
        $now = Carbon::now($tz);

        $monthOptions = [];
        if ($user->isAdmin()) {
            // Last 18 months selectable
            for ($i = 0; $i < 18; $i++) {
                $m = $now->copy()->subMonthsNoOverflow($i)->startOfMonth();
                $key = $m->format('Y-m');
                $monthOptions[$key] = $m->format('F Y');
            }
        } else {
            $monthOptions = [
                'current' => $now->format('F Y') . ' (Current)',
                'last' => $now->copy()->subMonthNoOverflow()->format('F Y') . ' (Last month)',
            ];
        }

        if ($user->isAgent()) {
            $start = $now->copy()->startOfMonth();
            $end = $now->copy()->endOfMonth();

            return [$start, $end, 'current', $start->format('F Y'), $monthOptions];
        }

        if ($user->isAdmin()) {
            $month = $request->input('month', $now->format('Y-m'));
            if (!preg_match('/^\d{4}-\d{2}$/', $month) || !isset($monthOptions[$month])) {
                $month = $now->format('Y-m');
            }
            $start = Carbon::createFromFormat('Y-m-d', $month . '-01', $tz)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            return [$start, $end, $month, $start->format('F Y'), $monthOptions];
        }

        // TL / Floor Manager
        $key = $request->input('period', 'current');
        if (!in_array($key, ['current', 'last'], true)) {
            $key = 'current';
        }
        if ($key === 'last') {
            $start = $now->copy()->subMonthNoOverflow()->startOfMonth();
            $end = $start->copy()->endOfMonth();
        } else {
            $start = $now->copy()->startOfMonth();
            $end = $now->copy()->endOfMonth();
        }

        return [$start, $end, $key, $start->format('F Y'), $monthOptions];
    }

    private function canAccessQaCompliance(User $user): bool
    {
        return $user->isAdmin()
            || $user->isFloorManager()
            || $user->isTeamLead()
            || $user->isAgent();
    }

    private function isManagerView(User $user): bool
    {
        return $user->isAdmin() || $user->isFloorManager() || $user->isTeamLead();
    }

    private function scopedAgents(User $user)
    {
        if ($user->isAdmin()) {
            return User::where('user_type', 'agent')->orderBy('name')->get();
        }

        if ($user->isFloorManager()) {
            return User::where('user_type', 'agent')
                ->where('floor_manager_id', $user->id)
                ->where('status', 'active')
                ->orderBy('name')
                ->get();
        }

        if ($user->isTeamLead()) {
            return User::where('user_type', 'agent')
                ->where('team_lead_id', $user->id)
                ->where('status', 'active')
                ->orderBy('name')
                ->get();
        }

        return collect([$user]);
    }
}
