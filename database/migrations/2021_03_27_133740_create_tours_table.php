<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tour_title_id')->unsigned();
            $table->bigInteger('tour_description_id')->unsigned();
            $table->integer('price')->unsigned();
            $table->string('available_time', 36)->nullable();
            $table->string('conducted_at', 32)->nullable();
            $table->string('duration', 16)->nullable();
            $table->bigInteger('manager_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->tinyInteger('tour_type_id')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('deleted_at')->nullable();


            $table->foreign('tour_title_id')
                ->references('id')
                ->on('tour_titles')
                ->onDelete('restrict');

            $table->foreign('tour_description_id')
                ->references('id')
                ->on('tour_descriptions')
                ->onDelete('restrict');

            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('restrict');

            $table->foreign('tour_type_id')
                ->references('id')
                ->on('tour_types')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
