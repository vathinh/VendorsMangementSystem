<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportsRequest extends FormRequest
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
            'billID' => 'required|min:1',
            'productID' => 'required|array',
            'productID.*' => 'required|numeric|integer|not_in:0|bail',
            'quantity' => 'required|array|min:1|bail',
            'quantity.*' => 'required|numeric|integer|min:1|bail',
            // 'importDate'=> 'required|date|bail',
            // 'txttax'=> 'numeric|gt:0|bail',
            // 'txtdiscount'=> 'numeric|between:0,100|bail',
        ];
    }
    public function messages()
    {
        return [
            'billID.required'=>'Invoice ID cannot blank',
            'vendorID.required'=>'Vendor ID cannot blank',
            'productID.required'=>'Product ID cannot blank',
            'importDate.required'=> '* Import Date cannot blank',
            'importDate.date'=> '* Import Date is invalid !',
            'quantity.[*].required'=> 'Product quantity cannot blank',
            'quantity.[*].min'=> 'Product quantity cannot below 1',
            // 'quantity.numeric'=> 'Product quantity must be numeric and integer',
            // 'quantity.integer'=> 'Product quantity must be numeric and integer',
            // 'txttax.numeric'=> '* Tax must be numeric',
            // 'txttax.gte'=> '* Tax cannot below 0',
            // 'txtdiscount.numeric'=> '* Discount must be numeric',
            // 'txtdiscount.between'=> '* Discount should be from 0% to 100%',
        ];
    }
}
