<?php


namespace App\Facades;


use App\Services\TokenService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static create($user)
 * @method static getId($user)
 */
class Token extends Facade
{
    public static function getFacadeAccessor()
    {
        return TokenService::class;
    }
}
