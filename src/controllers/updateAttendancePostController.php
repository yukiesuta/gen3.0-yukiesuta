<?php
session_start();
require '../dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['attendance']=='参加する'){
        $attendance_status=1;
    }elseif($_POST['attendance']=='参加しない'){
        $attendance_status=2;
    }else{
        $attendance_status=0;
    }
    $update_attendance_stmt=$db->prepare('update event_user_attendance set attendance_status=:attendance_status where event_id=:event_id and user_id=:user_id;');
    $update_attendance_stmt->bindValue(':attendance_status',$attendance_status);
    $update_attendance_stmt->bindValue(':event_id',$_POST['event_id']);
    $update_attendance_stmt->bindValue(':user_id',$_SESSION['login_user']['id']);
    $update_attendance_stmt->execute();
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
?>