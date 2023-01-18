<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillsRequest extends FormRequest
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
            'productID' => 'required|array',
            'productID.*' => 'required|numeric|integer|not_in:0|bail',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|integer|min:1|bail',
            // 'txtbilldate'=> 'required|date|bail',
            // 'txtquantity'=> 'required|numeric|integer|gte:0|bail',
            // 'txttax'=> 'numeric|gt:0|bail',
            // 'txtdiscount'=> 'numeric|between:0,100|bail',

            // 'quantity' => 'required|array|min:1',
            // 'quantity.*' => 'required|numeric|min:1',
            // 'quantity' => 'required|array|min:1',
            // 'quantity.*' => 'required|numeric|min:1',
        ];
    }
    public function messages()
    {
        return [
            'vendorID.required'=>'Vendor ID cannot blank',
            'productID.required'=>'Product ID cannot blank',
            'quantity.[*].required'=> 'Product quantity cannot blank',
            'quantity.[*].min'=> 'Product quantity cannot below 1',
            // 'txtbilldate.required'=> '* Bill Date cannot blank',
            // 'txtbilldate.date'=> '* Bill Date is invalid !',
            // 'txtquantity.required'=> '* Product quantity cannot blank',
            // 'txtquantity.numeric'=> '* Product quantity must be numeric and integer',
            // 'txtquantity.integer'=> '* Product quantity must be numeric and integer',
            // 'txtquantity.gt'=> '* Product quantity cannot below 0',
            // 'txttax.numeric'=> '* Tax must be numeric',
            // 'txttax.gte'=> '* Tax cannot below 0',
            // 'txtdiscount.numeric'=> '* Discount must be numeric',
            // 'txtdiscount.between'=> '* Discount should be from 0% to 100%',
        ];
    }
}
