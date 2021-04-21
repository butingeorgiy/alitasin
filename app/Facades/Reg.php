<?php


namespace App\Facades;


use App\Services\RegistrationService;

/**
 * @method static reg(string $phone, string $phoneCode, string $email, string $firstName, $lastName = null, string $accountTypeId = '1', bool $tokenGenerate = true)
 */
class Reg extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RegistrationService::class;
    }
}
