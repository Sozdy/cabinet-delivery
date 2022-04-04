<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return
            [
                'date' => 'required|string',
            ];
    }

    public function messages()
    {
        return
            [
                'date.required' => 'Не был передан параметр date',
                'date.string' => 'Параметр date должен быть строкой',
            ];
    }

    protected function failedAuthorization()
    {
        parent::failedAuthorization();
    }

    protected  function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::getJsonResultResponse(false, 'Переданы некорректные данные', [ 'errors' => $validator->errors()->toArray() ]));
    }

}
