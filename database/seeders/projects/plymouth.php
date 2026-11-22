<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "City College Plymouth Studenten Begeleiding".
 *
 * @return array<string, mixed>
 */
return [
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
    'types' => ['Robotica'],
    'cardTechnologies' => ['Micro Bits', 'MicroPython'],
    'detailTechnologies' => ['Micro Bits', 'MicroPython'],
    'links' => [],
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
        ProjectComponentGroup::Hardware->value => [
            'BBC micro:bit V2',
            'DFRobot Maqueen V2',
            'DFRobot micro:bit Gamepad',
        ],
        ProjectComponentGroup::Software->value => [
            'Python',
            'MicroPython',
        ],
        ProjectComponentGroup::Protocol->value => [
            'I2C',
        ],
        ProjectComponentGroup::Sensor->value => [
            'Maqueen Line Sensors',
        ],
    ],
    'contributors' => [
        ['name' => 'A. Oomen', 'role' => 'Exchange Lead', 'url' => 'https://github.com/Znooptokkie'],
        ['name' => 'M. de Graaf', 'role' => 'Exchange Lead', 'url' => 'https://github.com/Matthijs-de-Graaf'],
    ],
    'imageAlts' => [
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
    'firstPhoto' => 'plymouth_groepsfoto.webp',
];
