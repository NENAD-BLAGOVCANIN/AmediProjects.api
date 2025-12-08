<?php

namespace Database\Seeders;

use App\Models\Production;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['planning', 'measuring', 'finished'];

        $productions = [
            [
                'company' => 'BuildCorp Inc.',
                'site_city' => 'New York',
                'item' => 'Electrical Panel Installation',
                'status' => 'finished',
                'performed_by' => 'John Electrician',
                'notes' => 'Installation completed successfully. All panels tested and certified.',
            ],
            [
                'company' => 'Mall Developers Ltd.',
                'site_city' => 'Los Angeles',
                'item' => 'Security System Wiring',
                'status' => 'measuring',
                'performed_by' => 'Sarah Technician',
                'notes' => 'Measuring phase in progress. Site survey scheduled for next week.',
            ],
            [
                'company' => 'Warehouse Solutions',
                'site_city' => 'Chicago',
                'item' => 'Main Power Distribution',
                'status' => 'planning',
                'performed_by' => 'Mike Foreman',
                'notes' => 'Planning phase. Waiting for architectural drawings approval.',
            ],
            [
                'company' => 'Urban Living Properties',
                'site_city' => 'Miami',
                'item' => 'Residential Unit Wiring',
                'status' => 'measuring',
                'performed_by' => 'Emily Installer',
                'notes' => 'Initial measurements completed. Material list being prepared.',
            ],
            [
                'company' => 'HealthCare Systems',
                'site_city' => 'Houston',
                'item' => 'Emergency Power Systems',
                'status' => 'planning',
                'performed_by' => 'David Specialist',
                'notes' => 'Planning critical power systems. Redundancy requirements being evaluated.',
            ],
            [
                'company' => 'TechCorp Industries',
                'site_city' => 'San Francisco',
                'item' => 'Data Center Infrastructure',
                'status' => 'finished',
                'performed_by' => 'Lisa Engineer',
                'notes' => 'Data center electrical infrastructure completed. Load testing passed.',
            ],
            [
                'company' => 'Construction Plus LLC',
                'site_city' => 'Austin',
                'item' => 'HVAC Control Wiring',
                'status' => 'measuring',
                'performed_by' => 'Robert Technician',
                'notes' => 'Measuring HVAC zones. Control panel locations identified.',
            ],
            [
                'company' => 'Real Estate Developers',
                'site_city' => 'Seattle',
                'item' => 'Common Area Lighting',
                'status' => 'finished',
                'performed_by' => 'Jennifer Specialist',
                'notes' => 'LED lighting installation complete. Energy savings verified.',
            ],
            [
                'company' => 'Manufacturing Corp',
                'site_city' => 'Detroit',
                'item' => 'Industrial Machinery Power',
                'status' => 'planning',
                'performed_by' => 'James Foreman',
                'notes' => 'Planning power distribution for new machinery. Load calculations in progress.',
            ],
            [
                'company' => 'Hospitality Group',
                'site_city' => 'Las Vegas',
                'item' => 'Guest Room Electrical',
                'status' => 'measuring',
                'performed_by' => 'Patricia Installer',
                'notes' => 'Measuring guest room layouts. Smart control integration planned.',
            ],
        ];

        foreach ($productions as $production) {
            Production::create($production);
        }
    }
}
