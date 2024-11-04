<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // The attributes that are mass assignable
    protected $fillable = [
        'employee_id',
        'product_id',
        'item_name',
        'quantity',
        'unit_price',
        'total_price',
        'payment_method',
        'tax_amount',
        'net_amount',
        'status',
        'location_id',
        'reference_no',
    ];
    protected $primaryKey = 'transaction_id';
    protected $dates = ['created_at', 'updated_at'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
