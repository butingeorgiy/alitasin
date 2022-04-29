<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PartnerCreatingRequest;
use App\Http\Requests\PartnerRegisterRequest;
use App\Models\Partner;
use App\Models\PromoCode;
use App\Models\User;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    /**
     * Create a new partner.
     *
     * @param PartnerCreatingRequest $request
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function create(PartnerCreatingRequest $request): JsonResponse
    {
        // Check promo code on uniqueness

        if (PromoCode::where('code', $request->input('promo_code'))->exists()) {
            throw new Exception(__('messages.promo-code-not-unique'));
        }

        DB::transaction(function () use ($request) {
            // User model creating

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

            $user->password = Hash::make($request->input('password'));

            if (!$user->save()) {
                throw new Exception(__('messages.user-creating-failed'));
            }

            // Partner model creating

            $partner = Partner::create([
                'user_id' => $user->id,
                'parent_id' => $request->input('parent_user_id'),
                'profit_percent' => $request->input('profit_percent'),
                'city' => $request->input('city'),
                'company_income' => 0,
                'earned_profit' => 0,
                'received_profit' => 0
            ]);

            $partner->promoCodes()->create([
                'code' => $request->input('promo_code'),
                'sale_percent' => $request->input('sale_percent')
            ]);
        });

        return response()->json([
            'status' => true,
            'message' => __('messages.partner-creating-success')
        ], options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Delete partner.
     *
     * @param int $id
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function delete(int $id): JsonResponse
    {
        if (!$partner = Partner::find($id)) {
            throw new Exception(__('messages.user-not-found'));
        }

        if (!$partner->delete() || !$partner->user->delete()) {
            throw new Exception(__('messages.partner-ban-failed'));
        }

        return response()->json([
            'status' => true,
            'message' => __('messages.partner-ban-success')
        ], options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Restore partner.
     *
     * @param int $id
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function restore(int $id): JsonResponse
    {
        /** @var User $partner */
        if (!$partner = Partner::onlyTrashed()->find($id)) {
            throw new Exception(__('messages.user-not-found'));
        }

        if (!$partner->restore()) {
            throw new Exception(__('messages.partner-restore-failed'));
        }

        return response()->json([
            'status' => true,
            'message' => __('messages.partner-restore-success')
        ], options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Make partner payment.
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function makePayment(Request $request, int $id): JsonResponse
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

        if (!$partner = Partner::find($id)) {
            throw new Exception(__('messages.user-not-found'));
        }

        if ($partner->earned_profit - $partner->received_profit < (float) $request->input('amount')) {
            throw new Exception(__('messages.partner-payment-amount-max'));
        }

        logger()->info('Partner Payment.', [
            'partner_id' => $partner->id,
            'amount' => $request->input('amount')
        ]);

        $partner->plusReceivedProfit((float) $request->input('amount'));

        return response()->json([
            'status' => true,
            'message' => __('messages.partner-payment-saving-success')
        ], options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update partner's profit percent.
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function updateProfitPercent(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'profit_percent' => 'bail|required|numeric|min:0|max:100',
                // 'is_sub_partner_percent' => 'bail|required|string|in:0,1'
            ],
            [
                'profit_percent.required' => __('messages.profit-percent-required'),
                'profit_percent.numeric' => __('messages.profit-percent-numeric'),
                'profit_percent.min' => __('messages.profit-percent-min'),
                'profit_percent.max' => __('messages.profit-percent-max'),
                // 'is_sub_partner_percent.required' => __('messages.is-sub-partner-percent-required'),
                // 'is_sub_partner_percent.string' => __('messages.is-sub-partner-percent-string'),
                // 'is_sub_partner_percent.in' => __('messages.is-sub-partner-percent-in')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        if (!$partner = Partner::find($id)) {
            throw new Exception(__('messages.user-not-found'));
        }

        $partner->update([
            'profit_percent' => (float) $request->input('profit_percent')
        ]);

        return response()->json([
            'status' => true,
            'message' => __('messages.profit-percent-updating-success')
        ], options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update partner profile.
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'bail|required|min:2|max:32',
                'last_name' => 'bail|min:2|max:32',
                'email' => 'bail|required|email|max:128',
                'phone' => ['bail', 'required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/'],
                'new_password' => 'bail|nullable|string|min:8|confirmed',
                'new_password_confirmation' => 'bail|nullable',
                'city' => 'bail|string|max:255'
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
                'new_password.confirmed' => __('messages.password-confirmed'),
                'city.max' => 'Максимальная длина города 255 символов!' // todo: translate
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        /** @var Partner $partner */
        if (!$partner = Partner::with('user')->find($id)) {
            throw new Exception(__('messages.user-not-found'));
        }

        $emailUniqueCheck = User::where('email', $request->input('email'))
            ->where('id', '!=', $partner->user->id)->exists();

        if ($emailUniqueCheck) {
            throw new Exception(__('messages.user-email-unique'));
        }

        if ($partner->user->first_name !== $request->input('first_name')) {
            $partner->user->first_name = $request->input('first_name');
        }

        if ($request->has('last_name')) {
            if ($partner->user->last_name !== $request->input('last_name')) {
                $partner->user->last_name = $request->input('last_name');
            }
        }

        if ($partner->user->email !== $request->input('email')) {
            $partner->user->email = $request->input('email');
        }

        if ($partner->city !== $request->input('city')) {
            $partner->city = $request->input('city');
        }

        $userPhone = $partner->user->phone_code . $partner->user->getOriginal('phone');

        if ($userPhone !== $request->input('phone')) {
            $phone = substr($request->input('phone'), -10);
            $phoneCode = Str::before($request->input('phone'), $phone);

            $partner->user->phone_code = $phoneCode;
            $partner->user->phone = $phone;
        }

        if ($request->has('new_password')) {
            $partner->user->password = Hash::make($request->input('new_password'));
        }

        $partner->save();

        return response()->json([
            'success' => true,
            'message' => __('messages.updating-success')
        ], options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Search partners by phone, name, promo code and city.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        if (!$query = $request->input('query')) {
            return response()->json([
                'result' => []
            ], options: JSON_UNESCAPED_UNICODE);
        }

        $partnerIds = Partner::withTrashed()->selectRaw(
            'partners.id, CHAR_LENGTH(REGEXP_REPLACE(REGEXP_REPLACE(LOWER(REPLACE(CONCAT(users.phone_code, ' .
            'users.phone, users.email, users.first_name, IF(users.last_name IS NOT NULL, users.last_name, \'\'), ' .
            'IF(partners.city IS NOT NULL, partners.city, \'\'), IF(promo_codes.code IS NOT NULL, promo_codes.code, \'\')), \' \', \'\')), ?, \'~\'' .
            ', 1, 0, \'i\'), \'[^~]\', \'\')) as frequency',
            [str_replace(' ', '|', $query)]
        )
            ->leftJoin('users', 'partners.user_id', '=', 'users.id')
            ->leftJoin('promo_codes', 'partners.id', '=', 'promo_codes.partner_id')
            ->having('frequency', '>', 0)
            ->orderByDesc('frequency')->get()->modelKeys();

        return response()->json([
            'result' => Partner::withTrashed()->find($partnerIds)->map(function (Partner $partner) {
                return [
                    'id' => $partner->id,
                    'name' => $partner->user->full_name,
                    'promo_code' => $partner->promoCodes()->first()['code']
                ];
            })
        ], options: JSON_UNESCAPED_UNICODE);
    }

    public function register(PartnerRegisterRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            // User model creating

            $phone = substr($request->input('phone'), -10);
            $phoneCode = Str::before($request->input('phone'), $phone);

            /** @var User $user */
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'phone_code' => $phoneCode,
                'phone' => $phone,
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'account_type_id' => '2'
            ]);

            // Partner model creating

            $parentPromoCode = null;

            if ($request->has('partner_code')) {
                /** @var PromoCode $parentPromoCode */
                $parentPromoCode = PromoCode::select('code', 'partner_id')
                    ->where(
                        'code',
                        $request->input('partner_code')
                    )
                    ->first();

                if (Partner::where('id', $parentPromoCode->partner_id)->doesntExist()) {
                    throw new Exception('Partner not found.');
                }
            }

            $partner = Partner::create([
                'user_id' => $user->id,
                'parent_id' => optional($parentPromoCode)->partner_id,
                'profit_percent' => 5.0,
                'city' => $request->input('city'),
                'company_income' => 0,
                'earned_profit' => 0,
                'received_profit' => 0
            ]);

            $partner->promoCodes()->create([
                'code' => $request->input('promo_code'),
                'sale_percent' => 10
            ]);

            return response()->json([
                'status' => true,
                'message' => __('messages.partner-create-success')
            ], options: JSON_UNESCAPED_UNICODE);
        });
    }
}
