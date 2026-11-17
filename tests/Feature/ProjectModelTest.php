<?php

use App\Enums\ProjectStatus;
use App\Models\Project;

it('casts the status, favourite rank and years on the model', function () {
    $project = new Project([
        'status' => 'in_constructie',
        'favorite_rank' => '2',
        'started_year' => '2025',
        'ended_year' => null,
    ]);

    expect($project->status)->toBe(ProjectStatus::InConstructie)
        ->and($project->favorite_rank)->toBe(2)
        ->and($project->isFavorite())->toBeTrue()
        ->and((new Project(['favorite_rank' => null]))->isFavorite())->toBeFalse()
        ->and($project->started_year)->toBe(2025)
        ->and($project->ended_year)->toBeNull();
});

it('builds the period label from the start and optional end year', function () {
    expect((new Project(['started_year' => 2024, 'ended_year' => 2025]))->periodLabel())->toBe('2024 | 2025')
        ->and((new Project(['started_year' => 2026, 'ended_year' => null]))->periodLabel())->toBe('2026');
});

it('wraps the text between asterisks in a strong element and escapes the rest', function () {
    $project = new Project(['summary' => 'Sensoren en *N-Mosfets* & <b>', 'translations' => []]);

    expect((string) $project->accented('summary'))->toBe('Sensoren en <strong>N-Mosfets</strong> &amp; &lt;b&gt;');
});

it('accents the last word of a multi-word title', function () {
    expect((new Project(['title' => 'Smart Garden - Desktop']))->titleParts())
        ->toBe(['lead' => 'Smart Garden - ', 'accent' => 'Desktop']);
});

it('accents the last fifth of the letters of a single-word title', function () {
    expect((new Project(['title' => 'Battlebot']))->titleParts())->toBe(['lead' => 'Battleb', 'accent' => 'ot'])
        ->and((new Project(['title' => 'Zinra']))->titleParts())->toBe(['lead' => 'Zinr', 'accent' => 'a'])
        ->and((new Project(['title' => 'BRAM']))->titleParts())->toBe(['lead' => 'BRA', 'accent' => 'M']);
});

it('splits the translated title for the current locale', function () {
    $project = new Project(['title' => 'Automatische Trapverlichting', 'translations' => ['en' => ['title' => 'Automatic Stair Lighting']]]);

    app()->setLocale('en');

    expect($project->titleParts())->toBe(['lead' => 'Automatic Stair ', 'accent' => 'Lighting']);

    app()->setLocale('nl');
});
