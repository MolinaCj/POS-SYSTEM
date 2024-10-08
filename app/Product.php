<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['barcode', 'item_name', 'quantity', 'price'];
    protected $dates = ['created_at', 'updated_at'];
}
