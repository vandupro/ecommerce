<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsToMany(Product::class, 'tags_products','product_id', 'tag_id');
    }

    public function tag_products(){
        return $this->hasMany(Tag_Product::class, 'tag_id');
    }
}
