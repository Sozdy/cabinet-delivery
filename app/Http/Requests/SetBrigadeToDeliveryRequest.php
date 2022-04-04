<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class SetBrigadeToDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->is_admin;
    }

    public function rules()
    {
        return
            [
                'brigade_id' => 'integer',
                'delivery_id' => 'required|integer',
                'order_id' => 'integer'
            ];
    }

    public function messages()
    {
        return
            [
                'brigade_id.integer' => 'Неверный тип параметра id',
                'delivery_id.required' => 'Не был передан параметр id',
                'delivery_id.integer' => 'Неверный тип параметра id',
                'order_id.integer' => 'Неверный тип параметра id',
            ];
    }

    protected function failedAuthorization()
    {
        //return ResponseHandler::getJsonStatusResponse(400, 'Недостаточно прав для выполнения операции');
        //TODO: подумать, как поправить
        parent::failedAuthorization();
    }

    protected  function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::getJsonResultResponse(false, 'Переданы некорректные данные', [ 'errors' => $validator->errors()->toArray() ]));
    }
}
