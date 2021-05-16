<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'brand' => 'bail|required|string|min:2|max:64',
            'model' => 'bail|required|string|min:2|max:64',
            'region_id' => 'bail|required|numeric',
            'cost' => 'bail|required|numeric',
            'vehicle_type_id' => 'bail|required|numeric',
            'params' => 'bail|nullable|json',
            'show_at_index_page' => 'bail|nullable|in:0,1'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'brand.required' => 'Укажите название бренда!',
            'brand.min' => 'Минимальная длина бренда 2 символа!',
            'brand.max' => 'Максимальная длина бренда 64 символа!',
            'model.required' => 'Укажите название модели!',
            'model.min' => 'Минимальная длина модели 2 символа!',
            'model.max' => 'Максимальная длина модели 64 символа!',
            'region_id.required' => 'Укажите регион!',
            'region_id.numeric' => 'ID региона должно быть числом!',
            'cost.required' => 'Укажите стоимость!',
            'cost.numeric' => 'Стоимость должна быть числом!',
            'vehicle_type_id.required' => 'Укажите тип ТС!',
            'vehicle_type_id.numeric' => 'Тип ТС должен быть числом!',
            'params.json' => 'Некорректный тип параметров! Необходимо отправить JSON!',
            'show_at_index_page.in' => 'Некорректное значение show_at_index_page!'
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
