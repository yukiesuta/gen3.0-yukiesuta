@extends('layouts.app')

@section('content')
<div class="product-index">
    <div class="py-5 bg-light">
        <div class="container">
            <form action="/product-management/addproduct" method="post" class="btn col-sm-5 btn-sm btn-outline-green">
                @csrf
                <input type="submit" value="新規作成">
            </form>
            <div class="row">

                @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top btn fly" src="{{ asset('img/' . $product->thumbnail) }}" alt="tomato" style="height: 225px; width: 100%; display: block;" data-toggle="modal" data-target="#productModal{{ $product->id }}" data-whatever="productTomato">
                        <div class="card-body">
                            <p class="card-text">{{ $product->name }}</p>
                            <div class="text-right">
                                <small class="text-muted">{{ $product->format_price }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="input-group col-sm-5">
                                    <input type="text" class="form-control quantity" aria-label="Dollar amount (with dot and two decimal places)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">個</span>
                                    </div>
                                </div>
                                <form action="/product-management/deleteproduct" method="post" class="btn col-sm-5 btn-sm btn-outline-danger">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="submit" value="削除">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Modal -->
    @foreach ($products as $product)

    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <!-- //モーダルウィンドウの縦表示位置を調整・画像を大きく見せる -->
        <div class="modal-dialog modal-lg modal-middle">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{ asset('img/' . $product->image1) }}" alt="tomato" style=" width: 100%;" class="aligncenter size-full wp-image-425" />
                </div>
                <form>
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-md-4">{{ $product->description }}</div>
                            <div class="col-md-4 ml-auto text-right">{{ $product->quantity }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control col-md-4 quantityfromdetail" aria-label="Dollar amount (with dot and two decimal places)">
                                <div class="input-group-append">
                                    <span class="input-group-text">個</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ash" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="ToCartFromDetail({{ $product->id }}, {{ $loop->index }});">カートに追加
                        </button>
                    </div>
            </div>
        </div>
    </div>
    @endforeach

    @endsection