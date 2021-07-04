<?php

namespace App\Http\Controllers\Api;

use App\Facades\Hash;
use App\Http\Requests\PartnerCreatingRequest;
use App\Models\PartnerCity;
use App\Models\PartnerPayment;
use App\Models\PartnerPercent;
use App\Models\PromoCode;
use App\Models\User;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $user->password = Hash::make($request->input('password'), $user);

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

        // If has parent_user_id

        if ($request->has('parent_user_id')) {
            /** @var User $partner */
            if (!$partner = User::partners()->find($request->input('parent_user_id'))) {
                throw new Exception(__('messages.user-not-found'));
            }

            if (!$subPartnerProfitPercent = $request->input('sub_partner_profit_percent')) {
                throw new Exception(__('messages.sub-partner-profit-percent-required'));
            }

            DB::table('sub_partners')->insert([
                'parent_user_id' => $partner->id,
                'user_id' => $user->id
            ]);

            DB::table('sub_partner_percents')->insert([
                'user_id' => $user->id,
                'percent' => $subPartnerProfitPercent
            ]);
        }

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

    /**
     * Update partner's profit percent
     *
     * @param Request $request
     * @param $id
     * @return array
     * @throws Exception
     */
    public function updateProfitPercent(Request $request, $id): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'profit_percent' => 'bail|required|numeric|min:0|max:100',
                'is_sub_partner_percent' => 'bail|required|string|in:0,1'
            ],
            [
                'profit_percent.required' => __('messages.profit-percent-required'),
                'profit_percent.numeric' => __('messages.profit-percent-numeric'),
                'profit_percent.min' => __('messages.profit-percent-min'),
                'profit_percent.max' => __('messages.profit-percent-max'),
                'is_sub_partner_percent.required' => __('messages.is-sub-partner-percent-required'),
                'is_sub_partner_percent.string' => __('messages.is-sub-partner-percent-string'),
                'is_sub_partner_percent.in' => __('messages.is-sub-partner-percent-in')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        /**
         * @var $partner User
         */
        if (!$partner = User::partners()->find($id)) {
            throw new Exception(__('messages.user-not-found'));
        }

        if ($request->input('is_sub_partner_percent') === '0') {
            $isUpdated = $partner->updateProfitPercent((int) $request->input('profit_percent'));
        } else {
            $isUpdated = $partner->updateSubPartnerProfitPercent((int) $request->input('profit_percent'));
        }

        if (!$isUpdated) {
            throw new Exception(__('messages.updating-failed'));
        }

        return [
            'status' => true,
            'message' => __('messages.profit-percent-updating-success')
        ];
    }

    /**
     * Update partner profile
     *
     * @param Request $request
     * @param $id
     * @return array
     * @throws Exception
     */
    public function update(Request $request, $id): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'bail|required|min:2|max:32',
                'last_name' => 'bail|min:2|max:32',
                'email' => 'bail|required|email|max:128',
                'phone' => ['bail', 'required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/'],
                'new_password' => 'bail|nullable|string|min:8|confirmed',
                'new_password_confirmation' => 'bail|nullable'
            ],
            [
                'first_name.required' => __('messages.user-first-name-required'),
                'first_name.min' => __('messages.user-first-name-min'),
                'first_name.max' => __('messages.user-first-name-max'),
                'last_name.min' => __('messages.user-last-name-min'),
                'last_name.max' => __('messages.user-last-name-max'),
                'email.required' => __('messages.user-email-required'),
                'email.email' => __('messages.user-email-email'),
                'email.max' => __('messages.user-email-max'),
                'phone.required' => __('messages.user-phone-required'),
                'phone.regex' => __('messages.user-phone-regex'),
                'new_password.min' => __('messages.password-min'),
                'new_password.confirmed' => __('messages.password-confirmed')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        /** @var User|null $partner */
        if (!$partner = User::partners()->where('id', $id)->first()) {
            throw new Exception(__('messages.user-not-found'));
        }

        $emailUniqueCheck = User::where('email', $request->input('email'))
            ->where('id', '!=', $partner->id)->get()->first();

        if ($emailUniqueCheck) {
            throw new Exception(__('messages.user-email-unique'));
        }

        if ($partner->first_name !== $request->input('first_name')) {
            $partner->first_name = $request->input('first_name');
        }

        if ($request->has('last_name')) {
            if ($partner->last_name !== $request->input('last_name')) {
                $partner->last_name = $request->input('last_name');
            }
        }

        if ($partner->email !== $request->input('email')) {
            $partner->email = $request->input('email');
        }

        /** @var PartnerCity|null $partnerCity */
        if ($partnerCity = $partner->partnerCity()->first()) {
            if ($partnerCity->city !== $request->input('city')) {
                $partnerCity->city = $request->input('city');

                $partnerCity->save();
            }
        } else if ($request->input('city')) {
            $partnerCity = new PartnerCity();

            $partnerCity->partner_id = $partner->id;
            $partnerCity->city = $request->input('city');

            $partnerCity->save();
        }

        $userPhone = $partner->phone_code . $partner->getOriginal('phone');

        if ($userPhone !== $request->input('phone')) {
            $phone = substr($request->input('phone'), -10);
            $phoneCode = Str::before($request->input('phone'), $phone);

            $partner->phone_code = $phoneCode;
            $partner->phone = $phone;
        }

        if ($request->has('new_password')) {
            $partner->password = Hash::make($request->input('new_password'), $partner);
        }

        $partner->save();

        return [
            'success' => true,
            'message' => __('messages.updating-success')
        ];
    }

    /**
     * Search partners by phone, name, promo code and city
     *
     * @param Request $request
     * @return array|array[]
     */
    public function search(Request $request): array
    {
        if (!$query = $request->input('query')) {
            return [
                'result' => []
            ];
        }

        $partnerIds = User::partners()->selectRaw(
            'users.id, CHAR_LENGTH(REGEXP_REPLACE(REGEXP_REPLACE(LOWER(REPLACE(CONCAT(phone_code, ' .
            'phone, email, first_name, IF(last_name IS NOT NULL, last_name, \'\'), IF(partner_cities.city IS NOT ' .
            'NULL, partner_cities.city, \'\'), IF(promo_codes.code IS NOT NULL, promo_codes.code, \'\')), \' \', \'\')), ?, \'~\'' .
            ', 1, 0, \'i\'), \'[^~]\', \'\')) as frequency',
            [str_replace(' ', '|', $query)]
        )
            ->leftJoin('partner_cities', 'users.id', '=', 'partner_cities.partner_id')
            ->leftJoin('promo_codes', 'users.id', '=', 'promo_codes.user_id')
            ->having('frequency', '>', 0)
            ->orderByDesc('frequency')->get()->modelKeys();

        return [
            'result' => User::find($partnerIds)->map(function ($user) {
                /**
                 * @var PromoCode $promoCode
                 * @var User $user
                 */

                $promoCode = $user->promoCodes()->first();
                $promoCode = $promoCode->code;

                return [
                    'id' => $user->id,
                    'name' => $user->full_name,
                    'promo_code' => $promoCode
                ];
            })
        ];
    }
}
