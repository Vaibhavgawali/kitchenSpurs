<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Faker\Factory as Faker;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tasks = [
            [
                'title' => 'Update website homepage design',
                'description' => 'Redesign the homepage to improve user experience and reflect new branding guidelines.',
                'due_date' => now()->addDays(7),
                'status' => 'in progress',
            ],
            [
                'title' => 'Prepare project proposal',
                'description' => 'Write a proposal for the upcoming project including scope, timeline, and budget.',
                'due_date' => now()->addDays(5),
                'status' => 'pending',
            ],
            [
                'title' => 'Review and finalize quarterly report',
                'description' => 'Review and finalize the quarterly report with sales and financial data.',
                'due_date' => now()->addDays(10),
                'status' => 'completed',
            ],
            // Add more tasks as needed
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
