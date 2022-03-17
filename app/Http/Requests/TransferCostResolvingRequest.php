<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TransferCostResolvingRequest extends FormRequest
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
            'type_id' => 'bail|required|exists:transfer_types,id',
            'airport_id' => 'bail|required|exists:airports,id',
            'destination_id' => 'bail|required|exists:transfer_destinations,id',
            'departure' => 'bail|nullable|date_format:Y-m-d H:i:00',
            'arrival' => 'bail|nullable|date_format:Y-m-d H:i:00',
            'capacity_id' => 'bail|required|exists:transfer_capacity,id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'type_id.required' => __('messages.transfer-type-required'),
            'type_id.exists' => __('messages.transfer-type-not-found'),
            'airport_id.required' => __('messages.airport-required'),
            'airport_id.exists' => __('messages.airport-not-found'),
            'destination_id.required' => __('messages.destination-required'),
            'destination_id.exists' => __('messages.destination-not-found'),
            'departure.date_format' => __('messages.departure-date-format'),
            'arrival.date_format' => __('messages.arrival-date-format'),
            'capacity_id.required' => __('messages.capacity-required'),
            'capacity_id.exists' => __('messages.capacity-not-found')
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
