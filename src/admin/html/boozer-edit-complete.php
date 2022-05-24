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
// $stmt = $pdo->prepare("DELETE FROM agency_information WHERE id = :id");
// $stmt->bindValue(':id', $id);
// $res = $stmt->execute();

// }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>編集完了</title>
</head>

<body>
    <p>
        <a href="boozer-agency.php">エージェンシー情報へ</a>
    </p>
</body>

</html>