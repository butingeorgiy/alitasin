<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubPartnerRequest extends FormRequest
{
    /**
     * @inheritdoc
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:2|max:32',
            'last_name' => 'nullable|min:2|max:32',
            'phone' => ['required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/'],
            'email' => 'required|email|unique:users|max:128',
            'promo_code' => 'required|min:1|max:32|unique:promo_codes,code',
            'city' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    /**
     * @inheritdoc
     *
     * @return array
     */
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
            'promo_code.unique' => __('messages.promo-code-not-unique'),
            'city.required' => __('messages.city-required'),
            'password.required' => __('messages.password-required'),
            'password.min' => __('messages.password-min'),
            'password.confirmed' => __('messages.password-confirmed')
        ];
    }
}