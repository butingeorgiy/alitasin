<?php


namespace App\Facades;

use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Facade;


/**
 * @method static check(string[] $array = null)
 * @method static User user()
 * @method static login(array|string|null $input, array|string|null $input1)
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AuthenticationService::class;
    }
}
