<?php

use App\Models\LinuxCommand;
use App\Models\ShellScript;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores linux commands created by the factory', function () {
    $command = LinuxCommand::factory()->create([
        'command' => 'df -h',
        'description' => 'Toon het vrije schijfgebruik.',
    ]);

    expect($command->exists)->toBeTrue()
        ->and($command->command)->toBe('df -h')
        ->and($command->description)->toBe('Toon het vrije schijfgebruik.');
});

it('stores shell scripts created by the factory', function () {
    $script = ShellScript::factory()->create([
        'name' => 'backup.sh',
        'description' => 'Maakt een backup van de home-map.',
        'code' => "#!/usr/bin/env bash\necho backup",
    ]);

    expect($script->exists)->toBeTrue()
        ->and($script->name)->toBe('backup.sh')
        ->and($script->description)->toBe('Maakt een backup van de home-map.')
        ->and($script->code)->toBe("#!/usr/bin/env bash\necho backup");
});

it('allows shell scripts without a description', function () {
    $script = ShellScript::factory()->create(['description' => null]);

    expect($script->fresh()->description)->toBeNull();
});
