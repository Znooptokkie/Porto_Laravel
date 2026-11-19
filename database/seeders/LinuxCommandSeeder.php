<?php

namespace Database\Seeders;

use App\Actions\ImportLinuxCommands;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinuxCommandSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Imports the Linux commands from database/data/linux-commands.json.
     */
    public function run(): void
    {
        app(ImportLinuxCommands::class)->handle(database_path('data/linux-commands.json'));
    }
}
