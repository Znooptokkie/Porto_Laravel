<?php

namespace App\Http\Controllers;

use App\Actions\SendContactMessage;
use App\Http\Middleware\SetPageLocale;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Stores a contact form submission and sends it, then returns to the about page.
     * A filled honeypot field means a bot: nothing is sent, but the bot gets the same confirmation.
     */
    public function __invoke(ContactRequest $request, SendContactMessage $sendContactMessage): RedirectResponse
    {
        if (! $request->filled('website')) {
            $sendContactMessage->handle($request->validated());
        }

        return redirect(SetPageLocale::url('about').'#about-contact')->with('contactStatus', 'sent');
    }
}
