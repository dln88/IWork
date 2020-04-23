<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|string|max:10',
            'password' => 'required|string|max:30'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'ログインIDが未入力です。',
            'password.required'  => 'パスワードが未入力です。',
            'user_id.max'  => 'ログインIDの最大長は10文字です。',
            'password.max'  => 'パスワードの最大長は30文字です。',
            'user_id.string'  => 'ログインIDは半角英数字でなければなりません。',
            'password.string'  => 'パスワードは半角英数字でなければなりません。',
        ];
    }
}
