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
    $manager = $_POST["manager"];
    $phone_number = $_POST["phone_number"];


    $uploading_img = $_FILES["img"];


    $filename = basename($uploading_img["name"]);

    $unit_price = $_POST["unit_price"];
    $achievements = $_POST["achievements"];
    $contract_numbers = $_POST["contract_numbers"];
    $bases_numbers = $_POST["bases_numbers"];
    $support = $_POST["support"];
    // $place = $_POST["place"];


    if (isset($_POST['industry1'])) {
        $industrys[] = 1;
        $industry_comparison[] = 1;
       
    }
    if (isset($_POST['industry2'])) {
        $industrys[] = 2;
        $industry_comparison[] = 2;
       
    }
    if (isset($_POST['industry3'])) {
        $industrys[] = 3;
        $industry_comparison[] = 3;
                
    }
    if (isset($_POST['industry4'])) {
        $industrys[] = 4;
        $industry_comparison[] = 4;
        
    }
    if (isset($_POST['industry5'])) {
        $industrys[] = 5;
        $industry_comparison[] = 5;
        
    }
    if (isset($_POST['industry6'])) {
        $industrys[] = 6;
        $industry_comparison[] = 6;
      
    }
    if (isset($_POST['industry7'])) {
        $industrys[] = 7;
        $industry_comparison[] = 7;
        
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
        $industrys[] = 13;
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
        manager,
        phone_number,
        img,
        unit_price,
        achievements,
        contract_numbers,
        bases_numbers,
        support,
        -- place,
        claim_status
        ) VALUES(
        :agency_name,
        :catch_copy,
        :detail,
        :mail_address,
        :manager,
        :phone_number,
        :img,
        :unit_price,
        :achievements,
        :contract_numbers,
        :bases_numbers,
        :support,
        -- :place,
        :claim_status
    )');

    $stmt->bindValue(':agency_name', $agency_name);
    $stmt->bindValue(':catch_copy', $catch_copy);
    $stmt->bindValue(':detail', $detail);
    $stmt->bindValue(':mail_address', $mail_address);
    $stmt->bindValue(':manager', $manager);
    $stmt->bindValue(':phone_number', $phone_number);
    $stmt->bindValue(':img', $filename);
    $stmt->bindValue(':unit_price', $unit_price);
    $stmt->bindValue(':achievements', $achievements);
    $stmt->bindValue(':contract_numbers', $contract_numbers);
    $stmt->bindValue(':bases_numbers', $bases_numbers);
    $stmt->bindValue(':support', $support);
    // $stmt->bindValue(':place', $place);
    $stmt->bindValue(':claim_status', 0);


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

    foreach($industry_comparison as $industry){
        $stmt = $pdo->prepare('INSERT INTO agency_industry(
            agency_id,
            industry_id
            ) VALUES(
            :id,
            :industry_id
    
        )');
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':industry_id', $industry);
        $stmt->execute();
    }
 



    $stmt = $pdo->query("SELECT MAX(id) FROM agency_information");
    $now_id = $stmt->fetch(PDO::FETCH_ASSOC);
    $temp_path = $uploading_img['tmp_name'];
    $file_err = $uploading_img['error'];
    $filesize = $uploading_img['size'];
    $upload_dir = __DIR__ . '/../../user/uploaded_img/agency' . $now_id['MAX(id)'] . '.png';

    $allow_ext = array('jpg', 'jpeg', 'png');
 
    $temp_path = $uploading_img['tmp_name'];
    move_uploaded_file($temp_path, $upload_dir);
  
}
function edit_agency_information($pdo)
{
    $agency_name = $_POST["agency_name"];
    $catch_copy = $_POST["catch_copy"];
    $detail = $_POST["detail"];
    $mail_address = $_POST["mail_address"];
    $manager = $_POST["manager"];
    $phone_number = $_POST["phone_number"];


    $unit_price = $_POST["unit_price"];
    $achievements = $_POST["achievements"];
    $contract_numbers = $_POST["contract_numbers"];

    $stmt = $pdo->prepare('UPDATE agency_information SET
        agency_name = :agency_name,
        catch_copy = :catch_copy,
        detail = :detail,
        mail_address = :mail_address,
        manager = :manager,
        phone_number = :phone_number,
        unit_price = :unit_price,
        achievements = :achievements,
        contract_numbers = :contract_numbers 
        WHERE id = :id');
    $stmt->bindParam(':agency_name', $agency_name);

    $stmt->execute(array(
        ':agency_name' => $_POST['agency_name'],
        ':catch_copy' => $_POST['catch_copy'],
        ':detail' => $_POST['detail'],
        ':mail_address' => $_POST['mail_address'],
        ':manager' => $_POST['manager'],
        ':phone_number' => $_POST['phone_number'],
        ':unit_price' => $_POST['unit_price'],
        ':achievements' => $_POST['achievements'],
        ':contract_numbers' => $_POST['contract_numbers'],
        ':id' => $_GET["id"]
    ));
    echo '情報を更新しました';
}


function get_agency_informations($pdo)
{
    $stmt = $pdo->query("SELECT * FROM agency_information");
    $agency_informations = $stmt->fetchAll();
    return $agency_informations;
}

// 使わないかも
function get_student_informations($pdo)
{
    $stmt = $pdo->query("SELECT * FROM inquiry");
    $agency_informations = $stmt->fetchAll();
    return $agency_informations;
}
function get_inquiry_agency_informations($pdo)
{
    $stmt = $pdo->query("SELECT * FROM inquiry_agency");
    $agency_informations = $stmt->fetchAll();
    return $agency_informations;
}


// 編集画面 エージェンシー情報削除
function agency_delete($pdo){
    $id = $_GET["id"];
    $stmt = $pdo->prepare("DELETE FROM agency_information WHERE id = :id" );
    $stmt->bindValue(':id', $id);
    $res = $stmt->execute();
}

function student_delete($pdo){
    $cryptography = $_POST["cryptography"];
    $stmt = $pdo->prepare("DELETE FROM inquiry WHERE cryptography = :cryptography" );
    $stmt->bindValue(':cryptography', $cryptography);
    $stmt->execute();

    $stmt = $pdo->prepare("DELETE FROM inquiry_agency WHERE cryptography = :cryptography" );
    $stmt->bindValue(':cryptography', $cryptography);
    $stmt->execute();

    echo '削除しました。もう一度再更新すると反映されます。';
}




function edit_agency_claim_status($pdo)
{
    $claim_status_arr = [
        '未請求',
        '請求済み',
        '入金済み',
        '入金遅滞',
        '請求不能'
    ];
    $claim_status = $_POST["claim_status"];
    $id = $_POST["id"];
    $agency_name = $_POST["agency_name"];
    
    $stmt = $pdo->prepare('UPDATE agency_information SET
        claim_status = :claim_status
        WHERE id = :id');

    $stmt->execute(array(
        ':claim_status' => $claim_status,
        ':id' => $id
    ));

    echo $agency_name;
    echo 'の請求ステータスを';
    echo $claim_status_arr[$claim_status];
    echo 'に更新しました';
}


function edit_progress($pdo)
{
    $claim_status_arr = [
        '状況１',
        '状況２',
        '状況3',
        '状況4',
        '状況5'
    ];
    $progress = $_POST["progress"];
    $agency_id = $_POST["agency_id"];
    $cryptography = $_POST["cryptography"];
    $name = $_POST["name"];
    
    $stmt = $pdo->prepare('UPDATE inquiry_agency SET
        progress = :progress
        WHERE agency_id = :agency_id && cryptography = :cryptography');

    $stmt->execute(array(
        ':progress' => $progress,
        ':agency_id' => $agency_id,
        ':cryptography'=>$cryptography
    ));
    echo $name;
    echo 'の進行状況を';
    echo $progress;
    echo 'へ更新しました';
}
