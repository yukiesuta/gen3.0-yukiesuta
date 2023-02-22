@extends('layouts.app')

@section('content')
<div class="product-index">
    <h2>商品管理</h2>
    <div class="py-5 bg-light">
        <div class="container">
            <form action="/product-management/addproduct" method="post" class="btn btn-sm">
                @csrf
                <input type="submit" value="新規作成" class="btn btn-sm btn-outline-primary text-left">
            </form>
            <div class="row">

                @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top btn fly" src="{{ asset('img/' . $product->thumbnail) }}" style="height: 225px; width: 100%; display: block;">
                        <div class="card-body">
                            <p class="card-text">{{ $product->name }}</p>
                            <div class="text-right">
                                <small class="text-muted">{{ $product->format_price }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <input type="submit" data-toggle="modal" data-target="#productModal{{ $product->id }}" value="編集" class="btn btn-sm btn-outline-success"> 
                                
                                
                                <form action="/product-management/deleteproduct" method="post" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="submit" value="削除" onclick="return confirm('削除しますか?')" class="btn btn-sm btn-outline-danger">
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
                <form action="/product-management/updateproduct/{{ $product->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <img src="{{ asset('img/' . $product->thumbnail) }}" alt="tomato" style=" width: 100%;" class="aligncenter size-full wp-image-425" />
                    <input type="file" accept="image/*" name="thumbnail">
                    <div>サムネイル画像 ※写真の大きさが大きすぎると、アップロードできないことがあります</div>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('img/' . $product->image1) }}" alt="tomato" style=" width: 100%;" class="aligncenter size-full wp-image-425" />
                    <input type="file" accept="image/*" name="detail">
                    <div>詳細画像 ※写真の大きさが大きすぎると、アップロードできないことがあります</div>
                </div>
                    <div class="container-fluid">
                        <div class="row mb-2 ml-1">
                            <input value={{$product->name }} name="name">
                            <div>商品名</div>
                        </div>
                        <div class="row mb-2 ml-1">
                            <input value={{$product->description }} name="description">
                            <div>商品説明</div>
                        </div>
                        <div class="row mb-2 ml-1">
                            <input  value={{$product->quantity }} name="quantity">
                            <div>1箱あたりの個数 ※一箱あたり〇〇個、のフォーマッドで記入</div>
                        </div>
                        <div class="row mb-2 ml-1">
                            <input  value={{$product->price }} name="price">
                            <div>値段</div>
                        </div>
                        <div class="row mb-2 ml-1">
                            <input  value={{$product->stock }} name="stock">
                            <div>在庫</div>
                        </div>
                        {{-- <div class="row mb-2 ml-1">
                            <div class="input-group">
                                <input type="text" class="form-control col-md-4 quantityfromdetail" aria-label="Dollar amount (with dot and two decimal places)">
                                <div class="input-group-append">
                                    <span class="input-group-text">個</span>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ash" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-danger" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @endsection