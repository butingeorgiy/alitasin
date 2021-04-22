<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TourReserveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'bail|nullable|min:2|max:32',
            'phone' => ['bail', 'nullable', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/'],
            'email' => 'bail|nullable|email',
            'hotel_name' => 'bail|nullable|min:4|max:64',
            'communication_type' => 'bail|nullable|min:4|max:32',
            'time' => ['bail', 'nullable', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'date' => 'bail|nullable|date_format:Y-m-d',
            'promo_code' => 'bail|nullable|min:1|max:32',
            'tickets' => 'bail|required|json'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'first_name.min' => __('messages.user-first-name-min'),
            'first_name.max' => __('messages.user-first-name-max'),
            'phone.min' => __('messages.user-phone-required'),
            'phone.regex' => __('messages.user-phone-regex'),
            'email.email' => __('messages.email-wrong-format'),
            'hotel_name.min' => __('messages.hotel-name-min'),
            'hotel_name.max' => __('messages.hotel-name-max'),
            'communication_type.min' => __('messages.communication_type-min'),
            'communication_type.max' => __('messages.communication_type-max'),
            'time.regex' => __('messages.time-format'),
            'date.date_format' => __('messages.date-format'),
            'promo_code.min' => __('messages.promo-code-min'),
            'promo_code.max' => __('messages.promo-code-max'),
            'tickets.required' => __('messages.tickets-required'),
            'tickets.json' => __('messages.tickets-json')
        ];
    }

    /**
     * @param Validator $validator
     * @throws Exception
     */
    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }
}
