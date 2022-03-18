<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('title_id')->unsigned();
            $table->bigInteger('description_id')->unsigned();
            $table->tinyInteger('type_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->integer('cost')->unsigned();


            $table->foreign('title_id')
                ->references('id')
                ->on('property_titles');

            $table->foreign('description_id')
                ->references('id')
                ->on('property_descriptions');

            $table->foreign('type_id')
                ->references('id')
                ->on('property_types');

            $table->foreign('region_id')
                ->references('id')
                ->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
