<?php

namespace Database\Factories;

use App\Models\ShellScript;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ShellScript>
 */
class ShellScriptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->slug(2).'.sh',
            'description' => fake()->sentence(),
            'code' => "#!/usr/bin/env bash\nset -euo pipefail\n\necho 'Hello, world'",
        ];
    }
}
