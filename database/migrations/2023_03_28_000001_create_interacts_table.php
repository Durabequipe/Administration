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
        Schema::create('interacts', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('video_id');
            $table->unsignedBigInteger('link_to');
            $table->text('content');
            $table->unsignedBigInteger('position_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interacts');
    }
};
