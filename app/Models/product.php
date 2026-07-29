<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'category_id', 'image', 'quantity'];

    // Define relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
