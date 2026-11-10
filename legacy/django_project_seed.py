from django.core.management.base import BaseCommand

from apps.core.models.contributor import Contributor
from apps.core.models.framework import Framework
from apps.core.models.image import Image
from apps.core.models.language import Language
from apps.core.models.paragraph import Paragraph
from apps.core.models.project import Project
from apps.core.models.project_contributor import ProjectContributor
from apps.core.models.project_framework import ProjectFramework
from apps.core.models.project_language import ProjectLanguage
from apps.core.models.project_specification import ProjectSpecification
from apps.core.models.specification import Specification
from apps.core.models.sub_paragraph import SubParagraph


class Command(BaseCommand):
    help = "Reset and Seed core data"

    def handle(self, *args, **options):
        try:
            # =================
            # DELETE ALL
            # =================
            SubParagraph.objects.all().delete()
            Paragraph.objects.all().delete()
            ProjectSpecification.objects.all().delete()
            ProjectFramework.objects.all().delete()
            ProjectLanguage.objects.all().delete()
            ProjectContributor.objects.all().delete()

            Image.objects.all().delete()
            Specification.objects.all().delete()
            Contributor.objects.all().delete()
            Project.objects.all().delete()
            Framework.objects.all().delete()
            Language.objects.all().delete()

            self.stdout.write(self.style.SUCCESS("Alle data correct verwijderd!"))

            # =================
            # FRAMEWORKS
            # =================
            framework_objs = {}
            frameworks = [
                {"name": "Django", "svg_url": "django"},
                {"name": "Flask", "svg_url": "flask"},
                {"name": "React Native", "svg_url": "react"},
                {"name": "Electron", "svg_url": "electron"},
            ]

            for fw in frameworks:
                framework_objs[fw["name"]], _ = Framework.objects.update_or_create(
                    name=fw["name"],
                    defaults={
                        "svg_url": fw["svg_url"],
                    }
                )

            # =================
            # LANGUAGES
            # =================
            language_objs = {}
            languages = [
                {"name": "Python", "svg_url": "python"},
                {"name": "TypeScript", "svg_url": "typescript"},
                {"name": "PHP", "svg_url": "php"},
                {"name": "Java", "svg_url": "java"},
                {"name": "Docker", "svg_url": "docker"},
                {"name": "MicroPython", "svg_url": "python"},
                {"name": "JavaScript", "svg_url": "javascript"},
                {"name": "HTML", "svg_url": "html5"},
                {"name": "CSS", "svg_url": "css3"},
                {"name": "SASS", "svg_url": "sass"},
                {"name": "Bash", "svg_url": "bash"},
                {"name": "SQL", "svg_url": "azuresqldatabase"},
            ]

            for lang in languages:
                language_objs[lang["name"]], _ = Language.objects.update_or_create(
                    name=lang["name"],
                    defaults={
                        "svg_url": lang["svg_url"],
                    }
                )


            # =================
            # PROJECTS DATA
            # =================
            projects_data = [
                # ====================
                # BATTLEBOT
                # ====================
                {
                    "link": "battlebot",
                    "title": "Battlebot",
                    "description": "Battlebot was mijn eindstageproject waarin ik een bestaande robot omvormde tot een intelligent en grotendeels autonoom systeem, met een Raspberry Pi 5 en Pico 2, CAN-bus communicatie en AI-gestuurde objectdetectie via een Hailo-8 accelerator.",
                    "year": 2025,
                    "github": "https://github.com/BattlebotdeGripper/battlebot_pi",
                    "featured": True,
                    "in_progress": False,
                    "languages": ["Python", "MicroPython", "Bash"],
                    "images": [
                        {"image_url": "projects/battlebot/battlebot-logo.png", "alt_text": "Logo van Battlebot project", "is_main_image": False, "is_logo": True},
                        {"image_url": "projects/battlebot/battlebot_frontview.webp", "alt_text": "Vooraanzicht van de Battlebot", "is_main_image": False,  "is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_huge_mess_topview.webp", "alt_text": "Bovenaanzicht van de Battlebot", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_huge_mess.webp", "alt_text": "Enorme bende op de Battlebot", "is_main_image": True,  "is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_mcp_connection.webp", "alt_text": "De MCP2515-module connectie tussen beide Pi's", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_screen_picture.webp", "alt_text": "Foto van de Battlebot met de camera van de robot", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_selfmade_module_topview.webp", "alt_text": "Bovenaanzicht hardware zelf gemaakt hardware module", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_selfmade_module.webp", "alt_text": "Zelfgemaakte hardware module", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_sideview.webp", "alt_text": "Zijaanzicht van de Battlebot", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_view_top.webp", "alt_text": "Bovenaanzicht van de Battlebot", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_all_components_blueprint.webp", "alt_text": "Blueprint van alle geimplementeerde hardware componenten", "is_main_image": False,"is_logo": False},
                        {"image_url": "projects/battlebot/battlebot_circuit_blueprint.webp", "alt_text": "Blueprint voornamelijk elektrisch circuit", "is_main_image": False, "is_logo": False},
                    ],
                    "paragraphs": [
                        {
                            "order": 1,
                            "title": "Introductie",
                            "subparagraphs": [
                                "Battlebot was een eindstageproject waarin een bestaande robot werd omgevormd tot een intelligent en grotendeels autonoom systeem.",
                                "Het doel was niet alleen een werkende robot bouwen, maar ook diepgaand inzicht krijgen in hoe complexe systemen samenwerken.",
                                "Gedurende vier maanden werd de robot stap voor stap uitgebreid, getest en geoptimaliseerd."
                            ]
                        },
                        {
                            "order": 2,
                            "title": "Visie en Doelstelling",
                            "subparagraphs": [
                                "De kern van het project was het realiseren van een robot die zowel handmatig als autonoom kan functioneren.",
                                "Dit duale besturingssysteem combineert directe controle met zelfstandige intelligentie.",
                                "De autonome functionaliteit richtte zich op objectherkenning en bewegingsplanning."
                            ]
                        },
                        {
                            "order": 3,
                            "title": "Architecturale opzet",
                            "subparagraphs": [
                                "Vanaf het begin werd gekozen voor een gescheiden architectuur, waarbij verantwoordelijkheden duidelijk werden verdeeld tussen software en hardware. Dit verhoogde onderhoudbaarheid en maakte testen eenvoudiger.",
                                "De Raspberry Pi 5 fungeerde als centrale besturingshub voor logica, communicatie, AI-verwerking en beslissingsalgoritmen.",
                                "De Raspberry Pi Pico 2 verzorgde real-time aansturing van motoren en de grijparm, waardoor lage-latentie acties betrouwbaar konden worden uitgevoerd, onafhankelijk van de zwaardere verwerking op de Pi 5."
                            ]
                        },
                        {
                            "order": 4,
                            "title": "Besturing en Veiligheid",
                            "subparagraphs": [
                                "De robot wordt primair bestuurd via een RC-controller, waarvan signalen worden ingelezen door de Raspberry Pi 5.",
                                "Deze signalen worden gevalideerd en geïnterpreteerd, waarna ze worden doorgestuurd naar de Raspberry Pi Pico 2 voor fysieke aansturing van motoren en actuators.",
                                "Om veiligheid te waarborgen is een heartbeat-mechanisme geïmplementeerd, dat continu controleert of de communicatie tussen Pi 5 en Pico 2 intact is en bij verlies van verbinding de robot in een veilige staat zet."
                            ]
                        },
                        {
                            "order": 5,
                            "title": "Autonome Besturing",
                            "subparagraphs": [
                                "Nadat de handmatige besturing stabiel functioneerde, verschoof de focus naar autonome aansturing. Hiervoor werd een camerasysteem toegevoegd waarmee de robot zijn omgeving kan waarnemen en visuele data kan verzamelen voor objectdetectie.",
                                "Door visuele input te combineren met afstandsmetingen van sensoren kon de robot objecten detecteren, volgen en ermee interacteren, zoals het oppakken of ontwijken van obstakels."
                            ]
                        },
                        {
                            "order": 6,
                            "title": "Hardwarekeuze",
                            "subparagraphs": [
                                "De keuze voor de Raspberry Pi 5 was gebaseerd op de behoefte aan rekenkracht, uitbreidbaarheid en ondersteuning voor AI-frameworks. De Raspberry Pi Pico 2 werd ingezet voor real-time besturing vanwege de directe GPIO-aansturing en voorspelbare timing.",
                                "Deze combinatie resulteerde in een schaalbaar systeem waarin software en hardware logisch van elkaar gescheiden zijn, waardoor complexe taken betrouwbaar uitgevoerd kunnen worden."
                            ]
                        },
                        {
                            "order": 7,
                            "title": "CAN-bus",
                            "subparagraphs": [
                                "Voor communicatie tussen Raspberry Pi 5 en Pico 2 is gekozen voor het CAN-bus protocol, bekend om zijn betrouwbaarheid en fouttolerantie. De MCP2515-modules verzorgen de interface, waardoor berichten met verschillende prioriteiten veilig verzonden kunnen worden.",
                                "Hoewel de implementatie complex was, bood het waardevolle inzichten in industriële communicatieprotocollen en message-prioritization technieken."
                            ]
                        },
                        {
                            "order": 8,
                            "title": "RC-Receiver",
                            "subparagraphs": [
                                "De Flysky FS-iA10B receiver vormt de schakel tussen gebruiker en robot, waarbij RC-signalen worden ontvangen en verwerkt. De signalen worden via UART omgezet naar digitale besturingswaarden die de Pi 5 kan interpreteren en doorsturen naar de Pico 2. Failsafe-functionaliteit zorgt ervoor dat de robot automatisch stopt of in een veilige modus komt bij signaalverlies of foutieve inputs."
                            ]
                        },
                        {
                            "order": 9,
                            "title": "Sensoren",
                            "subparagraphs": [
                                "Extra sensoren werden toegevoegd voor betrouwbaardere besturing, vooral tijdens autonome navigatie. Ultrasone afstandssensoren leveren realtime data over de omgeving, wat cruciaal is voor obstakelvermijding en positionering van de grijparm. Deze sensoren ondersteunen zowel autonome navigatie als het nauwkeurig uitvoeren van fysieke taken.",
                                "Om rijprecisie te verbeteren zijn optische encoders en odometrie onderzocht. Hoewel deze technieken theoretisch nauwkeurige resultaten opleverden, bleken ze in de praktijk gevoelig voor mechanische afwijkingen en oppervlakteruis. Uiteindelijk is gekozen voor een eenvoudiger correctiemechanisme op basis van PWM-aansturing, dat betrouwbaarder en onderhoudsvriendelijker bleek."
                            ]
                        },
                        {
                            "order": 10,
                            "title": "AI-Verwerking",
                            "subparagraphs": [
                                "Real-time objectdetectie werd uitgevoerd met de Hailo-8 AI Accelerator, die beelden lokaal verwerkt zonder externe afhankelijkheid. De accelerator maakt het mogelijk zware AI-modellen snel en efficiënt uit te voeren, wat cruciaal is voor autonome beslissingen. Dankzij deze setup kan de robot zelfstandig objecten herkennen en acties uitvoeren op basis van lokaal verwerkte data."
                            ]
                        },
                        {
                            "order": 11,
                            "title": "Cameragebruik",
                            "subparagraphs": [
                                "De Camera Module 3 Wide NoIR werd gekozen vanwege het brede gezichtsveld en de goede prestaties bij weinig licht. Beelden worden direct naar de Hailo-8 gestuurd voor analyse, waardoor realtime objectdetectie mogelijk is. Aanpassingen aan autofocus en aanvullende sensoren verbeterden de nauwkeurigheid bij korte afstand en complexe interacties."
                            ]
                        },
                        {
                            "order": 12,
                            "title": "Softwarearchitectuur",
                            "subparagraphs": [
                                "De software op de Raspberry Pi 5 is volledig geschreven in Python, met nadruk op leesbaarheid, onderhoudbaarheid en objectgeoriënteerd ontwerp. Op de Raspberry Pi Pico 2 draait MicroPython, waarmee directe hardware-aansturing mogelijk is met lage latentie. Versiebeheer via GitHub zorgt voor traceerbaarheid van wijzigingen, samenwerking en reproduceerbaarheid van experimenten."
                            ]
                        },
                        {
                            "order": 13,
                            "title": "Projectverloop",
                            "subparagraphs": [
                                "Het project volgde een iteratief proces, waarbij ontwerpen regelmatig werden herzien op basis van testresultaten en observaties. Problemen met voeding, communicatie en mechanica leidden tot meerdere herontwerpen, wat het systeem uiteindelijk robuuster maakte. Deze iteraties leverden diepgaand inzicht in systeemintegratie, foutafhandeling en praktische engineering-vaardigheden."
                            ]
                        },
                        {
                            "order": 14,
                            "title": "Eindresultaat",
                            "subparagraphs": [
                                "Het eindresultaat is een robot die stabiel handmatig bestuurbaar is en gedeeltelijk autonoom kan functioneren. Hoewel niet alle doelen volledig zijn gerealiseerd, biedt het project een solide basis voor verdere uitbreiding en verbetering. De belangrijkste opbrengst is kennis over embedded systemen, AI, communicatieprotocollen en de integratie van complexe software-hardware-systemen."
                            ]
                        },
                    ],
                    "specifications": [
                        {"spec": "UART (Universal asynchronous receiver-transmitter)", "category": "PROTOCOL"},
                        {"spec": "CAN (Controller area network)", "category": "PROTOCOL"},
                        {"spec": "I-Bus", "category": "PROTOCOL"},
                        {"spec": "SPI (Serial Peripheral Interface)", "category": "PROTOCOL"},
                        {"spec": "SSH (Secure Shell)", "category": "PROTOCOL"},
                        {"spec": "Raspberry Pi 5", "category": "HARDWARE", "svg_url": "raspberrypi"},
                        {"spec": "Raspberry Pi Pico 2", "category": "HARDWARE", "svg_url": "raspberrypi"},
                        {"spec": "Hailo-HAT", "category": "HARDWARE"},
                        {"spec": "UBEC (Universal battery eliminator circuit)", "category": "HARDWARE"},
                        {"spec": "ESC (Electronic Speed Controller)", "category": "HARDWARE"},
                        {"spec": "MCP2515-module", "category": "HARDWARE"},
                        {"spec": "DC-Converter", "category": "HARDWARE"},
                        {'spec': "CSI (Camera Serial Interface)", "category": "HARDWARE"},
                        {"spec": "PWM (Pulse-width modulation)", "category": "HARDWARE"},
                        {"spec": "HC-SR04", "category": "SENSOR"},
                        {"spec": "FC-03 IR Optical Encoder", "category": "SENSOR"},
                        {"spec": "Bitwise Operators", "category": "SOFTWARE"},
                        {"spec": "Thonny", "category": "SOFTWARE"},
                        {"spec": "YOLOv11", "category": "SOFTWARE"},
                        {"spec": "Crontab", "category": "SOFTWARE"},
                    ],
                    "contributors": [
                        {
                            "name": "A. Oomen",
                            "git_url": "https://github.com/Znooptokkie",
                            "git_image": "contributors/oomen_git_avatar.jpeg"
                        },
                                                {
                            "name": "M. de Graaf",
                            "git_url": "https://github.com/Matthijs-de-Graaf",
                            "git_image": "contributors/graaf_git_avatar.png"
                        }
                    ]
                },
                # ====================
                # PORTFOLIO
                # ====================
                {
                    "link": "portfolio",
                    "title": "Portfolio",
                    "description": "Mijn portfolio website gemaakt in Django.",
                    "year": 2026,
                    "github": "https://github.com/Znooptokkie/CV",
                    "featured": True,
                    "in_progress": True,
                    "framework": ["Django"],
                    "languages": ["Python", "TypeScript", "SASS", "SQL"],
                    "images": [
                        {"image_url": "projects/portfolio/portfolio-logo.png", "alt_text": "Logo van Portfolio website", "is_main_image": False, "is_logo": True},
                        {"image_url": "projects/portfolio/portfolio-website-homepage.png", "alt_text": "Screenshot van Homepage", "is_main_image": True,  "is_logo": False},
                    ],
                    "paragraphs": [
                        {
                            "order": 1,
                            "title": "Introductie",
                            "subparagraphs": [
                                "Uiteraard kan een Portfolio website niet ontbreken bij een Software Ontwikkelaar. Het afgelopen half jaar ben ik dan ook bezig geweest om deze website te maken. Vooral met de intentie om er wat van te leren. Dat is ook een van de voornaamste redenen waarom ik 'plain' TypeScript code gebruik en geen frontend framework. Een backend framework, tja, die acht ik wel nodig."
                                "Initieel werkte ik met Flask en SQLAlchemy om de database verbinding en templates te tonen, dit omdat ik eerst van plan was om een non-relationail database te gebruiken zoals JSON."
                                "Naarmate het project vorderde, kwam ik er toch achter dat het wel handig kan zijn om al mijn data in een database te hebben."
                            ],
                        },
                        {
                            "order": 2,
                            "title": "Visie en Doelstelling",
                            "subparagraphs": [
                                "Ik had al enigzins ervaring met Flask en Django. Omdat ik dus niet van plan was een relationele database te gebruiken, besloot ik voor het lichtgewicht framework te gaan Flask.",
                                "Als eerste ging ik wat onderzoek doen naar bestaande portfolio websites, kijken hoe anderen die van hun hebben gemaakt.",
                                "De meeste protfolio websites die ik tegenkwam waren wel volledig gemaakt met een frontend framework zoals React. Desondanks heb ik er wel de nodige inspiratie van opgedaan."
                            ]
                        }
                    ],
                    "specifications": [
                        {"spec": "CI/CD", "category": "SOFTWARE"},
                        {"spec": "API", "category": "COMMUNICATIE"},
                        {"spec": "JSON", "category": "DATAFORMAT", "svg_url": "json"},
                        {"spec": "SVG", "category": "INTERFACE"},
                    ],
                    "contributors": [
                        {
                            "name": "A. Oomen",
                            "git_url": "https://github.com/Znooptokkie",
                            "git_image": "contributors/oomen_git_avatar.jpeg"
                        }
                    ]
                },
                # ====================
                # SMARTGARDEN DESKTOP
                # ====================
                {
                    "link": "smartgarden-desktop",
                    "title": "Smart Garden (desktop)",
                    "description": "Smart Garden is een samenwerkingsproject tussen het CIV Smart Technology, The Field in Leiden en mboRijnland, waarbij een dashboard werd gebouwd in Flask om een verticale tuin te monitoren en aan te sturen, inclusief live sensordata en een automatisch aangestuurde waterpomp via een Raspberry Pi 4.",
                    "year": 2024,
                    "github": "https://github.com/Znooptokkie/GoodGarden",
                    "featured": False,
                    "in_progress": False,
                    "framework": ["Electron", "Flask"],
                    "languages": ["Python", "JavaScript", "CSS", "HTML"],
                    "images": [
                        {"image_url": "projects/smart_garden_desktop/GG-logo.png", "alt_text": "Het logo van GoodGarden", "is_main_image": False, "is_logo": True},
                        {"image_url": "projects/smart_garden_desktop/gg_ik_bij_hh.webp", "alt_text": "Het formulier waar je een plant kan toevoegen aan de applicatie", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/smart_garden_desktop/gg_add_plant.webp", "alt_text": "Het formulier waar je een plant kan toevoegen aan de applicatie", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/smart_garden_desktop/gg_api_request.webp", "alt_text": "De vraag om een API request te doen voor de data", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/smart_garden_desktop/gg_api_result.webp", "alt_text": "De opgehaalde data van de API request", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/smart_garden_desktop/gg_homepage.webp", "alt_text": "Dashboard homepage van GoodGarden", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/smart_garden_desktop/gg_plant_info.webp", "alt_text": "De pagina waar alle info staat per plant", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/smart_garden_desktop/gg_settings.webp", "alt_text": "De pagina waar de instellingen staan", "is_main_image": False, "is_logo": False}
                    ],
                    "paragraphs": [
                        {
                            "order": 1,
                            "title": "Introductie",
                            "subparagraphs": [
                                "Smart Garden is een samenwerkingsproject tussen het CIV Smart Technology, The Field in Leiden en mboRijnland, met als nieuwste aanwinst studenten van de Haagse Hogeschool.",
                                "Het doel van dit project is om studenten actief te betrekken bij actuele maatschappelijke vraagstukken, met een focus op duurzaamheid en circulair bouwen. De centrale vraag binnen Smart Garden luidt: \"Hoe kunnen we een kas met planten zo efficiënt en autonoom mogelijk in leven houden?\"",
                                "Wat begon als een relatief klein project, groeide gedurende meerdere schooljaren uit tot een project van aanzienlijke omvang, met meerdere opeenvolgende teams en steeds verdergaande technische uitdagingen."
                            ]
                        },
                        {
                            "order": 2,
                            "title": "De Opdracht",
                            "subparagraphs": [
                                "Iedere tweedejaars student van de opleiding Software Developer bij mboRijnland kreeg in deze periode dezelfde opdracht, waarna groepjes werden gevormd om deze uit te voeren. Ons groepje bestond uit vijf leden.",
                                "Door de scrum-methodiek toe te passen, hadden we vanaf het begin een duidelijke rolverdeling: twee front-end developers, twee back-end developers (waarvan één ook de rol van Product Owner vervulde), en ikzelf als Scrum Master en projectleider.",
                                "De opdracht begon in periode drie van het schooljaar 2023-2024. Als eerste werd van ons verwacht dat we sensordata zouden ophalen uit een API van Quantified en deze zichtbaar zouden maken op een dashboard.",
                                "Daarnaast moesten we planten kunnen toevoegen die zich in de kas bevinden, zodat elke individuele plant gemonitord kan worden. Omdat het einddoel een autonome kas is, leek het ons zinvol om gegevens zoals waterbehoefte, zonlicht en voedingsstoffen automatisch te laten invullen. Hiervoor maakten we gebruik van een tweede API, die per plant de benodigde gegevens aanlevert."
                            ]
                        },
                        {
                            "order": 3,
                            "title": "Technische Keuzes",
                            "subparagraphs": [
                                "Na wat onderzoek leek het ons een goed idee om Electron te gebruiken voor het dashboard. We kwamen er echter al snel achter dat Electron voornamelijk bedoeld is voor desktopapplicaties, wat een beperking bleek zodra we daadwerkelijk data moesten gaan versturen en verwerken.",
                                "Aanvankelijk overwogen we om een aparte Flask-applicatie toe te voegen als backend, naast Electron. Na overleg met een docent besloten we echter om de volledige applicatie in Flask te bouwen, zonder Electron.",
                                "Twee frameworks naast elkaar gebruiken voelde omslachtig, terwijl Flask in principe alle functionaliteit kon bieden die we nodig hadden."
                            ]
                        },
                        {
                            "order": 4,
                            "title": "Functionaliteiten",
                            "subparagraphs": [
                                "Naast onze eigen code maakten we gebruik van twee externe API's. De Perenual API levert data van specifieke plantensoorten, die automatisch wordt ingevuld op de bijbehorende pagina van elke plant.",
                                "De Weerlive API zorgt ervoor dat actuele weersomstandigheden worden meegenomen in het systeem, aangezien planten sterk afhankelijk zijn van het weer: bij hoge temperaturen is bijvoorbeeld extra water nodig."
                            ]
                        },
                        {
                            "order": 5,
                            "title": "Vervolgopdracht",
                            "subparagraphs": [
                                "Nadat de opdracht was afgerond, mochten wij als groep verder werken aan Smart Garden, terwijl de rest van de klas aan een nieuw project begon. Deze kans grepen we uiteraard met beide handen aan.",
                                "De vervolgopdracht hield in dat we een pomp moesten aansturen die zich bevindt in het Smart Building bij The Field. Op dit moment kwam een extra teamlid ons versterken, gespecialiseerd in embedded systems en Linux.",
                                "De pomp zelf was ontworpen en gebouwd door studenten van de opleiding Technicus Engineering bij mboRijnland. Voor de aansturing bedachten wij een oplossing waarbij een Raspberry Pi 4 fungeert als centrale controller, waarin alle logica van het systeem samenkomt.",
                                "Omdat deze Raspberry Pi fysiek bij The Field stond en we niet altijd ter plaatse konden zijn, zetten we een reverse tunnel op via SSH. Op die manier konden we de Raspberry Pi op elk moment programmeren, uiteraard zonder deze op de pomp aangesloten te hebben, om problemen zoals overstroming te voorkomen.",
                                "Het bestaande dashboard werd tegelijkertijd verder uitgebreid, zodat het ook daadwerkelijk kon samenwerken met deze fysieke realisatie."
                            ]
                        },
                        {
                            "order": 6,
                            "title": "De Oplevering",
                            "subparagraphs": [
                                "Vanaf dit punt werkten we nauw samen met de studenten van Technicus Engineering, die de pomp hadden gebouwd. Deze samenwerking verliep uitstekend, mede dankzij de motivatie aan beide kanten.",
                                "De oplevering ging niet zonder slag of stoot: we kregen te maken met een onstabiele wifiverbinding, verkeerd gekalibreerde sensoren, en het feit dat vrijwel alles nieuw voor ons was.",
                                "Uiteindelijk slaagden we erin een werkend systeem op te leveren: de pomp geeft de planten sindsdien automatisch elke twee weken water. De sensoren werden bij deze oplevering nog niet gebruikt, door problemen die grotendeels buiten onze macht lagen."
                            ]
                        },
                        {
                            "order": 7,
                            "title": "Overdracht",
                            "subparagraphs": [
                                "Via een pitch bij het DIF in Zoetermeer werden studenten van de Haagse Hogeschool enthousiast gemaakt om Smart Garden voort te zetten.",
                                "Zij bouwen voort op de Raspberry Pi 4 als centraal brein van het systeem, en breiden dit uit met sensoren voor grondvochtigheid per plantenbak, een sensor voor luchtvochtigheid in de kas en een lichtsensor.",
                                "Daarnaast zetten zij de ChatGPT API in om automatisch gegevens per individuele plant in te vullen, en is het plan om een camera aan de kas te koppelen zodat kunstmatige intelligentie vroegtijdig bedreigingen kan signaleren in het dashboard."
                            ]
                        },
                        {
                            "order": 8,
                            "title": "Doelstelling",
                            "subparagraphs": [
                                "Het einddoel van Smart Garden is een volledig werkend algoritme dat elke individuele plant van water voorziet, gebaseerd op data uit de Perenual API en aangestuurd via het MQTT-protocol.",
                                "Daarnaast moet het dashboard volledig functioneren, met correcte data en werkende grafieken op alle pagina's. Indien mogelijk, met het oog op beveiliging, is het streven om de website ook daadwerkelijk beschikbaar te stellen voor gebruik door The Field zelf.",
                                "Gedurende dit project heb ik geleerd te werken met SSH-verbindingen, de basis van het Linux-besturingssysteem, het ophalen en verwerken van sensordata, het versturen en ophalen van data via API's, basiskennis van algoritmes, het maken van grafieken met ChartJS, werken met Python en Flask, en het gebruik van het MQTT-protocol voor sensordata."
                            ]
                        }
                    ],
                    "specifications": [
                        {"spec": "SSH (Secure Shell)", "category": "PROTOCOL"},
                        {"spec": "MQTT (Message Queuing Telemetry Transport)", "category": "PROTOCOL"},
                        {"spec": "API", "category": "COMMUNICATIE"},
                        {"spec": "Capacitive Soil Moisture Sensor", "category": "HARDWARE"},
                        {"spec": "Perenual API", "category": "COMMUNICATIE"},
                        {"spec": "Weerlive API", "category": "COMMUNICATIE"},
                        {"spec": "Raspberry Pi 4", "category": "HARDWARE", "svg_url": "raspberrypi"},
                        {"spec": "JSON", "category": "DATAFORMAT", "svg_url": "json"},
                        {"spec": "ChartJS", "category": "SOFTWARE", "svg_url": "chartjs"},
                        {"spec": "Flask", "category": "SOFTWARE"},
                    ],
                    "contributors": [
                        {
                            "name": "A. Oomen",
                            "git_url": "https://github.com/Znooptokkie",
                            "git_image": "contributors/oomen_git_avatar.jpeg"
                        },
                        {
                            "name": "R. van Putten",
                            "git_url": "https://github.com/SanzoVP",
                            "git_image": "contributors/putten_git_avatar.jpeg"
                        },
                        {
                            "name": "B. Diker",
                            "git_url": "https://github.com/bdiker61",
                            "git_image": "contributors/diker_git_avatar.png"
                        },
                        {
                            "name": "M. Cifci",
                            "git_url": "https://github.com/mohammedcifci",
                            "git_image": "contributors/cifci_git_avatar.jpeg"
                        },
                                                {
                            "name": "J. Doekhi",
                            "git_url": "https://github.com/6027529",
                            "git_image": "contributors/doekhi_git_avatar.png"
                        },
                        {
                            "name": "M. Heins",
                            "git_url": "https://github.com/martijnhe",
                            "git_image": "contributors/heins_git_avatar.png"
                        }
                    ]
                },
                # ====================
                # SMARTGARDEN MOBILE
                # ====================
                {
                    "link": "smartgarden-mobiel",
                    "title": "Smart Garden (mobiel)",
                    "description": "Voor mijn eindexamen Mobile Development heb ik het project Smart Garden (desktop) omgezet naar een volwaardige mobiele applicatie in React Native, met eigen Flask-API, gebruikersrollen en koppeling met een Raspberry Pi 4.",
                    "year": 2025,
                    "github": "https://github.com/6028968/GG_MAD",
                    "featured": True,
                    "in_progress": True,
                    "framework": ["React Native"],
                    "languages": ["TypeScript"],
                    "images": [
                        {"image_url": "projects/smart_garden_mobile/GG-logo-mobiel.png", "alt_text": "Het logo van GoodGarden (mobiel)", "is_main_image": False, "is_logo": True},
                        {"image_url": "projects/smart_garden_mobile/gg_mob_all_plants.webp", "alt_text": "Pagina waar alle planten staan", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/smart_garden_mobile/gg_mob_homepage.webp", "alt_text": "Homepage van de mobiele applicatie", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/smart_garden_mobile/gg_mob_log.webp", "alt_text": "Het logboek van de mobiele applicatie", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/smart_garden_mobile/gg_mob_login.webp", "alt_text": "De login pagina van de mobiele applicatie", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/smart_garden_mobile/gg_mob_plant_info.webp", "alt_text": "De informatie pagina van een plant van de mobiele applicatie", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/smart_garden_mobile/gg_mob_pump.webp", "alt_text": "De pagina van de pomp van de mobiele applicatie", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/smart_garden_mobile/gg_mob_sensors.webp", "alt_text": "De sensor pagina van de mobiele applicatie", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/smart_garden_mobile/gg_mob_settings.webp", "alt_text": "De instellingen pagina van de mobiele applicatie", "is_main_image": False, "is_logo": False},
                    ],
                    "paragraphs": [
                        {
                            "order": 1,
                            "title": "Introductie",
                            "subparagraphs": [
                                "Nadat de desktopversie van Smart Garden was opgeleverd, kreeg ik de kans om het project in mijn eigen eindexamen Mobile Development verder uit te werken. In plaats van vanaf nul te beginnen, besloot ik het concept van Smart Garden om te zetten naar een mobiele applicatie.",
                                "Doordat ik inmiddels meer ervaring en kennis had opgedaan, kon ik het project met een beter overzicht en een duidelijkere structuur aanpakken dan de eerste keer."
                            ]
                        },
                        {
                            "order": 2,
                            "title": "Doel en Doelgroep",
                            "subparagraphs": [
                                "Het doel van de mobiele applicatie is om eigenaren van verticale tuinen, met name medewerkers van The Field, een gebruiksvriendelijke manier te bieden om sensoren en pompen op afstand te monitoren en aan te sturen.",
                                "Gebruikers kunnen via de app bodemvochtigheid en andere gegevens inzien, irrigatieschema's instellen, planten toevoegen en historische data raadplegen. Er is bewust gekozen voor verschillende gebruikersrollen: normale gebruikers kunnen enkel gegevens inzien, terwijl admins volledige controle hebben over het beheer van de tuin."
                            ]
                        },
                        {
                            "order": 3,
                            "title": "Technische Keuzes",
                            "subparagraphs": [
                                "Voor de applicatie zelf koos ik voor React Native met TypeScript, een framework waar ik al goed mee overweg kon en dat het mogelijk maakt om in de toekomst ook op iOS uit te breiden.",
                                "Voor de backend bouwde ik eerst een eigen API in Node.js, maar stapte ik uiteindelijk over naar Flask, omdat Python prettiger werkte dan JavaScript voor dit deel van het project.",
                                "Lokale data, zoals gebruikers- en plantgegevens, wordt opgeslagen met AsyncStorage in plaats van een volwaardige database, nadat meerdere pogingen om een database te implementeren niet naar wens verliepen. Wachtwoorden worden hierbij wel gehasht opgeslagen, zodat de gegevens toch enigszins beschermd blijven."
                            ]
                        },
                        {
                            "order": 4,
                            "title": "Raspberry Pi",
                            "subparagraphs": [
                                "Voor de communicatie met de sensoren en de pomp bij The Field, die worden aangestuurd door een Raspberry Pi 4, koos ik voor een SSH-verbinding waarbij JSON-bestanden via het SCP-protocol werden uitgewisseld.",
                                "Op mijn mobiel gebruikte ik Termux om deze verbinding op te zetten en om een kleine Node.js-server te draaien die de data via HTTP-verzoeken beschikbaar maakte voor de app.",
                                "Deze opzet werkte in eerste instantie goed, maar na verloop van tijd viel de SSH-verbinding meerdere keren onverwacht uit en bleef deze onbeschikbaar. Om de applicatie toch volledig werkend te krijgen, heb ik ervoor gekozen om de sensordata tijdelijk hardcoded in de Flask-API te plaatsen, zodat de rest van de app wel volledig getest en getoond kon worden."
                            ]
                        },
                        {
                            "order": 5,
                            "title": "Functionaliteiten",
                            "subparagraphs": [
                                "De applicatie bevat onder andere een inlog- en registratiesysteem, een homepagina met een vijfdaagse weersverwachting en een overzicht van de planten aan beide kanten van de kas, en een pagina met alle ooit toegevoegde planten.",
                                "Op de pagina van een individuele plant wordt automatisch een deel van de gegevens ingevuld via de Perenual API, en kan de aanwezigheid, locatie en status van de plant worden beheerd.",
                                "Daarnaast zijn er aparte pagina's voor sensoren, pompen en een logboek van data en foutmeldingen. Alleen admin-gebruikers kunnen planten toevoegen, wijzigen of verwijderen en hebben toegang tot beheerfuncties zoals het verwijderen van de database."
                            ]
                        },
                        {
                            "order": 6,
                            "title": "Problemen",
                            "subparagraphs": [
                                "Naast de wegvallende SSH-verbinding liep ik tegen een aantal andere technische uitdagingen aan. React Native ondersteunt standaard geen interne communicatie binnen hetzelfde domein, waardoor ik CORS goed moest configureren om de app en de Flask-API probleemloos met elkaar te laten praten.",
                                "Ook het opslaan van gevoelige gegevens, zoals API-sleutels, in een apart .env-bestand bleek problematisch: na het toevoegen van de benodigde dependency crashte de applicatie volledig, zonder dat ik de oorzaak kon achterhalen. Uiteindelijk heb ik ervoor gekozen om deze gegevens, noodgedwongen, hardcoded in de applicatie te verwerken."
                            ]
                        },
                        {
                            "order": 7,
                            "title": "Toevoegingen",
                            "subparagraphs": [
                                "Tijdens de ontwikkeling heb ik een aantal functionaliteiten toegevoegd die niet in het oorspronkelijke ontwerp stonden. Zo kan er per plant een irrigatieschema worden ingesteld, waarin wordt bijgehouden hoe vaak een plant water nodig heeft en wanneer de volgende irrigatie gepland staat.",
                                "Ook kunnen admins alle gegevens van een plant achteraf aanpassen, en heb ik een functie toegevoegd om planten volledig uit het systeem te verwijderen, iets wat in eerste instantie ontbrak."
                            ]
                        },
                        {
                            "order": 8,
                            "title": "Ongerealiseerd",
                            "subparagraphs": [
                                "Niet alles is gelukt zoals oorspronkelijk gepland. Het automatisch invullen van plantgegevens bleek uiteindelijk complexer dan gedacht, omdat hiervoor eigenlijk twee API's nodig waren in plaats van één: een vertaal-API om de ingevoerde tekst naar het Engels om te zetten, voordat deze als parameter aan de Perenual API kon worden meegegeven.",
                                "Ook een exportfunctie voor sensor- en plantdata naar CSV of PDF heb ik uiteindelijk laten liggen, omdat ik meer tijd kwijt was aan het afronden van de kernfunctionaliteit dan verwacht.",
                                "Live sensordata kon door de wegvallende SSH-verbinding niet worden gerealiseerd, en de sensoren zelf waren op het moment van opleveren ook nog niet fysiek in de kas geïmplementeerd.",
                                "De functionaliteit om de pomp op afstand aan te sturen is technisch wel aanwezig, maar bewust niet volledig actief gemaakt: zonder een stabiele verbinding en zonder toezicht durfde ik het risico niet te nemen dat de pomp niet meer uitgeschakeld zou kunnen worden."
                            ]
                        },
                        {
                            "order": 9,
                            "title": "Kwaliteitsborging",
                            "subparagraphs": [
                                "Om de betrouwbaarheid van de applicatie te waarborgen, heb ik uitgebreid handmatig getest aan de hand van vooraf opgestelde testcases, gericht op zowel de normale gebruiker als de admin.",
                                "Vrijwel alle geteste functionaliteiten, zoals registreren, inloggen, planten toevoegen, filteren en verwijderen, bleken succesvol te werken. Eén test bracht aan het licht dat er geen foutmelding werd getoond bij het invoeren van een ongeldige gebruikersnaam, wat ik vervolgens heb opgelost door een validatiefunctie en een duidelijke foutmelding toe te voegen."
                            ]
                        },
                        {
                            "order": 10,
                            "title": "Eindresultaat",
                            "subparagraphs": [
                                "Het eindresultaat is een volledig functionerende mobiele applicatie die het beheer van een verticale tuin overzichtelijk en toegankelijk maakt, ook al draait een deel van de data momenteel nog op hardcoded waarden in plaats van live sensordata.",
                                "Mocht de SSH-verbinding met de Raspberry Pi in de toekomst weer stabiel werken, dan zou de overstap naar echte live data relatief snel te realiseren moeten zijn.",
                                "Dit project heeft mij vooral veel geleerd over het combineren van mobiele ontwikkeling met hardware-integratie, en over hoe je omgaat met onderdelen die, ondanks je beste inspanningen, niet altijd volledig naar wens werken."
                            ]
                        }
                    ],
                    "specifications": [
                        {"spec": "SSH (Secure Shell)", "category": "PROTOCOL"},
                        {"spec": "SCP (Secure Copy Protocol)", "category": "PROTOCOL"},
                        {"spec": "HTTP", "category": "PROTOCOL"},
                        {"spec": "CORS (Cross-Origin Resource Sharing)", "category": "PROTOCOL"},
                        {"spec": "API", "category": "COMMUNICATIE"},
                        {"spec": "Perenual API", "category": "COMMUNICATIE"},
                        {"spec": "Weer API", "category": "COMMUNICATIE"},
                        {"spec": "Raspberry Pi 4", "category": "HARDWARE", "svg_url": "raspberrypi"},
                        {"spec": "Soil Moisture Sensor", "category": "SENSOR"},
                        {"spec": "JSON", "category": "DATAFORMAT", "svg_url": "json"},
                        {"spec": "AsyncStorage", "category": "SOFTWARE"},
                        {"spec": "Termux", "category": "SOFTWARE"},
                        {"spec": "Expo", "category": "SOFTWARE", "svg_url": "expo"},
                        {"spec": "GPIO (General Purpose Input/Output)", "category": "HARDWARE"},
                    ],
                    "contributors": [
                        {
                            "name": "A. Oomen",
                            "git_url": "https://github.com/Znooptokkie",
                            "git_image": "contributors/oomen_git_avatar.jpeg"
                        }
                    ]
                },
                # ====================
                # BRAM
                # ====================
                {
                    "link": "bram",
                    "title": "BRAM",
                    "description": "BRAM was mijn eerste mobiele project, aangeboden door de gemeente Zoetermeer, waarbij we in Android Studio met Java een applicatie bouwden die ouderen moet helpen om gemakkelijker overweg te kunnen met hun mobiel, met functies zoals een noodknop en eenvoudige toegang tot familiefoto's.",
                    "year": 2024,
                    "github": "https://github.com/bdiker61/BRAM",
                    "featured": False,
                    "in_progress": False,
                    "languages": ["Java"],
                    "images": [
                        {"image_url": "projects/bram/bram-logo.png", "alt_text": "Logo van het project BRAM", "is_main_image": False, "is_logo": True},
                        {"image_url": "projects/bram/bram_loadingscreen.webp", "alt_text": "Een screenshot van het laadscherm van de mobiele applicatie", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/bram/bram_verwarming.webp", "alt_text": "Een screenshot voor het aansturen van de verwarming van de mobiele applicatie", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/bram/bram_lichten.webp", "alt_text": "Een screenshot voor het aansturen van de lichten van de mobiele applicatie", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/bram/bram_home.webp", "alt_text": "Een screenshot van de Homepage van de mobiele applicatie", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/bram/bram_foto.webp", "alt_text": "Een screenshot van de Album pagina van de mobiele applicatie", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/bram/bram_contact.webp", "alt_text": "Een screenshot van de Contact pagina van de mobiele applicatie", "is_main_image": False, "is_logo": False},
                    ],
                    "paragraphs": [
                        {
                            "order": 1,
                            "title": "Introductie",
                            "subparagraphs": [
                                "Dit project werd aan ons aangeboden door de gemeente Zoetermeer.",
                                "Het was mijn eerste project voor mobiel. Deze applicatie moest het voor ouderen gemakkelijker maken om met de mobiel overweg te kunnen.",
                                "Omdat ouderen vaak moeilijker mee kunnen komen met de technologie, kregen wij de opdracht om een applicatie te maken waarmee ouderen wat makkelijker overweg kunnen."
                            ],
                        },
                        {
                            "order": 2,
                            "title": "Visie en Doelstelling",
                            "subparagraphs": [
                                "De voornaamste doelstelling was dat ouderen door het gebruik van deze app niet tegen beperkingen zouden aanlopen.",
                                "Zo hebben wij verschillende ouderen geïnterviewd over wat voor hen nou zo belangrijk is om in deze applicatie te hebben.",
                                "Waar vrijwel iedereen het over eens was, was veiligheid. Er moest binnen de app een duidelijke 'noodknop' zijn waarmee externe hulp ingeschakeld kan worden.",
                                "Ook vonden de ouderen het erg belangrijk om gemakkelijk toegang tot foto's te hebben, vooral die van hun eigen familie."
                            ]
                        },
                        {
                            "order": 3,
                            "title": "Besluitvorming",
                            "subparagraphs": [
                                "Vanuit school was er de optie om dit project te maken met de kennis die wij al hadden. Dat hield in dat wij de applicatie met HTML, CSS en JavaScript mochten bouwen.",
                                "Voor wie een wat grotere uitdaging zocht, was er de mogelijkheid om het project in Android Studio te maken.",
                                "Uiteraard koos mijn projectgroep voor de tweede optie: Android Studio. Binnen Android Studio hadden we vervolgens nog de keuze tussen twee programmeertalen: Java of Kotlin.",
                                "Na wat onderzoek te hebben gedaan, besloten wij het in Java te maken, vooral omdat Java een meer gebruikte taal is dan Kotlin. Het leek ons daardoor een grotere toegevoegde waarde om Java te leren."
                            ]
                        },
                        {
                            "order": 4,
                            "title": "Taakverdeling",
                            "subparagraphs":
                            [
                                "Er moesten vier hoofdpagina's gerealiseerd worden. Dat kwam mooi uit, want we waren ook met precies vier man.",
                                "De 'Lampen'-pagina was aan mij toegekend, samen met het opzetten van de applicatie in Android Studio.",
                                "Zodra ik begreep hoe alles werkte binnen Android Studio, heb ik dit uitgelegd aan de rest van mijn groepje. Uiteraard zochten zij zelf ook het een en ander uit, maar ik neem meestal de leiding op me omdat ik altijd een duidelijk overzicht wil hebben van hoe alles werkt, zodat ik ook kan helpen mocht er ergens iets vastlopen. Daarnaast was ik ook een stuk ouder dan de rest, wat natuurlijk ook meehielp.",
                            ]
                        },
                        {
                            "order": 5,
                            "title": "Realisatie",
                            "subparagraphs": [
                                "Toen kwam het daadwerkelijke programmeren van de applicatie.",
                                "Van een docent kregen wij een inlogcode om via zijn VPS een set JSON-data op te halen waarmee we een lamp konden aansturen. Hiervoor moest namelijk een echte API gemaakt worden waarmee we dingen konden besturen, te beginnen bij die lamp.",
                                "Dit gebeurde allemaal via een lokaal wifinetwerk, anders kwamen er weer heel andere veiligheidsaspecten bij kijken.",
                                "Het realiseren verliep eigenlijk best vlekkeloos. Wel had ik zelf wat problemen met het inladen van foto's via een emulator, maar na vele pogingen is het gelukt. Ik had het zelf graag nog wat 'beter' willen maken, maar in de laatste week van het project was ik helaas niet op school (ik ging naar een festival dat al gepland stond).",
                                "Wel ben ik in constant contact gebleven met mijn projectgroep. Eigenlijk hadden ze mij niet echt nodig, het lukte hen zelf al aardig goed. Vooral Matthijs de Graaf moet ik hiervoor enorm bedanken, want hij zette zich elke dag voor de volle honderd procent in, waardoor het uit handen geven van de leiding mij niet echt zwaar viel."
                            ],
                        },
                        {
                            "order": 6,
                            "title": "Oplevering",
                            "subparagraphs": [
                                "Zoals wij het project hadden bedacht, zo is het ook geworden!",
                                "Ik kijk met een zeer tevreden gevoel terug op dit project. Het werd beoordeeld met een 10/10, wat natuurlijk een enorme boost voor het zelfvertrouwen was."
                            ]
                        }
                    ],
                    "specifications": [
                        {"spec": "Android SDK", "category": "SOFTWARE", "svg_url": "androidstudio"},
                        {"spec": "Gradle", "category": "SOFTWARE", "svg_url": "gradle"}, # Moet eigenlijk gradle-original zijn!@!$#%@$^
                        {"spec": "XML", "category": "DATAFORMAT", "svg_url": "xml"},
                        {"spec": "API", "category": "COMMUNICATIE"},
                    ],
                    "contributors": [
                        {
                            "name": "A. Oomen",
                            "git_url": "https://github.com/Znooptokkie",
                            "git_image": "contributors/oomen_git_avatar.jpeg"
                        },
                        {
                            "name": "M. de Graaf",
                            "git_url": "https://github.com/Matthijs-de-Graaf",
                            "git_image": "contributors/graaf_git_avatar.png"
                        },
                        {
                            "name": "R. van Putten",
                            "git_url": "https://github.com/SanzoVP",
                            "git_image": "contributors/putten_git_avatar.jpeg"
                        },
                        {
                            "name": "B. Diker",
                            "git_url": "https://github.com/bdiker61",
                            "git_image": "contributors/diker_git_avatar.png"
                        }
                    ]
                },
                # ====================
                # ZINRA
                # ====================
                {
                    "link": "zinra",
                    "title": "Zinra",
                    "description": "Voor het Ministerie van Binnenlandse Zaken en Koninkrijksrelaties (BZK) ontwikkelden wij twee programma's om een grote hoeveelheid documenten te organiseren: een mailbox-applicatie die mails automatisch categoriseert via het 'Bag of Words'-concept, en een website voor het handmatig sorteren en dedupliceren van documenten.",
                    "year": 2023,
                    "github": "",
                    "featured": True,
                    "in_progress": True,
                    "languages": ["PHP", "HTML"],
                    "images": [
                        {"image_url": "projects/zinra/zinra-logo.png", "alt_text": "Het logo van Zinra", "is_main_image": False, "is_logo": True},
                        {"image_url": "projects/zinra/zinra_app.webp", "alt_text": "Een screenshot van de beslissingsboom", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/zinra/zinra_home.webp", "alt_text": "Het homescreen van de applicatie binnenin de mail", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/zinra/zinra_mail.webp", "alt_text": "De mail waarin Zinra zich bevindt als add-on", "is_main_image": False, "is_logo": False},
                        {"image_url": "projects/zinra/zinra_unimportant.webp", "alt_text": "De uitslag nadat de mail gescanned is door Zinra", "is_main_image": True, "is_logo": False},
                        {"image_url": "projects/zinra/zinra_website_manual.webp", "alt_text": "De website van Zinra waar handmatig documenten gesorteerd kunnen worden", "is_main_image": True, "is_logo": False},
                    ],
                    "paragraphs": [
                        {
                            "order": 1,
                            "title": "Introductie",
                            "subparagraphs": [
                                "Zinra was een van mijn eerste projecten op school en meteen een bijzonder leerzame ervaring, omdat we voor het eerst met een echte, externe opdrachtgever werkten en het resultaat van ons werk direct zichtbaar was.",
                                "Vanuit het Ministerie van Binnenlandse Zaken en Koninkrijksrelaties (BZK) kregen wij de opdracht om orde te scheppen in een enorme hoeveelheid documenten die zich bij het ministerie hadden opgestapeld. Precies daarom was dit project zo leuk om aan te werken: het voelde niet als een bedachte schoolopdracht, maar als een probleem dat er echt toe deed voor een echte opdrachtgever."
                            ]
                        },
                        {
                            "order": 2,
                            "title": "De Opdracht",
                            "subparagraphs": [
                                "De kern van de opdracht was het efficiënter organiseren en categoriseren van documenten, zodat relevante informatie sneller teruggevonden kon worden en overbodige of dubbele bestanden niet langer voor onnodige rompslomp zorgden.",
                                "Vanuit school kregen wij daarbij een concrete technische eis mee: er moest een beslisboom in het systeem verwerkt zitten waarmee de documenten stap voor stap beoordeeld en verwerkt konden worden, en de communicatie hierbij moest via het SMTP-protocol verlopen."
                            ]
                        },
                        {
                            "order": 3,
                            "title": "Ons Idee",
                            "subparagraphs": [
                                "Om deze opdracht aan te pakken, besloten wij twee afzonderlijke programma's te ontwikkelen die elkaar aanvulden.",
                                "Het eerste programma was gericht op de mailbox zelf. Omdat e-mails in de kern zijn opgebouwd uit HTML, konden wij de inhoud van binnenkomende mails uitlezen met JavaScript. Door gebruik te maken van het \"Bag of Words\"-concept, waarbij op basis van de aanwezige woorden een inschatting wordt gemaakt van het onderwerp, kon het systeem automatisch bepalen bij welke categorie een bepaalde mail hoorde. Op deze manier konden documenten en mails al vroegtijdig, nog voordat iemand ze daadwerkelijk had gelezen, worden voorgesorteerd op relevantie.",
                                "Het tweede programma bestond uit een website waarmee documenten handmatig gesorteerd konden worden. Een gebruiker kon hier een volledige map of een los document uploaden, waarna zelf bepaald kon worden of het document bewaard moest blijven of verwijderd kon worden. Alle beslissingen werden opgeslagen in een database, die precies bijhield welke documenten behouden moesten blijven en welke weggegooid mochten worden. Een belangrijk voordeel van deze aanpak was dat het ook voorkwam dat er dubbele documenten in het systeem terechtkwamen."
                            ]
                        },
                        {
                            "order": 4,
                            "title": "Doorzetten",
                            "subparagraphs": [
                                "Gedurende het project ging ik ervan uit dat het eerste programma, de mailbox-applicatie, uiteindelijk niet naar behoren werkte. Ik kreeg namelijk verschillende errors en waarschuwingen te zien, wat mij deed concluderen dat er iets structureel mis was. Pas tegen het einde van het project besloot ik er toch nog eens goed naar te kijken, om te zien of het probleem alsnog op te lossen was.",
                                "Tot mijn eigen verbazing bleek de applicatie eigenlijk gewoon te werken. De problemen die ik had gezien, waren uiteindelijk slechts een aantal kleine foutjes die relatief eenvoudig te verhelpen waren. Deze ontdekking was een mooie les in doorzettingsvermogen: soms lijkt iets kapot, terwijl het probleem uiteindelijk een stuk kleiner is dan gedacht."
                            ]
                        },
                        {
                            "order": 5,
                            "title": "Terugblik",
                            "subparagraphs": [
                                "Helaas ben ik in de loop der tijd het documentatiedossier van dit project kwijtgeraakt, waardoor niet alle details en onderbouwingen van destijds nog beschikbaar zijn.",
                                "Toch blijft Zinra een van de projecten waar ik met veel plezier op terugkijk, juist omdat het een van mijn eerste kennismakingen was met het werken voor een echte opdrachtgever, en omdat het liet zien hoe waardevol het kan zijn om ergens niet te snel de handdoek in de ring te gooien."
                            ]
                        }
                    ],
                    "specifications": [
                        {"spec": "SMTP (Simple Mail Transfer Protocol)", "category": "PROTOCOL"},
                        {"spec": "Bag of Words", "category": "SOFTWARE"},
                        {"spec": "Beslisboom", "category": "SOFTWARE"},
                    ],
                    "contributors": [
                        {
                            "name": "A. Oomen",
                            "git_url": "https://github.com/Znooptokkie",
                            "git_image": "contributors/oomen_git_avatar.jpeg"
                        },
                        {
                            "name": "R. van Putten",
                            "git_url": "https://github.com/SanzoVP",
                            "git_image": "contributors/putten_git_avatar.jpeg"
                        },
                        {
                            "name": "B. Diker",
                            "git_url": "https://github.com/bdiker61",
                            "git_image": "contributors/diker_git_avatar.png"
                        },
                        {
                            "name": "M. Cifci",
                            "git_url": "https://github.com/mohammedcifci",
                            "git_image": "contributors/cifci_git_avatar.jpeg"
                        }
                    ]
                },
            ]

            # =================
            # PARAGRAPHS
            # =================
            def create_paragraphs(project, paragraphs):
                for p in paragraphs:
                    para_obj = Paragraph.objects.update_or_create(
                        project=project,
                        order=p["order"],
                        defaults={"title": p["title"]}
                    )[0]
                    for i, sub in enumerate(p["subparagraphs"], start=1):
                        SubParagraph.objects.update_or_create(
                            paragraph=para_obj,
                            order=i,
                            defaults={"content": sub}
                        )

            # =================
            # LOOP PROJECTS
            # =================
            for project_data in projects_data:
                proj, _ = Project.objects.update_or_create(
                    link=project_data["link"],
                    defaults={
                        "title": project_data["title"],
                        "description": project_data["description"],
                        "year": project_data["year"],
                        "github": project_data["github"],
                        "featured": project_data["featured"],
                        "in_progress": project_data["in_progress"],
                    }
                )

                # Koppeltabel: languages
                for lang_name in project_data.get("languages", []):
                    ProjectLanguage.objects.get_or_create(
                        project=proj,
                        language=language_objs[lang_name]
                    )

                # Koppeltabel: frameworks
                for frame_name in project_data.get("framework", []):
                    ProjectFramework.objects.get_or_create(
                        project=proj,
                        framework=framework_objs[frame_name]
                    )

                # Contributors
                for contributor_data in project_data.get("contributors", []):
                    contributor_obj, _ = Contributor.objects.update_or_create(
                        name=contributor_data["name"],
                        defaults={
                            "git_url": contributor_data["git_url"],
                            "git_image": contributor_data["git_image"],
                        }
                    )

                    ProjectContributor.objects.get_or_create(
                        project=proj,
                        contributor=contributor_obj
                    )

                for spec in project_data.get("specifications", []):
                    spec_obj, _ = Specification.objects.update_or_create(
                        specification=spec["spec"],
                        defaults={
                            "category": spec["category"],
                            "svg_url": spec.get("svg_url"),
                        }
                    )
                    ProjectSpecification.objects.get_or_create(
                        project=proj,
                        specification=spec_obj
                    )


                # Images
                for img in project_data.get("images", []):
                    Image.objects.update_or_create(
                        project=proj,
                        image_url=img["image_url"],
                        defaults={"alt_text": img["alt_text"], "is_main_image": img["is_main_image"], "is_logo": img["is_logo"]},
                    )

                create_paragraphs(proj, project_data.get("paragraphs", []))

            self.stdout.write(self.style.SUCCESS("Seed core data succesvol uitgevoerd!"))

        except Exception as e:
            self.stdout.write(self.style.ERROR(f"Seed mislukt: {e}"))
