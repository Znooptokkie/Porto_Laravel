<?php

namespace App\Actions;

use App\Models\Project;

class GetProjectDetail
{
    /**
     * Loads every relation the project detail page needs in one go, so the page does not query per section.
     */
    public function handle(Project $project): Project
    {
        return $project->load([
            'images',
            'chapters',
            'components',
            'contributors',
            'detailTechnologies',
        ]);
    }
}
