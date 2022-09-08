<?php
require '../dbconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['event_name'];
    $detail = $_POST['detail'];
    $start_at = $_POST['start_at'];
    $end_at = $_POST['end_at'];

    $regi_stmt = $db->prepare("INSERT INTO events (name, detail, start_at, end_at) VALUES (:name, :detail, :start_at, :end_at);");
    $regi_stmt->bindValue(':name',$name);
    $regi_stmt->bindValue(':detail',$detail);
    $regi_stmt->bindValue(':start_at',$start_at);
    $regi_stmt->bindValue(':end_at',$end_at);
    $regi_stmt->execute();

    header("Location:  /../admin/admin.php");
    exit;
}
