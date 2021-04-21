<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tour_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('manager_id')->unsigned();
            $table->bigInteger('promo_code_id')->unsigned()->nullable();
            $table->tinyInteger('promo_code_init_sale_percent')->unsigned()->nullable();
            $table->tinyInteger('reservation_status_id')->unsigned()->default(1);
            $table->integer('total_cost_without_sale')->unsigned();
            $table->tinyInteger('prepayment_percent')->unsigned()->nullable();
            $table->string('hotel_name', 64)->nullable();
            $table->string('communication_type', 32)->nullable();
            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->timestamp('created_at')->useCurrent();


            $table->foreign('tour_id')
                ->references('id')
                ->on('tours');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('manager_id')
                ->references('id')
                ->on('users');

            $table->foreign('promo_code_id')
                ->references('id')
                ->on('promo_codes');

            $table->foreign('reservation_status_id')
                ->references('id')
                ->on('reservation_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
