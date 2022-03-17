<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferCapacityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_capacity', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('en_name');
            $table->string('ru_name');
            $table->string('tr_name');
            $table->string('ua_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_capacity');
    }
}
