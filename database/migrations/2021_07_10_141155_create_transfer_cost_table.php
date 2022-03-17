<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_cost', function (Blueprint $table) {
            $table->bigInteger('transfer_id')->unsigned();
            $table->tinyInteger('capacity_id')->unsigned();
            $table->tinyInteger('type_id')->unsigned();
            $table->float('cost');


            $table->foreign('transfer_id')
                ->references('id')
                ->on('transfers');

            $table->foreign('capacity_id')
                ->references('id')
                ->on('transfer_capacity');

            $table->foreign('type_id')
                ->references('id')
                ->on('transfer_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_cost');
    }
}
