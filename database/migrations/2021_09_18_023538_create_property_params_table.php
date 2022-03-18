<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_params', function (Blueprint $table) {
            $table->increments('id');
            $table->string('en_name', 64);
            $table->string('ru_name', 64);
            $table->string('tr_name', 64);
            $table->string('ua_name', 64);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_params');
    }
}
