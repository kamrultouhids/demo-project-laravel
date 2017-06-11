<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RabEmployeeRequest extends FormRequest
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
        if(isset($this->id)){
            return [
                'employee_no'=>'required|unique:rab_employee,employee_no,'.$this->id,
                'employee_name'=>'required',
                'gender'=>'required',
                'contact_no'=>'required',
                'employee_image'=>'required',
                'fk_battalion_id'=>'required',
                'fk_designation_id'=>'required'
            ];
        }

        return [
            'employee_no'=>'required|unique:rab_employee',
            'employee_name'=>'required',
            'gender'=>'required',
            'contact_no'=>'required',
            'employee_image'=>'required',
            'fk_battalion_id'=>'required',
            'fk_designation_id'=>'required'
        ];
    }
}
