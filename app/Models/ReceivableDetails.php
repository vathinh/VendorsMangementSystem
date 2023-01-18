<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivableDetails extends Model
{
    use HasFactory;

    protected $table = 'receivabledetails';
    public $timestamps = false;
    protected $primaryKey = 'receivabledetailsID';

    protected $fillable = [
        'receivableID','invoiceID','notes','amount'
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'productID');
    }
    public function sales()
    {
        return $this->belongsTo(Receivables::class, 'orderID');
    }
}

