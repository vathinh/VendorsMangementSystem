<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'username'=> 'required|bail',
            'email'=> 'required|email|bail',
            // 'password'=> 'required|bail',
            // 'password_confirmed'=>'required|confirmed|bail',
            'fullname'=> 'required|bail',
            'phone'=> 'required|numeric|digits_between:8,10|bail',
            // 'oldPassword'=>'required|current_password|bail',

        ];
    }
    public function messages()
    {
        return [
            'username.required'=> '* Username cannot blank',
            'username.unique'=>'* Username must be unique !',
            'email.required'=> '* User Email cannot blank',
            'email.email'=> '* User Email is invalid !',
            // 'password.required'=> '* Password cannot blank',
            // 'password_confirmed.required'=> '* Password Confirmed cannot blank',
            // 'password_confirmed.required'=> '* Password Confirmed does not match',
            // 'oldPassword.required'=> '* Old Password cannot blank',
            // 'oldPassword.current_password'=> '* Old Password does not match',
            'fullname.required'=> '* Full Name cannot blank',
            // 'txtname.unique'=> '* User Name must be unique !',
            'phone.required'=> '* User Phone cannot blank',
            'phone.numeric'=> '* User Phone must be numeric',
            'phone.digits_between'=> '* User Phone should be between 8 to 10 digit',

        ];
    }
}
