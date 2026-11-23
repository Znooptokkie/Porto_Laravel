<?php

use App\Mail\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('sends the contact message to the configured address with the visitor as reply-to', function () {
    Mail::fake();

    $this->post(route('about.contact'), [
        'name' => 'Jan Bezoeker',
        'email' => 'jan@example.com',
        'message' => 'Hallo, mooi portfolio!',
    ])
        ->assertRedirect(route('about').'#about-contact')
        ->assertSessionHas('contactStatus', 'sent');

    Mail::assertSent(ContactMessage::class, function (ContactMessage $mail) {
        return $mail->hasTo(config('portfolio.links.email'))
            && $mail->hasReplyTo('jan@example.com')
            && $mail->senderName === 'Jan Bezoeker'
            && $mail->body === 'Hallo, mooi portfolio!';
    });
});

it('sends nothing when the honeypot field is filled in, but still confirms', function () {
    Mail::fake();

    $this->post(route('about.contact'), [
        'name' => 'Bot',
        'email' => 'bot@example.com',
        'message' => 'Spam',
        'website' => 'https://spam.example',
    ])
        ->assertRedirect(route('about').'#about-contact')
        ->assertSessionHas('contactStatus', 'sent');

    Mail::assertNothingSent();
});

it('rejects an empty submission without sending a message', function () {
    Mail::fake();

    $this->post(route('about.contact'), [])
        ->assertSessionHasErrors(['name', 'email', 'message']);

    Mail::assertNothingSent();
});

it('rejects an invalid email address', function () {
    Mail::fake();

    $this->post(route('about.contact'), [
        'name' => 'Jan',
        'email' => 'geen-mail',
        'message' => 'Test',
    ])->assertSessionHasErrors(['email']);

    Mail::assertNothingSent();
});

it('shows the english validation messages when the locale cookie is set', function () {
    $this->withUnencryptedCookie('locale', 'en')
        ->post(route('en.about.contact'), [])
        ->assertSessionHasErrors(['name' => 'Please enter your name.']);
});

it('shows the confirmation on the about page after sending', function () {
    Mail::fake();

    $this->followingRedirects()
        ->post(route('about.contact'), [
            'name' => 'Jan',
            'email' => 'jan@example.com',
            'message' => 'Test',
        ])
        ->assertOk()
        ->assertSee('Bedankt! Je bericht is verstuurd.');
});
