<?php


namespace App\Facades;

use App\Services\HashService;
use Illuminate\Support\Facades\Facade;


class Hash extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HashService::class;
    }
}