<?php

namespace App\Http\Controllers;

use App\Actions\GetHomeSkills;
use App\Actions\GetLeetcodeProblemCount;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Shows the homepage. The language preference is mirrored in a cookie by the frontend.
     */
    public function __invoke(Request $request, GetHomeSkills $getHomeSkills, GetLeetcodeProblemCount $getLeetcodeProblemCount): View
    {
        $locale = $request->cookie('locale') === 'en' ? 'en' : 'nl';
        app()->setLocale($locale);

        return view('home', [
            'skills' => $getHomeSkills->handle(),
            'leetcodeProblemCount' => $getLeetcodeProblemCount->handle(),
        ]);
    }
}
