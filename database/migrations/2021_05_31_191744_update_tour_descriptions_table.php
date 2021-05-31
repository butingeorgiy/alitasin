<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTourDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_descriptions', function (Blueprint $table) {
            $table->text('ru')->change();
            $table->text('en')->change();
            $table->text('tr')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tour_descriptions', function (Blueprint $table) {
            $table->string('ru', 2048)->change();
            $table->string('en', 2048)->change();
            $table->string('tr', 2048)->change();
        });
    }
}
