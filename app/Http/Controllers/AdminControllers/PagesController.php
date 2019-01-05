<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function home()
    {
        $menus = config('admin.menu');
        return view('admin.pages.home',['menus' => $menus]);
    }

    public function welcome()
    {
        return view('admin.pages.welcome');
    }
}
