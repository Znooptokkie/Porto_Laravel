
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

### Breakpoints

Breakpoints zijn gekozen op basis van de content (waar een layout niet meer past), en de ontwerpbreedtes 1810, 834 en 390 px blijven exact. Alle waarden staan in `resources/css/app.css`; de bovenste regel van het responsive-blok legt ze vast.

| Breedte | Gedrag |
|---|---|
| vanaf 1280 px | Skills naast elkaar: quote (376 px) en 5-koloms grid. |
| tot 1279 px | Skills gestapeld: quote boven het grid. Vanaf 835 px 5 kolommen; daaronder kolommen van minimaal 140 px (auto-fit). |
| vanaf 900 px | Desktopnavigatie in de header. |
| tot 899 px | Menuknop en paneel: tablet-paneel van 481 tot 899 px, mobiel paneel tot 480 px. |
| vanaf 835 px | Desktop-hero met vloeiende maten (zie hieronder). |
| tot 834 px | Tablet-ontwerp: hero-tekst 410 px, portret 312 px, footer 29 px. |
| tot 720 px | Compact: hero en tijdlijn gestapeld, zoals het mobiele ontwerp. |
| tot 480 px | Mobiel-ontwerp (390 px): kopmaten, header 84 px, skills in 2 kolommen. |

### Vloeiende maten

- De contentmarge (`--content-gutter`) loopt lineair van 40 px op 834 px naar 112 px op 1810 px en blijft daarboven 112 px.
- De hero is een rij met vloeiende breedtes: tekst `clamp(410px, …, 720px)`, portret `clamp(312px, …, 400px)`, tussenruimte `clamp(32px, …, 300px)`. Op 1810 px zijn dat de Figma-maten.
- Het portret (versiering en foto) is in `cqw` (procent van de portretbreedte) getekend, zodat de ring en de foto met het portret meeschalen.
- Overflow wordt niet verborgen. Layouts gebruiken `min-width: 0` op flex- en grid-items, `minmax(0, 1fr)` in grids en `flex-wrap` waar knoppen of logo's anders zouden breken.

## 4. Thema's

De website ondersteunt twee thema's:

- Light mode
- Dark mode

Regels:

- Bij het eerste bezoek volgt de website de systeemvoorkeur (`prefers-color-scheme`).
- Zodra de bezoeker zelf een thema kiest, wordt die keuze opgeslagen in `localStorage` en daarna gebruikt.
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

- Gebruik centrale design tokens voor kleuren, typografie, spacing, breedtes en andere gedeelde waarden. Deze staan in `resources/css/app.css` (light-tokens in `@theme`, dark-tokens onder `[data-theme="dark"]`).
- Voorkeuren van de bezoeker (thema, taal, accentkleur, toegankelijkheidsinstellingen) worden in `localStorage` bewaard en via één JavaScript-module toegepast.
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

## Accentkleuren

- **Bron:** `--accent` in `resources/css/app.css` (default `#2ECC71`). De bezoekerskeuze (5 presets uit `config/portfolio.php` `accent_presets` of een eigen HEX) wordt via `resources/js/preferences.js` op `--accent` gezet.
- **Afgeleide tinten:** `--accent-strong` is `color-mix(in srgb, var(--accent) 64%, #000)`; `--accent-soft` is `color-mix(in srgb, var(--accent) 15%, var(--color-surface))`. Beide volgen het actieve thema via de surface-token.
- **Iconen:** SVG-exports in `public/images/figma/**` en `resources/svg/skills/**` gebruiken `currentColor` voor hun groene delen; `<x-themed-image>` plaatst SVG's inline, zodat ze de accentkleur volgen. Monochrome PNG-iconen gebruiken `accent` (CSS-mask met de alfa van de PNG).- **Tekst op accent:** `--accent-ink` is de tekstkleur op volle accentvlakken (knop `.button--primary`, skip-link, footer). `--accent-ink-soft` is de tekstkleur op de accenttint `--accent-soft` (tags). Beide worden in `applyAccentInks()` (`resources/js/preferences.js`) gezet met `pickInk()` uit `resources/js/accent-contrast.js`: het hoogste WCAG-contrast van `#102334` of `#FFFFFF`. De tint wordt berekend op de surface van het actieve thema, zoals `--accent-soft`.
- **Contrasteis:** tekst op accentvlakken en -tinten haalt minimaal 4,5:1 (WCAG AA tekst); alleen als het contrast van de beste ink onder 4,5:1 zakt, is 3:1 het minimum voor grote tekst en UI. Met de huidige keuze blijft de beste ink voor ~88% van de RGB-kleuren boven 4,5:1; de slechtste kleur (bijv. `#5784A5`) haalt ~4,0:1. Toets nieuwe presets met `tests/Feature/AccentColourTest.php`.
- **Accent als tekst:** accentkleuren als tekst op de paginasurface (titels, `.hero__name-accent`, `.section-heading__title span`) halen de norm voor sommige kleuren niet (groen ~2,1:1 op wit; geel ~1,2:1). Dit is een ontwerpkeuze die nog open staat; de ink-regel dekt dit niet.

**Uitzonderingen (behouden hun oorspronkelijke kleur, ongeacht accent):**

1. De persoonlijke foto in sectie 1 van de homepage (`public/images/profile/me_HH.webp`).
2. Het Webprepare-logo in de tijdlijn (`public/images/companies/webprepare.webp`).
3. Het Battlebot-logo in de tijdlijn (`public/images/companies/mborijnland.svg`).

De logo's worden via `config/portfolio.php` (`internship_logos`) geladen. De Figma-logo-sheet (`sourceImageCrop.png`) en de ongebruikte Figma-exports (preset-voorbeelden `pop-swatch*.svg`, navigatie-iconen `navEdit`/`navMoon`/`navLanguage`, losse logo-exports) zijn verwijderd omdat ze nergens meer werden gebruikt.

De swatch-knoppen (`--swatch`) in de kleurenkiezer tonen hun eigen presetkleur en volgen het accent daarom niet. Dit is een interpretatie van de regel "alle groene onderdelen"; ter bevestiging.
