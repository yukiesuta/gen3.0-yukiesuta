<?php



require_once(__DIR__  . '/../app/config.php');

$pdo = getPdoInstance();

$agency_informations = get_agency_informations($pdo);
$industry_conditions = get_industry_conditions($pdo);
$major_conditions = get_major_conditions($pdo);
$feature_conditions = get_feature_conditions($pdo);

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// }
$shibori = agency_information($pdo);

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $shibori = agency_information($pdo);
// }
$ids = [$shibori];


// IN 句に入る値を作成
$inClause = substr(str_repeat(',?', count($ids)), 1);

$stmt = $pdo->prepare("SELECT * FROM agency_information 
JOIN agency_feature AS itt ON  agency_information.id = itt.agency_id
JOIN features ON itt.feature_id = features.id
-- JOIN industry_condition AS ittt ON  itt.feature_id = ittt.id
WHERE features.id IN ({$inClause})
ORDER BY unit_price DESC;
");

$stmt->execute($ids);

$agency_informations = $stmt->fetchAll();
// print_r($agency_informations);

$tmp = [];
$uniqueStations = [];

foreach ($agency_informations as $station) {
    if (!in_array($station->agency_name, $tmp)) {
        $tmp[] = $station->agency_name;
        $uniqueStations[] = $station;
    }
}

$stmt = $pdo->prepare("SELECT * FROM agency_information 
JOIN agency_feature AS itt ON  agency_information.id = itt.agency_id
JOIN features ON itt.feature_id = features.id
JOIN industry_condition AS ittt ON  itt.feature_id = ittt.id
");
$stmt->execute();

$agency_industry_comparison = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM agency_information 
JOIN agency_feature AS feature_comparison ON  agency_information.id = feature_comparison.agency_id
JOIN features ON feature_comparison.feature_id = features.id
");
$stmt->execute();

$agency_feature_comparison = $stmt->fetchAll();
// print_r($agency_feature_comparison);



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/toppage.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Craft</title>
</head>

<body>
    <header>
        <div class="headerTitle text-center fs-2">
            Craft
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand ms-3" href="#">Craft</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active me-5">
                        <a class="nav-link" href="#">就活サイト</a>
                    </li>
                    <li class="nav-item me-5">
                        <a class="nav-link" href="#">就活支援サービス</a>
                    </li>
                    <li class="nav-item me-5">
                        <a class="nav-link" href="#">自己分析診断ツール</a>
                    </li>
                    <li class="nav-item me-5">
                        <a class="nav-link" href="#">ES添削サービス</a>
                    </li>
                    <li class="nav-item me-5">
                        <a class="nav-link" href="#">就活エージェント</a>
                    </li>
                    <li class="nav-item me-5">
                        <a class="nav-link" href="#">就職の教科書とは</a>
                    </li>
                    <li class="nav-item me-5">
                        <a class="nav-link" href="#">お問い合わせ</a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <main>
        <div class="first-view">
            <img src="../img/firstview.jpg" alt="first-view" class="first-view-img">
        </div>
        <div class="text-center button">
            <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                絞り込み
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <from id="modal-content" method="post">
                        <div class="modal-body row">
                            <div class="mobile-top-content">
                                <div class="mt-4 search ms-2 p-2">
                                    <div class="search-title text-center">業種</div>
                                    <?php foreach ($industry_conditions as $industry_condition) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input-not-click" type="checkbox" name="industry<?= h($industry_condition->id); ?>" value="" id="ph_industry_flexCheckDefault<?= h($industry_condition->id); ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?= h($industry_condition->industry); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="mt-4 search ms-1 p-2">
                                    <div class="search-title text-center">文理</div>
                                    <?php foreach ($major_conditions as $major_condition) : ?>
                                        <div class="form-check mt-1">
                                            <input class="form-check-input form-check-input-not-click" type="checkbox" name="major<?= h($major_condition->id); ?>" value="" id="ph_major_flexCheckDefault<?= h($major_condition->id); ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?= h($major_condition->major); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="mt-4 search ms-1 me-2 p-2">
                                    <div class="search-title text-center">特徴</div>
                                    <?php foreach ($feature_conditions as $feature_condition) : ?>
                                        <div class="form-check mt-1">
                                            <input class="form-check-input form-check-input-not-click" type="checkbox" name="feature<?= h($feature_condition->id); ?>" value="" id="ph_feature_flexCheckDefault<?= h($feature_condition->id); ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?= h($feature_condition->feature); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <button type="submit" class="btn btn-success col-8 justify-content-center mt-2 mb-3" id="submitButton">絞り込み</button>
                            <!-- <button type="submit" class="btn btn-primary mt-5" >絞り込む</button> -->
                            <div class="col"></div>
                        </div>
                        </form>
                </div>
            </div>
        </div>
        <div class="main-container raw">
            <form class="main-left-content col-md-3" method="post">
                <div class="mt-5 ms-5 me-5 p-3 search">
                    <div class="search-title p-1 text-center">業種</div>
                    <?php foreach ($industry_conditions as $industry_condition) : ?>
                        <div class="form-check">
                            <input class="form-check-input form-check-input-click" type="checkbox" value="" name="industry<?= h($industry_condition->id); ?>" id="pc_industry_flexCheckDefault<?= h($industry_condition->id); ?>">
                            <label class="form-check-label" for="flexCheckDefault">
                                <?= h($industry_condition->industry); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 ms-5 me-5 p-3 search">
                    <div class="search-title p-1 text-center">文理</div>
                    <?php foreach ($major_conditions as $major_condition) : ?>
                        <div class="form-check mt-1">
                            <input class="form-check-input form-check-input-click" type="checkbox" value="" name="major<?= h($major_condition->id); ?>" id="pc_major_flexCheckDefault<?= h($major_condition->id); ?>">
                            <label class="form-check-label" for="flexCheckDefault">
                                <?= h($major_condition->major); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 ms-5 me-5 p-3 search">
                    <div class="search-title p-1 text-center">特徴</div>
                    <?php foreach ($feature_conditions as $feature_condition) : ?>
                        <div class="form-check mt-1">
                            <input class="form-check-input form-check-input-click" type="checkbox" value="" name="feature<?= h($feature_condition->id); ?>" id="pc_feature_flexCheckDefault<?= h($feature_condition->id); ?>">
                            <label class="form-check-label" for="flexCheckDefault">
                                <?= h($feature_condition->feature); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success mt-3">絞り込む</button>
                </div>
            </form>
            <div class="main-center-content col-md-6 col-12 ">
                <?php foreach ($uniqueStations as $agency_information) : ?>
                    <div class="mt-4 ms-5 me-5 mb-5 p-3 company-content-wrapper ">
                        <div class="d-flex company-content">
                            <a href="company.php?id=<?= h($agency_information->agency_id); ?>">
                                <div class="logo-container p-1">
                                    <img src="../uploaded_img/agency<?= h($agency_information->agency_id); ?>.png" alt="" class="center-img">
                                </div>
                            </a>
                            <div>
                                <a href="company.php?id=<?= h($agency_information->agency_id); ?>" class="text-decoration-none">
                                    <div class="company-content-title p-1"><?= h($agency_information->agency_name); ?></div>
                                </a>
                                <div class="p-3 company-content-paragraph">
                                    <?= h($agency_information->catch_copy); ?>
                                </div>
                                <div class="text-right"> 
                                    <div>
                                        <?php
                                        if ($data = $agency_information->agency_id) {
                                            foreach ($agency_industry_comparison as $val) {
                                                if ($val->agency_id === $data) {
                                                    echo '<div class="label-industry">#'.$val->industry.'</div>';
                                                }
                                            };
                                        } ?>
                                    </div>
                                    <div>
                                        <?php
    
                                        if ($data = $agency_information->agency_id) {
                                            foreach ($agency_feature_comparison as $val) {
                                                if ($val->agency_id === $data) {
                                                    if ($val->feature_id > 10) {
                                                        echo '<div class="label-industry">#'.$val->feature.'</div>';
                                                    }
                                                }
                                            };
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-check">
                                <input class="form-check-input form-check-input-click " type="checkbox" value="" name='looked' id="agency_flexCheckDefault<?= h($agency_information->agency_id); ?>">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- <div class="d-flex p-3 justify-content-center">
                    <a href="#applySection">
                        <button type="button" class="btn btn-success mt-5 position-fixed">比較に進む</button>
                    </a>
                </div> -->
            </div>
            <div class="main-right-content col-md-3 col-sm-3" name='rightContents'>
                <div class="mt-5">
                    <div class="search-title text-center w-75 m-auto p-1">
                        チェックした企業
                    </div>
                </div>
                <?php foreach ($agency_informations as $agency_information) : ?>
                    <a href="company.php?id=<?= h($agency_information->agency_id); ?>" class="text-decoration-none display-none" id="rightContent<?= h($agency_information->agency_id); ?>">
                        <div class="d-flex checked-content m-5 p-3">
                            <div class="me-2">
                                <img src="../uploaded_img/agency<?= h($agency_information->agency_id); ?>.png" alt="" class="right-img">
                            </div>
                            <div class="checked-paragraph">
                                <?= h($agency_information->agency_name); ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
                <div class="d-flex m-5 p-3">
                    <a href="#applySection">
                        <button type="button" class="btn btn-success" id="toCompare">選択した企業の比較に進む</button>
                    </a>
                </div>
            </div>
        </div>
    </main>
    <main class="w-100">
        <div class="text-center p-5 ms-5 me-5 compare " id="applySection">
            <div class="mt-3 mb-5 ms-5 me-5 title ">
                比較リスト
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <!-- <th scope="col"></th> -->
                            <th scope="col">エージェンシー</th>
                            <th scope="col">対応業種</th>
                            <th scope="col">サポート</th>
                            <th scope="col">求人エリア</th>
                            <th scope="col">面談場所</th>
                            <th scope="col">契約企業数</th>
                            <!-- <th scope="col">実績数</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agency_informations as $agency_information) : ?>
                            <tr id="comparison_agency<?= h($agency_information->agency_id); ?>" class="display-none">
                                <td>
                                    <button type="button" class="btn btn-success" id="comparisonDelete<?= h($agency_information->agency_id); ?>">削除</button>
                                </td>
                                <!-- <td>
                                <img id="comparisonDelete<?= h($agency_information->agency_id); ?>" src="../img/checked.png" alt="">
                            </td> -->
                                <!-- <td>
                                    <?= h($agency_information->agency_name); ?>
                                </td> -->
                                <th scope="row">
                                    <a href="company.php?id=<?= h($agency_information->agency_id); ?>">
                                        <img src="../uploaded_img/agency<?= h($agency_information->agency_id); ?>.png" alt="" class="center-img">
                                    </a>
                                </th>
                                <td>
                                    <?php

                                    if ($data = $agency_information->agency_id) {
                                        foreach ($agency_industry_comparison as $val) {
                                            if ($val->agency_id === $data) {
                                                echo '<div class="label-industry-comparison">#'.$val->industry.'</div>';
                                            }
                                        };
                                    } ?>
                                </td>
                                <td> <?php

                                        if ($data = $agency_information->agency_id) {
                                            foreach ($agency_feature_comparison as $val) {
                                                if ($val->agency_id === $data) {
                                                    if ($val->feature_id > 10) {
                                                        echo '<div class="label-industry-comparison">#'.$val->feature.'</div>';
                                                    }
                                                }
                                            };
                                        } ?>
                                </td>
                                <td><?= h($agency_information->achievements); ?></td>
                                <td><?= h($agency_information->bases_numbers); ?></td>
                                <td><?= h($agency_information->contract_numbers); ?></td>
                                <!-- <td><?= h($agency_information->support); ?></td> -->
                            </tr>
                        <?php endforeach; ?>
                        </thead>
                    <tbody>
                        <?php foreach ($agency_informations as $agency_information) : ?>
                            <tr id="comparison_agency<?= h($agency_information->agency_id); ?>" class="display-none">
                                <td>
                                    <button type="button" class="btn btn-success" id="comparisonDelete<?= h($agency_information->agency_id); ?>">削除</button>
                                </td>
                                <!-- <td>
                                    <img id="comparisonDelete<?= h($agency_information->agency_id); ?>" src="../img/checked.png" alt="">
                                </td> -->
                                <td>
                                    <?= h($agency_information->agency_name); ?>
                                </td>
                                <th scope="row">
                                    <a href="./company.html">
                                        <img src="../uploaded_img/agency<?= h($agency_information->agency_id); ?>.png" alt="" class="center-img">
                                    </a>
                                </th>
                                <td><?= h($agency_information->catch_copy); ?></td>
                                <td>○</td>
                                <td>✕</td>
                                <td>◯</td>
                                <td>✕</td>
                            </tr>
                            <a href="./company.html" class="text-decoration-none display-none" id="rightContent<?= h($agency_information->agency_id); ?>">
                                <div class="d-flex checked-content m-5 p-3">
                                    <div class="me-2">
                                        <img src="../uploaded_img/agency<?= h($agency_information->agency_id); ?>.png" alt="" class="right-img">
                                    </div>
                                    <div class="checked-paragraph">
                                        <?= h($agency_information->agency_name); ?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
            <a href="#navbarNavDropdown">
                <button type="button" class="btn btn-success mt-5">上に戻る</button>
            </a>
        </div>
        <div>
            <form class="text-center compare" action="check.php" method="post" id="inquiry">
                <div class=" m-auto mt-5 w-75 text-center title">
                    申し込みフォーム
                </div>
                <div>
                    <div>
                        <div class="form-group w-50 mt-3">
                            <label>お名前</label>
                            <input class="form-control" id="name" name="name" placeholder="例)クラフト太郎" required>
                        </div>
                        <div class="form-group w-50 mt-3">
                            <label>生年月日</label>
                            <input type="date"  class="form-control" id="birthday" name="birthday" required>
                        </div>
                        <div class="form-group w-50 mt-3">
                            <label>大学名</label>
                            <input class="form-control" id="university" name="university" placeholder="例)クラフト大学" required>
                        </div>
                        <div class="form-group w-50 mt-3">
                            <label>電話番号</label>
                            <input type="tel" pattern="[\d\-]*" class="form-control" id="phone-number" name="phone" placeholder="例)080-xxx-xxxx" required>
                        </div>
                        <div class="form-group w-50 mt-3">
                            <label>都道府県</label>
                            <select name="address" required class="form-control">
                                <option value="" selected>例)神奈川県</option>
                                <option value="北海道">北海道</option>
                                <option value="青森県">青森県</option>
                                <option value="岩手県">岩手県</option>
                                <option value="宮城県">宮城県</option>
                                <option value="秋田県">秋田県</option>
                                <option value="山形県">山形県</option>
                                <option value="福島県">福島県</option>
                                <option value="茨城県">茨城県</option>
                                <option value="栃木県">栃木県</option>
                                <option value="群馬県">群馬県</option>
                                <option value="埼玉県">埼玉県</option>
                                <option value="千葉県">千葉県</option>
                                <option value="東京都">東京都</option>
                                <option value="神奈川県">神奈川県</option>
                                <option value="新潟県">新潟県</option>
                                <option value="富山県">富山県</option>
                                <option value="石川県">石川県</option>
                                <option value="福井県">福井県</option>
                                <option value="山梨県">山梨県</option>
                                <option value="長野県">長野県</option>
                                <option value="岐阜県">岐阜県</option>
                                <option value="静岡県">静岡県</option>
                                <option value="愛知県">愛知県</option>
                                <option value="三重県">三重県</option>
                                <option value="滋賀県">滋賀県</option>
                                <option value="京都府">京都府</option>
                                <option value="大阪府">大阪府</option>
                                <option value="兵庫県">兵庫県</option>
                                <option value="奈良県">奈良県</option>
                                <option value="和歌山県">和歌山県</option>
                                <option value="鳥取県">鳥取県</option>
                                <option value="島根県">島根県</option>
                                <option value="岡山県">岡山県</option>
                                <option value="広島県">広島県</option>
                                <option value="山口県">山口県</option>
                                <option value="徳島県">徳島県</option>
                                <option value="香川県">香川県</option>
                                <option value="愛媛県">愛媛県</option>
                                <option value="高知県">高知県</option>
                                <option value="福岡県">福岡県</option>
                                <option value="佐賀県">佐賀県</option>
                                <option value="長崎県">長崎県</option>
                                <option value="熊本県">熊本県</option>
                                <option value="大分県">大分県</option>
                                <option value="宮崎県">宮崎県</option>
                                <option value="鹿児島県">鹿児島県</option>
                                <option value="沖縄県">沖縄県</option>
                            </select>
                        </div>
                        <div class="form-group w-50 mt-3">
                            <label for="exampleInputEmail1">メールアドレス</label>
                            <input type="email" name="email" id="email" class="text2 form-control" placeholder="例)xxx@example.com" required>
                        </div>
                        <div class="form-group w-50 mt-3">
                            <input type="checkbox" required>
                            <label for="exampleInputEmail1">入力内容を確認しました</label>
                        </div>
                        
                    </div>
                    <?php foreach ($agency_informations as $agency_information) : ?>
                        <input class="form-check-input" type="hidden" value="" name="agency<?= h($agency_information->agency_id); ?>" id="hidden_checkbox<?= h($agency_information->agency_id); ?>">
                    <?php endforeach; ?>
                    <div class="submit" id="submit-button">
                        <button type="submit" value="確認画面へ" id="form-button" class="btn btn-success mt-5 mb-5">
                            申し込み
                        </button>
                    </div>
            </form>
        </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../js/apply.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/toppage.js"></script>
</body>

</html>