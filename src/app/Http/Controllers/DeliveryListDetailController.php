<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryListDetailController extends Controller
{
    public function detail($order_id){
        $order=Order::find($order_id);
        return view('delivery.detail',compact('order'));
    }
}
