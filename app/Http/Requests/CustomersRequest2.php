<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomersRequest extends FormRequest
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
            'customerName' => 'bail|required',
            'TaxNumber' => 'bail|required',
            'address'=> 'bail|required',
            'phone'=> 'bail|required',
            'email'=> 'bail|required',
            // 'role'=> 'bail|required',
            'unpaid'=> 'bail|required',
        ];
    }
    public function messages(){
        return[
            'txtname.required'=>'Customer Name cannot be blank',
            'txtaddress.required'=>'Address cannot be blank',
            'txtphone.required'=>'Address cannot be blank',
            'txtphone.digits_between'=>'The phone number should be numeric only and must be between 8 and 10 digits',
            'txtemail.required'=>'Email cannot be blank',
            'txtunpaid.required'=>'Unpaid cannot be blank',
        ];
    }
}
