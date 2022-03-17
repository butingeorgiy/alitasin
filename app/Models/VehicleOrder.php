<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null promo_code_id
 * @property PromoCode|null promoCode
 * @property int|null promo_code_init_sale_percent
 * @property float cost_without_sale
 *
 * @mixin Builder
 */
class VehicleOrder extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    public function attachPromoCode(PromoCode $promoCode): void
    {
        $this->promo_code_id = $promoCode->id;
        $this->promo_code_init_sale_percent = $promoCode->sale_percent;
    }

    public function costWithoutSale(): float
    {
        return $this->cost_without_sale;
    }

    public function costWithSale(): float
    {
        if ($this->isUsedPromoCode()) {
            return $this->costWithoutSale() * (100 - $this->promo_code_init_sale_percent) / 100;
        }

        return $this->costWithoutSale();
    }

    /**
     * Define is promo code was used
     *
     * @return bool
     */
    public function isUsedPromoCode(): bool
    {
        if (PromoCode::find($this->promo_code_id) and $this->promo_code_init_sale_percent) {
            return true;
        }

        return false;
    }
}
