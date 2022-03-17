<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type_id')->unsigned();
            $table->enum('show_at_index_page', ['0', '1']);
            $table->string('brand', 64);
            $table->string('model', 64);
            $table->integer('region_id')->unsigned();
            $table->integer('cost')->unsigned();


            $table->foreign('type_id')
                ->references('id')
                ->on('vehicle_types');

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
        Schema::dropIfExists('vehicles');
    }
}
