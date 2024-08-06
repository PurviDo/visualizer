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
            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
            $table->enum('model_type', ['men', 'women', 'furniture'])->default('women');
            $table->string('background_image', 1000)->nullable();
            $table->string('foreground_image', 1000)->nullable();
            $table->string('shadow_image', 1000)->nullable();
            $table->string('highlight_image', 1000)->nullable();
            $table->string('preview_image', 1000)->nullable();
            $table->boolean('status')->default(1)->comment('1 = active,0 = not active'); 
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
