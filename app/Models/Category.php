<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //  Define the table associated with the model
    protected $fillable = ['name', 'description', 'image'];
}
