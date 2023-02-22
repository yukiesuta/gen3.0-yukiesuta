@extends('layouts.app')

@section('content')
    <h2>新規商品登録</h2>
    <form action="/product-management/createproduct" method="post" enctype="multipart/form-data">
        @csrf
        <table class="table table-striped">
            <tr>
                <th class="m">
                    <div>名前</div>
                </th>
                <th>
                    <input type="text" name="name">
                </th>
            </tr>
            <tr>
                <th>
                    <div>商品説明</div>
                </th>
                <th>
                    <input type="text" name="description">
                </th>
            </tr>
            <tr>
                <th>
                    <div>サムネイル画像</div>
                </th>
                <th>
                    <input type="file" accept="image/*" name="thumbnail">
                </th>
            </tr>
            <tr>
                <th>
                    <div>詳細画像</div>
                </th>
                <th>
                    <input type="file" accept="image/*" name="detail">
                </th>
            </tr>
            <tr>
                <th>
                    <div>1箱あたりの数量</div>
                </th>
                <th>
                    <input type="text" name="quantity">
                </th>
            </tr>
            <tr>
                <th>
                    <div>価格</div>
                </th>
                <th>
                    <input type="text" name="price">
                </th>
            </tr>
        </table>
        <input type="submit" value="登録" class="btn btn-primary">
    </form>
@endsection
