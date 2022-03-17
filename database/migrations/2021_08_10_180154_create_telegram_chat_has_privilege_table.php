<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramChatHasPrivilegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_chat_has_privilege', function (Blueprint $table) {
            $table->bigInteger('chat_id')->unsigned();
            $table->tinyInteger('privilege_id')->unsigned();

            $table->foreign('chat_id')
                ->references('id')
                ->on('telegram_chats');

            $table->foreign('privilege_id')
                ->references('id')
                ->on('telegram_privileges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telegram_chat_has_privilege');
    }
}
