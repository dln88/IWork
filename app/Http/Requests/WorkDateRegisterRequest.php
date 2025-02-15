<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkDateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_time' => "nullable|date_format:H:i",
            'end_time' => "nullable|date_format:H:i"
        ];
    }
}
