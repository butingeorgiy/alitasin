<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVehicleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_orders', function (Blueprint $table) {
            $table->bigInteger('promo_code_id')
                ->unsigned()
                ->nullable()
                ->after('user_id');

            $table->tinyInteger('promo_code_init_sale_percent')
                ->unsigned()
                ->nullable()
                ->after('promo_code_id');

            $table->float('cost_without_sale')
                ->after('promo_code_init_sale_percent');

            $table->foreign('promo_code_id')
                ->references('id')
                ->on('promo_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_orders', function (Blueprint $table) {
            $table->dropForeign('vehicle_orders_promo_code_id_foreign');

            $table->dropColumn('promo_code_id');
            $table->dropColumn('promo_code_init_sale_percent');
            $table->dropColumn('cost_without_sale');
        });
    }
}
