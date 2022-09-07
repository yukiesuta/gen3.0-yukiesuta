<?php
require('dbconnect.php');

$stmt = $db->query('SELECT * FROM event_user_attendance eua  INNER JOIN users u ON  eua.user_id = u.id INNER JOIN events e ON  eua.event_id = e.id WHERE attendance_status = 0');
$events = $stmt->fetchAll();

foreach ($events as $event) {
    $to = $event['email'];
    $subject = "未回答者様へ";
    $body = "「イベントアプリの回答が未回答です」";
    $headers = "From: system@posse-ap.com";

    $now_time = new DateTime(); //現在日時
    $designated_time = new DateTime($event['start_at']); //指定日時
    $designated_date = $designated_time->format('Y-m-d');

    $notification_date = $designated_time->modify('-3 day'); //通知日時

    $today = $now_time->format('Y-m-d'); //現在日
    $notification_date = $designated_time->format('Y-m-d'); //通知日

    // 通知日と今日が同じが同じならメール
    if ($notification_date == $today) {
        if (mb_send_mail($to, $subject, $body, $headers)) {
            print_r('<pre>');
            echo $event['name'];
            echo 'は';
            echo $designated_date;
            echo 'に開催されるため今日は三日前であり、';
            echo $body;
            echo 'は未回答である';
            echo $to;
            echo 'に送信されました';
            print_r('</pre>');
        } else {
            echo "メール送信失敗です";
        }
    }
}
