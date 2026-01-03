<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price_cents',
        'stock',
        'is_active',
    ];
    public function category() { return $this->belongsTo(Category::class); }

}
