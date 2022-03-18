<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
            'en_title' => 'bail|required|string|max:256',
            'ru_title' => 'bail|required|string|max:256',
            'tr_title' => 'bail|required|string|max:256',
            'ua_title' => 'bail|required|string|max:256',
            'en_description' => 'bail|required|string|max:10240',
            'ru_description' => 'bail|required|string|max:10240',
            'tr_description' => 'bail|required|string|max:10240',
            'ua_description' => 'bail|required|string|max:10240',
            'region_id' => 'bail|required|numeric|exists:regions,id',
            'type_id' => 'bail|required|numeric|exists:property_types,id',
            'cost_unit_id' => 'bail|nullable|numeric|exists:cost_units,id',
            'cost' => 'bail|required|numeric|min:0',
            'params' => 'bail|nullable|json'
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'en_title.required' => __('messages.property-en-title-required'),
            'en_title.max' => __('messages.property-en-title-max'),
            'ru_title.required' => __('messages.property-ru-title-required'),
            'ru_title.max' => __('messages.property-ru-title-max'),
            'tr_title.required' => __('messages.property-tr-title-required'),
            'tr_title.max' => __('messages.property-tr-title-max'),
            'ua_title.required' => __('messages.property-ua-title-required'),
            'ua_title.max' => __('messages.property-ua-title-max'),
            'en_description.required' => __('messages.property-en-description-required'),
            'en_description.max' => __('messages.property-en-description-max'),
            'ru_description.required' => __('messages.property-ru-description-required'),
            'ru_description.max' => __('messages.property-ru-description-max'),
            'tr_description.required' => __('messages.property-tr-description-required'),
            'tr_description.max' => __('messages.property-tr-description-max'),
            'ua_description.required' => __('messages.property-ua-description-required'),
            'ua_description.max' => __('messages.property-ua-description-max'),
            'region_id.required' => __('messages.region-id-required'),
            'region_id.numeric' => __('messages.region-id-numeric'),
            'region_id.exists' => __('messages.region-not-found'),
            'type_id.required' => __('messages.property-type-required'),
            'type_id.numeric' => __('messages.property-type-numeric'),
            'type_id.exists' => __('messages.property-type-exists'),
//            'cost_unit_id.required' => __('messages.cost-unit-required'),
            'cost_unit_id.numeric' => __('messages.cost-unit-numeric'),
            'cost_unit_id.exists' => __('messages.cost-unit-exists'),
            'cost.required' => __('messages.property-cost-required'),
            'cost.numeric' => __('messages.property-cost-numeric'),
            'cost.min' => __('messages.property-cost-min'),
            'params.json' => __('messages.property-params-json')
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
