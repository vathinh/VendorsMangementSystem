<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrdersRequest extends FormRequest
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
            // 'purchaseorderDate'=> 'required|date|bail',
            // 'tax'=> 'numeric|gt:0|bail',
            // 'discount'=> 'numeric|between:0,100|bail',
        ];
    }
    public function messages()
    {
        return [


            'customerID.required'=>'Customer ID cannot blank',
            'productID.required'=>'Product ID cannot blank',
            'quantity.[*].required'=> 'Product quantity cannot blank',
            'quantity.[*].min'=> 'Product quantity cannot below 1',
            // 'purchaseDate.required'=> '* Purchase Order Date cannot blank',
            // 'purchaseDate.date'=> '* Purchase Order Date is invalid !',
            // 'quantity.[*].numeric'=> 'Product quantity must be numeric and integer',
            // 'quantity.[*].integer'=> 'Product quantity must be numeric and integer',
            // 'quantity.required'=> 'Product quantity cannot blank',
            // 'quantity.numeric'=> 'Product quantity must be numeric and integer',
            // 'quantity.integer'=> 'Product quantity must be numeric and integer',
            // 'quantity.min'=> 'Product quantity cannot below 1',
            // 'tax.numeric'=> 'Tax must be numeric',
            // 'tax.min'=> 'Tax cannot below 0',
            // 'discount.numeric'=> 'Discount must be numeric',
            // 'discount.between'=> 'Discount should be from 0% to 100%',

        ];
    }
}
