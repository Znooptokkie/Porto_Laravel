<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('linux_commands', function (Blueprint $table) {
            $table->string('card_title_en')->nullable()->after('card_title');
            $table->text('description_en')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('linux_commands', function (Blueprint $table) {
            $table->dropColumn(['card_title_en', 'description_en']);
        });
    }
};
