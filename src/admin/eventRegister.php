<?php
require_once(dirname(__FILE__) . "/../dbconnect.php");
require_once(dirname(__FILE__) . "/../controllers/loginGetController.php");
session_start();


$stmt = $db->query('SELECT events.id, events.name, events.start_at, events.end_at, count(event_user_attendance.id) AS total_participants FROM events LEFT JOIN event_user_attendance ON events.id = event_user_attendance.event_id WHERE events.start_at >= DATE(now()) GROUP BY events.id ORDER BY events.start_at ASC');
$events = $stmt->fetchAll();

function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
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
        <img src="../img/header-logo.png" alt="" class="h-full">
      </div>
      <form action="../controllers/logoutPostController.php" method="POST">
        <input value="ログアウト" type="submit" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200 text-xs">
      </form>
    </div>
  </header>
  <main class="bg-gray-100">
    <div class="w-full mx-auto p-5">
    <div id="filter" class="mb-8">
        <h2 class="text-sm font-bold mb-3">メニュー</h2>
        <div class="flex">
          <a href="./admin.php" class="px-3 py-2 text-xs font-bold mr-2 rounded-md shadow-md bg-white">イベントリスト</a>
          <a href="./userRegister.php" class="px-3 py-2 text-xs font-bold mr-2 rounded-md shadow-md bg-white">ユーザー登録</a>
          <a href="./eventRegister.php" class="px-3 py-2 text-xs font-bold mr-2 rounded-md shadow-md bg-white">イベント追加</a>
          <a href="/" class="px-3 py-2 text-xs font-bold mr-2 rounded-md shadow-md bg-white">ユーザー画面へ</a>

        </div>
      </div>
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">イベント登録</h2>
      <form action="../../controllers/eventRegisterController.php" method="POST">
        <p>イベント名</p>
        <input name="event_name" type="name" class="w-full p-4 text-sm mb-3">
        <p>イベント詳細</p>
        <textarea name="detail" rows="4" class="w-full"></textarea>
        <p>開催日時</p>
        <input name="start_at" type="datetime-local" class="w-full p-4 text-sm mb-3">
        <p>終了日時</p>
        <input name="end_at" type="datetime-local" class="w-full p-4 text-sm mb-3">
        <input type="submit" value="登録" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
    </div>
    </div>
  </main>
  <script src="/js/main.js"></script>
</body>

</html>