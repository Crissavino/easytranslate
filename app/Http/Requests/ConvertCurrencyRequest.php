<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvertCurrencyRequest extends FormRequest
{

    const CURRENCY_STR_SIZE = 3;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => ['required', 'numeric'],
            'source_currency' => ['required', 'string', 'size:'. self::CURRENCY_STR_SIZE],
            'target_currency' => ['required', 'string', 'size:'. self::CURRENCY_STR_SIZE],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'amount.numeric' => 'The amount to convert must be a number.',
            'size' => 'The :attribute size must be 3.',
            'string' => 'The :attribute must be a string.',
        ];
    }
}
