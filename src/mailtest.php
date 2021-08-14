<?php

$to = "hackathon-teamX@posse-ap.com";
$subject = "PHPからメール送信サンプル";
$body = "本文";
$headers = "From: system@posse-ap.com";

mb_send_mail($to, $subject, $body, $headers);