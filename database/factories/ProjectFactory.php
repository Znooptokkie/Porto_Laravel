<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(2, true);

        return [
            'slug' => str($title)->slug()->toString(),
            'title' => ucfirst($title),
            'category' => 'WEBDEVELOPMENT',
            'intro_label' => null,
            'started_year' => fake()->numberBetween(2022, 2025),
            'ended_year' => null,
            'summary' => fake()->sentence(),
            'subtitle' => null,
            'story_lead' => null,
            'status' => fake()->randomElement(ProjectStatus::cases()),
            'favorite_rank' => null,
            'organization' => null,
            'department' => null,
            'repository_url' => null,
            'sort_order' => fake()->unique()->numberBetween(1, 999),
        ];
    }

    /**
     * Marks the project as a favourite with the given rank; 1 is the most favourite.
     */
    public function favorite(int $rank = 1): static
    {
        return $this->state(fn (): array => ['favorite_rank' => $rank]);
    }

    /**
     * Gives the project a specific status.
     */
    public function withStatus(ProjectStatus $status): static
    {
        return $this->state(fn (): array => ['status' => $status]);
    }
}
