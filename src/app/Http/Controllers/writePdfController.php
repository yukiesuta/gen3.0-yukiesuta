<?php

namespace App\Http\Controllers;

use App\Mail\invoice_mail;
use App\Models\DeliveryStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class writePdfController extends Controller
{
    public function index()
    {
        $all_customers = User::where('role_id', Role::getUserId())->get();
        $product_names = Product::pluck('name', 'id');
        $product_quantities_per_unit = Product::pluck('quantity', 'id');
        $product_price_per_unit = Product::pluck('price', 'id');
        foreach ($all_customers as $customer) {
            //請求日の先月に購入したものが届いたか確認
            $all_orders = Order::where('user_id', $customer->id)
            ->where('delivery_status_id',DeliveryStatus::getDeliveredId())
            ->whereYear('delivery_date',Carbon::today()->subMonthNoOverflow()->format('Y'))
            ->whereMonth('delivery_date', Carbon::today()->subMonthNoOverflow()->format('m'))
            ->with('order_details')->get();
            $string_for_pdf = '';
            foreach ($all_orders as $order) {
                foreach ($order->order_details as $order_detail) {
                    // dd($order_detail);
                    $tmp_string = "<tr>
                    <td>"
                    // <td style='width:30%;'>"
                    .$product_names[$order_detail->product_id].
                    "</td>
                    <td>"
                    // <td style='width:10%;'>"
                    .$order_detail->quantity.
                    "</td>
                    <td>"
                    // <td style='width:20%;'>"
                    .$product_quantities_per_unit[$order_detail->product_id].
                    "</td>
                    <td>"
                    // <td style='width:20%;'>"
                    .$product_price_per_unit[$order_detail->product_id].
                    "</td>
                    <td>"
                    // <td style='width:20%;'>"
                    .$product_price_per_unit[$order_detail->product_id]*$order_detail->quantity.
                    "</td>
                    </tr>
                    ";
                    $string_for_pdf = $string_for_pdf . $tmp_string;
                }
            }
            Mail::to($customer->email)->send(new invoice_mail($customer,$string_for_pdf));
        }
    }
}
