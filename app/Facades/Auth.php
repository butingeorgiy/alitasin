<?php


namespace App\Facades;

use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Facade;


class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AuthenticationService::class;
    }
}
