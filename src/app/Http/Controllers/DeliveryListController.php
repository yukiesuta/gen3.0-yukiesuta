<?php

namespace App\Http\Controllers;

use App\Models\DeliveryStatus;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveryListController extends Controller
{
    public function index()
    {
        $today=Carbon::today()->format('Y/m/d');
        $tomorrow=Carbon::today()->addDay(1)->format('Y/m/d');
        $orders = Order::with('delivery_address', 'order_details', 'order_details.product', 'user')
            ->where('delivery_date', '>=', Carbon::today()->format('Y-m-d'))
            ->where('delivery_date', '<', Carbon::today()->addDay(7)->format('Y-m-d'))
            ->get();
        $delivery_statuses=DeliveryStatus::select('id','name')->get();
        return view('delivery.index', compact('orders','today','tomorrow','delivery_statuses'));
    }

    public function detail($order_id)
    {
        $order = Order::with('delivery_address', 'order_details', 'order_details.product', 'user')->find($order_id);
        return view('delivery.detail', compact('order'));
    }
    
    public function change_status($order_id,Request $request){
        $new_delivery_status=$request->delivery_status;
        $order=Order::find($order_id);
        $order->delivery_status_id=$new_delivery_status;
        $order->save();
        return redirect('/delivery-list');
    }
}
