<?php

namespace App\Http\Controllers;

use App\Actions\GetProjectDetail;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectDetailController extends Controller
{
    /**
     * Shows one project. The language preference is mirrored in a cookie by the frontend.
     */
    public function __invoke(Request $request, Project $project, GetProjectDetail $getProjectDetail): View
    {
        app()->setLocale($request->cookie('locale') === 'en' ? 'en' : 'nl');

        return view('project-detail', [
            'project' => $getProjectDetail->handle($project),
        ]);
    }
}
