<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUaToRegionsTable extends Migration
{
    public function up()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->string('ua_name', 128)->nullable();
            $table->string('ua_description', 2048)->nullable();
        });
    }

    public function down()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn('ua_name');
            $table->dropColumn('ua_description');
        });
    }
}