## Projectafspraken

- Houd controllers dun: logica hoort in Action-klassen onder `app/Actions`.
- Schrijf tests in Pest-stijl met `it(...)`.
- Voorkom N+1-queries: gebruik `with()` bij het ophalen van relaties in lijsten.
- Test casts en berekeningen op het model zelf (`make()` of `new`), niet via `create()->fresh()`, want de database corrigeert waarden stilletjes.

## Werkwijze

- Draai `composer check` op de host voordat je zegt dat een taak klaar is. Los fouten op tot het slaagt.
- Gebruik geen Docker of Sail. Coverage, mutation testing, TIA en Xdebug draait de gebruiker zelf via `./vendor/bin/sail`.
- Voeg geen pakketten toe zonder akkoord van de gebruiker. Na `composer require` draait de gebruiker `php artisan boost:update --discover`, na `composer update` `php artisan boost:update`.
- Rector hoort niet in `composer check`. Draai `composer rector:check` alleen op verzoek.
