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
        Schema::connection('mongodb')->create('users', function (Blueprint $collection) {
            $collection->string('first_name');
            $collection->string('last_name');
            $collection->string('email')->unique();
            $collection->string('mobile_no');
            $collection->string('password');
            $collection->integer('purchased_credit');
            $collection->unsignedBigInteger('package_id');
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
        Schema::connection('mongodb')->dropIfExists('users');
    }
};
