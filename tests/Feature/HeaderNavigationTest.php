<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the knowledge base as a trigger that opens a submenu with leetcode, shell scripts and linux commands', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)->toContain('aria-controls="knowledge-popover" aria-expanded="false"')
        ->toContain('>Kennisbank')
        ->toContain('id="knowledge-popover"')
        ->toContain('>Leetcode</a>')
        ->toContain('href="'.route('shell-scripts').'"')
        ->toContain('>Shell Scripts</a>')
        ->toContain('href="'.route('linux-commands').'"')
        ->toContain('>Linux Commands</a>');
});
