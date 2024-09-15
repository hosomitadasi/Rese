<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'stripeToken' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'stripeToken.required' => 'カード情報が正しく入力されていません。',
        ];
    }
}
