<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            // Management Level
            [
                'name' => 'Chief Executive Officer',
                'description' => 'Top executive responsible for overall company strategy',
                'code' => 'CEO',
                'status' => 'active',
            ],
            [
                'name' => 'Chief Technology Officer',
                'description' => 'Senior executive responsible for technology strategy',
                'code' => 'CTO',
                'status' => 'active',
            ],
            [
                'name' => 'Chief Financial Officer',
                'description' => 'Senior executive responsible for financial management',
                'code' => 'CFO',
                'status' => 'active',
            ],
            [
                'name' => 'Floor Manager',
                'description' => 'Manages operations and team leads on a floor/department',
                'code' => 'FM',
                'status' => 'active',
            ],
            [
                'name' => 'Team Lead',
                'description' => 'Leads a team of agents and coordinates daily activities',
                'code' => 'TL',
                'status' => 'active',
            ],
            
            // HR Department
            [
                'name' => 'HR Manager',
                'description' => 'Manages human resources operations and policies',
                'code' => 'HRM',
                'status' => 'active',
            ],
            [
                'name' => 'HR Specialist',
                'description' => 'Specializes in specific HR functions like recruitment',
                'code' => 'HRS',
                'status' => 'active',
            ],
            [
                'name' => 'HR Coordinator',
                'description' => 'Coordinates HR activities and administrative tasks',
                'code' => 'HRC',
                'status' => 'active',
            ],
            
            // IT Department
            [
                'name' => 'IT Manager',
                'description' => 'Manages IT infrastructure and technical operations',
                'code' => 'ITM',
                'status' => 'active',
            ],
            [
                'name' => 'Senior Developer',
                'description' => 'Experienced software developer with advanced skills',
                'code' => 'SDEV',
                'status' => 'active',
            ],
            [
                'name' => 'Software Developer',
                'description' => 'Develops and maintains software applications',
                'code' => 'DEV',
                'status' => 'active',
            ],
            [
                'name' => 'System Administrator',
                'description' => 'Manages and maintains IT systems and networks',
                'code' => 'SYSADM',
                'status' => 'active',
            ],
            [
                'name' => 'IT Support Specialist',
                'description' => 'Provides technical support to end users',
                'code' => 'ITSUP',
                'status' => 'active',
            ],
            
            // Finance Department
            [
                'name' => 'Finance Manager',
                'description' => 'Manages financial operations and reporting',
                'code' => 'FMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Senior Accountant',
                'description' => 'Handles complex accounting and financial analysis',
                'code' => 'SACC',
                'status' => 'active',
            ],
            [
                'name' => 'Accountant',
                'description' => 'Manages day-to-day accounting operations',
                'code' => 'ACC',
                'status' => 'active',
            ],
            [
                'name' => 'Financial Analyst',
                'description' => 'Analyzes financial data and prepares reports',
                'code' => 'FAN',
                'status' => 'active',
            ],
            
            // Sales & Marketing
            [
                'name' => 'Sales Manager',
                'description' => 'Manages sales team and revenue generation',
                'code' => 'SMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Sales Representative',
                'description' => 'Handles customer relationships and sales activities',
                'code' => 'SREP',
                'status' => 'active',
            ],
            [
                'name' => 'Marketing Manager',
                'description' => 'Manages marketing campaigns and brand promotion',
                'code' => 'MMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Marketing Specialist',
                'description' => 'Executes marketing strategies and campaigns',
                'code' => 'MSP',
                'status' => 'active',
            ],
            
            // Operations
            [
                'name' => 'Operations Manager',
                'description' => 'Manages daily operations and process efficiency',
                'code' => 'OMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Operations Coordinator',
                'description' => 'Coordinates operational activities and logistics',
                'code' => 'OCO',
                'status' => 'active',
            ],
            
            // Customer Support
            [
                'name' => 'Customer Support Manager',
                'description' => 'Manages customer support team and service quality',
                'code' => 'CSMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Customer Support Agent',
                'description' => 'Provides direct customer service and support',
                'code' => 'CSA',
                'status' => 'active',
            ],
            
            // General Positions
            [
                'name' => 'Agent',
                'description' => 'General operational role with specific responsibilities',
                'code' => 'AG',
                'status' => 'active',
            ],
            [
                'name' => 'Administrative Assistant',
                'description' => 'Provides administrative support to management',
                'code' => 'ADMASS',
                'status' => 'active',
            ],
            [
                'name' => 'Data Entry Operator',
                'description' => 'Handles data entry and basic administrative tasks',
                'code' => 'DEO',
                'status' => 'active',
            ],
            
            // Quality Assurance
            [
                'name' => 'QA Manager',
                'description' => 'Manages quality assurance processes and standards',
                'code' => 'QAMGR',
                'status' => 'active',
            ],
            [
                'name' => 'QA Analyst',
                'description' => 'Analyzes processes and ensures quality standards',
                'code' => 'QAA',
                'status' => 'active',
            ],
            [
                'name' => 'Quality Inspector',
                'description' => 'Inspects products and services for quality compliance',
                'code' => 'QI',
                'status' => 'active',
            ],
            
            // Research & Development
            [
                'name' => 'R&D Manager',
                'description' => 'Manages research and development projects',
                'code' => 'RDMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Research Scientist',
                'description' => 'Conducts scientific research and analysis',
                'code' => 'RS',
                'status' => 'active',
            ],
            [
                'name' => 'Product Manager',
                'description' => 'Manages product development and lifecycle',
                'code' => 'PM',
                'status' => 'active',
            ],
            
            // Legal & Compliance
            [
                'name' => 'Legal Counsel',
                'description' => 'Provides legal advice and handles legal matters',
                'code' => 'LC',
                'status' => 'active',
            ],
            [
                'name' => 'Compliance Officer',
                'description' => 'Ensures regulatory compliance and risk management',
                'code' => 'CO',
                'status' => 'active',
            ],
            [
                'name' => 'Risk Manager',
                'description' => 'Identifies and manages business risks',
                'code' => 'RM',
                'status' => 'active',
            ],
            
            // Training & Development
            [
                'name' => 'Training Manager',
                'description' => 'Manages employee training and development programs',
                'code' => 'TMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Training Specialist',
                'description' => 'Designs and delivers training programs',
                'code' => 'TS',
                'status' => 'active',
            ],
            [
                'name' => 'Learning & Development Coordinator',
                'description' => 'Coordinates learning initiatives and programs',
                'code' => 'LDC',
                'status' => 'active',
            ],
            
            // Security & Facilities
            [
                'name' => 'Security Manager',
                'description' => 'Manages physical and digital security operations',
                'code' => 'SECMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Security Officer',
                'description' => 'Monitors and maintains security protocols',
                'code' => 'SECOFF',
                'status' => 'active',
            ],
            [
                'name' => 'Facilities Manager',
                'description' => 'Manages building maintenance and facilities',
                'code' => 'FACMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Maintenance Technician',
                'description' => 'Performs maintenance and repair tasks',
                'code' => 'MT',
                'status' => 'active',
            ],
            
            // Business Intelligence & Analytics
            [
                'name' => 'BI Manager',
                'description' => 'Manages business intelligence and analytics',
                'code' => 'BIMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Data Analyst',
                'description' => 'Analyzes data and generates business insights',
                'code' => 'DA',
                'status' => 'active',
            ],
            [
                'name' => 'Business Analyst',
                'description' => 'Analyzes business processes and requirements',
                'code' => 'BA',
                'status' => 'active',
            ],
            
            // Procurement & Supply Chain
            [
                'name' => 'Procurement Manager',
                'description' => 'Manages procurement and vendor relationships',
                'code' => 'PROCMGR',
                'status' => 'active',
            ],
            [
                'name' => 'Procurement Specialist',
                'description' => 'Handles procurement processes and negotiations',
                'code' => 'PROCSP',
                'status' => 'active',
            ],
            [
                'name' => 'Supply Chain Coordinator',
                'description' => 'Coordinates supply chain operations',
                'code' => 'SCC',
                'status' => 'active',
            ],
        ];

        foreach ($designations as $designation) {
            Designation::updateOrCreate(
                ['name' => $designation['name']],
                $designation
            );
        }
    }
}