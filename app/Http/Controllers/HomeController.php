<?php

namespace App\Http\Controllers;

use App\Actions\GetHomeSkills;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Shows the homepage. The language preference is mirrored in a cookie by the frontend.
     */
    public function __invoke(Request $request, GetHomeSkills $getHomeSkills): View
    {
        $locale = $request->cookie('locale') === 'en' ? 'en' : 'nl';
        app()->setLocale($locale);

        return view('home', [
            'skills' => $getHomeSkills->handle(),
        ]);
    }
}
