<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            [
                'ru_name' => 'Мармарис',
                'en_name' => 'Marmaris',
                'tr_name' => 'Marmaris',
                'show_at_index_page' => '1'
            ],
            [
                'ru_name' => 'Анталья',
                'en_name' => 'Antalya',
                'tr_name' => 'Antalya',
                'show_at_index_page' => '1'
            ],
            [
                'ru_name' => 'Белек',
                'en_name' => 'Belek',
                'tr_name' => 'Belek',
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
            ],
            [
                'ru_name' => 'Фетхие',
                'en_name' => 'Fethiye',
                'tr_name' => 'Fethiye',
                'show_at_index_page' => '0'
            ]
        ]);
    }
}
