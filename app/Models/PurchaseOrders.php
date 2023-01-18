<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrders extends Model
{
    use HasFactory;

    //
    protected $table = 'purchaseorders';
    protected $primaryKey = 'purchaseorderID';
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

    protected $fillable = [
        'vendorID', 'purchaseorderDate', 'total', 'userID','description'
    ];
}
