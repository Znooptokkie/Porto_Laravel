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
            $table->string('title')->nullable()->after('name');
            $table->string('package')->nullable()->after('description');
            $table->string('install_command')->nullable()->after('package');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shell_scripts', function (Blueprint $table) {
            $table->dropColumn(['title', 'package', 'install_command']);
        });
    }
};
