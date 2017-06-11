<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userControllerRequest extends FormRequest
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
        if(isset($this->user)){
            return [
            'name'=>'required',
            'email'=>'required|unique:user_info,email,'.$this->user,
        ];
        }
        return [
            'name'=>'required',
			'email'=>'required|unique:user_info',
			'password'=>'required|confirmed',
			'picture'=>'required',
        ];
    }
}
