<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return
            [
                'ids' => 'required|array|min:1',
                'ids.*' => 'required|integer|distinct'
            ];
    }

    public function messages()
    {
        return
            [
                'ids.required' => 'Не был передан ids',
                'id.array' => 'ids должен быть массивом',
                'ids.min' => 'Массив ids не должен быть пуст',
                'ids.*.integer' => 'Массив ids должен содержать целочисленные значения',
                'ids.*.distinct' => 'Массив ids должен содержать различные значения'
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
