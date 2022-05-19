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