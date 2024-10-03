<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => ucfirst($this->faker->words(4, true)),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['New', 'In Progress', 'Under Review', 'Completed']),
            'created_at' => now()->subDays(rand(0, 30)),
        ];
    }

    public function existing()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => $this->faker->numberBetween(1, 10),
                'category_id' => $this->faker->numberBetween(1, 5),
                'status' => $this->faker->randomElement(['New', 'In Progress', 'Under Review', 'Completed']),
            ];
        });
    }
}
