<?php

use Illuminate\Support\Facades\Route;

// Helper functions set_active() and set_show() are defined in app/helpers.php

// Redirect root to login
Route::get('/', function () {
    return view('auth.login');
});

// Authentication routes
Route::group(['namespace' => 'App\Http\Controllers\Auth'],function()
{
    // Login routes
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::post('/attendance/cleanup', [App\Http\Controllers\AttendanceController::class, 'cleanupInvalidRecords'])->name('attendance.cleanup');
        Route::get('/attendance/invalid-records', [App\Http\Controllers\AttendanceController::class, 'getInvalidRecords'])->name('attendance.invalid-records');
        Route::delete('/attendance/{id}', [App\Http\Controllers\AttendanceController::class, 'destroy'])->name('attendance.destroy');

        Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    });
});

// Protected routes (require authentication)
Route::group(['middleware'=>'auth'],function()
{
    // Dashboard
    Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

    // Goal Settings routes (Admin only)
    Route::get('/Goal-Setting', [App\Http\Controllers\SettingsController::class, 'index'])->name('goal-settings.index');
    Route::put('/Goal-Setting', [App\Http\Controllers\SettingsController::class, 'update'])->name('goal-settings.update');
    Route::post('/Goal-Setting/reset', [App\Http\Controllers\SettingsController::class, 'reset'])->name('goal-settings.reset');

    // Department routes
    Route::resource('departments', App\Http\Controllers\DepartmentController::class);
    
    // Designation routes
    Route::resource('designations', App\Http\Controllers\DesignationController::class);
    
    // Employee routes
    Route::get('/employees/active', [App\Http\Controllers\EmployeeController::class, 'active'])->name('employees.active');
    Route::get('/employees/inactive', [App\Http\Controllers\EmployeeController::class, 'inactive'])->name('employees.inactive');
    Route::get('/employees/all', [App\Http\Controllers\EmployeeController::class, 'all'])->name('employees.all');
    Route::get('/api/next-employee-id', [App\Http\Controllers\EmployeeController::class, 'getNextEmployeeId'])->name('employees.next-id');
    Route::patch('/employees/{employee}/status', [App\Http\Controllers\EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');
    Route::resource('employees', App\Http\Controllers\EmployeeController::class);
    
    // Attendance routes
    Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/report', [App\Http\Controllers\AttendanceController::class, 'report'])->name('attendance.report');
    Route::post('/attendance/mark', [App\Http\Controllers\AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::post('/attendance/bulk-mark', [App\Http\Controllers\AttendanceController::class, 'bulkMarkAttendance'])->name('attendance.bulk-mark');
    Route::post('/attendance/bulk-delete', [App\Http\Controllers\AttendanceController::class, 'bulkDelete'])->name('attendance.bulk-delete');
    
    // Leave routes
    Route::resource('leaves', App\Http\Controllers\LeaveController::class);
    Route::post('/leaves/{leave}/approve', [App\Http\Controllers\LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('/leaves/{leave}/reject', [App\Http\Controllers\LeaveController::class, 'reject'])->name('leaves.reject');
    
    // Leave Type routes
    Route::resource('leave-types', App\Http\Controllers\LeaveTypeController::class);
    
    // Submission routes
    Route::get('/submissions/report', [App\Http\Controllers\SubmissionController::class, 'report'])->name('submissions.report');
    Route::get('/submissions/monthly-report', [App\Http\Controllers\SubmissionController::class, 'monthlyReport'])->name('submissions.monthly-report');
    Route::resource('submissions', App\Http\Controllers\SubmissionController::class);
    
    // Approval routes
    Route::get('/approval', [App\Http\Controllers\ApprovalController::class, 'index'])->name('approval.index');
    Route::post('/approval/process', [App\Http\Controllers\ApprovalController::class, 'process'])->name('approval.process');
    Route::post('/approval/stats', [App\Http\Controllers\ApprovalController::class, 'stats'])->name('approval.stats');
    
    // Performance routes
    Route::get('/performance/team-report', [App\Http\Controllers\PerformanceController::class, 'teamReport'])->name('performance.team-report');
    Route::get('/performance/report', [App\Http\Controllers\PerformanceController::class, 'report'])->name('performance.report');
    
    // Profile routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update-picture', [App\Http\Controllers\ProfileController::class, 'updateProfilePicture'])->name('profile.update-picture');
    Route::post('/profile/remove-picture', [App\Http\Controllers\ProfileController::class, 'removeProfilePicture'])->name('profile.remove-picture');
    
    // Campaign routes
    Route::resource('campaigns', App\Http\Controllers\CampaignController::class);
    
    // Payroll routes
    // Payroll routes
    Route::get('/payroll', [App\Http\Controllers\PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payroll/management', [App\Http\Controllers\PayrollController::class, 'management'])->name('payroll.management');
    Route::post('/payroll/management', [App\Http\Controllers\PayrollController::class, 'storeManagement'])->name('payroll.management.store');
    Route::get('/payroll/management/bulk', [App\Http\Controllers\PayrollController::class, 'bulkManagement'])->name('payroll.management.bulk');
    Route::post('/payroll/management/bulk', [App\Http\Controllers\PayrollController::class, 'storeBulkManagement'])->name('payroll.management.bulk-store');
    Route::get('/payroll/management/{id}/edit', [App\Http\Controllers\PayrollController::class, 'editManagement'])->name('payroll.management.edit');
    Route::put('/payroll/management/{id}', [App\Http\Controllers\PayrollController::class, 'updateManagement'])->name('payroll.management.update');
    Route::delete('/payroll/management/{id}', [App\Http\Controllers\PayrollController::class, 'destroyManagement'])->name('payroll.management.destroy');
    Route::get('/payroll/{employeeId}', [App\Http\Controllers\PayrollController::class, 'show'])->name('payroll.show');
    Route::get('/payroll/export/csv', [App\Http\Controllers\PayrollController::class, 'export'])->name('payroll.export');
    Route::post('/payroll/custom-export', [App\Http\Controllers\PayrollController::class, 'customExport'])->name('payroll.custom-export');

    Route::get('/debug-bonus', function() {
        echo "<h1>Debug Bonus</h1>";
        $users = \App\Models\User::where('user_type', 'agent')->limit(10)->get();
        foreach($users as $u) {
            echo "ID: {$u->id} | Name: {$u->name} | Designation: <strong>[{$u->designation}]</strong> | Appt: {$u->appointment_date}<br>";
             // Logic Check
            $appt = \Carbon\Carbon::parse($u->appointment_date);
            $end = \Carbon\Carbon::now(); // or month end
            $diff = $appt->diff($end);
            echo "Diff: {$diff->y}y {$diff->m}m. Logic (m==3 && y==0): " . (($diff->y == 0 && $diff->m == 3) ? 'TRUE' : 'FALSE') . "<br><hr>";
        }
    });
    
    // Notification routes
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    
    // User Settings routes
    Route::get('/settings', [App\Http\Controllers\UserSettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/password', [App\Http\Controllers\UserSettingsController::class, 'updatePassword'])->name('settings.update-password');
    Route::put('/settings/profile', [App\Http\Controllers\UserSettingsController::class, 'updateProfile'])->name('settings.update-profile');
    
    // Team routes
    Route::get('/teams', [App\Http\Controllers\TeamController::class, 'index'])->name('teams.index');

    // Salary Info routes
    Route::get('/salary-info', [App\Http\Controllers\SalaryInfoController::class, 'index'])->name('salary-info.index');
    Route::post('/salary-info/bulk-temp-salary', [App\Http\Controllers\SalaryInfoController::class, 'bulkTempSalary'])->name('salary-info.bulk-temp-salary');
    Route::put('/salary-info/{id}', [App\Http\Controllers\SalaryInfoController::class, 'update'])->name('salary-info.update');

    // Employee Contracts routes
    Route::get('/employee-contracts', [App\Http\Controllers\EmployeeContractController::class, 'index'])->name('employee-contracts.index');
    Route::put('/employee-contracts/{id}', [App\Http\Controllers\EmployeeContractController::class, 'update'])->name('employee-contracts.update');

    // Active Agents Info (Others) — inline edit without refresh
    Route::get('/agent-info', [App\Http\Controllers\AgentInfoController::class, 'index'])->name('agent-info.index');
    Route::put('/agent-info/{id}', [App\Http\Controllers\AgentInfoController::class, 'update'])->name('agent-info.update');

    // QA Compliance routes
    Route::get('/qa-compliance', [App\Http\Controllers\QaComplianceController::class, 'index'])->name('qa-compliance.index');
});

// Outsource partner portal (separate from employee auth)
Route::prefix('outsource')->name('outsource.')->group(function () {
    Route::get('/', [App\Http\Controllers\OutsourceController::class, 'form'])->name('form');
    Route::post('/submit', [App\Http\Controllers\OutsourceController::class, 'submit'])->name('submit');
    Route::get('/login', [App\Http\Controllers\OutsourceController::class, 'loginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\OutsourceController::class, 'login'])->name('login.submit');
    Route::post('/logout', [App\Http\Controllers\OutsourceController::class, 'logout'])->name('logout');

    Route::middleware('outsource.auth')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\OutsourceController::class, 'dashboard'])->name('dashboard');
        Route::get('/submissions', [App\Http\Controllers\OutsourceController::class, 'submissions'])->name('submissions');
        Route::get('/report', [App\Http\Controllers\OutsourceController::class, 'report'])->name('report');
        Route::post('/report/data', [App\Http\Controllers\OutsourceController::class, 'reportData'])->name('report.data');
    });
});

// Auth routes are handled manually above
