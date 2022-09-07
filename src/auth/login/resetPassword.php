<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>Schedule | POSSE</title>
</head>

<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="/img/header-logo.png" alt="" class="h-full">
      </div>
    </div>
  </header>

  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">パスワード再設定フォーム</h2>
      <form action="../../controllers/forgotPasswordPostController.php" method="POST">
        <input name="email" type="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3">
        <input name="password" type="password" placeholder="新規パスワード" class="w-full p-4 text-sm mb-3">
        <input name="password_re" type="password" placeholder="新規パスワード再入力" class="w-full p-4 text-sm mb-3">
        <input type="submit" value="送信" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <?php 
      if($_SESSION['reset_bool']===0){
        echo '<div>メールアドレスが間違っているか、パスワードが不適切です</div>';}
      ?>
    </div>
  </main>
</body>
</html>