<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetails extends Model
{
    use HasFactory;

    protected $table = 'purchaseorderdetails';
    public $timestamps = false;
    protected $primaryKey = 'purchaseorderdetailsID';

    protected $fillable = [
        'purchaseorderID','productID','quantity','price','tax','subtotal','discount','amount'
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'productID');
    }
    public function sales()
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchaseorderID');
    }
}

