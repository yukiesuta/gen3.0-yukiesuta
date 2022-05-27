<?php


require_once(__DIR__  . '/../app/config.php');
require_once(__DIR__  . '/../app/admin-functions.php');
require_once(__DIR__  . '/../app/dbconnect.php');

$pdo = getPdoInstance();

$agency_informations = get_agency_informations($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    edit_agency_information($pdo);
}

$id = $_GET["id"];

$stmt = $db->query("SELECT * FROM agency_information WHERE id = $id" );
$result = $stmt->fetch();






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
    <link rel="stylesheet" href="../css/new-creation.css">
    <title>編集画面</title>
</head>

<body>
    <header class="text-center p-2">
        Craft
    </header>
    <main>
        <form class=" p-5 ms-5 me-5 form"  method="post" id="inquiry" enctype="multipart/form-data">
            <div class=" mb-3 ms-5 me-5 text-center title">
                編集フォーム
            </div>
            <div>
                <div class="form-group w-50 mt-3">
                    <label>エージェンシー名</label>
                    <input type="text"  name="agency_name" class="form-control" id="form-name" placeholder="例)株式会社クラフト" value="<?= $result['agency_name']?>" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <label>特徴</label>
                    <input type="text" name="catch_copy" class="form-control" id="form-name" placeholder="例)自慢の即日対応" value="<?= $result['catch_copy']?>" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <label for="exampleFormControlTextarea1">詳細説明</label>
                    <!-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea> -->
                    <textarea name="detail" class="form-control wide" id="exampleFormControlTextarea1" placeholder="例)性別問わずキャリアに強いヘッドハンターも多数在席しております。若手向けのチャレンジポジションから管理層ポジションまで直接スカウトが届きます。" required><?= $result['detail']?></textarea>
                </div>
                <div class="form-group w-50 mt-3">
                    <label>メールアドレス</label>
                    <input type="email" name="mail_address" class="form-control" id="form-name" placeholder="例)example@mail.com" value="<?= $result['mail_address']?>" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <label>担当責任者</label>
                    <input type="text" name="manager" class="form-control" id="form-name" placeholder="例)佐藤" value="<?= $result['manager']?>" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <label>電話番号</label>
                    <input type="tel" pattern="[\d\-]*" name="phone_number" class="form-control" id="form-name" placeholder="例)08012345678" value="<?= $result['phone_number']?>" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <div>
                        <label>会社ロゴ（会社ロゴの変更は新規作成画面からやり直してください。）</label>
                    </div>
                </div>
                <div class="form-group w-50 mt-3">
                    <!-- <label>拠点数</label> -->
                    <label>単価（半角数字）</label>
                    <input type="text" pattern="^[1-9][0-9]*$" name="unit_price" class="form-control" id="form-name" placeholder="例)10000" value="<?= $result['unit_price']?>" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <label>実績数</label>
                    <input type="text" name="achievements" class="form-control" id="form-name" placeholder="例)150社" value="<?= $result['achievements']?>" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <label>契約数</label>
                    <input type="text" name="contract_numbers" class="form-control" id="form-name" placeholder="例)2500件" value="<?= $result['contract_numbers']?>" required>
                </div>
            </div>
            <div class="d-flex justify-content-around">
                <div>
                    <a href="boozer-delete.php?id=<?= $id;?>">
                        <button type="button" class="btn btn-primary mt-5 btn-danger">削除</button>
                    </a>
                </div>
                <div>
                <a href="boozer-edit-complete.php?id=<?= $id;?>">
                    <button type="submit" class="btn btn-primary mt-5" >編集完了</button>
                </a>
                </div>
            </div>
        </form>
    </main>
</body>

</html>