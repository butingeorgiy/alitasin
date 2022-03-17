<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUaToReservationStatusesTable extends Migration
{
    public function up()
    {
        Schema::table('reservation_statuses', function (Blueprint $table) {
            $table->string('ua_name', 32)->nullable();
        });
    }

    public function down()
    {
        Schema::table('reservation_statuses', function (Blueprint $table) {
            $table->dropColumn('ua_name');
        });
    }
}