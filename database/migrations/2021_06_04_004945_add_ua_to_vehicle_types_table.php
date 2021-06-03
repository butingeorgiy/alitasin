<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUaToVehicleTypesTable extends Migration
{
    public function up()
    {
        Schema::table('vehicle_types', function (Blueprint $table) {
            $table->string('ua_name', 32)->nullable();
        });
    }

    public function down()
    {
        Schema::table('vehicle_types', function (Blueprint $table) {
            $table->dropColumn('ua_name');
        });
    }
}