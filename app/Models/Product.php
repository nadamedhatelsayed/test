<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function data(){
        return $this->hasOne(ProductDetails::class,'product_id');
    }
    public function images(){
        return $this->hasMany(ProductImage::class,'product_id');
    }
}
