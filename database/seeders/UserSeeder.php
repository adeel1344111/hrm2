<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // Admin Users
            [
                'name' => 'System Administrator',
                'email' => 'admin@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'admin',
                'employee_id' => 'ADM001',
                'contact_number' => '+92-300-1234567',
                'emergency_contact' => '+92-300-7654321',
                'cnic' => '12345-1234567-1',
                'appointment_date' => '2020-01-15',
                'left_date' => null,
                'referred_by' => 'HR Department',
                'phone' => '+1234567890',
                'department' => 'Administration',
                'join_date' => '2024-01-01',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            
            // Floor Managers
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'floor_manager',
                'employee_id' => 'FM001',
                'contact_number' => '+92-300-2345678',
                'emergency_contact' => '+92-300-8765432',
                'cnic' => '23456-2345678-2',
                'appointment_date' => '2020-03-01',
                'left_date' => null,
                'referred_by' => 'System Administrator',
                'phone' => '+1234567891',
                'department' => 'Information Technology',
                'join_date' => '2024-01-15',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'floor_manager',
                'employee_id' => 'FM002',
                'phone' => '+1234567892',
                'department' => 'Customer Support',
                'join_date' => '2024-02-01',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily.rodriguez@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'floor_manager',
                'employee_id' => 'FM003',
                'phone' => '+1234567893',
                'department' => 'Sales',
                'join_date' => '2024-02-15',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            
            // Team Leads
            [
                'name' => 'David Kim',
                'email' => 'david.kim@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'team_lead',
                'employee_id' => 'TL001',
                'phone' => '+1234567894',
                'department' => 'Information Technology',
                'join_date' => '2024-03-01',
                'status' => 'active',
                'floor_manager_id' => 2, // Sarah Johnson
                'team_lead_id' => null,
            ],
            [
                'name' => 'Lisa Wang',
                'email' => 'lisa.wang@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'team_lead',
                'employee_id' => 'TL002',
                'phone' => '+1234567895',
                'department' => 'Information Technology',
                'join_date' => '2024-03-15',
                'status' => 'active',
                'floor_manager_id' => 2, // Sarah Johnson
                'team_lead_id' => null,
            ],
            [
                'name' => 'James Wilson',
                'email' => 'james.wilson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'team_lead',
                'employee_id' => 'TL003',
                'phone' => '+1234567896',
                'department' => 'Customer Support',
                'join_date' => '2024-04-01',
                'status' => 'active',
                'floor_manager_id' => 3, // Michael Chen
                'team_lead_id' => null,
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'team_lead',
                'employee_id' => 'TL004',
                'phone' => '+1234567897',
                'department' => 'Customer Support',
                'join_date' => '2024-04-15',
                'status' => 'active',
                'floor_manager_id' => 3, // Michael Chen
                'team_lead_id' => null,
            ],
            [
                'name' => 'Robert Taylor',
                'email' => 'robert.taylor@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'team_lead',
                'employee_id' => 'TL005',
                'phone' => '+1234567898',
                'department' => 'Sales',
                'join_date' => '2024-05-01',
                'status' => 'active',
                'floor_manager_id' => 4, // Emily Rodriguez
                'team_lead_id' => null,
            ],
            
            // Agents
            [
                'name' => 'John Smith',
                'email' => 'john.smith@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG001',
                'phone' => '+1234567899',
                'department' => 'Information Technology',
                'join_date' => '2024-05-15',
                'status' => 'active',
                'floor_manager_id' => 2, // Sarah Johnson
                'team_lead_id' => 5, // David Kim
            ],
            [
                'name' => 'Jennifer Brown',
                'email' => 'jennifer.brown@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG002',
                'phone' => '+1234567900',
                'department' => 'Information Technology',
                'join_date' => '2024-06-01',
                'status' => 'active',
                'floor_manager_id' => 2, // Sarah Johnson
                'team_lead_id' => 5, // David Kim
            ],
            [
                'name' => 'Christopher Davis',
                'email' => 'christopher.davis@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG003',
                'phone' => '+1234567901',
                'department' => 'Information Technology',
                'join_date' => '2024-06-15',
                'status' => 'active',
                'floor_manager_id' => 2, // Sarah Johnson
                'team_lead_id' => 6, // Lisa Wang
            ],
            [
                'name' => 'Amanda Miller',
                'email' => 'amanda.miller@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG004',
                'phone' => '+1234567902',
                'department' => 'Information Technology',
                'join_date' => '2024-07-01',
                'status' => 'active',
                'floor_manager_id' => 2, // Sarah Johnson
                'team_lead_id' => 6, // Lisa Wang
            ],
            [
                'name' => 'Daniel Anderson',
                'email' => 'daniel.anderson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG005',
                'phone' => '+1234567903',
                'department' => 'Customer Support',
                'join_date' => '2024-07-15',
                'status' => 'active',
                'floor_manager_id' => 3, // Michael Chen
                'team_lead_id' => 7, // James Wilson
            ],
            [
                'name' => 'Jessica Thompson',
                'email' => 'jessica.thompson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG006',
                'phone' => '+1234567904',
                'department' => 'Customer Support',
                'join_date' => '2024-08-01',
                'status' => 'active',
                'floor_manager_id' => 3, // Michael Chen
                'team_lead_id' => 7, // James Wilson
            ],
            [
                'name' => 'Matthew White',
                'email' => 'matthew.white@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG007',
                'phone' => '+1234567905',
                'department' => 'Customer Support',
                'join_date' => '2024-08-15',
                'status' => 'active',
                'floor_manager_id' => 3, // Michael Chen
                'team_lead_id' => 8, // Maria Garcia
            ],
            [
                'name' => 'Ashley Harris',
                'email' => 'ashley.harris@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG008',
                'phone' => '+1234567906',
                'department' => 'Customer Support',
                'join_date' => '2024-09-01',
                'status' => 'active',
                'floor_manager_id' => 3, // Michael Chen
                'team_lead_id' => 8, // Maria Garcia
            ],
            [
                'name' => 'Kevin Martinez',
                'email' => 'kevin.martinez@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG009',
                'phone' => '+1234567907',
                'department' => 'Sales',
                'join_date' => '2024-09-15',
                'status' => 'active',
                'floor_manager_id' => 4, // Emily Rodriguez
                'team_lead_id' => 9, // Robert Taylor
            ],
            [
                'name' => 'Nicole Clark',
                'email' => 'nicole.clark@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG010',
                'phone' => '+1234567908',
                'department' => 'Sales',
                'join_date' => '2024-10-01',
                'status' => 'active',
                'floor_manager_id' => 4, // Emily Rodriguez
                'team_lead_id' => 9, // Robert Taylor
            ],
            [
                'name' => 'Ryan Lewis',
                'email' => 'ryan.lewis@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG011',
                'phone' => '+1234567909',
                'department' => 'Sales',
                'join_date' => '2024-10-15',
                'status' => 'active',
                'floor_manager_id' => 4, // Emily Rodriguez
                'team_lead_id' => 9, // Robert Taylor
            ],
            [
                'name' => 'Samantha Lee',
                'email' => 'samantha.lee@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG012',
                'phone' => '+1234567910',
                'department' => 'Human Resources',
                'join_date' => '2024-11-01',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            [
                'name' => 'Tyler Walker',
                'email' => 'tyler.walker@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG013',
                'phone' => '+1234567911',
                'department' => 'Finance & Accounting',
                'join_date' => '2024-11-15',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            [
                'name' => 'Rachel Hall',
                'email' => 'rachel.hall@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG014',
                'phone' => '+1234567912',
                'department' => 'Marketing',
                'join_date' => '2024-12-01',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            [
                'name' => 'Brandon Young',
                'email' => 'brandon.young@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG015',
                'phone' => '+1234567913',
                'department' => 'Operations',
                'join_date' => '2024-12-15',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}