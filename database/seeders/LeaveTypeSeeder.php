<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            [
                'name' => 'Sick',
                'description' => 'Medical leave for illness or health issues',
                'max_days' => 30,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Vacation',
                'description' => 'Annual vacation leave for rest and recreation',
                'max_days' => 15,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Personal',
                'description' => 'Personal leave for personal matters',
                'max_days' => 5,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Emergency',
                'description' => 'Emergency leave for urgent situations',
                'max_days' => 3,
                'requires_approval' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Maternity',
                'description' => 'Maternity leave for new mothers',
                'max_days' => 90,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Paternity',
                'description' => 'Paternity leave for new fathers',
                'max_days' => 15,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Bereavement',
                'description' => 'Leave for death of family member',
                'max_days' => 7,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Study',
                'description' => 'Leave for educational purposes',
                'max_days' => 10,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Compensatory',
                'description' => 'Compensatory leave for overtime work',
                'max_days' => null,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Sabbatical',
                'description' => 'Extended leave for research or personal development',
                'max_days' => 365,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Other',
                'description' => 'Other types of leave not covered above',
                'max_days' => null,
                'requires_approval' => true,
                'is_active' => true,
                'sort_order' => 11,
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::updateOrCreate(
                ['name' => $leaveType['name']],
                $leaveType
            );
        }
    }
}
