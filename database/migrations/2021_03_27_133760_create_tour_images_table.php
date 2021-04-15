<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tour_id')->unsigned();
            $table->string('link', 20);
            $table->enum('is_main', ['0', '1'])->default('0');


            $table->foreign('tour_id')
                ->references('id')
                ->on('tours')
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
        Schema::dropIfExists('tour_images');
    }
}
