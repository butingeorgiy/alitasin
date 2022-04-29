<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRegisterRequest extends FormRequest
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
            'phone' => ['required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/'],
            'email' => 'required|email|unique:users|max:128',
            'partner_code' => 'nullable|min:1|max:32|exists:promo_codes,code',
            'promo_code' => 'required|min:1|max:32|unique:promo_codes,code',
            'city' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];
    }
}