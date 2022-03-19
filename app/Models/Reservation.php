<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property mixed promo_code_id
 * @property mixed promo_code_init_sale_percent
 * @property string hotel_name
 * @property string communication_type
 * @property mixed time
 * @property mixed date
 * @property mixed total_cost_without_sale
 * @property mixed created_at
 * @property string|null hotel_room_number
 * @property int|null region_id
 * @property User user
 * @property Tour tour
 * @property PromoCode promoCode
 * @property int tour_init_price
 * @method static limit(int $int)
 * @method static Reservation find($reservationId)
 * @method static Reservation|Collection findOrFail(mixed $id)
 */
class Reservation extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    public function attachPromoCode(PromoCode $promoCode): void
    {
        $this->promo_code_id = $promoCode->id;
        $this->promo_code_init_sale_percent = $promoCode->sale_percent;
    }

    /**
     * Interact with reservation's date.
     *
     * @return Attribute
     */
    public function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value): ?string => is_null($value) ? null : Carbon::parse($value)->format('d.m.Y')
        );
    }

    /**
     * Interact with reservation's time.
     *
     * @return Attribute
     */
    public function time(): Attribute
    {
        return Attribute::make(
            get: fn ($value): ?string => is_null($value) ? null : Carbon::parse($value)->format('H:i')
        );
    }

    /**
     * Reservation's tickets
     *
     * @return BelongsToMany
     */
    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(
            Ticket::class,
            'reservations_has_tickets'
        );
    }

    /**
     * Reservation's tour
     *
     * @return BelongsTo
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Reservation's user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Reservation's manager
     *
     * @return BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Reservation's promo code
     *
     * @return BelongsTo
     */
    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class);
    }

    /**
     * Reservation's status
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(ReservationStatus::class, 'reservation_status_id');
    }

    /**
     * Reservation's region
     *
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get total cost of reservation without sale
     *
     * @return float
     */
    public function costWithoutSale(): float
    {
        return (float) $this->total_cost_without_sale;
    }

    /**
     * Get total cost of reservation with sale
     *
     * @return float
     */
    public function costWithSale(): float
    {
        if ($this->isUsedPromoCode()) {
            return $this->costWithoutSale() * (100 - $this->promoCodeSalePercent()) / 100;
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

    /**
     * Get promo code init percent. Return NULL if promo code was not used
     *
     * @return int|null
     */
    public function promoCodeSalePercent(): ?int
    {
        if ($this->isUsedPromoCode()) {
            return (int) $this->promo_code_init_sale_percent;
        }

        return null;
    }

    /**
     * Get date of creating
     *
     * @return string
     */
    public function createAtDate(): string
    {
        return Carbon::parse($this->created_at)->format('d.m.Y');
    }

    /**
     * Get time of creating
     *
     * @return string
     */
    public function createAtTime(): string
    {
        return Carbon::parse($this->created_at)->format('H:i');
    }
}
