<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUaToAdditionsTable extends Migration
{
    public function up()
    {
        Schema::table('additions', function (Blueprint $table) {
            $table->string('ua_title', 64)->nullable();
        });
    }

    public function down()
    {
        Schema::table('additions', function (Blueprint $table) {
            $table->dropColumn('ua_title');
        });
    }
}