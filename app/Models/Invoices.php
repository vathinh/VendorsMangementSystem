<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    //
    protected $table = 'invoices';
    protected $primaryKey = 'invoiceID';
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

    protected $fillable = [
        'orderID','customerID', 'invoiceDate', 'dueDate', 'total', 'userID','description'
    ];
}
