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
            'battlebot_huge_mess.webp' => ['nl' => 'Waar alle kabels en componenten samenkomen - georganiseerde chaos in volle glorie', 'en' => 'Where all the wires and components come together: organized chaos in all its glory'],
            'battlebot_mcp_connection.webp' => ['nl' => 'De MCP2515-modules die de CAN-buscommunicatie tussen de verschillende onderdelen mogelijk maken', 'en' => 'The MCP2515 modules enabling CAN bus communication between the different components'],
            'battlebot_screen_picture.webp' => ['nl' => 'Een uniek perspectief - een selfie gemaakt door de camera van de Battlebot', 'en' => 'A unique perspective: a selfie captured by the Battlebot’s own camera'],
            'battlebot_selfmade_module_topview.webp' => ['nl' => 'Een bovenaanzicht van de zelfontworpen en gebouwde elektronische module', 'en' => 'A top-down view of the custom-designed and built electronic module'],
            'battlebot_selfmade_module.webp' => ['nl' => 'De zelfgebouwde elektronische module, netjes op zijn plek in de behuizing', 'en' => 'The custom-built electronic module, neatly fitted inside its enclosure'],
            'battlebot_sideview.webp' => ['nl' => 'Een kijkje vanaf de zijkant - de Battlebot in volle glorie', 'en' => 'A side view of the Battlebot in all its glory'],
            'battlebot_view_top.webp' => ['nl' => 'De Battlebot van bovenaf, gespot in zijn natuurlijke habitat', 'en' => 'The Battlebot from above, spotted in its natural habitat'],
            'battlebot_controller.webp' => ['nl' => 'Tijd voor een kleine aanpassing - de controller opengemaakt om de joysticks helemaal naar eigen smaak af te stellen', 'en' => 'Time for a little modification - opening up the controller to customize the joysticks to my liking'],
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
            'zinra_mail.webp' => ['nl' => 'Het herkenbare Zinra-pictogram in Outlook - de toegangspoort tot de virtuele assistent', 'en' => 'The recognizable Zinra icon in Outlook - the gateway to the virtual assistant'],
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
        ],
        'dungeon-crawler' => [
            'crawler_battleview.webp' => ['nl' => 'Het Figma-ontwerp van de gevechtsfase - zo ziet een confrontatie met vijanden er straks uit', 'en' => 'The Figma design of the battle phase - a preview of what encounters with enemies will look like'],
            'crawler_dungeonview.webp' => ['nl' => 'Het Figma-ontwerp van de dungeon - een eerste indruk van de omgeving waarin spelers op avontuur gaan', 'en' => 'The Figma design of the dungeon - an early look at the environment where players embark on their adventure'],
            'crawler_enemy.webp' => ['nl' => 'Het daadwerkelijke spel in actie - een vijand verschijnt in de kamer, voorlopig nog met een zelfgemaakte placeholder', 'en' => 'The actual game in action - an enemy appears in the room, currently using a quickly created placeholder'],
            'crawler_homescreen.webp' => ['nl' => 'Het startscherm van de website - de eerste kennismaking met de wereld van Dungeon Crawler', 'en' => 'The website home screen - the first introduction to the world of Dungeon Crawler'],
            'crawler_open_chest.webp' => ['nl' => 'Een geopende schatkist in de dungeon - tijd om te ontdekken welke buit erin verborgen zit', 'en' => 'An opened treasure chest in the dungeon - time to discover what loot is hidden inside'],
            'crawler_roomview.webp' => ['nl' => 'De eerste kamer van Dungeon Level 1 - hier begint het avontuur voor iedere speler', 'en' => 'The first room of Dungeon Level 1 - where every player’s adventure begins'],
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
                'summary' => 'De eerste versie van mijn portfolio website had ik gemaakt in *Django (Python)*. Die beschouwde ik vooral als een leer-project. Het begon gestructureerd, maar eindigde toch wel in een aardige bende. Mede om die reden, en omdat ik met *Claude Code* een volledige iets wilde bouwen, heb ik besloten om mijn portfolio opnieuw te bouwen *Laravel (PHP)*. Dit keer met ondersteuning van *Figma-MCP* & *Claude Code*.',
                'subtitle' => 'Een website waar ik trots op kan zijn.',
                'story_lead' => 'My Portfolio: Een nieuw design, een nieuwe manier om mijzelf te introduceren.',
                'media_tagline' => '{ software }',
                'story_heading' => 'Een nieuw',
                'story_heading_accent' => 'begin',
                'story_aside' => '// stap voor stap',
                'repository_url' => 'https://github.com/Znooptokkie/Porto_Laravel',
                'favorite_rank' => 6,
                'status' => ProjectStatus::InConstructie,
                'organization' => 'Thuis',
                'department' => 'Bureau',
                'types' => ['Webdevelopment'],
                'cardTechnologies' => ['PHP', 'Laravel', 'TypeScript', 'Claude Code', 'Figma-MCP'],
                'detailTechnologies' => ['PHP', 'Laravel', 'TypeScript', 'Claude Code', 'Figma-MCP'],
                'links' => [], // invullen, zie syncLinks() voor het formaat
                'chapters' => [], // invullen
                'components' => [], // invullen
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Designer', 'url' => 'https://github.com/Znooptokkie'],
                ],
            ],
            [
                'slug' => 'smart-garden-desktop',
                'translations' => ['en' => [
                    'media_tagline' => '{ sensors × dashboard }',
                    'story_lead' => 'Smart Garden: live sensor data and an automatic water pump, in one dashboard.',
                    'title' => 'Smart Garden (desktop)',
                    'category' => 'IOT / EMBEDDED SYSTEMS',
                    'intro_label' => 'IOT / EMBEDDED SYSTEMS',
                    'summary' => 'Smart Garden is a collaboration between *CIV Smart Technology*, *The Field* in Leiden and *mboRijnland*, in which a dashboard was built in *Flask* to monitor and control a vertical garden, including live sensor data and an automatically controlled water pump via a *Raspberry Pi 4*.',
                    'subtitle' => 'A dashboard to monitor and control a vertical garden.',
                    'story_heading' => 'From assignment to',
                    'story_heading_accent' => 'delivery',
                    'story_aside' => '// from assignment to delivery',
                    'organization' => 'CIV Smart Technology, The Field & mboRijnland',
                    'department' => '',
                ]],
                'title' => 'Smart Garden (desktop)',
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
                'repository_url' => 'https://github.com/Znooptokkie/GoodGarden',
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
                        'url' => 'https://',
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
                        'url' => 'https://',
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
                'components' => $this->smartGardenDesktopComponents(),
                'contributors' => [
                    ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Projectleider / Scrum Master', 'url' => 'https://github.com/Znooptokkie'],
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
                    'title' => 'Smart Garden (mobile)',
                    'category' => 'MOBILE DEVELOPMENT',
                    'intro_label' => 'MOBILE DEVELOPMENT / FINAL EXAM',
                    'summary' => 'For my *Mobile Development* final exam I turned the Smart Garden (desktop) project into a full mobile app in *React Native*, with its own *Flask API*, user roles and a connection to a *Raspberry Pi 4*.',
                    'subtitle' => 'Smart Garden as a full mobile app.',
                    'story_heading' => 'From desktop to',
                    'story_heading_accent' => 'mobile',
                    'story_aside' => '// from dashboard to app',
                    'organization' => '',
                    'department' => '',
                ]],
                'title' => 'Smart Garden (mobiel)',
                'title_accent' => null,
                'category' => 'MOBILE DEVELOPMENT',
                'intro_label' => 'MOBILE DEVELOPMENT / EINDEXAMEN',
                'started_year' => 2025,
                'ended_year' => null,
                'summary' => 'Voor mijn eindexamen *Mobile Development* heb ik het project Smart Garden (desktop) omgezet naar een volwaardige mobiele applicatie in *React Native*, met eigen *Flask-API*, gebruikersrollen en koppeling met een *Raspberry Pi 4*.',
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
                'links' => [], // invullen, zie syncLinks() voor het formaat
                'chapters' => $this->portfolioV1Chapters(),
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
                    'department' => 'Hackaton',
                ]],
                'title' => 'Dungeon Crawler',
                'title_accent' => null,
                'category' => 'WEBDEVELOPMENT',
                'intro_label' => 'WEBDEVELOPMENT / HACKATHON',
                'started_year' => 2026,
                'ended_year' => null,
                'summary' => 'Ik deed mee aan de *hackaton* van de *Dutch Laravel Foundation*. Omdat het een tijdje geleden was dat ik *Laravel* had gebruikt als *framework*, besloot ik om een kleine dungeon crawler te maken. Het project staat op *onvoltooid*, maar ik sluit niet uit om hem alsnog af te maken.',
                'subtitle' => 'Een kleine dungeon crawler, gebouwd tijdens een hackathon.',
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
                'links' => [], // invullen, zie syncLinks() voor het formaat
                'chapters' => [],
                'components' => [],
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
                'title' => 'Plymouth Uitwisselingsbegeleiding',
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
                'chapters' => [],
                'components' => [],
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
}
