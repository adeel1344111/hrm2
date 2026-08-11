<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\OutsourceFrontorSubmission;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApprovalController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Access denied. Only administrators can access this page.');
            }
            return $next($request);
        });
    }

    /**
     * Display the approval page
     */
    public function index()
    {
        $campaigns = $this->getCampaigns();

        return view('approval.index', compact('campaigns'));
    }

    /**
     * Process the approval request
     */
    public function process(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'campaign' => 'required|string',
            'designation' => 'required|string|in:Verification Officer,CSR,Outsource',
            'phone_numbers' => 'required|string',
        ]);

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $campaign = $request->campaign;
        $designation = $request->designation;
        $phoneNumbersText = $request->phone_numbers;

        // Parse phone numbers from textarea (one per line)
        $phoneNumbers = array_filter(array_map('trim', explode("\n", $phoneNumbersText)));
        $phoneNumbers = array_unique($phoneNumbers); // Remove duplicates from input

        $submissions = $this->querySubmissions($designation, $campaign, $fromDate, $toDate)
            ->whereIn('phone', $phoneNumbers)
            ->orderBy('created_at', 'desc')
            ->get();

        // Group submissions by phone number
        $submissionsByPhone = $submissions->groupBy('phone');

        // Find duplicate numbers (numbers with more than one submission)
        $duplicateNumbers = $submissionsByPhone->filter(function ($submissions) {
            return $submissions->count() > 1;
        });

        // Find unique found numbers (numbers with exactly one submission)
        $uniqueFoundNumbers = $submissionsByPhone->filter(function ($submissions) {
            return $submissions->count() === 1;
        });

        // All found keys (for unmatched calculation)
        $allFoundKeys = $submissionsByPhone->keys()->toArray();

        // Find unmatched numbers (numbers that don't have any submissions)
        $unmatchedNumbers = array_diff($phoneNumbers, $allFoundKeys);

        // Prepare results data
        $results = [
            'found_submissions' => $uniqueFoundNumbers,
            'duplicate_numbers' => $duplicateNumbers,
            'unmatched_numbers' => $unmatchedNumbers,
            'total_found' => $uniqueFoundNumbers->count(),
            'total_duplicates' => $duplicateNumbers->count(),
            'total_unmatched' => count($unmatchedNumbers),
            'total_input' => count($phoneNumbers),
        ];

        $campaigns = $this->getCampaigns();

        return view('approval.index', compact(
            'campaigns',
            'results',
            'fromDate',
            'toDate',
            'campaign',
            'designation',
            'phoneNumbersText'
        ));
    }

    /**
     * Show submission stats + all forms for selected date range / campaign / designation.
     */
    public function stats(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'campaign' => 'required|string',
            'designation' => 'required|string|in:Verification Officer,CSR,Outsource',
        ]);

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $campaign = $request->campaign;
        $designation = $request->designation;
        $phoneNumbersText = $request->phone_numbers;

        $submissions = $this->querySubmissions($designation, $campaign, $fromDate, $toDate)
            ->orderBy('created_at', 'desc')
            ->limit(2000)
            ->get();

        $byPhone = $submissions->groupBy('phone');
        $duplicatePhones = $byPhone->filter(fn ($rows) => $rows->count() > 1)->count();

        $byAgent = $submissions->groupBy(function ($row) use ($designation) {
            if ($designation === 'Outsource') {
                return trim(($row->dialer_id ?? '') . '|' . ($row->name ?? 'Unknown'));
            }
            return trim(($row->employee_id ?? '') . '|' . ($row->employee_name ?? 'Unknown'));
        })->map->count()->sortDesc();

        $stats = [
            'total_forms' => $submissions->count(),
            'unique_phones' => $byPhone->count(),
            'duplicate_phones' => $duplicatePhones,
            'unique_agents' => $byAgent->count(),
            'by_agent' => $byAgent->take(20),
            'submissions' => $submissions,
            'truncated' => $submissions->count() >= 2000,
        ];

        $campaigns = $this->getCampaigns();
        $showStats = true;

        return view('approval.index', compact(
            'campaigns',
            'stats',
            'showStats',
            'fromDate',
            'toDate',
            'campaign',
            'designation',
            'phoneNumbersText'
        ));
    }

    /**
     * Base query for submissions by designation / campaign / date range.
     */
    private function querySubmissions(string $designation, string $campaign, string $fromDate, string $toDate)
    {
        $dateRange = [
            Carbon::parse($fromDate)->startOfDay(),
            Carbon::parse($toDate)->endOfDay(),
        ];

        if ($designation === 'Outsource') {
            return OutsourceFrontorSubmission::query()
                ->whereRaw('LOWER(campaign) = ?', [strtolower($campaign)])
                ->whereBetween('created_at', $dateRange);
        }

        $tableName = $designation === 'CSR' ? 'csr_submissions' : 'verification_submissions';

        return (new Submission)->setTable($tableName)
            ->where('campaign', $campaign)
            ->whereBetween('created_at', $dateRange)
            ->with('submittedBy');
    }

    /**
     * Get available campaigns from database
     */
    private function getCampaigns()
    {
        return Campaign::where('status', 'active')
                      ->orderBy('name')
                      ->pluck('name')
                      ->toArray();
    }
}
