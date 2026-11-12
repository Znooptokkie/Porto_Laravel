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

it('keeps the title text before the accent for the detail heading', function () {
    expect((new Project(['title' => 'Battlebot', 'title_accent' => 'bot']))->titleLead())->toBe('Battle')
        ->and((new Project(['title' => 'Zinra', 'title_accent' => null]))->titleLead())->toBe('Zinra');
});
