<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Order is important due to relationships
        $this->call([
            RoleSeeder::class,          // Must be first - creates roles needed by users
            UserSeeder::class,          // Creates users (auto-creates default projects)
            ProjectSeeder::class,       // Creates additional projects
            ContactSeeder::class,       // Creates contacts
            LeadSeeder::class,          // Needs contacts
            ClientSeeder::class,        // Needs contacts
            ProductSeeder::class,       // Needs projects
            ProductionSeeder::class,    // Creates production records
            CollectionSeeder::class,    // Creates collection records
            TaskSeeder::class,          // Needs users, projects, contacts, productions
        ]);

        $this->command->info('Demo data seeded successfully!');
        $this->command->info('You can login with the following credentials:');
        $this->command->newLine();
        $this->command->info('CEO: ceo@example.com / password123');
        $this->command->info('Project Manager: pm@example.com / password123');
        $this->command->info('Sales Manager: sales@example.com / password123');
        $this->command->info('Production Manager: production@example.com / password123');
        $this->command->info('IT Manager: it@example.com / password123');
        $this->command->info('System Installer: installer@example.com / password123');
        $this->command->info('Client: client1@example.com / password123');
        $this->command->info('User 1: user1@example.com / password123');
        $this->command->info('User 2: user2@example.com / password123');
        $this->command->info('User 3: user3@example.com / password123');
    }
}
