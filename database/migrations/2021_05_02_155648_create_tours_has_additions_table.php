<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursHasAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours_has_additions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('addition_id')->unsigned();
            $table->bigInteger('tour_id')->unsigned();
            $table->enum('is_include', ['0', '1']);
            $table->string('en_description', 128)->nullable();
            $table->string('ru_description', 128)->nullable();
            $table->string('tr_description', 128)->nullable();


            $table->foreign('addition_id')
                ->references('id')
                ->on('additions');

            $table->foreign('tour_id')
                ->references('id')
                ->on('tours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours_has_additions');
    }
}
