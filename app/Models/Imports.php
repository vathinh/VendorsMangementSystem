<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imports extends Model
{
    use HasFactory;

    //
    protected $table = 'imports';
    protected $primaryKey = 'importID';
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

    protected $fillable = [
        'billID', 'vendorID', 'importDate', 'userID','description'
    ];
}
