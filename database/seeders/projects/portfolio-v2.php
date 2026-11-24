<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "Portfolio V2".
 *
 * @return array<string, mixed>
 */
return [
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
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
        ProjectComponentGroup::Software->value => [
            'PHP',
            'Laravel',
            'Figma AI',
            'Figma MCP',
            'Claude Code',
            'Haiku 5.5',
            'Prism.js',
        ],
        ProjectComponentGroup::Protocol->value => [
            'MCP',
        ],
        ProjectComponentGroup::Communication->value => [
            'JSON',
        ],
    ],
    'contributors' => [
        ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Designer', 'url' => 'https://github.com/Znooptokkie'],
    ],
    'imageAlts' => [
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
        'porto_2_education_left.webp' => [
            'nl' => 'De pagina De Opleidingen, met mijn MBO 4-opleiding Software Development en de bijbehorende gegevens. Dit is de linkerkant van de afbeelding.',
            'en' => 'The Education page, showing my MBO 4 Software Development programme and its details. This is the left side of the image.',
        ],
        'porto_2_education_right.webp' => [
            'nl' => 'De pagina De Opleidingen, met mijn MBO 4-opleiding Software Development en de bijbehorende gegevens. Dit is de rechterkant van de afbeelding.',
            'en' => 'The Education page, showing my MBO 4 Software Development programme and its details. This is the right side of the image.',
        ],
        'porto_2_homepage_head_left.webp' => [
            'nl' => 'De introductiesectie van de homepage, met mijn naam, functie en een korte introductietekst. Dit is de linkerkant van de afbeelding.',
            'en' => 'The introduction section of the homepage, with my name, role and a short introduction. This is the left side of the image.',
        ],
        'porto_2_homepage_head_right.webp' => [
            'nl' => 'De introductiesectie van de homepage, met mijn naam, functie en een korte introductietekst. Dit is de rechterkant van de afbeelding.',
            'en' => 'The introduction section of the homepage, with my name, role and a short introduction. This is the right side of the image.',
        ],
        'porto_2_homepage_light_mode_left.webp' => [
            'nl' => 'De homepage in de lichte modus, met oranje accenten op een lichte achtergrond. Dit is de linkerkant van de afbeelding.',
            'en' => 'The homepage in light mode, with orange accents on a light background. This is the left side of the image.',
        ],
        'porto_2_homepage_light_mode_right.webp' => [
            'nl' => 'De homepage in de lichte modus, met oranje accenten op een lichte achtergrond. Dit is de rechterkant van de afbeelding.',
            'en' => 'The homepage in light mode, with orange accents on a light background. This is the right side of the image.',
        ],
        'porto_2_homepage_skills_left.webp' => [
            'nl' => 'De sectie Mijn Programmeer Kennis, met mijn programmeertalen, frameworks en AI-tools. Dit is de linkerkant van de afbeelding.',
            'en' => 'The Programming Skills section, showing my programming languages, frameworks and AI tools. This is the left side of the image.',
        ],
        'porto_2_homepage_skills_right.webp' => [
            'nl' => 'De sectie Mijn Programmeer Kennis, met mijn programmeertalen, frameworks en AI-tools. Dit is de rechterkant van de afbeelding.',
            'en' => 'The Programming Skills section, showing my programming languages, frameworks and AI tools. This is the right side of the image.',
        ],
        'porto_2_projects_left.webp' => [
            'nl' => 'De projectenpagina met een overzicht van alle projecten en de filters om ze te sorteren. Dit is de linkerkant van de afbeelding.',
            'en' => 'The projects page with an overview of all projects and the filters to sort them. This is the left side of the image.',
        ],
        'porto_2_projects_right.webp' => [
            'nl' => 'De projectenpagina met een overzicht van alle projecten en de filters om ze te sorteren. Dit is de rechterkant van de afbeelding.',
            'en' => 'The projects page with an overview of all projects and the filters to sort them. This is the right side of the image.',
        ],
    ],
    'imageMobileFiles' => [
        'porto_2_education.webp' => ['porto_2_education_left.webp', 'porto_2_education_right.webp'],
        'porto_2_homepage_head.webp' => ['porto_2_homepage_head_left.webp', 'porto_2_homepage_head_right.webp'],
        'porto_2_homepage_light_mode.webp' => ['porto_2_homepage_light_mode_left.webp', 'porto_2_homepage_light_mode_right.webp'],
        'porto_2_homepage_skills.webp' => ['porto_2_homepage_skills_left.webp', 'porto_2_homepage_skills_right.webp'],
        'porto_2_projects.webp' => ['porto_2_projects_left.webp', 'porto_2_projects_right.webp'],
    ],
    'firstPhoto' => 'porto_2_homepage_head.webp',
];
