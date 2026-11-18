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
        Schema::create('leetcode_concept_leetcode_problem', function (Blueprint $table) {
            $table->foreignId('leetcode_problem_id')->constrained()->cascadeOnDelete();
            $table->foreignId('leetcode_concept_id')->constrained()->cascadeOnDelete();

            $table->primary(['leetcode_problem_id', 'leetcode_concept_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leetcode_concept_leetcode_problem');
    }
};
