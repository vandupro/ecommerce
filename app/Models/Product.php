<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name', 'price', 'competitive_price', 'desc', 'short_desc', 'slug', 'branch_id', 'discount'];
    
    public function product_cate_pros(){
        return $this->hasMany(Cate_Product::class, 'product_id');
    }

    public function product_tags(){
        return $this->hasMany(Tag_Product::class, 'product_id');
    }
}
