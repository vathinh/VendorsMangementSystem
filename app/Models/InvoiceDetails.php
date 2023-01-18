<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;

    protected $table = 'invoicedetails';
    public $timestamps = false;
    protected $primaryKey = 'invoicedetailsID';

    protected $fillable = [
        'invoiceID','productID','quantity','price','tax','subtotal','discount','amount'
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'productID');
    }
    public function sales()
    {
        return $this->belongsTo(Invoices::class, 'orderID');
    }
}

