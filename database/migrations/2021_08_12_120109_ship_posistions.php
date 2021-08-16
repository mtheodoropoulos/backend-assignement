<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShipPosistions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_positions', function (Blueprint $table) {
            $table->id();
            $table->integer('mmsi');
            $table->integer('status');
            $table->integer('stationId');
            $table->integer('speed');
            $table->double('lon', 7, 5);
            $table->double('lat', 7, 5);
            $table->integer('course');
            $table->integer('heading');
            $table->string('rot')->nullable();
            $table->dateTime('timestamp');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ship_positions');
    }
}
