<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * SkillSeeder matches rows on name + icon. Renaming the skill therefore made
     * the seeder insert a new row instead of updating the existing "Raspberry" row.
     * This keeps the original row (and its position) and removes the duplicate.
     */
    public function up(): void
    {
        $legacySkill = DB::table('skills')->where('name', 'Raspberry')->where('icon', 'raspberry')->first();

        if ($legacySkill === null) {
            return;
        }

        DB::table('skills')
            ->where('name', 'Microcontrollers')
            ->where('icon', 'raspberry')
            ->where('id', '!=', $legacySkill->id)
            ->delete();

        DB::table('skills')
            ->where('id', $legacySkill->id)
            ->update(['name' => 'Microcontrollers']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('skills')
            ->where('name', 'Microcontrollers')
            ->where('icon', 'raspberry')
            ->update(['name' => 'Raspberry']);
    }
};
