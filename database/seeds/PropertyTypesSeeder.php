<?php

use Illuminate\Database\Seeder;

class PropertyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_types')->insert([
            [
                'en_name' => 'For sale',
                'ru_name' => 'На продажу',
                'tr_name' => 'Satılık',
                'ua_name' => 'На продаж'
            ],
            [
                'en_name' => 'Rentals',
                'ru_name' => 'Аренда',
                'tr_name' => 'Kiralama',
                'ua_name' => 'Оренда'
            ]
        ]);
    }
}
