@extends('layouts.app')

@section('content')
    <div class="order-index">
        <h2>注文履歴一覧</h2>

        @foreach ($orders as $order)
            <a href="{{  route('order.detail', [ 'id' => $order->id ]) }}" class="link-area">
                <div class="block">
                    <div class="row my-3 flex">
                        <div class="col-3">■ 注文番号 {{ $order->id }}</div>
                        <div class="col-3">■ 注文日 {{ $order->created_at }}</div>
                        <div class="col-3">■ 配送希望日 {{ $order->delivery_date->format('Y-m-d') }}{{ $order->is_am ? 'AM' : 'PM' }} </div>
                        <div class="col-3">■ 配送状況 {{ $order->delivery_status->name }} </div>
                    </div>
                <table class="table">
                        <thead>
                            <tr>
                              <th scope="col" class="text-left">商品名</th>
                              <th scope="col" class="text-right">数量</th>
                              <th scope="col" class="text-right">合計金額</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->order_details as $index => $order_detail)
                                <tr>
                                    <td class="text-left">{{ $order_detail->product->name }}</td>
                                    <td class="text-right">{{ $order_detail->quantity }}個</td>
                                    <td class="text-right">¥{{ number_format($order_detail->product->price * $order_detail->quantity) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <th scope="col" class="text-left">総額</th>
                        <td class="text-right"></td>
                        <td class="text-right">¥{{ $order -> total_price }}</td>
                    </table>
                </div>
            </a>
        @endforeach
    </div>
@endsection