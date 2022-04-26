<?php


define('DSN', 'mysql:host=db;dbname=shukatsu;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', 'password');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

require_once(__DIR__ . '/user-functions.php');