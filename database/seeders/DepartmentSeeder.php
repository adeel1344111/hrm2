<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Human Resources',
                'description' => 'Manages employee relations, recruitment, and HR policies',
                'code' => 'HR',
                'status' => 'active',
            ],
            [
                'name' => 'Information Technology',
                'description' => 'Handles all technical infrastructure and software development',
                'code' => 'IT',
                'status' => 'active',
            ],
            [
                'name' => 'Finance & Accounting',
                'description' => 'Manages financial operations, budgeting, and accounting',
                'code' => 'FIN',
                'status' => 'active',
            ],
            [
                'name' => 'Marketing',
                'description' => 'Responsible for brand promotion and customer acquisition',
                'code' => 'MKT',
                'status' => 'active',
            ],
            [
                'name' => 'Sales',
                'description' => 'Focuses on revenue generation and customer relationships',
                'code' => 'SAL',
                'status' => 'active',
            ],
            [
                'name' => 'Operations',
                'description' => 'Manages day-to-day business operations and processes',
                'code' => 'OPS',
                'status' => 'active',
            ],
            [
                'name' => 'Customer Support',
                'description' => 'Provides customer service and technical support',
                'code' => 'CS',
                'status' => 'active',
            ],
            [
                'name' => 'Research & Development',
                'description' => 'Innovation and product development activities',
                'code' => 'R&D',
                'status' => 'active',
            ],
            [
                'name' => 'Quality Assurance',
                'description' => 'Ensures product and service quality standards',
                'code' => 'QA',
                'status' => 'active',
            ],
            [
                'name' => 'Administration',
                'description' => 'General administrative and support functions',
                'code' => 'ADM',
                'status' => 'active',
            ],
            [
                'name' => 'Legal',
                'description' => 'Legal compliance and contract management',
                'code' => 'LEG',
                'status' => 'active',
            ],
            [
                'name' => 'Procurement',
                'description' => 'Vendor management and purchasing operations',
                'code' => 'PRO',
                'status' => 'active',
            ],
            [
                'name' => 'Training & Development',
                'description' => 'Employee training and skill development programs',
                'code' => 'T&D',
                'status' => 'active',
            ],
            [
                'name' => 'Security',
                'description' => 'Physical and digital security management',
                'code' => 'SEC',
                'status' => 'active',
            ],
            [
                'name' => 'Facilities Management',
                'description' => 'Building maintenance and facility operations',
                'code' => 'FAC',
                'status' => 'active',
            ],
            [
                'name' => 'Compliance',
                'description' => 'Regulatory compliance and risk management',
                'code' => 'COM',
                'status' => 'active',
            ],
            [
                'name' => 'Business Intelligence',
                'description' => 'Data analysis and business insights',
                'code' => 'BI',
                'status' => 'active',
            ],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['name' => $department['name']],
                $department
            );
        }
    }
}