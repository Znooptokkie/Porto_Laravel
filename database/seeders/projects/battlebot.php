<?php

use App\Enums\ProjectComponentGroup;
use App\Enums\ProjectStatus;

/**
 * Seed data for the project "Battlebot".
 *
 * @return array<string, mixed>
 */
return [
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
    'types' => ['Robotica', 'Embedded Systems'],
    'cardTechnologies' => ['Python', 'MicroPython', 'CAN-bus', 'AI'],
    'detailTechnologies' => ['Raspberry Pi 5', 'Pico 2', 'MicroPython', 'Python', 'CAN-bus', 'Hailo-8'],
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
    'chapters' => [
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
    ],
    'chapterTranslations' => [
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
    ],
    'components' => [
        ProjectComponentGroup::Hardware->value => ['Raspberry Pi 5', 'Raspberry Pi Pico 2', 'Hailo-HAT', 'UBEC (Universal battery eliminator circuit)', 'ESC (Electronic Speed Controller)', 'MCP2515-module', 'DC-Converter', 'PWM (Pulse-width modulation)'],
        ProjectComponentGroup::Software->value => ['Bitwise Operators', 'Thonny', 'YOLOv11', 'Crontab'],
        ProjectComponentGroup::Protocol->value => ['UART (Universal asynchronous receiver-transmitter)', 'CAN (Controller area network)', 'I-Bus', 'SPI (Serial Peripheral Interface)', 'CSI (Camera Serial Interface)', 'SSH (Secure Shell)'],
        ProjectComponentGroup::Sensor->value => ['HC-SR04', 'FC-03 IR Optical Encoder'],
    ],
    'contributors' => [
        ['name' => 'A. Oomen', 'role' => 'Embedded Software Engineer', 'url' => 'https://github.com/Znooptokkie'],
        ['name' => 'M. de Graaf', 'role' => 'AI Software Engineer', 'url' => 'https://github.com/Matthijs-de-Graaf'],
    ],
    'imageAlts' => [
        'battlebot_all_components_blueprint.webp' => ['nl' => 'Het complete communicatieschema - alle onderdelen van de Battlebot met elkaar verbonden', 'en' => 'The complete communication blueprint, connecting all components of the Battlebot'],
        'battlebot_circuit_blueprint.webp' => ['nl' => 'Het elektronische schema waarin alle verbindingen en circuits samenkomen', 'en' => 'The electronic circuit blueprint, bringing all connections and circuits together'],
        'battlebot_frontview.webp' => ['nl' => 'Een kijkje aan de voorkant van de Battlebot, met het brein buiten zijn behuizing', 'en' => 'A front view of the Battlebot, with its brain outside the enclosure'],
        'battlebot_huge_mess_topview.webp' => ['nl' => 'Een indrukwekkende wirwar van kabels en componenten, van bovenaf bekeken', 'en' => 'An impressive tangle of wires and components, viewed from above'],
        'battlebot_huge_mess.webp' => ['nl' => 'Waar alle kabels en componenten samenkomen - georganiseerde chaos in volle glorie', 'en' => 'Where all the wires and components come together: organised chaos in all its glory'],
        'battlebot_mcp_connection.webp' => ['nl' => 'De MCP2515-modules die de CAN-buscommunicatie tussen de verschillende onderdelen mogelijk maken', 'en' => 'The MCP2515 modules enabling CAN bus communication between the different components'],
        'battlebot_screen_picture.webp' => ['nl' => 'Een uniek perspectief - een selfie gemaakt door de camera van de Battlebot', 'en' => 'A unique perspective: a selfie captured by the Battlebot’s own camera'],
        'battlebot_selfmade_module_topview.webp' => ['nl' => 'Een bovenaanzicht van de zelfontworpen en gebouwde elektronische module', 'en' => 'A top-down view of the custom-designed and built electronic module'],
        'battlebot_selfmade_module.webp' => ['nl' => 'De zelfgebouwde elektronische module, netjes op zijn plek in de behuizing', 'en' => 'The custom-built electronic module, neatly fitted inside its enclosure'],
        'battlebot_sideview.webp' => ['nl' => 'Een kijkje vanaf de zijkant - de Battlebot in volle glorie', 'en' => 'A side view of the Battlebot in all its glory'],
        'battlebot_view_top.webp' => ['nl' => 'De Battlebot van bovenaf, gespot in zijn natuurlijke habitat', 'en' => 'The Battlebot from above, spotted in its natural habitat'],
        'battlebot_controller.webp' => ['nl' => 'Tijd voor een kleine aanpassing - de controller opengemaakt om de joysticks helemaal naar eigen smaak af te stellen', 'en' => 'Time for a little modification - opening up the controller to customise the joysticks to my liking'],
        'battlebot_custom_module.webp' => ['nl' => 'Passen, meten en experimenteren - stap voor stap krijgt de zelfontworpen module vorm', 'en' => 'Measuring, fitting and experimenting - the custom-designed module gradually taking shape'],
        'battlebot_expensive_mistake.webp' => ['nl' => 'Een wijze, maar prijzige les - vertrouw er niet blindelings op dat een buck converter altijd doet wat hij moet doen', 'en' => 'A valuable but costly lesson - never blindly assume a buck converter will always do its job'],
        'battlebot_HC-SR04_test.webp' => ['nl' => 'Eerst even testen - een proefopstelling om de HC-SR04-afstandssensoren aan de tand te voelen', 'en' => 'First, some testing - a test setup to put the HC-SR04 ultrasonic distance sensors through their paces'],
        'battlebot_mcp2515-module.webp' => ['nl' => 'Een bovenaanzicht van de gekoppelde MCP2515-modules - klaar voor CAN-buscommunicatie', 'en' => 'A top-down view of the connected MCP2515 modules - ready for CAN bus communication'],
        'battlebot_mcp2515.webp' => ['nl' => 'Een losse MCP2515-module - de schakel die CAN-buscommunicatie mogelijk maakt', 'en' => 'A standalone MCP2515 module - the component that makes CAN bus communication possible'],
        'battlebot_pico.webp' => ['nl' => 'De Raspberry Pi Pico 2 W gekoppeld aan een MCP2515-module - twee componenten die de handen ineenslaan', 'en' => 'The Raspberry Pi Pico 2 W connected to an MCP2515 module - two components working hand in hand'],
        'battlebot_under_the_hood.webp' => ['nl' => 'Een eerste blik onder de motorkap - kennismaken met de verschillende onderdelen waaruit de Battlebot is opgebouwd', 'en' => 'A first look under the hood - exploring the different components that make up the Battlebot'],
    ],
    'firstPhoto' => 'battlebot_screen_picture.webp',
];
