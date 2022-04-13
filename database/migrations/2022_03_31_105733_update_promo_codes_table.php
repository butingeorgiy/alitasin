<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropForeign('promo_codes_user_id_foreign');
            $table->dropColumn('user_id');

            $table->bigInteger('partner_id', unsigned: true);

            # Foreign keys

            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropForeign('promo_codes_partner_id_foreign');
            $table->dropColumn('partner_id');

            $table->bigInteger('user_id', unsigned: true);

            # Foreign keys

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }
};
