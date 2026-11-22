<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "Automatische Trapverlichting".
 *
 * @return array<string, mixed>
 */
return [
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
    'cardTechnologies' => ['MicroPython', 'Python', 'HC-SR505', 'Pico 2', 'KiCad', 'N-Mosfet'],
    'detailTechnologies' => ['Raspberry Pi Pico 2', 'N-Mosfet', 'MicroPython', 'Python', 'KiCad', 'HC-SR505'],
    'links' => [
        [
            'description' => ['nl' => 'Op Reddit vond ik een post die hetzelfde probleem met de spanning beschrijft.', 'en' => 'On Reddit I found a post describing the same voltage-related problem.'], 'url' => 'https://www.reddit.com/r/esp32/comments/w77tgm/esp32cam_connexion_to_a_pir_motion_sensor_loop/',
        ],
        [
            'description' => ['nl' => 'Deze tutorial heb ik gevolgd om de PCB te ontwerpen.', 'en' => 'This is the tutorial I followed for designing the PCB.'], 'url' => 'https://www.youtube.com/playlist?list=PLUOaI24LpvQPls1Ru_qECJrENwzD7XImd',
        ],
    ],
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
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
            'Thonny',
            'MicroPython',
        ],
        ProjectComponentGroup::Sensor->value => [
            'HC-SR505 PIR Sensor',
        ],
    ],
    'contributors' => [
        ['name' => 'A. Oomen', 'role' => 'Developer / Hardware Engineer', 'url' => 'https://github.com/Znooptokkie'],
    ],
    'imageAlts' => [
        'trap_all_mosfets_test.webp' => ['nl' => 'Alle MOSFETs op een breadboard - tijd om te controleren of ze doen wat ze moeten doen', 'en' => 'All MOSFETs mounted on a breadboard - time to check if they do what they are supposed to do'],
        'trap_both_sensors_test.webp' => ['nl' => 'Beide sensoren tegelijk aan het werk - een test om te ontdekken of ze elkaar niet in de weg zitten', 'en' => 'Both sensors working side by side - a test to see if they interfere with each other'],
        'trap_pcb_soldered.webp' => ['nl' => 'Het eindresultaat - de volledig gesoldeerde PCB met alle componenten netjes op hun plek', 'en' => 'The finished result - the fully soldered PCB with all components neatly in place'],
        'trap_pcb_soldering_pieces.webp' => ['nl' => 'Alle elektronische onderdelen klaargelegd - tijd om ze een voor een op de PCB te solderen', 'en' => 'All electronic components laid out and ready - time to solder them onto the PCB one by one'],
        'trap_single_mosfet_test.webp' => ['nl' => 'Eerst klein beginnen - een enkele MOSFET testen voordat de rest erbij komt', 'en' => 'Starting small - testing a single MOSFET before adding the rest'],
        'trap_single_sensor_test.webp' => ['nl' => 'Eerst één sensor aan het werk zetten en daarna de tweede toevoegen', 'en' => 'Getting one sensor up and running first, before bringing in the second'],
        'trap_transformer_test.webp' => ['nl' => 'De voeding van het systeem - deze transformator levert de benodigde 24 volt', 'en' => 'The system’s power supply - this transformer provides the required 24 volts'],
        'trap_whole_setup_test.webp' => ['nl' => 'Alles aangesloten en klaar voor de grote test - werkt het complete systeem zoals bedoeld?', 'en' => 'Everything connected and ready for the big test - does the complete system work as intended?'],
        'mosfet_pico_3d.webp' => ['nl' => 'Het PCB-ontwerp in 3D weergegeven in KiCad', 'en' => 'The PCB design rendered in 3D in KiCad'],
        'mosfet_pico_pcb.webp' => ['nl' => 'Het PCB-schema met alle onderling verbonden componenten', 'en' => 'The PCB schematic showing all interconnected components'],
        'mosfet_pico_schema.webp' => ['nl' => 'Het elektrische schema, ontworpen in KiCad', 'en' => 'The electrical schematic designed in KiCad'],
    ],
    'firstPhoto' => 'mosfet_pico_3d.webp',
];
