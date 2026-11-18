<?php

namespace App\Actions;

use App\Enums\LeetcodeLanguageFilter;
use App\Enums\LeetcodeMetricFilter;
use App\Enums\LeetcodeRatingFilter;
use App\Models\LeetcodeProblem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetLeetcodeOverview
{
    /**
     * The number of problem numbers shown per page; the next page is loaded when the visitor reaches the bottom.
     */
    public const int PAGE_SIZE = 10;

    /**
     * Returns one page of problem groups, searched, filtered and sorted by the validated query string. A page holds
     * PAGE_SIZE problem numbers; the first query only reads ids and numbers, so the code and concepts are loaded for
     * the page that is shown. Problems with the same number are grouped, and each group is split per programming
     * language so the page can show one tab per language.
     *
     * @param  array{q?: string|null, languages?: array<int, string>|null, difficulties?: array<int, string>|null, rating?: string|null, runtime?: string|null, memory?: string|null, page?: int|string|null}  $filters
     * @return array{groups: list<array{number: int, languages: array<string, Collection<int, LeetcodeProblem>>}>, count: int, page: int, offset: int, hasMorePages: bool}
     */
    public function handle(array $filters): array
    {
        $matching = $this->matchingProblems($filters);

        $numbers = $this->applySorting(clone $matching, $filters)
            ->get(['id', 'problem_number'])
            ->pluck('problem_number')
            ->unique()
            ->values();

        $page = max(1, (int) ($filters['page'] ?? 1));
        $pageNumbers = $numbers->forPage($page, self::PAGE_SIZE)->all();

        $problems = $this->applySorting(clone $matching, $filters)
            ->with('concepts')
            ->whereIn('problem_number', $pageNumbers)
            ->get();

        return [
            'groups' => $this->groupByNumberAndLanguage($problems),
            'count' => $numbers->count(),
            'page' => $page,
            'offset' => ($page - 1) * self::PAGE_SIZE,
            'hasMorePages' => $numbers->count() > $page * self::PAGE_SIZE,
        ];
    }

    /**
     * @param  array{q?: string|null, languages?: array<int, string>|null, difficulties?: array<int, string>|null, rating?: string|null, runtime?: string|null, memory?: string|null}  $filters
     * @return Builder<LeetcodeProblem>
     */
    private function matchingProblems(array $filters): Builder
    {
        return LeetcodeProblem::query()
            ->when(filled($filters['q'] ?? null), fn (Builder $query) => $query->where(
                fn (Builder $match) => $match
                    ->whereLike('name', '%'.$filters['q'].'%')
                    ->orWhereHas('concepts', fn (Builder $concepts) => $concepts->whereLike('name', '%'.$filters['q'].'%')),
            ))
            ->when($filters['languages'] ?? [], fn (Builder $query, array $languages) => $query->whereIn('language', $this->databaseLanguages($languages)))
            ->when($filters['difficulties'] ?? [], fn (Builder $query, array $difficulties) => $query->whereIn('difficulty', $difficulties))
            ->when($this->ratingRange($filters), fn (Builder $query, array $range) => $query->whereBetween('rating', $range))
            ->when($this->percentageCondition($filters, 'runtime'), fn (Builder $query, array $condition) => $query->where('runtime_percentage', $condition['operator'], $condition['value']))
            ->when($this->percentageCondition($filters, 'memory'), fn (Builder $query, array $condition) => $query->where('memory_percentage', $condition['operator'], $condition['value']));
    }

    /**
     * The stored languages of the chosen language options, such as typescript and javascript for JavaScript/TypeScript.
     *
     * @param  array<int, string>  $languages
     * @return list<string>
     */
    private function databaseLanguages(array $languages): array
    {
        return collect($languages)
            ->flatMap(fn (string $language): array => LeetcodeLanguageFilter::tryFrom($language)?->databaseLanguages() ?? [])
            ->values()
            ->all();
    }

    /**
     * @param  array{rating?: string|null}  $filters
     * @return array{0: int, 1: int}|null
     */
    private function ratingRange(array $filters): ?array
    {
        return LeetcodeRatingFilter::tryFrom($filters['rating'] ?? '')?->range();
    }

    /**
     * @param  array{runtime?: string|null, memory?: string|null}  $filters
     * @return array{operator: string, value: int}|null
     */
    private function percentageCondition(array $filters, string $key): ?array
    {
        return LeetcodeMetricFilter::tryFrom($filters[$key] ?? '')?->percentageCondition();
    }

    /**
     * Keeps the order of the sorted problems: a group sits where its first problem sits.
     *
     * @param  Collection<int, LeetcodeProblem>  $problems
     * @return list<array{number: int, languages: array<string, Collection<int, LeetcodeProblem>>}>
     */
    private function groupByNumberAndLanguage(Collection $problems): array
    {
        return $problems
            ->groupBy('problem_number')
            ->map(fn (Collection $sameNumber): array => [
                'number' => $sameNumber->first()->problem_number,
                'languages' => $sameNumber->groupBy('language')->all(),
            ])
            ->values()
            ->all();
    }

    /**
     * Only one sort applies: the first of rating, runtime or memory that has an ascending or descending option.
     *
     * @param  Builder<LeetcodeProblem>  $query
     * @param  array{rating?: string|null, runtime?: string|null, memory?: string|null}  $filters
     * @return Builder<LeetcodeProblem>
     */
    private function applySorting(Builder $query, array $filters): Builder
    {
        $sort = $this->sortOf($filters);

        if ($sort === null) {
            return $query->orderBy('problem_number')->orderBy('id');
        }

        return $query
            ->orderBy($sort['column'], $sort['direction'])
            ->orderBy('problem_number')
            ->orderBy('id');
    }

    /**
     * @param  array{rating?: string|null, runtime?: string|null, memory?: string|null}  $filters
     * @return array{column: string, direction: string}|null
     */
    private function sortOf(array $filters): ?array
    {
        $ratingDirection = LeetcodeRatingFilter::tryFrom($filters['rating'] ?? '')?->sortDirection();

        if ($ratingDirection !== null) {
            return ['column' => 'rating', 'direction' => $ratingDirection];
        }

        foreach (['runtime' => ['runtime_ms', 'runtime_percentage'], 'memory' => ['memory_mb', 'memory_percentage']] as $key => [$column, $percentageColumn]) {
            $metric = LeetcodeMetricFilter::tryFrom($filters[$key] ?? '');
            $direction = $metric?->sortDirection();

            if ($direction !== null) {
                return ['column' => $metric->isPercentage() ? $percentageColumn : $column, 'direction' => $direction];
            }
        }

        return null;
    }
}
