<?php
session_start();
require('../app/dbconnect.php');

if (!empty($_POST)) {
  $login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
  $login->execute(array(
    $_POST['email'],
    sha1($_POST['password'])
  ));
  $user = $login->fetch();

  if ($user) {
    $_SESSION = array();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['time'] = time();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/html/student-info.php');
    exit();
  } else {
    $error = 'fail';
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/normalize.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/login.css">
  <title>ログイン</title>
</head>

<body>
  <header>
  </header>
  <main>
    <div class="text-center mt-5 p-5">
      <img src="../img/posseLogo.png" alt="" class="logo">
    </div>
    <div class="w-25 text-center form">
      <? if (!empty($_POST)) {
        
        if (!$user) {
         echo "メールアドレスまたはパスワードが正しくありません。";
        }
      } ?>
      <form action="/admin/html/login.php" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">User name</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter User name" name="email" required>
        </div>
        <div class="form-group mt-3">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required name="password">
          <small id="emailHelp" class="form-text text-muted">ご不明の場合はBoozer担当者までお問い合わせください</small>
        </div>

        <button type="submit" value="ログイン" class="btn btn-primary mt-5">ログイン</button>
      </form>
    </div>
  </main>
</body>

</html>