<?php

use Illuminate\Database\Seeder;

class ReservationStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservation_statuses')->insert([
            [
                'en_name' => 'Formed',
                'ru_name' => 'Сформирован',
                'tr_name' => 'Oluşturulan'
            ],
            [
                'en_name' => 'Arrived',
                'ru_name' => 'Прибыл',
                'tr_name' => 'Geldi'
            ],
            [
                'en_name' => 'Not arrived',
                'ru_name' => 'Не прибыл',
                'tr_name' => 'Varmadı'
            ]
        ]);
    }
}
