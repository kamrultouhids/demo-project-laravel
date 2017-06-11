<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvictArrestInfo extends FormRequest
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
            'case_id'=>'required',
            'date'=>'required',
            'details.convict_arrest_information_id.*' => 'required',
            'details.name.*' => 'required',
            'details.place.*' => 'required',
        ];
    }
}
