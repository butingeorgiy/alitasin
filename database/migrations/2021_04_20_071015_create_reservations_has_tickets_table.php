<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsHasTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations_has_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('reservation_id')->unsigned();
            $table->tinyInteger('ticket_id')->unsigned();
            $table->tinyInteger('percent_from_init_cost')->unsigned();
            $table->integer('amount')->unsigned();


            $table->foreign('reservation_id')
                ->references('id')
                ->on('reservations');

            $table->foreign('ticket_id')
                ->references('id')
                ->on('tickets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations_has_tickets');
    }
}
