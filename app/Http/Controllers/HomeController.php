<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;

class HomeController extends Controller
{
    function index() {
        $products = Product::take(12)->get();

        return view('dashboard', [
            'products' => $products
        ]);
    }

    function shopview(){
        $products=Product::all();
        return view('shop',[
            'products'=>$products
        ]);
    }

}
