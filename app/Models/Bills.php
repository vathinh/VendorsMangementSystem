<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;

    //
    protected $table = 'bills';
    protected $primaryKey = 'billID';
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

    protected $fillable = [
        'purchaseorderID', 'vendorID', 'billDate', 'dueDate', 'total', 'userID','description'
    ];
}
