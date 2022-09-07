<?php
require '../dbconnect.php';
session_start();

$_SESSION['changed_password'] = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_stmt = $db->prepare('select * from users where email = :email limit 1;');
  $user_stmt->bindValue(':email', $_POST['email']);
  $user_stmt->execute();
  $user = $user_stmt->fetch();
  if (empty($user)||empty(trim($_POST['password']))||$_POST['password']!==$_POST['password_re']) {
    $_SESSION['reset_bool'] = 0;
    header("Location: ../auth/login/resetPassword.php");
    exit;
  } elseif (hash('sha512', $_POST['password']) === $user['password']) {
    $_SESSION['reset_bool'] = 0;
    header("Location: ../auth/login/resetPassword.php");
    exit;
  } else {
    $stmt = $db->prepare("UPDATE users SET password = :password WHERE email = :email");
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->bindValue(':password', hash('sha512', $_POST['password']));
    $stmt->execute();
    $_SESSION['changed_password'] = 1;
    $_SESSION['login_bool'] = null;
    header("Location: ../auth/login/index.php");
    exit;
  }
}
