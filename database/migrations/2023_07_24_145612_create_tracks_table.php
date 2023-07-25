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
        Schema::create('tracks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('deezer_id');
            $table->string('youtube_id');
            $table->string('title');
            $table->string('title_short')->nullable();
            $table->integer('duration');
            $table->integer('position');
            $table->integer('disk_number')->nullable();
            $table->date('release_date')->nullable();
            $table->text('preview')->nullable();
            $table->text('md5_image')->nullable();
            $table->string('searchable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
