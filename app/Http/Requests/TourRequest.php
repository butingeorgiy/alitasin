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
            'en_description' => 'bail|required|string|min:10|max:2048',
            'ru_description' => 'bail|required|string|min:10|max:2048',
            'tr_description' => 'bail|required|string|min:10|max:2048',
            'address' => 'bail|required|string|min:10|max:256',
            'manager_id' => 'bail|required|numeric',
            'region_id' => 'bail|required|numeric',
            'price' => 'bail|required|numeric|min:0',
            'date' => 'bail|required|date_format:Y-m-d',
            'tour_type_id' => 'bail|required|numeric'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'en_title.required' => 'Необходимо указать название экскурсии на английском языке!',
            'en_title.min' => 'Название экскурсии на английском языке не должно быть короче 10 символов!',
            'en_title.max' => 'Название экскурсии на английском языке не должно быть длиннее 256 символов!',
            'ru_title.required' => 'Необходимо указать название экскурсии на русском языке!',
            'ru_title.min' => 'Название экскурсии на русском языке не должно быть короче 10 символов!',
            'ru_title.max' => 'Название экскурсии не на русском языке должно быть длиннее 256 символов!',
            'tr_title.required' => 'Необходимо указать название экскурсии на турецком языке!',
            'tr_title.min' => 'Название экскурсии на турецком языке не должно быть короче 10 символов!',
            'tr_title.max' => 'Название экскурсии на турецком языке не должно быть длиннее 256 символов!',
            'en_description.required' => 'Необходимо указать описание экскурсии на английском языке!',
            'en_description.min' => 'Описание экскурсии на английском языке не должно быть короче 10 символов!',
            'en_description.max' => 'Описание экскурсии на английском языке не должно быть длиннее 2048 символов!',
            'ru_description.required' => 'Необходимо указать описание экскурсии на русском языке!',
            'ru_description.min' => 'Описание экскурсии на русском языке не должно быть короче 10 символов!',
            'ru_description.max' => 'Описание экскурсии на русском языке не должно быть длиннее 2048 символов!',
            'tr_description.required' => 'Необходимо указать описание экскурсии на турецком языке!',
            'tr_description.min' => 'Описание экскурсии на турецком языке не должно быть короче 10 символов!',
            'tr_description.max' => 'Описание экскурсии на турецком языке не должно быть длиннее 2048 символов!',
            'address.required' => 'Необходимо указать адрес экскурсии!',
            'address.min' => 'Адрес не должен быть короче 10 символов!',
            'address.max' => 'Адрес не должен быть длиннее 256 символов!',
            'manager_id.required' => 'Необходимо указать менеджера!',
            'manager_id.numeric' => 'Некорректный ID менеджера! ID является числом!',
            'region_id.required' => 'Необходимо указать регион проведения экскурсии!',
            'region_id.numeric' => 'Некорректный ID региона! ID является числом!',
            'price.required' => 'Укажите стоимость!',
            'price.numeric' => 'Стоимость должна быть числом!',
            'price.min' => 'Стоимость не может быть отрицательной!',
            'date.required' => 'Укажите дату!',
            'date.date_format' => 'Некорректный формат даты!',
            'tour_type_id.required' => 'Укажите тип экскурсии!',
            'tour_type_id.numeric' => 'Некорректный ID типа экскурсии!'
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
