<?php
require('dbconnect.php');

$stmt = $db->query('SELECT * FROM events');
$events = $stmt->fetchAll();

$stmt = $db->query('SELECT * FROM users');
$users = $stmt->fetchAll();

foreach ($events as $event) {

    $now_time = new DateTime(); //現在日時

    $designated_time = new DateTime($event['start_at']); //指定日時
    $designated_date = $designated_time->format('Y-m-d'); //指定日

    $notification_date = $designated_time->modify('-3 day'); //通知日時は三日前

    $today = $now_time->format('Y-m-d'); //現在日
    $notification_date = $designated_time->format('Y-m-d'); //通知日

    // 通知日と今日が同じが同じならメール
    if ($notification_date == $today) {
        foreach ($users as $user) {
            $to = $user['email'];
            $subject = "三日前通知！";
            $body = '【リマインド】' . $event['name'] . 'の三日前です。全員に通知しています。';
            $headers = "From: system@posse-ap.com";
            if (mb_send_mail($to, $subject, $body, $headers)) {
                mb_send_mail($to, $subject, $body, $headers);
                print_r('<pre>');
                echo $event['name'];
                echo 'は';
                echo $designated_date;
                echo 'に開催予定で、三日前であり、「';
                echo $body;
                echo '」は';
                echo $to;
                echo 'に送信されました。';
                print_r('</pre>');
            } else {
                echo "メール送信失敗です";
            }
        }
    }
}
