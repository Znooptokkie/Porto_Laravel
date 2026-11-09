<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    /**
     * Shows the education page. The language preference is mirrored in a cookie by the frontend.
     */
    public function __invoke(Request $request): View
    {
        app()->setLocale($request->cookie('locale') === 'en' ? 'en' : 'nl');

        return view('courses');
    }
}
