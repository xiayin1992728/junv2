<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductPage extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class,'pid','id');
    }

    public function spread()
    {
        return $this->belongsToMany(ProductPage::class,'page_spreads','page_id','spread_id');
    }
}
