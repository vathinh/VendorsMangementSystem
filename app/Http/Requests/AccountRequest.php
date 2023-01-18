<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'fullname' => 'bail|required',
            'password' => 'bail|required|min:4'
        ];
    }
    public function messages()
    {
        return[
            'fullname.required' => 'Please input your Full name!',
            'email.required' => 'Your email is necessary!',
            'password.required' => 'You cant create account without password!',
            'password.min' => 'Please your password is too weak!'

        ];
    }
}
