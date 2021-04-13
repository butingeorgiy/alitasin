<?php


namespace App\Helpers;


class RussianDeclensionsResolving
{
    public function resolve(int $int, array $vars): string
    {
        return $int . ' ' . $vars[($int % 100 > 4 && $int % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][min($int % 10, 5)]];
    }
}
