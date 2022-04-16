<?php

namespace App\Services\PartnerCounter\Drivers;

use App\Models\Partner;
use App\Models\PromoCode;
use Illuminate\Database\Eloquent\Model;

class VehiclePartnerCounter implements CounterInterface
{
    const FIRST_LEVEL_PERCENT = 4.0;

    const SECOND_LEVEL_PERCENT = 1.0;

    /**
     * Initial vehicle cost.
     *
     * @var float
     */
    protected float $vehicleCost;

    /**
     * Discounted vehicle cost.
     *
     * @var float
     */
    protected float $vehicleCostWithDiscount;

    /**
     * Promo code model instance.
     *
     * @var PromoCode
     */
    protected PromoCode $promoCode;

    /**
     * Partner model instance.
     *
     * @var Partner
     */
    protected Model $partner;

    /**
     * Class constructor.
     *
     * @param float $vehicleCost (initial cost – without sales)
     */
    public function __construct(float $vehicleCost)
    {
        $this->vehicleCost = $vehicleCost;
    }

    /**
     * Set promo code model instance.
     *
     * @param PromoCode $promoCode
     *
     * @return void
     */
    protected function setPromoCodeInstance(PromoCode $promoCode): void
    {
        $this->promoCode = $promoCode;
    }

    /**
     * Resolve partner model instance.
     *
     * @return void
     */
    protected function resolvePartnerModel(): void
    {
        $this->partner = Partner::query()
            ->select([
                'id', 'parent_id', 'profit_percent',
                'company_income', 'earned_profit'
            ])
            ->findOrFail($this->promoCode->partner_id);
    }

    /**
     * Resolve vehicle's discounted cost.
     *
     * @return void
     */
    protected function resolveDiscountCost(): void
    {
        $this->vehicleCostWithDiscount = $this->vehicleCost * (100 - $this->promoCode->sale_percent) / 100;
    }

    /**
     * Calculate company income.
     *
     * @return void
     */
    protected function calculateCompanyIncome(): void
    {
        $this->partner->plusCompanyIncome(
            $this->vehicleCostWithDiscount
        );
    }

    /**
     * Calculate earned profit.
     *
     * @return void
     */
    protected function calculateEarnedProfit(): void
    {
        $this->partner->plusEarnedProfit(
            $this->vehicleCostWithDiscount * $this->partner->profit_percent / 100
        );

        $parents = $this->partner->getParents();

        if (is_null($parents['firstLevel']) === false) {
            $parents['firstLevel']->plusEarnedProfit(
                $this->vehicleCostWithDiscount * self::FIRST_LEVEL_PERCENT / 100
            );
        }

        if (is_null($parents['secondLevel']) === false) {
            $parents['secondLevel']->plusEarnedProfit(
                $this->vehicleCostWithDiscount * self::SECOND_LEVEL_PERCENT / 100
            );
        }
    }

    /**
     * @inheritDoc
     *
     * @param PromoCode $promoCode
     *
     * @return array
     */
    public function calculate(PromoCode $promoCode): array
    {
        $this->setPromoCodeInstance($promoCode);

        $this->resolvePartnerModel();
        $this->resolveDiscountCost();

        $this->calculateCompanyIncome();
        $this->calculateEarnedProfit();

        return [];
    }
}