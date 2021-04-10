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
            $table->string('address', 256);
            $table->bigInteger('manager_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('deleted_at')->nullable();


            $table->foreign('tour_title_id')
                ->references('id')
                ->on('tour_titles');

            $table->foreign('tour_description_id')
                ->references('id')
                ->on('tour_descriptions');

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
        Schema::dropIfExists('tours');
    }
}
