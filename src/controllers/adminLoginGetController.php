<?php
session_start();
// print_r('<pre>');
// var_dump($_SESSION);
// print_r('</pre>');
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //ログインしてるか☑
    if (!isset($_SESSION['login_bool'])||$_SESSION['login_bool']===0) {
        header("Location: ../auth/login/index.php");
    }
    //管理者としてログインしてるか☑
    if($_SESSION['login_user']['is_admin']!=1){
        header("Location: ../auth/login/index.php");
    }
}