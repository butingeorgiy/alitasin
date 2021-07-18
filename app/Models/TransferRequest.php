<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int|null user_id
 * @property string user_name
 * @property string user_phone
 * @property string user_email
 * @property int|null promo_code_id
 * @property PromoCode|null promoCode
 * @property int|null promo_code_init_sale_percent
 * @property float cost_without_sale
 * @property int type_id
 * @property TransferType|null type
 * @property int airport_id
 * @property Airport|null airport
 * @property int destination_id
 * @property TransferDestination|null destination
 * @property int capacity_id
 * @property TransferCapacity|null capacity
 * @property string|null flight_number
 * @property string|null departure
 * @property string|null arrival
 * @property string|null created_at
 */
class TransferRequest extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $attributes = [
        'status_id' => 1
    ];


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

    public function status(): BelongsTo
    {
        return $this->belongsTo(TransferRequestStatus::class);
    }

    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TransferType::class);
    }

    public function airport(): BelongsTo
    {
        return $this->belongsTo(Airport::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(TransferDestination::class);
    }

    public function capacity(): BelongsTo
    {
        return $this->belongsTo(TransferCapacity::class);
    }
}
