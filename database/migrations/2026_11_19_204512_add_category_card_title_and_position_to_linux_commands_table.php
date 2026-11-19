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
            $table->string('category')->nullable()->after('id');
            $table->string('card_title')->nullable()->after('category');
            $table->unsignedInteger('position')->default(0)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('linux_commands', function (Blueprint $table) {
            $table->dropColumn(['category', 'card_title', 'position']);
        });
    }
};
