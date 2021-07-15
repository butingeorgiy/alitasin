<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TransferCostResolvingRequest;
use App\Models\Airport;
use App\Models\Transfer;
use App\Models\TransferDestination;
use Exception;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{
    /**
     * Get available airports.
     */
    public function getAirports()
    {
        return Airport::all();
    }

    /**
     * Get available destinations.
     */
    public function getDestinations()
    {
        return TransferDestination::all();
    }

    /**
     * @param TransferCostResolvingRequest $request
     * @return array
     * @throws Exception
     */
    public function getCost(TransferCostResolvingRequest $request): array
    {
        /** @var Transfer|null $transfer */
        $transfer = Transfer::where([
            ['airport_id', $request->input('airport_id')],
            ['destination_id', $request->input('destination_id')]
        ])->limit(1)->first();

        if (!$transfer) {
            throw new Exception(__('messages.transfer-not-found'));
        }

        $transferCost = $transfer->getCost(
            $request->input('type_id'),
            $request->input('capacity_id')
        );

        if ($transferCost === null) {
            throw new Exception(__('messages.transfer-not-found'));
        }

        return [
            'formatted_cost' => number_format($transferCost, 2, '.', ' '),
            'cost' => $transferCost
        ];
    }
}
