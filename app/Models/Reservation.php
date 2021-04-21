<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property integer promo_code_id
 * @property integer promo_code_init_sale_percent
 * @property string hotel_name
 * @property string communication_type
 * @property mixed time
 * @property mixed date
 */
class Reservation extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    public function attachPromoCode(PromoCode $promoCode)
    {
        $this->promo_code_id = $promoCode->id;
        $this->promo_code_init_sale_percent = $promoCode->sale_percent;
    }

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(
            Ticket::class,
            'reservations_has_tickets'
        );
    }
}
