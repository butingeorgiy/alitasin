<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('tickets')->insert([
            [
                'en_name' => 'Adult',
                'ru_name' => 'Взрослый',
                'tr_name' => 'Yetişkin',
                'percent_from_init_cost' => 100
            ],
            [
                'en_name' => 'Children (up to 12 age)',
                'ru_name' => 'Детский (до 12 лет)',
                'tr_name' => 'Çocuklar (12 yaşına kadar)',
                'percent_from_init_cost' => 50
            ],
            [
                'en_name' => 'Children (up to 6 age)',
                'ru_name' => 'Детский (до 6 лет)',
                'tr_name' => 'Çocuklar (6 yaşına kadar)',
                'percent_from_init_cost' => 0
            ]
        ]);
    }
}
