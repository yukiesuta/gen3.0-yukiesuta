@foreach($all_orders as $order)
<!-- {{dd($order->order_details[0])}} -->
@foreach($order->order_details as $index=>$order_detail)
{{dd($order->order_details[$index])}}
<tr>
  <th style="background-color:black;width:30%;">
    {{ $product_names[$order->product_id]}}
  </th>
  <th style="width:10%;">
    {{ $order->quantity }}
  </th>
  <th style="width:20%;">
    {{$product_quantities_per_unit[$order->product_id]}}
  </th>
  <th style="width:20%;">
    {{$product_price_per_unit[$order->product_id]}}
  </th>
  <th style="width:20%;">
    {{$product_price_per_unit[$order->product_id]}}
  </th>
</tr>
@endforeach
@endforeach