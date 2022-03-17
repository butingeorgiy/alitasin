<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUaToToursHasAdditionsTable extends Migration
{
    public function up()
    {
        Schema::table('tours_has_additions', function (Blueprint $table) {
            $table->string('ua_description', 128)->nullable();
        });
    }

    public function down()
    {
        Schema::table('tours_has_additions', function (Blueprint $table) {
            $table->dropColumn('ua_description');
        });
    }
}