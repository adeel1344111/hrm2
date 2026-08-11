<?php

namespace App\Http\Controllers;

use App\Models\OutsourceCompany;
use App\Models\OutsourceFrontorSubmission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OutsourceController extends Controller
{
    /** Public form gate: /outsource?company=&pass= */
    public function form(Request $request)
    {
        $company = trim((string) $request->query('company', ''));
        $pass = trim((string) $request->query('pass', ''));

        if ($company === '' || $pass === '') {
            return redirect()->route('outsource.login');
        }

        $row = OutsourceCompany::findByFormCredentials($company, $pass);
        if (!$row) {
            abort(404, 'Invalid company name or password');
        }

        return view('outsource.form', [
            'company' => $row->company_name,
            'companyDisplay' => strtoupper($row->company_name),
        ]);
    }

    /** POST submit from public form */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'required|string|max:255',
            'dialer_id' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'campaign' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:10',
            'age' => 'nullable|integer|min:1|max:120',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response('Failed to Update: ' . $validator->errors()->first(), 422);
        }

        $phone = preg_replace('/\D+/', '', (string) $request->input('phone'));
        if (strlen($phone) !== 10) {
            return response('Failed to Update: Invalid phone number. Ensure it is exactly 10 digits.', 422);
        }

        $zip = preg_replace('/\D+/', '', (string) $request->input('zip', ''));
        if ($zip !== '' && strlen($zip) !== 5) {
            return response('Failed to Update: Invalid ZIP code. Ensure it is exactly 5 digits.', 422);
        }

        $company = strtoupper(trim((string) $request->input('company')));
        $dialerId = preg_replace('/\D+/', '', (string) $request->input('dialer_id'));
        if ($dialerId === '') {
            return response('Failed to Update: Dialer ID is required.', 422);
        }

        $tz = config('app.timezone', 'America/Phoenix');
        $now = Carbon::now($tz);

        $data = [
            'dialer_id' => $dialerId,
            'name' => trim((string) $request->input('name')),
            'campaign' => trim((string) $request->input('campaign')),
            'phone' => $phone,
            'state' => trim((string) $request->input('state')) ?: null,
            'zip' => $zip !== '' ? $zip : null,
            'age' => $request->filled('age') ? (int) $request->input('age') : null,
            'comment' => trim((string) $request->input('comment')) ?: null,
            'company' => $company,
            'created_at' => $now->format('Y-m-d H:i:s'),
        ];

        $existing = OutsourceFrontorSubmission::query()
            ->where('dialer_id', $dialerId)
            ->where('phone', $phone)
            ->where('company', $company)
            ->orderByDesc('id')
            ->first();

        if ($existing && $existing->created_at) {
            $last = Carbon::parse($existing->created_at, $tz);
            if ($last->diffInHours($now, false) < 10 && $last->lte($now)) {
                $existing->fill(collect($data)->except('created_at')->all());
                $existing->save();
                return response('Successfully Updated the Existing Record');
            }
        }

        OutsourceFrontorSubmission::create($data);
        return response('Successfully Added');
    }

    public function loginForm()
    {
        // Always show the login page (do not redirect away — page looked "missing")
        return view('outsource.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $company = OutsourceCompany::findByPortalLogin(
            trim($request->input('email')),
            $request->input('password')
        );

        if (!$company) {
            return back()->withInput($request->only('email'))
                ->with('error', 'Invalid email or password');
        }

        $request->session()->put([
            'outsource_login_access' => '1',
            'outsource_company_id' => $company->id,
            'outsource_company_name' => $company->company_name,
            'outsource_admin_name' => $company->admin_name,
            'outsource_company_email' => $company->company_email,
        ]);

        return redirect()->route('outsource.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'outsource_login_access',
            'outsource_company_id',
            'outsource_company_name',
            'outsource_admin_name',
            'outsource_company_email',
        ]);

        return redirect()->route('outsource.login')->with('feedback', 'logged_out');
    }

    /** Partner dashboard: today's submissions + sales (verifier phone match). */
    public function dashboard()
    {
        $company = session('outsource_company_name');
        [$start, $end, $periodLabel] = $this->todayWindow();

        $submissions = $this->companySubmissionsInWindow($company, $start, $end);
        $this->attachSaleFlags($submissions, $start, $end);

        $totalSubmissions = $submissions->count();
        $totalSales = $submissions->where('is_sale', true)->count();

        return view('outsource.dashboard', [
            'company' => $company,
            'periodLabel' => $periodLabel,
            'totalSubmissions' => $totalSubmissions,
            'totalSales' => $totalSales,
            'conversion' => $totalSubmissions > 0
                ? round(($totalSales / $totalSubmissions) * 100, 1)
                : 0,
        ]);
    }

    /** Today submissions (America/Phoenix calendar day — same as HRM2). */
    public function submissions()
    {
        $company = session('outsource_company_name');
        [$start, $end, $periodLabel] = $this->todayWindow();

        $submissions = $this->companySubmissionsInWindow($company, $start, $end);
        $this->attachSaleFlags($submissions, $start, $end);

        return view('outsource.submissions', [
            'submissions' => $submissions,
            'company' => $company,
            'periodLabel' => $periodLabel,
            'totalSales' => $submissions->where('is_sale', true)->count(),
        ]);
    }

    public function report(Request $request)
    {
        $company = session('outsource_company_name');
        $tz = config('app.timezone', 'America/Phoenix');
        $startDate = $request->input('start_date', Carbon::now($tz)->subDays(7)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now($tz)->format('Y-m-d'));

        $start = Carbon::parse($startDate, $tz)->startOfDay();
        $end = Carbon::parse($endDate, $tz)->endOfDay();
        $submissions = $this->submissionsForRange($company, $startDate, $endDate);
        $this->attachSaleFlags($submissions, $start, $end);

        return view('outsource.report', [
            'submissions' => $submissions,
            'company' => $company,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'totalSales' => $submissions->where('is_sale', true)->count(),
        ]);
    }

    public function reportData(Request $request)
    {
        $company = session('outsource_company_name');
        $tz = config('app.timezone', 'America/Phoenix');
        $startDate = $request->input('start_date', Carbon::now($tz)->subDays(7)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now($tz)->format('Y-m-d'));

        $start = Carbon::parse($startDate, $tz)->startOfDay();
        $end = Carbon::parse($endDate, $tz)->endOfDay();
        $rows = $this->submissionsForRange($company, $startDate, $endDate);
        $this->attachSaleFlags($rows, $start, $end);

        $payload = $rows->map(function ($r) {
            return [
                'dialer_id' => $r->dialer_id,
                'name' => $r->name,
                'campaign' => $r->campaign,
                'phone' => $r->phone,
                'state' => $r->state,
                'zip' => $r->zip,
                'age' => $r->age,
                'comment' => $r->comment,
                'is_sale' => (bool) ($r->is_sale ?? false),
                'created_at' => optional($r->created_at)->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json($payload);
    }

    /**
     * Calendar day in HRM2 app timezone (America/Phoenix) — same as internal submissions.
     *
     * @return array{0: Carbon, 1: Carbon, 2: string}
     */
    private function todayWindow(): array
    {
        $tz = config('app.timezone', 'America/Phoenix');
        $start = Carbon::now($tz)->startOfDay();
        $end = Carbon::now($tz)->endOfDay();
        $label = $start->format('M j, Y') . ' (America/Phoenix)';

        return [$start, $end, $label];
    }

    private function companySubmissionsInWindow(string $company, Carbon $start, Carbon $end)
    {
        return OutsourceFrontorSubmission::query()
            ->where('company', $company)
            ->whereBetween('created_at', [$start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s')])
            ->orderByDesc('created_at')
            ->get()
            ->unique(fn ($row) => $row->phone . '|' . $row->dialer_id)
            ->values();
    }

    private function submissionsForRange(string $company, string $startDate, string $endDate)
    {
        $tz = config('app.timezone', 'America/Phoenix');
        $start = Carbon::parse($startDate, $tz)->startOfDay();
        $end = Carbon::parse($endDate, $tz)->endOfDay();

        return OutsourceFrontorSubmission::query()
            ->where('company', $company)
            ->whereBetween('created_at', [$start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s')])
            ->orderByDesc('created_at')
            ->limit(5000)
            ->get();
    }

    /**
     * Same rule as CSR submissions: Sale when a verification officer submitted the same phone
     * in the same window.
     */
    private function attachSaleFlags($submissions, Carbon $windowStart, Carbon $windowEnd): void
    {
        if ($submissions->isEmpty()) {
            return;
        }

        $phones = $submissions
            ->pluck('phone')
            ->map(fn ($p) => preg_replace('/\D+/', '', (string) $p))
            ->filter(fn ($p) => strlen($p) >= 10)
            ->unique()
            ->values();

        if ($phones->isEmpty()) {
            $submissions->each(fn ($row) => $row->is_sale = false);
            return;
        }

        // Small buffer for legacy rows stored under older timezones
        $verified = DB::table('verification_submissions')
            ->whereBetween('created_at', [
                $windowStart->copy()->subHours(6)->format('Y-m-d H:i:s'),
                $windowEnd->copy()->addHours(6)->format('Y-m-d H:i:s'),
            ])
            ->whereIn('phone', $phones->all())
            ->pluck('phone')
            ->map(fn ($p) => preg_replace('/\D+/', '', (string) $p))
            ->flip();

        foreach ($submissions as $row) {
            $digits = preg_replace('/\D+/', '', (string) $row->phone);
            $row->is_sale = $verified->has($digits);
        }
    }
}
