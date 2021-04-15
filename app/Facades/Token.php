<?php


namespace App\Facades;


use App\Services\TokenService;
use Illuminate\Support\Facades\Facade;

class Token extends Facade
{
    public static function getFacadeAccessor()
    {
        return TokenService::class;
    }
}
