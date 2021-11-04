<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('clever_id')->on('locations');
            $table->integer('available_ccs_fast');
            $table->integer('available_ccs_ultra');
            $table->integer('available_chademo_fast');
            $table->integer('available_chademo_ultra');
            $table->integer('available_iec_type_2_fast');
            $table->integer('available_iec_type_2_regular');

            $table->integer('functional_ccs_fast');
            $table->integer('functional_ccs_ultra');
            $table->integer('functional_chademo_fast');
            $table->integer('functional_chademo_ultra');
            $table->integer('functional_iec_type_2_fast');
            $table->integer('functional_iec_type_2_regular');

            $table->integer('total_ccs_fast');
            $table->integer('total_ccs_ultra');
            $table->integer('total_chademo_fast');
            $table->integer('total_chademo_ultra');
            $table->integer('total_iec_type_2_fast');
            $table->integer('total_iec_type_2_regular');
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
        Schema::dropIfExists('availabilities');
    }
}
