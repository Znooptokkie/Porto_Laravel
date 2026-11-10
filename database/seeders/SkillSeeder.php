<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['name' => 'Python', 'display_label' => 'Py', 'icon' => null, 'proficiency' => 85, 'subconcepts' => ['Django', 'Flask', 'MicroPython']],
            ['name' => 'TypeScript', 'display_label' => 'TS', 'icon' => null, 'proficiency' => 70, 'subconcepts' => ['React', 'Vue', 'React Native', 'Electron']],
            ['name' => 'PHP', 'display_label' => 'php', 'icon' => null, 'proficiency' => 80, 'subconcepts' => ['Laravel', 'Wordpress']],
            ['name' => 'Java', 'display_label' => null, 'icon' => 'java', 'proficiency' => 50, 'subconcepts' => ['Android Studio']],
            ['name' => 'AI', 'display_label' => null, 'icon' => 'ai', 'proficiency' => 60, 'subconcepts' => ['Claude Code', 'Figma MCP']],
            ['name' => 'Docker', 'display_label' => null, 'icon' => 'docker', 'proficiency' => 55, 'subconcepts' => []],
            ['name' => 'SASS', 'display_label' => 'Sass', 'icon' => null, 'proficiency' => 60, 'subconcepts' => []],
            ['name' => 'Linux', 'display_label' => null, 'icon' => 'linux', 'proficiency' => 75, 'subconcepts' => ['Bash', 'Zsh', 'Omarchy', 'Debian']],
            ['name' => 'SQL', 'display_label' => null, 'icon' => 'mysql', 'proficiency' => 65, 'subconcepts' => ['MariaDB/MySQL', 'PostgreSQL']],
            ['name' => 'Raspberry', 'display_label' => null, 'icon' => 'raspberry', 'proficiency' => 40, 'subconcepts' => ['Raspberry Pi 4 & 5', 'Pico 2']],
        ];

        foreach ($skills as $skill) {
            $key = ['name' => $skill['name'], 'icon' => $skill['icon']];

            Skill::query()->updateOrCreate($key, collect($skill)->except(array_keys($key))->all());
        }
    }
}
