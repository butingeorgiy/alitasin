<?php


namespace App\Facades;


use App\Services\SafeVarService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static add(array|string|null $phone)
 */
class SafeVar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SafeVarService::class;
    }
}
