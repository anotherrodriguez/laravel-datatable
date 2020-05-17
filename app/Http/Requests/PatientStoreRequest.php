<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientStoreRequest extends FormRequest
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
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'notification' => ['required'],
            'emails.*' => ['required', 'email:rfc,dns' ],
            'phone_numbers.*' => ['required', 'phone_number:test'],
            'department_id' => ['required'],
            'date_of_service' => ['required'],
            'site_id' => ['required'],
            'hippa' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'We need your first name',
            'last_name.required' => 'We need last name',
            'notification.required' => 'We need a notification method',
            'emails.*.required' => 'We need your email address',
            'phone_numbers.*.required' => 'We need your phone number',
            'phone_numbers.*.phone_number' => 'Incorrect phone number format. Use 000-000-0000',
            'department_id.required' => 'Please select a department',
            'date_of_service.required' => 'Please select a date',
            'site_id.required' => 'Please select a site',
            'hippa.required' => 'We need you to agree',
        ];
    }
    
}