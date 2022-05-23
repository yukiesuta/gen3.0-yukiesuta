<?php
require_once(__DIR__  . '/../../dbconnect.php');
require_once(__DIR__  . '/../app/config.php');



$pdo = getPdoInstance();
$agency_id = $_GET["agency_id"];


// $student_informations = get_student_informations($pdo);
// $inquiry_agency_informations = get_inquiry_agency_informations($pdo);

$inquiry_agency_stmt = $pdo->query("SELECT * FROM inquiry_agency WHERE agency_id = $agency_id");
$inquiry_agency_results = $inquiry_agency_stmt->fetchAll();

$inquiry_stmt = $pdo->query("SELECT * FROM inquiry");
$inquiry_results = $inquiry_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    edit_progress($pdo);
}

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
                    <? 
                    $count = $inquiry_result->id -1;

                    // Bに応募したエージェンシー　AB B　少なくなっちゃう
                    if($count<count($inquiry_agency_results)){
                        $sorted_phone = $inquiry_agency_results[$count]->phone;
                    }else{
                        break;
                    }

                    $inquiry_stmt2 = $pdo->query("SELECT * FROM inquiry WHERE phone = '$sorted_phone'");
                    $inquiry_results2 = $inquiry_stmt2->fetch();


                    ?>
                    <tr>
                        <th scope="row"><?=$inquiry_results2->name; ?></th>
                        <td><?= $inquiry_results2->name; ?></td>
                        <td><?= $inquiry_results2->email; ?></td>
                        <td><?= $inquiry_results2->phone; ?></td>
                        <td><?= $inquiry_results2->university; ?></td>
                        <td><?= $inquiry_results2->birthday; ?></td>

                        <!-- <?=$inquiry_agency_results[$count]->progress;?> -->
                        <td>
                            <form method='POST' action='agency.php?agency_id=<?=$agency_id?>'>
                                <select name="progress">
                                    <option value="0" <?php if($inquiry_agency_results[$count]->progress===0){echo "selected";} ?>>状況0</option>
                                    <option value="1" <?php if($inquiry_agency_results[$count]->progress===1){echo "selected";} ?>>状況1</option>
                                    <option value="2" <?php if($inquiry_agency_results[$count]->progress===2){echo "selected";} ?>>状況2</option>
                                    <option value="3" <?php if($inquiry_agency_results[$count]->progress===3){echo "selected";} ?>>状況3</option>
                                    <option value="4" <?php if($inquiry_agency_results[$count]->progress===4){echo "selected";} ?>>状況4</option>
                                </select>
                                <input type="hidden" value="<?=$agency_id?>" name="agency_id">
                                <input type="hidden" value="<?=$inquiry_results2->name; ?>" name="name">
                                <input type="hidden" value="<?= $inquiry_results2->phone; ?>" name="phone">
                                    <button class="btn-secondary btn" type='submit' > 更新</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </main>
</body>

</html>