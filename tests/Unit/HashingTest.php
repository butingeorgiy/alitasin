<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Facades\Hash;

class UserTest extends TestCase
{
    /**
     * @dataProvider passwordHashMakingProvider
     * @param $password
     * @param $user
     * @return void
     */
    public function testPasswordHashMaking($password, $user): void
    {
        print "\n\r\n\r" .
            'Password: ' . $password . "\n\r" .
            'Phone code: ' . ($user->phone_code ?? null) . "\n\r" .
            'Phone: ' . ($user->phone ?? null) . "\n\r" .
            'Result: ' . Hash::make($password, $user) . "\n\r\n\r";
    }

    /**
     * @return array[]
     */
    public function passwordHashMakingProvider(): array
    {
        $password = 'gosha!@#$';
        $user = new class {
            public $phone_code = '7';
            public $phone = '7475051903';
        };

        return [
            [$password, $user]
        ];
    }

    /**
     * @dataProvider passwordHashCheckingProvider
     * @param $password
     * @param $user
     * @return void
     */
    public function testPasswordHashChecking($password, $user): void
    {
        print "\n\r\n\r" .
            'Password: ' . $password . "\n\r" .
            'Password hash: ' . ($user->password ?? null) . "\n\r" .
            'Phone code: ' . ($user->phone_code ?? null) . "\n\r" .
            'Phone: ' . ($user->phone ?? null) . "\n\r" .
            'Result: ' . (Hash::check($password, $user) ? 'true' : 'false') . "\n\r\n\r";
    }

    public function passwordHashCheckingProvider(): array
    {
        $password = 'gosha!@#$';
        $user = new class {
            public $phone_code = '7';
            public $phone = '7475051903';
            public $password = '140f47d2b7c4ddfa94707658fd548a58b9a47b276ff420d28c2e280e198448af';
        };

        return [
            [$password, $user]
        ];
    }
}
