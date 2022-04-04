<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateActionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return
            [
                'id' => 'required|integer',
                'name' => 'required|string|min:1|max:100',
            ];
    }

    public function messages()
    {
        return
            [
                'id.required' => 'Не был передан параметр id',
                'id.integer' => 'Неверный тип параметра id',
                'name.required' => 'Необходимо ввести название действия',
                'name.string' => 'Некорректное название действия',
                'name.min' => 'Название действия должно состоять хотя бы из одной буквы',
                'name.max' => 'Название действия слишком длинное',
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
