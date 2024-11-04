<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // app/Models/Product.php
    protected $fillable = ['barcode', 'item_name', 'category', 'stocks', 'price'];

    protected $dates = ['created_at', 'updated_at'];
}
