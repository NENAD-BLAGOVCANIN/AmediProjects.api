<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Smith',
                'email' => 'ceo@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::CEO,
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'pm@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::PROJECT_MANAGER,
            ],
            [
                'name' => 'Mike Williams',
                'email' => 'sales@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::SALES_MANAGER,
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'production@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::PRODUCTION_MANAGER,
            ],
            [
                'name' => 'David Brown',
                'email' => 'it@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::IT_MANAGER,
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'installer@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::SYSTEM_INSTALLER,
            ],
            [
                'name' => 'Robert Taylor',
                'email' => 'client1@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::CLIENT,
            ],
            [
                'name' => 'Jennifer Martinez',
                'email' => 'user1@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::USER,
            ],
            [
                'name' => 'James Wilson',
                'email' => 'user2@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::USER,
            ],
            [
                'name' => 'Patricia Moore',
                'email' => 'user3@example.com',
                'password' => Hash::make('password123'),
                'role' => Role::USER,
            ],
        ];

        foreach ($users as $userData) {
            $role = Role::where('name', $userData['role'])->first();

            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);

            // Update the role after creation (the booted event sets it to 'user')
            $user->role_id = $role->id;
            $user->save();
        }
    }
}
