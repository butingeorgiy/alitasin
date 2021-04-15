<?php

namespace Tests\Unit;

use App\Facades\Auth;
use App\Facades\Token;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @dataProvider isAuthByPasswordWorkedSuccessfullyWithRightCredentialsProvider
     * @param $phone
     * @param $password
     */
    public function testIsAuthByPasswordWorkedSuccessfullyWithRightCredentials($phone, $password)
    {
        $authResponse = Auth::login($phone, collect(['password' => $password]));

        print "\n\r\n\r" . print_r($authResponse) . "\n\r\n\r";

        $this->assertTrue($authResponse['status']);
    }

    /**
     * @return \string[][]
     */
    public function isAuthByPasswordWorkedSuccessfullyWithRightCredentialsProvider(): array
    {
        return [
            ['77475051903', 'gosha!@#$']
        ];
    }

    /**
     * @dataProvider isAuthByPasswordWorkedSuccessfullyWithWrongCredentialsProvider
     * @param $phone
     * @param $password
     */
    public function testIsAuthByPasswordWorkedSuccessfullyWithWrongCredentials($phone, $password)
    {
        $authResponse = Auth::login($phone, collect(['password' => $password]));

        $this->assertFalse($authResponse['status']);
    }

    /**
     * @return \string[][]
     */
    public function isAuthByPasswordWorkedSuccessfullyWithWrongCredentialsProvider(): array
    {
        return [
            ['77475051903', 'qwerty123']
        ];
    }

    public function test1()
    {
        print (Token::check() ? 'true' : 'false');
    }
}
