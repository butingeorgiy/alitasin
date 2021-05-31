<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PartnerCreatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'bail|required|min:2|max:32',
            'last_name' => 'bail|nullable|min:2|max:32',
            'phone' => ['bail', 'required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/'],
            'email' => 'bail|required|email|unique:users|max:128',
            'promo_code' => 'bail|required|min:1|max:32',
            'sale_percent' => 'bail|required|numeric|min:0|max:100',
            'profit_percent' => 'bail|required|numeric|min:0|max:100',
            'sub_partner_profit_percent' => 'bail|nullable|numeric|min:0|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('messages.user-first-name-required'),
            'first_name.min' => __('messages.user-first-name-min'),
            'first_name.max' => __('messages.user-first-name-max'),
            'last_name.min' => __('messages.user-last-name-min'),
            'last_name.max' => __('messages.user-last-name-max'),
            'phone.required' => __('messages.user-phone-required'),
            'phone.regex' => __('messages.user-phone-regex'),
            'email.required' => __('messages.user-email-required'),
            'email.email' => __('messages.user-email-email'),
            'email.unique' => __('messages.user-email-unique'),
            'email.max' => __('messages.user-email-max'),
            'promo_code.required' => __('messages.promo-code-required'),
            'promo_code.min' => __('messages.promo-code-min'),
            'promo_code.max' => __('messages.promo-code-max'),
            'sale_percent.required' => __('messages.sale-percent-required'),
            'sale_percent.numeric' => __('messages.percent-numeric'),
            'sale_percent.min' => __('messages.percent-min'),
            'sale_percent.max' => __('messages.percent-max'),
            'profit_percent.required' => __('messages.profit-percent-required'),
            'profit_percent.numeric' => __('messages.profit-percent-numeric'),
            'profit_percent.min' => __('messages.percent-min'),
            'profit_percent.max' => __('messages.percent-max'),
            'sub_partner_profit_percent.numeric' => __('messages.percent-numeric'),
            'sub_partner_profit_percent.min' => __('messages.percent-min'),
            'sub_partner_profit_percent.max' => __('messages.percent-max')
        ];
    }

    /**
     * @throws Exception
     */
    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }
}
