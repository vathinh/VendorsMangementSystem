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
            'txtname'=> 'required|bail',
            'txtaddress'=> 'required|bail',
            'txtphone'=> 'required|numeric|digits_between:8,10|bail',
            'txtemail'=> 'required|email|bail',
            'unpaid'=> 'required|numeric|gte:0|bail'

        ];
    }
    public function messages()
    {
        return [
            'txtname.required'=> '* Customer Name cannot blank',
            'txtname.unique'=> '* Customer Name must be unique !',
            'txtaddress.required'=> '* Customer Address cannot blank',
            'txtphone.required'=> '* Customer Phone cannot blank',
            'txtphone.numeric'=> '* Customer Phone must be numeric',
            'txtphone.digits_between'=> '* Customer Phone should be between 8 to 10 digit',
            'txtemail.required'=> '* Customer Email cannot blank',
            'txtemail.email'=> '* Customer Email is invalid !',
            'unpaid.required'=> '* Customer Unpaid cannot blank',
            'unpaid.numeric'=> '* Customer Unpaid must be numeric',
            'unpaid.gte'=> '* Customer Unpaid cannot below 0',
        ];
    }
}
