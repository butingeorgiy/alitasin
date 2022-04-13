<?php

namespace App\Http\Controllers\Api;

use App\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferCostResolvingRequest;
use App\Http\Requests\TransferRequestCreatingRequest;
use App\Mail\TransferRequestCreated;
use App\Models\PromoCode;
use App\Models\Transfer;
use App\Models\TransferCapacity;
use App\Models\TransferCost;
use App\Models\TransferRequest;
use App\Models\TransferType;
use App\Services\PartnerCounter\Client as PartnerCounterClient;
use App\Services\PartnerCounter\Drivers\TransferPartnerCounter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
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
            (int)$request->input('airport_id'),
            (int)$request->input('destination_id')
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

            $partnerCounter = new PartnerCounterClient($promoCode);

            $partnerCounter->calculate(
                new TransferPartnerCounter($transferCost)
            );
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

    /**
     * Determine if transfer exists.
     *
     * @param Request $request
     * @return array
     */
    public function isExists(Request $request): array
    {
        /** @var Transfer|null $transfer */
        $transfer = Transfer::where([
            ['airport_id', $request->input('airport_id')],
            ['destination_id', $request->input('destination_id')]
        ])->select('id')->limit(1)->first();

        return [
            'result' => $transfer !== null,
            'transfer_id' => $transfer ? $transfer->id : null
        ];
    }

    /**
     * Get variations.
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function getAvailableVariations(Request $request): array
    {
        /** @var Transfer|null $transfer */
        $transfer = Transfer::where([
            ['airport_id', $request->input('airport_id')],
            ['destination_id', $request->input('destination_id')]
        ])->first();

        if (!$transfer) {
            throw new Exception(__('messages.transfer-not-found'));
        }

        $result = [];
        $variations = $transfer->variations()->get();

        /** @var TransferCapacity $capacity */
        foreach (TransferCapacity::all() as $capacity) {

            /** @var TransferType $type */
            foreach (TransferType::all() as $type) {
                $variation = $variations
                    ->where('type_id', $type->id)
                    ->where('capacity_id', $capacity->id)->first();

                $result[] = [
                    'type_id' => $type->id,
                    'type_name' => $type->name,
                    'capacity_id' => $capacity->id,
                    'capacity_name' => $capacity->name,
                    'price' => $variation ? $variation->cost : null
                ];
            }
        }

        return [
            'variations' => $result
        ];
    }

    /**
     * Update transfer variation cost.
     *
     * @param Request $request
     * @param $transferId
     * @return array
     * @throws Exception
     */
    public function updateVariationCost(Request $request, $transferId): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type_id' => 'bail|required|numeric|exists:transfer_types,id',
                'capacity_id' => 'bail|required|numeric|exists:transfer_capacity,id',
                'cost' => 'bail|required|numeric|min:0'
            ],
            [
                'type_id.required' => __('messages.transfer-type-required'),
                'type_id.exists' => __('messages.transfer-type-not-found'),
                'capacity_id.required' => __('messages.capacity-required'),
                'capacity_id.exists' => __('messages.capacity-not-found'),
                'cost.required' => __('messages.transfer-cost-required'),
                'cost.numeric' => __('messages.transfer-cost-numeric'),
                'cost.min' => __('messages.transfer-cost-min')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        if (!$transfer = Transfer::find($transferId)) {
            throw new Exception(__('messages.transfer-not-found'));
        }

        $transferCost = TransferCost::where([
            ['transfer_id', $transfer->id],
            ['capacity_id', $request->input('capacity_id')],
            ['type_id', $request->input('type_id')]
        ])->limit(1)->exists();

        if ($transferCost) {
            DB::table('transfer_cost')->where([
                ['transfer_id', $transfer->id],
                ['capacity_id', $request->input('capacity_id')],
                ['type_id', $request->input('type_id')]
            ])->update(['cost' => $request->input('cost')]);
        } else {
            $transferCost = new TransferCost([
                'transfer_id' => $transfer->id,
                'capacity_id' => $request->input('capacity_id'),
                'type_id' => $request->input('type_id'),
                'cost' => $request->input('cost')
            ]);

            if (!$transferCost->save()) {
                throw new Exception(__('messages.updating-failed'));
            }
        }

        return [
            'success' => true,
            'message' => __('messages.updating-success')
        ];
    }

    /**
     *
     *
     * @param Request $request
     * @param $transferId
     * @return array
     * @throws Exception
     */
    public function deleteVariationCost(Request $request, $transferId): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type_id' => 'bail|required|numeric|exists:transfer_types,id',
                'capacity_id' => 'bail|required|numeric|exists:transfer_capacity,id'
            ],
            [
                'type_id.required' => __('messages.transfer-type-required'),
                'type_id.exists' => __('messages.transfer-type-not-found'),
                'capacity_id.required' => __('messages.capacity-required'),
                'capacity_id.exists' => __('messages.capacity-not-found')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        if (!$transfer = Transfer::find($transferId)) {
            throw new Exception(__('messages.transfer-not-found'));
        }

        $transferCost = TransferCost::where([
            ['transfer_id', $transfer->id],
            ['capacity_id', $request->input('capacity_id')],
            ['type_id', $request->input('type_id')]
        ])->limit(1)->exists();

        if (!$transferCost) {
            throw new Exception(__('messages.transfer-not-found'));
        }

        DB::table('transfer_cost')->where([
            ['transfer_id', $transfer->id],
            ['capacity_id', $request->input('capacity_id')],
            ['type_id', $request->input('type_id')]
        ])->delete();

        return [
            'success' => true,
            'message' => __('messages.updating-success')
        ];
    }

    /**
     * Create a new transfer.
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function create(Request $request): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'airport_id' => 'bail|required|exists:airports,id',
                'destination_id' => 'bail|required|exists:transfer_destinations,id'
            ],
            [
                'airport_id.required' => __('messages.airport-required'),
                'airport_id.exists' => __('messages.airport-not-found'),
                'destination_id.required' => __('messages.destination-required'),
                'destination_id.exists' => __('messages.destination-not-found')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $transfer = new Transfer([
            'airport_id' => $request->input('airport_id'),
            'destination_id' => $request->input('destination_id')
        ]);

        if (!$transfer->save()) {
            throw new Exception(__('messages.transfer-creating-failed'));
        }

        return [
            'success' => true,
            'message' => __('messages.transfer-creating-success')
        ];
    }

    /**
     * Delete transfer.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function delete($id): array
    {
        if (!$transfer = Transfer::find($id)) {
            throw new Exception(__('messages.transfer-not-found'));
        }

        $transfer->variations()->delete();
        $transfer->delete();

        return [
            'success' => true,
            'message' => __('messages.transfer-deleting-success')
        ];
    }
}
