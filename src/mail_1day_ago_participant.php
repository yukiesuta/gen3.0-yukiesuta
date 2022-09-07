<?php
require('dbconnect.php');

$stmt = $db->query('SELECT * FROM event_user_attendance eua  INNER JOIN users u ON  eua.user_id = u.id INNER JOIN events e ON  eua.event_id = e.id WHERE attendance_status = 1');
$events = $stmt->fetchAll();

foreach ($events as $event) {
    $to = $event['email'];
    $subject = "未回答者様へ";
    $body = '【リマインド】イベント名「' . $event['name'] . '」の一日前です。内容は「' . $event['detail']  . '」です。開催日時は' . $event['start_at']  . 'です。回答をお願いします。このメールは参加者のみに通知しています。';;
    $headers = "From: system@posse-ap.com";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Transfer-Encoding: BASE64\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\n";

    $now_time = new DateTime(); //現在日時
    $designated_time = new DateTime($event['start_at']); //指定日時
    $designated_date = $designated_time->format('Y-m-d');

    $notification_date = $designated_time->modify('-1 day'); //通知日時

    $today = $now_time->format('Y-m-d'); //現在日
    $notification_date = $designated_time->format('Y-m-d'); //通知日

    // 通知日と今日が同じが同じならメール
    if ($notification_date == $today) {
        if (mb_send_mail($to, $subject, $body, $headers)) {
            print_r('<pre>');
            echo $event['name'];
            echo 'は';
            echo $designated_date;
            echo 'に開催されるため今日は一日前であり、「';
            echo $body;
            echo '」は参加者である';
            echo $to;
            echo 'に送信されました';
            print_r('</pre>');
        } else {
            echo "メール送信失敗です";
        }
    }
}
