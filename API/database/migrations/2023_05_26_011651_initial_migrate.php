<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::query('CREATE DATABASE IF NOT EXISTS jump_park');
        DB::query('USE "jump_park"');

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('service_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('vehiclePlate', 7);
            $table->dateTime('entryDateTime');
            $table->dateTime('exitDateTime')->default('0001-01-01 00:00:00');
            $table->string('priceType')->nullable();
            $table->decimal('price', 12, 2)->default(0.00);
            $table->unsignedInteger('userId');
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('service_orders');
        Schema::dropIfExists('users');

        // Drop the database if it exists
        DB::statement('DROP DATABASE IF EXISTS `jump_park`');
    }
};