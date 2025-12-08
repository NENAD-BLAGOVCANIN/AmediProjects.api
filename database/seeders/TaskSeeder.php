<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Contact;
use App\Models\Production;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $projects = Project::all();
        $contacts = Contact::all();
        $productions = Production::all();

        if ($users->isEmpty() || $projects->isEmpty()) {
            return;
        }

        // Tasks related to Projects
        $projectTasks = [
            [
                'subject' => 'Complete electrical inspection',
                'description' => 'Schedule and complete the final electrical inspection with city inspector',
                'status' => Task::STATUS_IN_PROGRESS,
                'due_date' => Carbon::now()->addDays(5),
                'phone' => '+1-555-9001',
                'email' => 'inspection@example.com',
            ],
            [
                'subject' => 'Order additional circuit breakers',
                'description' => 'Need to order 10 more 20A circuit breakers for phase 2',
                'status' => Task::STATUS_TODO,
                'due_date' => Carbon::now()->addDays(3),
                'phone' => '+1-555-9002',
                'email' => 'supply@example.com',
            ],
            [
                'subject' => 'Install emergency lighting',
                'description' => 'Install emergency exit lighting on floors 3-5',
                'status' => Task::STATUS_TODO,
                'due_date' => Carbon::now()->addDays(7),
                'phone' => '+1-555-9003',
                'email' => 'emergency@example.com',
            ],
            [
                'subject' => 'Update project documentation',
                'description' => 'Update as-built drawings with recent modifications',
                'status' => Task::STATUS_DONE,
                'due_date' => Carbon::now()->subDays(2),
                'phone' => '+1-555-9004',
                'email' => 'docs@example.com',
            ],
            [
                'subject' => 'Cable pull for data center',
                'description' => 'Complete cable installation for server racks 1-10',
                'status' => Task::STATUS_IN_PROGRESS,
                'due_date' => Carbon::now()->addDays(4),
                'phone' => '+1-555-9005',
                'email' => 'datacenter@example.com',
            ],
        ];

        foreach ($projectTasks as $taskData) {
            Task::create([
                'subject' => $taskData['subject'],
                'description' => $taskData['description'],
                'status' => $taskData['status'],
                'due_date' => $taskData['due_date'],
                'phone' => $taskData['phone'],
                'email' => $taskData['email'],
                'project_id' => $projects->random()->id,
                'assigned_to' => $users->random()->id,
            ]);
        }

        // Tasks related to Contacts (polymorphic)
        if ($contacts->isNotEmpty()) {
            $contactTasks = [
                [
                    'subject' => 'Follow up on quotation',
                    'description' => 'Call client to discuss the electrical quotation sent last week',
                    'status' => Task::STATUS_TODO,
                    'due_date' => Carbon::now()->addDays(2),
                ],
                [
                    'subject' => 'Schedule site visit',
                    'description' => 'Arrange site visit to assess electrical requirements',
                    'status' => Task::STATUS_IN_PROGRESS,
                    'due_date' => Carbon::now()->addDays(3),
                ],
                [
                    'subject' => 'Send project proposal',
                    'description' => 'Prepare and send detailed project proposal with timeline',
                    'status' => Task::STATUS_TODO,
                    'due_date' => Carbon::now()->addDays(5),
                ],
            ];

            foreach ($contactTasks as $taskData) {
                $contact = $contacts->random();
                Task::create([
                    'subject' => $taskData['subject'],
                    'description' => $taskData['description'],
                    'status' => $taskData['status'],
                    'due_date' => $taskData['due_date'],
                    'phone' => $contact->phone,
                    'email' => $contact->email,
                    'assigned_to' => $users->random()->id,
                    'taskable_id' => $contact->id,
                    'taskable_type' => Contact::class,
                ]);
            }
        }

        // Tasks related to Productions (polymorphic)
        if ($productions->isNotEmpty()) {
            $productionTasks = [
                [
                    'subject' => 'Complete measurements',
                    'description' => 'Finish taking all measurements for production planning',
                    'status' => Task::STATUS_IN_PROGRESS,
                    'due_date' => Carbon::now()->addDays(2),
                ],
                [
                    'subject' => 'Order production materials',
                    'description' => 'Order all materials needed for production phase',
                    'status' => Task::STATUS_TODO,
                    'due_date' => Carbon::now()->addDays(4),
                ],
                [
                    'subject' => 'Quality inspection',
                    'description' => 'Perform quality check on completed production items',
                    'status' => Task::STATUS_DONE,
                    'due_date' => Carbon::now()->subDays(1),
                ],
            ];

            foreach ($productionTasks as $taskData) {
                Task::create([
                    'subject' => $taskData['subject'],
                    'description' => $taskData['description'],
                    'status' => $taskData['status'],
                    'due_date' => $taskData['due_date'],
                    'assigned_to' => $users->random()->id,
                    'taskable_id' => $productions->random()->id,
                    'taskable_type' => Production::class,
                ]);
            }
        }

        // Additional general project tasks
        foreach ($projects as $project) {
            Task::create([
                'subject' => 'Weekly progress meeting',
                'description' => 'Attend weekly project progress review meeting',
                'status' => Task::STATUS_TODO,
                'due_date' => Carbon::now()->addDays(rand(1, 14)),
                'project_id' => $project->id,
                'assigned_to' => $users->random()->id,
            ]);
        }
    }
}
