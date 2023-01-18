<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceivablesRequest extends FormRequest
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
            'customerID' => 'required|not_in:0',
            'invoiceID' => 'required|array',
            'invoiceID.*' => 'required|numeric|integer|not_in:0|bail',
            'receivableDate'=>'required|date|bail',
            'paymentMethod'=> 'required',
        ];
    }
    public function messages()
    {
        return [
            'invoiceID.required'=> '* Invoice ID cannot blank',
            'receivableDate.required'=> '* Receivable Date cannot blank',
            'receivableDate.date'=> '* Receivable Date is invalid !',
            'paymentMethod.required'=> '* Payment Method cannot blank',
        ];
    }
}
