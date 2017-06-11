<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentBasicInfoRequest extends FormRequest
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
            'email'=>'email|unique:student_personal_info',
            'student_user_name'=>'unique:student_personal_info',
            'student_eng_name'=>'required',
            'student_ban_name'=>'required',
            'gender'=>'required',
            'religion'=>'required',
            'registration_id'=>'required',
            'date_of_birth'=>'required',
            'phone_home'=>'required',
            'father_name'=>'required',
            'mother_name'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'student_eng_name.required' => 'The student english name field is required.',
            'student_ban_name.required'  => 'The student bangla name field is required',
            'registration_id.required'  => 'The registration no. field is required',
        ];
    }
}
