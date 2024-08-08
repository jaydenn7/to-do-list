<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition() : array
    {
        return [
            'description' => $this->faker->sentence,
            'completed_at' => random_int(0, 1) ? Carbon::now() : null,
        ];
    }
}
