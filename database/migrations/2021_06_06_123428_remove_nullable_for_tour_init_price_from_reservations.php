<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNullableForTourInitPriceFromReservations extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('tour_init_price')->unsigned()->nullable(false)
                ->after('reservation_status_id')->change();
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('tour_init_price')->unsigned()->nullable()
                ->after('reservation_status_id')->change();
        });
    }
}