<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|min:8|max:191',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスは必須です。',
            'email.string' => 'メールアドレスは文字列でなければなりません。',
            'email.email' => '有効なメールアドレス形式で入力してください。',
            'email.max' => 'メールアドレスは191文字以内で入力してください。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
            'email.exists' => 'このメールアドレスは登録されていません。',

            'password.required' => 'パスワードは必須です。',
            'password.string' => 'パスワードは文字列でなければなりません。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは191文字以内で入力してください。',
            'password.incorrect' => '誤ったパスワードとなっています。',
        ];
    }
}
