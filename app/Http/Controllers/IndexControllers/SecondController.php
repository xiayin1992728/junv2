<?php

namespace App\Http\Controllers\IndexControllers;

use App\Models\Product;
use App\Http\Controllers\Controller;

class SecondController extends Controller
{
    public function second(Product $product)
    {
        $products = $product->where('types','外部产品')->where('status',1)->get();

        return ['data' => $products];
    }
}
