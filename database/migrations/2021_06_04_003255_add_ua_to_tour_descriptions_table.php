<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUaToTourDescriptionsTable extends Migration
{
    public function up()
    {
        Schema::table('tour_descriptions', function (Blueprint $table) {
            $table->text('ua')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tour_descriptions', function (Blueprint $table) {
            $table->dropColumn('ua');
        });
    }
}