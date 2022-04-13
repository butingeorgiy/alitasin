<?php

namespace App\Facades;

use App\Services\TokenService;
use Illuminate\Support\Facades\Facade;

class Token extends Facade
{
    /**
     * @inheritdoc
     *
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return TokenService::class;
    }
}
