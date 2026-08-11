<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AgentPayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the agent with employee_id AG001
        $agent = DB::table('users')->where('employee_id', 'AG001')->first();
        
        if (!$agent) {
            $this->command->error('Agent AG001 not found!');
            return;
        }

        $this->command->info('Creating dummy attendance and payroll data for AG001...');

        // Use simple calendar month (1st to last day of month)
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $today = Carbon::now();

        // Create attendance records for the payroll period
        $attendanceData = [];
        $currentDate = $startOfMonth->copy();
        
        while ($currentDate <= $endOfMonth && $currentDate <= $today) {
            // Skip Sundays
            if ($currentDate->dayOfWeek != 0) {
                $status = 'P'; // Present
                $checkIn = $currentDate->copy()->setTime(9, 0, 0)->format('H:i:s');
                $checkOut = $currentDate->copy()->setTime(18, 0, 0)->format('H:i:s');
                
                // Add some variety
                $rand = rand(1, 10);
                if ($rand == 1) {
                    $status = 'A'; // Absent
                    $checkIn = null;
                    $checkOut = null;
                } elseif ($rand == 2) {
                    $status = 'H'; // Half-day
                    $checkOut = $currentDate->copy()->setTime(13, 0, 0)->format('H:i:s');
                } elseif ($rand == 3) {
                    // Late arrival
                    $checkIn = $currentDate->copy()->setTime(9, 30, 0)->format('H:i:s');
                }
                
                // Check if attendance already exists for this date
                $exists = DB::table('attendances')
                    ->where('user_id', $agent->id)
                    ->where('attendance_date', $currentDate->format('Y-m-d'))
                    ->exists();
                
                if (!$exists) {
                    $attendanceData[] = [
                        'user_id' => $agent->id,
                        'attendance_date' => $currentDate->format('Y-m-d'),
                        'status' => $status,
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                        'marked_by' => $agent->id, // Self-marked
                        'remarks' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            
            $currentDate->addDay();
        }

        if (count($attendanceData) > 0) {
            DB::table('attendances')->insert($attendanceData);
            $this->command->info('Created ' . count($attendanceData) . ' attendance records');
        } else {
            $this->command->info('Attendance records already exist for this month');
        }

        // Create payroll management entry with bonuses and deductions
        DB::table('payroll_management')->updateOrInsert(
            [
                'employee_id' => $agent->id,
                'month' => $today->format('Y-m'),
            ],
            [
                'dock_value' => 500,
                'bonus' => 2000,
                'ref_bonus' => 1000,
                'plan' => 0,
                'advance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Created payroll management entry with bonuses and deductions');
        $this->command->info('Dummy data created successfully for AG001!');
    }
}
