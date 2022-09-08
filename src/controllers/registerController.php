<?php
require '../dbconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if($_POST['is_admin']===null){
      $is_admin=0;
    }else{
      $is_admin=$_POST['is_admin'];
    };
    // $githubID = $_POST['githubID'];
    // $slackID = $_POST['slackID'];

    $regi_stmt = $db->prepare("INSERT INTO users (name, email, password,is_admin) VALUES (:name, :email, :password, :is_admin);");
    $regi_stmt->bindValue(':email',$email);
    $regi_stmt->bindValue(':name',$name);
    $regi_stmt->bindValue(':password',hash('sha512',$password));
    $regi_stmt->bindValue(':is_admin',$is_admin);
    $regi_stmt->execute();

    header("Location:  /../admin/admin.php");
    exit;
}
