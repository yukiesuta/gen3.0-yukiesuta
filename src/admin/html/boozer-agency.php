<?php
require_once(__DIR__  . '/../../dbconnect.php');
require_once(__DIR__  . '/../app/config.php');

$pdo = getPdoInstance();

$stmt = $pdo->query("SELECT * FROM agency_information");
$agencys = $stmt->fetchAll();

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
    <link rel="stylesheet" href="../css/boozer-agency.css">
    <title>エージェンシー情報</title>
</head>
<body>
    <header class="text-center p-2">
        Craft
    </header>
    <main>
        <div class="row">
            <div class="main-left col-2">
                <div class="text-center mt-5">
                    <a href="boozer-agency.php" class="text-decoration-none text-secondary">
                        エージェンシー情報
                    </a>
                </div>
                <div class="text-center mt-3">
                    <a href="boozer-student-info.php" class="text-decoration-none text-white">
                        学生情報
                    </a>
                </div>
                <div class="text-center mt-3">
                    <a href="boozer-claim-info.php" class="text-decoration-none text-white">
                        請求情報管理
                    </a>
                </div>
                
                
            </div>
            <div class="main-right col-10">
                <div class="table">
                    <table class="table table-striped w-100 mt-5">
                        <thead>
                            <tr>
                                <th scope="col">エージェント名</th>
                                <th scope="col">メールアドレス</th>
                                <th scope="col">担当責任者</th>
                                <th scope="col">電話番号</th>
                                <th scope="col">総申込件数</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agencys as $agency) : ?>
                            <tr>
                                <th scope="row"><?= $agency->agency_name; ?></th>
                                <td><?= $agency->mail_address; ?></td>
                                <td><?= $agency->manager; ?></td>
                                <td><?= $agency->phone_number; ?></td>
                                <td>
                                    <?php
                                        $agency_stmt = $pdo->query("SELECT * FROM inquiry_agency WHERE agency_id = $agency->id");
                                        $agency_result = $agency_stmt->fetchAll();
                                        echo count($agency_result);
                                    ?>
                                <td>
                                    <a href="boozer-edit-creation.php?id=<?= $agency->id;?>">
                                        <button type="button" class="btn btn-primary btn-sm">編集・削除</button>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center btn-lg">
                    <a href="boozer-new-creation.php">
                        <button type="button" class="btn btn-primary mt-5">新規作成</button>
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>