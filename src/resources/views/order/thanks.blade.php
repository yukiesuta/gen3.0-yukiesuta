@extends('layouts.app')

@section('content')

    <?php

    $body = '注文が入りました。詳細は以下のリンクからご確認ください。http://localhost/login';
        $token_first='xoxb-4051294469826-';
        $token_second='4049361417781-';
        $token_third='m9hPqyTdeIjxUMnxMOL4brcy';
        $headers = [
            // トークンは保護する
            'Authorization: Bearer '.$token_first.$token_second.$token_third, //（1)
            'Content-Type: application/json;charset=utf-8'
        ];

        $url = "https://slack.com/api/chat.postMessage"; //(2)

        //(3)
        $post_fields = [
            "channel" => "#2d-hack",
            "text" => $body,
            "as_user" => true
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($post_fields)
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
    ?>
    <div class="order-thanks">
        <div class="max-width-800-center">
            <div class="block">
                <h2 class="head">ご注文ありがとうございました！</h2>

                <div class="mb-3">
                    ご注文をお受けいたしました。商品到着まで今しばらくお待ち下さい。
                </div>

                <button type="button" class="btn btn-ash" onclick="location.href='/'">
                    製品一覧に戻る
                </button>
            </div>
        </div>
    </div>
@endsection