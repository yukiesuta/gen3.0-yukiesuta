<?php
require('dbconnect.php');

$stmt = $db->query('SELECT * FROM event_user_attendance eua  INNER JOIN users u ON  eua.user_id = u.id INNER JOIN events e ON  eua.event_id = e.id WHERE attendance_status = 0');
$event_user_attendances = $stmt->fetchAll();

// foreach ($events as $event) {
//     $to = $event['email'];
//     $subject = "参加者様へ";
//     $body = '【リマインド】イベント名「' . $event['name'] . '」の三日前です。内容は「' . $event['detail']  . '」です。開催日時は' . $event['start_at']  . 'です。未回答者のみメンションします。回答してください。';;
//     $headers = "From: system@posse-ap.com";
//     $headers .= "MIME-Version: 1.0\n";
//     $headers .= "Content-Transfer-Encoding: BASE64\n";
//     $headers .= "Content-Type: text/plain; charset=UTF-8\n";

//     $now_time = new DateTime(); //現在日時
//     $designated_time = new DateTime($event['start_at']); //指定日時
//     $designated_date = $designated_time->format('Y-m-d');

//     $notification_date = $designated_time->modify('-3 day'); //通知日時

//     $today = $now_time->format('Y-m-d'); //現在日
//     $notification_date = $designated_time->format('Y-m-d'); //通知日

//     // 通知日と今日が同じが同じならスラック
//     if ($notification_date == $today) {
//         $headers = [
//             // トークンは保護する
//             'Authorization: Bearer ここにトークンを入力 xoxbで始まる', //（1)
//             'Content-Type: application/json;charset=utf-8'
//         ];
        
//         $url = "https://slack.com/api/chat.postMessage"; //(2)
        
//         //(3)
//         $post_fields = [
//             "channel" => "#2d-hack",
//             "text" => $body,
//             "as_user" => true
//         ];
        
//         $options = [
//             CURLOPT_URL => $url,
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_HTTPHEADER => $headers,
//             CURLOPT_POST => true,
//             CURLOPT_POSTFIELDS => json_encode($post_fields) 
//         ];
        
//         $ch = curl_init();
        
//         curl_setopt_array($ch, $options);
        
//         $result = curl_exec($ch); 
        
//         curl_close($ch);

//         print_r('<pre>');
//         echo $event['name'];
//         echo 'は';
//         echo $designated_date;
//         echo 'に開催されるため今日は三日前であり、「';
//         echo $body;
//         echo '」をスラックに投稿し、未回答者である';
//         echo $to;
//         echo 'にメンションしました。';
//         print_r('</pre>');
        
//     }
// }


$stmt = $db->query('SELECT * FROM events');
$events = $stmt->fetchAll();

foreach ($events as $event) {

    $now_time = new DateTime(); //現在日時
    $designated_time = new DateTime($event['start_at']); //指定日時
    $designated_date = $designated_time->format('Y-m-d');

    $notification_date = $designated_time->modify('-3 day'); //通知日時

    $today = $now_time->format('Y-m-d'); //現在日
    $notification_date = $designated_time->format('Y-m-d'); //通知日

    if($today == $notification_date){
        $stmt = $db->query('SELECT slack_id FROM event_user_attendance eua  INNER JOIN users u ON  eua.user_id = u.id INNER JOIN events e ON  eua.event_id = e.id WHERE attendance_status = 0 AND event_id =' . $event['id'] );
        $event_user_attendances = $stmt->fetchAll();

        print_r($event_user_attendances);
    }

    $body = '【リマインド】イベント名「' . $event['name'] . '」の三日前です。内容は「' . $event['detail']  . '」です。開催日時は' . $event['start_at']  . 'です。未回答者のみメンションします。回答してください。';

    
    foreach($event_user_attendances as $event_user_attendance){
        // このイベントの未回答者配列
        $not_answer_id_arr = array();
        $not_answer_id_arr[] = $event_user_attendance['slack_id'];
        // array_push($not_answer_arr,$event_user_attendance['slack_id']);
    }
    print_r('<pre>');
    print_r($not_answer_arr);
    print_r('</pre>');

    if ($notification_date == $today) {


    $headers = [
        // トークンは保護する
        'Authorization: Bearer ここにトークンを入力 xoxbで始まる', //（1)
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


    // print_r('<pre>');
    // echo $event['name'];
    // echo 'は';
    // echo $designated_date;
    // echo 'に開催されるため今日は三日前であり、「';
    // echo $body;
    // echo '」をスラックに投稿し、未回答者である人（未実装）';
    // echo 'にメンションしました。';
    // print_r('</pre>');
}
}


