<?php

namespace App\Services\PartnerCounter\Drivers;

use App\Models\PromoCode;

interface CounterInterface
{
    /**
     * Calculate and execute required operations.
     *
     * @param PromoCode $promoCode
     *
     * @return array
     */
    public function calculate(PromoCode $promoCode): array;
}