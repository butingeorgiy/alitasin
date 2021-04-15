<?php

use App\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            new class {
                public $phone_code = 7;
                public $phone = 7475051903;
                public $password = 'example1';
                public $full_name = 'Бутин Георгий Юрьевич';
                public $email = 'example1@gmail.com';
                public $account_type_id = '1';
            },
            new class {
                public $phone_code = 7;
                public $phone = 7776824163;
                public $password = 'example2';
                public $full_name = 'Иванов Иван Иванович';
                public $email = 'example2@gmail.com';
                public $account_type_id = '2';
            },
            new class {
                public $phone_code = 1;
                public $phone = 2223334455;
                public $password = 'example3';
                public $full_name = 'Петров Пётр Петрович';
                public $email = 'example3@gmail.com';
                public $account_type_id = '3';
            },
            new class {
                public $phone_code = 38;
                public $phone = 4445556677;
                public $password = 'example4';
                public $full_name = 'Сидоров Василий Евгеньевич';
                public $email = 'example4@gmail.com';
                public $account_type_id = '4';
            },
            new class {
                public $phone_code = 7;
                public $phone = 1234567890;
                public $password = 'example5';
                public $full_name = 'Фёдорова Ксения Витальевна';
                public $email = 'example5@gmail.com';
                public $account_type_id = '5';
            },
        ];

        foreach ($rows as $index => $row) {
            $row->password = Hash::make($row->password, $row);
            $rows[$index] = (array) $row;
        }

        DB::table('users')->insert($rows);
    }
}
