<?php

// ーーー学生画面startーーーー

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function getPdoInstance()
{
    try {
        $pdo = new PDO(
            DSN,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

function get_agency_informations($pdo)
{
    $stmt = $pdo->query("SELECT * FROM agency_information");
    $agency_informations = $stmt->fetchAll();
    return $agency_informations;
}

function get_industry_conditions($pdo)
{
    $stmt = $pdo->query("SELECT * FROM industry_condition");
    $industry_conditions = $stmt->fetchAll();
    return $industry_conditions;
}

function get_major_conditions($pdo)
{
    $stmt = $pdo->query("SELECT * FROM major_condition");
    $major_conditions = $stmt->fetchAll();
    return $major_conditions;
}

function get_feature_conditions($pdo)
{
    $stmt = $pdo->query("SELECT * FROM feature_condition");
    $feature_conditions = $stmt->fetchAll();
    return $feature_conditions;
}

// ーーー学生画面endーーー

// ーーーエージェンシーstartーーー

function add_agency_information($pdo)
{

    echo'aaa';

    $agency_name = $_POST["agency_name"];
    $catch_copy = $_POST["catch_copy"];
    $detail = $_POST["detail"];
    $mail_address = $_POST["mail_address"];
    $phone_number = $_POST["phone_number"];
    $img = $_POST["img"];
    $achievements = $_POST["achievements"];
    $contract_numbers = $_POST["contract_numbers"];

    $stmt = $pdo->prepare('INSERT INTO agency_information(agency_name,catch_copy,detail,mail_address,phone_number,img,achievements,contract_numbers,bases_numbers,support,place,industry_id,major_id,feature_id) VALUES(
        :agency_name,
        :catch_copy,
        :detail,
        :mail_address,
        :phone_number,
        :img,
        :achievements,
        :contract_numbers,
        "r",
        "r",
        "r",
        0,
        0,
        0
)');

$stmt->bindValue(':agency_name', $agency_name);
$stmt->bindValue(':catch_copy', $catch_copy);
$stmt->bindValue(':detail', $detail);
$stmt->bindValue(':mail_address', $mail_address);
$stmt->bindValue(':phone_number', $phone_number);
$stmt->bindValue(':img', $img);
$stmt->bindValue(':achievements', $achievements);
$stmt->bindValue(':contract_numbers', $contract_numbers);

$stmt->execute();
}