<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "Dungeon Crawler".
 *
 * @return array<string, mixed>
 */
return [
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
    'cardTechnologies' => ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'SVG'],
    'detailTechnologies' => ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'SVG'],
    'links' => [
        [
            'description' => [
                'nl' => 'Deze tutorial heb ik aan het begin van het project gevolgd om mijn kennis van Laravel op te frissen.',
                'en' => 'I followed this tutorial at the start of the project to refresh my knowledge of Laravel.',
            ],
            'url' => 'https://laravel.com/learn/getting-started-with-laravel',
        ],
    ],
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
        ProjectComponentGroup::Software->value => [
            'PHP',
            'Laravel',
            'Vue.js',
            'JavaScript',
            'MySQL',
        ],
    ],
    'contributors' => [['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Designer', 'url' => 'https://github.com/Znooptokkie']],
    'imageAlts' => [
        'crawler_battleview.webp' => ['nl' => 'Het Figma-ontwerp van de gevechtsfase - zo ziet een confrontatie met vijanden er straks uit', 'en' => 'The Figma design of the battle phase - a preview of what encounters with enemies will look like'],
        'crawler_dungeonview.webp' => ['nl' => 'Het Figma-ontwerp van de dungeon - een eerste indruk van de omgeving waarin spelers op avontuur gaan', 'en' => 'The Figma design of the dungeon - an early look at the environment where players embark on their adventure'],
        'crawler_enemy.webp' => ['nl' => 'Het daadwerkelijke spel in actie - een vijand verschijnt in de kamer, voorlopig nog met een zelfgemaakte placeholder', 'en' => 'The actual game in action - an enemy appears in the room, currently using a quickly created placeholder'],
        'crawler_homescreen.webp' => ['nl' => 'Het startscherm van de website - de eerste kennismaking met de wereld van Dungeon Crawler', 'en' => 'The website home screen - the first introduction to the world of Dungeon Crawler'],
        'crawler_open_chest.webp' => ['nl' => 'Een geopende schatkist in de dungeon - tijd om te ontdekken welke buit erin verborgen zit', 'en' => 'An opened treasure chest in the dungeon - time to discover what loot is hidden inside'],
        'crawler_roomview.webp' => ['nl' => 'De eerste kamer van Dungeon Level 1 - hier begint het avontuur voor iedere speler', 'en' => 'The first room of Dungeon Level 1 - where every player’s adventure begins'],
    ],
];
