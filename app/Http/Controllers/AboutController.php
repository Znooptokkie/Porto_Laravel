<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Shows the about-me page. The language preference is mirrored in a cookie by the frontend.
     */
    public function __invoke(Request $request): View
    {
        app()->setLocale($request->cookie('locale') === 'en' ? 'en' : 'nl');

        return view('about');
    }
}
