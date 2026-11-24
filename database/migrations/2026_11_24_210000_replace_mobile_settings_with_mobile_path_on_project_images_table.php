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
            $table->dropColumn(['mobile_fit', 'mobile_rotation', 'mobile_position_x', 'mobile_position_y']);
            $table->string('mobile_path')->nullable()->after('caption');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_images', function (Blueprint $table) {
            $table->dropColumn('mobile_path');
            $table->string('mobile_fit', 16)->default('cover')->after('caption');
            $table->unsignedSmallInteger('mobile_rotation')->default(0)->after('mobile_fit');
            $table->unsignedTinyInteger('mobile_position_x')->default(50)->after('mobile_rotation');
            $table->unsignedTinyInteger('mobile_position_y')->default(50)->after('mobile_position_x');
        });
    }
};
