<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            Project::STATUS_SETTING_UP,
            Project::STATUS_MEASUREMENT,
            Project::STATUS_WRITING_A_PROGRAM,
            Project::STATUS_PRODUCTION,
            Project::STATUS_GALVANIZATION,
            Project::STATUS_INSTALLATION,
            Project::STATUS_DELIVERY,
            Project::STATUS_COLLECTION,
        ];

        $projects = [
            [
                'name' => 'Office Building Renovation',
                'description' => 'Complete renovation of 5-story office building including electrical systems',
                'company_name' => 'BuildCorp Inc.',
                'location' => 'New York, NY',
                'contact_person' => 'Michael Brown',
                'phone' => '+1-555-0101',
                'company_number' => 'BC-2024-001',
                'accounting_phone' => '+1-555-0102',
                'project_manager_phone' => '+1-555-0103',
                'accounting_email' => 'accounting@buildcorp.com',
                'project_manager_email' => 'pm@buildcorp.com',
                'project_manager_name' => 'Sarah Johnson',
                'accounting_manager_name' => 'Tom Anderson',
                'status' => Project::STATUS_PRODUCTION,
            ],
            [
                'name' => 'Shopping Mall Installation',
                'description' => 'New shopping mall electrical and security systems installation',
                'company_name' => 'Mall Developers Ltd.',
                'location' => 'Los Angeles, CA',
                'contact_person' => 'Jennifer Lee',
                'phone' => '+1-555-0201',
                'company_number' => 'MD-2024-002',
                'accounting_phone' => '+1-555-0202',
                'project_manager_phone' => '+1-555-0203',
                'accounting_email' => 'accounting@malldev.com',
                'project_manager_email' => 'projects@malldev.com',
                'project_manager_name' => 'David Kim',
                'accounting_manager_name' => 'Lisa Chen',
                'status' => Project::STATUS_INSTALLATION,
            ],
            [
                'name' => 'Industrial Warehouse Setup',
                'description' => 'Complete electrical setup for 50,000 sq ft warehouse',
                'company_name' => 'Warehouse Solutions',
                'location' => 'Chicago, IL',
                'contact_person' => 'Robert Taylor',
                'phone' => '+1-555-0301',
                'company_number' => 'WS-2024-003',
                'accounting_phone' => '+1-555-0302',
                'project_manager_phone' => '+1-555-0303',
                'accounting_email' => 'billing@warehousesol.com',
                'project_manager_email' => 'manager@warehousesol.com',
                'project_manager_name' => 'Emily Davis',
                'accounting_manager_name' => 'Mark Wilson',
                'status' => Project::STATUS_MEASUREMENT,
            ],
            [
                'name' => 'Residential Complex Wiring',
                'description' => 'Electrical wiring for 100-unit residential complex',
                'company_name' => 'Urban Living Properties',
                'location' => 'Miami, FL',
                'contact_person' => 'Amanda White',
                'phone' => '+1-555-0401',
                'company_number' => 'UL-2024-004',
                'accounting_phone' => '+1-555-0402',
                'project_manager_phone' => '+1-555-0403',
                'accounting_email' => 'accounts@urbanliving.com',
                'project_manager_email' => 'pm@urbanliving.com',
                'project_manager_name' => 'John Smith',
                'accounting_manager_name' => 'Patricia Moore',
                'status' => Project::STATUS_GALVANIZATION,
            ],
            [
                'name' => 'Hospital Electrical Upgrade',
                'description' => 'Upgrade of electrical systems in regional hospital',
                'company_name' => 'HealthCare Systems',
                'location' => 'Houston, TX',
                'contact_person' => 'Dr. James Martin',
                'phone' => '+1-555-0501',
                'company_number' => 'HC-2024-005',
                'accounting_phone' => '+1-555-0502',
                'project_manager_phone' => '+1-555-0503',
                'accounting_email' => 'finance@healthcare-sys.com',
                'project_manager_email' => 'projects@healthcare-sys.com',
                'project_manager_name' => 'Mike Williams',
                'accounting_manager_name' => 'Nancy Garcia',
                'status' => Project::STATUS_SETTING_UP,
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::create($projectData);

            // Attach random users to the project (2-4 users per project)
            $users = User::inRandomOrder()->take(rand(2, 4))->pluck('id');
            $project->users()->attach($users);
        }
    }
}
