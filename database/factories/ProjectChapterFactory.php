<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectChapter>
 */
class ProjectChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => fake()->sentence(3),
            'paragraphs' => fake()->paragraphs(2),
            'sort_order' => fake()->numberBetween(1, 14),
        ];
    }
}
