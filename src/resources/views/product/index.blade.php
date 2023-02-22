@extends('layouts.app')

@section('content')
    @if ('user' == session()->get('role'))
        <div class="py-5 bg-light">
            <div class="container">
                <h2>あなたが最近購入した商品</h2>
                <div class="row">
                    @foreach ($repeat_products as $product)
                        <div class="col-md-4">
                            <div class="card mb-4 box-shadow">
                                <img class="card-img-top btn fly" src="{{ asset('img/' . $product->thumbnail) }}"
                                    alt="tomato" style="height: 225px; width: 100%; display: block;" data-toggle="modal"
                                    data-target="#productModal{{ $product->id }}" data-whatever="productTomato">
                                <div class="card-body">
                                    <p class="card-text">{{ $product->name }}</p>
                                    @if ($product->stock == 0)
                                        <div>売り切れ</div>
                                    @else
                                        <div>残り{{ $product->stock }}個</div>
                                    @endif
                                    <div class="text-right">
                                        @if ($product->stock == 0)
                                            <small class="text-muted">￥{{ $product->price }}</small>
                                        @elseif(date('H') >= 12 && $product->stock >= 50)
                                            <small>20%off</small>
                                            <small class="text-muted">￥{{ floor($product->price * 0.8) }}</small>
                                        @else
                                            <small class="text-muted">￥{{ $product->price }}</small>
                                        @endif
                                    </div>
                                    @if ($product->stock != 0)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group col-sm-7">
                                                <select class="form-control quantity pr-5"
                                                    aria-label="Dollar amount (with dot and two decimal places)"
                                                    value="0">
                                                    @for ($i = 1; $i < $product->stock + 1; $i++)
                                                        <option>{{ $i }}</option>
                                                    @endfor
                                                </select>

                                                <div class="input-group-append">
                                                    <span class="input-group-text">個</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn col-sm-5 btn-sm btn-outline-danger"
                                                onclick="ToCart({{ $product->id }}, {{ $loop->index }});">カートに追加
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div style="line-height: 50px" class="text-center py-3">
        <div>あと<span style="font-weight:bold; background-color:yellow; color:darkgreen; padding:10px 10px; border-radius: 50%;"  class="hour" id="hour"></span>時間<span style="font-weight:bold; background-color:yellow; color:darkgreen; padding:10px 10px; border-radius: 50%;"  class="minute" id="minute"></span>分<span
            style="font-weight:bold; background-color:yellow; color:darkgreen; padding:10px 10px; border-radius: 50%;" class="seconds" id="seconds"></span>秒以内に
        </div>
        <div>ご注文いただくと<span style="font-weight:bold; background-color:yellow; color:darkgreen; padding:10px 10px; border-radius: 10%;"  id="targetMessage"></span>に届きます！</div>
    </div>
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">『豊洲から最高品質の食材を調達』</h1>
            <p class="lead text-muted">
                役者の質が観客に与える感動の程度に影響するのと同じように<br>食材の質はお客様に与える喜びの程度に大きく影響します。<br>あなたの作る料理が、誰かの心を動かすためのお手伝いをさせてください。</p>
        </div>
    </section>

    <h2>商品一覧</h2>
    <div class="py-5 bg-light">
        <div class="container">
            <div class="row">

                @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top btn fly" src="{{ asset('img/' . $product->thumbnail) }}"
                                alt="tomato" style="height: 225px; width: 100%; display: block;" data-toggle="modal"
                                data-target="#productModal{{ $product->id }}" data-whatever="productTomato">
                            <div class="card-body">
                                <p class="card-text">{{ $product->name }}</p>
                                @if ($product->stock == 0)
                                    <div>売り切れ</div>
                                @else
                                    <div>残り{{ $product->stock }}個</div>
                                @endif
                                <div class="text-right">
                                    @if ($product->stock == 0)
                                        <small class="text-muted">￥{{ $product->price }}</small>
                                    @elseif(date('H') >= 12 && $product->stock >= 50)
                                        <small>20%off</small>
                                        <small class="text-muted">￥{{ floor($product->price * 0.8) }}</small>
                                    @else
                                        <small class="text-muted">￥{{ $product->price }}</small>
                                    @endif
                                </div>
                                @if ($product->stock != 0)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="input-group col-sm-7">
                                            <select class="form-control quantity pr-5"
                                                aria-label="Dollar amount (with dot and two decimal places)" value="0">
                                                @for ($i = 1; $i < $product->stock + 1; $i++)
                                                    <option>{{ $i }}</option>
                                                @endfor
                                            </select>

                                            <div class="input-group-append">
                                                <span class="input-group-text">個</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn col-sm-5 btn-sm btn-outline-danger"
                                            onclick="ToCart({{ $product->id }}, {{ $loop->index }});">カートに追加
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Modal -->
    @foreach ($products as $product)
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel">
            <!-- //モーダルウィンドウの縦表示位置を調整・画像を大きく見せる -->
            <div class="modal-dialog modal-lg modal-middle">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="{{ asset('img/' . $product->image1) }}" alt="tomato" style=" width: 100%;"
                            class="aligncenter size-full wp-image-425" />
                    </div>
                    <form>
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-md-4">{{ $product->description }}</div>
                                <div class="col-md-4 ml-auto text-right">{{ $product->quantity }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ash" data-dismiss="modal">Close</button>
                        </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script language="javascript" type="text/javascript">
        function ToCart(productid, count) {
            $(".quantity").each(function(i, elem) {
                if (count == i) {
                    window.location.href = '/cart/' + productid + '/' + $(elem).val();
                }
            });
        }

        function ToCartFromDetail(productid, count) {
            $(".quantityfromdetail").each(function(i, elem) {
                if (count == i) {
                    window.location.href = '/cart/' + productid + '/' + $(elem).val();
                }
            });
        }
    </script>
    <script>
        /*
                                                いつまでに注文するといつまでに届くのかを表示する
                                                    12:00:00:000 ~ 22:59:59:999 の注文の場合は、明日の午前中
                                                    23:00:00:000 ~ 23:59:59:999 の注文の場合は、明日の午後
                                                    00:00:00:000 ~ 11:59:59:999 の注文の場合は、今日の午後
                                                */
        function showCountdown() {
            const now = new Date();
            const nowHour = now.getHours();
            var targetDate, targetMessage;

            if (12 <= nowHour && nowHour < 23) {
                targetDate = (new Date()).setHours(22, 59, 59, 999);
                targetMessage = "明日の午前中";
            } else if (23 <= nowHour && nowHour < 24) {
                targetDate = (new Date()).setHours(23, 59, 59, 999);
                targetMessage = "明日の午後";
            } else {
                targetDate = (new Date()).setHours(11, 59, 59, 999);
                targetMessage = "今日の午後";
            }

            remainTime = targetDate - now.getTime();

            const remainHour = Math.floor(remainTime / (1000 * 60 * 60));
            const remainMinute = Math.floor((remainTime / (1000 * 60)) - (remainHour * 60));
            const remainSeconds = Math.floor(remainTime / 1000) - (remainHour * 60 * 60) - (remainMinute * 60);
            document.getElementById("hour").innerHTML = remainHour < 10 ? '0' + remainHour : remainHour;
            document.getElementById("minute").innerHTML = remainMinute < 10 ? '0' + remainMinute : remainMinute;
            document.getElementById("seconds").innerHTML = remainSeconds < 10 ? '0' + remainSeconds : remainSeconds;
            document.getElementById("targetMessage").innerHTML = targetMessage;
        };

        // 1秒ごとに実行
        setInterval('showCountdown()', 1000);
    </script>
@endpush
