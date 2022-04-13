<?php

namespace App\Services\PartnerCounter;

use App\Models\PromoCode;
use App\Services\PartnerCounter\Drivers\CounterInterface;

class Client
{
    /**
     * Promo code model instance.
     *
     * @var PromoCode
     */
    protected PromoCode $promoCode;
    /**
     * Class constructor.
     *
     * @param PromoCode $promoCode
     */
    public function __construct(PromoCode $promoCode)
    {
        $this->promoCode = $promoCode;
    }

    /**
     * Calculate required operations and return optional parameters.
     *
     * @param CounterInterface $driver
     *
     * @return array
     */
    public function calculate(CounterInterface $driver): array
    {
        return $driver->calculate($this->promoCode);
    }
}