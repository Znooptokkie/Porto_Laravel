<?php

use App\Actions\ImportLinuxCommands;
use App\Actions\ImportShellScripts;
use App\Models\LinuxCommand;
use App\Models\ShellScript;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->workDirectory = sys_get_temp_dir().'/content-import-'.uniqid();
    File::ensureDirectoryExists($this->workDirectory);
});

afterEach(function () {
    File::deleteDirectory($this->workDirectory);
});

it('imports linux commands from a json file', function () {
    $path = $this->workDirectory.'/linux-commands.json';
    File::put($path, json_encode([
        ['command' => 'df -h', 'description' => 'Toon het vrije schijfgebruik.'],
        ['command' => 'ps aux', 'description' => 'Toon alle processen.'],
    ]));

    app(ImportLinuxCommands::class)->handle($path);

    expect(LinuxCommand::query()->count())->toBe(2)
        ->and(LinuxCommand::query()->where('command', 'df -h')->value('description'))->toBe('Toon het vrije schijfgebruik.');
});

it('does not duplicate linux commands when imported twice', function () {
    $path = $this->workDirectory.'/linux-commands.json';
    File::put($path, json_encode([['command' => 'df -h', 'description' => 'Oud.']]));
    app(ImportLinuxCommands::class)->handle($path);

    File::put($path, json_encode([['command' => 'df -h', 'description' => 'Nieuw.']]));
    app(ImportLinuxCommands::class)->handle($path);

    expect(LinuxCommand::query()->count())->toBe(1)
        ->and(LinuxCommand::query()->value('description'))->toBe('Nieuw.');
});

it('rejects linux command entries without a command or description', function () {
    $path = $this->workDirectory.'/linux-commands.json';
    File::put($path, json_encode([['command' => 'df -h']]));

    app(ImportLinuxCommands::class)->handle($path);
})->throws(InvalidArgumentException::class);

it('imports shell scripts from .sh files and reads the description header', function () {
    File::put($this->workDirectory.'/backup.sh', "#!/usr/bin/env bash\n# description: Maakt een backup.\ntar -czf backup.tar.gz \$HOME\n");
    File::put($this->workDirectory.'/notes.txt', 'Geen script.');

    app(ImportShellScripts::class)->handle($this->workDirectory);

    $script = ShellScript::query()->sole();

    expect($script->name)->toBe('backup.sh')
        ->and($script->description)->toBe('Maakt een backup.')
        ->and($script->code)->toContain('tar -czf backup.tar.gz');
});

it('reads the title, package and install headers of a shell script', function () {
    File::put($this->workDirectory.'/fzf-preview.sh', "#!/usr/bin/env bash\n# title: Bestanden zoeken\n# package: fzf\n# install: sudo pacman -S fzf\nfzf\n");

    app(ImportShellScripts::class)->handle($this->workDirectory);

    $script = ShellScript::query()->sole();

    expect($script->title)->toBe('Bestanden zoeken')
        ->and($script->package)->toBe('fzf')
        ->and($script->install_command)->toBe('sudo pacman -S fzf')
        ->and($script->install_command_debian)->toBeNull()
        ->and($script->code)->not->toContain('# title:')
        ->and($script->code)->not->toContain('# package:')
        ->and($script->code)->toStartWith("#!/usr/bin/env bash\n")
        ->and($script->code)->toContain('fzf');
});

it('reads the Debian install header of a shell script', function () {
    File::put($this->workDirectory.'/fzf-preview.sh', "#!/usr/bin/env bash\n# package: fzf\n# install: sudo pacman -S fzf\n# install-debian: sudo apt install fzf\nfzf\n");

    app(ImportShellScripts::class)->handle($this->workDirectory);

    $script = ShellScript::query()->sole();

    expect($script->install_command)->toBe('sudo pacman -S fzf')
        ->and($script->install_command_debian)->toBe('sudo apt install fzf')
        ->and($script->code)->not->toContain('# install-debian:');
});

it('removes the blank lines left behind by header lines at the top of a script', function () {
    File::put($this->workDirectory.'/webp.sh', "# title: WEBP converter\n\nfind . -type f\n");

    app(ImportShellScripts::class)->handle($this->workDirectory);

    expect(ShellScript::query()->sole()->code)->toBe("find . -type f\n");
});

it('stores a shell script without description when it has no description header', function () {
    File::put($this->workDirectory.'/plain.sh', "#!/usr/bin/env bash\necho hallo\n");

    app(ImportShellScripts::class)->handle($this->workDirectory);

    expect(ShellScript::query()->sole()->description)->toBeNull();
});

it('does not duplicate shell scripts when imported twice', function () {
    File::put($this->workDirectory.'/backup.sh', "#!/usr/bin/env bash\necho oud\n");
    app(ImportShellScripts::class)->handle($this->workDirectory);

    File::put($this->workDirectory.'/backup.sh', "#!/usr/bin/env bash\necho nieuw\n");
    app(ImportShellScripts::class)->handle($this->workDirectory);

    expect(ShellScript::query()->count())->toBe(1)
        ->and(ShellScript::query()->value('code'))->toContain('echo nieuw');
});

it('imports the category, card title and position of linux commands', function () {
    $path = $this->workDirectory.'/linux-commands.json';
    File::put($path, json_encode([
        ['category' => 'Github', 'card_title' => 'Account', 'command' => 'gh auth status', 'description' => 'Controleer het account.'],
        ['command' => 'df -h', 'description' => 'Toon het vrije schijfgebruik.'],
    ]));

    app(ImportLinuxCommands::class)->handle($path);

    $status = LinuxCommand::query()->where('command', 'gh auth status')->sole();
    $disk = LinuxCommand::query()->where('command', 'df -h')->sole();

    expect($status->category)->toBe('Github')
        ->and($status->card_title)->toBe('Account')
        ->and($status->position)->toBe(0)
        ->and($disk->category)->toBeNull()
        ->and($disk->card_title)->toBeNull()
        ->and($disk->position)->toBe(1);
});

it('imports the keyword of linux commands and rejects an unknown keyword', function () {
    $path = $this->workDirectory.'/linux-commands.json';
    File::put($path, json_encode([['category' => 'Github', 'card_title' => 'Account', 'keyword' => 'git', 'command' => 'gh auth status', 'description' => 'Controleer het account.']]));

    app(ImportLinuxCommands::class)->handle($path);

    expect(LinuxCommand::query()->sole()->keyword)->toBe('git');

    File::put($path, json_encode([['command' => 'df -h', 'keyword' => 'cobol', 'description' => 'Toon het vrije schijfgebruik.']]));

    app(ImportLinuxCommands::class)->handle($path);
})->throws(InvalidArgumentException::class);

it('reads the english title and description headers of a shell script and keeps them out of the code', function () {
    File::put($this->workDirectory.'/backup.sh', "# title: Backuppen\n# title-en: Backup\n# description: Maakt een backup.\n# description-en: Makes a backup.\necho hallo\n");

    app(ImportShellScripts::class)->handle($this->workDirectory);

    $script = ShellScript::query()->sole();

    expect($script->title_en)->toBe('Backup')
        ->and($script->description_en)->toBe('Makes a backup.')
        ->and($script->description)->toBe('Maakt een backup.')
        ->and($script->code)->toBe("echo hallo\n");
});
