<?php

namespace Database\Seeders;

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;
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
     * Seeds the projects from the Figma design. Running the seeder again updates the existing projects.
     */
    public function run(): void
    {
        foreach ($this->projects() as $index => $data) {
            $data += self::INTRO_PLACEHOLDERS;

            $project = Project::query()->updateOrCreate(
                ['slug' => $data['slug']],
                collect($data)->except(['slug', 'types', 'cardTechnologies', 'detailTechnologies', 'chapters', 'chapterTranslations', 'components', 'contributors'])
                    ->put('sort_order', $index + 1)
                    ->all(),
            );

            $this->syncTypes($project, $data['types']);
            $this->syncTechnologies($project, $data['cardTechnologies'], 'card');
            $this->syncTechnologies($project, $data['detailTechnologies'] ?? $data['cardTechnologies'], 'detail');
            $this->syncImages($project);
            $this->syncChapters($project, $data['chapters'] ?? [], $data['chapterTranslations'] ?? []);
            $this->syncComponents($project, $data['components'] ?? []);
            $this->syncContributors($project, $data['contributors'] ?? []);
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function projects(): array
    {
        return [
            [
                'slug' => 'automatische-trapverlichting',
                'translations' => ['en' => ['title' => 'Automatic Stair Lighting',
                    'category' => 'EMBEDDED SYSTEMS',
                    'summary' => 'My mother is slowly losing her eyesight, so I decided to build an *automatic lighting system* on the stairs, with *sensors* and *N-MOSFETs*. Everything is controlled by a *Raspberry Pi Pico 2*. I also chose to design my own *PCB* for it, together with the *electrical schematic*.',
                ]],
                'title' => 'Automatische Trapverlichting',

                'category' => 'EMBEDDED SYSTEMS',
                'started_year' => 2026,
                'ended_year' => null,
                'summary' => 'Mijn moeder kan helaas steeds slechter zien, vandaar dat ik besloot om op de trap een *automatisch lichtsysteem* te maken met *sensoren* en *N-Mosfets*. Dit alles wordt aangestuurd via een *Raspberry Pi Pico 2*. Ook heb ik besloten om een eigen *PCB* hiervoor te ontwerpen, samen met het *elecktrisch schema*.',
                'status' => ProjectStatus::InConstructie,
                'is_favorite' => true,
                'types' => ['Embedded Systems'],
                'cardTechnologies' => ['MicroPython', 'HC-SR505', 'Pico 2', 'KiCad', 'N-Mosfet'],
            ],
            [
                'slug' => 'battlebot',
                'translations' => ['en' => [
                    'category' => 'ROBOTICS / STAGE PROJECT',
                    'intro_label' => 'ROBOTICS / FINAL STAGE PROJECT',
                    'summary' => 'Battlebot was my *final internship project*, in which I turned an existing robot into an intelligent and largely autonomous system, with a *Raspberry Pi 5* and *Pico 2*, *CAN-bus communication* and *AI-driven object detection* via a *Hailo-8 accelerator*.',
                    'subtitle' => 'From an existing robot to an intelligent and largely autonomous system.',
                    'story_lead' => 'The Battlebot: the foundation for autonomous control, sensors and object detection.',
                    'story_heading' => 'From idea to',
                    'story_heading_accent' => 'autonomy',
                    'story_aside' => '// step by step',
                    'department' => 'Department of Technology',
                ]],
                'title' => 'Battlebot',
                'title_accent' => 'bot',
                'category' => 'ROBOTICA / STAGEPROJECT',
                'intro_label' => 'ROBOTICA / EINDSTAGEPROJECT',
                'started_year' => 2025,
                'ended_year' => null,
                'summary' => 'Battlebot was mijn *eindstageproject* waarin ik een bestaande robot omvormde tot een intelligent en grotendeels autonoom systeem, met een *Raspberry Pi 5* en *Pico 2*, *CAN-bus communicatie* en *AI-gestuurde objectdetectie* via een *Hailo-8 accelerator*.',
                'subtitle' => 'Van een bestaande robot naar een intelligent en grotendeels autonoom systeem.',
                'story_lead' => 'De Battlebot: de basis voor autonome besturing, sensoren en objectdetectie.',
                'media_tagline' => '{ hardware × software }',
                'story_heading' => 'Van idee naar',
                'story_heading_accent' => 'autonomie',
                'story_aside' => '// stap voor stap',
                'repository_url' => 'https://github.com/BattlebotdeGripper/battlebot_pi',
                'status' => ProjectStatus::Klaar,
                'organization' => 'mboRijnland',
                'department' => 'Afdeling Techniek',
                'types' => ['Robotica'],
                'cardTechnologies' => ['Python', 'MicroPython', 'CAN-bus', 'AI'],
                'detailTechnologies' => ['Raspberry Pi 5', 'Pico 2', 'MicroPython', 'CAN-bus', 'Hailo-8'],
                'chapters' => $this->battlebotChapters(),
                'chapterTranslations' => $this->battlebotChapterTranslations(),
                'components' => $this->battlebotComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Development', 'url' => 'https://github.com/Znooptokkie'],
                    ['name' => 'M. de Graaf', 'role' => 'Development', 'url' => 'https://github.com/Matthijs-de-Graaf'],
                ],
            ],
            [
                'slug' => 'portfolio-v2',
                'translations' => ['en' => [
                    'category' => 'WEB DEVELOPMENT',
                    'summary' => 'The first version of my portfolio website was built in *Django (Python)*. I mainly saw it as a learning project. It started out well structured, but ended up as quite a mess. For that reason, and because I wanted to build a complete project with *Claude Code*, I decided to rebuild my portfolio in *Laravel (PHP)*. This time with support from *Figma-MCP* & *Claude Code*.',
                ]],
                'title' => 'Portfolio V2',
                'category' => 'WEBDEVELOPMENT',
                'started_year' => 2026,
                'ended_year' => null,
                'summary' => 'De eerste versie van mijn portfolio website had ik gemaakt in *Django (Python)*. Die beschouwde ik vooral als een leer-project. Het begon gestructureerd, maar eindigde toch wel in een aardige bende. Mede om die reden, en omdat ik met *Claude Code* een volledige iets wilde bouwen, heb ik besloten om mijn portfolio opnieuw te bouwen *Laravel (PHP)*. Dit keer met ondersteuning van *Figma-MCP* & *Claude Code*.',
                'status' => ProjectStatus::InConstructie,
                'types' => ['Webdevelopment'],
                'cardTechnologies' => ['PHP', 'Laravel', 'TypeScript', 'Claude Code', 'Figma-MCP'],
            ],
            [
                'slug' => 'smart-garden-desktop',
                'translations' => ['en' => [
                    'category' => 'IOT / EMBEDDED SYSTEMS',
                    'summary' => 'Smart Garden is a collaboration between *CIV Smart Technology*, *The Field* in Leiden and *mboRijnland*, in which a dashboard was built in *Flask* to monitor and control a vertical garden, including live sensor data and an automatically controlled water pump via a *Raspberry Pi 4*.',
                ]],
                'title' => 'Smart Garden (desktop)',
                'category' => 'IOT / EMBEDDED SYSTEMS',
                'started_year' => 2024,
                'ended_year' => 2025,
                'summary' => 'Smart Garden is een samenwerkingsproject tussen het *CIV Smart Technology*, *The Field* in Leiden en *mboRijnland*, waarbij een dashboard werd gebouwd in *Flask* om een verticale tuin te monitoren en aan te sturen, inclusief live sensordata en een automatisch aangestuurde waterpomp via een *Raspberry Pi 4*.',
                'status' => ProjectStatus::Klaar,
                'types' => ['IOT', 'Embedded Systems'],
                'cardTechnologies' => ['Python', 'JavaScript', 'Flask', 'Raspberry Pi', 'Electron'],
                'repository_url' => 'https://github.com/Znooptokkie/GoodGarden',
                'chapters' => $this->smartGardenDesktopChapters(),
                'components' => $this->smartGardenDesktopComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Development', 'url' => 'https://github.com/Znooptokkie'],
                    ['name' => 'R. van Putten', 'role' => 'Development', 'url' => 'https://github.com/SanzoVP'],
                    ['name' => 'B. Diker', 'role' => 'Development', 'url' => 'https://github.com/bdiker61'],
                    ['name' => 'M. Cifci', 'role' => 'Development', 'url' => 'https://github.com/mohammedcifci'],
                    ['name' => 'J. Doekhi', 'role' => 'Development', 'url' => 'https://github.com/6027529'],
                    ['name' => 'M. Heins', 'role' => 'Development', 'url' => 'https://github.com/martijnhe'],
                ],
            ],
            [
                'slug' => 'smart-garden-mobiel',
                'translations' => ['en' => [
                    'category' => 'MOBILE DEVELOPMENT',
                    'summary' => 'For my *Mobile Development* final exam I turned the Smart Garden (desktop) project into a full mobile app in *React Native*, with its own *Flask API*, user roles and a connection to a *Raspberry Pi 4*.',
                ]],
                'title' => 'Smart Garden (mobiel)',
                'category' => 'MOBILE DEVELOPMENT',
                'started_year' => 2025,
                'ended_year' => null,
                'summary' => 'Voor mijn eindexamen *Mobile Development* heb ik het project Smart Garden (desktop) omgezet naar een volwaardige mobiele applicatie in *React Native*, met eigen *Flask-API*, gebruikersrollen en koppeling met een *Raspberry Pi 4*.',
                'status' => ProjectStatus::Klaar,
                'types' => ['Mobile Development'],
                'cardTechnologies' => ['TypeScript', 'React Native', 'Flask API', 'Termux'],
                'repository_url' => 'https://github.com/6028968/GG_MAD',
                'chapters' => $this->smartGardenMobileChapters(),
                'components' => $this->smartGardenMobileComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Development', 'url' => 'https://github.com/Znooptokkie'],
                ],
            ],
            [
                'slug' => 'bram',
                'translations' => ['en' => [
                    'category' => 'MOBILE DEVELOPMENT',
                    'summary' => 'BRAM was my first mobile project, commissioned by the *municipality of Zoetermeer*. In *Android Studio* with *Java* we built an app to help older people use their phone more easily, with features such as an *emergency button* and simple access to *family photos*.',
                ]],
                'title' => 'BRAM',
                'category' => 'MOBILE DEVELOPMENT',
                'started_year' => 2024,
                'ended_year' => null,
                'summary' => 'BRAM was mijn eerste mobiele project, aangeboden door de *gemeente Zoetermeer*, waarbij we in *Android Studio* met *Java* een applicatie bouwden die ouderen moet helpen om gemakkelijker overweg te kunnen met hun mobiel, met functies zoals een *noodknop* en eenvoudige toegang tot *familiefoto’s*.',
                'status' => ProjectStatus::Klaar,
                'types' => ['Mobile Development'],
                'cardTechnologies' => ['Java', 'Android Studio', 'XML'],
                'repository_url' => 'https://github.com/bdiker61/BRAM',
                'chapters' => $this->bramChapters(),
                'components' => $this->bramComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Development', 'url' => 'https://github.com/Znooptokkie'],
                    ['name' => 'M. de Graaf', 'role' => 'Development', 'url' => 'https://github.com/Matthijs-de-Graaf'],
                    ['name' => 'R. van Putten', 'role' => 'Development', 'url' => 'https://github.com/SanzoVP'],
                    ['name' => 'B. Diker', 'role' => 'Development', 'url' => 'https://github.com/bdiker61'],
                ],
            ],
            [
                'slug' => 'zinra',
                'translations' => ['en' => [
                    'category' => 'DOCUMENT AUTOMATION',
                    'summary' => 'For the *Dutch Ministry of the Interior and Kingdom Relations (BZK)* we developed two programmes to organise a large volume of documents: a *mailbox application* that automatically categorises emails using the *\'Bag of Words\'* concept, and a *website* for manually *sorting* and *de-duplicating* documents.',
                ]],
                'title' => 'Zinra',
                'category' => 'DOCUMENTAUTOMATISERING',
                'started_year' => 2023,
                'ended_year' => null,
                'summary' => 'Voor het *Ministerie van Binnenlandse Zaken en Koninkrijksrelaties (BZK)* ontwikkelden wij twee programma’s om een grote hoeveelheid documenten te organiseren: een *mailbox-applicatie* die mails automatisch categoriseert via het *‘Bag of Words’-concept*, en een *website* voor het handmatig *sorteren* en *dedupliceren* van documenten.',
                'status' => ProjectStatus::Klaar,
                'types' => ['Automatisering'],
                'cardTechnologies' => ['Python', 'HTML', 'CSS'],
                'chapters' => $this->zinraChapters(),
                'components' => $this->zinraComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Development', 'url' => 'https://github.com/Znooptokkie'],
                    ['name' => 'R. van Putten', 'role' => 'Development', 'url' => 'https://github.com/SanzoVP'],
                    ['name' => 'B. Diker', 'role' => 'Development', 'url' => 'https://github.com/bdiker61'],
                    ['name' => 'M. Cifci', 'role' => 'Development', 'url' => 'https://github.com/mohammedcifci'],
                ],
            ],
            [
                'slug' => 'portfolio-v1',
                'translations' => ['en' => [
                    'category' => 'WEB DEVELOPMENT',
                    'summary' => 'My original portfolio website. Built in *Django* with *native TypeScript*. My aim for this project was to learn as much as possible from the different *concepts* that come with a website like this. That is also why it has turned into a bit of a mess. It started off structured, but eventually ended up with a rather messy *folder structure* and *codebase*.',
                ]],
                'title' => 'Portfolio V1',
                'category' => 'WEBDEVELOPMENT',
                'started_year' => 2025,
                'ended_year' => 2026,
                'summary' => 'Mijn oorspronkelijke portfolio website. Gemaakt in *Django* met *native TypeScript*. Mijn insteek voor dit project was om zoveel mogelijk te leren van de verschillende *concepten* die aan bod komen bij zo een website. Dit is ook wel de reden dat het eigenlijk een gigantisch bende is geworden. Het begon gestructureerd, maar het eindige toch met een behoorlijk onoverzichtelijke *mappenstructuur* en *code*.',
                'status' => ProjectStatus::Klaar,
                'types' => ['Webdevelopment'],
                'cardTechnologies' => ['Python', 'Django', 'TypeScript', 'SVG', 'CI/CD'],
                'repository_url' => 'https://github.com/Znooptokkie/CV',
                'chapters' => $this->portfolioV1Chapters(),
                'components' => $this->portfolioV1Components(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Development', 'url' => 'https://github.com/Znooptokkie'],
                ],
            ],
            [
                'slug' => 'dungeon-crawler',
                'translations' => ['en' => [
                    'category' => 'WEB DEVELOPMENT',
                    'summary' => 'I took part in the *hackathon* of the *Dutch Laravel Foundation*. Because it had been a while since I last used *Laravel* as a *framework*, I decided to build a small dungeon crawler. The project is *unfinished*, but I don\'t rule out finishing it at some point.',
                ]],
                'title' => 'Dungeon Crawler',
                'category' => 'WEBDEVELOPMENT',
                'started_year' => 2026,
                'ended_year' => null,
                'summary' => 'Ik deed mee aan de *hackaton* van de *Dutch Laravel Foundation*. Omdat het een tijdje geleden was dat ik *Laravel* had gebruikt als *framework*, besloot ik om een kleine dungeon crawler te maken. Het project staat op *onvoltooid*, maar ik sluit niet uit om hem alsnog af te maken.',
                'status' => ProjectStatus::Onvoltooid,
                'types' => ['Webdevelopment'],
                'cardTechnologies' => ['PHP', 'Laravel', 'Vue.js', 'SVG'],
            ],
        ];
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

    private function syncImages(Project $project): void
    {
        $project->images()->delete();

        foreach ($this->photosFor($project) as $index => $path) {
            $project->images()->create([
                'path' => $path,
                'caption' => $index === 0 ? $project->story_lead : null,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * The photos in public/images/projects/<slug>/, sorted by file name. Falls back to the placeholders when the folder is missing or empty.
     *
     * @return list<string>
     */
    private function photosFor(Project $project): array
    {
        $directory = public_path("images/projects/{$project->slug}");

        $photos = File::isDirectory($directory)
            ? collect(File::files($directory))
                ->filter(fn (SplFileInfo $file): bool => in_array(strtolower($file->getExtension()), self::PHOTO_EXTENSIONS, true))
                ->map(fn (SplFileInfo $file): string => "images/projects/{$project->slug}/{$file->getFilename()}")
                ->sort()
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
     * @param  list<array{group: ProjectComponentGroup, name: string}>  $components
     */
    private function syncComponents(Project $project, array $components): void
    {
        $project->components()->delete();

        foreach ($components as $index => $component) {
            $project->components()->create([
                'group' => $component['group'],
                'name' => $component['name'],
                'sort_order' => $index + 1,
            ]);
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

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function battlebotChapters(): array
    {
        return [
            ['title' => 'Introductie', 'paragraphs' => [
                'Battlebot was een eindstageproject waarin een bestaande robot werd omgevormd tot een intelligent en grotendeels autonoom systeem.',
                'Het doel was niet alleen een werkende robot bouwen, maar ook diepgaand inzicht krijgen in hoe complexe systemen samenwerken.',
                'Gedurende vier maanden werd de robot stap voor stap uitgebreid, getest en geoptimaliseerd.',
            ]],
            ['title' => 'Visie en Doelstelling', 'paragraphs' => [
                'De kern van het project was het realiseren van een robot die zowel handmatig als autonoom kan functioneren.',
                'Dit duale besturingssysteem combineert directe controle met zelfstandige intelligentie.',
                'De autonome functionaliteit richtte zich op objectherkenning en bewegingsplanning.',
            ]],
            ['title' => 'Architecturale opzet', 'paragraphs' => [
                'Vanaf het begin werd gekozen voor een gescheiden architectuur, waarbij verantwoordelijkheden duidelijk werden verdeeld tussen software en hardware. Dit verhoogde onderhoudbaarheid en maakte testen eenvoudiger.',
                'De Raspberry Pi 5 fungeerde als centrale besturingshub voor logica, communicatie, AI-verwerking en beslissingsalgoritmen.',
                'De Raspberry Pi Pico 2 verzorgde real-time aansturing van motoren en de grijparm, waardoor lage-latentie acties betrouwbaar konden worden uitgevoerd, onafhankelijk van de zwaardere verwerking op de Pi 5.',
            ]],
            ['title' => 'Besturing en Veiligheid', 'paragraphs' => [
                'De robot werd primair bestuurd via een RC-controller, waarvan signalen worden ingelezen door de Raspberry Pi 5.',
                'Deze signalen worden gevalideerd en geïnterpreteerd, waarna ze worden doorgestuurd naar de Raspberry Pi Pico 2 voor fysieke aansturing van motoren en actuators.',
                'Om veiligheid te waarborgen is een heartbeat-mechanisme geïmplementeerd, dat continu controleert of de communicatie tussen Pi en Pico 2 intact is en bij verlies van verbinding de robot in een veilige staat zet.',
            ]],
            ['title' => 'Autonome Besturing', 'paragraphs' => [
                'Nadat de handmatige besturing stabiel functioneerde, verschoof de focus naar autonome aansturing. Hiervoor werd een camerasysteem toegevoegd waarmee de robot zijn omgeving kon waarnemen en visuele data kan verzamelen voor objectdetectie.',
                'Door visuele input te combineren met afstandsmetingen van sensoren kon de robot objecten detecteren, volgen en ermee interacteren, zoals het oppakken of ontwijken van obstakels.',
            ]],
            ['title' => 'Hardwarekeuze', 'paragraphs' => [
                'De keuze voor de Raspberry Pi 5 was gebaseerd op de behoefte aan rekenkracht, uitbreidbaarheid en ondersteuning voor AI-frameworks. De Raspberry Pi Pico 2 werd ingezet voor real-time besturing vanwege de directe GPIO-aansturing en voorspelbare timing.',
                'Deze combinatie resulteerde in een schaalbaar systeem waarin software en hardware logisch van elkaar gescheiden zijn, waardoor complexe taken betrouwbaar uitgevoerd kunnen worden.',
            ]],
            ['title' => 'CAN-bus', 'paragraphs' => [
                'Voor communicatie tussen Raspberry Pi 5 en Pico 2 is gekozen voor het CAN-bus protocol, bekend om zijn betrouwbaarheid en fouttolerantie. De MCP2515-modules verzorgen de interface, waardoor berichten met verschillende prioriteiten veilig verzonden kunnen worden.',
                'Hoewel de implementatie complex was, bood het waardevolle inzichten in industriële communicatieprotocollen en message-prioritization technieken.',
            ]],
            ['title' => 'RC-Receiver', 'paragraphs' => [
                'De Flysky FS-iA10B receiver vormt de schakel tussen gebruiker en robot, waarbij RC-signalen worden ontvangen en verwerkt. De signalen worden via UART omgezet naar digitale besturingswaarden die de Pi 5 kan interpreteren en doorsturen naar de Pico 2. Failsafe-functionaliteit zorgt ervoor dat de robot automatisch stopt of in een veilige modus komt bij signaalverlies of foutieve inputs.',
            ]],
            ['title' => 'Sensoren', 'paragraphs' => [
                'Extra sensoren werden toegevoegd voor betrouwbaardere besturing, vooral tijdens autonome navigatie. Ultrasone afstandssensoren leveren realtime data over de omgeving, wat cruciaal is voor obstakelvermijding en positionering van de grijparm. Deze sensoren ondersteunen zowel autonome navigatie als het nauwkeurig uitvoeren van fysieke taken.',
                'Om rijprecisie te verbeteren zijn optische encoders en odometrie onderzocht. Hoewel deze technieken theoretisch nauwkeurige resultaten opleverden, bleken ze in de praktijk gevoelig voor mechanische afwijkingen en oppervlakteruis. Uiteindelijk is gekozen voor een eenvoudiger correctiemechanisme op basis van PWM-aansturing, dat betrouwbaarder en onderhoudsvriendelijker bleek.',
            ]],
            ['title' => 'AI-Verwerking', 'paragraphs' => [
                'Real-time objectdetectie werd uitgevoerd met de Hailo-8 AI Accelerator, die beelden lokaal verwerkt zonder externe afhankelijkheid. De accelerator maakt het mogelijk zware AI-modellen snel en efficiënt uit te voeren, wat cruciaal is voor autonome beslissingen. Dankzij deze setup kan de robot zelfstandig objecten herkennen en acties uitvoeren op basis van lokaal verwerkte data.',
            ]],
            ['title' => 'Cameragebruik', 'paragraphs' => [
                'De Camera Module 3 Wide NoIR werd gekozen vanwege het brede gezichtsveld en de goede prestaties bij weinig licht. Beelden worden direct naar de Hailo-8 gestuurd voor analyse, waardoor realtime objectdetectie mogelijk is. Aanpassingen aan autofocus en aanvullende sensoren verbeterden de nauwkeurigheid bij korte afstand en complexe interacties.',
            ]],
            ['title' => 'Softwarearchitectuur', 'paragraphs' => [
                'De software op de Raspberry Pi 5 is volledig geschreven in Python, met nadruk op leesbaarheid, onderhoudbaarheid en objectgeoriënteerd ontwerp. Op de Raspberry Pi Pico 2 draait MicroPython, waarmee directe hardware-aansturing mogelijk is met lage latentie. Versiebeheer via GitHub zorgt voor traceerbaarheid van wijzigingen, samenwerking en reproduceerbaarheid van experimenten.',
            ]],
            ['title' => 'Projectverloop', 'paragraphs' => [
                'Het project volgde een iteratief proces, waarbij ontwerpen regelmatig werden herzien op basis van testresultaten en observaties. Problemen met voeding, communicatie en mechanica leidden tot meerdere herontwerpen, wat het systeem uiteindelijk robuuster maakte. Deze iteraties leverden diepgaand inzicht in systeemintegratie, foutafhandeling en praktische engineering-vaardigheden.',
            ]],
            ['title' => 'Eindresultaat', 'paragraphs' => [
                'Het eindresultaat is een robot die stabiel handmatig bestuurbaar is en gedeeltelijk autonoom kan functioneren. Hoewel niet alle doelen volledig zijn gerealiseerd, biedt het project een solide basis voor verdere uitbreiding en verbetering. De belangrijkste opbrengst is kennis over embedded systemen, AI, communicatieprotocollen en de integratie van complexe software-hardware-systemen.',
            ]],
        ];
    }

    /**
     * English chapter texts, aligned with battlebotChapters().
     *
     * @return list<array{0: string, 1: string}>
     */
    private function battlebotChapterTranslations(): array
    {
        return [
            ['Introduction', 'Battlebot was a final internship project in which an existing robot was transformed into an intelligent and largely autonomous system.', 'The goal was not only to build a working robot, but also to gain deep insight into how complex systems work together.', 'Over four months, the robot was extended, tested and optimised step by step.'],
            ['Vision and Objective', 'The core of the project was to build a robot that can operate both manually and autonomously.', 'This dual control system combines direct control with independent intelligence.', 'The autonomous functionality focused on object recognition and motion planning.'],
            ['Architectural design', 'From the start, a separated architecture was chosen, in which responsibilities were clearly divided between software and hardware. This improved maintainability and made testing easier.', 'The Raspberry Pi 5 served as the central control hub for logic, communication, AI processing and decision-making algorithms.', 'The Raspberry Pi Pico 2 handled real-time control of the motors and the gripper arm, so that low-latency actions could be carried out reliably, independent of the heavier processing on the Pi 5.'],
            ['Control and Safety', 'The robot was primarily controlled with an RC controller, whose signals are read by the Raspberry Pi 5.', 'These signals are validated and interpreted, after which they are forwarded to the Raspberry Pi Pico 2 for physical control of the motors and actuators.', 'To ensure safety, a heartbeat mechanism was implemented. It continuously checks whether the communication between the Pi and Pico 2 is intact and puts the robot in a safe state when the connection is lost.'],
            ['Autonomous Control', 'Once manual control was working reliably, the focus shifted to autonomous control. A camera system was added so the robot could perceive its surroundings and collect visual data for object detection.', 'By combining visual input with distance measurements from sensors, the robot could detect, follow and interact with objects, for example by picking up or avoiding obstacles.'],
            ['Hardware choice', 'The Raspberry Pi 5 was chosen for its computing power, expandability and support for AI frameworks. The Raspberry Pi Pico 2 was used for real-time control because of its direct GPIO control and predictable timing.', 'This combination resulted in a scalable system in which software and hardware are logically separated, so that complex tasks can be carried out reliably.'],
            ['CAN bus', 'CAN bus was chosen for communication between the Raspberry Pi 5 and the Pico 2, known for its reliability and fault tolerance. MCP2515 modules provide the interface, so that messages with different priorities can be sent safely.', 'Although the implementation was complex, it gave valuable insight into industrial communication protocols and message prioritisation techniques.'],
            ['RC receiver', 'The Flysky FS-iA10B receiver forms the link between user and robot, receiving and processing RC signals. Via UART, the signals are converted into digital control values that the Pi 5 can interpret and forward to the Pico 2. Failsafe functionality makes the robot stop automatically or switch to a safe mode when the signal is lost or the input is faulty.'],
            ['Sensors', 'Additional sensors were added for more reliable control, especially during autonomous navigation. Ultrasonic distance sensors provide real-time data about the environment, which is crucial for avoiding obstacles and positioning the gripper arm. These sensors support both autonomous navigation and the precise execution of physical tasks.', 'To improve driving precision, optical encoders and odometry were investigated. Although these techniques gave accurate results in theory, in practice they proved sensitive to mechanical deviations and surface noise. In the end, a simpler correction mechanism based on PWM control was chosen, which proved more reliable and easier to maintain.'],
            ['AI processing', 'Real-time object detection was carried out with the Hailo-8 AI accelerator, which processes images locally without external dependencies. The accelerator makes it possible to run heavy AI models quickly and efficiently, which is crucial for autonomous decisions. Thanks to this setup, the robot can recognise objects and perform actions independently, based on locally processed data.'],
            ['Camera use', 'The Camera Module 3 Wide NoIR was chosen for its wide field of view and good performance in low light. Images are sent directly to the Hailo-8 for analysis, which makes real-time object detection possible. Adjustments to the autofocus and additional sensors improved accuracy at short range and during complex interactions.'],
            ['Software architecture', 'The software on the Raspberry Pi 5 is written entirely in Python, with an emphasis on readability, maintainability and object-oriented design. The Raspberry Pi Pico 2 runs MicroPython, which allows direct hardware control with low latency. Version control via GitHub keeps changes traceable and supports collaboration and the reproducibility of experiments.'],
            ['Project progress', 'The project followed an iterative process, in which designs were regularly revised based on test results and observations. Problems with power supply, communication and mechanics led to several redesigns, which ultimately made the system more robust. These iterations gave deep insight into system integration, error handling and practical engineering skills.'],
            ['Final result', 'The end result is a robot that is stable to control manually and can partly function autonomously. Although not all goals were fully achieved, the project provides a solid foundation for further expansion and improvement. The most important outcome is knowledge of embedded systems, AI, communication protocols and the integration of complex software and hardware systems.'],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function battlebotComponents(): array
    {
        $groups = [
            ProjectComponentGroup::Hardware->value => ['Raspberry Pi 5', 'Raspberry Pi Pico 2', 'Hailo-HAT', 'UBEC (Universal battery eliminator circuit)', 'ESC (Electronic Speed Controller)', 'MCP2515-module', 'DC-Converter', 'CSI (Camera Serial Interface)', 'PWM (Pulse-width modulation)'],
            ProjectComponentGroup::Software->value => ['Bitwise Operators', 'Thonny', 'YOLOv11', 'Crontab'],
            ProjectComponentGroup::Protocol->value => ['UART (Universal asynchronous receiver-transmitter)', 'CAN (Controller area network)', 'I-Bus', 'SPI (Serial Peripheral Interface)', 'SSH (Secure Shell)'],
            ProjectComponentGroup::Sensor->value => ['HC-SR04', 'FC-03 IR Optical Encoder'],
        ];

        return $this->groupedComponents($groups);
    }

    /**
     * Flattens component names keyed by group value into the list the seeder syncs.
     *
     * @param  array<string, list<string>>  $groups
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function groupedComponents(array $groups): array
    {
        return collect($groups)
            ->flatMap(fn (array $names, string $group): array => array_map(
                fn (string $name): array => ['group' => ProjectComponentGroup::from($group), 'name' => $name],
                $names,
            ))
            ->values()
            ->all();
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function smartGardenDesktopChapters(): array
    {
        return [
            ['title' => 'Introductie', 'paragraphs' => [
                'Smart Garden is een samenwerkingsproject tussen het CIV Smart Technology, The Field in Leiden en mboRijnland, met als nieuwste aanwinst studenten van de Haagse Hogeschool.',
                'Het doel van dit project is om studenten actief te betrekken bij actuele maatschappelijke vraagstukken, met een focus op duurzaamheid en circulair bouwen. De centrale vraag binnen Smart Garden luidt: "Hoe kunnen we een kas met planten zo efficiënt en autonoom mogelijk in leven houden?"',
                'Wat begon als een relatief klein project, groeide gedurende meerdere schooljaren uit tot een project van aanzienlijke omvang, met meerdere opeenvolgende teams en steeds verdergaande technische uitdagingen.',
            ]],
            ['title' => 'De Opdracht', 'paragraphs' => [
                'Iedere tweedejaars student van de opleiding Software Developer bij mboRijnland kreeg in deze periode dezelfde opdracht, waarna groepjes werden gevormd om deze uit te voeren. Ons groepje bestond uit vijf leden.',
                'Door de scrum-methodiek toe te passen, hadden we vanaf het begin een duidelijke rolverdeling: twee front-end developers, twee back-end developers (waarvan één ook de rol van Product Owner vervulde), en ikzelf als Scrum Master en projectleider.',
                'De opdracht begon in periode drie van het schooljaar 2023-2024. Als eerste werd van ons verwacht dat we sensordata zouden ophalen uit een API van Quantified en deze zichtbaar zouden maken op een dashboard.',
                'Daarnaast moesten we planten kunnen toevoegen die zich in de kas bevinden, zodat elke individuele plant gemonitord kan worden. Omdat het einddoel een autonome kas is, leek het ons zinvol om gegevens zoals waterbehoefte, zonlicht en voedingsstoffen automatisch te laten invullen. Hiervoor maakten we gebruik van een tweede API, die per plant de benodigde gegevens aanlevert.',
            ]],
            ['title' => 'Technische Keuzes', 'paragraphs' => [
                'Na wat onderzoek leek het ons een goed idee om Electron te gebruiken voor het dashboard. We kwamen er echter al snel achter dat Electron voornamelijk bedoeld is voor desktopapplicaties, wat een beperking bleek zodra we daadwerkelijk data moesten gaan versturen en verwerken.',
                'Aanvankelijk overwogen we om een aparte Flask-applicatie toe te voegen als backend, naast Electron. Na overleg met een docent besloten we echter om de volledige applicatie in Flask te bouwen, zonder Electron.',
                'Twee frameworks naast elkaar gebruiken voelde omslachtig, terwijl Flask in principe alle functionaliteit kon bieden die we nodig hadden.',
            ]],
            ['title' => 'Functionaliteiten', 'paragraphs' => [
                'Naast onze eigen code maakten we gebruik van twee externe API\'s. De Perenual API levert data van specifieke plantensoorten, die automatisch wordt ingevuld op de bijbehorende pagina van elke plant.',
                'De Weerlive API zorgt ervoor dat actuele weersomstandigheden worden meegenomen in het systeem, aangezien planten sterk afhankelijk zijn van het weer: bij hoge temperaturen is bijvoorbeeld extra water nodig.',
            ]],
            ['title' => 'Vervolgopdracht', 'paragraphs' => [
                'Nadat de opdracht was afgerond, mochten wij als groep verder werken aan Smart Garden, terwijl de rest van de klas aan een nieuw project begon. Deze kans grepen we uiteraard met beide handen aan.',
                'De vervolgopdracht hield in dat we een pomp moesten aansturen die zich bevindt in het Smart Building bij The Field. Op dit moment kwam een extra teamlid ons versterken, gespecialiseerd in embedded systems en Linux.',
                'De pomp zelf was ontworpen en gebouwd door studenten van de opleiding Technicus Engineering bij mboRijnland. Voor de aansturing bedachten wij een oplossing waarbij een Raspberry Pi 4 fungeert als centrale controller, waarin alle logica van het systeem samenkomt.',
                'Omdat deze Raspberry Pi fysiek bij The Field stond en we niet altijd ter plaatse konden zijn, zetten we een reverse tunnel op via SSH. Op die manier konden we de Raspberry Pi op elk moment programmeren, uiteraard zonder deze op de pomp aangesloten te hebben, om problemen zoals overstroming te voorkomen.',
                'Het bestaande dashboard werd tegelijkertijd verder uitgebreid, zodat het ook daadwerkelijk kon samenwerken met deze fysieke realisatie.',
            ]],
            ['title' => 'De Oplevering', 'paragraphs' => [
                'Vanaf dit punt werkten we nauw samen met de studenten van Technicus Engineering, die de pomp hadden gebouwd. Deze samenwerking verliep uitstekend, mede dankzij de motivatie aan beide kanten.',
                'De oplevering ging niet zonder slag of stoot: we kregen te maken met een onstabiele wifiverbinding, verkeerd gekalibreerde sensoren, en het feit dat vrijwel alles nieuw voor ons was.',
                'Uiteindelijk slaagden we erin een werkend systeem op te leveren: de pomp geeft de planten sindsdien automatisch elke twee weken water. De sensoren werden bij deze oplevering nog niet gebruikt, door problemen die grotendeels buiten onze macht lagen.',
            ]],
            ['title' => 'Overdracht', 'paragraphs' => [
                'Via een pitch bij het DIF in Zoetermeer werden studenten van de Haagse Hogeschool enthousiast gemaakt om Smart Garden voort te zetten.',
                'Zij bouwen voort op de Raspberry Pi 4 als centraal brein van het systeem, en breiden dit uit met sensoren voor grondvochtigheid per plantenbak, een sensor voor luchtvochtigheid in de kas en een lichtsensor.',
                'Daarnaast zetten zij de ChatGPT API in om automatisch gegevens per individuele plant in te vullen, en is het plan om een camera aan de kas te koppelen zodat kunstmatige intelligentie vroegtijdig bedreigingen kan signaleren in het dashboard.',
            ]],
            ['title' => 'Doelstelling', 'paragraphs' => [
                'Het einddoel van Smart Garden is een volledig werkend algoritme dat elke individuele plant van water voorziet, gebaseerd op data uit de Perenual API en aangestuurd via het MQTT-protocol.',
                'Daarnaast moet het dashboard volledig functioneren, met correcte data en werkende grafieken op alle pagina\'s. Indien mogelijk, met het oog op beveiliging, is het streven om de website ook daadwerkelijk beschikbaar te stellen voor gebruik door The Field zelf.',
                'Gedurende dit project heb ik geleerd te werken met SSH-verbindingen, de basis van het Linux-besturingssysteem, het ophalen en verwerken van sensordata, het versturen en ophalen van data via API\'s, basiskennis van algoritmes, het maken van grafieken met ChartJS, werken met Python en Flask, en het gebruik van het MQTT-protocol voor sensordata.',
            ]],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function smartGardenDesktopComponents(): array
    {
        return $this->groupedComponents([
            ProjectComponentGroup::Hardware->value => ['Capacitive Soil Moisture Sensor', 'Raspberry Pi 4'],
            ProjectComponentGroup::Software->value => ['JSON', 'ChartJS', 'Flask'],
            ProjectComponentGroup::Protocol->value => ['SSH (Secure Shell)', 'MQTT (Message Queuing Telemetry Transport)', 'API', 'Perenual API', 'Weerlive API'],
        ]);
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function smartGardenMobileChapters(): array
    {
        return [
            ['title' => 'Introductie', 'paragraphs' => [
                'Nadat de desktopversie van Smart Garden was opgeleverd, kreeg ik de kans om het project in mijn eigen eindexamen Mobile Development verder uit te werken. In plaats van vanaf nul te beginnen, besloot ik het concept van Smart Garden om te zetten naar een mobiele applicatie.',
                'Doordat ik inmiddels meer ervaring en kennis had opgedaan, kon ik het project met een beter overzicht en een duidelijkere structuur aanpakken dan de eerste keer.',
            ]],
            ['title' => 'Doel en Doelgroep', 'paragraphs' => [
                'Het doel van de mobiele applicatie is om eigenaren van verticale tuinen, met name medewerkers van The Field, een gebruiksvriendelijke manier te bieden om sensoren en pompen op afstand te monitoren en aan te sturen.',
                'Gebruikers kunnen via de app bodemvochtigheid en andere gegevens inzien, irrigatieschema\'s instellen, planten toevoegen en historische data raadplegen. Er is bewust gekozen voor verschillende gebruikersrollen: normale gebruikers kunnen enkel gegevens inzien, terwijl admins volledige controle hebben over het beheer van de tuin.',
            ]],
            ['title' => 'Technische Keuzes', 'paragraphs' => [
                'Voor de applicatie zelf koos ik voor React Native met TypeScript, een framework waar ik al goed mee overweg kon en dat het mogelijk maakt om in de toekomst ook op iOS uit te breiden.',
                'Voor de backend bouwde ik eerst een eigen API in Node.js, maar stapte ik uiteindelijk over naar Flask, omdat Python prettiger werkte dan JavaScript voor dit deel van het project.',
                'Lokale data, zoals gebruikers- en plantgegevens, wordt opgeslagen met AsyncStorage in plaats van een volwaardige database, nadat meerdere pogingen om een database te implementeren niet naar wens verliepen. Wachtwoorden worden hierbij wel gehasht opgeslagen, zodat de gegevens toch enigszins beschermd blijven.',
            ]],
            ['title' => 'Raspberry Pi', 'paragraphs' => [
                'Voor de communicatie met de sensoren en de pomp bij The Field, die worden aangestuurd door een Raspberry Pi 4, koos ik voor een SSH-verbinding waarbij JSON-bestanden via het SCP-protocol werden uitgewisseld.',
                'Op mijn mobiel gebruikte ik Termux om deze verbinding op te zetten en om een kleine Node.js-server te draaien die de data via HTTP-verzoeken beschikbaar maakte voor de app.',
                'Deze opzet werkte in eerste instantie goed, maar na verloop van tijd viel de SSH-verbinding meerdere keren onverwacht uit en bleef deze onbeschikbaar. Om de applicatie toch volledig werkend te krijgen, heb ik ervoor gekozen om de sensordata tijdelijk hardcoded in de Flask-API te plaatsen, zodat de rest van de app wel volledig getest en getoond kon worden.',
            ]],
            ['title' => 'Functionaliteiten', 'paragraphs' => [
                'De applicatie bevat onder andere een inlog- en registratiesysteem, een homepagina met een vijfdaagse weersverwachting en een overzicht van de planten aan beide kanten van de kas, en een pagina met alle ooit toegevoegde planten.',
                'Op de pagina van een individuele plant wordt automatisch een deel van de gegevens ingevuld via de Perenual API, en kan de aanwezigheid, locatie en status van de plant worden beheerd.',
                'Daarnaast zijn er aparte pagina\'s voor sensoren, pompen en een logboek van data en foutmeldingen. Alleen admin-gebruikers kunnen planten toevoegen, wijzigen of verwijderen en hebben toegang tot beheerfuncties zoals het verwijderen van de database.',
            ]],
            ['title' => 'Problemen', 'paragraphs' => [
                'Naast de wegvallende SSH-verbinding liep ik tegen een aantal andere technische uitdagingen aan. React Native ondersteunt standaard geen interne communicatie binnen hetzelfde domein, waardoor ik CORS goed moest configureren om de app en de Flask-API probleemloos met elkaar te laten praten.',
                'Ook het opslaan van gevoelige gegevens, zoals API-sleutels, in een apart .env-bestand bleek problematisch: na het toevoegen van de benodigde dependency crashte de applicatie volledig, zonder dat ik de oorzaak kon achterhalen. Uiteindelijk heb ik ervoor gekozen om deze gegevens, noodgedwongen, hardcoded in de applicatie te verwerken.',
            ]],
            ['title' => 'Toevoegingen', 'paragraphs' => [
                'Tijdens de ontwikkeling heb ik een aantal functionaliteiten toegevoegd die niet in het oorspronkelijke ontwerp stonden. Zo kan er per plant een irrigatieschema worden ingesteld, waarin wordt bijgehouden hoe vaak een plant water nodig heeft en wanneer de volgende irrigatie gepland staat.',
                'Ook kunnen admins alle gegevens van een plant achteraf aanpassen, en heb ik een functie toegevoegd om planten volledig uit het systeem te verwijderen, iets wat in eerste instantie ontbrak.',
            ]],
            ['title' => 'Ongerealiseerd', 'paragraphs' => [
                'Niet alles is gelukt zoals oorspronkelijk gepland. Het automatisch invullen van plantgegevens bleek uiteindelijk complexer dan gedacht, omdat hiervoor eigenlijk twee API\'s nodig waren in plaats van één: een vertaal-API om de ingevoerde tekst naar het Engels om te zetten, voordat deze als parameter aan de Perenual API kon worden meegegeven.',
                'Ook een exportfunctie voor sensor- en plantdata naar CSV of PDF heb ik uiteindelijk laten liggen, omdat ik meer tijd kwijt was aan het afronden van de kernfunctionaliteit dan verwacht.',
                'Live sensordata kon door de wegvallende SSH-verbinding niet worden gerealiseerd, en de sensoren zelf waren op het moment van opleveren ook nog niet fysiek in de kas geïmplementeerd.',
                'De functionaliteit om de pomp op afstand aan te sturen is technisch wel aanwezig, maar bewust niet volledig actief gemaakt: zonder een stabiele verbinding en zonder toezicht durfde ik het risico niet te nemen dat de pomp niet meer uitgeschakeld zou kunnen worden.',
            ]],
            ['title' => 'Kwaliteitsborging', 'paragraphs' => [
                'Om de betrouwbaarheid van de applicatie te waarborgen, heb ik uitgebreid handmatig getest aan de hand van vooraf opgestelde testcases, gericht op zowel de normale gebruiker als de admin.',
                'Vrijwel alle geteste functionaliteiten, zoals registreren, inloggen, planten toevoegen, filteren en verwijderen, bleken succesvol te werken. Eén test bracht aan het licht dat er geen foutmelding werd getoond bij het invoeren van een ongeldige gebruikersnaam, wat ik vervolgens heb opgelost door een validatiefunctie en een duidelijke foutmelding toe te voegen.',
            ]],
            ['title' => 'Eindresultaat', 'paragraphs' => [
                'Het eindresultaat is een volledig functionerende mobiele applicatie die het beheer van een verticale tuin overzichtelijk en toegankelijk maakt, ook al draait een deel van de data momenteel nog op hardcoded waarden in plaats van live sensordata.',
                'Mocht de SSH-verbinding met de Raspberry Pi in de toekomst weer stabiel werken, dan zou de overstap naar echte live data relatief snel te realiseren moeten zijn.',
                'Dit project heeft mij vooral veel geleerd over het combineren van mobiele ontwikkeling met hardware-integratie, en over hoe je omgaat met onderdelen die, ondanks je beste inspanningen, niet altijd volledig naar wens werken.',
            ]],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function smartGardenMobileComponents(): array
    {
        return $this->groupedComponents([
            ProjectComponentGroup::Hardware->value => ['Raspberry Pi 4', 'GPIO (General Purpose Input/Output)'],
            ProjectComponentGroup::Sensor->value => ['Soil Moisture Sensor'],
            ProjectComponentGroup::Software->value => ['JSON', 'AsyncStorage', 'Termux', 'Expo'],
            ProjectComponentGroup::Protocol->value => ['SSH (Secure Shell)', 'SCP (Secure Copy Protocol)', 'HTTP', 'CORS (Cross-Origin Resource Sharing)', 'API', 'Perenual API', 'Weer API'],
        ]);
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function bramChapters(): array
    {
        return [
            ['title' => 'Introductie', 'paragraphs' => [
                'Dit project werd aan ons aangeboden door de gemeente Zoetermeer.',
                'Het was mijn eerste project voor mobiel. Deze applicatie moest het voor ouderen gemakkelijker maken om met de mobiel overweg te kunnen.',
                'Omdat ouderen vaak moeilijker mee kunnen komen met de technologie, kregen wij de opdracht om een applicatie te maken waarmee ouderen wat makkelijker overweg kunnen.',
            ]],
            ['title' => 'Visie en Doelstelling', 'paragraphs' => [
                'De voornaamste doelstelling was dat ouderen door het gebruik van deze app niet tegen beperkingen zouden aanlopen.',
                'Zo hebben wij verschillende ouderen geïnterviewd over wat voor hen nou zo belangrijk is om in deze applicatie te hebben.',
                'Waar vrijwel iedereen het over eens was, was veiligheid. Er moest binnen de app een duidelijke \'noodknop\' zijn waarmee externe hulp ingeschakeld kan worden.',
                'Ook vonden de ouderen het erg belangrijk om gemakkelijk toegang tot foto\'s te hebben, vooral die van hun eigen familie.',
            ]],
            ['title' => 'Besluitvorming', 'paragraphs' => [
                'Vanuit school was er de optie om dit project te maken met de kennis die wij al hadden. Dat hield in dat wij de applicatie met HTML, CSS en JavaScript mochten bouwen.',
                'Voor wie een wat grotere uitdaging zocht, was er de mogelijkheid om het project in Android Studio te maken.',
                'Uiteraard koos mijn projectgroep voor de tweede optie: Android Studio. Binnen Android Studio hadden we vervolgens nog de keuze tussen twee programmeertalen: Java of Kotlin.',
                'Na wat onderzoek te hebben gedaan, besloten wij het in Java te maken, vooral omdat Java een meer gebruikte taal is dan Kotlin. Het leek ons daardoor een grotere toegevoegde waarde om Java te leren.',
            ]],
            ['title' => 'Taakverdeling', 'paragraphs' => [
                'Er moesten vier hoofdpagina\'s gerealiseerd worden. Dat kwam mooi uit, want we waren ook met precies vier man.',
                'De \'Lampen\'-pagina was aan mij toegekend, samen met het opzetten van de applicatie in Android Studio.',
                'Zodra ik begreep hoe alles werkte binnen Android Studio, heb ik dit uitgelegd aan de rest van mijn groepje. Uiteraard zochten zij zelf ook het een en ander uit, maar ik neem meestal de leiding op me omdat ik altijd een duidelijk overzicht wil hebben van hoe alles werkt, zodat ik ook kan helpen mocht er ergens iets vastlopen. Daarnaast was ik ook een stuk ouder dan de rest, wat natuurlijk ook meehielp.',
            ]],
            ['title' => 'Realisatie', 'paragraphs' => [
                'Toen kwam het daadwerkelijke programmeren van de applicatie.',
                'Van een docent kregen wij een inlogcode om via zijn VPS een set JSON-data op te halen waarmee we een lamp konden aansturen. Hiervoor moest namelijk een echte API gemaakt worden waarmee we dingen konden besturen, te beginnen bij die lamp.',
                'Dit gebeurde allemaal via een lokaal wifinetwerk, anders kwamen er weer heel andere veiligheidsaspecten bij kijken.',
                'Het realiseren verliep eigenlijk best vlekkeloos. Wel had ik zelf wat problemen met het inladen van foto\'s via een emulator, maar na vele pogingen is het gelukt. Ik had het zelf graag nog wat \'beter\' willen maken, maar in de laatste week van het project was ik helaas niet op school (ik ging naar een festival dat al gepland stond).',
                'Wel ben ik in constant contact gebleven met mijn projectgroep. Eigenlijk hadden ze mij niet echt nodig, het lukte hen zelf al aardig goed. Vooral Matthijs de Graaf moet ik hiervoor enorm bedanken, want hij zette zich elke dag voor de volle honderd procent in, waardoor het uit handen geven van de leiding mij niet echt zwaar viel.',
            ]],
            ['title' => 'Oplevering', 'paragraphs' => [
                'Zoals wij het project hadden bedacht, zo is het ook geworden!',
                'Ik kijk met een zeer tevreden gevoel terug op dit project. Het werd beoordeeld met een 10/10, wat natuurlijk een enorme boost voor het zelfvertrouwen was.',
            ]],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function bramComponents(): array
    {
        return $this->groupedComponents([
            ProjectComponentGroup::Software->value => ['Android SDK', 'Gradle', 'XML'],
            ProjectComponentGroup::Protocol->value => ['API'],
        ]);
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function zinraChapters(): array
    {
        return [
            ['title' => 'Introductie', 'paragraphs' => [
                'Zinra was een van mijn eerste projecten op school en meteen een bijzonder leerzame ervaring, omdat we voor het eerst met een echte, externe opdrachtgever werkten en het resultaat van ons werk direct zichtbaar was.',
                'Vanuit het Ministerie van Binnenlandse Zaken en Koninkrijksrelaties (BZK) kregen wij de opdracht om orde te scheppen in een enorme hoeveelheid documenten die zich bij het ministerie hadden opgestapeld. Precies daarom was dit project zo leuk om aan te werken: het voelde niet als een bedachte schoolopdracht, maar als een probleem dat er echt toe deed voor een echte opdrachtgever.',
            ]],
            ['title' => 'De Opdracht', 'paragraphs' => [
                'De kern van de opdracht was het efficiënter organiseren en categoriseren van documenten, zodat relevante informatie sneller teruggevonden kon worden en overbodige of dubbele bestanden niet langer voor onnodige rompslomp zorgden.',
                'Vanuit school kregen wij daarbij een concrete technische eis mee: er moest een beslisboom in het systeem verwerkt zitten waarmee de documenten stap voor stap beoordeeld en verwerkt konden worden, en de communicatie hierbij moest via het SMTP-protocol verlopen.',
            ]],
            ['title' => 'Ons Idee', 'paragraphs' => [
                'Om deze opdracht aan te pakken, besloten wij twee afzonderlijke programma\'s te ontwikkelen die elkaar aanvulden.',
                'Het eerste programma was gericht op de mailbox zelf. Omdat e-mails in de kern zijn opgebouwd uit HTML, konden wij de inhoud van binnenkomende mails uitlezen met JavaScript. Door gebruik te maken van het "Bag of Words"-concept, waarbij op basis van de aanwezige woorden een inschatting wordt gemaakt van het onderwerp, kon het systeem automatisch bepalen bij welke categorie een bepaalde mail hoorde. Op deze manier konden documenten en mails al vroegtijdig, nog voordat iemand ze daadwerkelijk had gelezen, worden voorgesorteerd op relevantie.',
                'Het tweede programma bestond uit een website waarmee documenten handmatig gesorteerd konden worden. Een gebruiker kon hier een volledige map of een los document uploaden, waarna zelf bepaald kon worden of het document bewaard moest blijven of verwijderd kon worden. Alle beslissingen werden opgeslagen in een database, die precies bijhield welke documenten behouden moesten blijven en welke weggegooid mochten worden. Een belangrijk voordeel van deze aanpak was dat het ook voorkwam dat er dubbele documenten in het systeem terechtkwamen.',
            ]],
            ['title' => 'Doorzetten', 'paragraphs' => [
                'Gedurende het project ging ik ervan uit dat het eerste programma, de mailbox-applicatie, uiteindelijk niet naar behoren werkte. Ik kreeg namelijk verschillende errors en waarschuwingen te zien, wat mij deed concluderen dat er iets structureel mis was. Pas tegen het einde van het project besloot ik er toch nog eens goed naar te kijken, om te zien of het probleem alsnog op te lossen was.',
                'Tot mijn eigen verbazing bleek de applicatie eigenlijk gewoon te werken. De problemen die ik had gezien, waren uiteindelijk slechts een aantal kleine foutjes die relatief eenvoudig te verhelpen waren. Deze ontdekking was een mooie les in doorzettingsvermogen: soms lijkt iets kapot, terwijl het probleem uiteindelijk een stuk kleiner is dan gedacht.',
            ]],
            ['title' => 'Terugblik', 'paragraphs' => [
                'Helaas ben ik in de loop der tijd het documentatiedossier van dit project kwijtgeraakt, waardoor niet alle details en onderbouwingen van destijds nog beschikbaar zijn.',
                'Toch blijft Zinra een van de projecten waar ik met veel plezier op terugkijk, juist omdat het een van mijn eerste kennismakingen was met het werken voor een echte opdrachtgever, en omdat het liet zien hoe waardevol het kan zijn om ergens niet te snel de handdoek in de ring te gooien.',
            ]],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function zinraComponents(): array
    {
        return $this->groupedComponents([
            ProjectComponentGroup::Protocol->value => ['SMTP (Simple Mail Transfer Protocol)'],
            ProjectComponentGroup::Software->value => ['Bag of Words', 'Beslisboom'],
        ]);
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function portfolioV1Chapters(): array
    {
        return [
            ['title' => 'Introductie', 'paragraphs' => [
                'Uiteraard kan een Portfolio website niet ontbreken bij een Software Ontwikkelaar. Het afgelopen half jaar ben ik dan ook bezig geweest om deze website te maken. Vooral met de intentie om er wat van te leren. Dat is ook een van de voornaamste redenen waarom ik \'plain\' TypeScript code gebruik en geen frontend framework. Een backend framework, tja, die acht ik wel nodig.',
                'Initieel werkte ik met Flask en SQLAlchemy om de database verbinding en templates te tonen, dit omdat ik eerst van plan was om een non-relationail database te gebruiken zoals JSON.',
                'Naarmate het project vorderde, kwam ik er toch achter dat het wel handig kan zijn om al mijn data in een database te hebben.',
            ]],
            ['title' => 'Visie en Doelstelling', 'paragraphs' => [
                'Ik had al enigzins ervaring met Flask en Django. Omdat ik dus niet van plan was een relationele database te gebruiken, besloot ik voor het lichtgewicht framework te gaan Flask.',
                'Als eerste ging ik wat onderzoek doen naar bestaande portfolio websites, kijken hoe anderen die van hun hebben gemaakt.',
                'De meeste protfolio websites die ik tegenkwam waren wel volledig gemaakt met een frontend framework zoals React. Desondanks heb ik er wel de nodige inspiratie van opgedaan.',
            ]],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function portfolioV1Components(): array
    {
        return $this->groupedComponents([
            ProjectComponentGroup::Software->value => ['CI/CD', 'JSON', 'SVG'],
            ProjectComponentGroup::Protocol->value => ['API'],
        ]);
    }
}
