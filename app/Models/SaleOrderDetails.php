<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrderDetails extends Model
{
    use HasFactory;

    protected $table = 'saleorderdetails';
    public $timestamps = false;
    protected $primaryKey = 'saleorderdetailsID';

    protected $fillable = [
        'orderID','productID','quantity','price','tax','subtotal','discount','amount'
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'productID');
    }
    public function sales()
    {
        return $this->belongsTo(SaleOrders::class, 'orderID');
    }
}

