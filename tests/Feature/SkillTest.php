<?php

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
use Database\Seeders\SkillSeeder;

it('casts subconcepts to an array and proficiency to an integer', function () {
    $skill = Skill::make([
        'name' => 'Python',
        'proficiency' => '85',
        'subconcepts' => ['Django', 'Flask'],
    ]);

    expect($skill->proficiency)->toBe(85)
        ->and($skill->subconcepts)->toBe(['Django', 'Flask']);
});

it('seeds ten skills, including the Raspberry card', function () {
    $this->seed(SkillSeeder::class);

    expect(Skill::query()->count())->toBe(10)
        ->and(Skill::query()->where('name', 'Raspberry')->count())->toBe(1);
});

it('updates existing skills instead of duplicating them when seeded twice', function () {
    $this->seed(SkillSeeder::class);
    Skill::query()->where('name', 'Python')->update(['proficiency' => 1]);

    $this->seed(SkillSeeder::class);

    expect(Skill::query()->count())->toBe(10)
        ->and(Skill::query()->where('name', 'Raspberry')->count())->toBe(1)
        ->and(Skill::query()->where('name', 'Python')->value('proficiency'))->toBe(85);
});
