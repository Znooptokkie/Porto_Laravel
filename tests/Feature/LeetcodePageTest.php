<?php

use App\Enums\LeetcodeConceptType;
use App\Enums\LeetcodeDifficulty;
use App\Models\LeetcodeConcept;
use App\Models\LeetcodeProblem;
use Database\Seeders\LeetcodeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

uses(RefreshDatabase::class);

/**
 * @param  array<int, array{type: LeetcodeConceptType, name: string}>  $concepts
 */
function leetcodeProblemUsing(array $concepts, array $attributes = []): LeetcodeProblem
{
    $problem = LeetcodeProblem::factory()->create($attributes);

    foreach ($concepts as $concept) {
        $problem->concepts()->attach(LeetcodeConcept::factory()->create($concept));
    }

    return $problem;
}

/**
 * The problems of every group, in the order they are shown.
 *
 * @param  array{groups: array<int, array{number: int, languages: array<string, Collection<int, LeetcodeProblem>>}>}  $overview
 * @return Collection<int, LeetcodeProblem>
 */
function leetcodeProblemsOf(array $overview): Collection
{
    return collect($overview['groups'])->flatMap(
        fn (array $group): array => collect($group['languages'])->flatMap(fn (Collection $problems): array => $problems->all())->all(),
    );
}

it('shows the stored problems with a solution, the concepts and a link to the problem', function () {
    leetcodeProblemUsing(
        [['type' => LeetcodeConceptType::Function, 'name' => 'len()']],
        ['name' => 'Two Sum', 'url' => 'https://leetcode.com/problems/two-sum/', 'language' => 'python', 'code' => 'return sum(nums)'],
    );

    $this->get(route('leetcode'))
        ->assertOk()
        ->assertSee('Two Sum')
        ->assertSee('class="language-python"', false)
        ->assertSee('href="https://leetcode.com/problems/two-sum/"', false)
        ->assertSee('return sum(nums)')
        ->assertSee('len()')
        ->assertSee('data-leetcode-list', false);
});

it('highlights the solution with the Prism class of its language, including TypeScript', function () {
    leetcodeProblemUsing([], ['language' => 'typescript', 'code' => 'const total = 1;']);

    $this->get(route('leetcode'))
        ->assertOk()
        ->assertSee('class="language-typescript"', false);
});

it('shows a problem with a Dutch difficulty label and the matching icon', function () {
    leetcodeProblemUsing([], ['difficulty' => LeetcodeDifficulty::Medium]);

    $this->get(route('leetcode'))
        ->assertOk()
        ->assertSee('Medium')
        ->assertSee('leetcode-card__difficulty-icon', false)
        ->assertSee('difficulty-inner-shadow', false);
});

it('shows one tab per language when the same problem number is solved in several languages', function () {
    leetcodeProblemUsing([], ['problem_number' => 42, 'language' => 'python']);
    leetcodeProblemUsing([], ['problem_number' => 42, 'language' => 'typescript']);

    $response = $this->get(route('leetcode'))
        ->assertOk()
        ->assertSee('role="tablist"', false)
        ->assertSee('data-leetcode-tab', false)
        ->assertSee('Typescript');

    expect(substr_count($response->getContent(), 'role="tab"'))->toBe(2)
        ->and(substr_count($response->getContent(), 'role="tabpanel"'))->toBe(2);
});

it('shows the solutions of one problem number without tabs when they use the same language', function () {
    leetcodeProblemUsing([], ['problem_number' => 42, 'name' => 'First submission']);
    leetcodeProblemUsing([], ['problem_number' => 42, 'name' => 'Second submission']);

    $this->get(route('leetcode'))
        ->assertOk()
        ->assertSee('First submission')
        ->assertSee('Second submission')
        ->assertDontSee('role="tablist"', false);
});

it('hides a concept group that the problem does not use', function () {
    leetcodeProblemUsing([['type' => LeetcodeConceptType::Function, 'name' => 'len()']]);

    $this->get(route('leetcode'))
        ->assertOk()
        ->assertSee('Functions:')
        ->assertDontSee('Algorithms:');
});

it('finds problems by a function, method, operator, data structure, control structure or algorithm', function () {
    leetcodeProblemUsing([['type' => LeetcodeConceptType::Method, 'name' => '.reverse()']]);
    leetcodeProblemUsing([['type' => LeetcodeConceptType::Operator, 'name' => 'bitwise XOR (^)']]);
    leetcodeProblemUsing([['type' => LeetcodeConceptType::DataStructure, 'name' => 'list']]);
    leetcodeProblemUsing([['type' => LeetcodeConceptType::ControlStructure, 'name' => 'nested loop']]);
    leetcodeProblemUsing([['type' => LeetcodeConceptType::Algorithm, 'name' => 'Sliding Window']]);

    foreach (['reverse', 'XOR', 'list', 'nested loop', 'sliding window'] as $term) {
        $problems = leetcodeProblemsOf($this->get(route('leetcode', ['q' => $term]))->assertOk()->viewData('overview'));

        expect($problems)->toHaveCount(1, "Zoekterm [{$term}] moet precies één probleem vinden");
    }
});

it('finds problems by a part of their name', function () {
    leetcodeProblemUsing([], ['name' => 'Two Sum']);
    leetcodeProblemUsing([], ['name' => 'Valid Parentheses']);

    $problems = leetcodeProblemsOf($this->get(route('leetcode', ['q' => 'parenth']))->assertOk()->viewData('overview'));

    expect($problems)->toHaveCount(1)
        ->and($problems[0]->name)->toBe('Valid Parentheses');
});

it('returns no problems when the search term matches no concept', function () {
    leetcodeProblemUsing([['type' => LeetcodeConceptType::Function, 'name' => 'len()']]);

    $this->get(route('leetcode', ['q' => 'geen-match']))
        ->assertOk()
        ->assertSee('Er zijn geen problemen die aan deze filters voldoen.')
        ->assertViewHas('overview', fn (array $overview): bool => $overview['groups'] === []);
});

it('filters the problems on difficulty', function () {
    leetcodeProblemUsing([], ['difficulty' => LeetcodeDifficulty::Easy]);
    leetcodeProblemUsing([], ['difficulty' => LeetcodeDifficulty::Hard]);

    $problems = leetcodeProblemsOf($this->get(route('leetcode', ['difficulties' => ['easy']]))->assertOk()->viewData('overview'));

    expect($problems)->toHaveCount(1)
        ->and($problems->first()->difficulty)->toBe(LeetcodeDifficulty::Easy);
});

it('sorts the problems on rating in the requested direction', function () {
    leetcodeProblemUsing([], ['rating' => 2]);
    leetcodeProblemUsing([], ['rating' => 5]);
    leetcodeProblemUsing([], ['rating' => 1]);

    $ratings = leetcodeProblemsOf($this->get(route('leetcode', ['rating' => 'desc']))->assertOk()->viewData('overview'))
        ->pluck('rating')
        ->all();

    expect($ratings)->toBe([5, 2, 1]);
});

it('filters on the chosen languages, where JavaScript covers TypeScript too', function () {
    leetcodeProblemUsing([], ['language' => 'python', 'problem_number' => 1]);
    leetcodeProblemUsing([], ['language' => 'typescript', 'problem_number' => 2]);
    leetcodeProblemUsing([], ['language' => 'php', 'problem_number' => 3]);

    $problems = leetcodeProblemsOf($this->get(route('leetcode', ['languages' => ['javascript']]))->assertOk()->viewData('overview'));

    expect($problems->pluck('language')->all())->toBe(['typescript']);
});

it('filters on a rating range, both bounds included', function () {
    leetcodeProblemUsing([], ['rating' => 1]);
    leetcodeProblemUsing([], ['rating' => 3]);
    leetcodeProblemUsing([], ['rating' => 4]);

    $ratings = leetcodeProblemsOf($this->get(route('leetcode', ['rating' => '2-3']))->assertOk()->viewData('overview'))
        ->pluck('rating')
        ->all();

    expect($ratings)->toBe([3]);
});

it('filters on a runtime percentage band', function () {
    leetcodeProblemUsing([], ['runtime_percentage' => 40]);
    leetcodeProblemUsing([], ['runtime_percentage' => 90]);

    $percentages = leetcodeProblemsOf($this->get(route('leetcode', ['runtime' => 'above-85']))->assertOk()->viewData('overview'))
        ->pluck('runtime_percentage')
        ->map(fn (string $percentage): float => (float) $percentage)
        ->all();

    expect($percentages)->toBe([90.0]);
});

it('sorts on the memory percentage when that option is chosen', function () {
    leetcodeProblemUsing([], ['memory_percentage' => 70]);
    leetcodeProblemUsing([], ['memory_percentage' => 20]);

    $percentages = leetcodeProblemsOf($this->get(route('leetcode', ['memory' => 'asc-percentage']))->assertOk()->viewData('overview'))
        ->pluck('memory_percentage')
        ->map(fn (string $percentage): float => (float) $percentage)
        ->all();

    expect($percentages)->toBe([20.0, 70.0]);
});

it('shows how many problems the filters found, with the number in the accent span', function () {
    leetcodeProblemUsing([], ['problem_number' => 1]);
    leetcodeProblemUsing([], ['problem_number' => 2, 'name' => 'Valid Parentheses']);

    $this->get(route('leetcode'))
        ->assertSeeHtml('<p class="results-count" data-project-count hidden>');

    $this->get(route('leetcode', ['q' => 'parenth']))
        ->assertSeeHtml('<p class="results-count" data-project-count>Er is <span class="results-count__number">1</span> probleem gevonden.</p>');

    $this->get(route('leetcode', ['q' => 'geen-match']))
        ->assertSeeHtml('Er zijn geen problemen gevonden.');
});

it('shows ten problem numbers per page and links the sentinel to the next page', function () {
    foreach (range(1, 12) as $number) {
        leetcodeProblemUsing([], ['problem_number' => $number]);
    }

    $first = $this->get(route('leetcode'))->assertOk();
    $firstOverview = $first->viewData('overview');

    expect($firstOverview['groups'])->toHaveCount(10)
        ->and($firstOverview['hasMorePages'])->toBeTrue()
        ->and($firstOverview['count'])->toBe(12);

    $first->assertSeeHtml('data-leetcode-more data-next-page-url="'.route('leetcode', ['page' => 2]).'"')
        ->assertSeeHtml('<span class="leetcode-list__spinner" aria-hidden="true"></span>');

    $second = $this->get(route('leetcode', ['page' => 2]))->assertOk();
    $secondOverview = $second->viewData('overview');

    expect($secondOverview['groups'])->toHaveCount(2)
        ->and($secondOverview['hasMorePages'])->toBeFalse()
        ->and(collect($secondOverview['groups'])->pluck('number')->all())->toBe([11, 12]);

    $second->assertDontSeeHtml('data-leetcode-more');
});

it('numbers the cards of later pages on from the first page so their ids stay unique', function () {
    foreach (range(1, 11) as $number) {
        leetcodeProblemUsing([], ['problem_number' => $number]);
    }

    $this->get(route('leetcode', ['page' => 2]))
        ->assertOk()
        ->assertSee('id="leetcode-problem-11-0-0-title"', false)
        ->assertDontSee('id="leetcode-problem-1-0-0-title"', false);
});

it('does not count the page as an active filter', function () {
    leetcodeProblemUsing([], ['problem_number' => 1]);

    $this->get(route('leetcode', ['page' => 1]))
        ->assertSeeHtml('<p class="results-count" data-project-count hidden>');
});

it('rejects a filter value that is not one of the options', function () {
    $this->get(route('leetcode', ['rating' => '10-11', 'runtime' => 'sideways', 'languages' => ['cobol']]))
        ->assertSessionHasErrors(['rating', 'runtime', 'languages.0']);
});

it('shows the problems in ascending problem number when no sort is chosen', function () {
    leetcodeProblemUsing([], ['problem_number' => 30]);
    leetcodeProblemUsing([], ['problem_number' => 10]);
    leetcodeProblemUsing([], ['problem_number' => 20]);

    $numbers = leetcodeProblemsOf($this->get(route('leetcode'))->assertOk()->viewData('overview'))
        ->pluck('problem_number')
        ->all();

    expect($numbers)->toBe([10, 20, 30]);
});

it('colours a percentage red below 50, orange up to 85 and green above 85', function () {
    expect(LeetcodeProblem::percentageTone(49.99))->toBe('negative')
        ->and(LeetcodeProblem::percentageTone(50))->toBe('warning')
        ->and(LeetcodeProblem::percentageTone(85))->toBe('warning')
        ->and(LeetcodeProblem::percentageTone(85.01))->toBe('positive');
});

it('applies the percentage colour to the runtime and memory percentage', function () {
    leetcodeProblemUsing([], ['runtime_percentage' => 10, 'memory_percentage' => 90]);

    $this->get(route('leetcode'))
        ->assertOk()
        ->assertSee('leetcode-metric__value--negative', false)
        ->assertSee('leetcode-metric__value--positive', false);
});

it('rejects a search term that is too long', function () {
    $this->get(route('leetcode', ['q' => str_repeat('a', 101)]))
        ->assertSessionHasErrors('q');
});

it('imports every problem and concept link from the migration fixture', function () {
    $this->seed(LeetcodeSeeder::class);

    expect(LeetcodeProblem::query()->count())->toBe(87)
        ->and(LeetcodeProblem::query()->distinct()->count('problem_number'))->toBe(87)
        ->and(LeetcodeConcept::query()->count())->toBe(77)
        ->and(LeetcodeProblem::query()->whereHas('concepts')->count())->toBe(84);
});
