<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ru_name', 128);
            $table->string('en_name', 128);
            $table->string('tr_name', 128);
            $table->string('ru_description', 2048)->nullable();
            $table->string('en_description', 2048)->nullable();
            $table->string('tr_description', 2048)->nullable();
            $table->enum('show_at_index_page', ['0', '1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
