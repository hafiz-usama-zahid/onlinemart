<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderProduct;
use App\Models\Delivery;

class Order extends Model
{
    protected $fillable = ['user_id', 'amount', 'status', 'orderno'];


    // Order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Order has many products
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    // Order has one delivery
    // This method defines the relationship between Order and Delivery models
    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
    
}
