<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@techcorp.com',
                'phone' => '+1-555-1001',
                'title' => 'Chief Technology Officer',
                'city' => 'San Francisco',
                'address' => '123 Tech Street, San Francisco, CA 94102',
                'organization' => 'TechCorp Industries',
                'description' => 'Interested in modern electrical solutions for tech campus',
                'status' => 'active',
                'lead_source' => 'referral',
                'past_client' => false,
            ],
            [
                'name' => 'Bob Martinez',
                'email' => 'bob.m@constructionplus.com',
                'phone' => '+1-555-1002',
                'title' => 'Project Coordinator',
                'city' => 'Austin',
                'address' => '456 Builder Ave, Austin, TX 78701',
                'organization' => 'Construction Plus LLC',
                'description' => 'Looking for reliable electrical contractors',
                'status' => 'active',
                'lead_source' => 'website',
                'past_client' => true,
            ],
            [
                'name' => 'Carol Williams',
                'email' => 'carol.w@realestate.com',
                'phone' => '+1-555-1003',
                'title' => 'Development Manager',
                'city' => 'Seattle',
                'address' => '789 Property Lane, Seattle, WA 98101',
                'organization' => 'Real Estate Developers',
                'description' => 'Multiple residential projects requiring electrical work',
                'status' => 'active',
                'lead_source' => 'cold_call',
                'past_client' => false,
            ],
            [
                'name' => 'Daniel Lee',
                'email' => 'daniel.lee@manufacturing.com',
                'phone' => '+1-555-1004',
                'title' => 'Facilities Director',
                'city' => 'Detroit',
                'address' => '321 Industrial Blvd, Detroit, MI 48201',
                'organization' => 'Manufacturing Corp',
                'description' => 'Factory electrical system upgrades needed',
                'status' => 'active',
                'lead_source' => 'trade_show',
                'past_client' => true,
            ],
            [
                'name' => 'Emma Davis',
                'email' => 'emma.davis@hospitality.com',
                'phone' => '+1-555-1005',
                'title' => 'Operations Manager',
                'city' => 'Las Vegas',
                'address' => '654 Resort Way, Las Vegas, NV 89101',
                'organization' => 'Hospitality Group',
                'description' => 'Hotel chain electrical maintenance contracts',
                'status' => 'inactive',
                'lead_source' => 'referral',
                'past_client' => false,
            ],
            [
                'name' => 'Frank Thompson',
                'email' => 'frank.t@retailchain.com',
                'phone' => '+1-555-1006',
                'title' => 'Store Development Lead',
                'city' => 'Phoenix',
                'address' => '987 Retail Plaza, Phoenix, AZ 85001',
                'organization' => 'Retail Chain Inc',
                'description' => 'National rollout of new store locations',
                'status' => 'active',
                'lead_source' => 'linkedin',
                'past_client' => true,
            ],
            [
                'name' => 'Grace Chen',
                'email' => 'grace.chen@education.edu',
                'phone' => '+1-555-1007',
                'title' => 'Facilities Coordinator',
                'city' => 'Boston',
                'address' => '147 Campus Drive, Boston, MA 02101',
                'organization' => 'Education Institute',
                'description' => 'University campus electrical infrastructure updates',
                'status' => 'active',
                'lead_source' => 'website',
                'past_client' => false,
            ],
            [
                'name' => 'Henry Rodriguez',
                'email' => 'henry.r@logistics.com',
                'phone' => '+1-555-1008',
                'title' => 'Warehouse Manager',
                'city' => 'Atlanta',
                'address' => '258 Logistics Park, Atlanta, GA 30301',
                'organization' => 'Logistics Solutions',
                'description' => 'Distribution center electrical requirements',
                'status' => 'active',
                'lead_source' => 'referral',
                'past_client' => false,
            ],
            [
                'name' => 'Isabella Garcia',
                'email' => 'isabella.g@healthcare.com',
                'phone' => '+1-555-1009',
                'title' => 'Facilities Director',
                'city' => 'Denver',
                'address' => '369 Medical Center Way, Denver, CO 80201',
                'organization' => 'Healthcare Network',
                'description' => 'Medical facilities requiring specialized electrical work',
                'status' => 'active',
                'lead_source' => 'cold_call',
                'past_client' => true,
            ],
            [
                'name' => 'Jack Wilson',
                'email' => 'jack.wilson@datacenters.com',
                'phone' => '+1-555-1010',
                'title' => 'Infrastructure Manager',
                'city' => 'Portland',
                'address' => '741 Server Farm Road, Portland, OR 97201',
                'organization' => 'Data Centers Inc',
                'description' => 'High-capacity electrical systems for data centers',
                'status' => 'active',
                'lead_source' => 'website',
                'past_client' => false,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
