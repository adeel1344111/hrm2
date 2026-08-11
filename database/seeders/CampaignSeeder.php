<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campaign;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = [
            [
                'name' => 'Summer Sale 2024',
                'description' => 'Annual summer promotion campaign with special discounts and offers',
                'status' => 'active',
                'created_by' => 'Admin',
            ],
            [
                'name' => 'Black Friday 2024',
                'description' => 'Black Friday mega sale campaign with massive discounts',
                'status' => 'completed',
                'created_by' => 'Admin',
            ],
            [
                'name' => 'Holiday Season 2024',
                'description' => 'Christmas and New Year holiday campaign',
                'status' => 'active',
                'created_by' => 'Admin',
            ],
            [
                'name' => 'Back to School 2024',
                'description' => 'Educational supplies and school essentials campaign',
                'status' => 'inactive',
                'created_by' => 'Admin',
            ],
            [
                'name' => 'Tech Innovation 2024',
                'description' => 'Latest technology products and gadgets campaign',
                'status' => 'active',
                'created_by' => 'Admin',
            ],
        ];

        foreach ($campaigns as $campaign) {
            Campaign::create($campaign);
        }
    }
}
