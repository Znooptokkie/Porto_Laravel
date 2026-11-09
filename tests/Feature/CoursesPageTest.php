<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the education page in dutch by default', function () {
    $this->get(route('courses'))
        ->assertOk()
        ->assertSee('lang="nl"', false)
        ->assertSee('Mijn')
        ->assertSee('MBO 4 - Software Development')
        ->assertSee('Onderzoek Kunstmatige Intelligentie (AI)');
});

it('renders the education page in english when the locale cookie is set', function () {
    $this->withUnencryptedCookie('locale', 'en')
        ->get(route('courses'))
        ->assertOk()
        ->assertSee('lang="en"', false)
        ->assertSee('Certificates</span>', false)
        ->assertSee('MBO 2 - Assistant Painter');
});

it('marks only the education link as the current page', function () {
    $html = $this->get(route('courses'))->assertOk()->getContent();

    expect(substr_count($html, 'site-nav__link--menu-active'))->toBe(1)
        ->and($html)->toContain('aria-current="page"');
});

it('does not mark a menu link as the current page on the homepage', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)->not->toContain('site-nav__link--menu-active')
        ->and($html)->not->toContain('aria-current="page"')
        ->and($html)->toContain('href="'.route('courses').'"');
});
