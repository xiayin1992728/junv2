<?php

namespace App\Http\Controllers\IndexControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function home()
    {
        return view('index.home');
    }
}
