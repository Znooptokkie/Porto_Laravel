<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;
use App\Enums\TechnologyKind;
use App\Models\Contributor;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Technology;
use Database\Seeders\ProjectSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists the projects from the database with their status badges', function () {
    Project::factory()->withStatus(ProjectStatus::Klaar)->create(['title' => 'Alpha', 'sort_order' => 1]);
    Project::factory()->withStatus(ProjectStatus::Onvoltooid)->create(['title' => 'Bravo', 'sort_order' => 2]);

    $this->get(route('projects'))
        ->assertOk()
        ->assertSee('lang="nl"', false)
        ->assertSee('KLAAR')
        ->assertSee('ONVOLTOOID')
        ->assertSee('Alpha')
        ->assertSee('Bravo');
});

it('puts the ranked favourite first by default and orders the rest by design position', function () {
    Project::factory()->create(['title' => 'Eerste', 'sort_order' => 1]);
    Project::factory()->favorite()->create(['title' => 'Tweede', 'sort_order' => 2]);

    $default = $this->get(route('projects'))->assertOk()->viewData('overview')['projects']->pluck('title')->all();
    $favourite = $this->get(route('projects', ['favorite' => 'most']))->assertOk()->viewData('overview')['projects']->pluck('title')->all();

    expect($default)->toBe(['Tweede', 'Eerste'])
        ->and($favourite)->toBe(['Tweede', 'Eerste']);
});

it('keeps the year sort working when no favourite choice is made', function () {
    Project::factory()->create(['title' => 'Oud', 'started_year' => 2023, 'sort_order' => 1]);
    Project::factory()->favorite()->create(['title' => 'Nieuw', 'started_year' => 2025, 'sort_order' => 2]);

    $byYear = $this->get(route('projects', ['year_sort' => 'asc']))->viewData('overview')['projects']->pluck('title')->all();

    expect($byYear)->toBe(['Oud', 'Nieuw']);
});

it('sorts the favourites by their rank, with unranked projects last', function () {
    Project::factory()->create(['title' => 'Geen rang', 'sort_order' => 1]);
    Project::factory()->favorite(2)->create(['title' => 'Rang twee', 'sort_order' => 2]);
    Project::factory()->favorite(1)->create(['title' => 'Rang een', 'sort_order' => 3]);
    Project::factory()->favorite(3)->create(['title' => 'Rang drie', 'sort_order' => 4]);

    $default = $this->get(route('projects'))->viewData('overview')['projects']->pluck('title')->all();
    $most = $this->get(route('projects', ['favorite' => 'most']))->viewData('overview')['projects']->pluck('title')->all();
    $least = $this->get(route('projects', ['favorite' => 'least']))->viewData('overview')['projects']->pluck('title')->all();

    expect($default)->toBe(['Rang een', 'Rang twee', 'Rang drie', 'Geen rang'])
        ->and($most)->toBe(['Rang een', 'Rang twee', 'Rang drie', 'Geen rang'])
        ->and($least)->toBe(['Rang drie', 'Rang twee', 'Rang een', 'Geen rang']);
});

it('filters on a programming language and on a framework separately', function () {
    $php = Technology::factory()->create(['name' => 'PHP', 'kind' => TechnologyKind::Language]);
    $laravel = Technology::factory()->create(['name' => 'Laravel', 'kind' => TechnologyKind::Framework]);

    $withPhp = Project::factory()->create(['title' => 'Met PHP', 'sort_order' => 1]);
    $withPhp->technologies()->attach($php->id, ['placement' => 'card', 'sort_order' => 1]);
    $withPhp->technologies()->attach($laravel->id, ['placement' => 'card', 'sort_order' => 2]);

    $withoutPhp = Project::factory()->create(['title' => 'Zonder', 'sort_order' => 2]);

    $byLanguage = $this->get(route('projects', ['languages' => [$php->id]]))->viewData('overview')['projects']->pluck('title')->all();
    $byFramework = $this->get(route('projects', ['frameworks' => [$laravel->id]]))->viewData('overview')['projects']->pluck('title')->all();

    expect($byLanguage)->toBe(['Met PHP'])
        ->and($byFramework)->toBe(['Met PHP'])
        ->and($withoutPhp->title)->toBe('Zonder');
});

it('only counts a technology for filters when it is shown on the card', function () {
    $python = Technology::factory()->create(['name' => 'Python', 'kind' => TechnologyKind::Language]);
    $project = Project::factory()->create(['title' => 'Detail only', 'sort_order' => 1]);
    $project->technologies()->attach($python->id, ['placement' => 'detail', 'sort_order' => 1]);

    $result = $this->get(route('projects', ['languages' => [$python->id]]))->viewData('overview')['projects'];

    expect($result)->toHaveCount(0);
});

it('keeps projects whose year range covers the selected year', function () {
    $range = Project::factory()->create(['title' => 'Twee jaar', 'started_year' => 2024, 'ended_year' => 2025, 'sort_order' => 1]);
    $single = Project::factory()->create(['title' => 'Eén jaar', 'started_year' => 2026, 'ended_year' => null, 'sort_order' => 2]);

    $in2025 = $this->get(route('projects', ['years' => [2025]]))->viewData('overview')['projects']->pluck('title')->all();

    expect($in2025)->toBe(['Twee jaar'])
        ->and($range->id)->not->toBe($single->id);
});

it('sorts alphabetically and by year in both directions', function () {
    Project::factory()->create(['title' => 'Bravo', 'started_year' => 2023, 'sort_order' => 1]);
    Project::factory()->create(['title' => 'Alpha', 'started_year' => 2025, 'sort_order' => 2]);

    $alphabetical = $this->get(route('projects', ['alpha' => 'desc']))->viewData('overview')['projects']->pluck('title')->all();
    $byYear = $this->get(route('projects', ['year_sort' => 'asc']))->viewData('overview')['projects']->pluck('title')->all();

    expect($alphabetical)->toBe(['Bravo', 'Alpha'])
        ->and($byYear)->toBe(['Bravo', 'Alpha']);
});

it('filters on project types', function () {
    $robotics = ProjectType::factory()->create(['name' => 'Robotica']);
    $robot = Project::factory()->create(['title' => 'Robot', 'sort_order' => 1]);
    $robot->projectTypes()->attach($robotics);
    Project::factory()->create(['title' => 'Overig', 'sort_order' => 2]);

    $result = $this->get(route('projects', ['types' => [$robotics->id]]))->viewData('overview')['projects']->pluck('title')->all();

    expect($result)->toBe(['Robot']);
});

it('shows the chapters, specifications and contributors on the project page', function () {
    $project = Project::factory()->create(['title' => 'Battlebot', 'title_accent' => 'bot', 'slug' => 'battlebot', 'sort_order' => 1]);
    $project->chapters()->create(['title' => 'Introductie', 'paragraphs' => ['Eerste alinea.'], 'sort_order' => 1]);
    $project->components()->create(['group' => ProjectComponentGroup::Hardware, 'name' => 'Raspberry Pi 5', 'sort_order' => 1]);
    $contributor = Contributor::factory()->create(['name' => 'A. Oomen']);
    $project->contributors()->attach($contributor, ['role' => 'Development', 'sort_order' => 1]);

    $this->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('Introductie')
        ->assertSee('Eerste alinea.')
        ->assertSee('Raspberry Pi 5')
        ->assertSee('A. Oomen')
        ->assertSee('Battle<span>bot</span>', false)
        ->assertSee('01 / BATTLEBOT', false);
});

it('shows the slide number and the total number of images in the media counter', function () {
    $project = Project::factory()->create(['title' => 'Battlebot', 'title_accent' => 'bot', 'slug' => 'battlebot', 'sort_order' => 1]);
    $project->images()->createMany([
        ['path' => 'images/projects/placeholders/photo-1.webp', 'sort_order' => 1],
        ['path' => 'images/projects/placeholders/photo-1.webp', 'sort_order' => 2],
        ['path' => 'images/projects/placeholders/photo-1.webp', 'sort_order' => 3],
    ]);

    $this->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('<p class="project-media__counter" data-project-media-counter>01 / 03 - BATTLEBOT</p>', false);
});

it('shows the project title with the alt text of the current slide as caption', function () {
    $project = Project::factory()->create(['title' => 'Battlebot', 'slug' => 'battlebot', 'sort_order' => 1, 'story_lead' => 'Dit mag niet getoond worden']);
    $project->images()->createMany([
        ['path' => 'images/projects/placeholders/photo-1.webp', 'alt' => 'De robot in de arena', 'sort_order' => 1],
        ['path' => 'images/projects/placeholders/photo-1.webp', 'alt' => 'De sensoren op de voorkant', 'sort_order' => 2],
        ['path' => 'images/projects/placeholders/photo-1.webp', 'alt' => null, 'sort_order' => 3],
    ]);

    $this->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('<p class="project-media__caption-text" data-project-media-caption-text>Battlebot: De robot in de arena</p>', false)
        ->assertSee('data-project-media-caption="Battlebot: De sensoren op de voorkant"', false)
        ->assertSee('data-project-media-caption="Battlebot"', false)
        ->assertDontSee('Dit mag niet getoond worden');
});

it('uses the english alt text in english and falls back to the dutch alt text when it is missing', function () {
    $project = Project::factory()->create(['title' => 'Battlebot', 'slug' => 'battlebot', 'sort_order' => 1]);
    $project->images()->createMany([
        ['path' => 'images/projects/placeholders/photo-1.webp', 'alt' => 'De robot in de arena', 'translations' => ['en' => ['alt' => 'The robot in the arena']], 'sort_order' => 1],
        ['path' => 'images/projects/placeholders/photo-1.webp', 'alt' => 'De sensoren op de voorkant', 'translations' => ['en' => ['alt' => '']], 'sort_order' => 2],
    ]);

    $this->withUnencryptedCookie('locale', 'en')
        ->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('<p class="project-media__caption-text" data-project-media-caption-text>Battlebot: The robot in the arena</p>', false)
        ->assertSee('data-project-media-caption="Battlebot: De sensoren op de voorkant"', false);
});

it('shares one contributor between several projects', function () {
    $contributor = Contributor::factory()->create(['name' => 'M. de Graaf']);
    $first = Project::factory()->create(['slug' => 'eerste', 'sort_order' => 1]);
    $second = Project::factory()->create(['slug' => 'tweede', 'sort_order' => 2]);
    $first->contributors()->attach($contributor, ['role' => 'Development', 'sort_order' => 1]);
    $second->contributors()->attach($contributor, ['role' => 'Design', 'sort_order' => 1]);

    expect(Contributor::query()->count())->toBe(1)
        ->and($contributor->projects()->count())->toBe(2);

    $this->get(route('projects.show', $second))
        ->assertOk()
        ->assertSee('M. de Graaf')
        ->assertSee('Design');
});

it('returns not found for an unknown project', function () {
    $this->get('/projecten/bestaat-niet')->assertNotFound();
});

it('renders english labels when the locale cookie is set to english', function () {
    Project::factory()->create(['slug' => 'engels', 'title' => 'English project', 'sort_order' => 1]);

    $this->withUnencryptedCookie('locale', 'en')
        ->get(route('projects'))
        ->assertOk()
        ->assertSee('lang="en"', false)
        ->assertSee('View project');
});

it('marks only the projects link as the current page on the projects overview', function () {
    $html = $this->get(route('projects'))->assertOk()->getContent();

    expect(substr_count($html, 'site-nav__link--menu-active'))->toBe(1)
        ->and($html)->toContain('aria-current="page"');
});

it('seeds the ten projects from the design with the battlebot story', function () {
    $this->seed(ProjectSeeder::class);
    $this->seed(ProjectSeeder::class);

    $battlebot = Project::query()->where('slug', 'battlebot')->firstOrFail();

    expect(Project::query()->count())->toBe(10)
        ->and(Project::query()->whereNotNull('favorite_rank')->count())->toBe(10)
        ->and($battlebot->chapters)->toHaveCount(14)
        ->and($battlebot->contributors)->toHaveCount(2)
        ->and(Contributor::query()->count())->toBe(7);
});

it('puts the featured photo first for smart garden and zinra', function () {
    $this->seed(ProjectSeeder::class);

    expect(Project::query()->where('slug', 'smart-garden-desktop')->firstOrFail()->images->first()->path)
        ->toBe('images/projects/smart-garden-desktop/gg_ik_bij_hh.webp')
        ->and(Project::query()->where('slug', 'zinra')->firstOrFail()->images->first()->path)
        ->toBe('images/projects/zinra/zinra_ik_bij_BZK.webp');
});

it('seeds the chapters, specifications and contributors from the legacy portfolio', function () {
    $this->seed(ProjectSeeder::class);

    $smartGarden = Project::query()->where('slug', 'smart-garden-desktop')->firstOrFail();
    $zinra = Project::query()->where('slug', 'zinra')->firstOrFail();

    expect($smartGarden->chapters)->toHaveCount(8)
        ->and($smartGarden->components)->toHaveCount(10)
        ->and($smartGarden->contributors)->toHaveCount(6)
        ->and($smartGarden->repository_url)->toBe('https://github.com/Znooptokkie/GoodGarden')
        ->and($zinra->repository_url)->toBe('https://github.com/placeholder')
        ->and($zinra->contributors)->toHaveCount(4)
        ->and(Project::query()->whereNull('subtitle')->orWhereNull('intro_label')->count())->toBe(0);
});

it('seeds the stair lighting chapters and components with Dutch and English texts', function () {
    $this->seed(ProjectSeeder::class);

    $project = Project::query()->where('slug', 'automatische-trapverlichting')->firstOrFail();

    expect($project->chapters)->toHaveCount(11)
        ->and($project->chapters->first()->title)->toBe('Introductie')
        ->and($project->chapters->pluck('translations.en.title')->filter()->count())->toBe(11)
        ->and($project->chapters->pluck('translations.en.paragraphs')->filter()->count())->toBe(11)
        ->and($project->components)->toHaveCount(13);

    $this->withUnencryptedCookie('locale', 'nl')->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('Introductie')
        ->assertSee('Debugging van Software en GPIO')
        ->assertSee('HC-SR505 PIR Sensor');

    $this->withUnencryptedCookie('locale', 'en')->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('Introduction')
        ->assertSee('Software and GPIO Debugging')
        ->assertSee('HC-SR505 PIR Sensor');
});

it('shows the links with their description above the url, in the active locale, above the components', function () {
    $project = Project::factory()->create(['title' => 'Trap', 'slug' => 'links-test', 'sort_order' => 1]);
    $project->links()->create([
        'description' => 'De broncode staat op GitHub.',
        'url' => 'https://example.com/code',
        'translations' => ['en' => ['description' => 'The source code is on GitHub.']],
        'sort_order' => 1,
    ]);
    $project->components()->create(['group' => ProjectComponentGroup::Hardware, 'name' => 'Raspberry Pi 5', 'sort_order' => 1]);

    $this->withUnencryptedCookie('locale', 'nl')->get(route('projects.show', $project))
        ->assertOk()
        ->assertSeeInOrder(['De broncode staat op GitHub.', 'https://example.com/code', 'Raspberry Pi 5']);

    $this->withUnencryptedCookie('locale', 'en')->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('The source code is on GitHub.')
        ->assertDontSee('De broncode staat op GitHub.');
});

it('hides the links section when a project has no links', function () {
    $project = Project::factory()->create(['title' => 'Zonder links', 'slug' => 'no-links', 'sort_order' => 1]);

    $this->get(route('projects.show', $project))
        ->assertOk()
        ->assertDontSee('project-links__list', false);
});

it('numbers the visible sections in order, skipping sections without content', function () {
    $project = Project::factory()->create(['title' => 'Nummers', 'slug' => 'numbering-test', 'sort_order' => 1]);
    $project->chapters()->create(['title' => 'Intro', 'paragraphs' => ['Tekst.'], 'sort_order' => 1]);
    $project->components()->create(['group' => ProjectComponentGroup::Hardware, 'name' => 'Raspberry Pi 5', 'sort_order' => 1]);
    $project->contributors()->attach(Contributor::factory()->create(['name' => 'A. Oomen']), ['role' => 'Development', 'sort_order' => 1]);

    $this->withUnencryptedCookie('locale', 'en')->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('01 / THE STORY')
        ->assertSee('02 / UNDER THE HOOD')
        ->assertSee('03 / MADE TOGETHER')
        ->assertDontSee('MORE INFO');

    $project->links()->create([
        'description' => 'Een link.',
        'url' => 'https://example.com',
        'translations' => ['en' => ['description' => 'A link.']],
        'sort_order' => 1,
    ]);

    $this->withUnencryptedCookie('locale', 'en')->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('02 / MORE INFO')
        ->assertSee('03 / UNDER THE HOOD')
        ->assertSee('04 / MADE TOGETHER');
});
