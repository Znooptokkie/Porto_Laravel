<?php

namespace Database\Factories;

use App\Enums\ProjectComponentGroup;
use App\Models\Project;
use App\Models\ProjectComponent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectComponent>
 */
class ProjectComponentFactory extends Factory
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
            'group' => fake()->randomElement(ProjectComponentGroup::cases()),
            'name' => fake()->word(),
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
