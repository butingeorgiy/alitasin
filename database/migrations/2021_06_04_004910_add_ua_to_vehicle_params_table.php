<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUaToVehicleParamsTable extends Migration
{
    public function up()
    {
        Schema::table('vehicle_params', function (Blueprint $table) {
            $table->string('ua_name', 64)->nullable();
        });
    }

    public function down()
    {
        Schema::table('vehicle_params', function (Blueprint $table) {
            $table->dropColumn('ua_name');
        });
    }
}