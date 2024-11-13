<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesHistory extends Model
{
    protected $table = 'histories';
    protected $fillable = [
        'employee_name',
        'item_name',
        'quantity',
        'unit_price',
        'total_price',
        'net_amount',
        'tax',
        'payment_amount',
        'change_amount',
        'timestamp',
        'reference_id',
    ];
}
