<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateUserPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->is_admin || Auth::user()->id == $this->get('id');
    }

    public function rules()
    {
        return
            [
                'id' => 'required|integer',
                'password' => 'required|string|min:8|confirmed',
            ];
    }

    public function messages()
    {
        return
            [
                'id.required' => 'Не был передан параметр id',
                'id.integer' => 'Неверный тип параметра id',
                'password.required' => 'Необходимо ввести пароль',
                'password.string' => 'Некорректный пароль',
                'password.min' => 'Пароль должен иметь длину не менее 8 символов',
                'password.confirmed' => 'Введенные пароли не совпадают',
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
