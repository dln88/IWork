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
            'start' => ['required', 'date_format:"H:i"'],
            'end' => ['required', 'regex:/^[0-9][0-9]:[0-5][0|5]$/'],
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
            'start.required' => '勤怠時間が確定していない勤怠情報の編集はできません。',
            'end.required'  => '勤怠時間が確定していない勤怠情報の編集はできません。',
        ];
    }
}
