@extends('layouts.app')

@section('content')
    <div class="delivery-index">
        <h2>配送一覧</h2>
        <select id="sampleSelect" onChange="goFilter();">
            <option value="all">全て</option>
            <option value="today_am">本日({{ $today }}) AM</option>
            <option value="today_pm">本日({{ $today }}) PM</option>
            <option value="tomorrow_am">明日({{ $tomorrow }}) AM</option>
            <option value="tomorrow_pm">明日({{ $tomorrow }}) PM</option>
        </select>
        <ul id="sampleTable">
            @foreach($orders as $order)
            @if(explode(' ',$order->delivery_date)[0]===str_replace('/','-',$today)&&$order->is_am===1)
            <!-- 今日かつ午前 -->
            <li today_am data-filter-key="today_am">
            @elseif(explode(' ',$order->delivery_date)[0]===str_replace('/','-',$today)&&$order->is_am===0)
            <!-- 今日かつ午後 -->
            <li today_pm data-filter-key="today_pm">
            @elseif(explode(' ',$order->delivery_date)[0]===str_replace('/','-',$tomorrow)&&$order->is_am===1)
            <!-- 明日かつ午前 -->
            <li tomorrow_am data-filter-key="tomorrow_am">
            @elseif(explode(' ',$order->delivery_date)[0]===str_replace('/','-',$tomorrow)&&$order->is_am===0)
            <!-- 明日かつ午後 -->
            <li tomorrow_pm data-filter-key="tomorrow_pm">
            @else
            <li>
            @endif
                    {{ $order->getFullFormatDeliveryDateAttribute() }} 配達予定
                    <div class="block">
                        <div class="row position">
                            <div class="col-5 order-head">■ 注文番号 {{ $order->id }}</div>
                            <div class="col-7 order-head">
                                トラック{{ $order->truck_id }}
                            </div>
                        </div>
                        ■ 配送先住所
                        <div class="row">
                            <div class="col-12">〒{{ $order->delivery_address->postal_code }}</div>
                        </div>
                        <div class="row">
                            <div class="col-12">{{ $order->delivery_address->getFullAddressAttribute() }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">{{ $order->user->company_name }}</div>
                        </div>
                        ■ 注文内容

                        @foreach($order->order_details as $order_detail)

                            <div class="row">
                                <div class="col-5">{{ $order_detail->product->name }}</div>
                                <div class="col-4 text-right">{{ $order_detail->quantity }}個</div>
                                <div class="col-3 text-right">¥{{ $order_detail->product->price }}</div>
                            </div>

                        @endforeach

                        <dt class="border-top pt-1">合計金額</dt>
                        <div class="row">
                            <div class="col-12 text-right">¥{{ $order->total_price }}</div>
                        </div>

                        <div class="text-right">
                            <button type="button" class="btn btn-ash"
                                    onclick="location.href='/delivery-list/{{ $order->id }}'">
                                詳細を見る
                            </button>
                        </div>
                    </div>
                </li>

            @endforeach

        </ul>
    </div>
@endsection

@push('scripts')
    <script>
        function goFilter() {
            var wTable = document.getElementById("sampleTable");
            var wSelect = document.getElementById("sampleSelect");
            var value = wSelect.options[wSelect.selectedIndex].value;
            if (value == 'all') {
                // --- 全ての場合はクラスをクリア ---
                wTable.className = '';
                console.log(1);
            } else {
                // --- タイトル以外のTRを非表示＋指定属性を持つTRのみ表示 ---
                wTable.className = 'allNoDisplay ' + value;
                console.log(2);
            }
        }
    </script>
@endpush