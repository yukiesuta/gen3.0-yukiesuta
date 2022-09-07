<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['login_bool']);
    unset($_SESSION['login_user']);
    header("Location: ../auth/login/index.php");
}
