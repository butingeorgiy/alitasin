<?php


namespace App\Facades;

use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Facade;


/**
 * @method static check(string[] $array)
 * @method static user()
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AuthenticationService::class;
    }
}
