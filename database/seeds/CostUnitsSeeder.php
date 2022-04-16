<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'en_name' => 'Day',
                'ru_name' => 'День',
                'tr_name' => 'Gün',
                'ua_name' => 'День'
            ],
            [
                'en_name' => 'Month',
                'ru_name' => 'Месяц',
                'tr_name' => 'Ay',
                'ua_name' => 'Місяць'
            ]
        ]);
    }
}
