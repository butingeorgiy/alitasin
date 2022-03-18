<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCostUnitIdToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->tinyInteger('cost_unit_id')->nullable()->unsigned();

            $table->foreign('cost_unit_id')
                ->references('id')
                ->on('cost_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign('properties_cost_unit_id_foreign');
            $table->dropColumn('cost_unit_id');
        });
    }
}
