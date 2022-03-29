<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyParamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_params')->insert([
            [
                'en_name' => 'Rooms amount',
                'ru_name' => 'Кол-во комнат',
                'tr_name' => 'Oda miktarı',
                'ua_name' => 'Кількість кімнат'
            ],
            [
                'en_name' => 'Total square, m2',
                'ru_name' => 'Общая площадь, м2',
                'tr_name' => 'Toplam kare, m2',
                'ua_name' => 'Загальна площа, м2'
            ],
            [
                'en_name' => 'Kitchen square, m2',
                'ru_name' => 'Площадь кухни, м2',
                'tr_name' => 'Mutfak meydanı, m2',
                'ua_name' => 'Площа кухні, м2'
            ],
            [
                'en_name' => 'Floor',
                'ru_name' => 'Этаж',
                'tr_name' => 'Zemin',
                'ua_name' => 'Поверх'
            ],
            [
                'en_name' => 'Floors amount',
                'ru_name' => 'Кол-во этажей',
                'tr_name' => 'Kat miktarı',
                'ua_name' => 'Кількість поверхів'
            ],
            [
                'en_name' => 'Built year',
                'ru_name' => 'Год постройки',
                'tr_name' => 'Yapım yılı',
                'ua_name' => 'Рік побудови'
            ],
            [
                'en_name' => 'Construction type',
                'ru_name' => 'Тип строения',
                'tr_name' => 'İnşaat türü',
                'ua_name' => 'Тип конструкції'
            ],
            [
                'en_name' => 'Condition',
                'ru_name' => 'Состояние',
                'tr_name' => 'Koşul',
                'ua_name' => 'Хвороба'
            ],
            [
                'en_name' => 'Bathrooms amount',
                'ru_name' => 'Кол-во санузлов',
                'tr_name' => 'Banyo miktarı',
                'ua_name' => 'Кількість санвузлів'
            ],
            [
                'en_name' => 'Ceiling height',
                'ru_name' => 'Высота потолков',
                'tr_name' => 'Tavan yüksekliği',
                'ua_name' => 'Висота стелі'
            ],
            [
                'en_name' => 'Internet',
                'ru_name' => 'Интернет',
                'tr_name' => '',
                'ua_name' => ''
            ],
            [
                'en_name' => 'Phone',
                'ru_name' => 'Телефон',
                'tr_name' => 'Telefon',
                'ua_name' => 'Телефон'
            ],
            [
                'en_name' => 'Balcony',
                'ru_name' => 'Балкон',
                'tr_name' => 'Balkon',
                'ua_name' => 'Балкон'
            ],
            [
                'en_name' => 'Parking',
                'ru_name' => 'Парковка',
                'tr_name' => 'Otopark',
                'ua_name' => 'Парковка'
            ],
            [
                'en_name' => 'Flooring',
                'ru_name' => 'Пол',
                'tr_name' => 'Döşeme',
                'ua_name' => 'Підлогове покриття'
            ],
            [
                'en_name' => 'Security',
                'ru_name' => 'Безопасность',
                'tr_name' => 'Güvenlik',
                'ua_name' => 'Безпека'
            ],
            [
                'en_name' => 'Other',
                'ru_name' => 'Прочее',
                'tr_name' => 'Diğer',
                'ua_name' => 'Інший'
            ],
        ]);
    }
}
