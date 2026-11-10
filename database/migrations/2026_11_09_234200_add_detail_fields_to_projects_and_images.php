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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title_accent')->nullable()->after('title');
            $table->string('media_tagline')->nullable()->after('story_lead');
            $table->string('story_heading')->nullable()->after('media_tagline');
            $table->string('story_heading_accent')->nullable()->after('story_heading');
            $table->string('story_aside')->nullable()->after('story_heading_accent');
        });

        Schema::table('project_images', function (Blueprint $table) {
            $table->string('caption')->nullable()->after('alt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_images', function (Blueprint $table) {
            $table->dropColumn('caption');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['title_accent', 'media_tagline', 'story_heading', 'story_heading_accent', 'story_aside']);
        });
    }
};
