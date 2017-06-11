<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoliceStationRequest extends FormRequest
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
                'police_station_name'=>'required|unique:police_stations,police_station_name,'.$this->id,
            ];
        }

        return [
            'fk_division_id'=>'required',
            'fk_district_id'=>'required',
            'police_station_name'=>'required|unique:police_stations'
        ];
    }
}
