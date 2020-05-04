<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatusStoreRequest extends FormRequest
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
            //
            'site_id' => ['required'],
            'department_id' => ['required'],
            'new_status.*.name' => [
                'required', 
                Rule::unique('statuses')->where(function ($query) { 
                    return $query->where('department_id', $this->department_id);
                    })
                ],
        ];
    }
}
