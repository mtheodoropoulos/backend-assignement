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
        Schema::create('vessel_tracks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mmsi')->index();
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('stationId')->index();
            $table->unsignedSmallInteger('speed');
            $table->decimal('lon', 8, 5);
            $table->decimal('lat', 8, 5);
            $table->unsignedSmallInteger('course');
            $table->unsignedSmallInteger('heading');
            $table->string('rot')->nullable();
            $table->timestamp('timestamp')->index();


            $table->foreign('stationId')->references('id')->on('stations')->cascadeOnDelete();
            $table->foreign('mmsi')->references('mmsi')->on('vessels')->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vessel_tracks');
    }
};
