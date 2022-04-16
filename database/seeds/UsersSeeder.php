<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $rows = [
            new class {
                public int $phone_code = 7;
                public int $phone = 7475051903;
                public string $password = 'example1';
                public string $first_name = 'Георгий';
                public string $last_name = 'Бутин';
                public string $email = 'example1@gmail.com';
                public string $account_type_id = '1';
            },
            new class {
                public int $phone_code = 7;
                public int $phone = 7776824163;
                public string $password = 'example2';
                public string $first_name = 'Иван';
                public string $last_name = 'Бутин';
                public string $email = 'example2@gmail.com';
                public string $account_type_id = '2';
            },
            new class {
                public int $phone_code = 1;
                public int $phone = 2223334455;
                public string $password = 'example3';
                public string $first_name = 'Пётр';
                public string $last_name = 'Бутин';
                public string $email = 'example3@gmail.com';
                public string $account_type_id = '3';
            },
            new class {
                public int $phone_code = 38;
                public int $phone = 4445556677;
                public string $password = 'example4';
                public string $first_name = 'Василий';
                public string $last_name = 'Бутин';
                public string $email = 'example4@gmail.com';
                public string $account_type_id = '4';
            },
            new class {
                public int $phone_code = 7;
                public int $phone = 1234567890;
                public string $password = 'example5';
                public string $first_name = 'Ксения';
                public string $last_name = 'Бутин';
                public string $email = 'example5@gmail.com';
                public string $account_type_id = '5';
            }
        ];

        foreach ($rows as $index => $row) {
            $row->password = Hash::make($row->password);
            $rows[$index] = (array) $row;
        }

        DB::table('users')->insert($rows);
    }
}
