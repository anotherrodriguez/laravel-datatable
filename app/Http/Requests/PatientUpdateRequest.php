<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
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
            'first_name' => ['sometimes', 'required', 'max:255'],
            'last_name' => ['sometimes', 'required', 'max:255'],
            'notification' => ['sometimes', 'required'],
            'emails.*' => ['sometimes', 'required', 'email:rfc,dns' ],
            'phone_numbers.*' => ['sometimes', 'required', 'phone_number:test'],
            'department_id' => ['sometimes', 'required'],
            'date_of_service' => ['sometimes', 'required'],
            'site_id' => ['sometimes', 'required'],
            'status_id' => ['required'],
        ];
    }
}
