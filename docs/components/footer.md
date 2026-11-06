## Component: Footer

- **Doel:** een herkenbare, minimalistische footer tonen die onderaan iedere pagina van de website terugkomt.
- **Inhoud:** de footer bestaat uit één horizontale balk over de volledige breedte van de website.
  - **Achtergrondkleur:** gebruik de main color van het actieve thema. Bij het standaardthema is dit groen (`#2ECC71`).
  - **Tekstkleur:** gebruik de achtergrondkleur van de website (`#00010F`).
  - De balk bevat drie onderdelen:
    1. `github.com/znooptokkie`: een externe link naar `https://github.com/znooptokkie/`. Open deze in een nieuw tabblad met `rel="noopener noreferrer"`.
    2. `Alle rechten voorbehouden.`
    3. `© 2026 Atilla Oomen`, waarbij het jaartal automatisch het huidige kalenderjaar weergeeft.
- **Layout:**
  - De drie onderdelen staan horizontaal naast elkaar en zijn gelijkmatig over de beschikbare breedte verdeeld.
  - De footer loopt over de volledige breedte van de website.
  - De inhoud heeft voldoende horizontale en verticale ruimte volgens Figma.
  - Op mobiel worden de drie onderdelen netjes onder elkaar of volgens het mobiele Figma-frame weergegeven.
  - Er mag geen horizontale overflow ontstaan.
- **Data:** geen database. De GitHub-URL staat op één centrale plek in `config/portfolio.php`, niet rechtstreeks in de Blade-view.
- **Beheer:** geen beheerpagina. De naam en overige vaste tekst worden rechtstreeks in de code aangepast.
- **Interactie:** alleen de externe GitHub-link.
- **Animatie:** geen.
- **Dynamisch jaartal:**
  - Gebruik PHP om automatisch het huidige kalenderjaar op te halen.
  - Gebruik hiervoor `now()->year` of een gelijkwaardige Laravel-oplossing.
  - Het jaartal moet automatisch veranderen op 1 januari, zonder handmatige aanpassing of databasewijziging.
- **Kleur:** gebruik de bestaande CSS-tokens voor de main color en de achtergrondkleur uit `theme.css`. Gebruik geen hardcoded hex-waarden in de component.
- **Toegankelijkheid:**
  - De GitHub-link moet een duidelijke en herkenbare link zijn.
  - Zorg voor voldoende kleurcontrast tussen de tekst en de achtergrond.
  - De footer moet semantisch worden opgebouwd met het HTML-element `<footer>`.
- **Acceptatie:**
  - De footer wordt op iedere pagina getoond.
  - De footer gebruikt de main color van het actieve thema als achtergrondkleur.
  - Alle drie de onderdelen worden correct weergegeven.
  - De tekst gebruikt de achtergrondkleur van de website.
  - De GitHub-link verwijst naar de juiste externe pagina en opent in een nieuw tabblad.
  - Het jaartal wordt automatisch bijgewerkt op basis van het huidige kalenderjaar.
  - De footer werkt correct op desktop, mobiel en tablet.
  - De footer veroorzaakt geen horizontale overflow.
  - De footer werkt zonder JavaScript.
