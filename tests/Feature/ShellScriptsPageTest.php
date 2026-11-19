<?php

use App\Models\ShellScript;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the empty state when no shell scripts exist', function () {
    $this->get('/shell-scripts')
        ->assertOk()
        ->assertSee(e(__('shell-scripts.overview.empty', [], 'nl')), false);
});

it('shows every shell script with its name, description and code', function () {
    ShellScript::factory()->create([
        'name' => 'backup.sh',
        'description' => 'Maakt een backup van de home-map.',
        'code' => "#!/usr/bin/env bash\ntar -czf backup.tar.gz \$HOME",
    ]);

    $this->get('/shell-scripts')
        ->assertOk()
        ->assertSee('backup.sh')
        ->assertSee('Maakt een backup van de home-map.')
        ->assertSee('tar -czf backup.tar.gz', false);
});

it('lists shell scripts in the order they were added', function () {
    ShellScript::factory()->create(['name' => 'first-script.sh']);
    ShellScript::factory()->create(['name' => 'second-script.sh']);

    $html = $this->get('/shell-scripts')->getContent();

    expect(strpos($html, 'first-script.sh'))->toBeLessThan(strpos($html, 'second-script.sh'));
});

it('shows the package with its install command and a copy button', function () {
    ShellScript::factory()->create([
        'name' => 'fzf-preview.sh',
        'package' => 'fzf',
        'install_command' => 'sudo pacman -S fzf',
    ]);

    $this->get('/shell-scripts')
        ->assertOk()
        ->assertSee('code-entry-card__packages', false)
        ->assertSee('Package:', false)
        ->assertSee('Installatiecommando:', false)
        ->assertSee('<li><span class="code-entry-card__label">Package:</span> fzf</li>', false)
        ->assertSee('data-copy-text="sudo pacman -S fzf"', false);
});

it('shows no package list or copy button when the script has no package', function () {
    ShellScript::factory()->create(['name' => 'plain.sh', 'package' => null, 'install_command' => null]);

    $this->get('/shell-scripts')
        ->assertOk()
        ->assertDontSee('code-entry-card__packages', false)
        ->assertDontSee('code-entry-card__install-command', false);
});

it('uses the title as heading and falls back to the file name', function () {
    ShellScript::factory()->create(['name' => 'backup.sh', 'title' => 'Home-map back-uppen']);
    ShellScript::factory()->create(['name' => 'untitled.sh', 'title' => null]);

    $this->get('/shell-scripts')
        ->assertOk()
        ->assertSee('Home-map <span class="code-entry-card__title-accent">back-uppen</span>', false)
        ->assertSee('untitled.sh');
});

it('shows an install command per distribution when both are given', function () {
    ShellScript::factory()->create([
        'name' => 'fzf-preview.sh',
        'package' => 'fzf',
        'install_command' => 'sudo pacman -S fzf',
        'install_command_debian' => 'sudo apt install fzf',
    ]);

    $this->get('/shell-scripts')
        ->assertOk()
        ->assertSee('data-copy-text="sudo pacman -S fzf"', false)
        ->assertSee('data-copy-text="sudo apt install fzf"', false)
        ->assertSee('code-entry-card__distribution', false);
});

it('gives the last word of the title the accent colour', function () {
    ShellScript::factory()->create(['name' => 'fzf-preview.sh', 'title' => 'Bestanden zoeken met fzf']);

    $this->get('/shell-scripts')
        ->assertOk()
        ->assertSee('Bestanden zoeken met <span class="code-entry-card__title-accent">fzf</span>', false);
});

it('shows a copy button for the full code', function () {
    ShellScript::factory()->create(['name' => 'plain.sh', 'code' => "#!/usr/bin/env bash\necho hallo\n"]);

    $this->get('/shell-scripts')
        ->assertOk()
        ->assertSee('code-entry-card__copy--code', false)
        ->assertSee('data-copy-text="#!/usr/bin/env bash', false);
});

it('filters shell scripts on a word from the title', function () {
    ShellScript::factory()->create(['name' => 'backup.sh', 'title' => 'Backuppen', 'code' => "echo a\n"]);
    ShellScript::factory()->create(['name' => 'webp.sh', 'title' => 'Converteren', 'code' => "echo b\n"]);

    $this->get('/shell-scripts?q=backup')
        ->assertOk()
        ->assertSee('Backuppen', false)
        ->assertDontSee('Converteren', false);
});

it('filters shell scripts on a part of the code', function () {
    ShellScript::factory()->create(['name' => 'one.sh', 'title' => 'Eerste', 'code' => "find . -type f\n"]);
    ShellScript::factory()->create(['name' => 'two.sh', 'title' => 'Tweede', 'code' => "tar -czf archief.tar.gz \$HOME\n"]);

    $this->get('/shell-scripts?q=archief')
        ->assertOk()
        ->assertSee('Tweede', false)
        ->assertDontSee('Eerste', false);
});

it('requires every word of a multi-word search to match', function () {
    ShellScript::factory()->create(['name' => 'a.sh', 'title' => 'Backuppen', 'code' => "echo a\n"]);
    ShellScript::factory()->create(['name' => 'b.sh', 'title' => 'Bestanden', 'code' => "echo b\n"]);

    $this->get('/shell-scripts?q=backuppen%20bestanden')
        ->assertOk()
        ->assertDontSee('Backuppen', false)
        ->assertDontSee('Bestanden', false);

    $this->get('/shell-scripts?q=echo%20backuppen')
        ->assertOk()
        ->assertSee('Backuppen', false)
        ->assertDontSee('Bestanden', false);
});

it('accepts a single letter as search term', function () {
    ShellScript::factory()->create(['name' => 'a.sh', 'title' => 'Zipper', 'code' => "echo a\n"]);
    ShellScript::factory()->create(['name' => 'b.sh', 'title' => 'Xylo', 'code' => "echo b\n"]);

    $this->get('/shell-scripts?q=z')
        ->assertOk()
        ->assertSee('Zipper', false)
        ->assertDontSee('Xylo', false);
});

it('shows a no-results message when nothing matches the search', function () {
    ShellScript::factory()->create(['name' => 'a.sh', 'title' => 'Zipper', 'code' => "echo a\n"]);

    $this->get('/shell-scripts?q=niets-van-dien')
        ->assertOk()
        ->assertSee(e(__('shell-scripts.overview.no_results', [], 'nl')), false)
        ->assertDontSee('Zipper', false);
});

it('shows the english title and description when the locale is english', function () {
    ShellScript::factory()->create([
        'name' => 'backup.sh',
        'title' => 'Backuppen',
        'title_en' => 'Backup',
        'description' => 'Maakt een backup.',
        'description_en' => 'Makes a backup.',
        'code' => "echo a\n",
    ]);

    $this->withUnencryptedCookie('locale', 'en')->get('/shell-scripts')
        ->assertOk()
        ->assertSee('Makes a backup.')
        ->assertSee('Backup', false)
        ->assertDontSee('Maakt een backup.')
        ->assertDontSee('Backuppen', false);
});
