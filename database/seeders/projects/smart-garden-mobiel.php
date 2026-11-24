<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "Smart Garden - Mobiel".
 *
 * @return array<string, mixed>
 */
return [
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
    'cardTechnologies' => ['JavaScript', 'React Native', 'Flask API', 'Termux'],
    'detailTechnologies' => ['JavaScript', 'React Native', 'Flask API', 'Termux', 'SCP', 'Raspberry Pi 4'],
    'links' => [], // invullen, zie syncLinks() voor het formaat
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
        ProjectComponentGroup::Hardware->value => ['Raspberry Pi 4'],
        ProjectComponentGroup::Sensor->value => ['Soil Moisture Sensor'],
        ProjectComponentGroup::Software->value => ['AsyncStorage', 'Termux', 'Expo', 'JavaScript', 'React Native'],
        ProjectComponentGroup::Protocol->value => ['SSH (Secure Shell)', 'SCP (Secure Copy Protocol)', 'HTTP', 'CORS (Cross-Origin Resource Sharing)'],
        ProjectComponentGroup::Communication->value => ['JSON', 'Flask API', 'Perenual API', 'Weer API'],
    ],
    'contributors' => [
        ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Designer', 'url' => 'https://github.com/Znooptokkie'],
    ],
    'imageAlts' => [
        'gg_mob_all_plants.webp' => ['nl' => 'Een compleet overzicht van alle planten die momenteel in de kas groeien', 'en' => 'A complete overview of all the plants currently growing in the greenhouse'],
        'gg_mob_homepage.webp' => ['nl' => 'Het startscherm van de Smart Garden-app - alle belangrijke onderdelen binnen handbereik', 'en' => 'The Smart Garden app home screen - all the essential features right at your fingertips'],
        'gg_mob_login.webp' => ['nl' => 'Het inlogscherm waarmee gebruikers toegang krijgen tot de Smart Garden-app', 'en' => 'The login screen where users can access the Smart Garden app'],
        'gg_mob_log.webp' => ['nl' => 'Het logboek waarin foutmeldingen en andere gebeurtenissen worden bijgehouden', 'en' => 'The logbook keeping track of errors and other application events'],
        'gg_mob_plant_info.webp' => ['nl' => 'Een kijkje bij alle informatie over een specifieke plant', 'en' => 'A closer look at all the information about a specific plant'],
        'gg_mob_pump.webp' => ['nl' => 'Een overzicht van alle pompen - met de mogelijkheid om ze afzonderlijk in of uit te schakelen', 'en' => 'An overview of all pumps - with the ability to switch each one on or off'],
        'gg_mob_sensors.webp' => ['nl' => 'Een overzicht van alle sensoren die in de kas de omstandigheden in de gaten houden', 'en' => 'An overview of all sensors monitoring conditions inside the greenhouse'],
        'gg_mob_settings.webp' => ['nl' => 'De instellingenpagina waar gebruikers hun persoonlijke voorkeuren en gegevens kunnen aanpassen', 'en' => 'The settings page where users can adjust their personal preferences and information'],
        'gg_mob_homepage_top.webp' => ['nl' => 'Het startscherm van de Smart Garden-app - alle belangrijke onderdelen binnen handbereik. Dit is het bovenste deel van de afbeelding.', 'en' => 'The Smart Garden app home screen - all the essential features right at your fingertips. This is the top part of the image.'],
        'gg_mob_homepage_bottom.webp' => ['nl' => 'Het startscherm van de Smart Garden-app - alle belangrijke onderdelen binnen handbereik. Dit is het onderste deel van de afbeelding.', 'en' => 'The Smart Garden app home screen - all the essential features right at your fingertips. This is the bottom part of the image.'],
    ],
    'imageMobileFiles' => [
        'gg_mob_homepage.webp' => ['gg_mob_homepage_top.webp', 'gg_mob_homepage_bottom.webp'],
    ],
    'firstPhoto' => 'gg_mob_login.webp',
];
