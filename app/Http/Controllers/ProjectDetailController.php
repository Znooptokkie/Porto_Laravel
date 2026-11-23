<?php

namespace App\Http\Controllers;

use App\Actions\GetProjectDetail;
use App\Models\Project;
use Illuminate\Contracts\View\View;

class ProjectDetailController extends Controller
{
    /**
     * Shows one project. The locale is set by the SetPageLocale middleware.
     */
    public function __invoke(Project $project, GetProjectDetail $getProjectDetail): View
    {
        return view('project-detail', [
            'project' => $getProjectDetail->handle($project),
        ]);
    }
}
