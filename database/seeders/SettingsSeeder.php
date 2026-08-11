<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default goal settings
        Setting::setDailyGoal(3);
        Setting::setWeeklyGoal(20);
        Setting::setMonthlyGoal(80);
        
        $this->command->info('Default goal settings created successfully!');
    }
}