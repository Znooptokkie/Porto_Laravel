<?php

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the homepage with the first ten skills ordered by id', function () {
    $skills = Skill::factory()->count(12)->sequence(fn ($sequence) => ['name' => 'Skill '.($sequence->index + 1)])->create();

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSeeInOrder(['Skill 1', 'Skill 2', 'Skill 3']);
    $response->assertSee('Skill 10');
    $response->assertDontSee('Skill 11');
    $response->assertDontSee('Skill 12');
    expect($skills)->toHaveCount(12);
});

it('renders the homepage without skills', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Mijn Programmeer');
});

it('does not render placeholder text in the section headings', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertDontSee('{ }', false);
});

it('renders the stage cards in timeline step 04', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Webprepare')
        ->assertSee('Battlebot');
});

it('renders dutch by default and english when the locale cookie is set', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('lang="nl"', false)
        ->assertSee('Tijdlijn');

    $this->withUnencryptedCookie('locale', 'en')
        ->get(route('home'))
        ->assertOk()
        ->assertSee('lang="en"', false)
        ->assertSee('Timeline');
});

it('does not show the figma stats row while its figures are unconfirmed', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertDontSee('Leetcode Opgelost', false);
});

it('shows the email icon without a link while no email address is configured', function () {
    config(['portfolio.links.email' => null]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('<span class="social-link" aria-hidden="true">', false)
        ->assertSee('themed-image__light', false)
        ->assertDontSee('mailto:', false);
});

it('links the email icon with mailto when an email address is configured', function () {
    config(['portfolio.links.email' => 'test@example.com']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('href="mailto:test@example.com"', false);
});

it('renders one timeline step with a milestone dot (light and dark image) for each of the five chapters', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect(substr_count($html, 'class="timeline-chapter"'))->toBe(5)
        ->and(substr_count($html, 'class="timeline-chapter__marker"'))->toBe(5);
    expect(substr_count($html, 'timeline-chapter__dot'))->toBe(10);
});
