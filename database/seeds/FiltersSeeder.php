<?php

use Illuminate\Database\Seeder;

class FiltersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filters = [
            [
                'ru_name' => 'Популярные',
                'en_name' => 'Popular',
                'tr_name' => 'Popüler',
            ],
            [
                'ru_name' => 'Выездные',
                'en_name' => 'Outgoing',
                'tr_name' => 'Dışa dönük',
            ],
            [
                'ru_name' => 'Обзорные',
                'en_name' => 'Sightseeing',
                'tr_name' => 'Gezi',
            ],
            [
                'ru_name' => 'Необычные',
                'en_name' => 'Fancy',
                'tr_name' => 'Fantezi',
            ],
            [
                'ru_name' => 'Авторские',
                'en_name' => "Author's",
                'tr_name' => 'Telif hakkı',
            ],
            [
                'ru_name' => 'Развлечения',
                'en_name' => 'Entertainment',
                'tr_name' => 'Eğlence',
            ]
        ];

        DB::table('filters')->insert($filters);
    }
}
