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
        Schema::create('template_models', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('template_id')->nullable();
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
            $table->text('background_image')->nullable();
            $table->text('foreground_image')->nullable();
            $table->text('shadow_image')->nullable();
            $table->text('highlight_image')->nullable();
            $table->text('preview_image')->nullable();
            $table->text('model_images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_models');
    }
};
