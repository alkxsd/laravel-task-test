<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Finish project report',
                'description' => 'Complete the report for the ongoing project',
                'status' => 'In Progress',
                'user_id' => 1, // Assuming user with ID 1 exists
                'category_id' => 1, // Assuming category with ID 1 exists
            ],
            [
                'title' => 'Grocery shopping',
                'description' => 'Buy milk, eggs, bread, and cheese from the supermarket',
                'status' => 'New',
                'user_id' => 1,
                'category_id' => 4,
            ],
            // ... Add more tasks
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
