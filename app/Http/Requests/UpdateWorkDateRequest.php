<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkDateRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'start' => ['required', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'end' => ['required', 'regex:/^([0-9]|[0-9][0-9]):([0-5][0-9])$/'],
            'memo' => 'nullable|string',
            'paid' => 'nullable|in:on',
            'exchange' => 'nullable|in:on',
            'special' => 'nullable|in:on',
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
            'start.regex' => '勤怠の開始時間の入力形式が不正です。',
            'end.regex' => '勤怠の終了時間の入力形式が不正です。',
            'start.required' => '勤怠の開始時間が確定していない勤怠情報の編集はできません。',//config('messages.010019'),
            'end.required'  => '勤怠の終了時間が確定していない勤怠情報の編集はできません。' //config('messages.010019')
        ];
        
    }
}
