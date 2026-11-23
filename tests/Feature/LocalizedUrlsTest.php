<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('serves the english pages on english urls and the dutch pages on dutch urls', function () {
    $this->get('/projects')->assertOk()->assertSee('lang="en"', false);
    $this->get('/about-me')->assertOk()->assertSee('lang="en"', false);
    $this->get('/courses')->assertOk()->assertSee('lang="en"', false);
    $this->get('/projecten')->assertOk()->assertSee('lang="nl"', false);
    $this->get('/over-mij')->assertOk()->assertSee('lang="nl"', false);
    $this->get('/opleidingen')->assertOk()->assertSee('lang="nl"', false);
});

it('links to the english urls from an english page', function () {
    $html = $this->get('/projects')->assertOk()->getContent();

    expect($html)->toContain('href="'.url('/projects').'"')
        ->toContain('href="'.url('/about-me').'"')
        ->toContain('href="'.url('/courses').'"')
        ->not->toContain('href="'.url('/projecten').'"');
});

it('links to the dutch urls from a dutch page', function () {
    $html = $this->get('/projecten')->assertOk()->getContent();

    expect($html)->toContain('href="'.url('/projecten').'"')
        ->toContain('href="'.url('/over-mij').'"')
        ->not->toContain('href="'.url('/projects').'"');
});

it('points the language options at the same page in the other language', function () {
    expect($this->get('/projecten')->getContent())
        ->toContain('data-locale-option="en" data-locale-url="'.url('/projects').'"')
        ->toContain('data-locale-option="nl" data-locale-url="'.url('/projecten').'"');

    expect($this->get('/projects')->getContent())
        ->toContain('data-locale-option="nl" data-locale-url="'.url('/projecten').'"');
});

it('keeps the query string when switching language on a page that shares its url', function () {
    $html = $this->get('/leetcode?keyword=arrays')->assertOk()->getContent();

    expect($html)->toContain('data-locale-option="en" data-locale-url="'.url('/leetcode?keyword=arrays').'"');
});

it('keeps the english project detail url with its slug when switching language', function () {
    $project = Project::factory()->create(['title' => 'Smart Garden']);

    expect($this->get(route('en.projects.show', $project))->assertOk()->getContent())
        ->toContain('data-locale-url="'.url('/projecten/'.$project->slug).'"');
});

it('builds project links in the english url scheme on the english overview', function () {
    $project = Project::factory()->create(['title' => 'Smart Garden']);

    expect($this->get('/projects')->assertOk()->getContent())
        ->toContain('href="'.url('/projects/'.$project->slug).'"');
});

it('remembers the locale of the last localized page for the shared homepage', function () {
    $cookies = collect($this->get('/projects')->baseResponse->headers->getCookies())->keyBy(fn ($cookie) => $cookie->getName());

    expect($cookies['locale']->getValue())->toBe('en')
        ->and($cookies['locale']->isHttpOnly())->toBeFalse();

    expect($this->withUnencryptedCookie('locale', 'en')->get('/')->assertOk()->getContent())
        ->toContain('lang="en"');
});

it('sends the english contact form to the english url and returns there', function () {
    $this->post('/about-me/contact', [
        'name' => 'Jan Bezoeker',
        'email' => 'jan@example.com',
        'message' => 'Hello there!',
    ])->assertRedirect(url('/about-me').'#about-contact');
});
