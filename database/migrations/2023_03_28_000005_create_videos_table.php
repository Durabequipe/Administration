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
        Schema::create('videos', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('project_id');
            $table->string('desktop_path');
            $table->string('mobile_path');
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
