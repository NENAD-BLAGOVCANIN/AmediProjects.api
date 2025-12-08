<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => Role::CEO, 'can_access_admin_panel' => true],
            ['name' => Role::PROJECT_MANAGER, 'can_access_admin_panel' => true],
            ['name' => Role::SALES_MANAGER, 'can_access_admin_panel' => true],
            ['name' => Role::PRODUCTION_MANAGER, 'can_access_admin_panel' => true],
            ['name' => Role::IT_MANAGER, 'can_access_admin_panel' => true],
            ['name' => Role::SYSTEM_INSTALLER, 'can_access_admin_panel' => false],
            ['name' => Role::CLIENT, 'can_access_admin_panel' => false],
            ['name' => Role::USER, 'can_access_admin_panel' => false],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['can_access_admin_panel' => $role['can_access_admin_panel'] ?? false]
            );
        }
    }
}
