<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// This model represents the Delivery entity in the application
// It is used to manage delivery information related to orders
class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'name', 'phone', 'province', 'city', 'building', 'area', 'address'
    ];
    
    // This method defines the relationship between Delivery and Order models
    
    public function order()
    {   // The Delivery model belongs to an Order
        return $this->belongsTo(Order::class);
    }
}
