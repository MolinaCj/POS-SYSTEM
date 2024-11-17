<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // app/Models/Product.php
    protected $fillable = ['barcode', 'item_name', 'category', 'stocks', 'price'];

    protected $dates = ['created_at', 'updated_at'];

    //RELATION BETWEEN TRANSACTION PRODUCT_ID AND PRODUCTS ID
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'product_id', 'id');
    }
}
