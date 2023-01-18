<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDetails extends Model
{
    use HasFactory;

    protected $table = 'importdetails';
    public $timestamps = false;
    protected $primaryKey = 'importdetailsID';

    protected $fillable = [
        'importID','productID','quantity'
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'productID');
    }
    public function sales()
    {
        return $this->belongsTo(Imports::class, 'orderID');
    }
}

