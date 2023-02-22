@extends('layouts.app')

@section('content')
    <div class="delivery-index">
        <h2>運送管理</h2>
        <select id="sampleSelect" onChange="goFilter();">
            <option value="all">全て</option>
            <option value="today_am">本日({{ $today }}) AM</option>
            <option value="today_pm">本日({{ $today }}) PM</option>
            <option value="tomorrow_am">明日({{ $tomorrow }}) AM</option>
            <option value="tomorrow_pm">明日({{ $tomorrow }}) PM</option>
        </select>
        <ul id="sampleTable">
            @foreach ($orders as $order)
                @if (explode(' ', $order->delivery_date)[0] === str_replace('/', '-', $today) && $order->is_am === 1)
                    <!-- 今日かつ午前 -->
                    <li today_am data-filter-key="today_am">
                    @elseif(explode(' ', $order->delivery_date)[0] === str_replace('/', '-', $today) && $order->is_am === 0)
                        <!-- 今日かつ午後 -->
                    <li today_pm data-filter-key="today_pm">
                    @elseif(explode(' ', $order->delivery_date)[0] === str_replace('/', '-', $tomorrow) && $order->is_am === 1)
                        <!-- 明日かつ午前 -->
                    <li tomorrow_am data-filter-key="tomorrow_am">
                    @elseif(explode(' ', $order->delivery_date)[0] === str_replace('/', '-', $tomorrow) && $order->is_am === 0)
                        <!-- 明日かつ午後 -->
                    <li tomorrow_pm data-filter-key="tomorrow_pm">
                    @else
                    <li>
                @endif
                <div class="row position">
                    <div class="col-5 order-head"><strong>注文番号 {{ $order->id }}</strong></div>
                    <div class="col-7 order-head">
                    </div>
                </div>
                {{ $order->getFullFormatDeliveryDateAttribute() }} 配達予定
                <div class="block">
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
                    <form style="margin-top:10px;align-items:center;gap:70px;margin-bottom:0;"
                        action="/delivery-list/{{ $order->id }}" method="POST">
                        @csrf
                        ■配送車・配送ステータス<br>
                        @if ('admin' == session()->get('role'))
                        <select name="truck_id">
                        @elseif ('delivery-agent' == session()->get('role'))
                        <select name="truck_id" disabled>
                        @endif
                            <option value="5" @if ($order->truck_id === 5) selected @endif>
                                未選択
                            </option>
                            <option value="1" @if ($order->truck_id === 1) selected @endif>トラック1
                            </option>
                            <option value="2" @if ($order->truck_id === 2) selected @endif>トラック2
                            </option>
                            <option value="3" @if ($order->truck_id === 3) selected @endif>トラック3
                            </option>
                            <option value="4" @if ($order->truck_id === 4) selected @endif>トラック4
                            </option>
                        </select>
                        <select name="delivery_status">
                            @foreach ($delivery_statuses as $status)
                                @if ($status->id === $order->delivery_status_id)
                                    <option selected value="{{ $status->id }}">{{ $status->name }}</option>
                                @else
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        {{-- <select name="truck_id">
                            <option value="0" @if ($order->truck_id === 0) selected @endif>
                                未選択
                            </option>
                            <option value="1" @if ($order->truck_id === 1) selected @endif>トラック1
                            </option>
                            <option value="2" @if ($order->truck_id === 2) selected @endif>トラック2
                            </option>
                            <option value="3" @if ($order->truck_id === 3) selected @endif>トラック3
                            </option>
                            <option value="4" @if ($order->truck_id === 4) selected @endif>トラック4
                            </option>
                        </select> --}}
                        <input style="border-radius:10%;background-color:#78A663;color:white;" type="submit"
                            value="更新">
                    </form>
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
                    ■ 配送方法
                    <div class="row mb-2">
                        <div class="col-12">{{ $order->delivery_method->name }}</div>
                    </div>
                    ■ 注文内容

                    @foreach ($order->order_details as $order_detail)
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

                    @if ('admin' == session()->get('role'))
                    <div class="text-right">
                        <button type="button" class="btn btn-ash"
                            onclick="location.href='/delivery-list/{{ $order->id }}'">
                            詳細を見る
                        </button>
                    </div>
                    @endif
                    </li>
            @endforeach
        </ul>
        <!-- Modal -->
        @if ($is_admin)
            <div class="modal fade" id="trackModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <!-- //モーダルウィンドウの縦表示位置を調整・画像を大きく見せる -->
                <div class="modal-dialog modal-lg modal-middle">
                    <div class="modal-content">
                        <form>
                            <div class="modal-body">
                                <label for="trackSelect">配送トラック選択</label>
                                @if ('admin' == session()->get('role'))
                                <select class="form-control" id="trackSelect">
                                @elseif ('delivery-agent' == session()->get('role'))
                                <select class="form-control" id="trackSelect" disabled>
                                @endif
                                    <option>トラック１</option>
                                    <option>トラック２</option>
                                    <option>トラック３</option>
                                    <option>トラック４</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-ash" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-danger" data-dismiss="modal" id="testttt">
                                    決定
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
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
@push('scripts')
    @if ($is_admin)
        <script>
            $('#testttt').on('click', function() {
                alert("testtttt");
                var cusno = $('#cusno').val();
                var oldday = $('#oldday').val();
                var newday = $('#newday').val();
                $.ajax({
                    url: "/", // 送信先 URL
                    type: "POST", // GET,POSTとか
                    dataType: "text",
                    data: { // 送信するデータ
                        xxx: 'dateup',
                        oldday: oldday,
                        newday: newday,
                        cusno: cusno
                    }
                }).done(function(data) {
                    // 通信成功時の処理
                    // PHP から返ってきた値（メッセージ）を p タグにセット
                    $('#mess').text(data);
                }).fail(function(data) {
                    // 通信失敗時の処理
                    console.dir(data);
                }).always(function(data) {
                    // 常に実行する処理
                    $("#modalForm").modal('hide'); // モーダルを閉じる
                });
            });
        </script>
    @endif
@endpush
