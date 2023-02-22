<?php

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Seeder;

class FixOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders=Order::get();
        foreach($orders as $order){
            $order_id=$order->id;
            $order_details=OrderDetail::where('order_id',$order_id)->with('product')->get();
            $sum=0;
            foreach($order_details as $detail){
                $sum=$sum+$detail->quantity*$detail->product->price;
            }
            $order->total_price=$sum;
            $order->update();
        }
    }
}
