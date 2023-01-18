<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetails extends Model
{
    use HasFactory;

    protected $table = 'billdetails';
    public $timestamps = false;
    protected $primaryKey = 'billdetailsID';

    protected $fillable = [
        'billID','productID','quantity','price','tax','subtotal','discount','amount'
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'productID');
    }
    public function sales()
    {
        return $this->belongsTo(Bills::class, 'orderID');
    }
}

