<?php

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

// ーーーエージェンシーstartーーー

function add_agency_information($pdo)
{
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