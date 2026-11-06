# Header

## Doel

De header is de gedeelde navigatiebalk van de website. Bezoekers kunnen hiermee naar de verschillende pagina's navigeren en de weergave en toegankelijkheidsinstellingen van de website aanpassen.

De header wordt op iedere pagina hergebruikt via de centrale Laravel Blade-layout. De header zelf bevat geen pagina-specifieke inhoud.

## Algemene opbouw

De header bestaat uit drie onderdelen:

1. **Links:** website-logo en naam.
2. **Midden/rechts:** navigatielinks.
3. **Uiterst rechts:** drie instellingenknoppen.

De volledige header volgt de drie beschikbare Figma-ontwerpen: desktop, tablet en mobiel.

De headerinhoud staat binnen dezelfde centrale contentcontainer als de rest van de website. Deze container heeft een vaste maximale breedte en mag nooit breder worden dan de vastgestelde maximale contentbreedte. Op kleinere schermen schaalt de inhoud mee binnen de beschikbare ruimte, met behoud van de marges volgens Figma.

De headerachtergrond mag, indien dit overeenkomt met Figma, wel over de volledige schermbreedte doorlopen.

## 1. Logo en naam

Links in de header staan:

- Het logo van de website.
- Rechts naast het logo de naam **Atilla Oomen**.

Het logo en de naam vormen samen één herkenbaar geheel.

De exacte afmetingen, onderlinge afstand, uitlijning en vormgeving volgen Figma.

## 2. Navigatie

Rechts van het logo en de naam staan vier navigatielinks:

1. Opleidingen
2. Projecten
3. Over Mij
4. Leetcode

Iedere link is bedoeld om naar een eigen pagina te navigeren.

De betreffende pagina's worden later ontwikkeld. Voor nu hoeven deze links nog niet naar bestaande pagina's te verwijzen. Gebruik daarom tijdelijke, niet-werkende bestemmingen. Verzin geen pagina's of routes.

De navigatielinks staan horizontaal naast elkaar en zijn rechts uitgelijnd.

Rechts van de vier navigatielinks staat een verticale scheidingslijn. Deze scheidt de navigatie visueel van de instellingenknoppen.

De exacte afmetingen, tussenruimtes, typografie en vormgeving volgen Figma.

## 3. Instellingenknoppen

Rechts van de verticale scheidingslijn staan drie vierkante, aanklikbare knoppen. Iedere knop bevat een icoon.

De drie knoppen hebben de volgende functies:

1. Dark mode / Light mode.
2. Taal kiezen.
3. Websitevoorkeuren aanpassen.

De knoppen staan horizontaal naast elkaar en hebben dezelfde afmetingen.

### 3.1 Dark mode / Light mode

De meest linkse knop schakelt tussen de donkere en lichte weergave van de website.

- De knop bevat een passend icoon.
- Bij iedere klik wisselt de website tussen dark mode en light mode.
- De volledige website moet zich aanpassen aan het gekozen thema, niet alleen de header.
- De bestaande kleurvariabelen en themastructuur moeten hiervoor worden gebruikt.
- De gekozen instelling blijft behouden wanneer de bezoeker naar een andere pagina navigeert of de website opnieuw opent.

Gebruik de bestaande CSS-variabelen en themastructuur. Voeg geen afzonderlijke, hardcoded kleuren toe aan componenten.

### 3.2 Taal kiezen

De middelste knop opent een praatwolkje (popover) met een pijltje dat naar de betreffende knop wijst.

De titel van het praatwolkje is:

**Taal Kiezen**

De bezoeker kan kiezen uit twee talen:

- Nederlands
- Engels

Nederlands is standaard geselecteerd.

Bij het selecteren van een taal moet de volledige website naar de gekozen taal worden vertaald. Dit geldt voor alle pagina's, navigatie, knoppen, meldingen en overige zichtbare teksten.

De Engelse vertalingen moeten correct en natuurlijk Engels zijn. Gebruik geen automatische vertaling tijdens het laden van de website.

Gebruik de Laravel localization-functionaliteit, zodat vertalingen centraal beheerd kunnen worden. Plaats vertaalbare teksten in de daarvoor bestemde taalbestanden en voorkom dat teksten onnodig rechtstreeks in Blade-templates worden vastgelegd.

De gekozen taal blijft behouden wanneer de bezoeker naar een andere pagina navigeert of de website opnieuw opent.

De exacte vormgeving van het praatwolkje, de taalkeuzes en de geselecteerde status volgt Figma.

### 3.3 Websitevoorkeuren

De meest rechtse knop opent een praatwolkje (popover) met een pijltje dat naar de betreffende knop wijst.

Dit praatwolkje bevat instellingen waarmee bezoekers de vormgeving en toegankelijkheid van de website kunnen aanpassen.

De instellingen zijn verdeeld in twee onderdelen:

#### 3.3.1 Accentkleuren

Hier kan de bezoeker de hoofdkleur (main color) van de website aanpassen.

Standaard gebruikt de website:

`#2ECC71`

De bezoeker kan de kleur op twee manieren aanpassen.

**Vooraf ingestelde kleuren**

Er staan vijf ronde kleurbolletjes naast elkaar.

- Het eerste bolletje bevat de standaardkleur `#2ECC71`.
- De overige vier bolletjes bevatten vooraf ingestelde alternatieve kleuren.
- De bezoeker kan op een bolletje klikken om die kleur als hoofdkleur in te stellen.
- De actieve kleur moet visueel herkenbaar zijn.

De vier alternatieve kleuren worden afgestemd op het Figma-ontwerp.

**Eigen hexkleur**

Naast het woord `Hex` staat een invoerveld waarin de bezoeker zelf een hexadecimale kleurcode kan invullen.

Placeholder:

`#2ECC71`

Bij een geldige hexkleur wordt deze direct toegepast als hoofdkleur van de website.

Houd rekening met:
- Valideer de ingevoerde hexkleur.
- Accepteer geldige hexnotaties.
- Ongeldige invoer mag de huidige kleur niet overschrijven.
- Geef bij ongeldige invoer duidelijk aan dat de kleurcode niet geldig is.
- De ingevoerde kleur moet ook overeenkomen met de actieve kleurselectie.

De gekozen accentkleur wordt via één centrale CSS-variabele toegepast op alle onderdelen die de hoofdkleur gebruiken. Denk aan knoppen, accenten, iconen, lijnen en andere elementen.

De bezoeker moet de accentkleur op iedere pagina op dezelfde manier terugzien.

De standaardkleur blijft `#2ECC71`. De gekozen kleur blijft behouden wanneer de bezoeker naar een andere pagina navigeert of de website opnieuw opent.

#### 3.3.2 Bijzondere opties

Onder de accentkleuren staat het onderdeel **Bijzondere opties**.

Hier staan drie vierkante knoppen horizontaal naast elkaar. De knoppen zijn over de beschikbare breedte verdeeld en bevatten ieder een icoon.

De drie knoppen hebben de volgende functies:

**1. Kleurenblindheidsvriendelijke weergave**

De linkerknop schakelt een kleurenblindheidsvriendelijke weergave in en uit.

Wanneer deze optie actief is, moet de website beter bruikbaar worden voor bezoekers met verschillende vormen van kleurenblindheid.

Houd hierbij rekening met:
- Zorg dat belangrijke informatie niet uitsluitend door kleur wordt overgebracht.
- Gebruik waar nodig aanvullende visuele herkenning, zoals patronen, vormen, iconen of tekstlabels.
- Zorg voor voldoende onderscheid tussen kleuren die voor kleurenblinde bezoekers moeilijk te onderscheiden zijn.
- Behoud de bestaande stijl en vormgeving van de website zoveel mogelijk.
- Zorg dat de aangepaste kleuren voldoende contrast behouden.

Het gaat om een daadwerkelijke toegankelijkheidsimplementatie en niet alleen om het vervangen van enkele kleuren.

**2. Animaties aan/uit**

De middelste knop schakelt animaties en bewegingen op de website in en uit.

- Animaties staan standaard aan.
- De knop is standaard groen om aan te geven dat animaties ingeschakeld zijn.
- Wanneer de bezoeker de optie uitschakelt, worden niet-noodzakelijke animaties en bewegingen uitgeschakeld.
- Houd ook rekening met CSS-transitions, hoveranimaties, bewegende decoratieve elementen en andere visuele bewegingen.
- Functionele overgangen mogen niet leiden tot een onbruikbare interface wanneer animaties uitstaan.

Respecteer daarnaast de systeeminstelling `prefers-reduced-motion`. Wanneer de bezoeker op systeemniveau heeft aangegeven minder beweging te willen, moet de website hier rekening mee houden.

**3. Hoger contrast**

De rechterknop schakelt een verhoogde contrastmodus in en uit.

Wanneer deze optie actief is:
- Wordt het contrast tussen tekst en achtergrond verhoogd.
- Worden belangrijke elementen duidelijker herkenbaar.
- Krijgen knoppen, invoervelden, randen en andere interactieve elementen voldoende contrast.
- Blijft de website goed leesbaar in zowel dark mode als light mode.
- Blijft de algemene vormgeving zoveel mogelijk behouden.

Deze instelling moet daadwerkelijk invloed hebben op de website en niet alleen op het icoon van de knop.

#### 3.3.3 Lettergrootte

Onder de drie vierkante knoppen staat een afzonderlijke instelling voor de lettergrootte.

Deze bestaat uit:
- Een vierkantje met een icoon dat staat voor het vergroten van tekst.
- Rechts daarvan een horizontale slider.

De slider werkt als volgt:
- Helemaal links staat de standaardlettergrootte.
- Naarmate de bezoeker de slider verder naar rechts beweegt, wordt de tekst groter.
- De tekstgrootte wordt direct aangepast wanneer de slider wordt verplaatst.

De vergroting moet op de volledige website worden toegepast.

Houd bij de implementatie rekening met de bestaande layout:
- Teksten moeten netjes kunnen doorlopen naar meerdere regels.
- Containers mogen niet buiten hun maximale breedte komen.
- Knoppen en navigatie-elementen moeten goed uitgelijnd blijven.
- Kaarten en andere componenten moeten voldoende ruimte krijgen voor grotere teksten.
- Voorkom overlappende teksten en elementen.
- Zorg dat de website ook bij de grootste ingestelde lettergrootte bruikbaar blijft.

Wanneer dit nodig is, mogen componenten op basis van de grotere tekstgrootte meer hoogte krijgen of mag de layout zich aanpassen. De maximale contentbreedte blijft echter behouden.

De standaardpositie van de slider is helemaal links.

De exacte vormgeving, afmetingen en verdeling van de instellingen volgen Figma.

## 4. Gedrag en opslag van instellingen

Alle instellingen uit de header gelden voor de volledige website.

De volgende instellingen moeten behouden blijven wanneer de bezoeker navigeert of de website opnieuw opent:

- Dark mode / Light mode.
- Geselecteerde taal.
- Geselecteerde accentkleur.
- Kleurenblindheidsvriendelijke weergave.
- Animaties aan/uit.
- Hoger contrast.
- Lettergrootte.

Gebruik hiervoor een passende centrale oplossing. Voorkom dat iedere pagina afzonderlijk instellingen moet uitlezen of implementeren.

**Implementatiebesluit:** alle voorkeuren worden in `localStorage` opgeslagen (één module, `resources/js/preferences.js`). De taal wordt daarnaast als cookie `locale` gespiegeld, zodat Laravel de juiste vertalingen al server-side kan renderen zonder dat de pagina eerst in de andere taal knippert. Het thema wordt vóór het renderen toegepast met een kort inline script in de layout.

**Ontbrekende light-varianten:** in Figma bestaan het taal- en het Appearance-menu alleen in de dark-variant. De light-variant wordt afgeleid met dezelfde vormgeving en de light-tokens uit `resources/css/app.css`.

De instellingen moeten ook op pagina's die later worden toegevoegd automatisch beschikbaar zijn.

De standaardinstellingen zijn:
- Thema: standaardthema volgens de bestaande websiteconfiguratie.
- Taal: Nederlands.
- Accentkleur: `#2ECC71`.
- Kleurenblindheidsvriendelijke weergave: uit.
- Animaties: aan.
- Hoger contrast: uit.
- Lettergrootte: standaard (slider helemaal links).

## 5. Responsive gedrag

De header moet correct functioneren op alle drie de beschikbare Figma-formaten:

- Desktop.
- Tablet.
- Mobiel.

Gebruik voor ieder formaat het bijbehorende Figma-ontwerp als uitgangspunt.

Houd rekening met:
- De beschikbare horizontale ruimte.
- De positie en uitlijning van het logo en de naam.
- De navigatielinks.
- De drie instellingenknoppen.
- De verticale scheidingslijn.
- De grootte en positionering van de popovers.
- De beschikbare ruimte voor de instellingen binnen de popovers.

Wanneer de volledige desktopnavigatie niet meer binnen de beschikbare ruimte past, moet de header zich aanpassen volgens het tablet- of mobiele Figma-ontwerp.

Verzin geen eigen mobiele navigatie wanneer de oplossing uit Figma kan worden afgeleid.

De header en popovers mogen nooit onbedoeld horizontale overflow veroorzaken.

### 5.1 Mobiele navigatie (implementatie)

Bron: Figma-frames `98:12133` (light) en `98:12075` (dark), en de gesloten header in de mobiele homepage-frames `98:8939` en `98:9556`.

- **Gesloten header** (tot 899 px): logo en naam links, één menuknop rechts (38 × 38 px, drie groene lijnen, Figma-asset `menuButton.svg`). De navigatielinks en de instellingenknoppen zijn dan niet zichtbaar.
- **Openen**: de menuknop opent een paneel van 390 × 377 px, bovenaan de header, met een afgeronde onderkant (25 px). Het paneel bevat het merk, de vier navigatielinks met scheidingslijnen (y 98, 146, 194, 243), de drie instellingenknoppen gecentreerd op y 294, en de groene balk onderaan (23 px) met een chevron op x 203.
- **Sluiten**: met dezelfde menuknop, met Escape, met een klik buiten het paneel, of met de groene balk onderaan. Die balk met de chevron is de sluitbediening (`button`, label "Menu sluiten"); er is geen aparte sluitknop bovenaan. Na het sluiten krijgt de menuknop de focus terug.
- **Toetsenbord**: na openen gaat de focus naar de eerste navigatielink. Tab bereikt de overige links en knoppen binnen het paneel.
- **Thema**: alle kleuren komen uit de tokens `--color-bg`, `--color-text`, `--color-muted`, `--color-border` en `--color-menu-border`. De menulinks gebruiken `--color-menu-link` (light `#546277`, dark `#f3f6fa`).
- **Desktop**: ongewijzigd. Vanaf 900 px zijn de menuknop en het paneel verborgen en staat de navigatie in de header. Het breekpunt (899/900 px) is gekozen waar de desktopnavigatie met logo en instellingen niet meer past; daaronder geldt het tablet-paneel.

**Afwijkingen en besluiten (niet uit Figma af te leiden):**
- De menuknop blijft bovenop het geopende paneel staan, zodat hij ook in open toestand te gebruiken is (label "Menu sluiten"). De groene balk is de sluitbediening, zoals in de opdracht vastgelegd.
- Figma markeert "Projecten" groen. Die markering zit in het divider-SVG van Figma en wordt daarom getoond. De tekstkleur van die link blijft grijs, omdat er geen actieve-paginalogica bestaat.
- Het sluiten bij een klik buiten het paneel is een eigen keuze; Figma beschrijft dit niet.
- De instellingenknoppen in het paneel gebruiken de desktop-iconen, verkleind naar de mobiele maten uit Figma (zon/maan 15 px, taal 10 px, potlood 14 px).
- Popovers (taal en voorkeuren) openen binnen het paneel. Hun positie op mobiel staat niet in Figma.
- Het tablet-frame van de navigatie (`98:11959`, 843 px breed) is niet afzonderlijk uitgelezen; het paneel gebruikt de volledige breedte van de header (834 px).

### 5.1a Tablet- en mobiel menu (bijgewerkt)

- **Tablet (481–899 px)** gebruikt eigen posities uit `98:12017` (light) en `98:11959` (dark): merk op (30, 5), instellingenrij rechtsboven op y 17 (rechts 19 px), linkskolom 595 px breed en gecentreerd op y 108, scheidingslijnen op y 118/166/214/263, groene balk onderaan.
- **Mobiel (≤480 px)** gebruikt de mobiele posities uit `98:12133` / `98:12075`: links op x 36 en y 89, instellingen op y 294, scheidingslijnen op y 98/146/194/243.
- **Tablet-paneel**: het paneel vult de header (`width: 100%`). Op 834 px is het paneel dus 834 px breed (Figma 843 px, begrensd door de viewport), zodat de rechterrand en de onderhoek zichtbaar blijven. Tussen 835 en 899 px groeit het paneel mee. De linkskolom staat op x 124 en de kolom en scheidingslijnen zijn `min(595px, 100% - 143px)` breed: 595 px vanaf een viewport van 738 px, daaronder krimpend. Instellingen blijven 19 px van de rechterrand van het paneel. De driehoek staat op het midden van het paneel (417 px op 834 px), niet op de Figma-coördinaat 421,5.
- **Scheidingslijnen** (`.site-nav__rule`) hebben `pointer-events: none`. Ze lagen over de onderste helft van de menulinks en blokkeerden klikken op die links; gemeten op 834 en 390 px gaf het midden van de link het SVG-element terug in plaats van de link.
- **Popovers op mobiel (390 px)**: het voorkeurenpaneel loopt tot y 544 terwijl het menupaneel 377 px hoog is. Het is niet afgeknipt en blijft in de viewport; Figma geeft geen positie voor mobiele popovers, dus dit is niet aangepast.
- **Groene sluitbalk**: de hele balk (23 px) is een `button` met label "Menu sluiten". De driehoek staat horizontaal gecentreerd en verticaal binnen de balk (top 3 px). De ruwe Figma-coördinaat (x 203 mobiel, x 430 tablet) wijkt af van het visueel gecentreerde beeld; de gecentreerde variant is gekozen.
- **Menuknop**: wordt verborgen zolang het menu openstaat (Figma toont daar geen knop). Sluiten gaat via de groene balk, Escape, of een klik buiten het paneel. Focus gaat terug naar de menuknop.
- **Actieve link**: "Projecten" is in het menu groen (`site-nav__link--menu-active`), overeenkomstig de Figma-staat. De groene scheidingslijn komt uit het SVG en is in Figma gemeten als `#2ECC71`. Dit is een vaste ontwerpstaat; er is geen actieve-paginalogica.

### 5.2 Gecontroleerde afmetingen (Playwright, light en dark)

| Onderdeel | Figma | Implementatie |
|---|---|---|
| Header hoogte | desktop 108, tablet 100, mobiel 84 | 108 / 100 / 84 |
| Header-inhoud | brand x 112 (desktop), 40 (tablet), 24 (mobiel) | 112 / 40 / 24 |
| Hero-tekst x / breedte | 195 / 720 (desktop), 40 / 410 (tablet), 24 / 342 (mobiel) | identiek |
| Portret x / y | 1215 / 246, 482 / 112, 39 / 108 | identiek |
| Hero-top | desktop 158 (50 px onder de header), tablet 100, mobiel 84 | identiek |
| Skills- en heading-x | 242 (desktop), 40 (tablet), 24 (mobiel) | identiek |
| Tijdlijnkaart x (desktop) | 466 | 466 |
| Footer hoogte | 41 / 29 / 86 | 41 / 29 / 86 |

De desktop-container is 1550 px breed en gecentreerd; de sectieinhoud begint op 242. De header en hero gebruiken de volle breedte met padding. Er is geen horizontale overflow op 1810, 834 en 390 px.

**Praatwolkjes:** tekst 15 px (titel), 14–16 px (opties), 12–13 px (hex, fout). Breedte 168 px. Pijltje gecentreerd op het triggerknop-midden. Dit is groter dan de 8–12 px in Figma, op verzoek van de opdrachtgever voor de leesbaarheid.

**Niet gecontroleerd op pixelniveau:** de verticale posities van de secties onder de hero (stats-rij is weggelaten), de koppen op tablet en mobiel, en de tablet-layout van de tijdlijn.

## 6. Technische implementatie

- Bouw de header als een gedeelde Laravel Blade-component.
- Gebruik de centrale layout zodat de header automatisch op iedere pagina wordt weergegeven.
- Houd de navigatie, instellingen en popovers logisch gescheiden in de code.
- Gebruik herbruikbare componenten waar dat zinvol is.
- Beheer thema's, accentkleuren en toegankelijkheidsinstellingen centraal.
- Gebruik CSS-variabelen voor kleuren en andere gedeelde ontwerpwaarden.
- Gebruik Laravel localization voor Nederlands en Engels.
- Gebruik geen database voor deze bezoekersvoorkeuren, tenzij daar later een concrete reden voor ontstaat.
- Voorkom onnodige JavaScript-afhankelijkheden.

## 7. Toegankelijkheid

- Gebruik een semantisch `<header>`-element.
- Gebruik een `<nav>`-element voor de navigatie.
- Alle knoppen moeten met het toetsenbord bedienbaar zijn.
- Geef iedere icoonknop een duidelijke toegankelijke naam via `aria-label` of een vergelijkbare geschikte oplossing.
- Gebruik correcte toegankelijkheidsattributen voor de popovers.
- Zorg dat popovers met het toetsenbord geopend en gesloten kunnen worden.
- Zorg voor een duidelijke focusindicator.
- Zorg dat de instellingen ook zonder muis te gebruiken zijn.
- Gebruik geen kleur als enige manier om een geselecteerde instelling aan te geven.
- Gebruik passende labels voor de slider en het hex-invoerveld.
- Houd rekening met voldoende contrast voor tekst en interactieve elementen.

## 8. Interactie en animaties

De volgende interacties moeten werken:

- Dark mode / Light mode wisselen.
- Het taalkeuzemenu openen en sluiten.
- Tussen Nederlands en Engels wisselen.
- Het instellingenmenu openen en sluiten.
- Een vooraf ingestelde accentkleur selecteren.
- Een eigen hexkleur invoeren.
- Kleurenblindheidsvriendelijke weergave in- en uitschakelen.
- Animaties in- en uitschakelen.
- Hoger contrast in- en uitschakelen.
- De lettergrootte aanpassen met de slider.

Popovers moeten netjes openen en sluiten en mogen geen andere onderdelen van de header onbedoeld verschuiven.

Gebruik alleen animaties die passen bij de bestaande ontwerpstijl en respecteer de ingestelde bewegingsvoorkeuren.

## 9. Acceptatiecriteria

- De header wordt op iedere pagina hergebruikt.
- Logo en naam staan links.
- De vier navigatielinks staan rechts uitgelijnd.
- De navigatielinks hebben voorlopig geen werkende paginabestemmingen.
- De verticale scheidingslijn staat tussen navigatie en instellingen.
- De drie instellingenknoppen staan rechts van de scheidingslijn.
- Dark mode en light mode werken voor de volledige website.
- Het taalkeuzemenu bevat Nederlands en Engels.
- Nederlands is standaard geselecteerd.
- De website kan volledig naar correct Engels worden omgeschakeld.
- Het instellingenmenu bevat de vijf accentkleuren en een hex-invoerveld.
- Een geldige eigen hexkleur wordt correct toegepast.
- De kleurenblindheidsvriendelijke weergave werkt daadwerkelijk.
- Animaties kunnen worden uitgeschakeld.
- De hogere contrastmodus werkt daadwerkelijk.
- De lettergrootte kan met de slider worden aangepast.
- Alle instellingen blijven behouden bij navigeren en opnieuw openen.
- De header en popovers werken op desktop, tablet en mobiel.
- De maximale contentbreedte wordt nergens overschreden.
- Er ontstaat geen onbedoelde horizontale overflow.
- Alle interactieve onderdelen zijn toegankelijk met toetsenbord en schermlezer.
- De implementatie werkt zonder dat iedere pagina afzonderlijk instellingen hoeft te beheren.
