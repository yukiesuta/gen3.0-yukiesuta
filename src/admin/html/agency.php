<?php
require_once(__DIR__  . '/../../dbconnect.php');
require_once(__DIR__  . '/../app/config.php');



$pdo = getPdoInstance();
$agency_id = $_GET["agency_id"];


// $student_informations = get_student_informations($pdo);
// $inquiry_agency_informations = get_inquiry_agency_informations($pdo);

$inquiry_agency_stmt = $pdo->query("SELECT phone FROM inquiry_agency WHERE agency_id = $agency_id");
$inquiry_agency_result = $inquiry_agency_stmt->fetchAll();

$inquiry_stmt = $pdo->query("SELECT * FROM inquiry");
$inquiry_results = $inquiry_stmt->fetchAll();


// $stmt = $pdo->query("SELECT * FROM inquiry WHERE ");
// $student_informations = $stmt->fetchAll();

// $stmt = $db->query("SELECT phone FROM inquiry_agency WHERE agency_id = $agency_id" );
// $result = $stmt->fetch();
// エージェンシいidが一致するもののみ回収したいけどテーブルがわからないから放置
// admin-function.phpにも？？？がある
// print_r($inquiry_agency_informations);

// $stmt = $db->query("SELECT * FROM inquiry_agency WHERE phone = $result" );
// $result = $stmt->fetch();

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/agency.css">
    <title>各エージェンシーのページ</title>
</head>

<body>
    <header>
        <div class="d-flex justify-content-between p-4">
            <div class="d-flex header-left">
                <div class="m-2">Craft</div>
                <div class="m-2">エージェンジー名</div>
            </div>
            <div class="d-flex">
                <a href="https://forms.gle/jJJArbBQXUxwnzQd8" class="m-2 header-right text-decoration-none">
                    <div>クラフトへのお問い合わせ</div>
                </a>
                <a href="https://forms.gle/UGw3MZt6JKsmLQmWA" class="m-2 header-right text-decoration-none">
                    <div>編集依頼フォーム</div>
                </a>
            </div>
        </div>
    </header>
    <main>
        <div class="table">
            <table class="table table-striped w-75 mt-5">
                <thead>
                    <tr>
                        <th scope="col">学生名</th>
                        <th scope="col">担当者</th>
                        <th scope="col">メールアドレス</th>
                        <th scope="col">電話番号</th>
                        <th scope="col">申込日</th>
                        <th scope="col">備考</th>
                        <th scope="col">進行状況</th>
                    </tr>
                </thead>
                <?php foreach ($inquiry_results as $inquiry_result) : ?>
                    <tbody>
                        <tr>
                            <th scope="row"><?=$inquiry_result->name; ?></th>
                            <td><?= $inquiry_result->university; ?></td>
                            <td><?= $inquiry_result->email; ?></td>
                            <td><?= $inquiry_result->phone; ?></td>
                            <td><?= $inquiry_result->birthday; ?></td>
                            <td><?= $inquiry_result->address; ?></td>
                            <td>只今未実装です</td>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>

</html>