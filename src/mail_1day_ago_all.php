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

    $notification_date = $designated_time->modify('-1 day'); //通知日時は一日前

    $today = $now_time->format('Y-m-d'); //現在日
    $notification_date = $designated_time->format('Y-m-d'); //通知日

    // 通知日と今日が同じが同じならメール
    mb_language("ja");
    mb_internal_encoding("utf-8");
    if ($notification_date == $today) {
        foreach ($users as $user) {
            $to = $user['email'];
            $subject = "一日前通知！";
            $body = '【リマインド】イベント名「' . $event['name'] . '」の一日前です。内容は「' .$event['detail']  .'」です。開催日時は' .$event['start_at']  .'です。このメールは入力状況に関わらず全員に通知しています。';
            $headers = "From: system@posse-ap.com";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-Transfer-Encoding: BASE64\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\n";
            if (mb_send_mail($to, $subject, $body, $headers)) {
                print_r('<pre>');
                echo $event['name'];
                echo 'は';
                echo $designated_date;
                echo 'に開催予定で、一日前であり、送信した内容は、「';
                echo $body;
                echo '」であり、';
                echo $to;
                echo 'に正常に送信されました。';
                print_r('</pre>');
            } else {
                echo "メール送信失敗です";
            }
        }
    }
}