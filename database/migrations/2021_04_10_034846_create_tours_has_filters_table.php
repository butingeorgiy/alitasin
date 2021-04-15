<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursHasFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours_has_filters', function (Blueprint $table) {
            $table->bigInteger('tour_id')->unsigned();
            $table->tinyInteger('filter_id')->unsigned();


            $table->foreign('tour_id')
                ->references('id')
                ->on('tours')
                ->onDelete('restrict');

            $table->foreign('filter_id')
                ->references('id')
                ->on('filters')
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
        Schema::dropIfExists('tours_has_filters');
    }
}
