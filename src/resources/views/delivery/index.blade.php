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
                        @if($is_admin)
                        <i class="material-icons track" data-toggle="modal" data-target="#trackModal" data-whatever="track1">local_shipping</i>
                        @endif
                    </div>
                </div>
                </li>
            @endforeach

        </ul>
        <!-- Modal -->
        <div class="modal fade" id="trackModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <!-- //モーダルウィンドウの縦表示位置を調整・画像を大きく見せる -->
            <div class="modal-dialog modal-lg modal-middle">
                <div class="modal-content">
                    <form>
                        <div class="modal-body">
                            <label for="trackSelect">配送トラック選択</label>
                            <select class="form-control" id="trackSelect">
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
        </li>

        @endforeach

    </ul>
    @if($is_admin)
    <!-- Modal -->
    <div class="modal fade" id="trackModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <!-- //モーダルウィンドウの縦表示位置を調整・画像を大きく見せる -->
        <div class="modal-dialog modal-lg modal-middle">
            <div class="modal-content">
                <form>
                    <div class="modal-body">
                        <label for="trackSelect">配送トラック選択</label>
                        <select class="form-control" id="trackSelect">
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
</script>
@endpush
@if($is_admin)
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
