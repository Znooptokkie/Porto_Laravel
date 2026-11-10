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
        Schema::table('project_types', function (Blueprint $table) {
            $table->json('translations')->nullable()->after('name');
        });

        Schema::table('project_chapters', function (Blueprint $table) {
            $table->json('translations')->nullable()->after('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_chapters', function (Blueprint $table) {
            $table->dropColumn('translations');
        });

        Schema::table('project_types', function (Blueprint $table) {
            $table->dropColumn('translations');
        });
    }
};
