<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivables extends Model
{
    use HasFactory;

    //
    protected $table = 'receivables';
    protected $primaryKey = 'receivableID';
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

    protected $fillable = [
        'customerID', 'receivableDate', 'paymentMethod', 'total', 'userID','description'
    ];
}
