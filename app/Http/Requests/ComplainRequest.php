<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplainRequest extends FormRequest
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
            'date'=>'required',
            'complainant_name'=>'required',
            'complainant_age'=>'required',
            'complainant_gender'=>'required',
            'complainant_contact_number'=>'required',
            'complainant_details'=>'required',
            'defendantDetails.defendant_name.*' => 'required',
            'defendantDetails.defendant_age.*' => 'required',
            'defendantDetails.defendant_gender.*' => 'required',
        ];
    }
}
