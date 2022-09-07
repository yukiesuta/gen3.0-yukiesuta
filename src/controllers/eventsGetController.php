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
//イベント一覧を取得
$events_stmt = $db->query('select id,name,start_at,end_at from events order by start_at asc;');
$events = $events_stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
//出席一覧を取得
$attendance_stmt = $db->query('select event_id,user_id,attendance_status from event_user_attendance order by attendance_status;');
$attendances = $attendance_stmt->fetchAll();
//出席一覧をイベントによってgroupbyする。laravelのeager loadを再現してる
$event_user_attendances_grouped_by_event_id = group_by('event_id', $attendances);
//ログインユーザーのイベントのattendance_statusを取得
$login_user_attendance_stmt = $db->prepare('select event_id,attendance_status from event_user_attendance where user_id= :user_id order by event_id;');
$login_user_attendance_stmt->bindValue(':user_id',$_SESSION['login_user']['id']);
$login_user_attendance_stmt->execute();
$login_user_attendance=$login_user_attendance_stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

foreach ($event_user_attendances_grouped_by_event_id as $event_id => $users) {
    //出席一覧を出席ステータスでgroupbyする。laravelのeager loadを再現してる
    $users_grouped_by_attendance_status = group_by('attendance_status', $users);
    $events[$event_id] = $events[$event_id] + array('attendance_status' => $users_grouped_by_attendance_status);
    $events[$event_id]=$events[$event_id]+array('login_user_attendance_status'=>$login_user_attendance[$event_id]['attendance_status']);
};
// print_r('<pre>');
// var_dump($events);
// // var_dump($grouped_by_attendances);
// // var_dump($events);
// print_r('</pre>');
