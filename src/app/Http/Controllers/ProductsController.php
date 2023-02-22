<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index() {
        $products = Product::all();
        $repeat_products=Order::where('user_id','=',Auth::id())->rightJoin('order_details', 'order_details.order_id', '=', 'orders.id')->Join('products', 'products.id', '=', 'order_details.product_id')->orderBy('orders.created_at', 'desc')->limit(6)->get();
        return view('product.index', compact('products','repeat_products'));
    }

 
}
