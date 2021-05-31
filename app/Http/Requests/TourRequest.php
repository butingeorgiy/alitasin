<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
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
            'en_title' => 'bail|required|string|min:10|max:256',
            'ru_title' => 'bail|required|string|min:10|max:256',
            'tr_title' => 'bail|required|string|min:10|max:256',
            'en_description' => 'bail|required|string|min:10|max:10240',
            'ru_description' => 'bail|required|string|min:10|max:10240',
            'tr_description' => 'bail|required|string|min:10|max:10240',
            'manager_id' => 'bail|required|numeric',
            'region_id' => 'bail|required|numeric',
            'price' => 'bail|required|numeric|min:0',
            'conducted_at' => 'bail|required|json',
            'tour_type_id' => 'bail|required|numeric',
            'filters' => 'bail|required|json',
            'duration' => ['bail', 'nullable', 'regex:/^\d*~(h|d)$/'],
            'additions' => 'bail|nullable|json'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'en_title.required' => __('messages.tour-en-title-required'),
            'en_title.min' => __('messages.tour-en-title-min'),
            'en_title.max' => __('messages.tour-en-title-max'),
            'ru_title.required' => __('messages.tour-ru-title-required'),
            'ru_title.min' => __('messages.tour-ru-title-min'),
            'ru_title.max' => __('messages.tour-ru-title-max'),
            'tr_title.required' => __('messages.tour-tr-title-required'),
            'tr_title.min' => __('messages.tour-tr-title-min'),
            'tr_title.max' => __('messages.tour-tr-title-max'),
            'en_description.required' => __('messages.tour-en-description-required'),
            'en_description.min' => __('messages.tour-en-description-min'),
            'en_description.max' => __('messages.tour-en-description-max'),
            'ru_description.required' => __('messages.tour-ru-description-required'),
            'ru_description.min' => __('messages.tour-ru-description-min'),
            'ru_description.max' => __('messages.tour-ru-description-max'),
            'tr_description.required' => __('messages.tour-tr-description-required'),
            'tr_description.min' => __('messages.tour-tr-description-min'),
            'tr_description.max' => __('messages.tour-tr-description-max'),
            'manager_id.required' => __('messages.tour-manager-require'),
            'manager_id.numeric' => __('messages.tour-manager-id-numeric'),
            'region_id.required' => __('messages.tour-region-require'),
            'region_id.numeric' => __('messages.tour-region-id-numeric'),
            'price.required' => __('messages.tour-price-require'),
            'price.numeric' => __('messages.tour-price-numeric'),
            'price.min' => __('messages.tour-price-min'),
            'conducted_at.required' => __('messages.tour-conducted-at-require'),
            'conducted_at.json' => __('messages.tour-conducted-at-json'),
            'tour_type_id.required' => __('messages.tour-type-require'),
            'tour_type_id.numeric' => __('messages.tour-type-id-numeric'),
            'filters.required' => __('messages.tour-filters-require'),
            'filters.json' => __('messages.tour-filters-json'),
            'duration.regex' => __('messages.tour-duration-format'),
            'additions.json' => __('messages.tour-additions-json')
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
