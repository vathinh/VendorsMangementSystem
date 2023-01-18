<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportDetails extends Model
{
    use HasFactory;

    protected $table = 'exportdetails';
    public $timestamps = false;
    protected $primaryKey = 'exportdetailsID';

    protected $fillable = [
        'exportID','productID','quantity'
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'productID');
    }
    public function sales()
    {
        return $this->belongsTo(Exports::class, 'orderID');
    }
}

