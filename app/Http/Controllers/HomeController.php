<?php

namespace App\Http\Controllers;

use App\Actions\GetHomeSkills;
use App\Actions\GetLeetcodeProblemCount;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Shows the homepage. The locale is set by the SetPageLocale middleware.
     */
    public function __invoke(GetHomeSkills $getHomeSkills, GetLeetcodeProblemCount $getLeetcodeProblemCount): View
    {
        return view('home', [
            'skills' => $getHomeSkills->handle(),
            'leetcodeProblemCount' => $getLeetcodeProblemCount->handle(),
        ]);
    }
}
