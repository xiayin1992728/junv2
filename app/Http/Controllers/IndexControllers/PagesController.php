<?php

namespace App\Http\Controllers\IndexControllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

class PagesController extends Controller
{
    /**
     * 前台首页视图
     * @param null $arg
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home($arg = null)
    {
        return view('index.home',['arg' => $arg]);
    }

    /**
     * 贷款页视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loan()
    {
        return view('index.loan');
    }

    /**
     * 资料完善页视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verify()
    {
        return view('index.verify');
    }

    public function feature()
    {
        return view('index.feature');
    }

    public function continue()
    {
        return view('index.continue');
    }

    public function second()
    {
        $products = Product::where('types','外部产品')->get();
        $carousels = [];
        $carousel = file_get_contents(public_path().'/settings/carousel.json');
        $carousels = json_decode($carousel,true);
        $product = $products->slice(0,2);

        return view('index.second',[
            'products'=>$products,
             'carousels' => $carousels,
            'product' => $product
        ]);
    }

    public function audit()
    {
        return view('index.audit');
    }
}
