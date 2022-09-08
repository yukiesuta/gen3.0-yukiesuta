<?php
require('dbconnect.php');

$stmt = $db->query('SELECT * FROM events');
$events = $stmt->fetchAll();

// イベントごとにforeachする
foreach ($events as $event) {

    $now_time = new DateTime(); //現在日時
    $designated_time = new DateTime($event['start_at']); //指定日時
    $designated_date = $designated_time->format('Y-m-d');

    $notification_date = $designated_time->modify('-1 day'); //通知日時

    $today = $now_time->format('Y-m-d'); //現在日
    $notification_date = $designated_time->format('Y-m-d'); //通知日

    // このイベントが通知するべき日ならこのイベントに参加者のslack_idをとってくる
    if ($today == $notification_date) {
        $stmt = $db->query('SELECT slack_id FROM event_user_attendance eua  INNER JOIN users u ON  eua.user_id = u.id INNER JOIN events e ON  eua.event_id = e.id WHERE attendance_status = 1 AND event_id =' . $event['id']);
        $event_user_attendances = $stmt->fetchAll();

        foreach ($event_user_attendances as $event_user_attendance) {
            $slack_id = '<@' . $event_user_attendance['slack_id'] . '>';
            $slack_id_mention = $slack_id_mention . $slack_id;
        }

        $body = '【リマインド】イベント名「' . $event['name'] . '」の一日前です。内容は「' . $event['detail']  . '」です。開催日時は' . $event['start_at']  . 'です。参加者のみメンションします。' . $slack_id_mention;

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

        print_r('<pre>');
        echo $event['name'];
        echo 'は';
        echo $designated_date;
        echo 'に開催されるため今日は一日前であり、「';
        echo $body;
        echo '」をスラックに投稿し、参加者である人';
        echo 'にメンションしました。';
        print_r('</pre>');
    }
}
