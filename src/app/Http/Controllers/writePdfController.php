<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class writePdfController extends Controller
{
    public function index()
    {
        $all_customers = User::where('role_id', Role::getUserId())->get();
        $product_names = Product::pluck('name', 'id');
        $product_quantities_per_unit = Product::pluck('quantity', 'id');
        $product_price_per_unit = Product::pluck('price', 'id');
        $month_of_request = Carbon::today()->addMonthNoOverflow(1)->format('m');
        foreach ($all_customers as $customer) {
            //今月購入したものが届いたか確認
            $all_orders = Order::where('user_id', $customer->id)->whereMonth('delivery_date', $month_of_request - 1)->with('order_details')->get();
            $string_for_pdf = '';
            foreach ($all_orders as $order) {
                foreach ($order->order_details as $order_detail) {
                    dd($order_detail);
                    $tmp_string = '<tr><th style="background-color:black;width:30%;">'.$product_names[$order_detail->product_id].'</th><th style="width:10%;">'.$order_detail->quantity.'</th><th style="width:20%;">'.$product_quantities_per_unit[$order_detail->product_id].'</th><th style="width:20%;">'.$product_price_per_unit[$order_detail->product_id].'</th><th style="width:20%;">'.$product_price_per_unit[$order_detail->product_id].'</th></tr>';
                    $string_for_pdf = $string_for_pdf . $tmp_string;
                }
            }
            $view_string = view('emails.monthly_invoice')->with(compact('all_orders', 'product_names', 'product_quantities_per_unit', 'product_price_per_unit', 'month_of_request'))->render();
            dd($view_string);
        }
    }
}
