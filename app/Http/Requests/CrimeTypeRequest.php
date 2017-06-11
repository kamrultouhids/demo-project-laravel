<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrimeTypeRequest extends FormRequest
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
                'crime_type_name'=>'required|unique:crime_type,crime_type_name,'.$this->id,

            ];
        }

        return [
            'crime_type_name'=>'required|unique:crime_type'
        ];
    }
}
