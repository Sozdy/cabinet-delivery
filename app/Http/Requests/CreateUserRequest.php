<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->is_admin;
    }

    public function rules()
    {
        return
            [
                'name' => 'required|string|min:3|max:100',
                'login' => 'required|string|min:3|max:32',
                'password' => 'required|string|min:8|confirmed',
                'is_admin' => 'required|boolean'
            ];
    }

    public function messages()
    {
        return
            [
                'name.required' => 'Необходимо ввести имя пользователя',
                'name.string' => 'Некорректное имя пользователя',
                'name.min' => 'Имя пользователя должно иметь длину не менее трех символов',
                'name.max' => 'Имя пользователя слишком длинное',
                'login.required' => 'Необходимо ввести логин пользователя',
                'login.string' => 'Некорректный логин пользователя',
                'login.min' => 'Логин пользователя должно иметь длину не менее трех символов',
                'login.max' => 'Логин пользователя слишком длинное',
                'password.required' => 'Необходимо ввести пароль',
                'password.string' => 'Некорректный пароль',
                'password.min' => 'Пароль должен иметь длину не менее 8 символов',
                'password.confirmed' => 'Введенные пароли не совпадают',
                'is_admin.required' => 'Необходимо передать параметр is_admin',
                'is_admin.boolean' => 'Некорректный тип параметра is_admin'
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
