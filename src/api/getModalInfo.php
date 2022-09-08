<?php
session_start();
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');

if (isset($_GET['event_id'])) {
  $event_id = htmlspecialchars($_GET['event_id']);
  try {
    $stmt = $db->prepare('select id,name,start_at,end_at,detail from events where id= :id;');
    $stmt->bindValue(':id',$event_id);
    $stmt->execute();
    $event = $stmt->fetch();
    $attendance_stmt=$db->prepare('select count(*) from event_user_attendance where event_id= :event_id and attendance_status=1;');
    $attendance_stmt->bindValue(':event_id',$event_id);
    $attendance_stmt->execute();
    $total_participants=$attendance_stmt->fetch()['count(*)'];
    $login_user_attendance_stmt = $db->prepare('select attendance_status from event_user_attendance where user_id= :user_id and event_id= :event_id;');
    $login_user_attendance_stmt->bindValue(':user_id',$_SESSION['login_user']['id']);
    $login_user_attendance_stmt->bindValue(':event_id',$event_id);
    $login_user_attendance_stmt->execute();
    $login_user_attendance=$login_user_attendance_stmt->fetch()['attendance_status'];
    $start_date = strtotime($event['start_at']);
    $end_date = strtotime($event['end_at']);

    $eventMessage = date("Y年m月d日", $start_date) . '（' . get_day_of_week(date("w", $start_date)) . '） ' . date("H:i", $start_date) . '~' . date("H:i", $end_date) . 'に' . $event['name'] . 'を開催します。<br>ぜひ参加してください。';

    $array = [
      'id' => $event['id'],
      'name' => $event['name'],
      'date' => date("Y年m月d日", $start_date),
      'day_of_week' => get_day_of_week(date("w", $start_date)),
      'start_at' => date("H:i", $start_date),
      'end_at' => date("H:i", $end_date),
      'total_participants' => $total_participants,
      'message' => $eventMessage,
      'status' => $login_user_attendance,
      'deadline' => date("m月d日", strtotime('-3 day', $end_date)),
    ];
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
  } catch(PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}

function get_day_of_week ($w) {
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}