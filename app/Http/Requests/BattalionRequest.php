<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BattalionRequest extends FormRequest
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
                'fk_division_id'=>'required',
                'fk_district_id'=>'required',
                'fk_police_station_id'=>'required',
                'battalion_name'=>'required|unique:battalion,battalion_name,'.$this->id,
                'battalion_address'=>'required',
                'contact_person_name'=>'required',
                'designation'=>'required',
                'contact_no'=>'required'
            ];
        }

        return [
            'fk_division_id'=>'required',
            'fk_district_id'=>'required',
            'fk_police_station_id'=>'required',
            'battalion_name'=>'required|unique:battalion',
            'battalion_address'=>'required',
            'contact_person_name'=>'required',
            'designation'=>'required',
            'contact_no'=>'required'
        ];
    }
}
