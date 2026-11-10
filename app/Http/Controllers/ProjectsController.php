<?php

namespace App\Http\Controllers;

use App\Actions\GetProjectFilterOptions;
use App\Actions\GetProjectsOverview;
use App\Http\Requests\ProjectIndexRequest;
use Illuminate\Contracts\View\View;

class ProjectsController extends Controller
{
    /**
     * Shows the projects overview. Filters come from the query string; the language preference is mirrored in a cookie by the frontend.
     */
    public function __invoke(ProjectIndexRequest $request, GetProjectsOverview $getProjects, GetProjectFilterOptions $getFilterOptions): View
    {
        app()->setLocale($request->cookie('locale') === 'en' ? 'en' : 'nl');

        $filters = $request->validated();

        return view('projects', [
            'overview' => $getProjects->handle($filters),
            'filterOptions' => $getFilterOptions->handle(),
            'filters' => $filters,
        ]);
    }
}
