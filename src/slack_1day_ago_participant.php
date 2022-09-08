<?php
$headers = [
    'Authorization: Bearer xoxb-4051294469826-4048340950789-V7x2EbBthVNlZK5lhVGvBX3Q', //（1)
    'Content-Type: application/json;charset=utf-8'
];

$url = "https://slack.com/api/chat.postMessage"; //(2)

//(3)
$post_fields = [
    "channel" => "#2d-hack",
    "text" => "イベントの一日前です！参加者メンションします",
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

