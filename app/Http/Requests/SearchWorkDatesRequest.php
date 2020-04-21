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
            'emp_num' => 'nullable|string|min:1|max:15',
            'department_id' => 'nullable|integer',
            'name' => 'nullable|string|max:30',
            'from_month' => 'nullable|date_format:Y/m',
            'to_month' => 'nullable|date_format:Y/m',
            'ot_min' => 'nullable|string|max:5',
            'ot_max' => 'nullable|string|max:5',
            'on_min' => 'nullable|string|max:5',
            'on_max' => 'nullable|string|max:5',
        ];
    }
}
