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

class ProjectSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Photos shown in the image grids. The same four images are used for every project until real photos are added.
     */
    private const array PHOTOS = [
        'images/figma/projects/photo-1.webp',
        'images/figma/projects/photo-2.webp',
        'images/figma/projects/photo-3.webp',
        'images/figma/projects/photo-4.webp',
    ];

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

    private const array FRAMEWORKS = ['Laravel', 'Django', 'Flask', 'Electron', 'React Native', 'Vue.js', 'Android Studio'];

    /**
     * Seeds the projects from the Figma design. Running the seeder again updates the existing projects.
     */
    public function run(): void
    {
        foreach ($this->projects() as $index => $data) {
            $project = Project::query()->updateOrCreate(
                ['slug' => $data['slug']],
                collect($data)->except(['slug', 'types', 'cardTechnologies', 'detailTechnologies', 'chapters', 'chapterTranslations', 'components', 'contributors'])
                    ->put('sort_order', $index + 1)
                    ->all(),
            );

            $this->syncTypes($project, $data['types']);
            $this->syncTechnologies($project, $data['cardTechnologies'], 'card');
            $this->syncTechnologies($project, $data['detailTechnologies'] ?? [], 'detail');
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
                'repository_url' => 'https://www.github.com/znooptokkie/battlebot',
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
                    ['name' => 'A. Oomen', 'role' => 'Development', 'url' => 'https://github.com/example'],
                    ['name' => 'M. de Graaf', 'role' => 'Development', 'url' => 'https://github.com/example'],
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

        foreach (self::PHOTOS as $index => $path) {
            $project->images()->create([
                'path' => $path,
                'caption' => $index === 0 ? $project->story_lead : null,
                'sort_order' => $index + 1,
            ]);
        }
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

        return collect($groups)
            ->flatMap(fn (array $names, string $group): array => array_map(
                fn (string $name): array => ['group' => ProjectComponentGroup::from($group), 'name' => $name],
                $names,
            ))
            ->values()
            ->all();
    }
}
