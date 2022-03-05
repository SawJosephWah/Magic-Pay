<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferValidate extends FormRequest
{
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
            'to_phone' => 'required|numeric',
            'amount' => 'required|numeric|min:500|max:500000'
        ];
    }

    public function messages()
{
    return [
        'to_phone.required' => 'Please fill To field information',
        'to_phone.numeric' => 'To field information must be phone number',
        'amount.required' => 'Please fill Amount field information',
        'amount.min' => 'Cannot transfer less than 500 MMK',
        'amount.max' => 'Cannot transfer more than 500000 MMK'
    ];
}
}
