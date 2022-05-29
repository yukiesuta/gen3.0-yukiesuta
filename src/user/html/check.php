<?php


$dsn = 'mysql:host=db;dbname=shukatsu;charset=utf8;';
$user = 'root';
$password = 'password';

try {
	$db = new PDO($dsn, $user, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo '接続失敗: ' . $e->getMessage();
	exit();
}

require_once(__DIR__  . '/../app/config.php');

$pdo = getPdoInstance();

$db->query('SET NAMES utf8');

$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$birthday = $_POST['birthday'];
$university = $_POST['university'];
$cryptography = $_POST['cryptography'];
$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$birthday = htmlspecialchars($birthday);
$address = htmlspecialchars($address);
$phone = htmlspecialchars($phone);
$university = htmlspecialchars($university);


$sql = 'INSERT INTO inquiry(name,birthday,university,phone,address,email,cryptography)VALUES("' . $name . '","' . $birthday . '","' . $university . '","' . $phone . '","' . $address . '","' . $email . '","' . $cryptography . '")';
$stmt = $db->prepare($sql);
$stmt->execute();



$agencys = array();

for ($i = 1; $i < 100; $i++) {
	if (isset($_POST['agency' . $i . ''])) {
		$sql = 'INSERT INTO inquiry_agency(cryptography,agency_id,progress)VALUES("' . $cryptography . '","' . $i . '","0")';
		$stmt = $db->prepare($sql);
		$stmt->execute();

		$stmt = $pdo->query("SELECT * FROM agency_information WHERE id =$i ");
		$stmt->execute();
		$inquiry_agency = $stmt->fetchAll();

		foreach ($inquiry_agency as $agency) {
			$mail_address = $agency->mail_address;

			$mail_sub = 'お問い合わせを受け付けました。';
			$mail_body = $name . '様、ご協力ありがとうございました。';
			$mail_body = html_entity_decode($mail_body, ENT_QUOTES, "UTF-8");
			$from = 'test@test.com';
			$mail_header = "From: {$from}\nReply-To: {$from}\nContent-Type: text/plain;";

			if (mb_send_mail($mail_address, $mail_sub, $mail_body, $mail_header, "-f test@test.com")) {
			} else {
			};
		};
	}
}
$mail_sub = 'お問い合わせを受け付けました。';
$mail_body = $name . '様、ご協力ありがとうございました。';
$mail_body = html_entity_decode($mail_body, ENT_QUOTES, "UTF-8");
$from = 'test@test.com';
$mail_header = "From: {$from}\nReply-To: {$from}\nContent-Type: text/plain;";
if (mb_send_mail($email, $mail_sub, $mail_body, $mail_header, "-f test@test.com")) {
} else {
};

$mail_sub_student = 'お問い合わせを受け付けました。';
$mail_body_student = 'クラフトにて学生の申し込みがありました。';
$mail_body_student = html_entity_decode($mail_body_student, ENT_QUOTES, "UTF-8");
// $from = 'test@test.com';
$mail_header_student = "From: {$name}\nReply-To: {$name}\nContent-Type: text/plain;";

if (mb_send_mail($from, $mail_sub_student, $mail_body_student, $mail_header_student)) {
} else {
};
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>申し込み完了</title>
	<link rel="stylesheet" href="../css/normalize.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/thanks.css">

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
		<div class="thanks-container">
			<img src="../img/people-gc8c838c19_1280.png" alt="thanks" class="thanks-img mt-4">
			<div class="mt-3 fs-3">お申込ありがとうございます。入力が完了致しました。</div>
			<div class="mt-3 fs-5">
				<div class="mt-1">お申込み先のエージェンシーよりご入力いただいたアドレスへと順次ご連絡がございます。</div>
				<div class="mt-1">システムによる自動送信にて、申込み完了メールを送付しております。</div>
				<div class="mt-1">受付完了メールが届かない場合、数日経ってもエージェンシーより連絡がない場合は<br>お手数をおかけいたしますが以下のアドレスまでご連絡ください。</div>
			</div>
			<div class="mt-3">
				<div class="fs-5">本サービスの改善、認知向上のためSNSでの共有にもご協力いただけますと幸いです。</div>
				<div class="mt-3">
					<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false" data-text="就活エージェントマッチングサービス　Craft" data-size="large" data-url="URL">Tweet</a>
				</div>
			</div>
			<div>
				<a href="toppage.php">
					<button type="button" class="btn btn-success mt-3">トップページに戻る</button>
				</a>
			</div>
		</div>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</body>

</html>