<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PartnerCreatingRequest;
use App\Models\PartnerPayment;
use App\Models\PartnerPercent;
use App\Models\PromoCode;
use App\Models\User;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    /**
     * @param PartnerCreatingRequest $request
     * @throws Exception
     * @return array
     */
    public function create(PartnerCreatingRequest $request): array
    {
        // Partner creating

        $phone = substr($request->input('phone'), -10);
        $phoneCode = Str::before($request->input('phone'), $phone);

        $user = new User([
            'first_name' => $request->input('first_name'),
            'phone_code' => $phoneCode,
            'phone' => $phone,
            'email' => $request->input('email'),
            'account_type_id' => '2'
        ]);

        if ($request->input('last_name')) {
            $user->last_name = $request->input('last_name');
        }

        $generatedPassword = $user->generatePassword();

        if (!$user->save()) {
            throw new Exception(__('messages.user-creating-failed'));
        }

        // Percent attaching

        PartnerPercent::create([
            'user_id' => $user->id,
            'percent' => $request->input('profit_percent')
        ]);

        // Promo code creating

        PromoCode::create([
            'code' => $request->input('promo_code'),
            'sale_percent' => $request->input('sale_percent'),
            'user_id' => $user->id
        ]);

        return [
            'status' => true,
            'message' => __('messages.partner-creating-success')
        ];
    }

    /**
     * Delete partner
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function delete($id): array
    {
        /**
         * @var User $partner
         */
        if (!$partner = User::partners()->where('id', $id)->get()->first()) {
            throw new Exception(__('messages.user-not-found'));
        }

        if (!$partner->delete()) {
            throw new Exception(__('messages.partner-ban-failed'));
        }

        return [
            'status' => true,
            'message' => __('messages.partner-ban-success')
        ];
    }

    /**
     * Restore partner
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function restore($id): array
    {
        /**
         * @var User $partner
         */
        if (!$partner = User::partners()->onlyTrashed()->where('id', $id)->get()->first()) {
            throw new Exception(__('messages.user-not-found'));
        }

        if (!$partner->restore()) {
            throw new Exception(__('messages.partner-restore-failed'));
        }

        return [
            'status' => true,
            'message' => __('messages.partner-restore-success')
        ];
    }

    /**
     * Make partner payment
     *
     * @param Request $request
     * @param $id
     * @throws Exception
     * @return array
     */
    public function makePayment(Request $request, $id): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'amount' => 'bail|required|numeric|min:0'
            ],
            [
                'amount.required' => __('messages.payment-amount-required'),
                'amount.numeric' => __('messages.payment-amount-numeric'),
                'amount.min' => __('messages.payment-amount-min')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        /**
         * @var $partner User
         */
        if (!$partner = User::partners()->where('id', $id)->get()->first()) {
            throw new Exception(__('messages.user-not-found'));
        }

        if ($partner->total_profit - $partner->total_payment_amount < (int) $request->input('amount')) {
            throw new Exception(__('messages.partner-payment-amount-max'));
        }

        PartnerPayment::create([
            'partner_id' => $partner->id,
            'amount' => (int) $request->input('amount')
        ]);

        return [
            'status' => true,
            'message' => __('messages.partner-payment-saving-success')
        ];
    }
}
