<?php

namespace Database\Seeders;

use App\Enums\ProjectComponentGroup;
use App\Enums\TechnologyKind;
use App\Models\Contributor;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class ProjectSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * The project data files in database/seeders/projects/, in the order they appear on the overview.
     */
    private const array PROJECT_FILES = [
        'automatische-trapverlichting',
        'battlebot',
        'portfolio-v2',
        'smart-garden-desktop',
        'smart-garden-mobiel',
        'bram',
        'zinra',
        'portfolio-v1',
        'dungeon-crawler',
        'plymouth',
    ];

    /**
     * Fallback photos for projects without images in public/images/projects/<slug>/.
     */
    private const array PLACEHOLDER_PHOTOS = [
        'images/projects/placeholders/photo-1.webp',
        'images/projects/placeholders/photo-2.webp',
        'images/projects/placeholders/photo-3.webp',
        'images/projects/placeholders/photo-4.webp',
    ];

    private const array PHOTO_EXTENSIONS = ['webp', 'jpg', 'jpeg', 'png'];

    /**
     * Languages and frameworks; these kinds drive the "Programmeertaal" and "Framework" filters.
     */
    private const array LANGUAGES = ['PHP', 'Python', 'Java', 'TypeScript', 'JavaScript'];

    /**
     * English names for the project types, shown in the project type filter.
     */
    private const array TYPE_NAMES_EN = [
        'Robotica' => 'Robotics',
        'Webdevelopment' => 'Web development',
        'Automatisering' => 'Automation',
        'IOT' => 'IoT',
        'Embedded Systems' => 'Embedded systems',
        'Mobile Development' => 'Mobile development',
    ];

    /**
     * Placeholders for the project intro fields. They apply only where a project does not define the field itself; replace them with the real text.
     */
    private const array INTRO_PLACEHOLDERS = [
        'intro_label' => 'PLACEHOLDER INTRO-LABEL',
        'subtitle' => 'Placeholder ondertitel',
        'organization' => 'Placeholder organisatie',
        'department' => 'Placeholder afdeling',
        'repository_url' => 'https://github.com/placeholder',
    ];

    private const array FRAMEWORKS = ['Laravel', 'Django', 'Flask', 'Electron', 'React Native', 'Vue.js', 'Android Studio'];

    /**
     * Slugs that were renamed; their old rows are removed so they don't show up twice.
     */
    private const array RENAMED_SLUGS = ['plymouth-uitwisseling-begeleiding'];

    /**
     * Seeds the projects from the Figma design. Running the seeder again updates the existing projects.
     */
    public function run(): void
    {
        Project::query()->whereIn('slug', self::RENAMED_SLUGS)->delete();

        foreach ($this->projects() as $index => $data) {
            $data += self::INTRO_PLACEHOLDERS;

            $project = Project::query()->updateOrCreate(
                ['slug' => $data['slug']],
                collect($data)->except([
                    'slug', 'types', 'cardTechnologies', 'detailTechnologies', 'chapters', 'chapterTranslations',
                    'links', 'components', 'contributors', 'imageAlts', 'firstPhoto',
                ])
                    ->put('sort_order', $index + 1)
                    ->all(),
            );

            $this->syncTypes($project, $data['types']);
            $this->syncTechnologies($project, $data['cardTechnologies'], 'card');
            $this->syncTechnologies($project, $data['detailTechnologies'] ?? $data['cardTechnologies'], 'detail');
            $this->syncImages($project, $data['imageAlts'] ?? [], $data['firstPhoto'] ?? null);
            $this->syncChapters($project, $data['chapters'] ?? [], $data['chapterTranslations'] ?? []);
            $this->syncLinks($project, $data['links'] ?? []);
            $this->syncComponents($project, $data['components'] ?? []);
            $this->syncContributors($project, $data['contributors'] ?? []);
        }
    }

    /**
     * Loads the seed data of every project from database/seeders/projects/<slug>.php.
     *
     * @return list<array<string, mixed>>
     */
    private function projects(): array
    {
        return array_map(
            fn (string $slug): array => File::getRequire(database_path("seeders/projects/{$slug}.php")),
            self::PROJECT_FILES,
        );
    }

    /**
     * @param  list<string>  $names
     */
    private function syncTypes(Project $project, array $names): void
    {
        $typeIds = collect($names)->map(fn (string $name): int => ProjectType::query()->updateOrCreate(
            ['name' => $name],
            ['translations' => ['en' => ['name' => self::TYPE_NAMES_EN[$name] ?? $name]]],
        )->id);

        $project->projectTypes()->sync($typeIds->all());
    }

    /**
     * @param  list<string>  $names
     */
    private function syncTechnologies(Project $project, array $names, string $placement): void
    {
        $project->technologies()->wherePivot('placement', $placement)->detach();

        foreach ($names as $index => $name) {
            $technology = Technology::query()->firstOrCreate(
                ['name' => $name],
                ['kind' => $this->kindFor($name)],
            );

            $project->technologies()->attach($technology->id, ['placement' => $placement, 'sort_order' => $index + 1]);
        }
    }

    private function kindFor(string $name): TechnologyKind
    {
        return match (true) {
            in_array($name, self::LANGUAGES, true) => TechnologyKind::Language,
            in_array($name, self::FRAMEWORKS, true) => TechnologyKind::Framework,
            default => TechnologyKind::Other,
        };
    }

    /**
     * @param  array<string, array{nl: string, en: string}>  $imageAlts  Alt texts keyed by file name.
     */
    private function syncImages(Project $project, array $imageAlts, ?string $firstPhoto): void
    {
        $project->images()->delete();

        foreach ($this->photosFor($project, $firstPhoto) as $index => $path) {
            $alts = $imageAlts[basename($path)] ?? ['nl' => '', 'en' => ''];

            $project->images()->create([
                'path' => $path,
                'alt' => $alts['nl'] !== '' ? $alts['nl'] : null,
                'translations' => ['en' => ['alt' => $alts['en']]],
                'caption' => $index === 0 ? $project->story_lead : null,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * The photos in public/images/projects/<slug>/, sorted by file name with the first photo moved to the front. Falls back to the placeholders when the folder is missing or empty.
     *
     * @return list<string>
     */
    private function photosFor(Project $project, ?string $firstPhoto): array
    {
        $directory = public_path("images/projects/{$project->slug}");

        $photos = File::isDirectory($directory)
            ? collect(File::files($directory))
                ->filter(fn (SplFileInfo $file): bool => in_array(strtolower($file->getExtension()), self::PHOTO_EXTENSIONS, true))
                ->map(fn (SplFileInfo $file): string => "images/projects/{$project->slug}/{$file->getFilename()}")
                ->sort()
                ->sortBy(fn (string $path): string => basename($path) === $firstPhoto ? '' : $path)
                ->values()
                ->all()
            : [];

        return $photos !== [] ? $photos : self::PLACEHOLDER_PHOTOS;
    }

    /**
     * @param  list<array{title: string, paragraphs: list<string>}>  $chapters
     * @param  list<array{0: string, 1: list<string>}>  $englishChapters
     */
    private function syncChapters(Project $project, array $chapters, array $englishChapters = []): void
    {
        $project->chapters()->delete();

        foreach ($chapters as $index => $chapter) {
            $english = $englishChapters[$index] ?? null;

            $project->chapters()->create([
                'title' => $chapter['title'],
                'paragraphs' => $chapter['paragraphs'],
                'sort_order' => $index + 1,
                'translations' => $english === null ? null : ['en' => ['title' => $english[0], 'paragraphs' => array_values(array_slice($english, 1))]],
            ]);
        }
    }

    /**
     * Links shown between the story and the specifications. Format per link:
     * ['description' => ['nl' => 'Korte zin.', 'en' => 'Short sentence.'], 'url' => 'https://example.com'].
     *
     * @param  list<array{description: array{nl: string, en: string}, url: string}>  $links
     */
    private function syncLinks(Project $project, array $links): void
    {
        $project->links()->delete();

        foreach ($links as $index => $link) {
            $project->links()->create([
                'description' => $link['description']['nl'],
                'url' => $link['url'],
                'translations' => ['en' => ['description' => $link['description']['en']]],
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * Components per group value, in the order they are shown: ['hardware' => ['Raspberry Pi 5'], 'protocol' => ['SSH (Secure Shell)']].
     *
     * @param  array<string, list<string>>  $components
     */
    private function syncComponents(Project $project, array $components): void
    {
        $project->components()->delete();

        $sortOrder = 0;

        foreach ($components as $group => $names) {
            foreach ($names as $name) {
                $project->components()->create([
                    'group' => ProjectComponentGroup::from($group),
                    'name' => $name,
                    'sort_order' => ++$sortOrder,
                ]);
            }
        }
    }

    /**
     * @param  list<array{name: string, role: string}>  $contributors
     */
    private function syncContributors(Project $project, array $contributors): void
    {
        $sync = [];

        foreach ($contributors as $index => $contributor) {
            $model = Contributor::query()->updateOrCreate(['name' => $contributor['name']], ['url' => $contributor['url'] ?? null]);
            $sync[$model->id] = ['role' => $contributor['role'], 'sort_order' => $index + 1];
        }

        $project->contributors()->sync($sync);
    }
}
