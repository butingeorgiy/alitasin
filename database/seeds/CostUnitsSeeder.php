<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('cost_units')->insert([
            [
                'id' => 1,
                'en_name' => 'Day',
                'ru_name' => 'День',
                'tr_name' => 'Gün',
                'ua_name' => 'День'
            ],
            [
                'id' => 2,
                'en_name' => 'Month',
                'ru_name' => 'Месяц',
                'tr_name' => 'Ay',
                'ua_name' => 'Місяць'
            ]
        ]);
    }
}
