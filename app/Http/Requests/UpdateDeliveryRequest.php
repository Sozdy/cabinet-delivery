<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateDeliveryRequest extends FormRequest
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
                'contact_person' => 'nullable|string',
                'phone' => 'nullable|string',
                'date' => 'required|string',
                'value' => 'nullable|integer|min:0',
                'organization_name' => 'nullable|string',
                'organization_address' => 'nullable|string',
                'selling' => 'nullable|string',
                'account' => 'nullable|string',
                'is_in_region' => 'required|boolean',
                'is_paid' => 'required|boolean',
                'is_available' => 'required|boolean',
                'actions' => 'array',
                'actions.*' => 'integer|distinct',
                'delivery_state_id' => 'required|integer'
            ];
    }

    public function messages()
    {
        return
            [
                'id.required' => 'Необходимо передать параметр id',
                'id.integer' => 'Некорректный тип параметра id',
                'contact_person.string' => 'Некорректное имя контактного лица',
                'phone.string' => 'Некорректный номер телефона',
                'date.required' => 'Необходимо ввести дату',
                'date.string' => 'Некорректный формат даты',
                'organization_name.required' => 'Необходимо ввести название организации',
                'organization_name.string' => 'Некорректное название организации',
                'organization_address.required' => 'Необходимо ввести адрес организации',
                'organization_address.string' => 'Некорректный адрес организации',
                'value.required' => 'Необходимо ввести объем',
                'value.integer' => 'Некорректный объем',
                'value.min' => 'Некорректный объем',
                'selling.string' => 'Некорректная реализация',
                'account.string' => 'Некорректный номер счета',
                'is_in_region.required' => 'Необходимо передать параметр is_in_region',
                'is_in_region.boolean' => 'Некорректный параметр is_in_region',
                'is_paid.required' => 'Необходимо передать параметр is_paid',
                'is_paid.boolean' => 'Некорректный параметр is_paid',
                'is_available.required' => 'Необходимо передать параметр is_available',
                'is_available.boolean' => 'Некорректный параметр is_available',
                'actions.array' => 'actions должен быть массивом',
                'actions.*.integer' => 'Массив actions должен содержать целочисленные значения',
                'actions.*.distinct' => 'Массив actions должен содержать различные значения',
                'delivery_state_id.required' => 'Необходимо передать параметр delivery_state_id',
                'delivery_state_id.integer' => 'Некорректный тип параметра delivery_state_id',
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
