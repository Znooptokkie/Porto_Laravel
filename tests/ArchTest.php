<?php

arch('models zijn classes')
    ->expect('App\Models')
    ->toBeClasses();

arch('geen debugging functies')
    ->expect(['dd', 'dump', 'ray', 'var_dump'])
    ->not->toBeUsed();
