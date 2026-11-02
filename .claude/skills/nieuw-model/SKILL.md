---
name: nieuw-model
description: Gebruik wanneer er een nieuw Eloquent-model moet komen. Maakt model, migratie, factory, eventuele enum en Pest-test volgens de projectafspraken.
---

# Nieuw model aanmaken

1. Maak model, migratie en factory met `php artisan make:model Naam -mf`.
2. Bedragen zijn integer-kolommen in centen. Statussen zijn een PHP Enum onder `app/Enums`, opgeslagen als string met een default.
3. Cast enums en bedragen in het model via `casts()`.
4. Vul de factory met realistische waarden, inclusief alle enum-statussen.
5. Schrijf een Pest feature-test met `it(...)`: aanmaken via de factory en controleren van de casts.
6. Draai `composer check` en los fouten op tot het slaagt.
7. Meld kort welke bestanden zijn aangemaakt.
