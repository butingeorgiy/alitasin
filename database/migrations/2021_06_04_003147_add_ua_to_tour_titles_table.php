<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUaToTourTitlesTable extends Migration
{
    public function up()
    {
        Schema::table('tour_titles', function (Blueprint $table) {
            $table->string('ua')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tour_titles', function (Blueprint $table) {
            $table->dropColumn('ua');
        });
    }
}