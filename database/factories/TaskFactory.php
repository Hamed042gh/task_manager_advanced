<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->boolean,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
