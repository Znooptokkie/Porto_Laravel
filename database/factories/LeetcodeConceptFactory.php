<?php

namespace Database\Factories;

use App\Enums\LeetcodeConceptType;
use App\Models\LeetcodeConcept;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeetcodeConcept>
 */
class LeetcodeConceptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(LeetcodeConceptType::cases()),
            'name' => fake()->unique()->word().'()',
            'description' => fake()->sentence(),
        ];
    }
}
