<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AirportRequest extends FormRequest
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
            'en_name' => 'bail|required|string|max:255',
            'ru_name' => 'bail|required|string|max:255',
            'tr_name' => 'bail|required|string|max:255',
            'ua_name' => 'bail|required|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'en_name.required' => __('messages.airport-name-required'),
            'en_name.max' => __('messages.airport-name-max'),
            'ru_name.required' => __('messages.airport-name-required'),
            'ru_name.max' => __('messages.airport-name-max'),
            'tr_name.required' => __('messages.airport-name-required'),
            'tr_name.max' => __('messages.airport-name-max'),
            'ua_name.required' => __('messages.airport-name-required'),
            'ua_name.max' => __('messages.airport-name-max'),
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
