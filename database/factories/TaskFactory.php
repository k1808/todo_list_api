<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $count = Task::count();
        return [
            'title' => fake()->word(),
            'priority' => fake()->numberBetween(0, 5),
            'status' => fake()->boolean,
            'description' => fake()->sentence(),
            'user_id'=>1,
            'parent_id'=>$count>0 ? fake()->numberBetween(1, $count):1
        ];
    }
}
