<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;


// This model represents the OrderProduct entity in the application

class OrderProduct extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity','price'];

    // Define relationship with Order
    public function order()
    {
    return $this->belongsTo(\App\Models\Order::class);
    }

    // Define relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
