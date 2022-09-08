<?php
function group_by($key, array $ary): array
{
    $result = [];

    foreach ($ary as $row) {
        if (array_key_exists($key, $row)) {
            $result[$row[$key]][] = $row;
        } else {
            $result[""][] = $row[$key];
        }
    }

    return $result;
}
$user_names_stmt = $db->query('select id,name from users;');
$user_names = $user_names_stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

//イベント一覧を取得,idをキーとすることでeager loadの再現をしやすくしている
$events_stmt = $db->query('select id,name,start_at,end_at,detail from events order by start_at asc;');
$events = $events_stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

//出席一覧を取得
$attendance_stmt = $db->query('select event_id,user_id,attendance_status from event_user_attendance order by attendance_status;');
$attendances = $attendance_stmt->fetchAll();

//各ユーザーの出席にユーザー名の情報を追加する
foreach ($attendances as &$attendance) {
    $attendance = $attendance + array('user_name' => $user_names[$attendance['user_id']]['name']);
}

//出席一覧をイベントによってgroupbyする。laravelのeager loadを再現してる
$event_user_attendances_grouped_by_event_id = group_by('event_id', $attendances);

//ログインユーザーのイベントのattendance_statusを取得
$login_user_attendance_stmt = $db->prepare('select event_id,attendance_status from event_user_attendance where user_id= :user_id order by event_id;');
$login_user_attendance_stmt->bindValue(':user_id', $_SESSION['login_user']['id']);
$login_user_attendance_stmt->execute();
$login_user_attendance = $login_user_attendance_stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

foreach ($event_user_attendances_grouped_by_event_id as $event_id => $users) {
    //出席一覧を出席ステータスでgroupbyする。laravelのeager loadを再現してる
    $users_grouped_by_attendance_status = group_by('attendance_status', $users);
    $events[$event_id] = $events[$event_id] + array('attendance_status' => $users_grouped_by_attendance_status);
    $events[$event_id] = $events[$event_id] + array('login_user_attendance_status' => $login_user_attendance[$event_id]['attendance_status']);
};
//URLのクエリパラメータによって返す情報をフィルターする
$events_filtered_by_login_user_attendance_status = [];
//全て
if (!isset($_GET['attendance_status'])) {
    $events_filtered_by_login_user_attendance_status = $events;
} else {
    foreach ($events as $event_id => $event) {
        if ($_GET['attendance_status'] === $event['login_user_attendance_status']) {
            $events_filtered_by_login_user_attendance_status = $events_filtered_by_login_user_attendance_status + array($event_id => $event);
        }
    }
}
//今日の日付のはじめを数値にして各イベントの開始時刻と比較
date_default_timezone_set('Asia/Tokyo');
$start_of_today = date("Y-m-d 00:00:00");
$time_start_of_today = strtotime($start_of_today);
foreach ($events_filtered_by_login_user_attendance_status as $key => $value) {
    //今日の00:00:00より前のイベントは消す
    if (strtotime($value['start_at']) <= $time_start_of_today) {
        unset($events_filtered_by_login_user_attendance_status[$key]);
    }
}
