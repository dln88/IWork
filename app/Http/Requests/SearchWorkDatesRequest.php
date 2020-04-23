<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchWorkDatesRequest extends FormRequest
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
            'emp_num' => 'nullable|numeric|max:15',
            'department_id' => 'nullable|integer',
            'name' => 'nullable|string|max:30',
            'from_month' => 'nullable|date_format:Y/m',
            'to_month' => 'nullable|date_format:Y/m',
            'ot_min' => 'nullable|numeric',
            'ot_max' => 'nullable|numeric',
            'on_min' => 'nullable|numeric',
            'on_max' => 'nullable|numeric',
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
            'emp_num.numeric' => '従業員番号は数値タイプでなければなりません。',
            'emp_num.max' => '従業員コードは15以下でなければなりません',
            'department_id.integer' => '部門の入力形式が不正です。',
            'name.string' => '名前は文字列でなければなりません',
            'name.max' => '名前は30以下である必要があります',
            'from_month.date_format' => '入力形式が無効です。',
            'to_month.date_format' => '入力形式が無効です。',
            'ot_min.numeric' => '残業は数値でなければなりません。',
            'ot_max.numeric' => '残業は数値でなければなりません。',
            'on_min.numeric' => '一晩は数字でなければなりません。',
            'on_max.numeric' => '一晩は数字でなければなりません。',
        ];
    }
}
