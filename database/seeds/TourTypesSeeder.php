<?php

use Illuminate\Database\Seeder;

class TourTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
