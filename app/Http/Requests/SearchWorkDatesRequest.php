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
            'emp_num.numeric' => '社員番号は実数で入力ください。',
            'emp_num.max' => '社員番号の最大長は15文字です。',
            'department_id.integer' => '部門は実数で入力ください。',
            'name.string' => '名前は文字列でなければなりません。',
            'name.max' => '氏名の最大長は30文字です。',
            'from_month.date_format' => '対象年月_FROMの入力形式が無効です。',
            'to_month.date_format' => '対象年月_TOの入力形式が無効です。',
            'ot_min.numeric' => '残業時間（合計）の開始は実数で入力ください。',
            'ot_max.numeric' => '残業時間（合計）の終了は実数で入力ください。',
            'on_min.numeric' => '深夜時間（合計）の開始は実数で入力ください。',
            'on_max.numeric' => '深夜時間（合計）の終了は実数で入力ください。',
        ];
    }
}
