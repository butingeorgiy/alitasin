<?php

namespace App\Models;

use App\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @method static isEmailUnique($email)
 * @method static find(array|string $id)
 * @method static where(string $string, array|string|null $input)
 * @method static managers()
 * @method static partners()
 * @method static create(string[] $array)
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
 * @property int total_profit
 * @property int total_payment_amount
 * @property int total_income
 * @property int profit_percent
 */
class User extends Model
{
    use SoftDeletes;


    public $timestamps = false;

    protected $guarded = [];

    public function scopeIsEmailUnique($query, $email): bool
    {
        return $query->where('email', $email)->get()->first() === null;
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(AuthToken::class)->where(
            DB::raw('UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_at)'),
            '<',
            DB::raw('time_valid')
        );
    }

    /**
     * Get users with manager's access
     *
     * @param $query
     * @return mixed
     */
    public function scopeManagers($query)
    {
        return $query->where('account_type_id', '4');
    }

    /**
     * Get users with partner's access
     *
     * @param $query
     * @return mixed
     */
    public function scopePartners($query)
    {
        return $query->where('account_type_id', '2');
    }

    public function getPhoneAttribute(): ?string
    {
        $phoneCode = $this->phone_code;
        $phone = $this->getOriginal('phone');

        if (!$phoneCode or !$phone) {
            return null;
        }

        if(preg_match( '/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/', $phoneCode . $phone,  $matches)) {
            return $matches[1] . ' ' . $matches[2] . ' ' .$matches[3] . ' ' . $matches[4];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        $firstName = $this->first_name;
        $lastName = $this->last_name;

        if (!$lastName) {
            return $firstName;
        } else {
            return $lastName . ' ' . $firstName;
        }
    }

    public function generatePassword(): string
    {
        $randomPassword = Str::random(10);
        $this->password = Hash::make($randomPassword, $this);
        return $randomPassword;
    }

    public function recentViewed(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'recent_viewed_tours');
    }

    public function reservedTours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'reservations');
    }

    public function favoriteTours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'favorite_tours');
    }

    public function percent(): HasOne
    {
        return $this->hasOne(PartnerPercent::class, 'user_id');
    }

    // Partner methods

    /**
     * Get attracted reservations by partner
     *
     * @return HasManyThrough
     */
    public function attractedReservations(): HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, PromoCode::class);
    }

    /**
     * Get partner payments
     *
     * @return HasMany
     */
    public function partnerPayments(): HasMany
    {
        return $this->hasMany(PartnerPayment::class, 'partner_id');
    }

    /**
     * Get total income attracted by partner
     *
     * @return int
     */
    public function getTotalIncomeAttribute(): int
    {
        /**
         * @var $attractedReservations Reservation[]
         */
        $attractedReservations = $this->attractedReservations()->get();
        $totalIncome = 0;

        foreach ($attractedReservations as $item) {
            $totalIncome += $item->costWithSale();
        }

        return $totalIncome;
    }

    /**
     * Get partner profit
     *
     * @return int
     */
    public function getTotalProfitAttribute(): int
    {
        /**
         * @var $attractedReservations Reservation[]
         */
        $attractedReservations = $this->attractedReservations()->get();
        $totalProfit = 0;
        $profitPercent = $this->profit_percent;

        foreach ($attractedReservations as $item) {
            $totalProfit += $item->costWithSale() * $profitPercent / 100;
        }

        return $totalProfit;
    }

    /**
     * Get partner total payment amount
     *
     * @return int
     */
    public function getTotalPaymentAmountAttribute(): int
    {
        /**
         * @var $partnerPayments PartnerPayment[]
         */
        $partnerPayments = $this->partnerPayments()->get();
        $amount = 0;

        foreach ($partnerPayments as $item) {
            $amount += $item->amount;
        }

        return $amount;
    }

    /**
     * Get personal partner profit percent
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
}
