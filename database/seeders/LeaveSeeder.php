<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('user_type', '!=', 'admin')->get();
        $leaveTypes = ['Sick', 'Vacation', 'Personal', 'Emergency', 'Maternity', 'Paternity', 'Bereavement', 'Study', 'Compensatory', 'Sabbatical', 'Other'];
        $statuses = ['Pending', 'Approved', 'Rejected', 'Cancelled'];
        $approvedBy = User::where('user_type', 'admin')->first()?->id ?? 1;

        // Generate leave requests for the last 90 days
        for ($i = 0; $i < 100; $i++) {
            $user = $users->random();
            $leaveType = $leaveTypes[array_rand($leaveTypes)];
            $status = $statuses[array_rand($statuses)];
            
            // Generate random start date within last 90 days
            $startDate = Carbon::now()->subDays(rand(1, 90));
            
            // Generate end date (1-7 days after start date)
            $endDate = $startDate->copy()->addDays(rand(1, 7));
            
            // Calculate total days
            $totalDays = $startDate->diffInDays($endDate) + 1;
            
            $reasons = [
                'Sick' => ['Fever and cold', 'Medical appointment', 'Recovery from surgery', 'Health checkup'],
                'Vacation' => ['Family vacation', 'Personal time off', 'Holiday trip', 'Rest and relaxation'],
                'Personal' => ['Personal matters', 'Family emergency', 'Personal work', 'Important appointment'],
                'Emergency' => ['Family emergency', 'Urgent personal matter', 'Emergency situation', 'Critical issue'],
                'Maternity' => ['Maternity leave', 'Baby care', 'Post-delivery recovery', 'Newborn care'],
                'Paternity' => ['Paternity leave', 'Newborn care', 'Family support', 'Baby bonding time'],
                'Bereavement' => ['Family member death', 'Funeral arrangements', 'Grieving period', 'Family support'],
                'Study' => ['Exam preparation', 'Course attendance', 'Training program', 'Educational purpose'],
                'Compensatory' => ['Overtime compensation', 'Extra work compensation', 'Compensatory time off'],
                'Sabbatical' => ['Research project', 'Personal development', 'Extended break', 'Career development'],
                'Other' => ['Other personal reason', 'Special circumstances', 'Miscellaneous reason'],
            ];
            
            $reason = $reasons[$leaveType][array_rand($reasons[$leaveType])];
            
            $adminRemarks = null;
            $approvedAt = null;
            
            if ($status === 'Approved') {
                $adminRemarks = 'Leave approved as per company policy';
                $approvedAt = $startDate->copy()->subDays(rand(1, 5));
            } elseif ($status === 'Rejected') {
                $adminRemarks = 'Leave rejected due to work requirements';
            }

            Leave::create([
                'user_id' => $user->id,
                'leave_type' => $leaveType,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'total_days' => $totalDays,
                'reason' => $reason,
                'status' => $status,
                'admin_remarks' => $adminRemarks,
                'approved_by' => $status === 'Approved' ? $approvedBy : null,
                'approved_at' => $approvedAt,
            ]);
        }

        // Generate some current and future leave requests
        for ($i = 0; $i < 30; $i++) {
            $user = $users->random();
            $leaveType = $leaveTypes[array_rand($leaveTypes)];
            $status = ['Pending', 'Approved'][array_rand(['Pending', 'Approved'])];
            
            // Generate future dates
            $startDate = Carbon::now()->addDays(rand(1, 30));
            $endDate = $startDate->copy()->addDays(rand(1, 5));
            $totalDays = $startDate->diffInDays($endDate) + 1;
            
            $reasons = [
                'Sick' => ['Medical appointment', 'Health checkup', 'Recovery time'],
                'Vacation' => ['Family vacation', 'Personal time off', 'Holiday trip'],
                'Personal' => ['Personal matters', 'Family event', 'Important appointment'],
                'Emergency' => ['Family emergency', 'Urgent personal matter'],
                'Maternity' => ['Maternity leave', 'Baby care'],
                'Paternity' => ['Paternity leave', 'Newborn care'],
                'Bereavement' => ['Family member death', 'Funeral arrangements'],
                'Study' => ['Exam preparation', 'Course attendance'],
                'Compensatory' => ['Overtime compensation'],
                'Sabbatical' => ['Research project', 'Personal development'],
                'Other' => ['Other personal reason'],
            ];
            
            $reason = $reasons[$leaveType][array_rand($reasons[$leaveType])];
            
            $adminRemarks = null;
            $approvedAt = null;
            
            if ($status === 'Approved') {
                $adminRemarks = 'Leave approved';
                $approvedAt = Carbon::now()->subDays(rand(1, 3));
            }

            Leave::create([
                'user_id' => $user->id,
                'leave_type' => $leaveType,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'total_days' => $totalDays,
                'reason' => $reason,
                'status' => $status,
                'admin_remarks' => $adminRemarks,
                'approved_by' => $status === 'Approved' ? $approvedBy : null,
                'approved_at' => $approvedAt,
            ]);
        }
    }
}