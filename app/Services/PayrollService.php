<?php

namespace App\Services;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    // Constants for business rules
    private const NCNS_DEDUCTION = 2000;
    private const LATE_DEDUCTION = 500;
    private const LATE_THRESHOLD = 3;
    private const TRAINING_BONUS = 5000;

    /**
     * Calculate salaries for a given period and employee
     * @param int|null $employeeId Specific employee ID or null for all
     * @param bool $lastMonth Calculate for last month if true
     * @param int|null $teamLeadId Team lead ID for filtering agents
     * @return array Calculated salaries
     */
    public function calculateSalaries($employeeId = null, $lastMonth = false, $teamLeadId = null)
    {
        // Determine payroll period
        $period = $this->getPayrollPeriod($lastMonth);
        $workingDays = $this->calculateWorkingDays($period['startDate'], $period['endDate']);
        
        // Custom Rule for January 2026: Working days should be 22
        if ($period['monthYear'] === 'January 2026') {
            $workingDays = 22;
        }

        $firstWorkingDate = $this->getFirstWorkingDateOfMonth($period['startDate']);

        // Fetch employee and attendance data
        $employees = $this->fetchEmployeeData($employeeId, $period['startDate'], $period['endDate'], $teamLeadId);
        $calculatedSalaries = [];

        foreach ($employees as $employee) {
            // Fetch salary data
            $salaryData = $this->fetchSalaryData($employee['id'], $period['monthYear']);
            
            // Use salary data from the database
            $basicSalary = $salaryData['basic_salary'];
            $punctuality = $salaryData['punctuality'];

            // Check appointment and termination
            $hasAppointment = $this->checkAppointmentInPeriod($employee['id'], $period['startDate'], $period['endDate'], $firstWorkingDate);
            $isLeftPunctual = $this->checkLeftInPeriod($employee['id'], $period['startDate'], $period['endDate']);

            // Calculate final salary
            $salaryResult = $this->calculateFinalSalary(
                $employee,
                $basicSalary,
                $punctuality,
                $workingDays,
                $hasAppointment,
                $isLeftPunctual
            );

            $finalSalary = $salaryResult['amount'];
            $actualPunctuality = $salaryResult['actual_punctuality'];

            // Apply adjustments
            $finalSalary -= (float)($salaryData['dock'] ?? 0);
            $finalSalary += (float)($salaryData['bonus'] ?? 0);
            $finalSalary += (float)($salaryData['ref_bonus'] ?? 0);
            $finalSalary -= (float)($salaryData['advance'] ?? 0);

            // Apply late deduction
            $lateDeduction = 0;
            $lateCount = 0;
            if ($employee['user_type'] !== 'agent') {
                $lateCount = $this->getLateCount($employee['id'], $period['startDate'], $period['endDate']);
                if ($lateCount > self::LATE_THRESHOLD) {
                    $lateDeduction = ($lateCount - self::LATE_THRESHOLD) * self::LATE_DEDUCTION;
                    $finalSalary -= $lateDeduction;
                }
            }

            // Saturday bonus removed as per request

            // Apply training bonus
            $trainingBonus = 0;
            if ($this->hasCompletedThreeMonths($employee['appointment_date'], $period['startDate'], $period['endDate']) &&
                $employee['designation'] == 'CSR') {
                $trainingBonus = self::TRAINING_BONUS;
                $finalSalary += $trainingBonus;
            }
            
            // Apply Arrears for Dec 21-31 (Only for Jan 2026 payroll)
            $arrearsAmount = 0;
            if ($period['monthYear'] === 'January 2026') {
                $arrearsDays = (int)($employee['arrears_days'] ?? 0);
                if ($arrearsDays > 0) {
                    $arrearsDailyRate = $basicSalary / 22;
                    $arrearsAmount = $arrearsDailyRate * $arrearsDays;
                    $finalSalary += $arrearsAmount;
                }
            }

            // Round final salary
            $finalSalary = $this->applyRounding($finalSalary);

            // Ensure non-negative salary
            $finalSalary = max(0, $finalSalary);

            $calculatedSalaries[] = [
                'employee_id' => $employee['id'],
                'employee_code' => $employee['employee_id'],
                'name' => $employee['name'],
                'user_type' => $employee['user_type'],
                'department' => $employee['department'],
                'basic_salary' => (float)$basicSalary,
                'punctuality' => (float)$punctuality,
                'actual_punctuality' => (float)$actualPunctuality,
                'presents' => (int)($employee['presents'] ?? 0) + (int)($employee['holiday_count'] ?? 0),
                'absent_count' => (int)($employee['absent_count'] ?? 0),
                'unpaid_count' => (int)($employee['unpaid_count'] ?? 0),
                'ncns_count' => (int)($employee['ncns_count'] ?? 0),
                'half_days' => (int)($employee['half_days'] ?? 0),
                'holiday_count' => (int)($employee['holiday_count'] ?? 0),
                'final_salary' => $finalSalary,
                'total_working_days' => $workingDays,
                'bonus' => (float)($salaryData['bonus'] ?? 0),
                'late_deduction' => $lateDeduction,
                'late_count' => $lateCount,
                'dock' => (float)($salaryData['dock'] ?? 0),
                'ref_bonus' => (float)($salaryData['ref_bonus'] ?? 0),
                'training_bonus' => $trainingBonus,
                'arrears_amount' => $arrearsAmount,
                'period' => $period['monthYear']
            ];
        }

        return $calculatedSalaries;
    }

    /**
     * Fetch salary-related data (plan, dock, bonuses, advance)
     */
    private function fetchSalaryData($employeeId, $monthYear)
    {
        // Get the current active salary for the employee
        $salary = Salary::where('employee_id', $employeeId)
                       ->where('status', 'active')
                       ->latest('effective_date')
                       ->first();
        
        // Get payroll management data for the month
        $payrollManagement = DB::table('payroll_management')
                              ->where('employee_id', $employeeId)
                              ->where('month', $monthYear)
                              ->first();
        
        if ($salary) {
            $isTemp = !empty($salary->temp_salary);
            $effectiveBasic = $isTemp ? (float)$salary->temp_salary : (float)$salary->basic_salary;
            $effectivePunctuality = $isTemp ? 5000.0 : (float)$salary->punctuality;

            return [
                'punctuality' => $effectivePunctuality,
                'basic_salary' => $effectiveBasic,
                'plan' => $payrollManagement->plan ?? null,
                'dock' => $payrollManagement->dock_value ?? 0,
                'bonus' => $payrollManagement->bonus ?? 0,
                'ref_bonus' => $payrollManagement->ref_bonus ?? 0,
                'advance' => $payrollManagement->advance ?? 0
            ];
        }
        
        // Return default values if no salary found
        return [
            'punctuality' => 0,
            'basic_salary' => 0,
            'plan' => null,
            'dock' => 0,
            'bonus' => 0,
            'ref_bonus' => 0,
            'advance' => 0
        ];
    }

    /**
     * Determine payroll period based on current date and mode
     */
    private function getPayrollPeriod($lastMonth)
    {
        if ($lastMonth) {
            // Last month: 1st to last day of previous month
            $startDate = date('Y-m-01', strtotime('-1 month'));
            $endDate = date('Y-m-t', strtotime('-1 month'));
            $monthYear = date('F Y', strtotime('-1 month'));
        } else {
            // Current month: 1st to last day of current month
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t');
            $monthYear = date('F Y');
        }



        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'monthYear' => $monthYear
        ];
    }

    /**
     * Fetch employee and attendance data
     */
    private function fetchEmployeeData($employeeId, $startDate, $endDate, $teamLeadId = null)
    {
        $query = User::select([
            'users.id',
            'users.employee_id',
            'users.name',
            'users.user_type',
            'users.team_lead_id',
            'users.appointment_date',
            'users.department',
            'users.designation',
            'salaries.basic_salary',
            'salaries.punctuality',
            DB::raw('COUNT(DISTINCT CASE WHEN attendances.status = "P" AND attendances.attendance_date >= "' . $startDate . '" AND attendances.attendance_date <= "' . $endDate . '" THEN attendances.attendance_date END) as presents'),
            DB::raw('COUNT(DISTINCT CASE WHEN attendances.status = "A" AND attendances.attendance_date >= "' . $startDate . '" AND attendances.attendance_date <= "' . $endDate . '" THEN attendances.attendance_date END) as absent_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN attendances.status = "NCNS" AND attendances.attendance_date >= "' . $startDate . '" AND attendances.attendance_date <= "' . $endDate . '" THEN attendances.attendance_date END) as ncns_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN attendances.status = "H" AND attendances.attendance_date >= "' . $startDate . '" AND attendances.attendance_date <= "' . $endDate . '" THEN attendances.attendance_date END) as half_days'),
            DB::raw('COUNT(DISTINCT CASE WHEN attendances.status = "HOLIDAY" AND attendances.attendance_date >= "' . $startDate . '" AND attendances.attendance_date <= "' . $endDate . '" THEN attendances.attendance_date END) as holiday_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN attendances.status = "U" AND attendances.attendance_date >= "' . $startDate . '" AND attendances.attendance_date <= "' . $endDate . '" THEN attendances.attendance_date END) as unpaid_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN (attendances.status = "P" OR attendances.status = "H" OR attendances.status = "HOLIDAY") AND attendances.attendance_date >= "2025-12-21" AND attendances.attendance_date <= "2025-12-31" THEN attendances.attendance_date END) as arrears_days')
        ])
        ->leftJoin('salaries', function($join) {
            $join->on('salaries.employee_id', '=', 'users.id')
                 ->where('salaries.status', '=', 'active');
        })
        ->leftJoin('attendances', 'attendances.user_id', '=', 'users.id')
        ->where('users.user_type', '!=', 'admin')
        ->whereExists(function($query) use ($startDate, $endDate) {
            $query->select(DB::raw(1))
                  ->from('attendances as att')
                  ->whereColumn('att.user_id', 'users.id')
                  ->whereBetween('att.attendance_date', [$startDate, $endDate]);
        });

        if ($employeeId !== null) {
            $query->where('users.id', $employeeId);
        }

        if ($teamLeadId !== null) {
            $query->where('users.team_lead_id', $teamLeadId)
                  ->where('users.user_type', 'agent');
        }

        $query->groupBy('users.id', 'users.employee_id', 'users.name', 'users.user_type', 
                       'users.team_lead_id', 'users.appointment_date', 'users.department', 'users.designation', 
                       'salaries.basic_salary', 'salaries.punctuality');

        return $query->get()->toArray();
    }

    /**
     * Calculate final salary with adjustments
     */
    private function calculateFinalSalary($employee, $basicSalary, $punctuality, $workingDays, $hasAppointment, $isLeftPunctual)
    {
        $basicSalary = (float)$basicSalary;
        $punctuality = (float)$punctuality;
        $workingDays = (int)$workingDays;
        
        $dailySalary = $workingDays > 0 ? $basicSalary / $workingDays : 0;
        
        // Calculate base salary from attendance (Present + Half Day + Holiday)
        // HOLIDAY is explicitly counted as a payable present day
        $payableDays = (int)$employee['presents'] + (int)$employee['half_days'] + (int)$employee['holiday_count'];
        $attendanceSalary = $dailySalary * $payableDays;
        
        // Start with attendance salary + punctuality
        $finalSalary = $attendanceSalary + $punctuality;
        $punctualityDeducted = false;

        // NCNS deduction
        if ((int)$employee['ncns_count'] > 0) {
            if (!$punctualityDeducted) {
                $finalSalary -= $punctuality;
                $punctualityDeducted = true;
            }
            $finalSalary -= self::NCNS_DEDUCTION * (int)$employee['ncns_count'];
        }

        // Appointment or termination deduction
        if (($hasAppointment || $isLeftPunctual) && !$punctualityDeducted) {
            $finalSalary -= $punctuality;
            $punctualityDeducted = true;
        }

        // Half-day or absence deduction
        if (!$punctualityDeducted && ((int)$employee['half_days'] >= 3 || (int)$employee['absent_count'] >= 1) && $punctuality > 0) {
            $finalSalary -= $punctuality;
            $punctualityDeducted = true;
        }

        // Add back one day's salary for absences
        if ((int)$employee['absent_count'] >= 1 && !$hasAppointment && !$isLeftPunctual) {
            $finalSalary += $dailySalary;
        }

        if (
            isset($employee['designation']) && $employee['designation'] === 'Verification Officer' &&
            (int)$employee['half_days'] == 2 &&
            ((int)$employee['absent_count'] > 0 || (int)$employee['ncns_count'] > 0)
        ) {
            $finalSalary -= $dailySalary;
        }

        return [
            'amount' => $finalSalary,
            'actual_punctuality' => $punctualityDeducted ? 0 : $punctuality
        ];
    }

    /**
     * Round salary to nearest 500 or 1000
     */
    private function applyRounding($salary)
    {
        $salary = (int)$salary;
        $lastThreeDigits = $salary % 1000;
        $base = floor($salary / 1000) * 1000;

        if ($lastThreeDigits <= 249) {
            return $base;
        } elseif ($lastThreeDigits <= 499) {
            return $base + 500;
        } elseif ($lastThreeDigits <= 749) {
            return $base + 500;
        } else {
            return $base + 1000;
        }
    }

    /**
     * Calculate working days between two dates
     */
    private function calculateWorkingDays($startDate, $endDate)
    {
        $workingDays = 0;
        $currentDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        while ($currentDate <= $endDate) {
            if (date('N', $currentDate) < 6) {
                $workingDays++;
            }
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $workingDays;
    }

    /**
     * Get first working date of the month
     */
    private function getFirstWorkingDateOfMonth($startDate)
    {
        $date = strtotime($startDate);
        while (date('N', $date) > 5) {
            $date = strtotime('+1 day', $date);
        }
        return date('Y-m-d', $date);
    }

    /**
     * Check if employee was appointed in the period
     */
    private function checkAppointmentInPeriod($employeeId, $startDate, $endDate, $firstWorkingDate)
    {
        return User::where('id', $employeeId)
                   ->where('appointment_date', '>', $startDate)
                   ->where('appointment_date', '<=', $endDate)
                   ->where('appointment_date', '!=', $firstWorkingDate)
                   ->exists();
    }

    /**
     * Check if employee left in the period
     */
    private function checkLeftInPeriod($employeeId, $startDate, $endDate)
    {
        return User::where('id', $employeeId)
                   ->whereNotNull('left_date')
                   ->where('left_date', '>=', $startDate)
                   ->where('left_date', '<=', $endDate)
                   ->exists();
    }



    /**
     * Count late arrivals
     */
    private function getLateCount($employeeId, $startDate, $endDate)
    {
        // For now, return 0 since we don't have time tracking
        // You can implement this based on your attendance system
        return 0;
    }

    /**
     * Check if employee has completed three months
     */
    private function hasCompletedThreeMonths($appointmentDate, $periodStartDate, $periodEndDate)
    {
        if (empty($appointmentDate)) {
            return false;
        }

        $appointmentDate = Carbon::parse($appointmentDate);

        // Check if the appointment date is a Monday
        if ($appointmentDate->format('l') == 'Monday') {
            // Adjust to the previous Saturday
            $appointmentDate->modify('last Saturday');
        }

        // Calculate the date when 3 months are completed
        $threeMonthDate = $appointmentDate->copy()->addMonths(3);

        $periodStart = Carbon::parse($periodStartDate);
        $periodEnd = Carbon::parse($periodEndDate);

        // Check if the 3-month completion date falls within the payroll period
        return $threeMonthDate->between($periodStart, $periodEnd);
    }
}
