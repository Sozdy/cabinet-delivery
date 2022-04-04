<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class ChangeDayRequest extends DateRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge(parent::rules(),
            [
               'value' => 'integer|required'
            ]);
    }

    public function messages()
    {
        return array_merge(parent::messages(),
            [
                'value.required' => 'Не был передан параметр value',
                'value.integer' => 'Параметр value должен быть числом',
            ]);
    }

    protected function failedAuthorization()
    {
        parent::failedAuthorization();
    }

    protected function failedValidation(Validator $validator)
    {
        return parent::failedValidation($validator);
    }
}
