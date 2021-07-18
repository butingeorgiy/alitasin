<?php

namespace App\Http\Controllers\Api;

use App\Facades\Auth;
use App\Http\Requests\TransferCostResolvingRequest;
use App\Http\Requests\TransferRequestCreatingRequest;
use App\Mail\TransferRequestCreated;
use App\Models\Airport;
use App\Models\PromoCode;
use App\Models\Transfer;
use App\Models\TransferDestination;
use App\Models\TransferRequest;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

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
     * Get cost of transfer.
     *
     * @param TransferCostResolvingRequest $request
     * @return array
     * @throws Exception
     */
    public function getCost(TransferCostResolvingRequest $request): array
    {
        /** @var Transfer|null $transfer */
        $transfer = Transfer::matchedBy(
            (int) $request->input('airport_id'),
            (int) $request->input('destination_id')
        )->limit(1)->first();

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

    /**
     * Create a new transfer request.
     *
     * @param TransferRequestCreatingRequest $request
     * @return array
     * @throws Exception
     */
    public function createRequest(TransferRequestCreatingRequest $request): array
    {
        /** @var Transfer|null $transfer */
        $transfer = Transfer::matchedBy(
            (int) $request->input('airport_id'),
            (int) $request->input('destination_id')
        )->limit(1)->first();

        if (!$transfer) {
            throw new Exception(__('messages.transfer-not-found'));
        }

        $transferCost = $transfer->getCost(
            $request->input('type_id'),
            $request->input('capacity_id')
        );

        if (!$transferCost) {
            throw new Exception(__('messages.transfer-not-found'));
        }

        if (Auth::check(['1'])) {
            $user = Auth::user();
        }

        if ($request->has('promo_code')) {
            /** @var PromoCode|null $promoCode */
            if (!$promoCode = PromoCode::where('code', $request->input('promo_code'))
                ->limit(1)->first()) {
                throw new Exception(__('messages.promo-code-not-found'));
            }
        }

        $transferRequest = new TransferRequest([
            'user_id' => isset($user) ? $user->id : null,
            'user_name' => $request->input('user_name'),
            'user_phone' => $request->input('user_phone'),
            'user_email' => $request->input('user_email'),
            'cost_without_sale' => $transferCost,
            'type_id' => $request->input('type_id'),
            'airport_id' => $request->input('airport_id'),
            'destination_id' => $request->input('destination_id'),
            'capacity_id' => $request->input('capacity_id'),
            'flight_number' => $request->input('flight_number'),
            'departure' => $request->input('departure'),
            'arrival' => $request->input('arrival')
        ]);

        if (isset($promoCode) && $promoCode) {
            $transferRequest->attachPromoCode($promoCode);
        }

        if (!$transferRequest->save()) {
            throw new Exception(__('messages.request-sending-failed'));
        }

        Mail::to(config('mail.admin_address'))
            ->send(new TransferRequestCreated($transferRequest));

        return [
            'success' => true,
            'message' => __('messages.request-sending-success')
        ];
    }
}
