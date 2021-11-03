<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('clever_id')->unique();
            $table->string('line1');
            $table->string('line2');
            $table->decimal('lat', 10, 7);
            $table->decimal('long', 10, 7);
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_future');
            $table->boolean('is_open24');
            $table->boolean('is_remote_charging_supported');
            $table->boolean('is_roaming');
            $table->string('location_id');
            $table->string('opening_hours_dk');
            $table->string('opening_hours_en')->nullable();
            $table->string('phone_number')->nullable();
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
        Schema::dropIfExists('locations');
    }
}
