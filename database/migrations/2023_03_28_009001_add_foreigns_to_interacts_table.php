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
        Schema::table('interacts', function (Blueprint $table) {
            $table
                ->foreign('video_id')
                ->references('id')
                ->on('videos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('link_to')
                ->references('id')
                ->on('videos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interacts', function (Blueprint $table) {
            $table->dropForeign(['video_id']);
            $table->dropForeign(['link_to']);
            $table->dropForeign(['position_id']);
        });
    }
};
