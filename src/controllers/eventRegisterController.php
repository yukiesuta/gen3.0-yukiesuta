<?php
require '../dbconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['event_name'];
    $detail = $_POST['detail'];
    $start_at = $_POST['start_at'];
    $end_at = $_POST['end_at'];

    $regi_stmt = $db->prepare("INSERT INTO events (name, detail, start_at, end_at) VALUES (:name, :detail, :start_at, :end_at);");
    $regi_stmt->bindValue(':name', $name);
    $regi_stmt->bindValue(':detail', $detail);
    $regi_stmt->bindValue(':start_at', $start_at);
    $regi_stmt->bindValue(':end_at', $end_at);
    $regi_stmt->execute();
    //登録したイベントのidを取得
    $last_insert_event_id_stmt = $db->query("select id from events order by id desc limit 1;");
    $last_insert_event_id_stmt->execute();
    $last_insert_event_id = $last_insert_event_id_stmt->fetch()['id'];
    $all_user_ids_stmt = $db->query("select id from users;");
    $all_user_ids_stmt->execute();
    $all_user_ids = $all_user_ids_stmt->fetchAll();
    //全てのユーザー分登録したイベントに未回答で登録する
    foreach ($all_user_ids as $user_id) {
        $create_event_user_attendance_stmt = $db->prepare("insert into event_user_attendance (event_id,user_id) values (:event_id,:user_id);");
        $create_event_user_attendance_stmt->bindValue(':event_id',$last_insert_event_id);
        $create_event_user_attendance_stmt->bindValue(':user_id',$user_id['id']);
        $create_event_user_attendance_stmt->execute();
    }
    header("Location:  /../admin/admin.php");
    exit;
}
//管理画面のボタンの色の変化もやるべき。遷移してるから簡単
