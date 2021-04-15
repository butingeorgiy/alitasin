<?php


namespace App\Services;

use Exception;
use Throwable;

class HashService
{
    /**
     * Create hash from user password
     *
     * @param $password
     * @param $user
     * @return string
     * @throws Exception
     */
    public function make($password, $user) {
        if (strlen($password) < 8) {
            throw new Exception('Can\'t create hash! The password is less than 8 characters long.');
        }

        if (!isset($user->email)) {
            throw new Exception('Object of user do not have email attribute!');
        }


        return hash('sha256', 'VfYD$a(1' . substr($password, 0, 5) .
            $user->email . substr($password, 5) . 'jF#0d@)ds');
    }

    public function check($password, $user) {
        if (strlen($password) < 8) {
            throw new Exception('Can\'t check hash! The password is less than 8 characters long.');
        }

        if (!isset($user->email)) {
            throw new Exception('Object of user do not have email attribute!');
        }

        if (!isset($user->password)) {
            throw new Exception('Object of user do not have password attribute!');
        }


        $hash = hash('sha256', 'VfYD$a(1' . substr($password, 0, 5) .
            $user->email . substr($password, 5) . 'jF#0d@)ds');

        return $hash === $user->password;
    }
}
