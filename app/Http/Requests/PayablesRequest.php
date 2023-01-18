<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayablesRequest extends FormRequest
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
            'vendorID' => 'required|not_in:0',
            'billID' => 'required|array',
            'billID.*' => 'required|numeric|integer|not_in:0|bail',
            'payableDate'=>'required|date|bail',
            'paymentMethod'=> 'required',


        ];
    }
    public function messages()
    {
        return [
            'payableDate.required'=> '* Payable Date cannot blank',
            'payableDate.date'=> '* Payable Date is invalid !',
            'paymentMethod.required'=> '* Payment Method cannot blank',
        ];
    }
}
