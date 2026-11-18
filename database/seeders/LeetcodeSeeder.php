<?php

namespace Database\Seeders;

use App\Actions\ImportLeetcodeFixture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeetcodeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Imports the LeetCode problems and concepts from the migration fixture.
     */
    public function run(): void
    {
        app(ImportLeetcodeFixture::class)->handle(base_path('docs/migration/leetcode.json'));
    }
}
