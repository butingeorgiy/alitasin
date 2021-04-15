<?php


namespace App\Facades;


use App\Helpers\RussianDeclensionsResolving;
use Illuminate\Support\Facades\Facade;

class RusDecl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RussianDeclensionsResolving::class;
    }
}
