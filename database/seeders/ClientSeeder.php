<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get contacts that are marked as past_client or have active status
        $contacts = Contact::where('past_client', true)
            ->orWhere('status', 'active')
            ->limit(8)
            ->get();

        foreach ($contacts as $contact) {
            Client::create([
                'contact_id' => $contact->id,
            ]);
        }
    }
}
