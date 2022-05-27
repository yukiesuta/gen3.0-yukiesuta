<?php

require_once(__DIR__  . '/../app/config.php');

$pdo = getPdoInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_agency_information($pdo);
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
    <link rel="stylesheet" href="../css/new-creation.css">
    <title>新規作成画面</title>
</head>

<body>
    <header class="text-center p-2">
        Craft
    </header>
    <main>
        <form class=" p-5 ms-5 me-5 form"  method="post" id="inquiry" enctype="multipart/form-data">
            <div class=" mb-3 ms-5 me-5 text-center title">
                新規作成フォーム
            </div>
            <div>
                <div class="form-group w-50 mt-3">
                    <label>エージェンシー名</label>
                    <input type="text"  name="agency_name" class="form-control" id="form-name" placeholder="例)株式会社クラフト" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <!-- <label>キャッチフレーズ</label> -->
                    <label>特徴</label>
                    <input type="text" name="catch_copy" class="form-control" id="form-name" placeholder="例)自慢の即日対応" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <label for="exampleFormControlTextarea1">詳細説明</label>
                    <!-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea> -->
                    <textarea name="detail" class="form-control wide" id="exampleFormControlTextarea1" placeholder="例)性別問わずキャリアに強いヘッドハンターも多数在席しております。若手向けのチャレンジポジションから管理層ポジションまで直接スカウトが届きます。" required></textarea>
                </div>
                <div class="form-group w-50 mt-3">
                    <label>メールアドレス</label>
                    <input type="email" name="mail_address" class="form-control" id="form-name" placeholder="例)example@mail.com" required>
                </div>
                <div class="form-group w-50 mt-3">

                    <label>担当責任者</label>
                    <input type="text" name="manager" class="form-control" id="form-name" placeholder="担当責任者をご入力ください" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <label>電話番号（ハイフン不要）</label>
                    <input type="tel" pattern="[\d\-]*" name="phone_number" class="form-control" id="form-name" placeholder="例)08012345678" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <div>
                        <label>会社ロゴ</label>
                    </div>
                    <input type="file" name="img" class="form-control-file mt-2" id="exampleFormControlFile1" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <!-- <label>実績数</label> -->
                    <label>求人エリア</label>
                    <input type="text" name="achievements" class="form-control" id="form-name" placeholder="例)渋谷・自由が丘" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <!-- <label>拠点数</label> -->
                    <label>面談場所</label>
                    <input type="text" name="bases_numbers" class="form-control" id="form-name" placeholder="例)渋谷・自由が丘" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <!-- <label>拠点数</label> -->
                    <label>単価（半角数字）</label>
                    <input type="text" pattern="^[1-9][0-9]*$" name="unit_price" class="form-control" id="form-name" placeholder="学生１人あたりの値段">
                </div>
                <div class="form-group w-50 mt-3">
                    <!-- <label>サポート</label> -->
                    <label>契約企業数</label>
                    <input type="text" name="support" class="form-control" id="form-name" placeholder="例)150社" required>
                </div>
                <div class="form-group w-50 mt-3">
                    <label>実績数</label>
                    <input type="text" name="contract_numbers" class="form-control" id="form-name" placeholder="例)2500件" required>
                </div>
            </div>
            <div>
                <div class="mt-5 ms-5 me-5 p-3 search">
                    <div class="search-title p-1 text-center">得意業種</div>
                    <div class="form-check w-25">
                        <input name="industry1" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            コンサル
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="industry2" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            エンジニア
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="industry3" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            メーカー
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="industry4" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            金融
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="industry5" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            商社
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="industry6" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            ベンチャー
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="industry7" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            サービス
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="industry8" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            インフラ
                        </label>
                    </div>
                </div>
                <div class="mt-5 ms-5 me-5 p-3 search">
                    <div class="search-title p-1 text-center">文理</div>
                    <div class="form-check w-25">
                        <input name="major1" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            文系
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="major2" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            理系
                        </label>
                    </div>
                </div>
                <div class="mt-5 ms-5 me-5 p-3 search">
                    <div class="search-title p-1 text-center">サポート</div>
                    <div class="form-check w-25">
                        <input name="feature1" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            ES添削あり
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="feature2" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            面接対策あり
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="feature3" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            即日連絡
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="feature4" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            オンライン可能
                        </label>
                    </div>
                    <div class="form-check w-25">
                        <input name="feature5" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            担当者変更可能
                        </label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-around">
                <div>
                    <a href="boozer-agency.php">
                        <button type="button" class="btn btn-primary mt-5">＜前のページに戻る</button>
                    </a>
                </div>
                <div>
                    <a href="boozer-agency.php">
                        <button type="submit" class="btn btn-primary mt-5" >この情報で登録する＞</button>
                    </a>
                </div>
            </div>
        </form>
    </main>
</body>

</html>