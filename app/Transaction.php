<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // The attributes that are mass assignable
    protected $fillable = [
        'employee_id',
        'employee_name',
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

    //RELATION BETWEEN TRANSACTION PRODUCT_ID AND PRODUCTS ID
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
