<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\ValidationMessages;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ServiceOrdersPostRequest extends FormRequest
{   
    public const RULES = [
        'vehiclePlate' => 'required|alpha_dash:ascii|max:7',
        'entryDateTime' => 'required|date',
        'exitDateTime' => 'nullable|date',
        'priceType' => 'nullable,string|max:55',
        'price' => 'nullable|decimal:0,2|max:999999999.99',
        'userId' => 'required|numeric|max_digits:11'
    ];

    public const MESSAGES = [
            'vehiclePlate.required' =>  ValidationMessages::REQUIRED,
            'vehiclePlate.alpha_dash' => ValidationMessages::ALPHA_DASH,
            'vehiclePlate.max' => ValidationMessages::MAX_DIGITS,
            
            'entryDateTime.required' =>  ValidationMessages::REQUIRED,
            'entryDateTime.date' =>  ValidationMessages::DATE,
            
            'exitDateTime.date' =>  ValidationMessages::DATE,

            'priceType.string' =>  ValidationMessages::STRING,
            'priceType.max' =>  ValidationMessages::MAX_DIGITS,

            'price.required' =>  ValidationMessages::REQUIRED,
            'price.decimal' =>  ValidationMessages::DECIMAL_DUAS_CASAS,
            'price.max' =>  ValidationMessages::MAX,

            'userId.required' =>  ValidationMessages::REQUIRED,
            'userId.numeric' =>  ValidationMessages::NUMERIC,
            'userId.max' =>  ValidationMessages::MAX_DIGITS
    ];
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
    public static function rules(): array
    {
        return self::RULES;
    }

    public function messages(): array
    {
        return self::MESSAGES;
    }

}
