<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $collection) {
            $collection->string('name');
            $collection->integer('duration'); 
            $collection->string('description');
            $collection->integer('credits');
            $collection->decimal('actual_price', 8, 2);
            $collection->decimal('discounted_price', 8, 2);
            $collection->string('status'); 
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
};
