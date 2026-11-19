<?php

namespace Database\Seeders;

use App\Actions\ImportShellScripts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShellScriptSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Imports every .sh file from database/data/shell-scripts.
     */
    public function run(): void
    {
        app(ImportShellScripts::class)->handle(database_path('data/shell-scripts'));
    }
}
