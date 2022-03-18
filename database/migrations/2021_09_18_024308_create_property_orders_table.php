<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('user_name',32);
            $table->string('user_phone', 14);
            $table->integer('property_id')->unsigned();
            $table->timestamp('created_at')->useCurrent();


            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('property_id')
                ->references('id')
                ->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_orders');
    }
}
