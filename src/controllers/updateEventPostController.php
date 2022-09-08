<?php
require '../dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_is_after_today=strtotime($_POST['start_at'])>strtotime(date('Y-m-d 00:00:00'));
    $end_is_after_start=strtotime($_POST['end_at'])>strtotime($_POST['start_at']);
    if($start_is_after_today && $end_is_after_start){
        $update_event_stmt=$db->prepare("update events set name=:name,detail=:detail,start_at=:start_at,end_at=:end_at where id=:id");
        $update_event_stmt->bindValue(':name',$_POST['event_name']);
        $update_event_stmt->bindValue(':detail',$_POST['detail']);
        $update_event_stmt->bindValue(':start_at',$_POST['start_at']);
        $update_event_stmt->bindValue(':end_at',$_POST['end_at']);
        $update_event_stmt->bindValue(':id',$_POST['event_id']);
        $update_event_stmt->execute();
    }
    //元の場所にもどる
    $uri=$_SERVER['HTTP_REFERER'];
    header("Location: ".$uri);
}