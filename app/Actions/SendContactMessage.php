<?php

namespace App\Actions;

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;

class SendContactMessage
{
    /**
     * Sends a contact form submission to the address configured in config/portfolio.php.
     *
     * @param  array{name: string, email: string, message: string}  $data
     */
    public function handle(array $data): void
    {
        Mail::to(config('portfolio.links.email'))->send(
            new ContactMessage($data['name'], $data['email'], $data['message']),
        );
    }
}
