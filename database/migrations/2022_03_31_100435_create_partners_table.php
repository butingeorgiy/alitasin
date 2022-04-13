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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', unsigned: true);
            $table->bigInteger('parent_id', unsigned: true)->nullable();

            $table->string('city')->nullable();

            $table->float('profit_percent', 5, unsigned: true)
                ->default(5.0)
                ->comment('Процент доходности партнёра');

            $table->double('company_income', 10, 2, true)
                ->comment('Доход компании, который был привлечен данным партнёром');

            $table->double('earned_profit', 10, 2, true)
                ->comment('Прибыль, на которую может претендовать данный партнёр');

            $table->double('received_profit', 10, 2, true)
                ->comment('Прибыль, которую уже получил данный партнёр');

            # Foreign keys

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('parent_id')
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
        Schema::dropIfExists('partners');
    }
};
