<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_partners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_user_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();


            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('parent_user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_partners');
    }
}
