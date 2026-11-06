## Sectie: Introductie

- **Doel:** bezoekers in één oogopslag laten zien wie ik ben en dat ik cum laude ben afgestudeerd, en ze doorsturen naar projecten, mijn profiel, mijn LinkedIn en mijn GitHub.
- **Inhoud:** vast, in Blade. Geen database.
  - Korte tekst over het diploma, letterlijk: "Aan mboRijnland in Leiden heb ik de opleiding Software Developer afgerond met de onderscheiding cum laude, als eerste student in de geschiedenis van de opleiding."
  - Afbeelding van mezelf: `public/images/profile/me_HH.webp`. Alt-tekst: "Atilla als challengegever bij de Haagsche Hogeschool voor het project SmartGarden".
  - Linkjes:
    - LinkedIn: externe pagina (https://www.linkedin.com/in/atilla-oomen-3a4b78335), nieuw tabblad met `rel="noopener noreferrer"`.
    - GitHub: externe pagina (https://github.com/znooptokkie/), nieuw tabblad met `rel="noopener noreferrer"`.
    - Over mij: interne link naar de pagina "Over Mij".
  - Twee knoppen:
    - "Projecten": naar de pagina Projecten.
    - "Over Mij": naar de pagina Over Mij.
- **Data:** geen. De externe URL's (LinkedIn, GitHub) staan op één plek in `config/portfolio.php`, niet in de views.
- **Beheer:** geen; ik wijzig tekst en links in de code.
- **Interactie:** alleen de links en knoppen. Geen formulier of filter.
- **Animatie:**
  - De afbeelding van mij is stilstaand.
  - De versiering rondom de afbeelding is decoratief (`aria-hidden="true"`) en draait langzaam en continu rond de afbeelding. Eén rondje duurt 30 seconden.
  - Bij `prefers-reduced-motion` draait de versiering niet.
- **Randgevallen:**
  - Ontbreekt de afbeelding, toon dan alleen de tekst en de knoppen, zonder lege plek.
  - Op mobiel volgt de layout het mobiele frame in Figma.
  - De versiering mag niet buiten het scherm vallen of horizontaal scrollen veroorzaken.
- **Acceptatie:**
  - De pagina toont de tekst, de afbeelding, drie linkjes en twee knoppen.
  - Externe links openen in een nieuw tabblad met `rel="noopener noreferrer"`.
  - "Projecten" leidt naar de Projecten-pagina, de knop "Over Mij" naar de pagina Over Mij.
  - De versiering draait; met reduced motion staat hij stil.
  - De pagina werkt en is leesbaar zonder JavaScript.


## Sectie: Programmeervaardigheden

- **Doel:** bezoekers laten zien welke programmeertalen, tools en concepten ik beheers, met een korte toelichtende tekst.
- **Inhoud:** links vaste tekst in Blade, rechts dynamische kaarten uit de database.
  - **Grote container (links), vaste tekst:** "Ik beschik over een goede basis in meerdere programmeertalen, vooral in **Python**, **PHP** en **JavaScript**. En ik blijf mijn kennis verder uitbreiden." De woorden Python, PHP en JavaScript zijn vetgedrukt (`<strong>`).
  - **Kleine containers (rechts):** twee rijen van vijf kaarten, dus maximaal 10. Elke kaart vertegenwoordigt één `Skill` uit de database, gesorteerd op oplopende primary key (`id`).
- **Opbouw van één kaart:**
  - Linksboven het icoon als SVG, bepaald door het veld `icon`.
  - Daaronder de naam van de vaardigheid.
  - Rechts van de naam een groene beheersingsbalk:
    - De kleur komt uit de CSS-token `--accent` (#2ECC71 als standaardthema).
    - De kleur verandert automatisch wanneer de gebruiker een ander thema kiest.
    - De breedte wordt bepaald door het veld `proficiency` en geeft het beheersingsniveau aan.
    - `proficiency` is een integer tussen 0 en 100, waarbij 100 overeenkomt met een volledig gevulde balk.
    - Claude Code mag voorlopig zelf realistische voorbeeldwaarden voor `proficiency` bepalen. Ik pas deze later zelf aan naar de juiste waarden.
    - De balk is decoratief en heeft een lichte transparantie volgens de waarde in Figma.
  - Onderaan een regel met de subconcepten (frameworks, IDE's en andere gerelateerde technologieën), visueel gescheiden zoals in Figma.
    - Alle eerste regels van de subconcepten beginnen op exact dezelfde verticale positie binnen hun kaarten.
    - Als de subconcepten niet op één regel passen, loopt de tekst door op een tweede regel.
    - Er worden maximaal twee regels getoond. Als de tekst niet binnen twee regels past, wordt het resterende gedeelte afgekapt met een ellipsis (`…`).
    - De hoogte en positie van dit gedeelte staan vast, zodat kaarten onderling gelijk blijven en andere elementen niet verschuiven.
    - Een skill zonder subconcepten behoudt dezelfde kaartindeling, maar toont geen subconcepttekst.
- **Data (Skill):**
  - `name`: verplicht (bijvoorbeeld "Python", "AI", "Docker", "Linux"). Niet uniek, omdat Figma twee SQL-kaarten bevat.
  - `icon`: optioneel, bestandsnaam van de SVG zonder extensie. De SVG-bestanden staan in `resources/svg/skills/` en worden via een Blade-component ingeladen. Sla geen SVG-inhoud op in de database.
  - `display_label`: optioneel, tekstlogo voor tegels zonder icoon (Py, TS, php, Sass).
  - `proficiency`: verplicht, integer tussen 0 en 100. Bepaalt de breedte van de beheersingsbalk.
  - `subconcepts`: optioneel, lijst van teksten (JSON-array, in het model gecast naar een array).
  - Het model heet `Skill`, niet `ProgrammingLanguage`, omdat niet alle vaardigheden programmeertalen zijn.
- **Beheer:** geen beheerpagina; de data komt uit een seeder en wordt rechtstreeks in de code aangepast.
- **Interactie:** geen.
- **Animatie:** geen, tenzij Figma anders toont.
- **Layout-regel:**
  - De rechterkant (beide rijen samen) is exact even hoog als de grote container links.
  - De twee rijen zijn exact even hoog en verdelen de beschikbare hoogte gelijkmatig.
  - De rechterkant behoudt altijd een gridstructuur van twee rijen en vijf kolommen, ook wanneer er minder dan 10 skills aanwezig zijn.
  - Ontbrekende skills laten lege plekken achter. Bestaande kaarten worden niet automatisch groter om deze plekken op te vullen.
  - Alle kaarten binnen dezelfde rij hebben dezelfde hoogte.
  - De kaarten mogen nooit groter worden door hun inhoud.
  - De inhoud wordt binnen de beschikbare ruimte afgekapt wanneer deze niet past.
  - De layout mag niet verschuiven door verschillen in tekstlengte.
- **Randgevallen:**
  - Er zijn minder dan 10 skills: toon alleen de bestaande kaarten. De overige plekken blijven leeg, zonder dat de hoogte of breedte van de bestaande kaarten verandert.
  - Er zijn meer dan 10 skills: toon uitsluitend de eerste 10 op basis van oplopende `id`.
  - Er zijn geen skills: toon de grote container met de tekst en geen foutmelding.
  - Een skill zonder subconcepten: toon geen subconcepttekst, maar behoud de vaste indeling van de kaart.
  - Een ontbrekend SVG-bestand: toon een neutrale, hardcoded SVG-placeholder. Dit mag geen foutmelding of kapotte layout veroorzaken.
  - Op mobiel volgt de layout het mobiele frame in Figma. Behoud daarbij de onderlinge verhoudingen en voorkom horizontale overflow.
- **Toegankelijkheid:**
  - De iconen en de groene beheersingsbalk zijn decoratief (`aria-hidden="true"`).
  - De naam van de vaardigheid staat al als tekst op de kaart.
  - De inhoud blijft leesbaar zonder afhankelijkheid van kleur.
  - De SVG-placeholder is eveneens decoratief.
- **Kleur:** gebruik de CSS-token `--accent` uit `resources/css/app.css`. Gebruik geen hardcoded hex-waarden in componenten.
- **Database:** haal alle skills op met één databasequery, gesorteerd op `id` en beperkt tot maximaal 10 resultaten.
- **Acceptatie:**
  - De tekst toont Python, PHP en JavaScript vetgedrukt.
  - De kaarten staan in oplopende volgorde van `id`.
  - Elke kaart toont het icoon, de naam, de beheersingsbalk en eventuele subconcepten.
  - De breedte van de beheersingsbalk komt overeen met `proficiency`.
  - De kleur van de beheersingsbalk volgt de actieve themakleur.
  - Claude Code vult voorlopig zelf realistische `proficiency`-waarden in.
  - Alle eerste regels van de subconcepten beginnen op dezelfde hoogte.
  - Subconcepten worden maximaal over twee regels getoond en daarna afgekapt met een ellipsis.
  - De rechterkant is exact even hoog als de grote container.
  - De gridstructuur blijft twee rijen en vijf kolommen, ook bij minder dan 10 skills.
  - Met 0, 3 of 12 skills in de database breekt de layout niet.
  - Een ontbrekend SVG-bestand wordt vervangen door een neutrale SVG-placeholder.
  - De sectie gebruikt één databasequery voor alle skills.


## Sectie: Tijdlijn

- **Doel:** bezoekers informeren over de keuzes die ik gedurende mijn leven heb gemaakt, met de nadruk op mijn schoolervaring, mijn opleiding en de redenen waarom ik bepaalde keuzes wel of niet heb gemaakt.
- **Inhoud:** vijf vaste containers met ieder een eigen onderdeel van mijn persoonlijke verhaal. Alle inhoud is statisch en wordt rechtstreeks in Blade geplaatst. Er wordt geen database gebruikt.
- **Structuur van de tijdlijn:**
  - Links van de vijf containers staat een verticale, genummerde tijdlijn.
  - Iedere container heeft een eigen bolletje op de tijdlijn.
  - Vanuit ieder bolletje loopt een verticale verbindingslijn naar beneden, die aansluit op de volgende stap in de tijdlijn.
  - Rechts van ieder bolletje staat het bijbehorende nummer, beginnend bij `01` en oplopend tot `05`.
  - Onder het nummer staat in één woord het onderwerp van de betreffende container.
  - De bolletjes, nummers, onderwerpen en verbindingslijnen moeten visueel correct uitgelijnd zijn met de bijbehorende containers.
  - De verticale verbindingslijn sluit aan op de volgende stap. Bij de laatste container eindigt de lijn onderaan de container.
  - Geometrie van de verbindingslijn op tablet en mobiel (Figma: connector-line `98:8852` en `98:9109`, x 5, y 12, lengte tot 44 px onder de markercel): de lijn begint op de bovenkant van het bolletje van stap N en eindigt op de bovenkant van het bolletje van stap N+1, dus 44 px onder de markercel (32 px tijdlijnafstand + 12 px). Het bolletje is 11 px en de lijn zit op het midden daarvan (x 5). Op desktop is dit niet gewijzigd.
- **Opbouw van één container:**
  - **Bovenste regel:** bestaat uit een icoon, een titel en vijf decoratieve schuine strepen.
    - Links staat een icoon dat past bij het onderwerp van de container.
    - Naast het icoon staat de titel.
    - Rechts van de titel staan vijf decoratieve schuine strepen die de positie van de container in de tijdlijn aangeven.
    - Alle onderdelen staan op dezelfde horizontale regel.
    - De vijf strepen hebben een vaste vorm en afmeting.
    - Het aantal ingekleurde strepen komt overeen met de positie van de container:
      - Container 1: één ingekleurde streep.
      - Container 2: twee ingekleurde strepen.
      - Container 3: drie ingekleurde strepen.
      - Container 4: vier ingekleurde strepen.
      - Container 5: vijf ingekleurde strepen.
    - De ingekleurde strepen gebruiken de main color van het standaardthema.
    - De overige strepen zijn zichtbaar, maar hebben een gedempte kleur.
  - **Verhaal:** onder de bovenste regel staat de tekst die bij de betreffende container hoort.
    - De tekst bestaat uit meerdere paragrafen.
    - Bepaalde woorden of zinsdelen zijn vetgedrukt en krijgen de main color van het standaardthema.
    - Gebruik hiervoor semantische HTML (`<strong>`).
    - De paragrafen behouden de onderlinge witruimte en tekstindeling zoals weergegeven in Figma.
- **Data:** geen. Alle vijf containers, titels, iconen, onderwerpen en teksten staan vast in Blade. Er worden geen databasequeries uitgevoerd.
- **Beheer:** geen beheerpagina. Aanpassingen aan de inhoud gebeuren rechtstreeks in de Blade-code.
- **Interactie:** geen. De tijdlijn is uitsluitend bedoeld om informatie te presenteren.
- **Animatie:** geen, tenzij Figma anders toont.
- **Layout-regel:**
  - De tijdlijn links en de vijf containers rechts vormen samen één samenhangende layout.
  - Iedere tijdlijnstap moet verticaal overeenkomen met de bijbehorende container.
  - De verbindingslijnen sluiten visueel aan op de bolletjes en lopen langs de volledige hoogte van de bijbehorende tijdlijnstappen.
  - De vijf containers behouden dezelfde vormgeving en onderlinge structuur.
  - De bovenste regel van iedere container blijft horizontaal uitgelijnd.
  - De vijf decoratieve strepen blijven rechts van de titel staan, zonder dat ze de titel of het icoon verdringen.
  - Lange titels mogen de layout niet laten overlopen of horizontaal laten scrollen.
  - De tekst mag de container niet buiten de beschikbare breedte laten groeien.
- **Randgevallen:**
  - Alle vijf containers worden altijd getoond, in de vaste volgorde van 01 tot en met 05.
  - Een lege paragraaf of ontbrekende tekst mag geen onnodige lege ruimte veroorzaken.
  - Lange teksten moeten netjes doorlopen naar volgende regels.
  - Op mobiel volgt de layout het mobiele frame in Figma. De tijdlijn en containers moeten daarbij correct uitgelijnd blijven.
  - Er mag geen horizontale overflow ontstaan.
- **Toegankelijkheid:**
  - De iconen, bolletjes, verbindingslijnen en decoratieve schuine strepen zijn decoratief (`aria-hidden="true"`).
  - De nummers, onderwerpen, titels en verhalen blijven beschikbaar als normale tekst.
  - De nadruk op woorden mag niet uitsluitend afhankelijk zijn van kleur; gebruik ook `<strong>`.
  - De volledige inhoud moet leesbaar en bruikbaar blijven zonder JavaScript.
- **Kleur:** gebruik de bestaande CSS-token voor de main color van het standaardthema. Controleer hiervoor `resources/css/app.css` en gebruik geen hardcoded hex-waarden in componenten.
- **Besluiten van de opdrachtgever (implementatie):**
  - De stats-rij (31 jaar oud, 5 jaar ervaring, 6 projecten voltooid, 90 leetcode opgelost) staat in Figma, maar is voorlopig weggelaten omdat de cijfers nog niet zijn bevestigd.
  - De stage-kaarten Webprepare (eerste stage) en Battlebot (laatste stage) horen bij tijdlijnstap 04 (Praktijk). De kaarten zijn statisch in Blade.
  - De twee SQL-kaarten staan in Figma allebei als "SQL" en blijven zo. Daarom mag de naam van een skill niet uniek zijn; zie het Skill-model hieronder.
  - De Figma-tegels Py, TS, php en Sass zijn tekstlogo's en geen SVG-iconen. Het veld `display_label` bevat de tekst voor deze tegels; `icon` is dan leeg.
  - De beheersingsbalk is in Figma een vaste streep van 12 px. De vulling binnen die streep is `proficiency` in procent.
- **Acceptatie:**
  - Er worden exact vijf containers getoond.
  - De containers staan in de juiste volgorde van 01 tot en met 05.
  - Iedere container heeft een eigen bolletje, nummer en onderwerp op de tijdlijn.
  - De verticale verbindingslijnen sluiten correct aan op de tijdlijnstappen.
  - Iedere container toont een icoon, titel, vijf decoratieve schuine strepen en het bijbehorende verhaal.
  - Het aantal ingekleurde strepen loopt op van één bij de eerste container tot vijf bij de laatste container.
  - De ingekleurde strepen gebruiken de main color van het standaardthema.
  - Vetgedrukte woorden gebruiken `<strong>` en de main color van het standaardthema.
  - De bovenste regel van iedere container blijft correct uitgelijnd.
  - De tijdlijn en containers blijven correct uitgelijnd op mobiel.
  - De layout veroorzaakt geen horizontale overflow.
  - Alle inhoud is statisch en er worden geen databasequeries uitgevoerd.
  - De volledige sectie werkt en is leesbaar zonder JavaScript.

## Implementatie-verificatie (afmetingen)

Gemeten in de browser (light en dark) en vergeleken met de Figma-metadata. Stats-rij uitgesloten.

- Desktop 1810: hero y 158 / h 580; hero-tekst x 195 w 720; portret x 1215 y 246; skills y 788 h 500 (dark 576); tijdlijn y 1338 h 2380; footer h 41 (dark 30). Afwijking maximaal 3 px.
- Tablet 834: hero h 538 (Figma 537); hero-naam 62 px, letter-spacing -3 px, één regel; skills h 757 licht / 761 donker (Figma 761); footer h 29.
- Mobiel 390: hero h 882 (Figma 882); hero-naam 66 px, letter-spacing -3 px, twee regels; skills-kop 36 px; tijdlijn h 4762 (Figma 4762); footer h 86.
- Tijdlijnkaarten tablet: totale hoogte 2792 tegen Figma 2910 (-118 px). De kaartenhoogten verschillen per kaart (tekstafbreking); niet opgelost.
- Mobiel skills-kop: 116 px tegen Figma 130 px; de aside "{ }" valt onder de titel.

Niet visueel vergeleken met alle zes Figma-screenshots: de homepage is nog niet als visueel gecontroleerd gemarkeerd.

## Visuele verificatie (stand na de laatste ronde)

**Status: niet als visueel gecontroleerd gemarkeerd.** Niet alle zes varianten zijn volledig visueel met Figma vergeleken.

Gemeten in de browser (light en dark) en vergeleken met de Figma-metadata. De stats-rij is uitgesloten.

- **Desktop**: skills op y 788 (licht 500 px, donker 576 px), tijdlijn op 1338 (kaarten binnen 3 px van Figma), footer 41 px (donker 30 px). Overflow: geen.
- **Tablet**: hero 538 px (Figma 537), skills 761 px in beide thema's (Figma 761). Tijdlijnkaarten 612 / 483 / 786 / 509 / 411 px tegen Figma 612 / 482 / 786 / 492 / 410 px. Kaart 4 (stages) is 17 px te hoog. Footer 29 px.
- **Mobiel**: hero 882 px (Figma 882), skills 1413 px (Figma 1413), skills-kop 131 px (Figma 130), tijdlijnkop 92 px (Figma 92), tijdlijn 4667 px (Figma 4762), footer 86 px. Tijdlijnkaarten 851 / 646 / 1232 / 761 / 551 px tegen Figma 863 / 687 / 1296 / ? / 565 px. De afwijking zit in de regelafbreking van de alinea's.

Visueel vergeleken met Figma (screenshot-zijvergelijking, of uitsnede):
- Desktop light: volledige pagina, geen grote afwijkingen zichtbaar.
- Tablet light: tijdlijn, kaartkop (icoon boven de titel, voortgangsstrepen rechts), milestones 11 px.
- Mobiel light: tijdlijn-kaart 2, regelafbreking verschilt nog.
- Hero (desktop light): portretring, 12 orbit-ticks (vier groen), stilstaand (animatie uit via reduced motion).

Nog niet visueel vergeleken: desktop dark, tablet dark, mobiel dark, de skills-secties op tablet en mobiel, en de hero op tablet en mobiel.

**Oorzaken die in deze ronde zijn opgelost**
- Tablet-kaartkop was een rij; Figma is een kolom (icoon, daaronder titel).
- Kaartinhoud was 2 px te smal door de rand; nu 574 px (tablet) en 274 px (mobiel), zoals Figma.
- Dark-mode en tablet/mobiel gebruikten dezelfde onderkant-padding; nu per breakpoint.
- `prefers-reduced-motion` werd genegeerd omdat JavaScript altijd `data-motion="on"` zette.
- Orbit-element gebruikte procentuele waarden die in de browser niet de Figma-maat (352 px) gaven.
- De 4 px- en 13 px-verschillen in de skills-sectie kwamen van een dubbele padding-regel op donker.

**Nog openstaand**
- Mobiele tijdlijnkaarten: 2 tot 64 px per kaart korter dan Figma. Figma heeft per alinea soms één regel meer; de oorzaak is niet met zekerheid vastgesteld.
- Tablet-tijdlijn kaart 4 (stages): 17 px te hoog.
- Het donkere-thema-verschil in de Figma-tijdlijn (afwijkende scheidingen) is niet nagemeten.
- Stats-rij en de "Figma-only" elementen zijn niet in de vergelijking opgenomen.

### Stand na de navigatie- en tijdlijnronde

- **Visueel vergeleken met Figma (screenshot-zijvergelijking of uitsnede)**: desktop light (volledige pagina), desktop dark (bovenste deel: hero en skills), tablet light (tijdlijn en kaartkop), mobiel light (tijdlijnkaart 2), hero desktop light (portretring en ticks).
- **Nog niet visueel vergeleken**: tablet dark, mobiel dark, tablet/mobiel hero, mobiele skills-sectie (alleen uitsnede gegenereerd), en de volledige tijdlijn op tablet en mobiel.
- **Tijdlijn tablet**: kaarten 612 / 483 / 786 / 509 / 411 px tegen Figma 612 / 482 / 786 / 492 / 410 px. Kaart 4 (stages) 17 px te hoog. Oorzaak: stage-kaarten hebben hogere tekstblokken.
- **Tijdlijn mobiel**: 4667 px tegen 4762 px. Figma heeft per alinea soms één regel meer. Oorzaak niet vastgesteld; geen vaste hoogtes toegepast.
- **Status**: de homepage is **niet** volledig visueel gevalideerd en is niet als gecontroleerd gemarkeerd.

### Stand na de visuele validatieronde (tablet donker, mobiel donker, tijdlijn)

**Status: niet als visueel gecontroleerd gemarkeerd.** Niet alle zes Figma-frames zijn volledig vergeleken (zie onder).

Vergeleken met Figma (zijvergelijking per 1200 px, stats-rij uit het Figma-beeld verwijderd):
- **Tablet donker (98:9250)**: volledige pagina vergeleken. Opgelost: surface-kleur donker (#000b1d i.p.v. #0b1120) voor kaarten en skill-kaarten; quote-vlak donker navy i.p.v. groen; ondertitel "Junior Developer" donker grijs (#525252); portret 100 px te hoog (nu margin-top 112 px, orbit op y 218 zoals Figma); stage-kaarten met rand (#2a2a2a), 277 px breed, 20 px tussenruimte, logo 48 px, padding 20/24, tekst op Figma-positie; tijdlijnkop "// stap door de tijd"; skill-beschrijvingen niet meer afgeknipt (flex-shrink); "Electron" verwijderd uit TypeScript (Figma toont "React - Vue - React Native"); "Figma MCP" toegevoegd bij AI.
- **Tablet licht (98:8633)**: deels vergeleken (kaartgrootte, hero-positie, stage-rand op transparant gezet omdat Figma licht geen zichtbare rand toont). Volledige zijvergelijking nog niet gedaan.
- **Mobiel donker (98:9556)**: volledige pagina vergeleken. Opgelost: tijdlijn-rail zichtbaar (x 31, loopt naar volgende dot); kaarten ingesprongen 28 px en padding 20 px (Figma: kaart x 52, breedte 314); dubbele `.story-card`-padding (24 px) verwijderd; stage-padding 20 px; hero-knoppen gecentreerd met padding 18 px. Kaarthoogten nu 897/693/1306/715/570 tegen Figma 863/687/1296/≈697/565.
- **Desktop donker (98:11339)**: volledige pagina vergeleken (segmenten). Dezelfde surface- en quote-correcties gelden; de stage-kaarten en Electron-correctie zijn ook van toepassing.
- **Mobiel licht (98:8939)**: niet vergeleken. De Figma-download uit de vorige ronde is gebruikt; de MCP-limiet bereikte bij deze aanroep.
- **Desktop licht**: alleen regressie-check (eerder volledig vergeleken).

**Nog open**
- E-mail-icoon in de hero (tablet, mobiel en desktop): Figma toont het, de implementatie niet. Er is geen e-mailadres in `config/portfolio.php`; asset `EmailIcon.svg` bestaat wel. Niet toegevoegd om geen functionaliteit te verzinnen.
- Mobiele tekstafbreking: Figma-tekst is ca. 1% smaller dan de browser-tekst (16 px). Daardoor breekt in tijdlijnkaart 1 één regel anders ("Omdat ik schilder werd, koos ik voor"). Kaarthoogten wijken daardoor 7 tot 34 px af. Geen letter-spacing-hack toegepast.
- Lokale database: de wijzigingen in `SkillSeeder` (AI, TypeScript) worden pas zichtbaar na `php artisan migrate:fresh --seed` of een handmatige update.
- Tijdlijnkaart 2 op tablet is 1 px hoger dan Figma (483 tegen 482); kaart 5 1 px (411 tegen 410).
- Desktop donker: enkele tekstafbrekingen in de tijdlijnkaarten wijken af (Figma-wrap); niet opgelost.
- Mobiel totaal tijdlijn 4834 tegen Figma 4762 (+72 px, verdeeld over de kaarten, zie hierboven).

**Meting skills-kop mobiel**: hero 882 px, skills 1413 px en footer 86 px komen overeen met Figma.

### Stand na de afrondingsronde

**Status: OPEN.** De homepage is niet als visueel gecontroleerd gemarkeerd.

- **E-mailicoon (hero):** staat tussen LinkedIn en GitHub, met de `emailIcon.svg` (light) en `EmailIcon.svg` (dark). Zolang `config('portfolio.links.email')` leeg is, is het icoon niet-interactief (`aria-hidden`). Met een ingevuld adres wordt het een `mailto:`-link met aria-label "E-mail"/"Email". Er is geen fictief adres ingevuld.
- **SkillSeeder:** idempotent via `updateOrCreate` op name + icon. Databasestand vóór: 10 rijen, TypeScript bevatte "Electron", AI miste "Figma MCP". Na één run van de seeder: 10 rijen, geen duplicaten, TypeScript zonder Electron, AI met "Claude Code" en "Figma MCP". Homepage-HTML toont "Figma MCP" en geen "Electron". Tests in `tests/Feature/SkillTest.php` en `HomePageTest.php` dekken dit af.
- **Visuele validatie:** de Figma-MCP-limiet op het Starter-plan is bereikt, dus er konden geen verse frames worden opgehaald. Gebruikt zijn de bestaande exports in `/tmp/figma-analysis/`. Volledige zijvergelijkingen van alle zes frames zijn NIET afgerond; alleen het donkere desktop-frame is deels bekeken (hero en begin skills). Overige frames: open.
- **Mobiele tijdlijn (4834 px tegen 4762 px):** niet opgelost. Oorzaak nog niet vastgesteld; geen vaste hoogtes toegepast.
- **Accentkleuren:** `--accent-soft` en `--accent-strong` zijn nu afgeleid van `--accent` via `color-mix`. De JavaScript-override van `--accent-strong` is verwijderd. Groene assets zijn dynamisch gemaakt (SVG via `currentColor`, monochrome PNG als mask, de stage-logo's geïsoleerd als uitzonderingen). De uitzonderingen en contrastregels staan in `docs/design-system.md`. Tekst op accentvlakken gebruikt `--accent-ink`, tags gebruiken `--accent-ink-soft`; de tags wijken daarmee af van het oorspronkelijke groene tekstgebruik en vragen een Figma-controle.
- **Controles:** `npm run build` en `composer check` slagen. Alle zes varianten: geen horizontale overflow en geen consolefouten (fullshots.js). menu.js, close.js, interact.js en popover.js: zonder foutmeldingen.

### Stand na de tijdlijn- en menucorrectie (tablet en mobiel)

- **Tijdlijn**: de verbindingslijn op tablet en mobiel stond verkeerd. De oude waarden (top 27 px, bottom -59 px, left 7 px) lieten de lijn volgens berekening 4 px onder het bolletje van stap N beginnen, 4 px onder het bolletje van stap N+1 eindigen en 2 px naast het midden van de 11 px bolletjes lopen (berekend uit de CSS-waarden, niet vóór de wijziging in de browser gemeten). Nu: top 12 px, bottom -44 px, left 5 px. Gemeten (834 en 390 px, light en dark): begin van de lijn = bovenkant bolletje N, einde = bovenkant bolletje N+1, midden van de lijn = midden van het bolletje. Stap 05 heeft geen lijn. Desktop niet gewijzigd.
- **Menu tablet en mobiel**: zie `docs/components/header.md` (5.1a). Paneel past nu binnen de viewport, scheidingslijnen blokkeerden klikken op menulinks en zijn gecorrigeerd.
- **Buiten scope, niet aangepast**: horizontale overflow bij gesloten menu op 481 tot 834 px komt van de hero-portretring (`portrait__orbit`, documentbreedte 804 px op 600 px) en van de internship-kaarten (rechterrand 661 px op 600 px). Dit valt buiten de twee gevraagde correcties. *(Opgelost in de responsive-audit, zie hieronder.)*
- **Status**: blijft OPEN. Figma-MCP was op limiet; de zes varianten zijn niet allemaal visueel vergeleken.

## Responsive-audit

Gecontroleerd: homepage (`/`) met hero, skills, tijdlijn (incl. internships), footer, header (gesloten en geopend menu, taal- en voorkeurenpopover) in light en dark. Breedtes (light en dark): 320, 340, 360, 375, 390, 414, 430, 480, 481, 500, 560, 600, 640, 641, 700, 720, 721, 738, 768, 800, 834, 835, 880, 899, 900, 1000, 1024, 1100, 1199, 1279, 1280, 1366, 1440, 1600, 1810, 1920. Breakpoints en vloeiende maten staan in `docs/design-system.md` (Breakpoints en Vloeiende maten).

### Gevonden problemen (vóór de audit)

- **320 px**: documentbreedte 350 px. Oorzaak: het portret had vaste px-maten (orbit 300 px, frame 248 px) in een portret van 272 px.
- **481 tot 800 px (gesloten menu)**: documentbreedte 807 tot 809 px. Oorzaak: de tablet-hero-rij had vaste breedtes (tekst 410 px + tussenruimte 32 px + portret 312 px + marges 80 px = 834 px), die in een smallere viewport niet pasten.
- **835 tot 1100 px**: documentbreedte 1328 tot 1459 px. Oorzaak 1: de desktop-hero had vaste breedtes (720 + 300 + 400 px) en een vaste marge van 112 px. Oorzaak 2: de desktopnavigatie (677 px) paste niet naast het logo; de navigatie stond tot 940 px op een viewport van 835 px.
- **1366 tot 1440 px**: documentbreedte 1531 px, door dezelfde hero-maten.
- **Skills, 481 tot 1279 px**: het 5-koloms grid kreeg kolommen van 71 px (481 px), 86 px (1100 px) en 62 px (1200 px). Skill-namen werden afgekapt ("…").
- **Internships, 481 tot 835 px**: de kaartrand lag op 661 px bij een viewport van 600 px. Oorzaak: kolommen `1fr` met een min-content die groter was dan de kolom, en een naam (bijv. "Webprepare") die niet kon breken.
- **Menu geopend, 320 en 360 px**: de navigatielinks en scheidingslijnen waren 340 px breed, dus 47 px (320) en 7 px (360) horizontale overflow.
- **Mobiele popovers (390 px)**: taalpopover y 339 tot 462; voorkeurenpopover y 339 tot 544. Dit is niet afgeknipt en blijft binnen de viewport. Zie open punten.

### Structurele oplossingen

- **Portret in `cqw`**: alle geometrie van de versiering en de foto is procentueel ten opzichte van de portretbreedte (`container-type: inline-size`). Desktop-maten (400 px) geven exact dezelfde px-waarden als voorheen.
- **Hero-rij fluid**: tekst, portret en tussenruimte zijn `clamp()`-waarden die op 1810 px de Figma-maten geven. De contentmarge is `clamp(40px, …, 112px)`.
- **Hero gestapeld tot 720 px**: onder 720 px staat het portret boven de tekst, zoals in het mobiele ontwerp. De breekgrens is de plek waar de rij met de minimale kolombreedtes (naam, portret) niet meer past.
- **Header-breekpunt 899/900 px**: het tablet/mobiele menu geldt tot 899 px in plaats van 834 px. Het tablet-paneel vult de header (`width: 100%`). Dit volgt header.md (5). De header-regels staan nu in één blok vóór de compacte en mobiele blokken.
- **Skills**: tot 1279 px gestapeld (quote boven het grid). Het grid is 5 kolommen vanaf 835 px, daaronder `repeat(auto-fit, minmax(140px, 1fr))`. Mobiel: 2 kolommen. Skill-kaartpadding `clamp(16px, 5.13vw, 20px)` (390 px ongewijzigd: 20 px).
- **Tijdlijn**: markerkolom `clamp(100px, …, 192px)`; onder 720 px gestapeld. Internships: `repeat(2, minmax(0, 1fr))`, `.internship-card__org` met `flex-wrap`, en `overflow-wrap: anywhere` op de naam als laatste vangnet.
- **Knoppen**: `.hero__actions` met `flex-wrap`, `.button` met `white-space: nowrap` (op 320 px stonden "Over Mij" en de pijl anders op twee regels).
- **Globale `overflow-x: hidden` op `body` en `overflow-x: clip` op de header zijn verwijderd.** Er is geen verbergmiddel meer; de metingen zonder die regels laten geen overflow zien.

### Resultaat

- Horizontale overflow: geen (documentbreedte gelijk aan viewport, op alle bovenstaande breedtes in light en dark). Geen afgeknipte tekst, geen overlappende elementen in hero, skills, header en tijdlijn. Geen consolefouten.
- Ontworpen breedtes ongewijzigd: de rechthoeken van hero, portret, skills, tijdlijn en footer op 1810 px en 834 px zijn identiek aan de voorgaande meting. Op 390 px ook identiek, behalve de verplichte wrap van de knoppen (alleen 320 px).
- Gemeten: menu geopend 320/360/375/390/834 px en 835/880 px (paneel = viewport, geen spill); popovers open op alle breedtes.
- **Visueel bekeken** (screenshots, light en dark): 320, 390 (dark), 600, 721, 738, 834 (light), 880 (menu), 1024, 1280, 1920 (dark); skills op 320 en 1280; tijdlijn en internships op 600, 1024 en 320.

### Open punten

- **Mobiele popovers (390 px)**: de voorkeurenpopover loopt tot y 544, buiten het groene paneel (377 px). Figma geeft geen positie voor mobiele popovers. De popover blijft binnen de viewport en wordt niet afgeknipt; de keuze voor een overlay of een uitklapbaar paneel vraagt een ontwerpbesluit.
- **Tablet-paneel driehoek**: op 834 px op 417 px (bewuste keuze, zie header.md 5.1a).
- **Figma-validatie**: de Figma-MCP zit op limiet. De zes varianten zijn niet volledig tegen Figma vergeleken; de beoordeling hierboven is op de eigen screenshots en de metingen. De homepage is daarom niet als visueel gecontroleerd gemarkeerd.
- **Skills-kop `{ }`**: de aside van de skills-sectie toont de letterlijke tekst "{ }" (bestaand, niet door deze audit veroorzaakt; inhoudelijke beslissing).
- **Overige bestaande punten** (tijdlijn-regelafbreking, stage-kaart hoogte, e-mailicoon): ongewijzigd, zie eerdere secties.

