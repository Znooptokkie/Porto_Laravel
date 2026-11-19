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
        Schema::table('shell_scripts', function (Blueprint $table) {
            $table->string('install_command_debian')->nullable()->after('install_command');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shell_scripts', function (Blueprint $table) {
            $table->dropColumn('install_command_debian');
        });
    }
};
