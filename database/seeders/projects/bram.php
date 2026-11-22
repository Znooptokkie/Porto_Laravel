<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "BRAM".
 *
 * @return array<string, mixed>
 */
return [
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
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
        ProjectComponentGroup::Software->value => ['Android SDK', 'Gradle'],
        ProjectComponentGroup::Communication->value => ['XML', 'API'],
    ],
    'contributors' => [
        ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Scrum Master', 'url' => 'https://github.com/Znooptokkie'],
        ['name' => 'M. de Graaf', 'role' => 'Full-stack Developer / Product Owner', 'url' => 'https://github.com/Matthijs-de-Graaf'],
        ['name' => 'R. van Putten', 'role' => 'Full-stack Developer', 'url' => 'https://github.com/SanzoVP'],
        ['name' => 'B. Diker', 'role' => 'Full-stack Developer', 'url' => 'https://github.com/bdiker61'],
    ],
    'imageAlts' => [
        'bram_contact.webp' => ['nl' => 'Een overzicht van alle contacten binnen BRAM', 'en' => 'An overview of all contacts in BRAM'],
        'bram_foto.webp' => ['nl' => 'Een kijkje in de fotogalerij, waar alle herinneringen samenkomen', 'en' => 'A look inside the photo gallery, where all the memories come together'],
        'bram_home.webp' => ['nl' => 'Het startscherm van BRAM, het centrale punt voor de bediening van je slimme huis', 'en' => 'The BRAM home screen, the central hub for controlling your smart home'],
        'bram_lichten.webp' => ['nl' => 'De lichtbediening van BRAM, waarmee je de verlichting in huis naar wens kunt regelen', 'en' => 'BRAM’s lighting controls, letting you adjust the lights throughout your home'],
        'bram_loadingscreen.webp' => ['nl' => 'Een eerste kennismaking met BRAM - het laadscherm dat verschijnt bij het opstarten van de applicatie', 'en' => 'A first introduction to BRAM - the loading screen displayed when the application starts'],
        'bram_verwarming.webp' => ['nl' => 'De verwarmingsbediening van BRAM, waarmee je de temperatuur in huis kunt regelen', 'en' => 'BRAM’s heating controls, allowing you to adjust the temperature throughout your home'],
    ],
];
