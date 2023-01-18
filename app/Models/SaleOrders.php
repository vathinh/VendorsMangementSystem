<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrders extends Model
{
    use HasFactory;

    //
    protected $table = 'saleorders';
    protected $primaryKey = 'orderID';
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

    protected $fillable = [
        'customerID', 'saleorderDate', 'total', 'userID','description'
    ];
}
