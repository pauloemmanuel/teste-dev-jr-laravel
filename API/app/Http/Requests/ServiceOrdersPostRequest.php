<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceOrdersPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required' ,
            'vehiclePlate' => 'required',
            'entryDateTime' => 'required',
            'exitDateTime' => 'required',
            'priceType' => 'required',
            'price' => 'required',
            'userId' => 'required'
        ];
    }

    public function messages(): array
{
    return [
        'id.required' => 'O campo id é obrigatório ',
        'vehiclePlate.required' => 'O campo vehiclePlate é obrigatório ',
        'entryDateTime.required' => 'O campo entryDateTime é obrigatório ',
        'exitDateTime.required' => 'O campo exitDateTime é obrigatório ',
        'priceType.required' => 'O campo priceType é obrigatório ',
        'price.required' => 'O campo price é obrigatório ',
        'userId.required' => 'O campo userId é obrigatório '
    ];
}
}
