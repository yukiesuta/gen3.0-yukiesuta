<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_SESSION['login_bool'])||$_SESSION['login_bool']===0) {
        header("Location: ../auth/login/index.php");
    }
}
