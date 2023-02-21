<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('admin.index',compact('products'));

    }

    public function deleteproduct(Request $request, Product $product) {

        $product_id = $request -> product_id;
        $message = $product->deleteproduct($product_id);
        $products = Product::all();
        return view('admin.index',compact('message','products'));

    }
 }
