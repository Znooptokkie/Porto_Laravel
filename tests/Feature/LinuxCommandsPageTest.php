<?php

use App\Models\LinuxCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the empty state when no linux commands exist', function () {
    $this->get('/linux-commands')
        ->assertOk()
        ->assertSee(e(__('linux-commands.overview.empty', [], 'nl')), false);
});

it('shows every linux command with its description and command', function () {
    LinuxCommand::factory()->create(['command' => 'df -h', 'description' => 'Toon het vrije schijfgebruik.']);
    LinuxCommand::factory()->create(['command' => 'ps aux | grep nginx', 'description' => 'Zoek naar draaiende nginx-processen.']);

    $this->get('/linux-commands')
        ->assertOk()
        ->assertSee('df -h', false)
        ->assertSee('Toon het vrije schijfgebruik.')
        ->assertSee('ps aux | grep nginx', false)
        ->assertSee('Zoek naar draaiende nginx-processen.');
});

it('lists linux commands in the order they were added', function () {
    LinuxCommand::factory()->create(['command' => 'first-command']);
    LinuxCommand::factory()->create(['command' => 'second-command']);

    $html = $this->get('/linux-commands')->getContent();

    expect(strpos($html, 'first-command'))->toBeLessThan(strpos($html, 'second-command'));
});

it('groups commands with the same card title into one card under their category', function () {
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Delete branch', 'command' => 'git branch -d <branch>', 'description' => 'Verwijder de branch lokaal.', 'position' => 0]);
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Delete branch', 'command' => 'git push origin --delete <branch>', 'description' => 'Verwijder de branch op de remote.', 'position' => 1]);
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Schijfgebruik', 'command' => 'df -h', 'description' => 'Toon het vrije schijfgebruik.', 'position' => 2]);

    $html = $this->get('/linux-commands')->assertOk()->getContent();

    expect(substr_count($html, 'class="about-card code-entry-card code-entry-group"'))->toBe(2)
        ->and(substr_count($html, 'class="code-entries__category-label"'))->toBe(2)
        ->and(substr_count($html, 'class="code-entry-card__code"'))->toBe(3);
});

it('shows the categories and their cards in the order of their position', function () {
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Schijfgebruik', 'command' => 'df -h', 'position' => 1]);
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Account', 'command' => 'gh auth status', 'position' => 0]);

    $html = $this->get('/linux-commands')->getContent();

    expect(strpos($html, '>Github</p>'))->toBeLessThan(strpos($html, '>Linux</p>'));
});

it('accents the category, the first word of the card title, in the card heading', function () {
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Delete branch', 'command' => 'git branch -d <branch>', 'position' => 0]);

    $html = $this->get('/linux-commands')->getContent();

    expect($html)->toContain('<span class="code-entry-card__title-accent">Github</span>')
        ->and($html)->toContain('- Delete branch')
        ->and($html)->not->toContain('branch</span>');
});

it('filters linux commands on a word from the category or card title', function () {
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Backuppen', 'command' => 'git branch -d <branch>', 'position' => 0]);
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Schijfgebruik', 'command' => 'df -h', 'position' => 1]);

    $this->get('/linux-commands?q=github')
        ->assertOk()
        ->assertSee('git branch -d', false)
        ->assertDontSee('df -h', false);
});

it('filters linux commands on a part of the code', function () {
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Account', 'command' => 'gh auth status', 'position' => 0]);
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Processen', 'command' => 'ps aux | grep nginx', 'position' => 1]);

    $this->get('/linux-commands?q=nginx')
        ->assertOk()
        ->assertSee('ps aux | grep nginx', false)
        ->assertDontSee('gh auth status', false);
});

it('requires every word of a multi-word linux command search to match', function () {
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Account', 'command' => 'gh auth status', 'position' => 0]);
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Processen', 'command' => 'ps aux | grep nginx', 'position' => 1]);

    $this->get('/linux-commands?q=grep%20github')
        ->assertOk()
        ->assertDontSee('ps aux | grep nginx', false)
        ->assertDontSee('gh auth status', false);

    $this->get('/linux-commands?q=grep%20nginx')
        ->assertOk()
        ->assertSee('ps aux | grep nginx', false);
});

it('accepts a single letter as linux command search term', function () {
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Zipper', 'command' => 'ls -la', 'position' => 0]);
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Xylo', 'command' => 'df -h', 'position' => 1]);

    $this->get('/linux-commands?q=z')
        ->assertOk()
        ->assertSee('ls -la', false)
        ->assertDontSee('df -h', false);
});

it('shows a no-results message when no linux command matches the search', function () {
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Zipper', 'command' => 'ls -la', 'position' => 0]);

    $this->get('/linux-commands?q=niets-van-dien')
        ->assertOk()
        ->assertSee(e(__('linux-commands.overview.no_results', [], 'nl')), false)
        ->assertDontSee('ls -la', false);
});

it('shows every keyword next to the search field', function () {
    $this->get('/linux-commands')
        ->assertOk()
        ->assertSee('Bash', false)
        ->assertSee('SSH', false)
        ->assertSee('JavaScript', false)
        ->assertSee('Networking', false)
        ->assertSee('Nginx', false);
});

it('shows only the cards of the selected keyword', function () {
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Account', 'keyword' => 'git', 'command' => 'gh auth status', 'position' => 0]);
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Schijfgebruik', 'keyword' => 'linux', 'command' => 'df -h', 'position' => 1]);

    $this->get('/linux-commands?keyword=git')
        ->assertOk()
        ->assertSee('gh auth status', false)
        ->assertDontSee('df -h', false)
        ->assertSee('aria-current="true"', false);
});

it('combines the keyword with the search term', function () {
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Account', 'keyword' => 'git', 'command' => 'gh auth status', 'position' => 0]);
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Branch', 'keyword' => 'git', 'command' => 'git branch -d <branch>', 'position' => 1]);
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Processen', 'keyword' => 'linux', 'command' => 'ps aux | grep git', 'position' => 2]);

    $this->get('/linux-commands?keyword=git&q=branch')
        ->assertOk()
        ->assertSee('git branch -d', false)
        ->assertDontSee('gh auth status', false)
        ->assertDontSee('ps aux', false);
});

it('keeps the keyword when searching', function () {
    $this->get('/linux-commands?keyword=git')
        ->assertOk()
        ->assertSee('<input type="hidden" name="keyword" value="git">', false);
});

it('ignores an unknown keyword by sending the visitor back to the list', function () {
    $this->get('/linux-commands?keyword=onbekend')->assertRedirect();
});

it('renders the copied popover that confirms a copy', function () {
    LinuxCommand::factory()->create(['command' => 'df -h', 'description' => 'Toon het vrije schijfgebruik.']);

    $this->get('/linux-commands')
        ->assertOk()
        ->assertSee('data-copy-popover', false)
        ->assertSee('Code gekopieerd!');
});

it('shows the English description and card title when the locale is English', function () {
    LinuxCommand::factory()->create([
        'category' => 'Github',
        'card_title' => 'Schijfgebruik',
        'card_title_en' => 'Disk usage',
        'command' => 'df -h',
        'description' => 'Toon het vrije schijfgebruik.',
        'description_en' => 'Show the free disk space.',
        'position' => 0,
    ]);

    $this->withUnencryptedCookie('locale', 'en')->get('/linux-commands')
        ->assertOk()
        ->assertSee('Show the free disk space.')
        ->assertSee('Disk', false)
        ->assertSee('usage', false)
        ->assertDontSee('Toon het vrije schijfgebruik.');
});

it('shows how many linux commands the search and keyword found, and only once a filter is active', function () {
    LinuxCommand::factory()->create(['category' => 'Github', 'card_title' => 'Account', 'keyword' => 'git', 'command' => 'gh auth status', 'position' => 0]);
    LinuxCommand::factory()->create(['category' => 'Linux', 'card_title' => 'Schijfgebruik', 'keyword' => 'linux', 'command' => 'df -h', 'position' => 1]);

    $this->get('/linux-commands')
        ->assertSeeHtml('<p class="results-count" data-project-count hidden>');

    $this->get('/linux-commands?q=github')
        ->assertSeeHtml('<p class="results-count" data-project-count>Er is <span class="results-count__number">1</span> commando gevonden.</p>');

    $this->get('/linux-commands?keyword=linux')
        ->assertSeeHtml('<p class="results-count" data-project-count>Er is <span class="results-count__number">1</span> commando gevonden.</p>');
});
