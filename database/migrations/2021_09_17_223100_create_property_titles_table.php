<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_titles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ru', 256);
            $table->string('en', 256);
            $table->string('tr', 256);
            $table->string('ua', 256);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_titles');
    }
}
