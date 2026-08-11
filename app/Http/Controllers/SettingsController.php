<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display settings page
     */
    public function index()
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $settings = [
            'daily_goal' => Setting::getDailyGoal(),
            'weekly_goal' => Setting::getWeeklyGoal(),
            'monthly_goal' => Setting::getMonthlyGoal(),
        ];

        return view('goal-settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $validator = Validator::make($request->all(), [
            'daily_goal' => 'required|integer|min:1|max:50',
            'weekly_goal' => 'required|integer|min:1|max:200',
            'monthly_goal' => 'required|integer|min:1|max:1000',
        ], [
            'daily_goal.required' => 'Daily goal is required',
            'daily_goal.integer' => 'Daily goal must be a number',
            'daily_goal.min' => 'Daily goal must be at least 1',
            'daily_goal.max' => 'Daily goal cannot exceed 50',
            'weekly_goal.required' => 'Weekly goal is required',
            'weekly_goal.integer' => 'Weekly goal must be a number',
            'weekly_goal.min' => 'Weekly goal must be at least 1',
            'weekly_goal.max' => 'Weekly goal cannot exceed 200',
            'monthly_goal.required' => 'Monthly goal is required',
            'monthly_goal.integer' => 'Monthly goal must be a number',
            'monthly_goal.min' => 'Monthly goal must be at least 1',
            'monthly_goal.max' => 'Monthly goal cannot exceed 1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update settings
            Setting::setDailyGoal($request->daily_goal);
            Setting::setWeeklyGoal($request->weekly_goal);
            Setting::setMonthlyGoal($request->monthly_goal);

            // Clear cache
            Setting::clearCache();

            return redirect()->route('goal-settings.index')
                ->with('success', 'Settings updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update settings. Please try again.')
                ->withInput();
        }
    }

    /**
     * Reset settings to default
     */
    public function reset()
    {
        // Only allow admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        try {
            Setting::setDailyGoal(3);
            Setting::setWeeklyGoal(20);
            Setting::setMonthlyGoal(80);

            // Clear cache
            Setting::clearCache();

            return redirect()->route('goal-settings.index')
                ->with('success', 'Settings reset to default values successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to reset settings. Please try again.');
        }
    }
}