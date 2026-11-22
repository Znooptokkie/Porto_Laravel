<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "Smart Garden - Desktop".
 *
 * @return array<string, mixed>
 */
return [
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
    'organization' => 'mboRijnland',
    'department' => 'CIV Smart Technology, The Field & Haagsche Hogeschool',
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
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
        ProjectComponentGroup::Hardware->value => ['Raspberry Pi 4'],
        ProjectComponentGroup::Sensor->value => ['Capacitive Soil Moisture Sensor'],
        ProjectComponentGroup::Software->value => ['ChartJS', 'Flask', 'Python', 'Electron'],
        ProjectComponentGroup::Protocol->value => ['SSH (Secure Shell)', 'MQTT (Message Queuing Telemetry Transport)'],
        ProjectComponentGroup::Communication->value => ['JSON', 'API', 'Perenual API', 'Weerlive API'],
    ],
    'contributors' => [
        ['name' => 'A. Oomen', 'role' => 'Full-stack Developer / Project Leader / Scrum Master', 'url' => 'https://github.com/Znooptokkie'],
        ['name' => 'R. van Putten', 'role' => 'Front-end Developer / Product Owner', 'url' => 'https://github.com/SanzoVP'],
        ['name' => 'B. Diker', 'role' => 'Back-end Developer', 'url' => 'https://github.com/bdiker61'],
        ['name' => 'M. Cifci', 'role' => 'Back-end Developer', 'url' => 'https://github.com/mohammedcifci'],
        ['name' => 'J. Doekhi', 'role' => 'Front-end Developer', 'url' => 'https://github.com/6027529'],
        ['name' => 'M. Heins', 'role' => 'Embedded Systems Specialist', 'url' => 'https://github.com/martijnhe'],
    ],
    'imageAlts' => [
        'gg_ik_bij_hh.webp' => ['nl' => 'Ik als challengegever tijdens het presenteren voor studenten aan De Haagse Hogeschool', 'en' => 'Me presenting a challenge to students at The Hague University of Applied Sciences'],
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
    'firstPhoto' => 'gg_ik_bij_hh.webp',
];
