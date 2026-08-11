<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            DesignationSeeder::class,
            LeaveTypeSeeder::class,
            UserSeeder::class,
            SalarySeeder::class,
            AttendanceSeeder::class,
            LeaveSeeder::class,
            EnhancedDataSeeder::class, // Add enhanced data
        ]);
    }
}
