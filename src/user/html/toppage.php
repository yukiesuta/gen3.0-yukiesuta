<?php



require_once(__DIR__  . '/../app/config.php');

$pdo = getPdoInstance();

$agency_informations = get_agency_informations($pdo);
$industry_conditions = get_industry_conditions($pdo);
$major_conditions = get_major_conditions($pdo);
$feature_conditions = get_feature_conditions($pdo);



print_r($agency_informations);
$ids = [1,2];
// $ids1 = [1];
// $ids2 = [1];

// IN 句に入る値を作成
$inClause = substr(str_repeat(',?', count($ids)), 1);
// $inClause1 = substr(str_repeat(',?', count($ids1)), 1);
// $inClause2= substr(str_repeat(',?', count($ids2)), 1);


// $stmt = $pdo->prepare("SELECT * FROM agency_information 
// JOIN agency_industry AS itt ON  agency_information.id = itt.agency_id
// JOIN industry_condition ON itt.industry_id = industry_condition.id
// JOIN agency_major AS ittt ON  agency_information.id = ittt.agency_id
// JOIN major_condition ON ittt.major_id = major_condition.id
// JOIN agency_feature AS itti ON  agency_information.id = itti.agency_id
// JOIN feature_condition ON itti.feature_id = feature_condition.id
// WHERE industry_condition.id IN ({$inClause})  AND major_condition.id IN (1) AND feature_condition.id IN (1) 
// -- GROUP BY agency_information.id
// ");
$stmt = $pdo->prepare("SELECT * FROM agency_information 
JOIN agency_feature AS itt ON  agency_information.id = itt.agency_id
JOIN features ON itt.feature_id = features.id
WHERE features.id IN ({$inClause})
-- GROUP BY agency_information.agency_name
");

$stmt->execute($ids);

$agency_informations = $stmt->fetchAll();
// print_r($agency_informations);


$tmp = [];
$uniqueStations = [];

foreach ($agency_informations as $station){
    if (!in_array($station ->agency_name, $tmp)) {
        $tmp[] = $station ->agency_name;
        $uniqueStations[] = $station;
    }
}

print_r($uniqueStations);



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
                    <div id="modal-content">
                        <div class="modal-body row">
                            <div class="mobile-top-content">
                                <div class="mt-4 search ms-2 p-2">
                                    <div class="search-title text-center">業種</div>
                                    <?php foreach ($industry_conditions as $industry_condition) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="ph_industry_flexCheckDefault<?= h($industry_condition->id); ?>">
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
                                            <input class="form-check-input" type="checkbox" value="" id="ph_major_flexCheckDefault <?= h($major_condition->id); ?>">
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
                                            <input class="form-check-input" type="checkbox" value="" id="ph_feature_flexCheckDefault<?= h($feature_condition->id); ?>">
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
                            <button type="button" class="btn btn-success col-8 justify-content-center mt-2 mb-3" id="submitButton">絞り込み</button>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-container raw">
            <div class="main-left-content col-md-3">
                <div class="mt-5 ms-5 me-5 p-3 search">
                    <div class="search-title p-1 text-center">業種</div>
                    <?php foreach ($industry_conditions as $industry_condition) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="pc_industry_flexCheckDefault<?= h($industry_condition->id); ?>">
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
                            <input class="form-check-input" type="checkbox" value="" id="pc_major_flexCheckDefault<?= h($major_condition->id); ?>">
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
                            <input class="form-check-input" type="checkbox" value="" id="pc_feature_flexCheckDefault<?= h($feature_condition->id); ?>">
                            <label class="form-check-label" for="flexCheckDefault">
                                <?= h($feature_condition->feature); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="main-center-content col-md-6 col-12">
                <!-- <div class="mt-3 text-center drop-down p-1">
                    <div>並び替え</div>
                        <form action="toppage.php" method = "POST">
                        <select name="sort_change">
                            <option value="name">五十音</option>
                            <option value="bases_numbers">拠点数</option>
                            <option value="achievements">実績数</option>
                            <option value="contract_numbers">契約数</option>
                        </select>
                        <input type="submit"name="submit"value="並べ替える"/>
                    </form>
                </div> -->
                <?php foreach ( $uniqueStations as $agency_information) : ?>
                    <div class="mt-4 ms-5 me-5 mb-5 p-3 company-content-wrapper">
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
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name='looked' id="agency_flexCheckDefault<?= h($agency_information->agency_id); ?>">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="main-right-content col-md-3 col-sm-3" name='rightContents'>
                <?php foreach ($agency_informations as $agency_information) : ?>
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
                <div class="d-flex m-5 p-3">
                    <a href="#applySection">
                        <button type="button" class="btn btn-success mt-5">次へ</button>
                    </a>
                </div>
            </div>
        </div>
    </main>
    <main class="w-100">
        <div class="text-center p-5 ms-5 me-5 compare" id="applySection">
            <div class="mt-3 mb-5 ms-5 me-5 title ">
                比較リスト
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">エージェンシー</th>
                            <th scope="col">得意業界</th>
                            <th scope="col">ES添削</th>
                            <th scope="col">面接対策</th>
                            <th scope="col">即日連絡</th>
                            <th scope="col">担当者変更</th>
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
                <div class=" mb-3 ms-5 me-5 mt-5 text-center title">
                    申し込みフォーム
                </div>
                <div>
                    <div class="form-group w-50 mt-3">
                        <label>お名前</label>
                        <input class="form-control" id="name" name="name" placeholder="お名前をご入力ください">
                    </div>
                    <div class="form-group w-50 mt-3">
                        <label>生年月日</label>
                        <input class="form-control" id="birthday" name="birthday" placeholder="お名前をご入力ください">
                    </div>
                    <div class="form-group w-50 mt-3">
                        <label>大学名</label>
                        <input class="form-control" id="university" name="university" placeholder="大学名をご入力ください">
                    </div>
                    <div class="form-group w-50 mt-3">
                        <label>電話番号</label>
                        <input class="form-control" id="phone-number" name="phone" placeholder="電話番号をご入力ください">
                    </div>
                    <div class="form-group w-50 mt-3">
                        <label>住所</label>
                        <input class="form-control" id="address" placeholder="住所をご入力ください" name="address">
                    </div>
                    <div class="form-group w-50 mt-3">
                        <label for="exampleInputEmail1">メールアドレス</label>
                        <input type="text" name="email" id="email" class="text2 form-control" placeholder="xxx@example.com">
                    </div>
                </div>
                <?php foreach ($agency_informations as $agency_information) : ?>
                    <input class="form-check-input" type="checkbox" value="" name="agency<?= h($agency_information->agency_id); ?>" id="hidden_checkbox<?= h($agency_information->agency_id); ?>">
                <?php endforeach; ?>
                <div class="submit" id="submit-button">
                        <button type="submit" value="確認画面へ" id="form-button" class="btn btn-success mt-5 unclick">
                            申し込み
                        </button>
                </div>
            </form>
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