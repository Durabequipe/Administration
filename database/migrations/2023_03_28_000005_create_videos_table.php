<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id');
            $table->string('name');
            $table->string('desktop_path');
            $table->string('mobile_path')->nullable();
            $table->string('desktop_thumbnail')->nullable();
            $table->string('mobile_thumbnail')->nullable();
            $table
                ->boolean('is_main')
                ->default(false)
                ->nullable();
            $table
                ->unsignedBigInteger('interaction_id')
                ->default(1)
                ->nullable();

            $table->string('interaction_title')->nullable();
            $table->integer('position_x')->nullable()->default(0);
            $table->integer('position_y')->nullable()->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
