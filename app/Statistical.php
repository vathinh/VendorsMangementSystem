<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistical extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'created_at', 'sales' , 'profit' , 'quantity' , 'total_order'
    ];
    protected $primaryKey = 'id_statistical';
    protected $table = 'tbl_statistical';
}
