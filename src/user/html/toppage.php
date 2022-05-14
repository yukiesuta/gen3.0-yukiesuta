<?php

// echo 'わーーーひらけたーー';

require_once(__DIR__  . '/../app/config.php');

$pdo = getPdoInstance();

$agency_informations = get_agency_informations($pdo);
$industry_conditions = get_industry_conditions($pdo);
$major_conditions = get_major_conditions($pdo);
$feature_conditions = get_feature_conditions($pdo);

if (isset($_POST["sort_change"])) {
    // セレクトボックスで選択された値を受け取る
    $sort_change = $_POST["sort_change"];
    // 受け取った値を画面に出力
    echo $sort_change;
}

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

        <div class="navigations mt-4">
            <ul class="d-flex justify-content-center mb-0">
                <a href="" class="navigation me-5">
                    <li>就活サイト</li>
                </a>
                <a href="" class="navigation me-5">
                    <li>就活支援サービス</li>
                </a>
                <a href="" class="navigation me-5">
                    <li>自己分析診断ツール</li>
                </a>
                <a href="" class="navigation me-5">
                    <li>ES添削サービス</li>
                </a>
                <a href="" class="navigation me-5">
                    <li>就活エージェント</li>
                </a>
                <a href="" class="navigation me-5">
                    <li>就職の教科書とは</li>
                </a>
                <a href="" class="navigation me-5">
                    <li>お問い合わせ</li>
                </a>
            </ul>
        </div>
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
            <div class="main-center-content col-md-6 col-sm-9">
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
                <?php foreach ($agency_informations as $agency_information) : ?>
                    <div class="mt-4 ms-5 me-5 mb-5 p-3 company-content-wrapper">
                        <div class="d-flex company-content">
                            <a href="company.php?id=<?= h($agency_information->id); ?>">
                                <div class="logo-container p-1">
                                    <img src="../uploaded_img/agency<?= h($agency_information->id); ?>.png" alt="" class="center-img">
                                </div>
                            </a>
                            <div>
                                <a href="company.php?id=<?= h($agency_information->id); ?>" class="text-decoration-none">
                                    <div class="company-content-title p-1"><?= h($agency_information->agency_name); ?></div>
                                </a>
                                <div class="p-3 company-content-paragraph">
                                    <?= h($agency_information->catch_copy); ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name='looked' id="agency_flexCheckDefault<?= h($agency_information->id); ?>">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="main-right-content col-md-3 col-sm-3" name='rightContents'>
                <?php foreach ($agency_informations as $agency_information) : ?>
                    <a href="./company.html" class="text-decoration-none display-none" id="rightContent<?= h($agency_information->id); ?>">
                        <div class="d-flex checked-content m-5 p-3">
                            <div class="me-2">
                                <img src="../uploaded_img/agency<?= h($agency_information->id); ?>.png" alt="" class="right-img">
                            </div>
                            <div class="checked-paragraph">
                                <?= h($agency_information->agency_name); ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="d-flex justify-content-center icons">
            <a href="">
                <span class="material-icons">
                    navigate_before
                </span>
            </a>
            <a href="" class="m-1">
                <div>
                    1
                </div>
            </a>
            <a href="" class="m-1">
                <div>
                    2
                </div>
            </a>
            <a href="" class="m-1">
                <div>
                    3
                </div>
            </a>
            <a href="">
                <span class="material-icons">
                    navigate_next
                </span>
            </a>
        </div>
        <div class="text-center">
            <a href="">
                <a href="apply.php">
                <button type="button" class="btn btn-success m-5" onclick="checked_check()">
                    比較する
                </button>
            </a>
            </a>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../js/toppage.js"></script>
    <script>
    function checked_check(){

        arr = new Array()

        <?php foreach ($agency_informations as $agency_information) : ?>
            if(document.getElementById("flexCheckDefault<?= h($agency_information->id); ?>").checked){
                arr.push('<?= h($agency_information->id); ?>');
            }
        <?php endforeach; ?>
        console.log(arr);
        let json = JSON.stringify(arr);
        localStorage.setItem('keyname', arr);
    }
    </script>
</body>

</html>