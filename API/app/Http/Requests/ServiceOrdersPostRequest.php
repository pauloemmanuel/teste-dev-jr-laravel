<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\ValidationMessages;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ServiceOrdersPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'vehiclePlate' => 'required|alpha_dash:ascii|max_digits:7',
            'entryDateTime' => 'required|date',
            'exitDateTime' => 'nullable|date',
            'priceType' => 'nullable,alpha_dash:ascii|max_digits:55',
            'price' => 'nullable|decimal:0,2|max_digits:13|max:9999999999.99',
            'userId' => 'required|numeric|max_digits:11'
        ];
    }

    public function messages(): array
    {
        return [ 
            'vehiclePlate.required' =>  ValidationMessages::REQUIRED,
            'vehiclePlate.numeric' => ValidationMessages::NUMERIC,
            'vehiclePlate.alpha_dash' => ValidationMessages::ALPHA_DASH,
            'vehiclePlate.max_digits' => ValidationMessages::MAX_DIGITS,
            
            'entryDateTime.required' =>  ValidationMessages::REQUIRED,
            'entryDateTime.date' =>  ValidationMessages::DATE,
            
            'exitDateTime.date' =>  ValidationMessages::DATE,

            'priceType.alpha_dash' =>  ValidationMessages::ALPHA_DASH,
            'priceType.max_digits' =>  ValidationMessages::MAX_DIGITS,

            'price.required' =>  ValidationMessages::REQUIRED,
            'price.decimal' =>  ValidationMessages::DECIMAL,
            'price.max' =>  ValidationMessages::MAX,
            'price.max_digits' =>  ValidationMessages::MAX_DIGITS,

            'userId.required' =>  ValidationMessages::REQUIRED,
            'userId.numeric' =>  ValidationMessages::NUMERIC,
            'userId.max_digits' =>  ValidationMessages::MAX_DIGITS,
        ];
    }

    protected function failedValidation($validator)
    {
        return Controller::handleValidationError($validator);
    }
}
