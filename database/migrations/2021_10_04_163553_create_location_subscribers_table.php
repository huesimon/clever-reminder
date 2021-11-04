<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('type');

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

            $table->foreignId('location_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('location_subscribers');
    }
}
