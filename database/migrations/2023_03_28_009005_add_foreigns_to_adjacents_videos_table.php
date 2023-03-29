<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('adjacents_videos', function (Blueprint $table) {
            $table
                ->foreign('video_id')
                ->references('id')
                ->on('videos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('adjacent_id')
                ->references('id')
                ->on('videos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adjacents_videos', function (Blueprint $table) {
            $table->dropForeign(['video_id']);
            $table->dropForeign(['adjacent_id']);
        });
    }
};
