<?php


namespace App\Facades;

use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Facade;


/**
 * @method static check(string[] $array = null)
 * @method static User user()
 * @method static login(string $email, string $password)
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AuthenticationService::class;
    }
}
