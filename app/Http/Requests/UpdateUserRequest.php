<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
                'name' => 'required|string|min:3|max:100',
                'login' => 'required|string|min:3|max:32'
            ];
    }

    public function messages()
    {
        return
            [
                'id.required' => 'Не был передан параметр id',
                'id.integer' => 'Неверный тип параметра id',
                'name.required' => 'Необходимо ввести имя пользователя',
                'name.string' => 'Некорректное имя пользователя',
                'name.min' => 'Имя пользователя должно иметь длину не менее трех символов',
                'name.max' => 'Имя пользователя слишком длинное',
                'login.required' => 'Необходимо ввести логин пользователя',
                'login.string' => 'Некорректный логин пользователя',
                'login.min' => 'Логин пользователя должно иметь длину не менее трех символов',
                'login.max' => 'Логин пользователя слишком длинное'
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
