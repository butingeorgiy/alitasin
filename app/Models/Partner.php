<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property int id
 * @property int user_id
 * @property int|null parent_id
 * @property string|null city
 * @property float profit_percent
 * @property float company_income
 * @property float earned_profit
 * @property float received_profit
 *
 * @property User user
 * @property Partner|null parent
 *
 * @mixin Builder
 */
class Partner extends Model
{
    use SoftDeletes;

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


    # Relations

    /**
     * Retrieve user relation.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Retrieve parent partner relation.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'parent_id');
    }

    /**
     * Retrieve promo codes relations.
     *
     * @return HasMany
     */
    public function promoCodes(): HasMany
    {
        return $this->hasMany(PromoCode::class);
    }

    /**
     * Retrieve attracted reservation relations.
     *
     * @return HasManyThrough
     */
    public function attractedReservations(): HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, PromoCode::class);
    }

    /**
     * Retrieve attracted transfers relations.
     *
     * @return HasManyThrough
     */
    public function attractedTransfers(): HasManyThrough
    {
        return $this->hasManyThrough(TransferRequest::class, PromoCode::class);
    }

    /**
     * Retrieve attracted vehicles relations.
     *
     * @return HasManyThrough
     */
    public function attractedVehicles(): HasManyThrough
    {
        return $this->hasManyThrough(VehicleOrder::class, PromoCode::class);
    }


    # Other methods

    /**
     * Determine if partner is sub partner.
     *
     * @return bool
     */
    public function isSubPartner(): bool
    {
        return is_null($this->parent_id) === false;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Get parents of first and second level.
     *
     * @return array
     */
    #[ArrayShape([
        'firstLevel' => "App\\Models\\Partner",
        'secondLevel' => "App\\Models\\Partner"
    ])]
    public function getParents(): array
    {
        if ($this->parent()->doesntExist()) {
            return [
                'firstLevel' => null,
                'secondLevel' => null
            ];
        }

        /** @var Partner $firstLevel */
        $firstLevel = $this->parent()
            ->select([
                'id', 'user_id', 'parent_id',
                'city', 'profit_percent', 'company_income',
                'earned_profit', 'received_profit'
            ])
            ->first();

        $secondLevel = $firstLevel->parent()
            ->select([
                'id', 'user_id', 'parent_id',
                'city', 'profit_percent', 'company_income',
                'earned_profit', 'received_profit'
            ])
            ->first();

        return compact('firstLevel', 'secondLevel');
    }

    /**
     * Get direct sub-partners.
     *
     * @return Collection
     */
    public function getDirectSubPartners(): Collection
    {
        return Partner::query()
            ->select([
                'id', 'user_id', 'parent_id',
                'city', 'profit_percent', 'company_income',
                'earned_profit', 'received_profit'
            ])
            ->where('parent_id', $this->id)
            ->get();
    }

    /**
     * Plus partner's company income.
     *
     * @param float $value
     *
     * @return float
     */
    public function plusCompanyIncome(float $value): float
    {
        $result = $this->company_income + $value;

        $this->update([
            'company_income' => $result
        ]);

        return $result;
    }

    /**
     * Plus partner's earned profit.
     *
     * @param float $value
     *
     * @return float
     */
    public function plusEarnedProfit(float $value): float
    {
        $result = $this->earned_profit + $value;

        $this->update([
            'earned_profit' => $result
        ]);

        return $result;
    }

    /**
     * Plus partner's received profit.
     *
     * @param float $value
     *
     * @return float
     */
    public function plusReceivedProfit(float $value): float
    {
        $result = $this->received_profit + $value;

        $this->update([
            'received_profit' => $result
        ]);

        return $result;
    }

    /**
     * Get total figures:
     *
     * @return array
     */
    public static function getTotalFigures(): array
    {
        return (array) DB::table('partners')
            ->selectRaw(
                'SUM(company_income) as company_income, ' .
                'SUM(earned_profit) as earned_profit, ' .
                'SUM(received_profit) as received_profit'
            )
            ->first();
    }
}
