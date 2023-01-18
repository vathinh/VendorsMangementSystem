<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorsRequest extends FormRequest
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
            'vendorName'=> 'required|bail',
            'address'=> 'required|bail',
            'phone'=> 'required|numeric|digits_between:8,10|bail',
            'email'=> 'required|email|bail',
            'unpaid'=> 'required|numeric|gte:0|bail'
        ];
    }
    public function messages()
    {
        return [
            'vendorName.required'=> '* Vendor Name cannot blank',
            'address.required'=> '* Vendor Address cannot blank',
            'phone.required'=> '* Vendor Phone cannot blank',
            'phone.numeric'=> '* Vendor Phone must be numeric',
            'phone.digits_between'=> '* Vendor Phone should be between 8 to 10 digit',
            'email.required'=> '* Vendor Email cannot blank',
            'email.email'=> '* Vendor Email is invalid !',
            'unpaid.required'=> '* Vendor Unpaid cannot blank',
            'unpaid.numeric'=> '* Vendor Unpaid must be numeric',
            'unpaid.gte'=> '* Vendor Unpaid cannot below 0',
        ];
    }
}
