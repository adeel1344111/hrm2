<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PerformanceController extends Controller
{
    public function report()
    {
        try {
            $user = Auth::user();
            
            // Get current time and determine the shift period
            $currentTime = now();
            $shiftData = $this->getShiftPeriod($currentTime);
            
            // Get agents based on user type
            $agents = $this->getFilteredAgents($user);
            
            // Get performance data for the shift period
            $performanceData = $this->getPerformanceData($user, $shiftData, $agents);
            
            // Generate hours for the view (6am to 5pm)
            $hours = [];
            for ($i = 6; $i <= 17; $i++) {
                $hours[] = sprintf('%02d:00', $i);
            }
            
            return view('performance.report', compact('performanceData', 'agents', 'shiftData', 'hours'));
        } catch (\Exception $e) {
            \Log::error('Performance report error: ' . $e->getMessage());
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }
    
    private function getShiftPeriod($currentTime)
    {
        $currentHour = $currentTime->hour;
        
        if ($currentHour >= 6 && $currentHour < 18) {
            // Currently in day shift: 6am to 6pm
            // Show today's day shift (6am to 6pm)
            $startDate = $currentTime->format('Y-m-d');
            $endDate = $currentTime->format('Y-m-d');
        } else {
            // Currently outside day shift (6pm to 6am)
            // Show the most recent completed day shift
            if ($currentHour >= 18) {
                // Between 6pm to 11:59pm - show today's day shift
                $startDate = $currentTime->format('Y-m-d');
                $endDate = $currentTime->format('Y-m-d');
            } else {
                // Between 12am to 5:59am - show yesterday's day shift
                $startDate = $currentTime->copy()->subDay()->format('Y-m-d');
                $endDate = $currentTime->copy()->subDay()->format('Y-m-d');
            }
        }
        
        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'start_time' => '06:00:00', // 6am
            'end_time' => '18:00:00',   // 6pm
            'period_label' => $this->getPeriodLabel($startDate, $endDate)
        ];
    }
    
    private function getPeriodLabel($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        if ($start->isSameDay($end)) {
            return $start->format('M d, Y') . ' Day Shift';
        } else {
            return $start->format('M d') . ' - ' . $end->format('M d, Y') . ' Day Shift';
        }
    }
    
    private function getFilteredAgents($user)
    {
        if ($user->isAdmin()) {
            // Admin sees all agents (both CSR and verification officers)
            return User::where('user_type', 'agent')
                      ->where('status', 'active')
                      ->orderBy('name')
                      ->get();
        } elseif ($user->isFloorManager()) {
            return User::where('user_type', 'agent')
                      ->where('floor_manager_id', $user->id)
                      ->where('status', 'active')
                      ->orderBy('name')
                      ->get();
        } elseif ($user->isTeamLead()) {
            return User::where('user_type', 'agent')
                      ->where('team_lead_id', $user->id)
                      ->where('status', 'active')
                      ->orderBy('name')
                      ->get();
        } else {
            // Special case for Verification Officers: show ALL verification officers
            if ($user->isVerificationOfficer()) {
                return User::where('user_type', 'agent')
                      ->where('designation', 'Verification Officer')
                      ->where('status', 'active')
                      ->orderBy('name')
                      ->get();
            }

            // For regular agents (CSR), show their entire team's data if they have a team lead
            if ($user->team_lead_id) {
                return User::where('user_type', 'agent')
                    ->where('team_lead_id', $user->team_lead_id)
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->get();
            }
            // Fallback for agents without a team lead
            return collect([$user]);
        }
    }
    
    private function getPerformanceData($user, $shiftData, $agents)
    {
        $campaignPerformance = [];
        
        // Generate hourly slots from 6am to 6pm (06:00 to 18:00)
        $hours = [];
        for ($i = 6; $i <= 17; $i++) {
            $hours[] = sprintf('%02d:00', $i);
        }
        
        foreach ($agents as $agent) {
            // Get submissions for this agent within the shift period
            // Check both CSR and Verification tables
            $csrSubmissions = (new Submission)->setTable('csr_submissions')
                ->where('submitted_by', $agent->id)
                ->whereBetween('created_at', [
                    $shiftData['start_date'] . ' 06:00:00',
                    $shiftData['end_date'] . ' 18:00:00'
                ])
                ->get();
            
            $verificationSubmissions = (new Submission)->setTable('verification_submissions')
                ->where('submitted_by', $agent->id)
                ->whereBetween('created_at', [
                    $shiftData['start_date'] . ' 06:00:00',
                    $shiftData['end_date'] . ' 18:00:00'
                ])
                ->get();
            
            // Merge both collections
            $submissions = $csrSubmissions->merge($verificationSubmissions);
            
            // If agent has no submissions, add them to "No Activity" group
            if ($submissions->isEmpty()) {
                $hourlySubmissions = [];
                foreach ($hours as $hour) {
                    $hourlySubmissions[$hour] = 0;
                }
                
                $campaignPerformance['No Submission Available'][] = [
                    'agent' => $agent,
                    'hourly_submissions' => $hourlySubmissions,
                    'total_submissions' => 0,
                    'sales_count' => 0
                ];
                continue;
            }
            
            // Group submissions by campaign
            $submissionsByCampaign = $submissions->groupBy('campaign');
            
            foreach ($submissionsByCampaign as $campaign => $campaignSubmissions) {
                $campaignName = $campaign ?: 'Unknown Campaign';
                
                $agentData = [
                    'agent' => $agent,
                    'hourly_submissions' => []
                ];
                
                // Initialize hours
                foreach ($hours as $hour) {
                    $agentData['hourly_submissions'][$hour] = 0;
                }
                
                // Count submissions by hour for this campaign
                foreach ($campaignSubmissions as $submission) {
                    $submissionHour = $submission->created_at->format('H:00');
                    if (isset($agentData['hourly_submissions'][$submissionHour])) {
                        $agentData['hourly_submissions'][$submissionHour]++;
                    }
                }
                
                // Calculate Sales Count for this campaign
                $phones = $campaignSubmissions->pluck('phone')->filter()->unique()->values();
                $salesCount = 0;
                
                if ($phones->isNotEmpty()) {
                    $salesCount = \Illuminate\Support\Facades\DB::table('verification_submissions')
                        ->whereIn('phone', $phones)
                        ->whereBetween('created_at', [
                            $shiftData['start_date'] . ' 06:00:00',
                            $shiftData['end_date'] . ' 18:00:00'
                        ])
                        ->count();
                }

                $qaPenalty = $this->qaSalesDeduction(
                    (int) $agent->id,
                    $shiftData['start_date'] . ' 00:00:00',
                    $shiftData['end_date'] . ' 23:59:59'
                );
                
                $agentData['total_submissions'] = $campaignSubmissions->count();
                $agentData['gross_sales_count'] = $salesCount;
                $agentData['qa_sales_penalty'] = $qaPenalty;
                $agentData['sales_count'] = max(0, (int) round($salesCount - $qaPenalty));
                
                $campaignPerformance[$campaignName][] = $agentData;
            }
        }

        // Sort agents by sales_count descending within each campaign
        foreach ($campaignPerformance as $campaign => &$data) {
            usort($data, function ($a, $b) {
                return $b['sales_count'] <=> $a['sales_count'];
            });
        }
        unset($data); // Break reference
        
        // Ensure "No Submission Available" comes last if it exists
        if (isset($campaignPerformance['No Submission Available'])) {
            $noSubmission = $campaignPerformance['No Submission Available'];
            unset($campaignPerformance['No Submission Available']);
            $campaignPerformance['No Submission Available'] = $noSubmission;
        }
        
        return $campaignPerformance;
    }

    public function teamReport()
    {
        try {
            $user = Auth::user();
            
            // Get current time and shift period
            $currentTime = now();
            $shiftData = $this->getShiftPeriod($currentTime);
            
            // Get Team Leads based on user role
            $teamLeads = $this->getFilteredTeamLeads($user);
            
            // Calculate performance data for each Team Lead
            $teamPerformanceData = [];
            
            foreach ($teamLeads as $tl) {
                // Get all active agents under this Team Lead
                $agentIds = User::where('team_lead_id', $tl->id)
                    ->where('user_type', 'agent')
                    ->where('status', 'active')
                    ->pluck('id');
                
                // Get all CSR submissions by these agents in the shift
                $submissions = Submission::query()->from('csr_submissions')
                    ->whereIn('submitted_by', $agentIds)
                    ->whereBetween('created_at', [
                        $shiftData['start_date'] . ' 06:00:00',
                        $shiftData['end_date'] . ' 18:00:00'
                    ])
                    ->get();
                    
                $totalSubmissions = $submissions->count();
                
                // Calculate Sales (Verified Phones)
                $phones = $submissions->pluck('phone')->filter()->unique()->values();
                $salesCount = 0;
                
                if ($phones->isNotEmpty()) {
                    $salesCount = \Illuminate\Support\Facades\DB::table('verification_submissions')
                        ->whereIn('phone', $phones)
                        ->whereBetween('created_at', [
                            $shiftData['start_date'] . ' 00:00:00',
                            $shiftData['end_date'] . ' 23:59:59'
                        ])
                        ->count();
                }

                $qaPenalty = 0;
                foreach ($agentIds as $aid) {
                    $qaPenalty += $this->qaSalesDeduction(
                        (int) $aid,
                        $shiftData['start_date'] . ' 00:00:00',
                        $shiftData['end_date'] . ' 23:59:59'
                    );
                }
                
                $teamPerformanceData[] = [
                    'team_lead' => $tl,
                    'total_submissions' => $totalSubmissions,
                    'gross_sales_count' => $salesCount,
                    'qa_sales_penalty' => $qaPenalty,
                    'sales_count' => max(0, (int) round($salesCount - $qaPenalty)),
                ];
            }

            // Sort by sales_count descending
            usort($teamPerformanceData, function ($a, $b) {
                return $b['sales_count'] <=> $a['sales_count'];
            });
            
            return view('performance.team_report', compact('teamPerformanceData', 'shiftData'));
        } catch (\Exception $e) {
            \Log::error('Team Performance Report Error: ' . $e->getMessage());
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    private function getFilteredTeamLeads($user)
    {
        if ($user->isAdmin() || $user->isFloorManager() || $user->isTeamLead()) {
            return User::teamLeadRole()
                ->where('status', 'active')
                ->orderBy('name')
                ->get();
        }
        return collect([]);
    }

    /**
     * Sum applied QA sales deductions for an agent in a datetime window (Phoenix wall times stored as DATETIME).
     */
    private function qaSalesDeduction(int $userId, string $start, string $end): float
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('qa_sales_penalties')) {
            return 0;
        }

        return (float) \Illuminate\Support\Facades\DB::table('qa_sales_penalties')
            ->where('user_id', $userId)
            ->where('penalty_decision', 'apply')
            ->where(function ($q) {
                $q->where('penalty_outcome', 'sales')->orWhereNull('penalty_outcome');
            })
            ->whereBetween('occurred_at', [$start, $end])
            ->sum('sales_deduction');
    }
}