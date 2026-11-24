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
        Schema::table('project_images', function (Blueprint $table) {
            $table->unsignedTinyInteger('mobile_position_x')->default(50)->after('mobile_rotation');
            $table->unsignedTinyInteger('mobile_position_y')->default(50)->after('mobile_position_x');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_images', function (Blueprint $table) {
            $table->dropColumn(['mobile_position_x', 'mobile_position_y']);
        });
    }
};
