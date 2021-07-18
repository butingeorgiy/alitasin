<?php

namespace App\Traits;

use App\Models\PartnerPayment;
use App\Models\Reservation;
use App\Models\TransferRequest;
use App\Models\User;

trait PartnerCalculator
{
    /**
     * Get partner's total income.
     *
     * @return float
     */
    public function getTotalIncome(): float
    {
        $incomeFromReservations = $this->getIncomeFromAttractedReservations();
        $incomeFromTransfers = $this->getIncomeFromAttractedTransfers();

        return $incomeFromReservations + $incomeFromTransfers;
    }

    /**
     * Get partner's total profit.
     *
     * @return float
     */
    public function getTotalProfit(): float
    {
        $profitFromReservations = $this->getProfitFromAttractedReservations();
        $profitFromTransfers = $this->getProfitFromAttractedTransfers();

        return $profitFromReservations + $profitFromTransfers;
    }

    /**
     * Get partner's payment amount.
     *
     * @return int
     */
    public function getPaymentAmount(): int
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
     * Calculate income from partner's attracted excursions.
     *
     * @return float
     */
    private function getIncomeFromAttractedReservations(): float
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
     * Calculate profit from partner's attracted excursions.
     *
     * @return float
     */
    private function getProfitFromAttractedReservations(): float
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

        if ($this->hasSubPartners()) {

            /** @var $subPartners User[] */
            $subPartners = User::with(['attractedReservations'])
                ->whereIn('id', $this->subPartnerIds())->get();

            foreach ($subPartners as $subPartner) {
                /** @var Reservation $item */
                foreach ($subPartner->attractedReservations()->get() as $item) {
                    $totalProfit += $item->costWithSale() * $subPartner->sub_partners_profit_percent / 100;
                }
            }
        }

        return $totalProfit;
    }

    /**
     * Calculate income from partner's attracted transfers.
     *
     * @return float
     */
    private function getIncomeFromAttractedTransfers(): float
    {
        /** @var TransferRequest[] $attractedTransfers */
        $attractedTransfers = $this->attractedTransfers()->get();
        $totalIncome = 0;

        foreach ($attractedTransfers as $item) {
            $totalIncome += $item->costWithSale();
        }

        return $totalIncome;
    }

    /**
     * Calculate profit from partner's attracted transfers.
     *
     * @return float
     */
    private function getProfitFromAttractedTransfers(): float
    {
        /** @var TransferRequest[] $attractedTransfers */
        $attractedTransfers = $this->attractedTransfers()->get();
        $totalProfit = 0;
        $profitPercent = $this->profit_percent;

        foreach ($attractedTransfers as $item) {
            $totalProfit += $item->costWithSale() * $profitPercent / 100;
        }

        return $totalProfit;
    }
}