<?php

use Illuminate\Database\Seeder;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            [
                'ru_name' => 'Стамбул',
                'en_name' => 'Istanbul',
                'tr_name' => 'İstanbul',
                'show_at_index_page' => '1'
            ],
            [
                'ru_name' => 'Анталья',
                'en_name' => 'Antalya',
                'tr_name' => 'Antalya',
                'show_at_index_page' => '1'
            ],
            [
                'ru_name' => 'Кемер',
                'en_name' => 'Kemer',
                'tr_name' => 'Kemer',
                'show_at_index_page' => '1'
            ],
            [
                'ru_name' => 'Аланья',
                'en_name' => 'Alanya',
                'tr_name' => 'Alanya',
                'show_at_index_page' => '1'
            ],
            [
                'ru_name' => 'Сиде',
                'en_name' => 'Side',
                'tr_name' => 'Side',
                'show_at_index_page' => '1'
            ],
            [
                'ru_name' => 'Бодрум',
                'en_name' => 'Bodrum',
                'tr_name' => 'Bodrum',
                'show_at_index_page' => '1'
            ]
        ]);
    }
}
