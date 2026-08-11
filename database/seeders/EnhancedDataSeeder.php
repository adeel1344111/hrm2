<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Submission;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Salary;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EnhancedDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding enhanced fake data...');

        // Create additional users
        $this->createAdditionalUsers();
        
        // Create submissions data
        $this->createSubmissions();
        
        // Create attendance data
        $this->createAttendance();
        
        // Create leave data
        $this->createLeaves();
        
        // Create salary data
        $this->createSalaries();

        $this->command->info('Enhanced fake data seeding completed!');
    }

    private function createAdditionalUsers()
    {
        $this->command->info('Creating additional users...');
        
        $additionalUsers = [
            // More Floor Managers
            [
                'name' => 'Alex Thompson',
                'email' => 'alex.thompson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'floor_manager',
                'employee_id' => 'FM004',
                'contact_number' => '+92-300-3456789',
                'emergency_contact' => '+92-300-9876543',
                'cnic' => '34567-3456789-3',
                'appointment_date' => '2020-06-01',
                'phone' => '+1234567914',
                'department' => 'Marketing',
                'join_date' => '2024-01-20',
                'status' => 'active',
            ],
            [
                'name' => 'Sophie Anderson',
                'email' => 'sophie.anderson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'floor_manager',
                'employee_id' => 'FM005',
                'contact_number' => '+92-300-4567890',
                'emergency_contact' => '+92-300-0987654',
                'cnic' => '45678-4567890-4',
                'appointment_date' => '2020-08-15',
                'phone' => '+1234567915',
                'department' => 'Operations',
                'join_date' => '2024-02-10',
                'status' => 'active',
            ],

            // More Team Leads
            [
                'name' => 'Carlos Mendez',
                'email' => 'carlos.mendez@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'team_lead',
                'employee_id' => 'TL006',
                'phone' => '+1234567916',
                'department' => 'Marketing',
                'join_date' => '2024-03-20',
                'status' => 'active',
                'floor_manager_id' => 5, // Alex Thompson
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'priya.patel@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'team_lead',
                'employee_id' => 'TL007',
                'phone' => '+1234567917',
                'department' => 'Operations',
                'join_date' => '2024-04-05',
                'status' => 'active',
                'floor_manager_id' => 6, // Sophie Anderson
            ],
            [
                'name' => 'Ahmed Hassan',
                'email' => 'ahmed.hassan@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'team_lead',
                'employee_id' => 'TL008',
                'phone' => '+1234567918',
                'department' => 'Finance',
                'join_date' => '2024-05-10',
                'status' => 'active',
                'floor_manager_id' => null,
            ],

            // More Agents
            [
                'name' => 'Emma Wilson',
                'email' => 'emma.wilson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG016',
                'phone' => '+1234567919',
                'department' => 'Marketing',
                'join_date' => '2024-06-20',
                'status' => 'active',
                'floor_manager_id' => 5,
                'team_lead_id' => 10, // Carlos Mendez
            ],
            [
                'name' => 'Marcus Johnson',
                'email' => 'marcus.johnson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG017',
                'phone' => '+1234567920',
                'department' => 'Marketing',
                'join_date' => '2024-07-05',
                'status' => 'active',
                'floor_manager_id' => 5,
                'team_lead_id' => 10, // Carlos Mendez
            ],
            [
                'name' => 'Isabella Rodriguez',
                'email' => 'isabella.rodriguez@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG018',
                'phone' => '+1234567921',
                'department' => 'Operations',
                'join_date' => '2024-08-10',
                'status' => 'active',
                'floor_manager_id' => 6,
                'team_lead_id' => 11, // Priya Patel
            ],
            [
                'name' => 'Ethan Chen',
                'email' => 'ethan.chen@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG019',
                'phone' => '+1234567922',
                'department' => 'Operations',
                'join_date' => '2024-09-15',
                'status' => 'active',
                'floor_manager_id' => 6,
                'team_lead_id' => 11, // Priya Patel
            ],
            [
                'name' => 'Olivia Davis',
                'email' => 'olivia.davis@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG020',
                'phone' => '+1234567923',
                'department' => 'Finance',
                'join_date' => '2024-10-20',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => 12, // Ahmed Hassan
            ],
            [
                'name' => 'Lucas Martinez',
                'email' => 'lucas.martinez@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG021',
                'phone' => '+1234567924',
                'department' => 'Finance',
                'join_date' => '2024-11-25',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => 12, // Ahmed Hassan
            ],
            [
                'name' => 'Ava Thompson',
                'email' => 'ava.thompson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG022',
                'phone' => '+1234567925',
                'department' => 'Human Resources',
                'join_date' => '2024-12-30',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            [
                'name' => 'Noah Garcia',
                'email' => 'noah.garcia@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG023',
                'phone' => '+1234567926',
                'department' => 'Quality Assurance',
                'join_date' => '2025-01-05',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            [
                'name' => 'Mia Anderson',
                'email' => 'mia.anderson@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG024',
                'phone' => '+1234567927',
                'department' => 'Research & Development',
                'join_date' => '2025-01-20',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
            [
                'name' => 'William Brown',
                'email' => 'william.brown@hrm.com',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'employee_id' => 'AG025',
                'phone' => '+1234567928',
                'department' => 'Legal',
                'join_date' => '2025-02-01',
                'status' => 'active',
                'floor_manager_id' => null,
                'team_lead_id' => null,
            ],
        ];

        foreach ($additionalUsers as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }

    private function createSubmissions()
    {
        $this->command->info('Creating submissions data...');
        
        $campaigns = [
            'Customer Support',
            'Sales',
            'Technical Support',
            'Marketing',
            'Quality Assurance',
            'Data Entry',
            'Research',
            'Training',
        ];

        $comments = [
            'Customer inquiry about product features',
            'Technical support request for software issue',
            'Sales follow-up call completed',
            'Marketing survey response collected',
            'Quality feedback received from customer',
            'Data entry task completed successfully',
            'Research interview conducted',
            'Training session feedback provided',
            'Customer complaint resolved',
            'Product demonstration completed',
            'Support ticket closed',
            'Sales lead generated',
            'Marketing campaign response',
            'Quality check completed',
            'Data verification done',
            'Research data collected',
            'Training material reviewed',
            'Customer satisfaction survey',
            'Technical documentation updated',
            'Sales report submitted',
        ];

        $agents = User::where('user_type', 'agent')->get();
        
        // Create submissions for the last 3 months
        for ($i = 0; $i < 500; $i++) {
            $agent = $agents->random();
            $date = Carbon::now()->subDays(rand(1, 90));
            
            Submission::create([
                'employee_id' => $agent->employee_id,
                'employee_name' => $agent->name,
                'team_lead_name' => $agent->teamLead ? $agent->teamLead->name : 'Not Assigned',
                'campaign' => $campaigns[array_rand($campaigns)],
                'phone' => '+92' . rand(3000000000, 3999999999),
                'comment' => $comments[array_rand($comments)],
                'submitted_by' => $agent->id,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }

    private function createAttendance()
    {
        $this->command->info('Creating attendance data...');
        
        $users = User::where('status', 'active')->get();
        
        // Create attendance for the last 2 months
        for ($i = 0; $i < 60; $i++) {
            $date = Carbon::now()->subDays($i);
            
            foreach ($users as $user) {
                // Skip weekends
                if ($date->isWeekend()) {
                    continue;
                }
                
                // 90% attendance rate
                if (rand(1, 100) <= 90) {
                    $checkIn = $date->copy()->setTime(9, rand(0, 30), 0)->format('H:i:s');
                    $checkOut = $date->copy()->setTime(17, rand(0, 59), 0)->format('H:i:s');
                    
                    Attendance::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'attendance_date' => $date->format('Y-m-d'),
                        ],
                        [
                            'check_in' => $checkIn,
                            'check_out' => $checkOut,
                            'status' => 'P', // Present
                            'marked_by' => 1, // Admin
                            'created_at' => $date,
                            'updated_at' => $date,
                        ]
                    );
                } else {
                    // Absent or half day
                    $status = rand(1, 2) == 1 ? 'A' : 'H'; // Absent or Half day
                    $checkIn = $status === 'H' ? $date->copy()->setTime(10, rand(0, 59), 0)->format('H:i:s') : null;
                    
                    Attendance::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'attendance_date' => $date->format('Y-m-d'),
                        ],
                        [
                            'check_in' => $checkIn,
                            'check_out' => null,
                            'status' => $status,
                            'marked_by' => 1, // Admin
                            'created_at' => $date,
                            'updated_at' => $date,
                        ]
                    );
                }
            }
        }
    }

    private function createLeaves()
    {
        $this->command->info('Creating leave data...');
        
        $leaveTypes = [
            'Vacation',
            'Sick',
            'Personal',
            'Emergency',
            'Maternity',
            'Paternity',
            'Study',
            'Compensatory',
        ];

        $reasons = [
            'Family emergency',
            'Medical appointment',
            'Personal matters',
            'Vacation',
            'Wedding',
            'Illness',
            'Study purposes',
            'Mental health day',
            'Child care',
            'Religious observance',
        ];

        $users = User::where('status', 'active')->get();
        
        // Create leaves for the last 6 months
        for ($i = 0; $i < 200; $i++) {
            $user = $users->random();
            $startDate = Carbon::now()->subDays(rand(1, 180));
            $duration = rand(1, 5);
            $endDate = $startDate->copy()->addDays($duration - 1);
            
            $statuses = ['Pending', 'Approved', 'Rejected'];
            $status = $statuses[array_rand($statuses)];
            
            $leave = Leave::create([
                'user_id' => $user->id,
                'leave_type' => $leaveTypes[array_rand($leaveTypes)],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_days' => $duration,
                'reason' => $reasons[array_rand($reasons)],
                'status' => $status,
                'approved_by' => $status === 'Approved' ? 1 : null, // Admin
                'created_at' => $startDate->subDays(rand(1, 7)),
                'updated_at' => $startDate->subDays(rand(1, 7)),
            ]);
        }
    }

    private function createSalaries()
    {
        $this->command->info('Creating salary data...');
        
        $users = User::where('status', 'active')->get();
        
        foreach ($users as $user) {
            $baseSalary = $this->getBaseSalaryByRole($user->user_type);
            
            $punctualityBonus = $this->getPunctualityBonusByRole($user->user_type);
            
            Salary::create([
                'employee_id' => $user->id,
                'basic_salary' => $baseSalary,
                'punctuality' => $punctualityBonus,
                'effective_date' => Carbon::now()->subMonths(rand(1, 12)),
                'end_date' => null,
                'status' => 'active',
                'notes' => 'Salary record created automatically',
                'created_at' => Carbon::now()->subMonths(rand(1, 12)),
                'updated_at' => Carbon::now()->subMonths(rand(1, 12)),
            ]);
        }
    }

    private function getBaseSalaryByRole($userType)
    {
        return match($userType) {
            'admin' => rand(150000, 200000),
            'floor_manager' => rand(120000, 150000),
            'team_lead' => rand(80000, 120000),
            'agent' => rand(50000, 80000),
            default => rand(40000, 60000),
        };
    }

    private function getPunctualityBonusByRole($userType)
    {
        return match($userType) {
            'admin' => rand(5000, 15000),
            'floor_manager' => rand(3000, 10000),
            'team_lead' => rand(2000, 8000),
            'agent' => rand(1000, 5000),
            default => rand(1000, 5000),
        };
    }
}
