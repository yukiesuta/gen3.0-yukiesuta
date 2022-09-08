<?php
session_start();
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');

if (isset($_GET['event_id'])) {
  $event_id = htmlspecialchars($_GET['event_id']);
  try {
    $stmt = $db->prepare('select id,name,start_at,end_at,detail from events where id= :id;');
    $stmt->bindValue(':id', $event_id);
    $stmt->execute();
    $event = $stmt->fetch();
    $attendance_count_stmt = $db->prepare('select count(*) from event_user_attendance where event_id= :event_id and attendance_status=1;');
    $attendance_count_stmt->bindValue(':event_id', $event_id);
    $attendance_count_stmt->execute();
    $total_participants = $attendance_count_stmt->fetch()['count(*)'];
    $user_names_stmt = $db->query('select id,name from users;');
    $user_names = $user_names_stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
    //出席一覧を取得
    $attendance_stmt = $db->prepare('select user_id from event_user_attendance where attendance_status=1 and event_id= :event_id;');
    $attendance_stmt->bindValue(':event_id', $event_id);
    $attendance_stmt->execute();
    $attendances = $attendance_stmt->fetchAll();
    //各ユーザーの出席にユーザー名の情報を追加する
    foreach ($attendances as &$attendance) {
      $attendance = $attendance + array('user_name' => $user_names[$attendance['user_id']]['name']);
    }
    $login_user_attendance_stmt = $db->prepare('select attendance_status from event_user_attendance where user_id= :user_id and event_id= :event_id;');
    $login_user_attendance_stmt->bindValue(':user_id', $_SESSION['login_user']['id']);
    $login_user_attendance_stmt->bindValue(':event_id', $event_id);
    $login_user_attendance_stmt->execute();
    $login_user_attendance = $login_user_attendance_stmt->fetch()['attendance_status'];
    $start_date = strtotime($event['start_at']);
    $end_date = strtotime($event['end_at']);
    $event_message = nl2br(htmlspecialchars($event['detail'], ENT_QUOTES, 'UTF-8'));
    $array = [
      'current_date' => date("Y-m-d"),
      'id' => $event['id'],
      'name' => $event['name'],
      'date' => date("Y年m月d日", $start_date),
      'day_of_week' => get_day_of_week(date("w", $start_date)),
      'start_at' => $event['start_at'],
      'end_at' => $event['end_at'],
      'total_participants' => $total_participants,
      'message' => $event_message,
      'status' => $login_user_attendance,
      'deadline' => date("m月d日", strtotime('-3 day', $end_date)),
      'participants'=>json_encode($attendances)
    ];
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}

function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
?>
