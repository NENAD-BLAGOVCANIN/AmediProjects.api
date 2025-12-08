<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'LED Lighting System',
                'description' => 'Energy-efficient LED lighting panels for commercial spaces',
                'price' => 15000.00,
            ],
            [
                'name' => 'Circuit Breaker Panel',
                'description' => '200A main service panel with surge protection',
                'price' => 3500.00,
            ],
            [
                'name' => 'Emergency Generator',
                'description' => '50kW standby generator with automatic transfer switch',
                'price' => 25000.00,
            ],
            [
                'name' => 'Security Camera System',
                'description' => '16-channel IP camera system with NVR',
                'price' => 8500.00,
            ],
            [
                'name' => 'Fire Alarm System',
                'description' => 'Addressable fire alarm panel with 50 devices',
                'price' => 12000.00,
            ],
            [
                'name' => 'HVAC Control System',
                'description' => 'Building automation system for climate control',
                'price' => 18000.00,
            ],
            [
                'name' => 'Electrical Wiring Bundle',
                'description' => 'Complete wiring package for residential units',
                'price' => 5500.00,
            ],
            [
                'name' => 'Power Distribution Unit',
                'description' => 'Rack-mounted PDU for data center applications',
                'price' => 2200.00,
            ],
            [
                'name' => 'Solar Panel Array',
                'description' => '20kW solar panel system with inverters',
                'price' => 35000.00,
            ],
            [
                'name' => 'UPS System',
                'description' => 'Uninterruptible power supply 10kVA',
                'price' => 8000.00,
            ],
        ];

        $projects = Project::all();

        foreach ($projects as $project) {
            // Add 2-5 random products to each project
            $productCount = rand(2, 5);
            $selectedProducts = collect($products)->random($productCount);

            foreach ($selectedProducts as $productData) {
                Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'project_id' => $project->id,
                ]);
            }
        }
    }
}
