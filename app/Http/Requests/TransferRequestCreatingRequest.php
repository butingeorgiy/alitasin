<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequestCreatingRequest extends FormRequest
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
            'user_id' => 'bail|nullable|exists:users,id',
            'user_name' => 'bail|required|string|max:255',
            'user_phone' => ['bail', 'required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/'],
            'user_email' => 'bail|required|email|max:255',
            'flight_number' => 'bail|nullable|string|max:255',
            'promo_code' => 'bail|nullable|string|max:32',
            'type_id' => 'bail|required|exists:transfer_types,id',
            'airport_id' => 'bail|required|exists:airports,id',
            'destination_id' => 'bail|required|exists:transfer_destinations,id',
            'capacity_id' => 'bail|required|exists:transfer_capacity,id',
            'departure' => 'bail|nullable|date_format:Y-m-d H:i:00',
            'arrival' => 'bail|nullable|date_format:Y-m-d H:i:00'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => __('messages.user-not-found'),
            'user_name.required' => __('messages.user-first-name-required'),
            'user_name.max' => __('messages.user-name-max'),
            'user_phone.required' => __('messages.user-phone-required'),
            'user_phone.regex' => __('messages.user-phone-regex'),
            'user_email.required' => __('messages.user-email-required'),
            'user_email.email' => __('messages.user-email-email'),
            'user_email.max' => __('messages.user-email-max'),
            'flight_number.max' => __('messages.flight-number-max'),
            'promo_code.max' => __('messages.promo-code-max'),
            'type_id.required' => __('messages.transfer-type-required'),
            'type_id.exists' => __('messages.transfer-type-not-found'),
            'airport_id.required' => __('messages.airport-required'),
            'airport_id.exists' => __('messages.airport-not-found'),
            'destination_id.required' => __('messages.destination-required'),
            'destination_id.exists' => __('messages.destination-not-found'),
            'capacity_id.required' => __('messages.capacity-required'),
            'capacity_id.exists' => __('messages.capacity-not-found'),
            'departure.date_format' => __('messages.date-format'),
            'arrival.date_format' => __('messages.date-format')
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
