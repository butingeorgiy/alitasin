<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
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
                public $phone = 7776824163;
                public $password = 'gosha!@#$';
                public $account_type_id = '0';
            },
            new class {
                public $phone_code = 7;
                public $phone = 7776824163;
                public $password = 'gosha!@#$';
                public $account_type_id = '1';
            },
            new class {
                public $phone_code = 7;
                public $phone = 7776824163;
                public $password = 'gosha!@#$';
                public $account_type_id = '2';
            },
            new class {
                public $phone_code = 7;
                public $phone = 7776824163;
                public $password = 'gosha!@#$';
                public $account_type_id = '3';
            },
        ];

        foreach ($rows as $index => $row) {
            $row->password = \App\Facades\Hash::make($row->password, $row);
            $rows[$index] = (array) $row;
        }

        DB::table('users')->insert($rows);
    }
}
