<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            // 'password'=> 'required',
            // 'password_confirmed'=>'required|same:password',
            'oldPassword'=>'required',

            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
    }
    public function messages()
    {
        return [
        'password.required'=>'* Password cannot blank',
        'password_confirmation.required'=> '* Password Confirmed cannot blank',
        'oldPassword.required'=> '* Old Password cannot blank',
        ];

    }
}
