<?php

namespace App\Facades;

use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Facade;

class Auth extends Facade
{
    /**
     * @inheritdoc
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return AuthenticationService::class;
    }
}
