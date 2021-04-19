<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone_code', 4);
            $table->char('phone', 10);
            $table->char('password', 64);
            $table->string('first_name', 32);
            $table->string('last_name', 32)->nullable();
            $table->string('email', 128)->unique();
            $table->enum('account_type_id', ['1', '2', '3', '4', '5']);
            $table->timestamp('created_at')->useCurrent();


            $table->foreign('account_type_id')
                ->references('id')
                ->on('account_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
