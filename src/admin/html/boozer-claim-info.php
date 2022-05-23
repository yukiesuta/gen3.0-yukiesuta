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
    <link rel="stylesheet" href="https://unpkg.com/@popperjs/core@2">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/claim-info.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>請求情報管理</title>
</head>

<body>
    <header class="text-center p-2">
        Craft
    </header>
    <main>
        <div class="row">
            <div class="main-left col-2">
                <div class="text-center mt-5">
                    <a href="boozer-agency.php" class="text-decoration-none text-white">
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
                    <table class="table table-striped w-75 mt-5">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">エージェンシー名</th>
                                <th scope="col">請求ステータス</th>
                                <th scope="col">申し込み人数</th>
                                <th scope="col">金額(単価×申込み人数)</th>
                                <th scope="col">電話番号</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        <?php foreach ($agencys as $agency) : ?>
                            <tr>
                                <th scope="row"><?= $agency->agency_name; ?></th>
                                <td>
                                    <select name="change">
                                        <option value="recommend">未請求</option>
                                        <option value="name">請求済み</option>
                                        <option value="number">入金済み</option>
                                        <option value="number">入金遅滞</option>
                                        <option value="number">請求不能</option>
                                    </select>
                                </td>
                                <td>
                                    <?php
                                        $agency_stmt = $pdo->query("SELECT * FROM inquiry_agency WHERE agency_id = $agency->id");
                                        $agency_result = $agency_stmt->fetchAll();
                                        echo count($agency_result);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo 3000 * count($agency_result);
                                    ?>
                                </td>
                                <td><?= $agency->phone_number; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>