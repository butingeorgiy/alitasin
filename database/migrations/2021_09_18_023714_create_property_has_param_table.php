<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyHasParamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_has_param', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id')->unsigned();
            $table->integer('property_param_id')->unsigned();
            $table->string('en_value', 128);
            $table->string('ru_value', 128);
            $table->string('tr_value', 128);
            $table->string('ua_value', 128);


            $table->foreign('property_id')
                ->references('id')
                ->on('properties');

            $table->foreign('property_param_id')
                ->references('id')
                ->on('property_params');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_has_param');
    }
}
