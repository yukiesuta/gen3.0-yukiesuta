<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index() {
        $products = Product::all();

        return view('product.index', compact('products'));
    }
}
