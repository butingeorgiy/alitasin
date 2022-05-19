<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            ['title' => 'Клиент'],
            ['title' => 'Партнёр'],
            ['title' => 'Редактор'],
            ['title' => 'Менеджер'],
            ['title' => 'Главный менеджер']
        ];

        DB::table('account_types')->insert($rows);
    }
}
