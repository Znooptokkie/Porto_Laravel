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
     * The photo that is shown first in the slideshow and on the overview card, keyed by project slug.
     */
    private const array FIRST_PHOTOS = [
        'smart-garden-desktop' => 'gg_ik_bij_hh.webp',
        'zinra' => 'zinra_ik_bij_BZK.webp',
        'plymouth' => 'plymouth_groepsfoto.webp',
        'battlebot' => 'battlebot_screen_picture.webp',
        'portfolio-v1' => 'porto_1_homepage_head.webp',
        'portfolio-v2' => 'porto_2_homepage_head.webp',
    ];

    /**
     * Alt texts per photo, keyed by project slug and file name. Fill in 'nl' and 'en'; an empty value means no alt text.
     */
    private const array IMAGE_ALTS = [
        'battlebot' => [
            'battlebot_all_components_blueprint.webp' => ['nl' => 'Het complete communicatieschema - alle onderdelen van de Battlebot met elkaar verbonden', 'en' => 'The complete communication blueprint, connecting all components of the Battlebot'],
            'battlebot_circuit_blueprint.webp' => ['nl' => 'Het elektronische schema waarin alle verbindingen en circuits samenkomen', 'en' => 'The electronic circuit blueprint, bringing all connections and circuits together'],
            'battlebot_frontview.webp' => ['nl' => 'Een kijkje aan de voorkant van de Battlebot, met het brein buiten zijn behuizing', 'en' => 'A front view of the Battlebot, with its brain outside the enclosure'],
            'battlebot_huge_mess_topview.webp' => ['nl' => 'Een indrukwekkende wirwar van kabels en componenten, van bovenaf bekeken', 'en' => 'An impressive tangle of wires and components, viewed from above'],
            'battlebot_huge_mess.webp' => ['nl' => 'Waar alle kabels en componenten samenkomen - georganiseerde chaos in volle glorie', 'en' => 'Where all the wires and components come together: organised chaos in all its glory'],
            'battlebot_mcp_connection.webp' => ['nl' => 'De MCP2515-modules die de CAN-buscommunicatie tussen de verschillende onderdelen mogelijk maken', 'en' => 'The MCP2515 modules enabling CAN bus communication between the different components'],
            'battlebot_screen_picture.webp' => ['nl' => 'Een uniek perspectief - een selfie gemaakt door de camera van de Battlebot', 'en' => 'A unique perspective: a selfie captured by the Battlebot’s own camera'],
            'battlebot_selfmade_module_topview.webp' => ['nl' => 'Een bovenaanzicht van de zelfontworpen en gebouwde elektronische module', 'en' => 'A top-down view of the custom-designed and built electronic module'],
            'battlebot_selfmade_module.webp' => ['nl' => 'De zelfgebouwde elektronische module, netjes op zijn plek in de behuizing', 'en' => 'The custom-built electronic module, neatly fitted inside its enclosure'],
            'battlebot_sideview.webp' => ['nl' => 'Een kijkje vanaf de zijkant - de Battlebot in volle glorie', 'en' => 'A side view of the Battlebot in all its glory'],
            'battlebot_view_top.webp' => ['nl' => 'De Battlebot van bovenaf, gespot in zijn natuurlijke habitat', 'en' => 'The Battlebot from above, spotted in its natural habitat'],
            'battlebot_controller.webp' => ['nl' => 'Tijd voor een kleine aanpassing - de controller opengemaakt om de joysticks helemaal naar eigen smaak af te stellen', 'en' => 'Time for a little modification - opening up the controller to customise the joysticks to my liking'],
            'battlebot_custom_module.webp' => ['nl' => 'Passen, meten en experimenteren - stap voor stap krijgt de zelfontworpen module vorm', 'en' => 'Measuring, fitting and experimenting - the custom-designed module gradually taking shape'],
            'battlebot_expensive_mistake.webp' => ['nl' => 'Een wijze, maar prijzige les - vertrouw er niet blindelings op dat een buck converter altijd doet wat hij moet doen', 'en' => 'A valuable but costly lesson - never blindly assume a buck converter will always do its job'],
            'battlebot_HC-SR04_test.webp' => ['nl' => 'Eerst even testen - een proefopstelling om de HC-SR04-afstandssensoren aan de tand te voelen', 'en' => 'First, some testing - a test setup to put the HC-SR04 ultrasonic distance sensors through their paces'],
            'battlebot_mcp2515-module.webp' => ['nl' => 'Een bovenaanzicht van de gekoppelde MCP2515-modules - klaar voor CAN-buscommunicatie', 'en' => 'A top-down view of the connected MCP2515 modules - ready for CAN bus communication'],
            'battlebot_mcp2515.webp' => ['nl' => 'Een losse MCP2515-module - de schakel die CAN-buscommunicatie mogelijk maakt', 'en' => 'A standalone MCP2515 module - the component that makes CAN bus communication possible'],
            'battlebot_pico.webp' => ['nl' => 'De Raspberry Pi Pico 2 W gekoppeld aan een MCP2515-module - twee componenten die de handen ineenslaan', 'en' => 'The Raspberry Pi Pico 2 W connected to an MCP2515 module - two components working hand in hand'],
            'battlebot_under_the_hood.webp' => ['nl' => 'Een eerste blik onder de motorkap - kennismaken met de verschillende onderdelen waaruit de Battlebot is opgebouwd', 'en' => 'A first look under the hood - exploring the different components that make up the Battlebot'],
        ],
        'bram' => [
            'bram_contact.webp' => ['nl' => 'Een overzicht van alle contacten binnen BRAM', 'en' => 'An overview of all contacts in BRAM'],
            'bram_foto.webp' => ['nl' => 'Een kijkje in de fotogalerij, waar alle herinneringen samenkomen', 'en' => 'A look inside the photo gallery, where all the memories come together'],
            'bram_home.webp' => ['nl' => 'Het startscherm van BRAM, het centrale punt voor de bediening van je slimme huis', 'en' => 'The BRAM home screen, the central hub for controlling your smart home'],
            'bram_lichten.webp' => ['nl' => 'De lichtbediening van BRAM, waarmee je de verlichting in huis naar wens kunt regelen', 'en' => 'BRAM’s lighting controls, letting you adjust the lights throughout your home'],
            'bram_loadingscreen.webp' => ['nl' => 'Een eerste kennismaking met BRAM - het laadscherm dat verschijnt bij het opstarten van de applicatie', 'en' => 'A first introduction to BRAM - the loading screen displayed when the application starts'],
            'bram_verwarming.webp' => ['nl' => 'De verwarmingsbediening van BRAM, waarmee je de temperatuur in huis kunt regelen', 'en' => 'BRAM’s heating controls, allowing you to adjust the temperature throughout your home'],
        ],
        'smart-garden-desktop' => [
            'gg_ik_bij_hh.webp' => ['nl' => 'Ik als challengegever tijdens het begeleiden van studenten aan De Haagse Hogeschool', 'en' => 'Me presenting a challenge while mentoring students at The Hague University of Applied Sciences'],
            'gg_add_plant.webp' => ['nl' => 'Het formulier waarmee je een nieuwe plant aan je dashboard toevoegt', 'en' => 'The form used to add a new plant to your dashboard'],
            'gg_api_request.webp' => ['nl' => 'Het moment waarop de applicatie plantgegevens opvraagt bij de Perenual API', 'en' => 'The moment the application requests plant information from the Perenual API'],
            'gg_api_result.webp' => ['nl' => 'De ontvangen API-resultaten - de gevonden plantnaam kwam nog niet helemaal overeen met de oorspronkelijke zoekopdracht', 'en' => 'The returned API results - the identified plant name did not yet fully match the original search query'],
            'gg_homepage.webp' => ['nl' => 'Het complete Smart Garden-dashboard met alle belangrijke onderdelen op één plek', 'en' => 'The complete Smart Garden dashboard, bringing all the key features together in one place'],
            'gg_plant_info.webp' => ['nl' => 'De informatiepagina van een plant - met alle bijbehorende gegevens overzichtelijk bij elkaar', 'en' => 'A plant’s information page - bringing all its details together in one clear overview'],
            'gg_settings.webp' => ['nl' => 'De instellingenpagina waar gebruikers hun persoonlijke gegevens kunnen aanpassen of verwijderen', 'en' => 'The settings page where users can update or delete their personal information'],
            'gg_breadboards.webp' => ['nl' => 'Een kijkje bij The Field - de verschillende breadboards waarop de Smart Garden-elektronica is opgebouwd', 'en' => 'A look inside The Field - the various breadboards used to build the Smart Garden electronics'],
            'gg_pomp.webp' => ['nl' => 'De waterpomp die ervoor zorgt dat de planten in de kas op tijd hun water krijgen', 'en' => 'The water pump responsible for keeping the plants in the greenhouse properly watered'],
            'gg_relais.webp' => ['nl' => 'De relaismodule die de schakelingen van de pompen en kleppen voor zijn rekening neemt', 'en' => 'The relay module responsible for switching the pumps and valves'],
            'gg_single_breadboard.webp' => ['nl' => 'Een close-up van een van de breadboards - waar de elektronische verbindingen tot leven komen', 'en' => 'A close-up of one of the breadboards - where the electronic connections come to life'],
            'gg_the_field.webp' => ['nl' => 'Een blik op The Field - de kas waarvoor het Smart Garden-project is ontwikkeld', 'en' => 'A look at The Field - the greenhouse for which the Smart Garden project was developed'],
        ],
        'smart-garden-mobiel' => [
            'gg_mob_all_plants.webp' => ['nl' => 'Een compleet overzicht van alle planten die momenteel in de kas groeien', 'en' => 'A complete overview of all the plants currently growing in the greenhouse'],
            'gg_mob_homepage.webp' => ['nl' => 'Het startscherm van de Smart Garden-app - alle belangrijke onderdelen binnen handbereik', 'en' => 'The Smart Garden app home screen - all the essential features right at your fingertips'],
            'gg_mob_login.webp' => ['nl' => 'Het inlogscherm waarmee gebruikers toegang krijgen tot de Smart Garden-app', 'en' => 'The login screen where users can access the Smart Garden app'],
            'gg_mob_log.webp' => ['nl' => 'Het logboek waarin foutmeldingen en andere gebeurtenissen worden bijgehouden', 'en' => 'The logbook keeping track of errors and other application events'],
            'gg_mob_plant_info.webp' => ['nl' => 'Een kijkje bij alle informatie over een specifieke plant', 'en' => 'A closer look at all the information about a specific plant'],
            'gg_mob_pump.webp' => ['nl' => 'Een overzicht van alle pompen - met de mogelijkheid om ze afzonderlijk in of uit te schakelen', 'en' => 'An overview of all pumps - with the ability to switch each one on or off'],
            'gg_mob_sensors.webp' => ['nl' => 'Een overzicht van alle sensoren die in de kas de omstandigheden in de gaten houden', 'en' => 'An overview of all sensors monitoring conditions inside the greenhouse'],
            'gg_mob_settings.webp' => ['nl' => 'De instellingenpagina waar gebruikers hun persoonlijke voorkeuren en gegevens kunnen aanpassen', 'en' => 'The settings page where users can adjust their personal preferences and information'],
        ],
        'zinra' => [
            'zinra_ik_bij_BZK.webp' => ['nl' => 'Mijn taak was om de gerealiseerde projecten kort toe te lichten aan de aanwezigen bij het ministerie van BZK', 'en' => 'My task was to briefly present the completed projects to attendees at the Ministry of the Interior and Kingdom Relations'],
            'zinra_app.webp' => ['nl' => 'De virtuele assistent op de website - gebruikers worden stap voor stap door een reeks vragen geleid', 'en' => 'The virtual assistant on the website - guiding users step by step through a series of questions'],
            'zinra_home.webp' => ['nl' => 'Zinra aan het werk in de Outlook-mailbox - de virtuele assistent helpt bij het verwerken van binnenkomende e-mails', 'en' => 'Zinra at work in the Outlook inbox - the virtual assistant helps process incoming emails'],
            'zinra_mail.webp' => ['nl' => 'Het herkenbare Zinra-pictogram in Outlook - de toegangspoort tot de virtuele assistent', 'en' => 'The recognisable Zinra icon in Outlook - the gateway to the virtual assistant'],
            'zinra_unimportant.webp' => ['nl' => 'Zinra heeft zijn oordeel gevormd - deze e-mail is na analyse als onbelangrijk gemarkeerd', 'en' => 'Zinra has made its decision - after analysis, this email has been marked as unimportant'],
            'zinra_website_manual.webp' => ['nl' => 'Het handmatig doorzoeken van verschillende documenten - precies het tijdrovende werk dat Zinra helpt automatiseren', 'en' => 'Manually searching through various documents - exactly the time-consuming task Zinra helps automate'],
        ],
        'automatische-trapverlichting' => [
            'trap_all_mosfets_test.webp' => ['nl' => 'Alle MOSFETs op een breadboard - tijd om te controleren of ze doen wat ze moeten doen', 'en' => 'All MOSFETs mounted on a breadboard - time to check if they do what they are supposed to do'],
            'trap_both_sensors_test.webp' => ['nl' => 'Beide sensoren tegelijk aan het werk - een test om te ontdekken of ze elkaar niet in de weg zitten', 'en' => 'Both sensors working side by side - a test to see if they interfere with each other'],
            'trap_pcb_soldered.webp' => ['nl' => 'Het eindresultaat - de volledig gesoldeerde PCB met alle componenten netjes op hun plek', 'en' => 'The finished result - the fully soldered PCB with all components neatly in place'],
            'trap_pcb_soldering_pieces.webp' => ['nl' => 'Alle elektronische onderdelen klaargelegd - tijd om ze een voor een op de PCB te solderen', 'en' => 'All electronic components laid out and ready - time to solder them onto the PCB one by one'],
            'trap_single_mosfet_test.webp' => ['nl' => 'Eerst klein beginnen - een enkele MOSFET testen voordat de rest erbij komt', 'en' => 'Starting small - testing a single MOSFET before adding the rest'],
            'trap_single_sensor_test.webp' => ['nl' => 'Eerst één sensor aan het werk zetten en daarna de tweede toevoegen', 'en' => 'Getting one sensor up and running first, before bringing in the second'],
            'trap_transformer_test.webp' => ['nl' => 'De voeding van het systeem - deze transformator levert de benodigde 24 volt', 'en' => 'The system’s power supply - this transformer provides the required 24 volts'],
            'trap_whole_setup_test.webp' => ['nl' => 'Alles aangesloten en klaar voor de grote test - werkt het complete systeem zoals bedoeld?', 'en' => 'Everything connected and ready for the big test - does the complete system work as intended?'],
        ],
        'plymouth' => [
            'plymouth_all_robots.webp' => ['nl' => 'Een vrolijk overzicht van alle robots - ieder voorzien van een afbeelding die door de studenten zelf is uitgekozen', 'en' => 'A cheerful overview of all the robots - each featuring an image chosen by the students themselves'],
            'plymouth_doolhof.webp' => ['nl' => 'Een student in actie tijdens de doolhofuitdaging - op zoek naar de juiste route naar de finish', 'en' => 'A student taking on the maze challenge - searching for the right path to the finish'],
            'plymouth_groepsfoto.webp' => ['nl' => 'Een groepsfoto met mij, Atilla, mijn medestudent Matthijs en de volledige groep studenten', 'en' => 'A group photo featuring me, Atilla, my fellow student Matthijs and the entire group of students'],
            'plymouth_maze.webp' => ['nl' => 'Het doolhof was een van de uitdagingen waarmee studenten punten konden verdienen', 'en' => 'The maze was one of the challenges through which students could earn points'],
            'plymouth_medestudent_matthijs.webp' => ['nl' => 'Mijn medestudent Matthijs houdt de scores nauwlettend bij tijdens de uitdagingen', 'en' => 'My fellow student Matthijs keeping a close eye on the scores during the challenges'],
            'plymouth_rocket.webp' => ['nl' => 'De studenten kwamen zelf op het idee om Rocket League na te bouwen met hun robots', 'en' => 'The students came up with the idea of recreating Rocket League using their robots'],
            'plymouth_maze_explaining.webp' => [
                'nl' => 'Een student staat klaar om aan het doolhof te beginnen. Aan mij de taak om de spelregels uit te leggen.',
                'en' => 'A student is getting ready to start the maze challenge. My task is to explain the rules of the game.',
            ],
            'plymouth_topview_rocket.webp' => [
                'nl' => 'Een bovenaanzicht van een potje Rocket League in volle gang.',
                'en' => 'An overhead view of a Rocket League match in progress.',
            ],
            'plymouth_watching.webp' => [
                'nl' => 'Ik houd het spel Rocket League nauwlettend in de gaten.',
                'en' => 'I am keeping a close eye on the Rocket League match.',
            ],
        ],
        'dungeon-crawler' => [
            'crawler_battleview.webp' => ['nl' => 'Het Figma-ontwerp van de gevechtsfase - zo ziet een confrontatie met vijanden er straks uit', 'en' => 'The Figma design of the battle phase - a preview of what encounters with enemies will look like'],
            'crawler_dungeonview.webp' => ['nl' => 'Het Figma-ontwerp van de dungeon - een eerste indruk van de omgeving waarin spelers op avontuur gaan', 'en' => 'The Figma design of the dungeon - an early look at the environment where players embark on their adventure'],
            'crawler_enemy.webp' => ['nl' => 'Het daadwerkelijke spel in actie - een vijand verschijnt in de kamer, voorlopig nog met een zelfgemaakte placeholder', 'en' => 'The actual game in action - an enemy appears in the room, currently using a quickly created placeholder'],
            'crawler_homescreen.webp' => ['nl' => 'Het startscherm van de website - de eerste kennismaking met de wereld van Dungeon Crawler', 'en' => 'The website home screen - the first introduction to the world of Dungeon Crawler'],
            'crawler_open_chest.webp' => ['nl' => 'Een geopende schatkist in de dungeon - tijd om te ontdekken welke buit erin verborgen zit', 'en' => 'An opened treasure chest in the dungeon - time to discover what loot is hidden inside'],
            'crawler_roomview.webp' => ['nl' => 'De eerste kamer van Dungeon Level 1 - hier begint het avontuur voor iedere speler', 'en' => 'The first room of Dungeon Level 1 - where every player’s adventure begins'],
        ],
        'portfolio-v1' => [
            'porto_1_about_me.webp' => [
                'nl' => 'De pagina Over Mij, waarop ik kort beschrijf wie ik ben en wat mij typeert.',
                'en' => 'The About Me page, where I briefly describe who I am and what defines me.',
            ],
            'porto_1_education.webp' => [
                'nl' => 'De pagina Mijn Opleidingen, waarop ik mijn afgeronde opleidingen en behaalde certificaten presenteer.',
                'en' => 'The My Education page, where I present my completed studies and earned certificates.',
            ],
            'porto_1_homepage_head.webp' => [
                'nl' => 'De introductiesectie van mijn homepage, met een op maat gemaakte SVG-illustratie en een korte introductietekst.',
                'en' => 'The introductory section of my homepage, featuring a custom SVG illustration and a short introduction.',
            ],
            'porto_1_homepage_skills.webp' => [
                'nl' => 'De sectie Vaardigheden, waarin ik mijn ervaring met verschillende technologieën, programmeertalen en andere onderdelen weergeef.',
                'en' => 'The Skills section, where I showcase my experience with various technologies, programming languages and other areas.',
            ],
            'porto_1_homepage_timeline.webp' => [
                'nl' => 'De tijdlijnsectie, waarin ik mijn opleidings- en loopbaanverloop kort toelicht en vertel over de keuzes die ik onderweg heb gemaakt.',
                'en' => 'The timeline section, where I briefly outline my educational and career journey and explain some of the decisions I made along the way.',
            ],
            'porto_1_leetcode.webp' => [
                'nl' => 'De LeetCode-pagina. Deze is voornamelijk bedoeld om mijn eigen voortgang en oplossingen bij te houden, maar is ook interessant om met anderen te delen.',
                'en' => 'The LeetCode page. It is primarily intended to track my own progress and solutions, but is also interesting to share with others.',
            ],
            'porto_1_projects.webp' => [
                'nl' => 'De pagina Mijn Projecten, waarop ik mijn verschillende projecten presenteer in een op maat gemaakte SVG-illustratie.',
                'en' => 'The My Projects page, where I showcase my various projects through a custom SVG illustration.',
            ],
        ],
        'portfolio-v2' => [
            'porto_2_education.webp' => [
                'nl' => 'De pagina De Opleidingen, met mijn MBO 4-opleiding Software Development en de bijbehorende gegevens.',
                'en' => 'The Education page, showing my MBO 4 Software Development programme and its details.',
            ],
            'porto_2_homepage_accent_options.webp' => [
                'nl' => 'De homepage met het paneel voor accentkleuren, waarmee bezoekers de kleur van de site kunnen aanpassen.',
                'en' => 'The homepage with the accent colour panel, where visitors can change the colour of the site.',
            ],
            'porto_2_homepage_head.webp' => [
                'nl' => 'De introductiesectie van de homepage, met mijn naam, functie en een korte introductietekst.',
                'en' => 'The introduction section of the homepage, with my name, role and a short introduction.',
            ],
            'porto_2_homepage_language.webp' => [
                'nl' => 'De homepage met het taalmenu, waarmee bezoekers kunnen kiezen tussen Nederlands en Engels.',
                'en' => 'The homepage with the language menu, where visitors can choose between Dutch and English.',
            ],
            'porto_2_homepage_light_mode.webp' => [
                'nl' => 'De homepage in de lichte modus, met oranje accenten op een lichte achtergrond.',
                'en' => 'The homepage in light mode, with orange accents on a light background.',
            ],
            'porto_2_homepage_skills.webp' => [
                'nl' => 'De sectie Mijn Programmeer Kennis, met mijn programmeertalen, frameworks en AI-tools.',
                'en' => 'The Programming Skills section, showing my programming languages, frameworks and AI tools.',
            ],
            'porto_2_homepage_timeline.webp' => [
                'nl' => 'De tijdlijnsectie, waarin ik mijn schooltijd en werk als schilder toelicht, voorafgaand aan mijn overstap naar softwareontwikkeling.',
                'en' => 'The timeline section, outlining my school years and my work as a painter, leading up to my move into software development.',
            ],
            'porto_2_mobile_filters.webp' => [
                'nl' => 'Het mobiele filtermenu van de projectenpagina, met filters voor onder andere jaartal en programmeertaal.',
                'en' => 'The mobile filter menu on the projects page, with filters for year and programming language, among others.',
            ],
            'porto_2_mobile_menu.webp' => [
                'nl' => 'Het mobiele menu met de navigatielinks en de instellingen voor thema, taal en accentkleur.',
                'en' => 'The mobile menu with the navigation links and the settings for theme, language and accent colour.',
            ],
            'porto_2_projects.webp' => [
                'nl' => 'De projectenpagina met een overzicht van alle projecten en de filters om ze te sorteren.',
                'en' => 'The projects page with an overview of all projects and the filters to sort them.',
            ],
        ],
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
                collect($data)->except(['slug', 'types', 'cardTechnologies', 'detailTechnologies', 'chapters', 'chapterTranslations', 'links', 'components', 'contributors'])
                    ->put('sort_order', $index + 1)
                    ->all(),
            );

            $this->syncTypes($project, $data['types']);
            $this->syncTechnologies($project, $data['cardTechnologies'], 'card');
            $this->syncTechnologies($project, $data['detailTechnologies'] ?? $data['cardTechnologies'], 'detail');
            $this->syncImages($project);
            $this->syncChapters($project, $data['chapters'] ?? [], $data['chapterTranslations'] ?? []);
            $this->syncLinks($project, $data['links'] ?? []);
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
                'translations' => ['en' => [
                    'media_tagline' => '{ sensors x lighting }',
                    'story_lead' => 'The stair lighting: a deeper dive into sensors, MOSFETs and microcontrollers.',
                    'title' => 'Automatic Stair Lighting',
                    'category' => 'EMBEDDED SYSTEMS',
                    'intro_label' => 'EMBEDDED SYSTEMS',
                    'summary' => 'My mother is slowly losing her eyesight, so I decided to build an *automatic lighting system* on the stairs, with *sensors* and *N-MOSFETs*. Everything is controlled by a *Raspberry Pi Pico 2*. I also chose to design my own *PCB* for it, together with the *electrical schematic*.',
                    'subtitle' => 'A fully automated light system',
                    'story_heading' => 'More light in the',
                    'story_heading_accent' => 'darkness',
                    'story_aside' => '// step by step',
                    'organization' => 'Mother\'s home',
                    'department' => 'Stairs',
                ]],
                'title' => 'Automatische Trapverlichting',
                'title_accent' => 'ligth',
                'category' => 'EMBEDDED SYSTEMS',
                'intro_label' => 'EMBEDDED SYSTEMS',
                'started_year' => 2026,
                'ended_year' => null,
                'summary' => 'Mijn moeder kan helaas steeds slechter zien, vandaar dat ik besloot om op de trap een *automatisch lichtsysteem* te maken met *sensoren* en *N-Mosfets*. Dit alles wordt aangestuurd via een *Raspberry Pi Pico 2*. Ook heb ik besloten om een eigen *PCB* hiervoor te ontwerpen, samen met het *elecktrisch schema*.',
                'subtitle' => 'Een nieuwe verdieping in Embedded Systems en elecktronica.',
                'story_lead' => 'De Trapverlichting: de verdere verdieping van sensoren, mosfets en microcontrollers',
                'media_tagline' => '{ hardware × software }',
                'story_heading' => 'Een helpende hand',
                'story_heading_accent' => 'bieden',
                'story_aside' => '// stap voor stap',
                'repository_url' => 'https://github.com/Znooptokkie/Trapverlichting_mosfets',
                'favorite_rank' => 3,
                'status' => ProjectStatus::InConstructie,
                'organization' => 'Moeder haar huis',
                'department' => 'Trap',
                'types' => ['Embedded Systems'],
                'cardTechnologies' => ['MicroPython', 'HC-SR505', 'Pico 2', 'KiCad', 'N-Mosfet'],
                'detailTechnologies' => ['Raspberry Pi Pico 2', 'N-Mosfet', 'MicroPython', 'KiCad', 'HC-SR505'],
                'links' => [
                    [
                        'description' => ['nl' => 'Op Reddit vond ik een post die hetzelfde probleem met de spanning beschrijft.', 'en' => 'On Reddit I found a post describing the same voltage-related problem.'], 'url' => 'https://www.reddit.com/r/esp32/comments/w77tgm/esp32cam_connexion_to_a_pir_motion_sensor_loop/',
                    ],
                    [
                        'description' => ['nl' => 'Deze tutorial heb ik gevolgd om de PCB te ontwerpen.', 'en' => 'This is the tutorial I followed for designing the PCB.'], 'url' => 'https://www.youtube.com/playlist?list=PLUOaI24LpvQPls1Ru_qECJrENwzD7XImd',
                    ],
                ],
                'chapters' => $this->stairLightingChapters(),
                'chapterTranslations' => $this->stairLightingChapterTranslations(),
                'components' => $this->stairLightingComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Developer / Hardware Engineer', 'url' => 'https://github.com/Znooptokkie'],
                ],
            ],
            [
                'slug' => 'battlebot',
                'translations' => ['en' => [
                    'media_tagline' => '{ autonoom x robot }',
                    'title' => 'Battlebot',
                    'category' => 'ROBOTICS / STAGE PROJECT',
                    'intro_label' => 'ROBOTICS / FINAL STAGE PROJECT',
                    'summary' => 'Battlebot was my *final internship project*, in which I turned an existing robot into an intelligent and largely autonomous system, with a *Raspberry Pi 5* and *Pico 2*, *CAN-bus communication* and *AI-driven object detection* via a *Hailo-8 accelerator*.',
                    'subtitle' => 'From an existing robot to an intelligent and largely autonomous system.',
                    'story_lead' => 'The Battlebot: the foundation for autonomous control, sensors and object detection.',
                    'story_heading' => 'From idea to',
                    'story_heading_accent' => 'autonomy',
                    'story_aside' => '// step by step',
                    'organization' => 'mboRijnland',
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
                'favorite_rank' => 4,
                'status' => ProjectStatus::Klaar,
                'organization' => 'mboRijnland',
                'department' => 'Afdeling Techniek',
                'types' => ['Robotica'],
                'cardTechnologies' => ['Python', 'MicroPython', 'CAN-bus', 'AI'],
                'detailTechnologies' => ['Raspberry Pi 5', 'Pico 2', 'MicroPython', 'CAN-bus', 'Hailo-8'],
                'links' => [
                    [
                        'description' => [
                            'nl' => 'De repository met de software voor de Raspberry Pi Pico 2 W.',
                            'en' => 'The repository containing the software for the Raspberry Pi Pico 2 W.',
                        ],
                        'url' => 'https://github.com/BattlebotdeGripper/battlebot_pico',
                    ],
                    [
                        'description' => [
                            'nl' => 'De repository met de implementatie en aansturing van de MCP2515-module.',
                            'en' => 'The repository containing the implementation and control logic for the MCP2515 module.',
                        ],
                        'url' => 'https://github.com/Znooptokkie/mcp2515/',
                    ],
                ],
                'chapters' => $this->battlebotChapters(),
                'chapterTranslations' => $this->battlebotChapterTranslations(),
                'components' => $this->battlebotComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Embedded Software Engineer', 'url' => 'https://github.com/Znooptokkie'],
                    ['name' => 'M. de Graaf', 'role' => 'AI Software Engineer', 'url' => 'https://github.com/Matthijs-de-Graaf'],
                ],
            ],
            [
                'slug' => 'portfolio-v2',
                'translations' => ['en' => [
                    'media_tagline' => '{ software x portfolio }',
                    'story_lead' => 'My Portfolio: a new design, a new way to introduce myself.',
                    'title' => 'Portfolio V2',
                    'category' => 'WEB DEVELOPMENT',
                    'intro_label' => 'WEB DEVELOPMENT / PORTFOLIO',
                    'summary' => 'The first version of my portfolio website was built in *Django (Python)*. I mainly saw it as a learning project. It started out well structured, but ended up as quite a mess. For that reason, and because I wanted to build a complete project with *Claude Code*, I decided to rebuild my portfolio in *Laravel (PHP)*. This time with support from *Figma-MCP* & *Claude Code*.',
                    'subtitle' => 'A revamp from my first portfolio website, now with Claude Code and Figma MCP fully integrated.',
                    'story_heading' => 'My progress in Software',
                    'story_heading_accent' => 'Development',
                    'story_aside' => '// step by step',
                    'organization' => 'Home',
                    'department' => 'Desk',
                ]],
                'title' => 'Portfolio V2',
                'title_accent' => null,
                'category' => 'WEBDEVELOPMENT',
                'intro_label' => 'WEBDEVELOPMENT / PORTFOLIO',
                'started_year' => 2026,
                'ended_year' => null,
                'summary' => 'De eerste versie van mijn portfolio website had ik gemaakt in *Django (Python)*. Die beschouwde ik vooral als een leer-project. Het begon gestructureerd, maar eindigde toch wel in een aardige bende. Mede om die reden, en omdat ik met *Claude Code* een volledige iets wilde bouwen, heb ik besloten om mijn portfolio opnieuw te bouwen in *Laravel (PHP)*. Dit keer met ondersteuning van *Figma-MCP* & *Claude Code*.',
                'subtitle' => 'Een website waar ik trots op kan zijn.',
                'story_lead' => 'My Portfolio: Een nieuw design, een nieuwe manier om mijzelf te introduceren.',
                'media_tagline' => '{ software x portfolio }',
                'story_heading' => 'Een nieuw',
                'story_heading_accent' => 'begin',
                'story_aside' => '// stap voor stap',
                'repository_url' => 'https://github.com/Znooptokkie/Porto_Laravel',
                'favorite_rank' => 6,
                'status' => ProjectStatus::InConstructie,
                'organization' => 'Thuis',
                'department' => 'Bureau',
                'types' => ['Webdevelopment'],
                'cardTechnologies' => ['PHP', 'Laravel', 'JavaScript', 'Claude Code', 'Figma-MCP'],
                'detailTechnologies' => ['PHP', 'Laravel', 'JavaScript', 'Claude Code', 'Figma-MCP'],
                'links' => [],
                'chapters' => $this->portfolioV2Chapters(),
                'chapterTranslations' => $this->portfolioV2ChapterTranslations(),
                'components' => $this->portfolioV2Components(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Designer', 'url' => 'https://github.com/Znooptokkie'],
                ],
            ],
            [
                'slug' => 'smart-garden-desktop',
                'translations' => ['en' => [
                    'media_tagline' => '{ sensors × dashboard }',
                    'story_lead' => 'Smart Garden: live sensor data and an automatic water pump, in one dashboard.',
                    'title' => 'Smart Garden - Desktop',
                    'category' => 'IOT / EMBEDDED SYSTEMS',
                    'intro_label' => 'IOT / EMBEDDED SYSTEMS',
                    'summary' => 'Smart Garden is a collaboration between *CIV Smart Technology*, *The Field* in Leiden and *mboRijnland*, in which a dashboard was built in *Flask* to monitor and control a vertical garden, including live sensor data and an automatically controlled water pump via a *Raspberry Pi 4*.',
                    'subtitle' => 'A dashboard to monitor and control a vertical garden.',
                    'story_heading' => 'From assignment to',
                    'story_heading_accent' => 'delivery',
                    'story_aside' => '// from assignment to delivery',
                    'organization' => 'mboRijnland',
                    'department' => 'CIV Smart Technology, The Field & Haagsche Hogeschool',
                ]],
                'title' => 'Smart Garden - Desktop',
                'title_accent' => null,
                'category' => 'IOT / EMBEDDED SYSTEMS',
                'intro_label' => 'IOT / SAMENWERKINGSPROJECT',
                'started_year' => 2024,
                'ended_year' => 2025,
                'summary' => 'Smart Garden is een samenwerkingsproject tussen het *CIV Smart Technology*, *The Field* in Leiden en *mboRijnland*, waarbij een dashboard werd gebouwd in *Flask* om een verticale tuin te monitoren en aan te sturen, inclusief live sensordata en een automatisch aangestuurde waterpomp via een *Raspberry Pi 4*.',
                'subtitle' => 'Een dashboard om een verticale tuin te monitoren en aan te sturen.',
                'story_lead' => 'Smart Garden: live sensordata en een automatische waterpomp, in één dashboard.',
                'media_tagline' => '{ sensoren × dashboard }',
                'story_heading' => 'Van opdracht naar',
                'story_heading_accent' => 'oplevering',
                'story_aside' => '// van opdracht tot oplevering',
                'repository_url' => 'https://github.com/Znooptokkie/GG',
                'favorite_rank' => 1,
                'status' => ProjectStatus::Klaar,
                'organization' => 'CIV Smart Technology, The Field & mboRijnland',
                'department' => '',
                'types' => ['IOT', 'Embedded Systems'],
                'cardTechnologies' => ['Python', 'JavaScript', 'Flask', 'Raspberry Pi', 'Electron'],
                'detailTechnologies' => ['Python', 'JavaScript', 'Flask', 'Raspberry Pi', 'Electron', 'IOT', 'Embedded Systems'],
                'links' => [
                    [
                        'description' => [
                            'nl' => 'Mijn eerste bijdrage over Smart Garden, gepubliceerd op de website van CIV Smart Technology.',
                            'en' => 'My first contribution about Smart Garden, published on the CIV Smart Technology website.',
                        ],
                        'url' => 'https://civ-smarttechnology.nl/project-smrt-garden-bij-smrt-building/',
                    ],
                    [
                        'description' => [
                            'nl' => 'Een voortgangsupdate over de ontwikkeling van het pompsysteem en de kleppen, geschreven vanuit het perspectief van de techniekstudenten.',
                            'en' => 'A progress update on the development of the pumping system and valves, written from the perspective of the engineering students.',
                        ],
                        'url' => 'https://civ-smarttechnology.nl/update-voortgang-project-watersysteem/',
                    ],
                    [
                        'description' => [
                            'nl' => 'Een update over de voortgang van Smart Garden, waaraan ik ook tijdens de vakantieperiode bleef werken.',
                            'en' => 'An update on the progress of Smart Garden, a project I continued working on during the summer holiday.',
                        ],
                        'url' => 'https://civ-smarttechnology.nl/update-project-watersysteem/',
                    ],
                    [
                        'description' => [
                            'nl' => 'Een mooi bericht van mijn voormalige docent over het moment waarop ik de leiding over het Smart Garden-project overnam.',
                            'en' => 'A post by my former teacher about the moment I took over the leadership of the Smart Garden project.',
                        ],
                        'url' => 'https://www.linkedin.com/posts/lindeverbaas_een-mooi-vervolg-op-het-project-smart-garden-ugcPost-7303711081913331712-SIfD/',
                    ],
                    [
                        'description' => [
                            'nl' => 'Samen met HBO-studenten presenteerde ik Smart Garden tijdens de CIV-jaarconferentie van 2025.',
                            'en' => 'Together with higher education students, I presented Smart Garden at the 2025 CIV annual conference.',
                        ],
                        'url' => 'https://civ-smarttechnology.nl/jaarconferentie-civ-st-2025/',
                    ],
                    [
                        'description' => [
                            'nl' => 'Een presentatie over het project voor een zaal vol docenten, op een gigantisch scherm. Een behoorlijk spannende ervaring!',
                            'en' => 'A presentation about the project to an audience of teachers, displayed on a huge screen. Quite an exciting experience!',
                        ],
                        'url' => 'https://www.linkedin.com/posts/naomi-hollander-531066335_ugcPost-7305653354574106624-Tzro/',
                    ],
                    [
                        'description' => [
                            'nl' => 'Een mooie terugblik van een HBO-student die ik als challengegever tijdens het Smart Garden-project mocht begeleiden.',
                            'en' => 'A great reflection from a higher education student whom I had the opportunity to mentor as a project challenge provider during Smart Garden.',
                        ],
                        'url' => 'https://www.linkedin.com/posts/vireen-jagram-833985224_smartgarden-ai-iot-share-7335244310193344514-BSF7/',
                    ],
                ],
                'chapters' => $this->smartGardenDesktopChapters(),
                'chapterTranslations' => $this->smartGardenDesktopChapterTranslations(),
                'components' => $this->smartGardenDesktopComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Project Leader / Scrum Master', 'url' => 'https://github.com/Znooptokkie'],
                    ['name' => 'R. van Putten', 'role' => 'Front-end Developer / Product Owner', 'url' => 'https://github.com/SanzoVP'],
                    ['name' => 'B. Diker', 'role' => 'Back-end Developer', 'url' => 'https://github.com/bdiker61'],
                    ['name' => 'M. Cifci', 'role' => 'Back-end Developer', 'url' => 'https://github.com/mohammedcifci'],
                    ['name' => 'J. Doekhi', 'role' => 'Front-end Developer', 'url' => 'https://github.com/6027529'],
                    ['name' => 'M. Heins', 'role' => 'Embedded Systems Specialist', 'url' => 'https://github.com/martijnhe'],
                ],
            ],
            [
                'slug' => 'smart-garden-mobiel',
                'translations' => ['en' => [
                    'media_tagline' => '{ mobile × Raspberry Pi }',
                    'story_lead' => 'Smart Garden on your phone, with its own API, user roles and a Raspberry Pi.',
                    'title' => 'Smart Garden - Mobile',
                    'category' => 'MOBILE DEVELOPMENT',
                    'intro_label' => 'MOBILE DEVELOPMENT / FINAL EXAM',
                    'summary' => 'For my *Mobile Development* final exam I turned the Smart Garden - Desktop project into a full mobile app in *React Native*, with its own *Flask API*, user roles and a connection to a *Raspberry Pi 4*.',
                    'subtitle' => 'Smart Garden as a full mobile app.',
                    'story_heading' => 'From desktop to',
                    'story_heading_accent' => 'mobile',
                    'story_aside' => '// from dashboard to app',
                    'organization' => '',
                    'department' => '',
                ]],
                'title' => 'Smart Garden - Mobiel',
                'title_accent' => null,
                'category' => 'MOBILE DEVELOPMENT',
                'intro_label' => 'MOBILE DEVELOPMENT / EINDEXAMEN',
                'started_year' => 2025,
                'ended_year' => null,
                'summary' => 'Voor mijn eindexamen *Mobile Development* heb ik het project Smart Garden - Desktop omgezet naar een volwaardige mobiele applicatie in *React Native*, met eigen *Flask-API*, gebruikersrollen en koppeling met een *Raspberry Pi 4*.',
                'subtitle' => 'Smart Garden als volwaardige mobiele app gemaakt voor het Mobilde Development Examen.',
                'story_lead' => 'Smart Garden op je telefoon, met een eigen API, gebruikersrollen en een Raspberry Pi.',
                'media_tagline' => '{ mobiel × Raspberry Pi }',
                'story_heading' => 'Van desktop naar',
                'story_heading_accent' => 'mobiel',
                'story_aside' => '// van dashboard naar app',
                'repository_url' => 'https://github.com/6028968/GG_MAD',
                'favorite_rank' => 9,
                'status' => ProjectStatus::Klaar,
                'organization' => 'mboRijnland',
                'department' => 'Mobilde Development Examen',
                'types' => ['Mobile Development'],
                'cardTechnologies' => ['TypeScript', 'React Native', 'Flask API', 'Termux'],
                'detailTechnologies' => ['TypeScript', 'React Native', 'Flask API', 'Termux', 'SCP', 'Raspberry Pi 4'],
                'links' => [], // invullen, zie syncLinks() voor het formaat
                'chapters' => $this->smartGardenMobileChapters(),
                'chapterTranslations' => $this->smartGardenMobileChapterTranslations(),
                'components' => $this->smartGardenMobileComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Designer', 'url' => 'https://github.com/Znooptokkie'],
                ],
            ],
            [
                'slug' => 'bram',
                'translations' => ['en' => [
                    'media_tagline' => '{ simplicity × accessibility }',
                    'story_lead' => 'BRAM: a simpler phone, with an emergency button and family photos within reach.',
                    'title' => 'BRAM',
                    'category' => 'MOBILE DEVELOPMENT',
                    'intro_label' => 'MOBILE DEVELOPMENT / MUNICIPAL PROJECT',
                    'summary' => 'BRAM was my first mobile project, commissioned by the *municipality of Zoetermeer*. In *Android Studio* with *Java* we built an app to help older people use their phone more easily, with features such as an *emergency button* and simple access to *family photos*.',
                    'subtitle' => 'An app that helps older people use their phone more easily.',
                    'story_heading' => 'Simplicity for',
                    'story_heading_accent' => 'older people',
                    'story_aside' => '// from idea to delivery',
                    'organization' => 'Municipality of Zoetermeer',
                    'department' => 'Elderly',
                ]],
                'title' => 'BRAM',
                'title_accent' => null,
                'category' => 'MOBILE DEVELOPMENT',
                'intro_label' => 'MOBILE DEVELOPMENT / GEMEENTEPROJECT',
                'started_year' => 2024,
                'ended_year' => null,
                'summary' => 'BRAM was mijn eerste mobiele project, aangeboden door de *gemeente Zoetermeer*, waarbij we in *Android Studio* met *Java* een applicatie bouwden die ouderen moet helpen om gemakkelijker overweg te kunnen met hun mobiel, met functies zoals een *noodknop* en eenvoudige toegang tot *familiefoto’s*.',
                'subtitle' => 'Een app die ouderen helpt om makkelijker met hun telefoon om te gaan.',
                'story_lead' => 'BRAM: een eenvoudiger telefoon, met een noodknop en familiefoto\'s binnen handbereik.',
                'media_tagline' => '{ eenvoud × toegankelijkheid }',
                'story_heading' => 'Eenvoud voor',
                'story_heading_accent' => 'ouderen',
                'story_aside' => '// van idee tot oplevering',
                'repository_url' => 'https://github.com/bdiker61/BRAM',
                'favorite_rank' => 6,
                'status' => ProjectStatus::Klaar,
                'organization' => 'Gemeente Zoetermeer',
                'department' => 'Ouderen',
                'types' => ['Mobile Development'],
                'cardTechnologies' => ['Java', 'Android Studio', 'XML', 'API'],
                'detailTechnologies' => ['Java', 'Android Studio', 'XML', 'API'],
                'links' => [],
                'chapters' => $this->bramChapters(),
                'chapterTranslations' => $this->bramChapterTranslations(),
                'components' => $this->bramComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Scrum Master', 'url' => 'https://github.com/Znooptokkie'],
                    ['name' => 'M. de Graaf', 'role' => 'Full-stack Developer / Product Owner', 'url' => 'https://github.com/Matthijs-de-Graaf'],
                    ['name' => 'R. van Putten', 'role' => 'Full-stack Developer', 'url' => 'https://github.com/SanzoVP'],
                    ['name' => 'B. Diker', 'role' => 'Full-stack Developer', 'url' => 'https://github.com/bdiker61'],
                ],
            ],
            [
                'slug' => 'zinra',
                'translations' => ['en' => [
                    'media_tagline' => '{ email × documents }',
                    'story_lead' => 'Zinra: from a large volume of documents to a clear overview.',
                    'title' => 'Zinra',
                    'category' => 'DOCUMENT AUTOMATION',
                    'intro_label' => 'DOCUMENT AUTOMATION / MINISTRY ASSIGNMENT',
                    'summary' => 'For the *Dutch Ministry of the Interior and Kingdom Relations (BZK)* we developed two programmes to organise a large volume of documents: a *mailbox application* that automatically categorises emails using the *\'Bag of Words\'* concept, and a *website* for manually *sorting* and *de-duplicating* documents.',
                    'subtitle' => 'A mailbox that categorises emails automatically, and a website for sorting documents.',
                    'story_heading' => 'From sorting to',
                    'story_heading_accent' => 'overview',
                    'story_aside' => '// automatic and manual',
                    'organization' => 'Government',
                    'department' => 'Dutch Ministry of the Interior and Kingdom Relations (BZK)',
                ]],
                'title' => 'Zinra',
                'title_accent' => null,
                'category' => 'DOCUMENTAUTOMATISERING',
                'intro_label' => 'DOCUMENTAUTOMATISERING / OPDRACHT BZK',
                'started_year' => 2023,
                'ended_year' => null,
                'summary' => 'Voor het *Ministerie van Binnenlandse Zaken en Koninkrijksrelaties (BZK)* ontwikkelden wij twee programma’s om een grote hoeveelheid documenten te organiseren: een *mailbox-applicatie* die mails automatisch categoriseert via het *‘Bag of Words’-concept*, en een *website* voor het handmatig *sorteren* en *dedupliceren* van documenten.',
                'subtitle' => 'Een mailbox die mails automatisch categoriseert, en een website om documenten te sorteren.',
                'story_lead' => 'Zinra: van een grote hoeveelheid documenten naar een overzichtelijk geheel.',
                'media_tagline' => '{ mail × documenten }',
                'story_heading' => 'Van ordenen naar',
                'story_heading_accent' => 'overzicht',
                'story_aside' => '// automatisch en handmatig',
                'repository_url' => 'https://github.com/Znooptokkie/Project_P3',
                'favorite_rank' => 2,
                'status' => ProjectStatus::Klaar,
                'organization' => 'Overheid',
                'department' => 'Ministerie van Binnenlandse Zaken en Koninkrijksrelaties (BZK)',
                'types' => ['Automatisering'],
                'cardTechnologies' => ['PHP', 'AI', 'Decission Tree', 'Bag of Words', 'SMTP'],
                'detailTechnologies' => ['PHP', 'AI', 'Decission Tree', 'Bag of Words', 'SMTP'],
                'links' => [
                    [
                        'description' => [
                            'nl' => 'Mijn eerste project waarbij ik in de schijnwerpers mocht staan om de verschillende projecten te presenteren en aan te kondigen.',
                            'en' => 'My first project where I had the opportunity to step into the spotlight and present and announce the various projects.',
                        ],
                        'url' => 'https://www.rijksorganisatieodi.nl/actueel/nieuws/2023/04/20/mbo-studenten-ontwikkelen-virtuele-zoekassistent',
                    ],
                    [
                        'description' => [
                            'nl' => 'Een publicatie over de kick-off van het NINJA-project, een samenwerking met het ministerie van Binnenlandse Zaken en Koninkrijksrelaties (BZK), op de website van CIV Smart Technology.',
                            'en' => 'A publication about the kick-off of the NINJA project, a collaboration with the Ministry of the Interior and Kingdom Relations (BZK), on the CIV Smart Technology website.',
                        ],
                        'url' => 'https://civ-smarttechnology.nl/kick-off-the-ninja-project-met-ministerie-bzk/',
                    ],
                    [
                        'description' => [
                            'nl' => 'Een aanvullende vermelding van het NINJA-project op de website van Rijksorganisatie ODI, waarbij opnieuw een afbeelding van mijn presentatie is gebruikt.',
                            'en' => 'Another mention of the NINJA project on the Rijksorganisatie ODI website, once again featuring an image from my presentation.',
                        ],
                        'url' => 'https://www.rijksorganisatieodi.nl/i-partnerschap/praktijkvoorbeelden',
                    ],
                ],
                'chapters' => $this->zinraChapters(),
                'chapterTranslations' => $this->zinraChapterTranslations(),
                'components' => $this->zinraComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Back-end Developer / Scrum Master', 'url' => 'https://github.com/Znooptokkie'],
                    ['name' => 'R. van Putten', 'role' => 'Front-end Developer / Product Owner', 'url' => 'https://github.com/SanzoVP'],
                    ['name' => 'B. Diker', 'role' => 'Front-end Developer', 'url' => 'https://github.com/bdiker61'],
                    ['name' => 'M. Cifci', 'role' => 'Back-end Developer', 'url' => 'https://github.com/mohammedcifci'],
                ],
            ],
            [
                'slug' => 'portfolio-v1',
                'translations' => ['en' => [
                    'media_tagline' => '{ learning × portfolio }',
                    'story_lead' => 'Portfolio V1: the first version of my portfolio, built to learn as much as possible.',
                    'title' => 'Portfolio V1',
                    'category' => 'WEB DEVELOPMENT',
                    'intro_label' => 'WEB DEVELOPMENT / PORTFOLIO',
                    'summary' => 'My original portfolio website. Built in *Django* with *native TypeScript*. My aim for this project was to learn as much as possible from the different *concepts* that come with a website like this. That is also why it has turned into a bit of a mess. It started off structured, but eventually ended up with a rather messy *folder structure* and *codebase*.',
                    'subtitle' => 'My first portfolio, built as a learning process with Django and TypeScript.',
                    'story_heading' => 'Learning by',
                    'story_heading_accent' => 'building',
                    'story_aside' => '// step by step',
                    'organization' => '',
                    'department' => '',
                ]],
                'title' => 'Portfolio V1',
                'title_accent' => null,
                'category' => 'WEBDEVELOPMENT',
                'intro_label' => 'WEBDEVELOPMENT / PORTFOLIO',
                'started_year' => 2025,
                'ended_year' => 2026,
                'summary' => 'Mijn oorspronkelijke portfolio website. Gemaakt in *Django* met *native TypeScript*. Mijn insteek voor dit project was om zoveel mogelijk te leren van de verschillende *concepten* die aan bod komen bij zo een website. Dit is ook wel de reden dat het eigenlijk een gigantisch bende is geworden. Het begon gestructureerd, maar het eindige toch met een behoorlijk onoverzichtelijke *mappenstructuur* en *code*.',
                'subtitle' => 'Mijn eerste portfolio, gebouwd als leerproces met Django en TypeScript.',
                'story_lead' => 'Portfolio V1: de eerste versie van mijn portfolio, gebouwd om zoveel mogelijk te leren.',
                'media_tagline' => '{ leren × bouwen }',
                'story_heading' => 'Leren door',
                'story_heading_accent' => 'bouwen',
                'story_aside' => '// stap voor stap',
                'repository_url' => 'https://github.com/Znooptokkie/CV',
                'favorite_rank' => 9,
                'status' => ProjectStatus::Klaar,
                'organization' => '',
                'department' => '',
                'types' => ['Webdevelopment'],
                'cardTechnologies' => ['Python', 'Django', 'TypeScript', 'SVG', 'CI/CD'],
                'detailTechnologies' => [],
                'links' => [
                    [
                        'description' => [
                            'nl' => 'De repository die ik heb aangemaakt om met SVG\'s te experimenteren. Of dit de ideale aanpak was, weet ik niet helemaal, maar ik heb er veel van geleerd!',
                            'en' => 'The repository I created to experiment with SVGs. I am not entirely sure whether this was the ideal approach, but I learned a lot from it!',
                        ],
                        'url' => 'https://github.com/Znooptokkie/SVG',
                    ],
                ],
                'chapters' => $this->portfolioV1Chapters(),
                'chapterTranslations' => $this->portfolioV1ChapterTranslations(),
                'components' => $this->portfolioV1Components(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Designer', 'url' => 'https://github.com/Znooptokkie'],
                ],
            ],
            [
                'slug' => 'dungeon-crawler',
                'translations' => ['en' => [
                    'media_tagline' => '{ hackaton × gaming }',
                    'story_lead' => 'Dungeon Crawler: picking up Laravel again, with a game as the project.',
                    'title' => 'Dungeon Crawler',
                    'category' => 'WEB DEVELOPMENT',
                    'intro_label' => 'WEB DEVELOPMENT / HACKATHON',
                    'summary' => 'I took part in the *hackathon* of the *Dutch Laravel Foundation*. Because it had been a while since I last used *Laravel* as a *framework*, I decided to build a small dungeon crawler. The project is *unfinished*, but I don\'t rule out finishing it at some point.',
                    'subtitle' => 'A small dungeon crawler, built during a hackathon.',
                    'story_heading' => 'A game with',
                    'story_heading_accent' => 'Laravel',
                    'story_aside' => '// not finished yet',
                    'organization' => 'Dutch Laravel Foundation',
                    'department' => 'Hackathon',
                ]],
                'title' => 'Dungeon Crawler',
                'title_accent' => null,
                'category' => 'WEBDEVELOPMENT',
                'intro_label' => 'WEBDEVELOPMENT / HACKATHON',
                'started_year' => 2026,
                'ended_year' => null,
                'summary' => 'Ik deed mee aan de *hackaton* van de *Dutch Laravel Foundation*. Omdat het een tijdje geleden was dat ik *Laravel* had gebruikt als *framework*, besloot ik om een kleine dungeon crawler te maken. Het project staat op *onvoltooid*, maar ik sluit niet uit om hem alsnog af te maken.',
                'subtitle' => 'Een kleine dungeon crawler, gebouwd voor de hackathon.',
                'story_lead' => 'Dungeon Crawler: Laravel weer oppakken, met een spel als project.',
                'media_tagline' => '{ Laravel × spel }',
                'story_heading' => 'Een spel met',
                'story_heading_accent' => 'Laravel',
                'story_aside' => '// nog niet af',
                'repository_url' => 'https://github.com/Znooptokkie/laravel_dungeon_crawler',
                'favorite_rank' => 10,
                'status' => ProjectStatus::Onvoltooid,
                'organization' => 'Dutch Laravel Foundation',
                'department' => 'Hackaton',
                'types' => ['Webdevelopment'],
                'cardTechnologies' => ['PHP', 'Laravel', 'Vue.js', 'SVG'],
                'detailTechnologies' => ['PHP', 'Laravel', 'Vue.js', 'SVG'],
                'links' => [
                    [
                        'description' => [
                            'nl' => 'Deze tutorial heb ik aan het begin van het project gevolgd om mijn kennis van Laravel op te frissen.',
                            'en' => 'I followed this tutorial at the start of the project to refresh my knowledge of Laravel.',
                        ],
                        'url' => 'https://laravel.com/learn/getting-started-with-laravel',
                    ],
                ],
                'chapters' => $this->dungeonCrawlerChapters(),
                'chapterTranslations' => $this->dungeonCrawlerChapterTranslations(),
                'components' => $this->dungeonCrawlerComponents(),
                'contributors' => [['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Designer', 'url' => 'https://github.com/Znooptokkie']],
            ],
            [
                'slug' => 'plymouth',
                'translations' => ['en' => [
                    'media_tagline' => '{ exchange x micro:bits }',
                    'story_lead' => 'An unforgettable experience for my fellow student (*Matthijs*) and me, as we took the lead in guiding an international exchange project.',
                    'title' => 'Plymouth Exchange Guidance',
                    'category' => 'ROBOTICS / EXCHANGE GUIDANCE',
                    'intro_label' => 'ROBOTICS / EXCHANGE GUIDANCE.',
                    'summary' => '*Matthijs* and I had the opportunity to guide students during this international *exchange project*. During the first week, their challenge was to build a fully functional *robot* capable of driving using *micro:bits*. The second week brought *three challenges* where teams could earn points. The team with the highest score won *four micro:bits* to take home.',
                    'subtitle' => 'From almost no experience to building a fully functional robot.',
                    'story_heading' => 'Drive like a',
                    'story_heading_accent' => 'racing car',
                    'story_aside' => '// learn, build & have fun',
                    'organization' => 'mboRijnland',
                    'department' => 'Software Development',
                ]],
                'title' => 'City College Plymouth Studenten Begeleiding',
                'title_accent' => null,
                'category' => 'ROBOTICA / UITWISSELINGSBEGELEIDING',
                'intro_label' => 'ROBOTICA / UITWISSELINGSBEGELEIDING.',
                'started_year' => 2025,
                'ended_year' => null,
                'summary' => 'Samen met mijn medestudent *Matthijs* kreeg ik de kans om een *internationale uitwisseling* vanuit *Plymouth* te begeleiden. Tijdens de eerste week gingen de studenten aan de slag met het bouwen van een volledig werkende *robot* op basis van *micro:bits*. In de tweede week namen ze het tegen elkaar op in drie verschillende uitdagingen, waarbij het team met de meeste punten *vier micro:bits* mee naar huis mocht nemen.',
                'subtitle' => 'Van nauwelijks ervaring naar een volledig werkende robot.',
                'story_lead' => 'Een bijzondere ervaring waarin Matthijs en ik niet alleen onze technische kennis konden delen, maar ook een groep internationale studenten mochten begeleiden bij hun eerste stappen in de robotica.',
                'media_tagline' => '{ uitwisseling x micro:bits }',
                'story_heading' => 'Racen als een',
                'story_heading_accent' => 'pro',
                'story_aside' => '// leren, bouwen & plezier',
                'repository_url' => 'https://github.com/Matthijs-de-Graaf/bot',
                'favorite_rank' => 5,
                'status' => ProjectStatus::Klaar,
                'organization' => 'mboRijnland',
                'department' => 'Software Development',
                'types' => [],
                'cardTechnologies' => ['MicroBits', 'MicroPython'],
                'detailTechnologies' => ['MicroBits', 'MicroPython'],
                'links' => [],
                'chapters' => $this->plymouthChapters(),
                'chapterTranslations' => $this->plymouthChapterTranslations(),
                'components' => $this->plymouthComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Exchange Lead', 'url' => 'https://github.com/Znooptokkie'],
                    ['name' => 'M. de Graaf', 'role' => 'Exchange Lead', 'url' => 'https://github.com/Matthijs-de-Graaf'],
                ],
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
            $alts = self::IMAGE_ALTS[$project->slug][basename($path)] ?? ['nl' => '', 'en' => ''];

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
                ->sortBy(fn (string $path): string => basename($path) === (self::FIRST_PHOTOS[$project->slug] ?? null) ? '' : $path)
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
     * English chapter texts, aligned with smartGardenDesktopChapters().
     *
     * @return list<list<string>>
     */
    private function smartGardenDesktopChapterTranslations(): array
    {
        return [
            [
                'Introduction',
                'Smart Garden is a collaboration between CIV Smart Technology, The Field in Leiden and mboRijnland, with students from The Hague University of Applied Sciences as its newest addition.',
                'The goal of this project is to actively involve students in current social issues, with a focus on sustainability and circular construction. The central question within Smart Garden is: "How can we keep a greenhouse full of plants alive as efficiently and autonomously as possible?"',
                'What started as a relatively small project grew over several school years into a considerable undertaking, with multiple consecutive teams and increasingly complex technical challenges.',
            ],
            [
                'The Assignment',
                'Every second-year Software Developer student at mboRijnland received the same assignment during this period, after which groups were formed to carry it out. Our group consisted of five members.',
                'By applying the Scrum methodology, we had a clear division of roles from the start: two front-end developers, two back-end developers (one of whom also acted as Product Owner), and myself as Scrum Master and project leader.',
                'The assignment began in period three of the 2023–2024 school year. First, we were expected to retrieve sensor data from a Quantified API and make it visible on a dashboard.',
                'In addition, we had to be able to add plants located in the greenhouse, so that each individual plant could be monitored. Since the ultimate goal was an autonomous greenhouse, it made sense to have data such as water requirements, sunlight and nutrients filled in automatically. For this we used a second API, which supplies the necessary data for each plant.',
            ],
            [
                'Technical Choices',
                'After some research, we thought it was a good idea to use Electron for the dashboard. However, we quickly discovered that Electron is mainly intended for desktop applications, which became a limitation as soon as we actually had to send and process data.',
                'We initially considered adding a separate Flask application as a back end alongside Electron. After consulting a teacher, however, we decided to build the entire application in Flask, without Electron.',
                'Using two frameworks side by side felt cumbersome, while Flask could in principle provide all the functionality we needed.',
            ],
            [
                'Functionalities',
                'Alongside our own code, we used two external APIs. The Perenual API provides data on specific plant species, which is automatically filled in on the corresponding page of each plant.',
                'The Weerlive API ensures that current weather conditions are taken into account in the system, since plants depend heavily on the weather: at high temperatures, for example, extra water is needed.',
            ],
            [
                'Follow-up Assignment',
                'After the assignment was completed, our group was allowed to keep working on Smart Garden, while the rest of the class started a new project. We of course seized this opportunity with both hands.',
                'The follow-up assignment involved controlling a pump located in the Smart Building at The Field. At this point an extra team member joined us, specialising in embedded systems and Linux.',
                'The pump itself had been designed and built by students of the Technicus Engineering programme at mboRijnland. For the control, we came up with a solution in which a Raspberry Pi 4 acts as the central controller, bringing together all of the system’s logic.',
                'Because this Raspberry Pi was physically located at The Field and we could not always be on site, we set up a reverse SSH tunnel. This allowed us to program the Raspberry Pi at any time, naturally without it being connected to the pump, to prevent problems such as flooding.',
                'The existing dashboard was expanded at the same time, so that it could actually work together with this physical implementation.',
            ],
            [
                'Delivery',
                'From this point on, we worked closely with the students of Technicus Engineering who had built the pump. This collaboration went very well, thanks in part to the motivation on both sides.',
                'The delivery did not go entirely smoothly: we encountered an unstable Wi-Fi connection, incorrectly calibrated sensors, and the fact that almost everything was new to us.',
                'In the end, we succeeded in delivering a working system: since then, the pump has automatically watered the plants every two weeks. The sensors were not yet in use at delivery, due to problems that were largely beyond our control.',
            ],
            [
                'Handover',
                'Through a pitch to the DIF in Zoetermeer, students of The Hague University of Applied Sciences were enthusiastic about continuing Smart Garden.',
                'They are building on the Raspberry Pi 4 as the central brain of the system, and are expanding it with sensors for soil moisture per planter, a sensor for air humidity in the greenhouse and a light sensor.',
                'In addition, they are using the ChatGPT API to automatically fill in data for each individual plant, and the plan is to connect a camera to the greenhouse so that artificial intelligence can detect threats early on in the dashboard.',
            ],
            [
                'Objective',
                'The ultimate goal of Smart Garden is a fully working algorithm that waters each individual plant, based on data from the Perenual API and controlled via the MQTT protocol.',
                'In addition, the dashboard must function fully, with correct data and working charts on all pages. Where possible, and with security in mind, the aim is to make the website available for actual use by The Field itself.',
                'Throughout this project, I learned to work with SSH connections, the basics of the Linux operating system, retrieving and processing sensor data, sending and retrieving data via APIs, basic knowledge of algorithms, creating charts with ChartJS, working with Python and Flask, and using the MQTT protocol for sensor data.',
            ],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function smartGardenDesktopComponents(): array
    {
        return $this->groupedComponents([
            ProjectComponentGroup::Hardware->value => ['Raspberry Pi 4'],
            ProjectComponentGroup::Sensor->value => ['Capacitive Soil Moisture Sensor'],
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
     * English chapter texts, aligned with smartGardenMobileChapters().
     *
     * @return list<list<string>>
     */
    private function smartGardenMobileChapterTranslations(): array
    {
        return [
            [
                'Introduction',
                'After the desktop version of Smart Garden had been delivered, I got the chance to develop the project further for my own Mobile Development final exam. Rather than starting from scratch, I decided to turn the Smart Garden concept into a mobile application.',
                'Having gained more experience and knowledge in the meantime, I could approach the project with a better overview and a clearer structure than the first time.',
            ],
            [
                'Purpose and Target Audience',
                'The purpose of the mobile application is to give owners of vertical gardens, mainly employees of The Field, a user-friendly way to monitor and control sensors and pumps remotely.',
                'Through the app, users can view soil moisture and other data, set irrigation schedules, add plants and consult historical data. Deliberately, different user roles were chosen: regular users can only view data, while admins have full control over managing the garden.',
            ],
            [
                'Technical Choices',
                'For the app itself, I chose React Native with TypeScript, a framework I was already comfortable with and one that makes it possible to expand to iOS in the future.',
                'For the back end, I initially built my own API in Node.js, but eventually switched to Flask, because Python worked more pleasantly than JavaScript for this part of the project.',
                'Local data, such as user and plant information, is stored with AsyncStorage rather than a full database, after several attempts to implement a database did not go as hoped. Passwords are stored hashed, so the data remains at least somewhat protected.',
            ],
            [
                'Raspberry Pi',
                'For communication with the sensors and the pump at The Field, which are controlled by a Raspberry Pi 4, I chose an SSH connection in which JSON files were exchanged via the SCP protocol.',
                'On my phone I used Termux to set up this connection and to run a small Node.js server that made the data available to the app via HTTP requests.',
                'This setup initially worked well, but after a while the SSH connection repeatedly dropped unexpectedly and remained unavailable. To get the application fully working anyway, I chose to temporarily hardcode the sensor data in the Flask API, so the rest of the app could be fully tested and demonstrated.',
            ],
            [
                'Functionalities',
                'The application includes, among other things, a login and registration system, a home page with a five-day weather forecast and an overview of the plants on both sides of the greenhouse, and a page with all plants that have ever been added.',
                'On the page of an individual plant, part of the data is filled in automatically via the Perenual API, and the plant’s presence, location and status can be managed.',
                'There are also separate pages for sensors, pumps and a log of data and error messages. Only admin users can add, change or delete plants and have access to management functions such as deleting the database.',
            ],
            [
                'Problems',
                'Besides the dropped SSH connection, I ran into several other technical challenges. React Native does not support communication within the same domain by default, so I had to configure CORS properly to let the app and the Flask API communicate smoothly.',
                'Storing sensitive data, such as API keys, in a separate .env file also proved problematic: after adding the required dependency, the application crashed completely, and I could not determine the cause. In the end, I was forced to hardcode this data into the application instead.',
            ],
            [
                'Additions',
                'During development, I added several features that were not in the original design. For example, an irrigation schedule can now be set for each plant, tracking how often a plant needs water and when the next irrigation is planned.',
                'Admins can also edit all of a plant’s data afterwards, and I added a function to remove plants completely from the system, something that was initially missing.',
            ],
            [
                'Unrealised',
                'Not everything went as originally planned. Automatically filling in plant data turned out to be more complex than expected, because it actually required two APIs instead of one: a translation API to convert the entered text into English before it could be passed as a parameter to the Perenual API.',
                'I also ultimately dropped an export function for sensor and plant data to CSV or PDF, because I spent more time finishing the core functionality than I had expected.',
                'Live sensor data could not be realised because of the dropped SSH connection, and the sensors themselves had not yet been physically installed in the greenhouse at the time of delivery.',
                'The functionality to control the pump remotely is technically present, but was deliberately not fully enabled: without a stable connection and without supervision, I was not willing to take the risk that the pump could no longer be switched off.',
            ],
            [
                'Quality Assurance',
                'To ensure the application’s reliability, I carried out extensive manual testing based on predefined test cases, focusing on both the regular user and the admin.',
                'Almost all tested functionality, such as registering, logging in, adding plants, filtering and deleting, turned out to work successfully. One test revealed that no error message was shown when an invalid username was entered, which I then fixed by adding a validation function and a clear error message.',
            ],
            [
                'Final Result',
                'The end result is a fully functioning mobile application that makes managing a vertical garden clear and accessible, even though some of the data currently still runs on hardcoded values instead of live sensor data.',
                'Should the SSH connection with the Raspberry Pi work reliably again in the future, switching to real live data should be relatively quick to achieve.',
                'This project taught me a great deal about combining mobile development with hardware integration, and about dealing with components that, despite your best efforts, do not always work entirely as hoped.',
            ],
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
     * English chapter texts, aligned with bramChapters().
     *
     * @return list<list<string>>
     */
    private function bramChapterTranslations(): array
    {
        return [
            [
                'Introduction',
                'This project was offered to us by the municipality of Zoetermeer.',
                'It was my first project for mobile. This application was meant to make it easier for older people to use a mobile phone.',
                'Because older people often find it harder to keep up with technology, we were given the assignment to create an application that makes it somewhat easier for older people to get by.',
            ],
            [
                'Vision and Objective',
                'The main objective was that older people would not run into limitations when using this app.',
                'We therefore interviewed several older people about what they felt was most important to have in this application.',
                'Almost everyone agreed on one thing: safety. The app needed a clear "emergency button" through which external help could be called.',
                'The older people also considered it very important to have easy access to photos, especially those of their own family.',
            ],
            [
                'Decision-making',
                'From school, there was the option to make this project with the knowledge we already had. That meant building the application with HTML, CSS and JavaScript.',
                'For those seeking a bigger challenge, there was the option to make the project in Android Studio.',
                'Naturally, my project group chose the second option: Android Studio. Within Android Studio, we then still had a choice between two programming languages: Java or Kotlin.',
                'After doing some research, we decided to build it in Java, mainly because Java is more widely used than Kotlin. It seemed to us that learning Java would add more value.',
            ],
            [
                'Task Division',
                'Four main pages had to be realised. That worked out nicely, because we were also exactly four people.',
                'The "Lamps" page was assigned to me, together with setting up the application in Android Studio.',
                'As soon as I understood how everything worked within Android Studio, I explained it to the rest of my group. They of course also figured out a lot themselves, but I usually take the lead because I always want a clear overview of how everything works, so I can help if anything gets stuck. I was also a fair bit older than the others, which of course helped too.',
            ],
            [
                'Realisation',
                'Then came the actual programming of the application.',
                'From a teacher we received a login code to retrieve a set of JSON data via his VPS, which we used to control a lamp. This required building a real API through which we could control things, starting with that lamp.',
                'All of this happened over a local Wi-Fi network, as otherwise entirely different security aspects would have come into play.',
                'The implementation actually went quite smoothly. I did have some problems loading photos via an emulator myself, but after many attempts it worked. I would have liked to make it a bit "better", but in the last week of the project I unfortunately was not at school (I was going to a festival that had already been planned).',
                'I did stay in constant contact with my project group, though. They honestly did not really need me, as they were already managing quite well. I owe particular thanks to Matthijs de Graaf for this, because he committed himself one hundred percent every day, which made handing over leadership not very hard for me at all.',
            ],
            [
                'Delivery',
                'Everything turned out just as we had planned!',
                'I look back on this project with a very satisfied feeling. It was graded 10/10, which of course was a huge boost to my confidence.',
            ],
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
     * English chapter texts, aligned with zinraChapters().
     *
     * @return list<list<string>>
     */
    private function zinraChapterTranslations(): array
    {
        return [
            [
                'Introduction',
                'Zinra was one of my first projects at school and an especially educational experience right away, because for the first time we worked with a real, external client, and the result of our work was immediately visible.',
                'From the Dutch Ministry of the Interior and Kingdom Relations (BZK), we were given the assignment to bring order to a huge volume of documents that had piled up at the ministry. That is exactly what made this project so enjoyable to work on: it did not feel like a made-up school assignment, but like a problem that really mattered to a real client.',
            ],
            [
                'The Assignment',
                'The core of the assignment was to organise and categorise documents more efficiently, so that relevant information could be found more quickly and redundant or duplicate files no longer caused unnecessary hassle.',
                'From school, we also received a concrete technical requirement: a decision tree had to be built into the system, with which documents could be assessed and processed step by step, and communication had to take place via the SMTP protocol.',
            ],
            [
                'Our Idea',
                'To tackle this assignment, we decided to develop two separate programmes that complemented each other.',
                'The first programme focused on the mailbox itself. Because emails are fundamentally built from HTML, we could read the contents of incoming emails with JavaScript. By using the "Bag of Words" concept, in which the words present are used to estimate the subject, the system could automatically determine which category an email belonged to. In this way, documents and emails could be pre-sorted by relevance at an early stage, even before anyone had actually read them.',
                'The second programme consisted of a website for sorting documents manually. A user could upload an entire folder or a single document here, after which they could decide whether the document should be kept or deleted. All decisions were stored in a database, which kept precise track of which documents had to be retained and which could be discarded. An important advantage of this approach was that it also prevented duplicate documents from ending up in the system.',
            ],
            [
                'Persevering',
                'During the project, I assumed that the first programme, the mailbox application, would ultimately not work properly. I kept seeing various errors and warnings, which led me to conclude that something was fundamentally wrong. It was only towards the end of the project that I decided to take a closer look, to see whether the problem could still be solved.',
                'To my own surprise, the application actually turned out to work. The problems I had seen were ultimately just a few minor bugs that were relatively easy to fix. This discovery was a good lesson in perseverance: sometimes something seems broken, while the problem turns out to be a lot smaller than expected.',
            ],
            [
                'Reflection',
                'Unfortunately, over time I lost the documentation file for this project, so not all details and justifications from back then are still available.',
                'Even so, Zinra remains one of the projects I look back on with great pleasure, precisely because it was one of my first experiences working for a real client, and because it showed how valuable it can be not to throw in the towel too quickly.',
            ],
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
    private function stairLightingChapters(): array
    {
        return [
            ['title' => 'Introductie', 'paragraphs' => [
                'Dit project begon vanuit een persoonlijke motivatie. Door een ziekte van mijn moeder heeft zij het zicht in één oog verloren en heeft ze in het andere oog nog ongeveer 30% zicht. Ik wilde haar huis veiliger maken en makkelijker begaanbaar maken, vooral op de trap.',
                'Het idee was om een automatisch verlichtingssysteem te ontwikkelen dat beweging detecteert en de trap verlicht zodra iemand naderbij komt. In plaats van een kant-en-klare oplossing te kopen, besloot ik het volledige systeem zelf te ontwerpen en te bouwen.',
            ]],
            ['title' => 'Onderzoek en Doelstelling', 'paragraphs' => [
                'Eerdere projecten zoals Battlebot en Smart Garden hadden mij al ervaring gegeven met microcontrollers, sensoren en embedded elektronica. Deze kennis gebruikte ik als startpunt voor dit project.',
                'Het doel was om een betrouwbaar automatisch trapverlichtingssysteem te ontwikkelen met bewegingssensoren, een microcontroller en individueel aangestuurde verlichting. Betrouwbaarheid was extra belangrijk, omdat het systeem de veiligheid in het dagelijks gebruik moest verbeteren.',
            ]],
            ['title' => 'Sensorkeuze', 'paragraphs' => [
                'Voor bewegingsdetectie is de HC-SR505 PIR-sensor gekozen. Het compacte formaat en de relatief eenvoudige interface maakten de sensor geschikt om rondom de trap te installeren.',
                'Eerste tests met de sensoren verliepen succesvol. Op basis van deze resultaten ben ik verdergegaan met de installatie en integratie van het volledige systeem.',
            ]],
            ['title' => 'Eerste Problemen', 'paragraphs' => [
                'Na de installatie begon het systeem onvoorspelbaar te reageren. De verlichting ging af en toe aan zonder dat er iemand bij de trap was, en soms bleef ze enkele seconden aan.',
                'In eerste instantie vermoedde ik een probleem met de software of de GPIO. Het vervangen van een PIR-sensor met een beschadigd onderdeel loste het probleem echter niet op. Ook met een nieuwe sensor bleven willekeurige triggers optreden.',
            ]],
            ['title' => 'Debugging van Software en GPIO', 'paragraphs' => [
                'Om het probleem te isoleren heb ik verschillende GPIO-pinnen op de ESP32 getest en geëxperimenteerd met de interne PULL_DOWN-configuratie. Daarnaast heb ik softwarematige filtering en vertragingen toegepast, zodat korte of ongewenste signalen de verlichting niet konden activeren.',
                'Ook een externe pull-downweerstand van 10 kΩ is getest. Geen van deze software- en GPIO-aanpassingen heeft het probleem echter volledig opgelost.',
                'Om de ESP32-ingang onafhankelijk te controleren heb ik handmatig 3,3 V op de GPIO gezet. De pin registreerde consequent een HIGH-signaal, wat aangaf dat de GPIO zelf correct functioneerde.',
            ]],
            ['title' => 'Elektrische Probleemanalyse', 'paragraphs' => [
                'Het onderzoek richtte zich vervolgens op de elektrische aansluitingen. Ik heb de doorgang gecontroleerd tussen VCC, GND en OUT, kortsluiting uitgesloten en verschillende kabelconfiguraties getest.',
                'Om mogelijke storing te beperken zijn de signaalkabels ook uit de buurt van de 230 V- en 24 V-bedrading gelegd.',
                'Tijdens een valse trigger bleek bij metingen dat het OUT-signaal van de PIR zelf opliep tot ongeveer 2,7 V. Dit bevestigde dat het probleem minstens gedeeltelijk binnen de sensor of de voeding daarvan zat, en niet alleen in de ESP32 of de software.',
            ]],
            ['title' => 'Onderzoek naar de Voeding', 'paragraphs' => [
                'Verder onderzoek wees uit dat één van de oudere PIR-sensoren een beschadigd onderdeel bevatte, wat bijdroeg aan de instabiliteit. Het vervangen ervan loste het probleem echter niet volledig op.',
                'Na onderzoek naar vergelijkbare gevallen ontdekte ik dat de HC-SR505 een interne 7133-1 low-dropout spanningsregelaar (LDO) bevat, die de interne voeding van de sensor op 3,3 V regelt.',
                'De sensor werd rechtstreeks gevoed vanaf de 3,3 V-uitgang van de ESP32. Metingen aan de ingang van de regelaar lieten echter slechts ongeveer 2,8 V zien, wat onvoldoende was om een stabiele 3,3 V-uitgang te behouden.',
                'Dit verklaarde waarom de sensor onvoorspelbaar kon reageren, ook al leek de nominale bedrijfsspanning een voeding van 3,3 V te ondersteunen.',
            ]],
            ['title' => 'Hardware-aanpassing', 'paragraphs' => [
                'Om het voedingsprobleem op te lossen heb ik besloten de PIR-sensoren te voeden met ongeveer 5 V in plaats van rechtstreeks met 3,3 V.',
                'Het systeem gebruikt een Mean Well LRS-100-24 voeding, die de primaire 24 V-voeding levert. Een DC-DC buckconverter verlaagt deze spanning naar 5 V, waarmee de Raspberry Pi Pico 2 en de aangesloten PIR-sensoren via de VBUS-voeding worden gevoed.',
                'Na de aanpassing meette ik ongeveer 4,8 V aan de ingang van de interne LDO en een stabiele 3,3 V aan de uitgang. Het PIR-signaal meet ongeveer 0 V in rust en 3,3 V bij gedetecteerde beweging.',
                'De sensoren zijn daarna gedurende langere tijd getest. De willekeurige triggers waren verdwenen, terwijl echte beweging nog steeds correct werd gedetecteerd.',
            ]],
            ['title' => 'PCB-ontwerp', 'paragraphs' => [
                'Zodra de elektronica betrouwbaar werkte, ben ik begonnen met het ontwerpen van een eigen printplaat (PCB) in KiCad.',
                'Dit was mijn eerste ervaring met het ontwerpen van een PCB en het maken van een volledig elektrisch schema. Door een uitgebreide YouTube-tutorial te volgen leerde ik de benodigde werkwijze en vertaalde ik het werkende prototype stap voor stap naar een goed circuitontwerp.',
                'Na het afronden van het schema en de PCB-layout heb ik het eerste prototype besteld. Omdat ik de printplaat aanvankelijk had ontworpen rond de ESP32, kon de oorspronkelijke PCB na de overstap naar de Raspberry Pi Pico 2 niet meer worden gebruikt.',
                'Ik moest de printplaat daarom opnieuw ontwerpen en een tweede versie bestellen. Dit kostte ongeveer €25 extra, wat ik een waardevolle investering vond in praktijkervaring.',
            ]],
            ['title' => 'Eindresultaat', 'paragraphs' => [
                'Het uiteindelijke systeem detecteert beweging en verlicht de trap automatisch. Na het oplossen van de instabiliteit van de sensoren en het herontwerpen van de elektronica rond de Raspberry Pi Pico 2 werkte het systeem tijdens het testen betrouwbaar.',
                'Het belangrijkste is dat de installatie mijn moeder beter zicht geeft en het gebruik van de trap aanzienlijk makkelijker maakt.',
            ]],
            ['title' => 'Geleerde Lessen', 'paragraphs' => [
                'Dit project heeft mij het belang van systematisch probleemoplossen geleerd. Wat in eerste instantie een software- of GPIO-probleem leek, bleek vooral samen te hangen met de interne spanningsregelaar van de PIR-sensor en een te lage voedingsspanning, in combinatie met een defecte sensor.',
                'Daarnaast heb ik praktische ervaring opgedaan met elektrische metingen, voedingsontwerp, pull-downweerstanden, microcontrollers en PCB-ontwikkeling met KiCad.',
                'Een van de belangrijkste lessen was om de elektrische eisen van componenten zorgvuldiger te onderzoeken voordat ze in een systeem worden geïntegreerd. In toekomstige projecten let ik in de ontwerpfase beter op spanningsregeling, bedrijfsspanningen en signaalstabiliteit.',
            ]],
        ];
    }

    /**
     * English chapter texts, aligned with stairLightingChapters().
     *
     * @return list<array{0: string, 1: string}>
     */
    private function stairLightingChapterTranslations(): array
    {
        return [
            [
                'Introduction',
                'This project started with a personal motivation. Due to my mother’s illness, she lost sight in one eye and retained only approximately 30% vision in the other. I wanted to make her home safer and easier to navigate, especially on the stairs.',
                'The idea was to develop an automatic lighting system that detects movement and illuminates the stairs whenever someone approaches. Rather than purchasing an off-the-shelf solution, I decided to design and build the entire system myself.',
            ],
            [
                'Research and Objective',
                'Previous projects such as Battlebot and Smart Garden had already given me experience with microcontrollers, sensors and embedded electronics. I used this knowledge as a starting point for the project.',
                'The objective was to develop a reliable automatic stair lighting system using motion sensors, a microcontroller and individually controlled lighting. Reliability was particularly important because the system was intended to improve safety in everyday use.',
            ],
            [
                'Sensor Selection',
                'The HC-SR505 PIR sensor was selected for motion detection. Its compact size and relatively simple interface made it suitable for installation around the stairs.',
                'Initial tests with the sensors were successful. Based on these results, I proceeded with the installation and integration of the complete system.',
            ],
            [
                'Initial Problems',
                'After installation, the system started behaving unpredictably. The lights occasionally switched on without anyone being near the stairs, sometimes remaining activated for several seconds.',
                'Initially, I suspected a software or GPIO-related problem. However, replacing a PIR sensor with a damaged component did not resolve the issue. Even with a new sensor, random triggers continued to occur.',
            ],
            [
                'Software and GPIO Debugging',
                'To isolate the problem, I tested several GPIO pins on the ESP32 and experimented with its internal PULL_DOWN configuration. I also implemented software filtering and delays to prevent short or unwanted signals from activating the lights.',
                'An external 10 kΩ pulldown resistor was tested as well. However, none of these software and GPIO-related adjustments eliminated the problem completely.',
                'To verify the ESP32 input independently, I manually applied 3.3 V to the GPIO. The pin consistently registered a HIGH signal, indicating that the GPIO itself was functioning correctly.',
            ],
            [
                'Electrical Troubleshooting',
                'The investigation then moved to the electrical connections. I checked continuity across VCC, GND and OUT, ruled out short circuits and tested different cable configurations.',
                'To minimise possible interference, signal cables were also routed away from the 230 V and 24 V wiring.',
                'During a false trigger, measurements revealed that the PIR OUT signal itself was rising to approximately 2.7 V. This confirmed that the problem originated at least partly within the sensor or its electrical supply, rather than solely in the ESP32 or software.',
            ],
            [
                'Power Supply Investigation',
                'Further inspection revealed that one of the older PIR sensors contained a damaged component, which contributed to the instability. However, replacing it did not completely solve the problem.',
                'After researching similar cases, I discovered that the HC-SR505 contains an internal 7133-1 low-dropout voltage regulator (LDO), which regulates its internal supply to 3.3 V.',
                'The sensor had been powered directly from the ESP32 3.3 V output. Measurements at the regulator input showed only approximately 2.8 V, which was insufficient for the regulator to maintain a stable 3.3 V output.',
                'This explained why the sensor could behave unpredictably even though its nominal operating voltage appeared to support a 3.3 V supply.',
            ],
            [
                'Hardware Revision',
                'To resolve the power supply issue, I decided to power the PIR sensors using approximately 5 V instead of directly supplying them with 3.3 V.',
                'The system uses a Mean Well LRS-100-24 power supply, which provides the primary 24 V supply. A DC-DC buck converter reduces this voltage to 5 V, which is then used to power the Raspberry Pi Pico 2 and the connected PIR sensors through its VBUS supply.',
                'After the modification, measurements showed approximately 4.8 V at the internal LDO input and a stable 3.3 V at its output. The PIR signal measured approximately 0 V at rest and 3.3 V when motion was detected.',
                'The sensors were then tested over an extended period. Random triggers had disappeared, while actual movement continued to be detected correctly.',
            ],
            [
                'PCB Design',
                'Once the electronics were operating reliably, I moved on to designing a custom printed circuit board using KiCad.',
                'This was my first experience designing a PCB and creating a complete electrical schematic. By following a detailed YouTube tutorial, I learned the necessary workflow and gradually translated the working prototype into a proper circuit design.',
                'After completing the schematic and PCB layout, I ordered the first prototype. Since I had initially designed the board around the ESP32, switching to the Raspberry Pi Pico 2 meant that the original PCB could no longer be used.',
                'I therefore had to redesign the board and order a second version. This cost approximately €25 extra, which I considered a worthwhile investment in practical experience.',
            ],
            [
                'Final Result',
                'The final system successfully detects movement and automatically illuminates the stairs. After resolving the sensor instability and redesigning the electronics around the Raspberry Pi Pico 2, the system operated reliably during testing.',
                'Most importantly, the installation provides my mother with better visibility and makes navigating the stairs considerably easier.',
            ],
            [
                'Lessons Learned',
                'This project taught me the importance of systematic troubleshooting. What initially appeared to be a software or GPIO problem turned out to be primarily related to the PIR sensor’s internal voltage regulator and insufficient supply voltage, combined with a defective sensor.',
                'I also gained practical experience with electronic measurements, power supply design, pull-down resistors, microcontrollers and PCB development using KiCad.',
                'One of the most important lessons was to investigate the electrical requirements of components more carefully before integrating them into a system. In future projects, I will pay closer attention to voltage regulation, operating voltages and signal stability during the initial design phase.',
            ],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function stairLightingComponents(): array
    {
        $groups = [
            ProjectComponentGroup::Hardware->value => [
                'Raspberry Pi Pico 2',
                'ESP32',
                'Mean Well LRS-100-24',
                '5 V DC-DC Buck Converter',
                '10 kΩ PULL DOWN Resistor',
                '220 Ω Resistor',
                'PCB (Printed Circuit Board)',
                'RFP30N06LE (N-Mosfet)',
            ],
            ProjectComponentGroup::Software->value => [
                'KiCad',
                'GPIO',
                'Thonny',
                'MicroPython',
            ],
            ProjectComponentGroup::Sensor->value => [
                'HC-SR505 PIR Sensor',
            ],
        ];

        return $this->groupedComponents($groups);
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function plymouthChapters(): array
    {
        return [
            ['title' => 'Introductie', 'paragraphs' => [
                'Tijdens mijn laatste stage, bij het Battlebot-project, kregen Matthijs en ik de vraag of het ons leuk leek om studenten van City College Plymouth te begeleiden tijdens een internationale uitwisseling. Zonder lang na te denken waren we het er allebei over eens: dat gaan we doen!',
                'De voorbereiding bleek een behoorlijke uitdaging, want we hadden nog maar één week om een project te bedenken en het volledige programma voor te bereiden. Na overleg met verschillende docenten en onze stagebegeleider besloten we een project rondom de BBC micro:bit te organiseren.',
                'Ons doel was om de studenten op een praktische en interactieve manier kennis te laten maken met programmeren, elektronica en draadloze communicatie. Geïnspireerd door Mario Kart bedachten we verschillende battles waarin de studenten hun eigen robotauto\'s konden programmeren en tegen elkaar konden inzetten.',
            ]],
            ['title' => 'Projectvoorbereiding', 'paragraphs' => [
                'We verdeelden de studenten in drie teams van vier personen. Elk team kreeg de beschikking over een Maqueen V2-robotauto, een Gamepad en twee micro:bits. Eén micro:bit werd gebruikt voor de besturing van de auto en de andere voor de Gamepad.',
                'De studenten kregen twee weken de tijd om hun hardware te programmeren voordat de verschillende battles zouden plaatsvinden. We boden zowel Code Blocks als Python aan, maar uiteindelijk kozen alle drie de teams ervoor om met Python te werken.',
                'Naast de technische opdrachten ontwikkelden we een puntensysteem waarbij niet alleen de resultaten van de battles meetelden, maar ook teamwork, programmeervaardigheden, creativiteit en het behalen van specifieke doelstellingen. Zo wilden we voorkomen dat uitsluitend het snelste team zou winnen.',
            ]],
            ['title' => 'Kennismaking met de micro:bit', 'paragraphs' => [
                'De eerste dagen stonden in het teken van kennismaken met de BBC micro:bit en de programmeermogelijkheden ervan. We begonnen met eenvoudige opdrachten, zoals het weergeven van afbeeldingen en tekst op het LED-display.',
                'Vervolgens introduceerden we de ingebouwde radiofunctionaliteit met behulp van radio.on(). Hiermee konden de studenten draadloos berichten versturen tussen verschillende micro:bits en kennismaken met de basisprincipes van communicatie tussen embedded systemen.',
                'Om deze opdracht uitdagender te maken, moesten de teams zelf een versleutelingsmethode bedenken voor de berichten die ze via de radio verstuurden. Eén team koos voor een Caesar cipher, een ander voor XOR-encryptie en het derde team voor een oplossing op basis van ASCII-codering.',
                'De volgende dag moesten de teams uitleggen hoe hun gekozen versleuteling werkte. Hiermee stimuleerden we niet alleen het schrijven van code, maar ook het daadwerkelijk begrijpen en kunnen uitleggen van de onderliggende principes.',
            ]],
            ['title' => 'Maqueen en Gamepad', 'paragraphs' => [
                'Na de introductie van de micro:bit maakten de studenten kennis met de Maqueen V2-robotauto en de bijbehorende Gamepad. Binnen ieder team werden de verantwoordelijkheden verdeeld: twee studenten hielden zich bezig met de Gamepad en de andere twee met de Maqueen.',
                'Het belangrijkste doel was om betrouwbare communicatie tussen beide apparaten te realiseren en de benodigde functionaliteit te programmeren om de robotauto op afstand te besturen.',
                'Naarmate het project vorderde, introduceerden we uitgebreidere functionaliteiten, waaronder geleidelijke acceleratie. We gaven de studenten hiervoor een formule waarmee ze de snelheid van de Maqueen geleidelijk konden laten opbouwen, in plaats van de motoren direct op volle snelheid te laten draaien.',
                'Daarnaast organiseerden we een extra Python-les voor studenten die wat meer ondersteuning nodig hadden. Als creatieve opdracht mochten ze een eigen overwinningsdansje bedenken en programmeren met de micro:bit.',
            ]],
            ['title' => 'Battles en Puntentelling', 'paragraphs' => [
                'De competitie bestond uit verschillende uitdagingen, geïnspireerd door Mario Kart. Elk team kreeg de mogelijkheid om punten te verdienen tijdens de afzonderlijke battles en door hun algemene prestaties.',
                'We beoordeelden de teams op samenwerking, programmeervaardigheden, creativiteit en het behalen van specifieke doelstellingen. Voor teamwork konden maximaal 30 punten worden verdiend en voor programming maximaal 20 punten.',
                'Ook creativiteit speelde een belangrijke rol. Teams werden beloond voor originele ideeën en effectieve oplossingen. Daarnaast waren er per battle specifieke doelstellingen waarmee extra punten verdiend konden worden.',
                'Met deze aanpak wilden we de studenten stimuleren om zelfstandig na te denken, goed samen te werken en eigen oplossingen te ontwikkelen, in plaats van uitsluitend bezig te zijn met het winnen van de competitie.',
            ]],
            ['title' => 'Battle 1: Maze', 'paragraphs' => [
                'De eerste battle was een doolhofuitdaging. We maakten een parcours met zwarte tape op een witte ondergrond. Onderweg waren verschillende kruispunten gemarkeerd met gekleurde tape, die de studenten konden verzamelen.',
                'Het doel was om de Maqueen zo snel mogelijk door het doolhof te manoeuvreren. Iedere botsing met een muur leverde vijf seconden straftijd op, terwijl het verzamelen van de gemarkeerde kruispunten juist tijd van de eindtijd aftrok.',
                'Om deze uitdaging technisch te ondersteunen, hadden we een basisimplementatie voorbereid voor de lijnsensoren van de Maqueen. De sensoren werden via I2C uitgelezen, waardoor het programma kon detecteren wanneer de auto een zwarte lijn raakte. Zodra dit gebeurde, kleurden de RGB-leds onder de Maqueen rood.',
                'De studenten moesten deze functionaliteit integreren in hun eigen besturingsprogramma. Hiervoor moesten ze sensorinformatie, motorbesturing en visuele feedback combineren, terwijl ze de robot onder controle hielden.',
                'De Maze-battle werd succesvol uitgevoerd en vormde de eerste praktische test van de programmeer- en rijvaardigheden van de teams.',
            ]],
            ['title' => 'Battle 2: Mario Kart Race', 'paragraphs' => [
                'De tweede geplande battle was een race, geïnspireerd door Mario Kart. We wilden verschillende power-ups introduceren die de teams tijdens het parcours konden verzamelen en strategisch konden inzetten.',
                'Het idee was om speciale markeringen op het parcours te plaatsen. Zodra een team over een markering reed, konden wij als begeleiders via een aparte micro:bit een draadloos bericht naar het betreffende team versturen. Hierdoor werd een Boolean-status in hun programma geactiveerd, waardoor de verzamelde power-up beschikbaar kwam.',
                'We hadden drie verschillende power-ups bedacht: Stun, waarmee tegenstanders tijdelijk konden worden stilgezet; Speed, waarmee de Maqueen gedurende vijf seconden van 80% naar 100% snelheid kon gaan; en Invincible, waarmee een team dertig seconden onschendbaar zou zijn.',
                'Hoewel we een deel van de functionaliteit hadden geïmplementeerd, bleef vooral de draadloze communicatie rondom de Stun-power-up instabiel. De Speed-functionaliteit werkte, maar we kregen niet alle onderdelen binnen de beschikbare tijd betrouwbaar genoeg werkend.',
                'Uiteindelijk hebben we besloten deze race niet uit te voeren. Het ontwikkelen van deze functionaliteit leverde desondanks interessante ervaring op met draadloze communicatie, statusbeheer en het combineren van verschillende hardwarecomponenten.',
            ]],
            ['title' => 'Battle 3: Rocket League', 'paragraphs' => [
                'Oorspronkelijk hadden we voor de derde battle een Balloonbattle bedacht. Hierbij zouden ballonnen achter op de Maqueen worden bevestigd en zou er aan de voorkant een prikker zitten waarmee de ballonnen van tegenstanders kapotgemaakt konden worden.',
                'De studenten kwamen echter zelf met een ander voorstel: of we in plaats daarvan Rocket League konden spelen. Dat vonden we een leuk idee, waarna we besloten het programma aan hun voorstel aan te passen.',
                'Voor deze battle kreeg ieder team twee Maqueen-robotauto\'s. We maakten een speelveld met aan beide kanten een doel en plaatsten een pingpongbal in het midden.',
                'Het doel was om als eerste drie doelpunten te maken tegen het andere team. Deze uitdaging gaf de studenten de mogelijkheid om hun geprogrammeerde auto\'s op een compleet andere manier te gebruiken en vereiste bovendien goede samenwerking tussen de spelers.',
                'De Rocket League-battle vormde de afsluiting van het competitieve gedeelte en liet zien hoe de studenten hun programmeerwerk op een creatieve en onverwachte manier konden toepassen.',
            ]],
            ['title' => 'Afsluiting', 'paragraphs' => [
                'De laatste dag stond in het teken van presentaties, een Kahoot-quiz en het bekendmaken van het winnende team.',
                'De studenten kregen de gelegenheid om te laten zien wat ze hadden ontwikkeld en om een aantal keuzes uit te leggen die ze tijdens het project hadden gemaakt. Ook keken we terug op hun samenwerking, programmeervaardigheden, creativiteit en prestaties tijdens de verschillende uitdagingen.',
                'Hoewel niet alle geplande battles uiteindelijk uitgevoerd konden worden, was het project een geslaagde afsluiting van de uitwisseling. We hadden binnen een zeer beperkte voorbereidingstijd een compleet programma opgezet en de studenten begeleid vanaf hun eerste micro:bit-opdrachten tot het programmeren en besturen van hun eigen robotauto\'s.',
            ]],
            ['title' => 'Mijn Bijdrage en Ervaring', 'paragraphs' => [
                'Dit project was voor mij een waardevolle ervaring, omdat mijn rol veranderde van voornamelijk zelf software ontwikkelen naar het begeleiden en onderwijzen van anderen. Samen met Matthijs heb ik het programma voorbereid, de technische opdrachten uitgewerkt en de studenten gedurende de uitwisseling begeleid.',
                'Verschillende technische onderwerpen kwamen hierbij samen, waaronder Python, microcontrollers, draadloze communicatie, I2C en hardwarebesturing. Daarnaast moesten we technische concepten duidelijk kunnen uitleggen en onze begeleiding aanpassen aan studenten met verschillende niveaus van programmeerervaring.',
                'Wat ik vooral interessant vond, was het begeleiden van studenten bij het ontwikkelen van hun eigen oplossingen. In plaats van simpelweg code aan te leveren, stimuleerden we ze om zelf problemen te onderzoeken, te begrijpen hoe hun programma\'s werkten en kritisch na te denken over hun implementaties.',
                'De beperkte voorbereidingstijd en onverwachte technische uitdagingen leerden mij bovendien hoe belangrijk flexibiliteit is. Niet alles verliep volgens het oorspronkelijke plan, maar samen met de studenten hebben we steeds gekeken naar alternatieven en mogelijkheden.',
                'Terugkijkend heeft dit project mij niet alleen technisch verder ontwikkeld, maar ook ervaring opgeleverd met begeleiden, organiseren, presenteren en het overbrengen van technische kennis. Het was bijzonder om te zien hoe de studenten steeds zelfstandiger werden en uiteindelijk met hun eigen geprogrammeerde robotauto\'s tegen elkaar konden strijden.',
            ]],
        ];
    }

    /**
     * English chapter texts, aligned with plymouthChapters().
     *
     * @return list<array{0: string, 1: string}>
     */
    private function plymouthChapterTranslations(): array
    {
        return [
            [
                'Introduction',
                'During my final internship at the Battlebot project, Matthijs and I were asked whether we would be interested in supervising students from City College Plymouth during an international exchange. We immediately agreed.',
                'The preparation proved quite challenging, as we had only one week to come up with a project and prepare the entire programme. After consulting several teachers and discussing our ideas with our internship supervisor, we decided to organise a project centred around the BBC micro:bit.',
                'Our goal was to introduce the students to programming, electronics and wireless communication through practical and interactive activities. Inspired by Mario Kart, we designed several battles in which the students would programme their own robot cars and compete against each other.',
            ],
            [
                'Project Planning',
                'We divided the students into three teams of four. Each team received a Maqueen V2 robot car, a Gamepad and two micro:bit boards. One micro:bit was used to control the car, while the other operated the Gamepad.',
                'The students were given two weeks to programme their hardware before competing in several battles. We offered both Code Blocks and Python, but all three teams eventually chose to work with Python.',
                'In addition to the technical challenges, we developed a scoring system that evaluated teamwork, programming skills, creativity and objectives achieved during each battle. This ensured that the competition rewarded more than just speed or the final result.',
            ],
            [
                'Introduction to Micro:bit',
                'The first days focused on introducing the students to the BBC micro:bit and its programming capabilities. We started with simple exercises, such as displaying images and text on the LED display.',
                'Next, we introduced the built-in radio functionality using radio.on(). This allowed the students to send wireless messages between different micro:bits and explore the fundamentals of communication between embedded systems.',
                'To make the exercise more challenging, each team had to develop its own encryption method for the messages transmitted over the radio. One team implemented a Caesar cipher, another used XOR encryption, while the third chose an approach based on ASCII encoding.',
                'The following day, the teams had to explain how their chosen encryption methods worked. This encouraged them not only to write code, but also to understand and explain the underlying principles.',
            ],
            [
                'Maqueen and Gamepad',
                'After introducing the micro:bit, the students moved on to the Maqueen V2 robot car and its accompanying Gamepad. Each team divided its responsibilities, with two students working on the Gamepad and the other two focusing on the Maqueen.',
                'The main objective was to establish reliable communication between both devices and programme the functionality required to control the robot car remotely.',
                'As the project progressed, we introduced more advanced functionality, including gradual acceleration. We provided the students with a formula to implement acceleration correctly, allowing the Maqueen to increase its speed gradually instead of immediately running at full power.',
                'We also organised an additional Python lesson for students who needed more support. As a creative exercise, they were challenged to design and programme their own victory dance using the micro:bit.',
            ],
            [
                'Battles and Scoring System',
                'The competition consisted of several challenges inspired by Mario Kart. Each team had opportunities to earn points during the individual battles and through their overall performance.',
                'We evaluated the teams on teamwork, programming skills, creativity and the completion of specific objectives. Teamwork contributed a maximum of 30 points, while programming contributed 20 points.',
                'Creativity was also an important part of the scoring system, rewarding original ideas and effective solutions. Each battle also included specific objectives that could earn additional points.',
                'This approach encouraged the students to think independently, collaborate effectively and develop their own solutions instead of focusing exclusively on winning the competition.',
            ],
            [
                'Battle 1: Maze',
                'The first battle was a maze challenge. We created a course using black tape on a white surface, with several coloured intersections that the students could collect along the way.',
                'The objective was to navigate the Maqueen through the maze as quickly as possible. Every collision with a wall resulted in a five-second penalty, while collecting the marked intersections reduced the final time.',
                'To support this challenge, we prepared a basic implementation for the Maqueen\'s line sensors. The sensors were read through I2C, allowing the programme to detect when the car encountered a black line. Whenever this happened, the RGB LEDs underneath the Maqueen turned red.',
                'The students had to integrate this functionality into their own control programmes. This required them to combine sensor input, motor control and visual feedback while maintaining control of the robot.',
                'The Maze battle was successfully completed and became the first practical test of the teams\' programming and driving skills.',
            ],
            [
                'Battle 2: Mario Kart Race',
                'The second planned battle was a race inspired by Mario Kart. We wanted to introduce several power-ups that the teams could collect during the course and activate strategically.',
                'The idea was to place special markers along the track. Whenever a team drove over one of these markers, we could send a wireless message from a separate micro:bit to the corresponding team. This would activate a Boolean state in their programme, making the collected power-up available.',
                'We designed three different power-ups: Stun, which temporarily stopped opposing players; Speed, which increased the Maqueen from 80% to 100% speed for five seconds; and Invincible, which provided temporary protection for thirty seconds.',
                'Although we managed to implement part of the functionality, the wireless communication surrounding the Stun power-up remained unstable. The Speed functionality worked, but we could not get all components operating reliably within the available time.',
                'We eventually decided not to run the race. Nevertheless, developing this functionality provided valuable experience with wireless communication, state management and combining different hardware components.',
            ],
            [
                'Battle 3: Rocket League',
                'The original plan for the third battle was a Balloonbattle. Balloons would be attached to the back of each Maqueen, with a small skewer at the front to pop the balloons of opposing players.',
                'However, the students suggested playing Rocket League instead. We liked the idea and decided to adapt the programme to their suggestion.',
                'For this battle, each team received two Maqueen robot cars. We created a playing field with a goal at each end and placed a ping-pong ball in the centre.',
                'The objective was to score three goals against the opposing team. This challenge allowed the students to use their programmed cars in a completely different way and required good coordination between the players.',
                'The Rocket League battle became the conclusion of the competitive part of the project and demonstrated how the students could apply their programming work in a creative and unexpected way.',
            ],
            [
                'Final Day',
                'The final day was dedicated to presentations, a Kahoot quiz and announcing the winning team.',
                'The students had the opportunity to demonstrate what they had developed and explain some of the decisions they had made during the project. We also reviewed their teamwork, programming skills, creativity and performance throughout the different challenges.',
                'Although not every planned battle could be completed, the project provided a successful conclusion to the exchange. We had developed a complete programme within a very limited preparation period and guided the students from their first micro:bit exercises to programming and controlling their own robot cars.',
            ],
            [
                'My Contribution and Experience',
                'This project was a valuable experience because my role shifted from primarily developing software myself to guiding and teaching others. Together with Matthijs, I prepared the programme, developed the technical challenges and supervised the students throughout the exchange.',
                'Several technical subjects came together, including Python, microcontrollers, wireless communication, I2C and hardware control. We also had to explain technical concepts clearly and adapt our guidance to students with different levels of programming experience.',
                'One of the aspects I particularly enjoyed was helping students develop their own solutions. Rather than simply providing code, we encouraged them to investigate problems, understand how their programmes worked and think critically about their implementations.',
                'The limited preparation time and unexpected technical challenges also taught me the importance of flexibility. Not everything went according to the original plan, but together with the students, we continuously looked for alternatives and solutions.',
                'Looking back, this project helped me develop not only my technical skills, but also my experience in mentoring, organising, presenting and communicating technical knowledge. Seeing the students become increasingly independent and eventually compete using their own programmed robot cars made the experience especially rewarding.',
            ],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function plymouthComponents(): array
    {
        $groups = [
            ProjectComponentGroup::Hardware->value => [
                'BBC micro:bit V2',
                'DFRobot Maqueen V2',
                'DFRobot micro:bit Gamepad',
            ],
            ProjectComponentGroup::Software->value => [
                'Python',
                'MicroPython',
                'I2C',
            ],
            ProjectComponentGroup::Sensor->value => [
                'Maqueen Line Sensors',
            ],
        ];

        return $this->groupedComponents($groups);
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function dungeonCrawlerChapters(): array
    {
        return [
            ['title' => 'De voorbereiding', 'paragraphs' => [
                'Een oud-docent met wie ik nog regelmatig contact heb, vroeg me of ik interesse had om mee te doen aan de hackathon van The Dutch Laravel Foundation. Zonder aarzelen zei ik direct ja! Ik had eerder al meegedaan aan de ZeroDay Hackathon in Zoetermeer, dus ik had inmiddels een klein beetje ervaring met dit soort evenementen. Desondanks vond ik het opnieuw enorm spannend om hieraan deel te nemen.',
                'Ongeveer twee jaar geleden was ik overgestapt van PHP naar Python, omdat ik me destijds meer in die programmeertaal wilde verdiepen. Dat betekende dat ik voor deze hackathon mijn kennis van PHP en Laravel weer even moest opfrissen. Gelukkig was Laravel me niet helemaal onbekend. Tijdens mijn opleiding aan mboRijnland had ik namelijk bewust voor Laravel als keuzedeel gekozen. Daardoor kon ik de basis vrij snel weer oppakken.',
            ]],
            ['title' => 'Een geschikt oefenproject', 'paragraphs' => [
                'In eerste instantie vroeg ik ChatGPT om me te helpen bij de voorbereiding. Al snel merkte ik echter dat de ideeën die daaruit voortkwamen nogal standaard waren. Een veelvoorkomend voorbeeld was een bibliotheeksysteem waarin je boeken, auteurs, titels en beoordelingen kunt beheren. Hoewel ik dit idee kort als uitgangspunt gebruikte, kwam ik al snel tot de conclusie dat het te beperkt was. Ik wilde een project waarmee ik verschillende onderdelen van Laravel kon oefenen en tegelijkertijd voldoende ruimte had om nieuwe technieken te ontdekken.',
                'Daarom besloot ik zelf op zoek te gaan naar een beter idee. Ik moest terugdenken aan een PHP-opdracht tijdens mijn mbo-opleiding, waarbij we een terminalgebaseerde dungeon crawler moesten ontwikkelen. Dat leek me een uitstekend uitgangspunt voor mijn voorbereiding.',
                'Ik wilde het project alleen niet beperken tot een spel dat volledig uit tekst bestond. Juist omdat ik ook ervaring wilde opdoen met een frontendframework, besloot ik er een visueel spel van te maken. Zo kon ik niet alleen met Laravel aan de slag, maar ook de frontend en de communicatie tussen beide onderdelen meenemen in mijn project.',
            ]],
            ['title' => 'De keuze voor mijn tech stack', 'paragraphs' => [
                'Voor de frontend was ik op zoek naar een framework waarmee ik nog niet veel ervaring had. React viel daarom af: daar had ik inmiddels al meerdere keren mee gewerkt. Ik wilde juist iets nieuws leren.',
                'Ik had al regelmatig over Vue.js gehoord en besloot me daarin te verdiepen. Na wat brainstormen en het vergelijken van de mogelijkheden koos ik uiteindelijk voor Vue.js. Voor de database gebruikte ik MySQL. Daar had ik al behoorlijk wat ervaring mee en bovendien was het eenvoudig op te zetten en te testen op mijn Omarchy-besturingssysteem.',
                'Daarmee was mijn tech stack compleet: PHP en Laravel voor de backend, Vue.js voor de frontend en MySQL als database.',
            ]],
            ['title' => 'Bewust zonder AI programmeren', 'paragraphs' => [
                'Een belangrijk uitgangspunt van dit project was dat ik zo min mogelijk AI wilde gebruiken bij het schrijven van de code. Ik wilde vooral zelf ontdekken hoe Laravel in de praktijk werkt en mijn programmeervaardigheden verder ontwikkelen.',
                'Dat betekende niet dat ik helemaal geen gebruikmaakte van ChatGPT. Ik gebruikte het bijvoorbeeld om advies te vragen over de structuur van mijn project en de manier waarop ik bepaalde onderdelen het beste kon implementeren. De daadwerkelijke uitwerking wilde ik echter zo veel mogelijk zelf doen.',
                'Achteraf gezien is dat niet op alle punten even goed gelukt. Zo kwam uiteindelijk een groot gedeelte van de speltechniek terecht in één bestand: de DungeonController. Dat was niet de structuur waar ik naartoe wilde werken. Ik had het project liever opgesplitst in afzonderlijke Services, Middleware, Actions en andere classes, zodat de verantwoordelijkheden beter verdeeld zouden zijn.',
            ]],
            ['title' => 'Een zelfbedacht systeem voor de minimap', 'paragraphs' => [
                'Een onderdeel waar ik zelf behoorlijk trots op ben, is het systeem achter de minimap. Niet zozeer vanwege de uiteindelijke code, maar vooral omdat het onderliggende idee volledig uit mijn eigen koker kwam.',
                'In de minimap wordt een pijl weergegeven die aangeeft in welke richting de speler kijkt. Daarnaast moet het spel weten aan welke kant van een kamer de deuren zich bevinden. Ik wilde hiervoor een systeem ontwikkelen waarbij de richting van de speler en de positie van de deuren op een logische manier aan elkaar gekoppeld werden.',
                'Mijn uitgangspunt was om iedere richting een numerieke waarde te geven en deze te koppelen aan een X- en Y-coördinaat. North kreeg waarde 0, West waarde 1, South waarde 2 en East waarde 3. De coördinaten bepaalden vervolgens de bijbehorende positie op de minimap. Hierbij hield ik rekening met het feit dat de Y-as op het scherm naar beneden loopt.',
                'Het idee was om de speler bij het starten van een kamer standaard naar het noorden te laten kijken. Wanneer de speler vervolgens een andere richting op beweegt, verandert ook de oriëntatie. De numerieke waarde wordt daarbij aangepast aan de hand van de draairichting. Door de waarden met modulo 4 te laten doorlopen, kunnen de vier richtingen steeds opnieuw worden gebruikt.',
                'Op die manier kan het spel bepalen waar de speler naartoe kijkt en aan welke kant de deuren zich bevinden. De minimap kan vervolgens de juiste positie en oriëntatie weergeven, ongeacht de richting waarin de speler kijkt.',
                'Voor de berekening van dit systeem had ik uiteindelijk wel hulp van ChatGPT nodig. Ik had zelf ongeveer 75% van de bijbehorende code geschreven, maar liep vast bij het bepalen van de juiste berekeningen. Het concept en de manier waarop ik het probleem wilde oplossen, had ik zelf bedacht. De hulp van ChatGPT gebruikte ik vooral om de wiskundige uitwerking daarvan goed te krijgen.',
            ]],
            ['title' => 'Code refactoring', 'paragraphs' => [
                'Voordat ik het project voortijdig beëindigde, was ik al begonnen met het refactoren van de code. Mijn bedoeling was om de verschillende verantwoordelijkheden onder te brengen in afzonderlijke Services, Middleware, Actions en andere classes.',
                'Helaas heb ik niet genoeg tijd gehad om deze herstructurering volledig af te ronden. Zo bleef een groot gedeelte van de speltechniek in de DungeonController staan. Mocht ik het project in de toekomst weer oppakken, dan is het verder opsplitsen en structureren van de code een van de eerste zaken die ik zou aanpakken.',
            ]],
            ['title' => 'Het resultaat en mijn ervaring', 'paragraphs' => [
                'Uiteindelijk is er een goede basis voor een dungeon crawler ontstaan. Het was een relatief kort project, maar tegelijkertijd een bijzonder leerzame ervaring.',
                'Hoewel ik al redelijk bekend was met PHP en Laravel, heb ik tijdens het ontwikkelen toch veel nieuwe dingen geleerd en mijn bestaande kennis verder kunnen opfrissen. Daarnaast heb ik kennisgemaakt met Vue.js en ervaring opgedaan met het combineren van een backend, frontend en database binnen één applicatie.',
                'Voor mij was dit project vooral een goede manier om weer vertrouwd te raken met Laravel, nieuwe technieken te ontdekken en zelfstandig een applicatie op te bouwen waarin verschillende onderdelen samenkomen.',
            ]],
        ];
    }

    /**
     * English chapter texts, aligned with dungeonCrawlerChapters().
     *
     * @return list<list<string>>
     */
    private function dungeonCrawlerChapterTranslations(): array
    {
        return [
            [
                'The Preparation',
                'A former teacher whom I still keep in regular contact with asked me whether I would be interested in participating in the hackathon organised by The Dutch Laravel Foundation. Without hesitation, I immediately said yes! I had previously participated in the ZeroDay Hackathon in Zoetermeer, so I already had some experience with these kinds of events. Nevertheless, I was still very excited and a little nervous about taking part.',
                'Around two years earlier, I had moved away from PHP to focus more on Python. This meant I needed to refresh my knowledge of both PHP and Laravel before the hackathon. Fortunately, Laravel was not entirely new to me. During my studies at mboRijnland, I had deliberately chosen Laravel as an elective. This allowed me to pick up the fundamentals again fairly quickly.',
            ],
            [
                'Finding the Right Practice Project',
                'Initially, I asked ChatGPT to help me prepare for the hackathon. However, I quickly noticed that the ideas it suggested were rather conventional. A common example was a library management system where you could manage books, authors, titles and ratings. Although I briefly considered this idea, I soon realised that it was too limited. I wanted a project that would allow me to practise different aspects of Laravel while also giving me enough room to explore new technologies.',
                'I therefore decided to come up with a better idea myself. I remembered a PHP assignment from my vocational studies in which we had to develop a terminal-based dungeon crawler. This seemed like an excellent starting point for my preparation.',
                'However, I did not want to limit the project to a game consisting entirely of text. Since I also wanted to gain experience with a frontend framework, I decided to turn it into a visual game. This allowed me to work not only with Laravel, but also with the frontend and the communication between both parts of the application.',
            ],
            [
                'Choosing My Tech Stack',
                'For the frontend, I was looking for a framework I had little experience with. React was therefore not an option, as I had already worked with it several times. I specifically wanted to learn something new.',
                'I had heard about Vue.js on several occasions and decided to explore it further. After some brainstorming and comparing the possibilities, I ultimately chose Vue.js. For the database, I used MySQL. I was already quite familiar with it, and it was also straightforward to set up and test on my Omarchy operating system.',
                'With that, my tech stack was complete: PHP and Laravel for the backend, Vue.js for the frontend and MySQL as the database.',
            ],
            [
                'Deliberately Programming Without AI',
                'One of the main principles of this project was to use as little AI as possible when writing the code. I wanted to discover how Laravel works in practice and further develop my own programming skills.',
                'That did not mean I avoided ChatGPT entirely. I occasionally used it for advice on project structure and how to approach certain implementations. However, I wanted to do as much of the actual development myself as possible.',
                'In retrospect, I did not manage to achieve this perfectly in every respect. A large part of the game logic eventually ended up in a single file: the DungeonController. This was not the structure I had originally intended. I would have preferred to separate the code into individual Services, Middleware, Actions and other classes, allowing responsibilities to be distributed more effectively.',
            ],
            [
                'A Custom-Built Minimap System',
                'One part of the project I am particularly proud of is the system behind the minimap. Not necessarily because of the final implementation, but mainly because the underlying concept was entirely my own idea.',
                'The minimap displays an arrow indicating which direction the player is facing. The game also needs to know which side of a room contains each door. I wanted to develop a system that logically connected the player’s orientation with the positions of the doors.',
                'My approach was to assign a numerical value to each direction and connect it to an X and Y coordinate. North was assigned the value 0, West 1, South 2 and East 3. The coordinates then determined the corresponding position on the minimap. I also accounted for the fact that the Y-axis on a screen increases downwards.',
                'The idea was to make the player face north by default when entering a room. When the player moves in another direction, their orientation changes accordingly. The numerical value is adjusted based on the direction of rotation. By using modulo 4, the four direction values can continuously cycle without exceeding their range.',
                'This allows the game to determine which direction the player is facing and which side of the room contains the doors. The minimap can then display the correct positions and orientation, regardless of the direction the player is facing.',
                'I eventually needed some help from ChatGPT with the calculations behind this system. I had written approximately 75% of the related code myself, but got stuck when working out the correct calculations. The concept and the approach to solving the problem were my own. I mainly used ChatGPT to help me work out the mathematical implementation.',
            ],
            [
                'Code Refactoring',
                'Before discontinuing the project, I had already started refactoring the code. My intention was to move the different responsibilities into separate Services, Middleware, Actions and other classes.',
                'Unfortunately, I did not have enough time to complete this restructuring. As a result, a large part of the game logic remained in the DungeonController. If I ever return to this project, further separating and structuring the code will be one of the first things I address.',
            ],
            [
                'The Result and What I Learned',
                'Ultimately, I managed to build a solid foundation for a dungeon crawler. It was a relatively short project, but also a very valuable learning experience.',
                'Although I was already reasonably familiar with PHP and Laravel, I still learned a great deal during development and was able to refresh my existing knowledge. I also gained experience with Vue.js and combining a backend, frontend and database within a single application.',
                'For me, this project was primarily an opportunity to become familiar with Laravel again, explore new technologies and independently build an application in which several different components work together.',
            ],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function dungeonCrawlerComponents(): array
    {
        $groups = [
            ProjectComponentGroup::Software->value => [
                'PHP',
                'Laravel',
                'Vue.js',
                'JavaScript',
                'MySQL',
            ],
        ];

        return $this->groupedComponents($groups);
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function portfolioV1Chapters(): array
    {
        return [
            ['title' => 'Het idee en de voorbereiding', 'paragraphs' => [
                'Als softwareontwikkelaar is een eigen portfolio natuurlijk een mooie manier om je werk en vaardigheden te presenteren, zeker wanneer je aan het begin van je carrière staat. Daarom besloot ik na het afronden van mijn opleiding direct aan de slag te gaan met het ontwikkelen van mijn eigen portfolio website.',
                'Mijn insteek was tweeledig: enerzijds wilde ik een mooie website neerzetten, maar anderzijds wilde ik er vooral veel van leren. Ik wilde gestructureerd leren werken, zo min mogelijk afhankelijk zijn van AI en mijn programmeervaardigheden verder ontwikkelen. Daarbij wilde ik me voornamelijk richten op Python, omdat ik daar op dat moment graag beter in wilde worden.',
                'Aanvankelijk lukte dat behoorlijk goed. Ik probeerde zoveel mogelijk zelf uit te zoeken en oplossingen te bedenken voordat ik hulp inschakelde. Toch merkte ik al vrij snel dat sommige keuzes die ik vooraf had gemaakt niet helemaal aansloten bij wat het project uiteindelijk nodig had.',
            ]],
            ['title' => 'Van Flask naar Django', 'paragraphs' => [
                'In eerste instantie wilde ik helemaal geen relationele database gebruiken. Mijn idee was om de gegevens eenvoudig op te slaan in JSON-bestanden. Naarmate het project groeide, merkte ik echter dat deze aanpak minder geschikt was voor de hoeveelheid en de structuur van de gegevens die ik wilde beheren.',
                'Daarom besloot ik over te stappen van Flask naar Django. Een belangrijk voordeel van Django was de ingebouwde ORM (Object-Relational Mapping). Hiermee kon ik modellen definiëren en op een gestructureerde manier met mijn database communiceren, zonder daarvoor een externe ORM-dependency te hoeven installeren.',
                'Als database koos ik uiteindelijk voor MySQL. Daar had ik tijdens mijn opleiding al de nodige ervaring mee opgedaan, waardoor ik me op dat onderdeel niet volledig opnieuw hoefde te verdiepen.',
            ]],
            ['title' => 'Ontwerpen en experimenteren met SVG', 'paragraphs' => [
                'Ik vind het zelf erg leuk om te ontwerpen en vervolgens mijn ontwerpen om te zetten naar code. Dat is ook duidelijk terug te zien op mijn website, die behoorlijk wat zelfgemaakte SVG-illustraties bevat.',
                'Deze SVG\'s heb ik met JavaScript opgebouwd en gemanipuleerd. Hierdoor kon ik veel meer doen dan alleen statische afbeeldingen tonen. Ik kon verschillende elementen afzonderlijk aansturen en mijn ontwerpen interactief en dynamisch maken.',
                'Toch is het eindresultaat niet helemaal geworden zoals ik het oorspronkelijk in mijn hoofd had. Dat lag voornamelijk aan mijn eigen technische kennis. Ik had wel verschillende tutorials gevolgd om meer te leren over het werken met SVG\'s, maar het lukte me niet altijd om precies te realiseren wat ik voor ogen had.',
                'In plaats van daar volledig op vast te lopen, besloot ik mijn ontwerpideeën enigszins aan te passen. Zo ben ik uiteindelijk meer gaan experimenteren met een glasachtige uitstraling. Dat leverde een andere stijl op dan ik aanvankelijk had bedacht, maar gaf de website wel een eigen karakter.',
            ]],
            ['title' => 'De uitdagingen tijdens het ontwikkelen', 'paragraphs' => [
                'Het project begon eigenlijk behoorlijk goed. Ik had een duidelijk idee, de structuur stond en mijn motivatie was hoog. Naarmate het project vorderde, merkte ik echter dat zowel de structuur als mijn motivatie wat begonnen af te nemen.',
                'De code werd op sommige plekken een beetje een rommeltje en mijn motivatie kwam steeds meer met vlagen. Vooral het feit dat ik bepaalde ontwerpen niet voor elkaar kreeg zoals ik ze in gedachten had, begon me tegen te werken.',
                'Toch heb ik het project niet opgegeven. Ondanks de momenten waarop het wat minder soepel liep, bleef ik eraan werken. Uiteindelijk is het me gelukt om een volledig werkende portfolio website neer te zetten. Dat ging niet zonder de nodige frustraties, maar het resultaat stond er!',
            ]],
            ['title' => 'Mijn eerste eigen VPS-deployment', 'paragraphs' => [
                'Dit project was voor mij ook de eerste keer dat ik een complete website daadwerkelijk online zette op mijn eigen VPS. Daarmee kwam er een nieuw onderdeel bij kijken: het configureren van een productieomgeving en het veilig beschikbaar maken van mijn applicatie.',
                'Dit gedeelte heb ik grotendeels met behulp van AI opgezet. Ik wilde namelijk niet zomaar iets online zetten, maar ervoor zorgen dat de serverconfiguratie op een verantwoorde manier werd ingericht.',
                'Achteraf waren er nog wel een aantal zaken die beter hadden gekund. Zo was de scheiding tussen de development- en productieconfiguratie niet helemaal ideaal ingericht. Dat soort dingen ontdek je soms pas wanneer je daadwerkelijk met een applicatie op een eigen server werkt. Ook dat was weer een waardevolle les.',
                'De applicatie draait op mijn eigen VPS, waarbij Nginx als webserver en reverse proxy fungeert. Nginx ontvangt de binnenkomende HTTP-verzoeken en stuurt deze door naar Gunicorn. Gunicorn voert vervolgens mijn Django-applicatie uit via de WSGI-interface en geeft de gegenereerde responses weer terug.',
            ]],
            ['title' => 'Experimenteren met CI/CD', 'paragraphs' => [
                'Ik wilde tijdens dit project ook graag kennismaken met CI/CD, omdat dit een belangrijk onderdeel is van moderne softwareontwikkeling en veel wordt toegepast binnen het werkveld.',
                'Ik heb daarom geprobeerd om gedurende het project volgens deze werkwijze te werken. Dat leverde af en toe de nodige mergeconflicten op, maar ook daar heb ik mezelf doorheen moeten werken. Het was een goede manier om meer ervaring op te doen met Git en het werken met verschillende branches.',
                'De implementatie van CI/CD hield ik bewust vrij eenvoudig. Ik wilde eerst begrijpen wat het concept precies inhield en welk probleem het oplost, voordat ik allerlei automatische processen zou toevoegen.',
                'Als eerste stap heb ik Ruff geïmplementeerd in mijn CI-pipeline. Ruff is een Python-tool die zowel als linter als formatter gebruikt kan worden. De linter controleert mijn code op onder andere mogelijke fouten, ongebruikte imports en afwijkingen van de afgesproken programmeerstijl. De formatter kan daarnaast automatisch zorgen voor een consistente codeopmaak.',
                'Hierdoor kon ik bij wijzigingen automatisch laten controleren of mijn Python-code aan de ingestelde regels voldeed. Het was nog geen uitgebreide CI/CD-pipeline met geautomatiseerde tests en deployment, maar wel een eerste stap om vertrouwd te raken met deze manier van werken.',
            ]],
            ['title' => 'Deployment en het eindresultaat', 'paragraphs' => [
                'Het bijwerken van de website kon uiteindelijk via een vaste reeks terminalcommando\'s. Achteraf gezien had ik daar natuurlijk ook een shellscript voor kunnen schrijven, zodat ik het deploymentproces met één commando kon uitvoeren. Maar goed, zo bleef ik ondertussen ook nog wat extra Linux-commando\'s uit mijn hoofd leren!',
                'Uiteindelijk heb ik een werkende portfolio website gerealiseerd die ik volledig zelf heb ontworpen, ontwikkeld en online heb gezet. Het project verliep niet altijd even soepel en de uiteindelijke code en structuur waren niet overal zoals ik ze oorspronkelijk voor ogen had.',
                'Toch heb ik er ontzettend veel van geleerd. Ik heb niet alleen mijn kennis van Python, Flask en Django verder ontwikkeld, maar ook ervaring opgedaan met JavaScript, SVG, MySQL, Git, CI/CD en het beheren van een eigen VPS.',
                'Misschien nog wel belangrijker: ik heb ervaren hoeveel er komt kijken bij het ontwikkelen van een complete applicatie. Van het eerste ontwerp tot de database, de code en uiteindelijk het online beschikbaar maken ervan. Het was een behoorlijk project met de nodige uitdagingen, maar wel eentje waar ik uiteindelijk met trots op terugkijk.',
            ]],
        ];
    }

    /**
     * English chapter texts, aligned with portfolioV1Chapters().
     *
     * @return list<list<string>>
     */
    private function portfolioV1ChapterTranslations(): array
    {
        return [
            [
                'The Idea and Preparation',
                'As a software developer, having your own portfolio is a great way to showcase your work and skills, especially when starting your career. That is why, after completing my studies, I decided to start building my own portfolio website right away.',
                'I had two main goals: to create an attractive website, but also to learn as much as possible along the way. I wanted to develop a structured way of working, minimise my reliance on AI and improve my programming skills. I particularly wanted to focus on Python, as that was the language I wanted to become more proficient in at the time.',
                'Initially, things went quite well. I tried to figure out as much as possible on my own and come up with solutions before asking for help. However, I soon realised that some of my initial choices were not entirely suited to what the project eventually required.',
            ],
            [
                'From Flask to Django',
                'Initially, I did not want to use a relational database at all. My idea was to store the data in JSON files instead. However, as the project grew, I realised that this approach was becoming less suitable for the amount and structure of the data I wanted to manage.',
                'That is why I decided to switch from Flask to Django. One of Django\'s main advantages was its built-in ORM (Object-Relational Mapping). This allowed me to define models and interact with my database in a structured way without having to install an external ORM dependency.',
                'I eventually chose MySQL as my database. I had already gained some experience with it during my studies, so I did not have to learn an entirely new database system at the same time.',
            ],
            [
                'Designing and Experimenting with SVG',
                'I really enjoy designing things and then turning those designs into code. This is clearly reflected in my website, which features quite a few custom-made SVG illustrations.',
                'I built and manipulated these SVGs using JavaScript. This allowed me to do much more than simply display static images. I could control individual elements and make my designs interactive and dynamic.',
                'However, the final result did not quite turn out the way I had originally imagined. This was mainly due to the limits of my own technical knowledge. I had followed several tutorials to learn more about working with SVGs, but I could not always achieve exactly what I had envisioned.',
                'Rather than getting completely stuck, I decided to adapt my design ideas. I eventually started experimenting more with a glass-like appearance. This resulted in a different style than I had initially planned, but it also gave the website its own distinctive character.',
            ],
            [
                'The Challenges During Development',
                'The project actually started quite well. I had a clear idea, the structure was in place and my motivation was high. However, as the project progressed, I noticed that both the structure and my motivation began to decline.',
                'Parts of the code became a bit messy, and my motivation started coming and going. In particular, not being able to achieve certain designs the way I had imagined became increasingly frustrating.',
                'Still, I did not give up on the project. Despite the moments when things were not going as smoothly as I had hoped, I kept working on it. Eventually, I managed to build a fully functional portfolio website. It was not without its frustrations, but I got there in the end!',
            ],
            [
                'My First Deployment on a VPS',
                'This project was also the first time I had deployed a complete website to my own VPS. This introduced an entirely new aspect of development: configuring a production environment and making my application securely accessible online.',
                'I set up most of this part with the help of AI. I did not simply want to put something online; I wanted to make sure the server configuration was set up responsibly.',
                'Looking back, there were still a few things I could have done better. For example, the separation between the development and production configurations was not ideal. These are the kinds of things you sometimes only discover when you actually run an application on your own server. That was another valuable learning experience.',
                'The application runs on my own VPS, with Nginx acting as the web server and reverse proxy. Nginx receives incoming HTTP requests and forwards them to Gunicorn. Gunicorn then runs my Django application through the WSGI interface and returns the generated responses.',
            ],
            [
                'Experimenting with CI/CD',
                'I also wanted to gain some experience with CI/CD during this project, as it is an important part of modern software development and widely used in the industry.',
                'I therefore tried to follow this approach throughout the project. This occasionally resulted in merge conflicts, but I worked through those as well. It was a good opportunity to gain more experience with Git and working with different branches.',
                'I deliberately kept the CI/CD implementation fairly simple. I first wanted to understand what the concept actually meant and what problems it solves before adding a range of automated processes.',
                'As a first step, I integrated Ruff into my CI pipeline. Ruff is a Python tool that can be used as both a linter and a formatter. The linter checks my code for potential errors, unused imports and deviations from the configured coding style. The formatter can also automatically ensure consistent code formatting.',
                'This allowed me to automatically check whether my Python code followed the configured rules whenever changes were made. It was not yet an extensive CI/CD pipeline with automated tests and deployment, but it was a first step towards becoming familiar with this way of working.',
            ],
            [
                'Deployment and the Final Result',
                'Updating the website eventually involved running a fixed sequence of terminal commands. Looking back, I could of course have written a shell script for this, allowing me to run the entire deployment process with a single command. But at least I got to memorise a few more Linux commands along the way!',
                'Ultimately, I built a fully functional portfolio website that I designed, developed and deployed myself. The project did not always go smoothly, and the final code and structure were not entirely what I had originally envisioned.',
                'Nevertheless, I learned an enormous amount. I further developed my knowledge of Python, Flask and Django, while also gaining experience with JavaScript, SVG, MySQL, Git, CI/CD and managing my own VPS.',
                'Perhaps more importantly, I discovered just how much is involved in developing a complete application. From the initial design to the database, the code and finally making everything available online. It was a substantial project with its fair share of challenges, but one I can ultimately look back on with pride.',
            ],
        ];
    }

    /**
     * @return list<array{group: ProjectComponentGroup, name: string}>
     */
    private function portfolioV1Components(): array
    {
        $groups = [
            ProjectComponentGroup::Software->value => [
                'Python',
                'Flask',
                'Django',
                'TypeScript',
                'SVG',
                'MySQL',
                'Ruff',
                'Github Actions',
                'CI/CD',
                'Nginx',
                'Gunicorn',
                'WSGI',
                'Linux',
            ],
            ProjectComponentGroup::Hardware->value => [
                'VPS',
            ],
        ];

        return $this->groupedComponents($groups);
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function portfolioV2Chapters(): array
    {
        return [
            [
                'title' => 'Van handmatig programmeren naar AI-assisted development',
                'paragraphs' => [
                    'Tijdens de hackathon van The Dutch Laravel Foundation heb ik met verschillende developers gesproken en samengewerkt. Vrijwel allemaal gaven ze aan dat het schrijven van code met de hand steeds minder voorkomt. Een groot deel van het programmeerwerk wordt tegenwoordig uitbesteed aan AI-tools zoals Claude Code en Codex. Uiteraard wordt er nog steeds verwacht dat je zelf voldoende kennis bezit om problemen te herkennen, fouten op te lossen en waar nodig aanpassingen te maken.',
                    'Om die reden, en omdat ik het toch al van plan was, besloot ik dat dit een mooi moment was om mijn portfolio website volledig opnieuw te bouwen. Dit keer met volledige ondersteuning van Figma AI, Figma MCP en Claude Code.',
                    'De keuze voor Claude Code was vrij eenvoudig. De Figma MCP werkt hier goed mee samen en Claude Code behoort naar mijn mening tot de beste AI-tools van dit moment op het gebied van programmeren.',
                ],
            ],
            [
                'title' => 'Van bestaand ontwerp naar een nieuw design',
                'paragraphs' => [
                    'Als eerste liet ik de Figma AI Agent mijn voormalige website analyseren. Ik wilde namelijk in grote lijnen dezelfde layout en stijl behouden. Vervolgens heeft de AI daar zijn eigen draai aan gegeven.',
                    'En hier komt meteen het menselijke aspect om de hoek kijken. Hoewel naar mijn schatting zo\'n 80% van het resultaat overeenkwam met wat ik had gevraagd, was het toch niet helemaal naar mijn smaak. Ik ben behoorlijk perfectionistisch, dus dat helpt daar ook niet echt bij. Ik moest zelf nog het een en ander aanpassen aan het ontwerp.',
                    'Zo heb ik bijvoorbeeld de filteropties zelf bedacht, de groene vetgedrukte teksten toegevoegd en een extra keuzemenu ontworpen voor slechtzienden. Via dat menu kunnen bezoekers onder andere de accentkleur aanpassen. Daarnaast heb ik nog verschillende kleine aanpassingen gedaan om het ontwerp precies naar mijn smaak te krijgen.',
                ],
            ],
            [
                'title' => 'De Laravel-omgeving voorbereiden',
                'paragraphs' => [
                    'Toen het design helemaal naar wens was, ben ik begonnen met het goed opzetten van het Laravel-project. Een belangrijk onderdeel daarvan was het schrijven van guidelines en skills voor Claude Code. Daarmee kan ik duidelijk vastleggen hoe ik wil dat Claude Code binnen mijn project te werk gaat.',
                    'Een voorbeeld hiervan is de manier waarop Claude Code met de Figma MCP omgaat. Omdat ik de gratis versie gebruik en het aantal beschikbare verzoeken wil beperken, moet Claude Code eerst aan mij vragen of het de Figma MCP mag raadplegen. Zo houd ik zelf de controle over wanneer er verzoeken naar Figma worden verstuurd.',
                    'Daarnaast heb ik vanaf het begin verschillende dependencies geïnstalleerd die moeten helpen om de codekwaliteit en projectstructuur op peil te houden. Laravel Boost was daarbij al standaard aanwezig. Dit is een belangrijke toevoeging voor AI-assisted development, omdat het AI-agents toegang geeft tot Laravel-specifieke documentatie, context en hulpmiddelen.',
                    'Maar ik wilde ook een aantal aanvullende tools gebruiken om zelf de regie in handen te houden. Zo heb ik ArchTest toegevoegd om architectuurregels vast te leggen en te controleren of de code zich daaraan houdt. Met Laravel Vet kan ik wijzigingen aan Composer-dependencies controleren voordat ze worden geaccepteerd.',
                    'Ook heb ik Laravel PAO geïnstalleerd. Deze tool zet de uitvoer van verschillende PHP-tools om naar compacte JSON. Daardoor krijgt Claude Code minder overbodige terminaluitvoer te verwerken, wat het aantal benodigde tokens kan verminderen.',
                    'Verder heb ik Laravel Debugbar toegevoegd. Deze heb ik nog niet uitgebreid gebruikt, maar het leek me handig om inzicht te krijgen in wat er tijdens het uitvoeren van de applicatie gebeurt. Zo kan ik bijvoorbeeld databasequeries bekijken en controleren of deze efficiënt worden uitgevoerd.',
                    'Tot slot heb ik Rector en Larastan toegevoegd. Rector kan bepaalde code automatisch refactoren en moderniseren, terwijl Larastan mijn code analyseert om mogelijke programmeerfouten op te sporen.',
                ],
            ],
            [
                'title' => 'Samenwerken met Claude Code',
                'paragraphs' => [
                    'Tijdens het ontwikkelen laat ik Claude Code regelmatig de ingestelde controles uitvoeren om te kijken of er fouten zijn ontstaan. Wanneer er problemen worden gevonden, laat ik Claude Code deze waar mogelijk zelf oplossen.',
                    'Na iedere grotere aanpassing lees ik de uitvoer van Claude Code door. Wanneer ik nieuwe afspraken of belangrijke inzichten tegenkom, laat ik deze toevoegen aan het bestand CLAUDE.md. Op die manier blijft de documentatie van het project meegroeien en kan Claude Code bij volgende opdrachten rekening houden met eerdere beslissingen.',
                    'Op deze manier lukt het me inmiddels aardig om samen met Claude Code een website te bouwen die vrijwel één op één overeenkomt met het Figma-ontwerp.',
                ],
            ],
            [
                'title' => 'Waar AI tekortschiet',
                'paragraphs' => [
                    'Toch merk ik dat de beslissingen die Claude Code neemt niet altijd de beste zijn. Dat heeft misschien ook te maken met het model dat ik gebruik. Ik werk namelijk met Haiku 5.5, omdat dit een van de meest kostenefficiënte modellen is.',
                    'Vooral bij het maken van het uitklapbare navigatiemenu had Claude Code behoorlijk wat moeite. Ik wilde dat de navigatielinks, zoals ze nu ook daadwerkelijk staan, gecentreerd in het menu zouden worden weergegeven.',
                    'Ondanks meerdere prompts met een vrij duidelijke omschrijving lukte het Claude Code niet om te maken wat ik voor ogen had. Uiteindelijk moest ik dit gedeelte dus zelf gaan oplossen. En daar komt precies dat beetje programmeerkennis bij kijken dat je nodig blijft hebben om efficiënt met AI te kunnen werken. AI maakt nu eenmaal fouten.',
                    'Toen ik de code van het uitklapbare menu ging bekijken, kwam ik iets opvallends tegen. In plaats van alle navigatielinks in één gezamenlijke container te plaatsen, had Claude Code iedere link afzonderlijk een absolute positionering gegeven.',
                    'In mijn ogen was dat niet de juiste aanpak. Hierdoor moest ik namelijk iedere link afzonderlijk positioneren om ze netjes in het midden te krijgen. Omdat er inmiddels al behoorlijk wat code stond, heb ik ervoor gekozen om de bestaande structuur aan te passen in plaats van een grotere refactor uit te voeren.',
                    'Uiteindelijk is het menu nu precies zoals ik het voor ogen had en werkt het op alle schermformaten correct.',
                ],
            ],
            [
                'title' => 'De rol van de developer blijft belangrijk',
                'paragraphs' => [
                    'Zo zie je maar dat, ondanks dat Claude Code ontzettend krachtig en efficiënt is, er altijd een developer aan te pas blijft komen. Zeker wanneer je iets wilt bouwen dat precies overeenkomt met wat je zelf in gedachten hebt.',
                    'Dat vind ik misschien wel het moeilijkste aan werken met AI: het vertalen van je eigen gedachten naar een prompt. Hoe duidelijk je iets ook probeert te omschrijven, er blijft altijd een stukje passen en meten bij kijken. Soms begrijpt de AI je bedoeling niet helemaal, soms maakt het andere keuzes dan jij zou doen en soms moet je simpelweg zelf in de code duiken om het gewenste resultaat te bereiken.',
                    'Mijn portfolio is inmiddels vrijwel helemaal geworden zoals ik het voor ogen had. Ik ben nog van plan om meer aandacht te besteden aan de styling, extra animaties toe te voegen en verschillende onderdelen verder uit te werken.',
                    'Maar als eerste versie heeft Claude Code mij aangenaam verrast. Het is bijzonder om te zien hoeveel werk je met behulp van AI kunt verzetten, zonder dat je als developer de controle volledig uit handen hoeft te geven. Ik ben dan ook erg benieuwd hoe de toekomst van softwareontwikkeling eruit gaat zien en welke rol de samenwerking tussen developers en AI daarin gaat spelen.',
                ],
            ],
        ];
    }

    /**
     * @return list<array{title: string, paragraphs: list<string>}>
     */
    private function portfolioV2ChapterTranslations(): array
    {
        return [
            [
                'From Manual Coding to AI-Assisted Development',
                'During The Dutch Laravel Foundation hackathon, I had the opportunity to talk and work with several developers. Almost all of them mentioned that writing code manually is becoming less common. A large part of the development process is now delegated to AI tools such as Claude Code and Codex. Of course, developers are still expected to have enough knowledge to recognise problems, fix errors and make adjustments when necessary.',
                'For that reason, and because I had already been planning to do so, I decided this would be a good opportunity to rebuild my portfolio website from scratch. This time, with full support from Figma AI, Figma MCP and Claude Code.',
                'Choosing Claude Code was fairly straightforward. It works well with the Figma MCP, and in my opinion, it is one of the leading AI tools for software development at the moment.',
            ],
            [
                'From an Existing Design to a New Look',
                'I started by having the Figma AI Agent analyse my previous website. I wanted to preserve the overall layout and style, at least in broad terms. The AI then added its own interpretation to the design.',
                'This is where the human aspect immediately comes into play. Although I would estimate that around 80% of the result matched what I had requested, it still was not entirely to my liking. I am quite a perfectionist, which does not exactly make things easier. I still had to make several adjustments to the design myself.',
                'For example, I came up with the filter options myself, added the green bold text and designed an additional menu for visually impaired visitors. This menu allows visitors to change the accent colour, among other things. I also made several smaller adjustments to get the design exactly how I wanted it.',
            ],
            [
                'Preparing the Laravel Environment',
                'Once the design was exactly how I wanted it, I started setting up the Laravel project properly. An important part of this process was writing guidelines and skills for Claude Code. These allow me to clearly define how I want Claude Code to work within my project.',
                'One example is how Claude Code interacts with the Figma MCP. Since I use the free version and want to limit the number of available requests, Claude Code must ask me for permission before consulting the Figma MCP. This allows me to stay in control of when requests are sent to Figma.',
                'I also installed several dependencies from the beginning to help maintain code quality and project structure. Laravel Boost was already included by default. It is an important addition to AI-assisted development because it provides AI agents with Laravel-specific documentation, context and tools.',
                'However, I also wanted some additional tools to maintain control over the development process. I added ArchTest to define architectural rules and check whether the code follows them. Laravel Vet allows me to review changes to Composer dependencies before accepting them.',
                'I also installed Laravel PAO. This tool converts the output of various PHP tools into compact JSON. This means Claude Code has less unnecessary terminal output to process, which can help reduce token usage.',
                'I also added Laravel Debugbar. I have not used it extensively yet, but I thought it would be useful for gaining insight into what happens while the application is running. For example, I can inspect database queries and check whether they are being executed efficiently.',
                'Finally, I added Rector and Larastan. Rector can automatically refactor and modernise certain parts of the code, while Larastan analyses my code to detect potential programming errors.',
            ],
            [
                'Working Together with Claude Code',
                'Throughout development, I regularly have Claude Code run the configured checks to see whether any errors have been introduced. Whenever problems are detected, I let Claude Code fix them itself whenever possible.',
                'After every major change, I review Claude Code\'s output. Whenever I come across new guidelines or important insights, I have them added to the CLAUDE.md file. This allows the project documentation to evolve alongside the code, so Claude Code can take previous decisions into account when handling future tasks.',
                'This approach has made it possible for me to work with Claude Code to build a website that closely matches the Figma design, almost pixel for pixel.',
            ],
            [
                'Where AI Falls Short',
                'However, I have noticed that the decisions Claude Code makes are not always the best ones. This may also have something to do with the model I use. I work with Haiku 5.5 because it is one of the most cost-effective models.',
                'Claude Code had particular difficulty creating the collapsible navigation menu. I wanted the navigation links to be centred within the menu, just as they are now.',
                'Despite providing several prompts with fairly clear descriptions, Claude Code could not produce what I had in mind. Eventually, I had to solve this part myself. This is exactly where the programming knowledge you still need to work effectively with AI comes into play. AI makes mistakes, after all.',
                'When I inspected the code for the collapsible menu, I noticed something unusual. Instead of placing all the navigation links inside a single shared container, Claude Code had given each link its own absolute position.',
                'In my opinion, that was not the right approach. It meant I had to position every link individually to get them properly centred. Since quite a lot of code had already been written, I decided to adjust the existing structure rather than carry out a larger refactor.',
                'In the end, the menu now looks exactly as I intended and works correctly across all screen sizes.',
            ],
            [
                'The Developer Still Plays an Important Role',
                'This shows that, even though Claude Code is incredibly powerful and efficient, a developer is still needed. Especially when you want to build something that matches exactly what you have in mind.',
                'Perhaps the most difficult part of working with AI is translating your own thoughts into a prompt. No matter how clearly you try to describe something, there is always some trial and error involved. Sometimes the AI does not fully understand what you mean, sometimes it makes different choices than you would, and sometimes you simply have to dive into the code yourself to achieve the desired result.',
                'My portfolio is now almost exactly how I envisioned it. I still plan to spend more time refining the styling, adding extra animations and further developing various parts of the website.',
                'However, Claude Code has pleasantly surprised me as a first version. It is remarkable how much work you can accomplish with the help of AI without having to give up control as a developer. I am very curious to see what the future of software development will look like and what role the collaboration between developers and AI will play in it.',
            ],
        ];
    }

    private function portfolioV2Components(): array
    {
        $groups = [
            ProjectComponentGroup::Software->value => [
                'PHP',
                'Laravel',
                'Figma AI',
                'Figma MCP',
                'Claude Code',
                'Haiku 5.5',
                'Laravel Boost',
                'ArchTest',
                'Laravel Vet',
                'Laravel PAO',
                'Laravel Debugbar',
                'Rector',
                'Larastan',
                'JSON',
                'MCP',
                'Git',
            ],
        ];

        return $this->groupedComponents($groups);
    }
}
