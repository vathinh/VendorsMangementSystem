<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payables extends Model
{
    use HasFactory;

    //
    protected $table = 'payables';
    protected $primaryKey = 'payableID';
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

    protected $fillable = [
        'vendorID', 'payableDate', 'paymentMethod', 'total', 'userID','description'
    ];
}
