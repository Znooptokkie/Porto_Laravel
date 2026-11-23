<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class CoursesController extends Controller
{
    /**
     * Shows the education page. The locale is set by the SetPageLocale middleware.
     */
    public function __invoke(): View
    {
        return view('courses');
    }
}
