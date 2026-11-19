<?php

namespace Database\Factories;

use App\Models\LinuxCommand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LinuxCommand>
 */
class LinuxCommandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'command' => 'ls -la '.fake()->word(),
            'description' => fake()->sentence(),
        ];
    }
}
