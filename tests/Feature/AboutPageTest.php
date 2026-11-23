<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the about page in dutch by default', function () {
    $this->get('/over-mij')
        ->assertOk()
        ->assertSee('lang="nl"', false)
        ->assertSee('Wie Ik')
        ->assertSee('Mijn Werk met')
        ->assertSee('Neem Contact Met Mij')
        ->assertSee('Smart Garden');
});

it('renders the about page in english when the locale cookie is set', function () {
    $this->withUnencryptedCookie('locale', 'en')
        ->get(route('en.about'))
        ->assertOk()
        ->assertSee('lang="en"', false)
        ->assertSee('Who I')
        ->assertSee('My Work with')
        ->assertSee('Send message');
});

it('opens the external project links in a new tab', function () {
    $html = $this->get(route('about'))->assertOk()->getContent();

    preg_match_all('/<a class="about-accordion__link"[^>]*target="_blank" rel="noopener noreferrer"/', $html, $matches);

    expect($matches[0])->toHaveCount(11);
});

it('marks only the about link as the current page', function () {
    $html = $this->get(route('about'))->assertOk()->getContent();

    expect(substr_count($html, 'site-nav__link--menu-active'))->toBe(1)
        ->and($html)->toContain('aria-current="page"')
        ->and($html)->toContain('href="'.route('about').'"');
});
