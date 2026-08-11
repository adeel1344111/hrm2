<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Deleting all existing salaries...');
        
        // Delete all existing salary records
        DB::table('salaries')->delete();
        
        $this->command->info('Creating new salary records for all users...');
        
        // Get all active users (excluding admin)
        $users = DB::table('users')
            ->where('status', 'active')
            ->where('user_type', '!=', 'admin')
            ->get();
        
        // Salary tiers: [basic_salary => punctuality]
        $salaryTiers = [
            22000 => 3000,
            27000 => 3000,
            32000 => 3000,
            35000 => 5000,
            45000 => 5000,
            55000 => 5000,
            65000 => 5000,
            75000 => 5000,
        ];
        
        $salaryKeys = array_keys($salaryTiers);
        $salaryCount = count($salaryKeys);
        $index = 0;
        
        foreach ($users as $user) {
            // Cycle through salary tiers
            $basicSalary = $salaryKeys[$index % $salaryCount];
            $punctuality = $salaryTiers[$basicSalary];
            
            DB::table('salaries')->insert([
                'employee_id' => $user->id,
                'basic_salary' => $basicSalary,
                'punctuality' => $punctuality,
                'effective_date' => Carbon::now()->startOfMonth(),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->command->info("Created salary for {$user->name} ({$user->employee_id}): PKR {$basicSalary} + PKR {$punctuality}");
            
            $index++;
        }
        
        $this->command->info('Salary seeding completed successfully!');
        $this->command->info("Total salaries created: " . $users->count());
    }
}