<?php

it('renders the not found page in dutch by default', function () {
    $this->get('/bestaat-niet')
        ->assertNotFound()
        ->assertSee('lang="nl"', false)
        ->assertSee('niet gevonden')
        ->assertSee('Naar de homepage')
        ->assertSee('Bekijk projecten');
});

it('renders the not found page in english when the locale cookie is set', function () {
    $this->withUnencryptedCookie('locale', 'en')
        ->get('/bestaat-niet')
        ->assertNotFound()
        ->assertSee('lang="en"', false)
        ->assertSee('not found')
        ->assertSee('Go to homepage')
        ->assertSee('View projects');
});

it('links the not found page back to the homepage', function () {
    $this->get('/bestaat-niet')
        ->assertNotFound()
        ->assertSee('href="'.route('home').'"', false);
});
