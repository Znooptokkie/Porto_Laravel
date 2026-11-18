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
        Schema::create('leetcode_problems', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('problem_number');
            $table->string('name');
            $table->string('url');
            $table->unsignedTinyInteger('rating');
            $table->string('difficulty', 10)->index();
            $table->string('language', 50)->index();
            $table->decimal('runtime_ms', 8, 2);
            $table->decimal('runtime_percentage', 5, 2);
            $table->decimal('memory_mb', 8, 2);
            $table->decimal('memory_percentage', 5, 2);
            $table->text('code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leetcode_problems');
    }
};
