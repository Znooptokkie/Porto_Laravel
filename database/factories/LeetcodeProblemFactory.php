<?php

namespace Database\Factories;

use App\Enums\LeetcodeDifficulty;
use App\Models\LeetcodeProblem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeetcodeProblem>
 */
class LeetcodeProblemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slug = fake()->unique()->slug(3);

        return [
            'problem_number' => fake()->numberBetween(1, 4000),
            'name' => str($slug)->replace('-', ' ')->title()->toString(),
            'url' => 'https://leetcode.com/problems/'.$slug.'/',
            'rating' => fake()->numberBetween(1, 6),
            'difficulty' => fake()->randomElement(LeetcodeDifficulty::cases()),
            'language' => 'python',
            'runtime_ms' => fake()->randomFloat(2, 0, 1000),
            'runtime_percentage' => fake()->randomFloat(2, 0, 100),
            'memory_mb' => fake()->randomFloat(2, 15, 25),
            'memory_percentage' => fake()->randomFloat(2, 0, 100),
            'code' => "class Solution:\n    def solve(self, nums: list[int]) -> int:\n        return sum(nums)",
        ];
    }
}
