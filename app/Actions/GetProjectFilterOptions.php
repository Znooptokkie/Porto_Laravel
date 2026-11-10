<?php

namespace App\Actions;

use App\Enums\TechnologyKind;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Collection;

class GetProjectFilterOptions
{
    /**
     * Returns the choices for every filter group, all read from the database so new projects add new options.
     *
     * @return array{years: list<int>, languages: Collection<int, Technology>, frameworks: Collection<int, Technology>, types: Collection<int, ProjectType>}
     */
    public function handle(): array
    {
        return [
            'years' => $this->yearsCovered(),
            'languages' => $this->technologiesOfKind(TechnologyKind::Language),
            'frameworks' => $this->technologiesOfKind(TechnologyKind::Framework),
            'types' => ProjectType::query()->whereHas('projects')->orderBy('name')->get(),
        ];
    }

    /**
     * Every year from the earliest start year up to the latest end year (or start year when a project has no end year).
     *
     * @return list<int>
     */
    private function yearsCovered(): array
    {
        $ranges = Project::query()->get(['started_year', 'ended_year']);

        if ($ranges->isEmpty()) {
            return [];
        }

        $first = (int) $ranges->min('started_year');
        $last = (int) $ranges->map(fn (Project $project): int => $project->ended_year ?? $project->started_year)->max();

        return range($first, $last);
    }

    /**
     * @return Collection<int, Technology>
     */
    private function technologiesOfKind(TechnologyKind $kind): Collection
    {
        return Technology::query()
            ->where('kind', $kind->value)
            ->whereHas('cardProjects')
            ->orderBy('name')
            ->get();
    }
}
