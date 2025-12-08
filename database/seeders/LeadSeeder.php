<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leadSources = ['website', 'referral', 'cold_call', 'trade_show', 'linkedin', 'email_campaign'];

        $leads = [
            [
                'description' => 'Interested in comprehensive electrical solution for new tech campus. Budget approved, looking for quotes.',
                'lead_source' => 'referral',
            ],
            [
                'description' => 'Needs electrical contractor for ongoing construction projects. Previously satisfied client.',
                'lead_source' => 'website',
            ],
            [
                'description' => 'Multiple residential developments in pipeline. Seeking long-term partnership.',
                'lead_source' => 'cold_call',
            ],
            [
                'description' => 'Factory expansion project requiring extensive electrical work. Met at trade show.',
                'lead_source' => 'trade_show',
            ],
            [
                'description' => 'Hotel chain looking for maintenance contracts across multiple properties.',
                'lead_source' => 'referral',
            ],
            [
                'description' => 'Retail chain expanding to 50 new locations this year. Seeking reliable electrical partner.',
                'lead_source' => 'linkedin',
            ],
        ];

        $contacts = Contact::limit(6)->get();

        foreach ($leads as $index => $leadData) {
            if (isset($contacts[$index])) {
                Lead::create([
                    'contact_id' => $contacts[$index]->id,
                    'description' => $leadData['description'],
                    'lead_source' => $leadData['lead_source'],
                ]);
            }
        }
    }
}
