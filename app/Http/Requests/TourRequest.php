<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TourCreatingRequest extends FormRequest
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
            'en_description' => 'bail|required|string|min:10|max:2048',
            'ru_description' => 'bail|required|string|min:10|max:2048',
            'tr_description' => 'bail|required|string|min:10|max:2048',
            'address' => 'bail|required|string|min:10|max:256',
            'manager_id' => 'bail|required|numeric',
            'region_id' => 'bail|required|numeric',
            'price' => 'bail|required|numeric|min:0',
            'date' => 'bail|required|date_format:Y-m-d'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'en_title.required' => 'Необходимо указать название тура на английском языке!',
            'en_title.min' => 'Название тура на английском языке не должно быть короче 10 символов!',
            'en_title.max' => 'Название тура на английском языке не должно быть длинее 256 символов!',
            'ru_title.required' => 'Необходимо указать название тура на русском языке!',
            'ru_title.min' => 'Название тура на русском языке не должно быть короче 10 символов!',
            'ru_title.max' => 'Название тура не на русском языке должно быть длинее 256 символов!',
            'tr_title.required' => 'Необходимо указать название тура на турецком языке!',
            'tr_title.min' => 'Название тура на турецком языке не должно быть короче 10 символов!',
            'tr_title.max' => 'Название тура на турецком языке не должно быть длинее 256 символов!',
            'en_description.required' => 'Необходимо указать описание тура на английском языке!',
            'en_description.min' => 'Описание тура на английском языке не должно быть короче 10 символов!',
            'en_description.max' => 'Описание тура на английском языке не должно быть длинее 2048 символов!',
            'ru_description.required' => 'Необходимо указать описание тура на русском языке!',
            'ru_description.min' => 'Описание тура на русском языке не должно быть короче 10 символов!',
            'ru_description.max' => 'Описание тура на русском языке не должно быть длинее 2048 символов!',
            'tr_description.required' => 'Необходимо указать описание тура на турецком языке!',
            'tr_description.min' => 'Описание тура на турецком языке не должно быть короче 10 символов!',
            'tr_description.max' => 'Описание тура на турецком языке не должно быть длинее 2048 символов!',
            'address.required' => 'Необходимо указать адрес тура!',
            'address.min' => 'Адрес не должен быть короче 10 символов!',
            'address.max' => 'Адрес не должен быть длинее 256 символов!',
            'manager_id.required' => 'Необходимо указать менеджера!',
            'manager_id.numeric' => 'Некорректный ID менеджера! ID является числом!',
            'region_id.required' => 'Необходимо указать регион проведения тура!',
            'region_id.numeric' => 'Некорректный ID региона! ID является числом!',
            'price.required' => 'Укажите стоимость!',
            'price.numeric' => 'Стоимость должна быть числом!',
            'price.min' => 'Стимость не может быть отрицательной!',
            'date.required' => 'Укажите дату!',
            'date.date_format' => 'Некорректный формат даты!'
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
