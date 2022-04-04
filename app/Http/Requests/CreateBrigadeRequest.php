<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateBrigadeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return
            [
                'phone' => 'nullable|string',
                'contact_person' => 'nullable|string',
                'car' => 'nullable|string',
                'driver' => 'nullable|string',
                'brigade_type_id' => 'required|integer'
            ];
    }

    public function messages()
    {
        return
            [
                'phone.string' => 'Некорректный номер телефона',
                'contact_person.string' => 'Некорректное имя контакного лица',
                'driver.string' => 'Некорректное имя водителя',
                'car.string' => 'Некорректная информация об автомобиле',
                'brigade_type_id.required' => 'Необходимо передать параметр brigade_type_id',
                'brigade_type_id.integer' => 'Некорректный тип параметра brigade_type_id'
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
