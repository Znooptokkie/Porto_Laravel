<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "Zinra".
 *
 * @return array<string, mixed>
 */
return [
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
    'types' => ['Automatisering', 'Webdevelopment'],
    'cardTechnologies' => ['PHP', 'JavaScript', 'Electron', 'AI', 'Decission Tree', 'Bag of Words', 'SMTP'],
    'detailTechnologies' => ['PHP', 'JavaScript', 'Electron', 'AI', 'Decission Tree', 'Bag of Words', 'SMTP'],
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
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
        ProjectComponentGroup::Protocol->value => ['SMTP (Simple Mail Transfer Protocol)'],
        ProjectComponentGroup::Software->value => ['Bag of Words', 'Beslisboom', 'PHP', 'JavaScript', 'Electron'],
    ],
    'contributors' => [
        ['name' => 'A. Oomen', 'role' => 'Back-end Developer / Scrum Master', 'url' => 'https://github.com/Znooptokkie'],
        ['name' => 'R. van Putten', 'role' => 'Front-end Developer / Product Owner', 'url' => 'https://github.com/SanzoVP'],
        ['name' => 'B. Diker', 'role' => 'Front-end Developer', 'url' => 'https://github.com/bdiker61'],
        ['name' => 'M. Cifci', 'role' => 'Back-end Developer', 'url' => 'https://github.com/mohammedcifci'],
    ],
    'imageAlts' => [
        'zinra_ik_bij_BZK.webp' => ['nl' => 'Mijn taak was om de gerealiseerde projecten kort toe te lichten aan de aanwezigen bij het ministerie van BZK', 'en' => 'My task was to briefly present the completed projects to attendees at the Ministry of the Interior and Kingdom Relations'],
        'zinra_app.webp' => ['nl' => 'De virtuele assistent op de website - gebruikers worden stap voor stap door een reeks vragen geleid', 'en' => 'The virtual assistant on the website - guiding users step by step through a series of questions'],
        'zinra_home.webp' => ['nl' => 'Zinra aan het werk in de Outlook-mailbox - de virtuele assistent helpt bij het verwerken van binnenkomende e-mails', 'en' => 'Zinra at work in the Outlook inbox - the virtual assistant helps process incoming emails'],
        'zinra_mail.webp' => ['nl' => 'Het herkenbare Zinra-pictogram in Outlook - de toegangspoort tot de virtuele assistent', 'en' => 'The recognisable Zinra icon in Outlook - the gateway to the virtual assistant'],
        'zinra_unimportant.webp' => ['nl' => 'Zinra heeft zijn oordeel gevormd - deze e-mail is na analyse als onbelangrijk gemarkeerd', 'en' => 'Zinra has made its decision - after analysis, this email has been marked as unimportant'],
        'zinra_website_manual.webp' => ['nl' => 'Het handmatig doorzoeken van verschillende documenten - precies het tijdrovende werk dat Zinra helpt automatiseren', 'en' => 'Manually searching through various documents - exactly the time-consuming task Zinra helps automate'],
    ],
    'firstPhoto' => 'zinra_ik_bij_BZK.webp',
];
