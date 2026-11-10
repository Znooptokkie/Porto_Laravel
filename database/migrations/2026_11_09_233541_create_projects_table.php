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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category');
            $table->string('intro_label')->nullable();
            $table->unsignedSmallInteger('started_year');
            $table->unsignedSmallInteger('ended_year')->nullable();
            $table->text('summary');
            $table->string('subtitle')->nullable();
            $table->text('story_lead')->nullable();
            $table->string('status');
            $table->boolean('is_favorite')->default(false);
            $table->string('organization')->nullable();
            $table->string('department')->nullable();
            $table->string('repository_url')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
