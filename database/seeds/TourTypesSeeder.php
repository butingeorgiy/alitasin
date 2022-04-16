<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $types = [
            [
                'ru_name' => 'Индивидуальная',
                'en_name' => 'Individual',
                'tr_name' => 'Bireysel'
            ],
            [
                'ru_name' => 'Групповая',
                'en_name' => 'Group',
                'tr_name' => 'Grup'
            ]
        ];

        DB::table('tour_types')->insert($types);
    }
}
