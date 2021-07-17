<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('user_name');
            $table->string('user_phone', 14);
            $table->string('user_email', 128);

            $table->bigInteger('promo_code_id')->unsigned()->nullable();
            $table->tinyInteger('promo_code_init_sale_percent')->unsigned()->nullable();

            $table->float('cost_without_sale');

            $table->tinyInteger('type_id')->unsigned();
            $table->bigInteger('airport_id')->unsigned();
            $table->bigInteger('destination_id')->unsigned();
            $table->tinyInteger('capacity_id')->unsigned();
            $table->tinyInteger('status_id')->unsigned();

            $table->string('flight_number')->nullable();

            $table->timestamp('departure')->nullable();
            $table->timestamp('arrival')->nullable();

            $table->timestamp('created_at')->useCurrent();


            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('promo_code_id')
                ->references('id')
                ->on('promo_codes');

            $table->foreign('type_id')
                ->references('id')
                ->on('transfer_types');

            $table->foreign('airport_id')
                ->references('id')
                ->on('airports');

            $table->foreign('destination_id')
                ->references('id')
                ->on('transfer_destinations');

            $table->foreign('capacity_id')
                ->references('id')
                ->on('transfer_capacity');

            $table->foreign('status_id')
                ->references('id')
                ->on('transfer_request_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_requests');
    }
}
