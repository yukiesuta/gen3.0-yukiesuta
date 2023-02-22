@extends('layouts.app')

@section('content')
<div>新規商品登録</div>
<form action="" method="post" enctype="multipart/form-data">
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <th>
                    <input type="text" name="name">
                </th>
                <th>
                    <div>名前</div>
                </th>
            </tr>
            <tr>
                <th>
                    <input type="text" name="description">
                </th>
                <th>
                    <div>商品説明</div>
                </th>
            </tr>
            <tr>
                <th>
                    <input type="file" name="img" accept="image/*" name="thumbnail">
                </th>
                <th>
                    <div>サムネイル画像</div>
                </th>
            </tr>
            <tr>
                <th>
                    <input type="file" name="img" accept="image/*"  name="image1">
                </th>
                <th>
                    <div>詳細画像</div>
                </th>
            </tr>
            <tr>
                <th>
                    <input type="text" name="quantity">
                </th>
                <th>
                    <div>1箱あたりの数量</div>
                </th>
            </tr>
            <tr>
                <th>
                    <input type="text" name="price">
                </th>
                <th>
                    <div>価格</div>
                </th>
            </tr>
        </table>
    </form>
</form>
@endsection