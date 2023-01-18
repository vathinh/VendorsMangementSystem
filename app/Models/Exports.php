<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exports extends Model
{
    use HasFactory;

    //
    protected $table = 'exports';
    protected $primaryKey = 'exportID';
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

    protected $fillable = [
        'invoiceID', 'customerID', 'exportDate', 'userID','description'
    ];
}
