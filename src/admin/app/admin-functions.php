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


    $uploading_img = $_FILES["img"];


    $filename = basename($uploading_img["name"]);

    $achievements = $_POST["achievements"];
    $contract_numbers = $_POST["contract_numbers"];
    $bases_numbers = $_POST["bases_numbers"];
    $support = $_POST["support"];
    $place = $_POST["place"];


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

// print_r($industrys);
    






    $stmt = $pdo->prepare('INSERT INTO agency_information(
        agency_name,
        catch_copy,
        detail,
        mail_address,
        phone_number,
        img,
        achievements,
        contract_numbers,
        bases_numbers,
        support,
        place
        ) VALUES(
        :agency_name,
        :catch_copy,
        :detail,
        :mail_address,
        :phone_number,
        :img,
        :achievements,
        :contract_numbers,
        :bases_numbers,
        :support,
        :place
    )');

    $stmt->bindValue(':agency_name', $agency_name);
    $stmt->bindValue(':catch_copy', $catch_copy);
    $stmt->bindValue(':detail', $detail);
    $stmt->bindValue(':mail_address', $mail_address);
    $stmt->bindValue(':phone_number', $phone_number);
    $stmt->bindValue(':img', $filename);
    $stmt->bindValue(':achievements', $achievements);
    $stmt->bindValue(':contract_numbers', $contract_numbers);
    $stmt->bindValue(':bases_numbers', $bases_numbers);
    $stmt->bindValue(':support', $support);
    $stmt->bindValue(':place', $place);


    // echo $stmt;

    $stmt->execute();



    $id = $pdo -> lastInsertId();
    // printf($id);
    
    foreach($industrys as $industry){
        $stmt = $pdo->prepare('INSERT INTO agency_feature(
            agency_id,
            feature_id
            ) VALUES(
            :id,
            :feature_id
    
        )');
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':feature_id', $industry);
        $stmt->execute();
        

    }
 



    $stmt = $pdo->query("SELECT MAX(id) FROM agency_information");
    $now_id = $stmt->fetch(PDO::FETCH_ASSOC);
    $temp_path = $uploading_img['tmp_name'];
    $file_err = $uploading_img['error'];
    $filesize = $uploading_img['size'];
    $upload_dir = __DIR__ . '/../../user/uploaded_img/agency' . $now_id['MAX(id)'] . '.png';

    $allow_ext = array('jpg', 'jpeg', 'png');
    // $file_ext = pathinfo($uploading_img,PATHINFO_EXTENSION);

    // if(!in_array(strtolower($file_ext),$allow_ext)){
    // echo '画像ファイルを送ってください';
    // }elseif($filesize > 100000000){
    // echo 'データがデカすぎる';
    // }else{
    $temp_path = $uploading_img['tmp_name'];
    move_uploaded_file($temp_path, $upload_dir);
    // echo '成功';
    // echo $file_err;
    // }
}
function edit_agency_information($pdo)
{
    $agency_name = $_POST["agency_name"];
    $catch_copy = $_POST["catch_copy"];
    $detail = $_POST["detail"];
    $mail_address = $_POST["mail_address"];
    $phone_number = $_POST["phone_number"];


    $achievements = $_POST["achievements"];
    $contract_numbers = $_POST["contract_numbers"];

    $stmt = $pdo->prepare('UPDATE agency_information SET
        agency_name = :agency_name,
        catch_copy = :catch_copy,
        detail = :detail,
        mail_address = :mail_address,
        phone_number = :phone_number,
        achievements = :achievements,
        contract_numbers = :contract_numbers 
        WHERE id = :id');
    $stmt->bindParam(':agency_name', $agency_name);

    $stmt->execute(array(
        ':agency_name' => $_POST['agency_name'],
        ':catch_copy' => $_POST['catch_copy'],
        ':detail' => $_POST['detail'],
        ':mail_address' => $_POST['mail_address'],
        ':phone_number' => $_POST['phone_number'],
        ':achievements' => $_POST['achievements'],
        ':contract_numbers' => $_POST['contract_numbers'],
        ':id' => $_GET["id"]
    ));

    echo $agency_name;

    echo '情報を更新しました';
}


function get_agency_informations($pdo)
{
    $stmt = $pdo->query("SELECT * FROM agency_information");
    $agency_informations = $stmt->fetchAll();
    return $agency_informations;
}
