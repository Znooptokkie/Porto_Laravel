<?php

namespace App\Actions;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetProjectsOverview
{
    /**
     * Returns the projects for the overview, filtered and sorted by the validated query string, plus the total count
     * that the page heading and the card numbers use. Filters within one group combine with OR; groups combine with AND.
     *
     * @param  array{year_sort?: string|null, years?: array<int, int>|null, languages?: array<int, int>|null, frameworks?: array<int, int>|null, alpha?: string|null, favorite?: string|null, types?: array<int, int>|null}  $filters
     * @return array{projects: Collection<int, Project>, total: int}
     */
    public function handle(array $filters): array
    {
        $projects = Project::query()
            ->with(['images', 'cardTechnologies'])
            ->when($filters['years'] ?? [], fn (Builder $query, array $years) => $this->whereActiveInYears($query, $years))
            ->when($filters['languages'] ?? [], fn (Builder $query, array $ids) => $query->whereHas('cardTechnologies', fn (Builder $technology) => $technology->whereKey($ids)))
            ->when($filters['frameworks'] ?? [], fn (Builder $query, array $ids) => $query->whereHas('cardTechnologies', fn (Builder $technology) => $technology->whereKey($ids)))
            ->when($filters['types'] ?? [], fn (Builder $query, array $ids) => $query->whereHas('projectTypes', fn (Builder $type) => $type->whereKey($ids)));

        $projects = $this->applySorting($projects, $filters);

        return [
            'projects' => $projects->get(),
            'total' => Project::query()->count(),
        ];
    }

    /**
     * @param  array<int, int>  $years
     */
    private function whereActiveInYears(Builder $query, array $years): void
    {
        $query->where(function (Builder $yearQuery) use ($years): void {
            foreach (array_map(intval(...), $years) as $year) {
                $yearQuery->orWhere(fn (Builder $range) => $range
                    ->where('started_year', '<=', $year)
                    ->whereRaw('coalesce(ended_year, started_year) >= ?', [$year]));
            }
        });
    }

    /**
     * Ranked projects come first, in the rank order the editor set: "most" (also the default) lists rank 1 upwards,
     * "least" lists the highest rank first. Projects without a rank always come last, in design order. An explicit
     * year or title sort replaces the default rank order, but not an explicit favourite choice.
     *
     * @param  array{year_sort?: string|null, alpha?: string|null, favorite?: string|null}  $filters
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    private function applySorting(Builder $query, array $filters): Builder
    {
        $favorite = $filters['favorite'] ?? null;
        $rankDirection = match (true) {
            $favorite === 'least' => 'desc',
            $favorite === 'most', $favorite === null && ! isset($filters['year_sort']) && ! isset($filters['alpha']) => 'asc',
            default => null,
        };

        return $query
            ->when($rankDirection !== null, fn (Builder $sorted) => $sorted->orderByRaw('favorite_rank is null')->orderBy('favorite_rank', $rankDirection))
            ->when(isset($filters['year_sort']), fn (Builder $sorted) => $sorted->orderBy('started_year', $filters['year_sort'] ?? 'asc'))
            ->when(isset($filters['alpha']), fn (Builder $sorted) => $sorted->orderBy('title', $filters['alpha'] ?? 'asc'))
            ->orderBy('sort_order');
    }
}
