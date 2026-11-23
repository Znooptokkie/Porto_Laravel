<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    /**
     * Shows the about-me page. The locale is set by the SetPageLocale middleware.
     */
    public function __invoke(): View
    {
        return view('about');
    }
}
