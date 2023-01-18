<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'productName'=> 'required|bail',
            'manufacture'=> 'required|bail',
            'salesprice'=> 'required|numeric|min:0|gte:salesprice|bail',
            'purchaseprice'=> 'required|numeric|min:0|lte:salesprice|bail',
            'quantity'=> 'required|numeric|integer|min:0|bail',
            'category'=> 'required|bail',
            // 'picture'=> 'required|bail',
        ];
    }
    public function messages()
    {
        return [
            'productName.required'=> '* Product Name cannot blank',
            // 'txtname.unique'=> '* Product Name must be unique !',
            'manufacture.required'=> '* Manufacturer cannot blank',
            'salesprice.required'=> '* Sale Price cannot blank',
            'salesprice.numeric'=> '* Sale Price must be numeric',
            'salesprice.min'=> '* Sale Price cannot below 0',
            'saleprice.gte'=> '* Product Sale Price should be less than or equal Purchase Price',
            'purchaseprice.required'=> '* Product Purchase Price cannot blank',
            'purchaseprice.numeric'=> '* Product Purchase Price must be numeric',
            'purchaseprice.min'=> '* Product Purchase Price cannot below 0',
            'purchaseprice.lte'=> '* Product Purchase Price should be less than or equal Sale Price',
            'quantity.required'=> '* Product quantity cannot blank',
            'quantity.numeric'=> '* Product quantity must be numeric and integer',
            'quantity.integer'=> '* Product quantity must be numeric and integer',
            'quantity.min'=> '* Product quantity cannot below 0',
            'category.required'=> '* Category cannot blank',
            // 'picture.required'=> '* Product picture cannot blank',
        ];
    }
}
