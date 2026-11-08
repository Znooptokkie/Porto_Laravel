
# Application Architecture

Dit document beschrijft de technische uitgangspunten voor de Laravel-portfolioapplicatie.

## 1. Algemene uitgangspunten

- Gebruik Laravel en de bestaande projectstructuur.
- Onderzoek eerst hoe het project momenteel is opgebouwd.
- Respecteer bestaande conventies en afhankelijkheden.
- Introduceer geen nieuwe architectuur of technische afhankelijkheden zonder duidelijke reden.
- Houd de applicatie eenvoudig, onderhoudbaar en uitbreidbaar.
- Vermijd onnodige abstracties en overengineering.

## 2. Laravel en Blade

- Gebruik Blade voor de server-side weergave.
- Gebruik herbruikbare Blade-components voor onderdelen die op meerdere plaatsen voorkomen.
- Gebruik layouts voor de algemene paginastructuur.
- Houd de verantwoordelijkheden van routes, controllers, models en views gescheiden.
- Plaats geen onnodige bedrijfslogica in Blade-views.
- Gebruik bestaande Laravel-functionaliteit waar mogelijk.

## 3. Gedeelde componenten

Gedeelde onderdelen worden centraal beheerd.

Voorbeelden:
- Header
- Footer
- Navigatie
- Thema-instellingen
- Taalkeuze
- Website-instellingen

Wijzigingen aan gedeelde componenten moeten consistent doorwerken op alle pagina's.

## 4. Frontendstructuur

- Houd CSS en JavaScript logisch gescheiden.
- Gebruik de bestaande Vite-configuratie.
- Beheer globale stijlen en design tokens centraal.
- Voorkom dubbele CSS-regels en JavaScript-functionaliteit.
- Gebruik herbruikbare componentstijlen waar dat logisch is.
- Voeg geen frontendframework toe wanneer de bestaande Laravel- en Blade-oplossing voldoende is.

## 5. Globale website-instellingen

De volgende instellingen gelden voor de volledige website:

- Light mode / dark mode
- Accentkleur
- Taal
- Kleurenblindheidsmodus
- Animaties aan/uit
- Verhoogd contrast
- Lettergrootte

Regels:
- Beheer de instellingen vanuit één centrale oplossing.
- Voorkom afzonderlijke instellingenlogica per pagina.
- Zorg dat alle pagina's dezelfde actieve instellingen gebruiken.
- Sla bezoekersvoorkeuren lokaal op zodat ze behouden blijven.
- Zorg dat de instellingen ook zonder account werken.
- Voorkom dat de pagina bij het laden onnodig zichtbaar tussen verschillende thema's wisselt.

## 6. Vertalingen

- Gebruik Laravel localization.
- Beheer Nederlandse en Engelse teksten centraal.
- Gebruik vertaalkeys in plaats van hardcoded zichtbare teksten.
- Gebruik Nederlands als standaardtaal.
- Zorg dat nieuwe pagina's vanaf het begin geschikt zijn voor beide talen.

## 7. Configuratie

- Plaats gedeelde configuratiewaarden op een centrale locatie.
- Vermijd hardcoded URL's en andere configuratiewaarden verspreid door views.
- Gebruik bestaande Laravel-configuratie waar mogelijk.
- Houd configuratie en presentatielogica gescheiden.

## 8. Database

- Gebruik de database alleen wanneer gegevens daadwerkelijk dynamisch of persistent beheerd moeten worden.
- Plaats vaste website-inhoud niet onnodig in de database.
- Gebruik migrations, models en seeders volgens de bestaande Laravel-conventies.
- Voorkom onnodige databasequeries.

## 9. Beveiliging

- Gebruik Laravel-validatie voor invoer.
- Bescherm formulieren tegen CSRF.
- Escapete gebruikersinvoer correct.
- Vertrouw nooit blind op gegevens die vanuit de browser worden aangeleverd.
- Valideer zelf ingevoerde HEX-kleuren voordat ze als CSS-waarde worden gebruikt.
- Gebruik geen onveilige dynamische HTML-invoer.

## 10. Tests en kwaliteitscontrole

- Voeg tests toe voor belangrijke functionaliteit.
- Test de werking van globale instellingen.
- Test taalwisselingen en vertalingen.
- Test de werking van de gedeelde componenten.
- Controleer responsive gedrag.
- Controleer light mode en dark mode.
- Voer relevante bestaande tests en kwaliteitscontroles uit na wijzigingen.
