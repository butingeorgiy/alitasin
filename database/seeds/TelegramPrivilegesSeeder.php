<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TelegramPrivilegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'alias' => 'main_admin',
                'description' => 'Can receive any notifications'
            ],
            [
                'id' => 2,
                'alias' => 'reservation_manager',
                'description' => 'Can receive only notifications about new reservations'
            ],
            [
                'id' => 3,
                'alias' => 'transfer_manager',
                'description' => 'Can receive only notifications about new transfer requests'
            ]
        ];

        DB::table('telegram_privileges')->insert($data);
    }
}
