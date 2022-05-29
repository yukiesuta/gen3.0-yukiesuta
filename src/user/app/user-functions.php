<?php

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



function agency_information($pdo)
{

    if (isset($_POST['industry1'])) {
        $industrys[] = 1;
    }
    if (isset($_POST['industry2'])) {
        $industrys[] = 2;
    }
    if (isset($_POST['industry3'])) {
        $industrys[] = 3;
    }
    if (isset($_POST['industry4'])) {
        $industrys[] = 4;
    }
    if (isset($_POST['industry5'])) {
        $industrys[] = 5;
    }
    if (isset($_POST['industry6'])) {
        $industrys[] = 6;
    }
    if (isset($_POST['industry7'])) {
        $industrys[] = 7;
    }


    if (isset($_POST['major1'])) {
        $industrys[] = 8;
    }
    if (isset($_POST['major2'])) {
        $industrys[] = 9;
    }


    if (isset($_POST['feature1'])) {
        $industrys[] = 10;
    }
    if (isset($_POST['feature2'])) {
        $industrys[] = 11;
    }
    if (isset($_POST['feature3'])) {
        $industrys[] = 12;
    }
    if (isset($_POST['feature4'])) {
        $features[] = 13;
    }
    if (isset($_POST['feature5'])) {
        $industrys[] = 14;
    }

    if (isset($industrys)) {
        $result = implode(',', $industrys);
        // print_r($result);
        return $result;
    }
};
