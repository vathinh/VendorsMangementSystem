<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayableDetails extends Model
{
    use HasFactory;

    protected $table = 'payabledetails';
    public $timestamps = false;
    protected $primaryKey = 'payabledetailsID';

    protected $fillable = [
        'payableID','billID','notes','amount'
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'productID');
    }
    public function sales()
    {
        return $this->belongsTo(Payables::class, 'orderID');
    }
}

