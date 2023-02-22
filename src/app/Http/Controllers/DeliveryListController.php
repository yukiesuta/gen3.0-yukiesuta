<?php

namespace App\Http\Controllers;

use App\Models\DeliveryStatus;
use App\Models\Order;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryListController extends Controller
{
    public function index()
    {
        $is_admin = Auth::user()->role_id === Role::getAdminId();
        $is_agent = Auth::user()->role_id === Role::getDeliveryAgentId();
        $today = Carbon::today()->format('Y/m/d');
        $tomorrow = Carbon::today()->addDay(1)->format('Y/m/d');
        $orders = Order::with('delivery_address', 'order_details', 'order_details.product', 'user','delivery_method')            ->where('delivery_date', '>=', Carbon::today()->format('Y-m-d'))
            ->where('delivery_date', '<', Carbon::today()->addDay(7)->format('Y-m-d'))
            ->get();
        $delivery_statuses = DeliveryStatus::select('id', 'name')->get();
        return view('delivery.index', compact('is_agent', 'is_admin', 'orders', 'today', 'tomorrow', 'delivery_statuses'));
    }

    public function detail($order_id)
    {
        $order = Order::with('delivery_address', 'order_details', 'order_details.product', 'user')->find($order_id);
        return view('delivery.detail', compact('order'));
    }

    public function change_status($order_id, Request $request)
    {
        $new_delivery_status = $request->delivery_status;
        $new_truck_id = $request->truck_id;
        $order = Order::find($order_id);
        $order->delivery_status_id = $new_delivery_status;
        $order->truck_id = $new_truck_id;
        $order->save();
        return redirect('/delivery-list');
    }
}
