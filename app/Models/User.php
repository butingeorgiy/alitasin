<?php

namespace App\Models;

use App\Traits\PartnerCalculator;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

/**
 * @method static isEmailUnique($email)
 * @method static Collection|User|null find(array|string $id)
 * @method static Builder where(string $string, array|string|null $input)
 * @method static Builder managers()
 * @method static Builder partners()
 * @method static create(string[] $array)
 * @method static Builder selectRaw(string $expression)
 * @property string full_name
 * @property string first_name
 * @property string account_type_id
 * @property string last_name
 * @property string phone_code
 * @property string password
 * @property integer id
 * @property string email
 * @property mixed recentViewed
 * @property mixed reservedTours
 * @property mixed favoriteTours
 * @property int profit_percent
 * @property int sub_partners_profit_percent
 * @property string profile
 * @property string phone
 *
 * @mixin Builder
 */
class User extends Authenticatable implements FilamentUser
{
    use SoftDeletes;
    use PartnerCalculator;

    /**
     * @inheritdoc
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @inheritdoc
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Define is user's email is unique.
     *
     * @param Builder $query
     * @param string $email
     *
     * @return bool
     */
    public function scopeIsEmailUnique(Builder $query, string $email): bool
    {
        return $query->where('email', $email)->get()->first() === null;
    }

    /**
     * Get user's tokens.
     *
     * @return HasMany
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(AuthToken::class)->where(
            DB::raw('UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_at)'),
            '<',
            DB::raw('time_valid')
        );
    }

    /**
     * Get users with manager's access.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeManagers(Builder $query): Builder
    {
        return $query->where('account_type_id', '4');
    }

    /**
     * Get users with partner's access.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePartners(Builder $query): Builder
    {
        return $query->where('account_type_id', '2');
    }

    /**
     * Interact with user's phone.
     *
     * @return Attribute
     */
    public function phone(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (!$attributes['phone_code'] or !$value) {
                    return null;
                }

                if (preg_match('/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/', $attributes['phone_code'] . $value, $matches)) {
                    return $matches[1] . ' ' . $matches[2] . ' ' . $matches[3] . ' ' . $matches[4];
                }

                return null;
            }
        );
    }

    /**
     * Interact with user's full name.
     *
     * @return Attribute
     */
    public function fullName(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (!$attributes['last_name']) {
                    return $attributes['first_name'];
                } else {
                    return $attributes['last_name'] . ' ' . $attributes['first_name'];
                }
            }
        );
    }

    /**
     * Get recent viewed tours.
     *
     * @return BelongsToMany
     */
    public function recentViewed(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'recent_viewed_tours');
    }

    /**
     * Get reserved tours.
     *
     * @return BelongsToMany
     */
    public function reservedTours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'reservations');
    }

    /**
     * Get favorite tours.
     *
     * @return BelongsToMany
     */
    public function favoriteTours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'favorite_tours');
    }


    # Partner methods

    /**
     * Get partner's profit percent.
     *
     * @return HasOne
     */
    public function percent(): HasOne
    {
        return $this->hasOne(PartnerPercent::class, 'user_id');
    }

    /**
     * Get sub partner's profit percent.
     *
     * @return HasOne
     */
    public function subPartnerPercent(): HasOne
    {
        return $this->hasOne(SubPartnerPercent::class, 'user_id');
    }

    /**
     * Get attracted reservations by partner.
     *
     * @return HasManyThrough
     */
    public function attractedReservations(): HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, PromoCode::class);
    }

    /**
     * Get attracted transfers by partner.
     *
     * @return HasManyThrough
     */
    public function attractedTransfers(): HasManyThrough
    {
        return $this->hasManyThrough(TransferRequest::class, PromoCode::class);
    }

    /**
     * Get attracted vehicles by partner.
     *
     * @return HasManyThrough
     */
    public function attractedVehicles(): HasManyThrough
    {
        return $this->hasManyThrough(VehicleOrder::class, PromoCode::class);
    }


    /**
     * Get partner's promo codes.
     *
     * @return HasMany
     */
    public function promoCodes(): HasMany
    {
        return $this->hasMany(PromoCode::class);
    }

    /**
     * Get partner payments.
     *
     * @return HasMany
     */
    public function partnerPayments(): HasMany
    {
        return $this->hasMany(PartnerPayment::class, 'partner_id');
    }

    /**
     * Get partner city.
     *
     * @return HasOne
     */
    public function partnerCity(): HasOne
    {
        return $this->hasOne(PartnerCity::class, 'partner_id');
    }

    /**
     * Get personal partner profit percent.
     *
     * @return int
     */
    public function getProfitPercentAttribute(): int
    {
        if (!$percent = $this->percent()->get()->first()) {
            return 0;
        }

        return $percent->percent;
    }

    /**
     * Get sub partner profit percent.
     *
     * @return int|null
     */
    public function getSubPartnersProfitPercentAttribute(): ?int
    {
        if (!$subPartnerProfitPercent = $this->subPartnerPercent()->get()->first()) {
            return null;
        }

        return $subPartnerProfitPercent->percent;
    }

    /**
     * Determine if user is sub partner.
     *
     * @return bool
     */
    public function isSubPartner(): bool
    {
        return DB::table('sub_partners')
            ->where('user_id', $this->id)->exists();
    }

    /**
     * Get ids of sub partners
     *
     * @return array
     */
    public function subPartnerIds(): array
    {
        $subPartnerIds = [];

        foreach (DB::table('sub_partners')->select('user_id')
                     ->where('parent_user_id', $this->id)->get() as $item) {
            $subPartnerIds[] = $item->user_id;
        }

        return $subPartnerIds;
    }

    /**
     * Determine if user has sub partners
     *
     * @return bool
     */
    public function hasSubPartners(): bool
    {
        return DB::table('sub_partners')
            ->where('parent_user_id', $this->id)->exists();
    }

    /**
     * Update profit percent
     *
     * @param int $newValue
     * @return bool
     */
    public function updateProfitPercent(int $newValue): bool
    {
        if (!$percent = $this->percent()->get()->first()) {
            return false;
        }

        $percent->percent = $newValue;

        return $percent->save();
    }

    /**
     * Update sub partner's profit percent
     *
     * @param int $newValue
     * @return bool
     */
    public function updateSubPartnerProfitPercent(int $newValue): bool
    {
        if (!$subPartnerProfitPercent = $this->subPartnerPercent()->get()->first()) {
            return false;
        }

        $subPartnerProfitPercent->percent = $newValue;

        return $subPartnerProfitPercent->save();
    }

    /**
     * @return bool
     */
    public function canAccessFilament(): bool
    {
        return $this->account_type_id == 5;
    }
}
