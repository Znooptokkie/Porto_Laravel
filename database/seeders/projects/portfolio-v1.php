<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "Portfolio V1".
 *
 * @return array<string, mixed>
 */
return [
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
    'cardTechnologies' => ['Python', 'Django', 'JavaScript', 'SVG', 'CI/CD'],
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
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
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
            'Linux',
            'VPS',
            'Prism.js',
        ],
        ProjectComponentGroup::Protocol->value => [
            'WSGI',
        ],
    ],
    'contributors' => [
        ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Designer', 'url' => 'https://github.com/Znooptokkie'],
    ],
    'imageAlts' => [
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
    'firstPhoto' => 'porto_1_homepage_head.webp',
];
