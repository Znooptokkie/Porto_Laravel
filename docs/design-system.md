
# Design System

Dit document beschrijft de algemene ontwerpregels en visuele richtlijnen van de website. Deze regels gelden voor alle pagina's en gedeelde componenten.

## 1. Figma als bron van waarheid

- Figma is altijd de leidende bron voor visuele implementaties.
- Voor iedere pagina en component zijn desktop-, tablet- en mobiele ontwerpen beschikbaar.
- Voor de website zijn zowel light-mode- als dark-mode-ontwerpen beschikbaar.
- Controleer de relevante ontwerpen voordat je begint met implementeren.
- Verzin geen ontbrekende ontwerpdetails wanneer deze uit Figma af te leiden zijn.
- Wanneer ontwerpen onduidelijk of tegenstrijdig zijn, onderzoek dit eerst en rapporteer eventuele onduidelijkheden.
- Gebruik Figma niet alleen als globale inspiratie, maar als concrete implementatiereferentie.

## 2. Algemene layout

- Iedere pagina heeft een centrale contentcontainer met een vaste maximale breedte.
- De inhoud mag nooit breder worden dan deze maximale breedte.
- Op kleinere schermen schaalt de container mee binnen de beschikbare schermbreedte.
- Respecteer de marges en afstanden uit de bijbehorende Figma-ontwerpen.
- Achtergrondkleuren en andere full-width achtergrondelementen mogen wel over de volledige schermbreedte lopen.
- Voorkom horizontale overflow.
- Zorg dat teksten, afbeeldingen en componenten binnen hun beschikbare ruimte blijven.

De exacte maximale breedte en responsive afmetingen moeten worden bepaald aan de hand van Figma. Leg deze waarden centraal vast.

## 3. Responsive design

Iedere pagina en component moet correct werken op:

- Desktop
- Tablet
- Mobiel

Gebruik de bijbehorende Figma-ontwerpen als uitgangspunt.

- Verzin geen eigen breakpointwaarden wanneer deze uit het ontwerp of de bestaande projectconfiguratie af te leiden zijn.
- Controleer niet alleen of elementen kleiner worden, maar ook of de layout en onderlinge verhoudingen correct veranderen.
- Voorkom dat teksten, afbeeldingen, navigatie of andere elementen elkaar overlappen.
- Behoud de maximale contentbreedte op alle schermformaten.

## 4. Thema's

De website ondersteunt twee thema's:

- Light mode
- Dark mode

Regels:

- Light mode is het standaardthema.
- Gebruik centrale CSS-variabelen voor achtergrondkleuren, tekstkleuren, borders en andere themagevoelige elementen.
- Componenten mogen geen onnodig hardcoded themakleuren bevatten.
- De themakeuze moet op iedere pagina consistent worden toegepast.
- De gekozen instelling moet behouden blijven bij navigatie en een volgend websitebezoek.
- Houd rekening met de systeemvoorkeur van de bezoeker wanneer er nog geen eigen voorkeur is opgeslagen.

## 5. Accentkleuren

De bezoeker kan de accentkleur van de website aanpassen.

- De standaardaccentkleur is #2ECC71.
- Bied vijf vooraf ingestelde accentkleuren aan.
- Bied daarnaast de mogelijkheid om zelf een HEX-kleur in te voeren.
- Gebruik één centrale CSS-variabele voor de actieve accentkleur.
- Alle onderdelen die de accentkleur gebruiken, moeten automatisch meeveranderen.
- Controleer of de gekozen kleur voldoende contrast heeft met de omliggende tekst en achtergronden.

## 6. Toegankelijkheidsinstellingen

De website biedt de volgende instellingen:

### Kleurenblindheidsmodus
- Pas kleurencombinaties aan zodat informatie niet uitsluitend afhankelijk is van kleur.
- Behoud de bestaande visuele stijl zoveel mogelijk.
- Zorg dat belangrijke informatie herkenbaar blijft door aanvullende visuele kenmerken.

### Animaties
- De bezoeker kan animaties uitschakelen.
- Respecteer ook de systeeminstelling prefers-reduced-motion.
- Schakel niet-noodzakelijke animaties en bewegingen uit wanneer dit is ingeschakeld.

### Verhoogd contrast
- Verhoog het contrast tussen tekst, achtergronden, borders en interactieve elementen.
- Behoud de algemene vormgeving zoveel mogelijk.

### Lettergrootte
- De bezoeker kan de algemene lettergrootte aanpassen.
- De standaardinstelling is de normale lettergrootte.
- Zorg dat componenten en containers zich aanpassen aan grotere teksten.
- Voorkom overlappende elementen, afgesneden tekst en horizontale overflow.
- Gebruik waar mogelijk relatieve CSS-eenheden.

## 7. Taal

De website ondersteunt:

- Nederlands (standaard)
- Engels

Regels:

- Gebruik centrale vertaalbestanden.
- Plaats geen vertaalbare teksten rechtstreeks verspreid door Blade-componenten.
- Alle zichtbare teksten moeten vertaalbaar zijn, inclusief navigatie, knoppen, meldingen en toegankelijkheidsinstellingen.
- Zorg dat beide talen inhoudelijk correct en natuurlijk zijn vertaald.
- De gekozen taal moet behouden blijven bij navigatie en een volgend websitebezoek.

## 8. Typografie

- Gebruik de typografie uit Figma.
- Beheer lettertypes, gewichten, groottes en regelhoogtes centraal.
- Zorg dat tekst op alle schermformaten goed leesbaar blijft.
- Houd rekening met de instelbare lettergrootte.

## 9. Herbruikbaarheid

- Gebruik centrale design tokens voor kleuren, typografie, spacing, breedtes en andere gedeelde waarden.
- Vermijd dubbele definities.
- Gedeelde componenten moeten op alle pagina's dezelfde visuele regels volgen.
- Maak geen afzonderlijke oplossingen wanneer een bestaande centrale oplossing uitgebreid kan worden.

## 10. Toegankelijkheid

- Gebruik semantische HTML.
- Alle interactieve elementen moeten met het toetsenbord te bedienen zijn.
- Gebruik duidelijke focus-indicatoren.
- Geef iconen en knoppen toegankelijke namen.
- Gebruik voldoende contrast.
- Vertrouw niet uitsluitend op kleur om informatie over te brengen.
- Houd rekening met prefers-reduced-motion.
