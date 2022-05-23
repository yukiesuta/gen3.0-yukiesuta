<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<title>確認画面</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div id="inquiry">
		<h2>確認画面</h2>
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
		$name = htmlspecialchars($name);
		$email = htmlspecialchars($email);
		$birthday = htmlspecialchars($birthday);
		$address = htmlspecialchars($address);
		$phone = htmlspecialchars($phone);
		$university = htmlspecialchars($university);

		echo '<ul>' . "\n";
		echo '<li>';
		if ($name == '') {
			echo 'お名前が入力されていません。<br>' . "\n";
		} else {
			echo 'お名前：' . $name . '<br>' . "\n";
		}
		echo '</li>' . "\n";
		echo '<li>';
		if ($email == '') {
			echo 'メールアドレスが、入力されていません。<br>' . "\n";
		} else {
			echo 'メールアドレス：' . $email . '<br>' . "\n";
		}
		echo '</li>' . "\n";
		echo '<li>';
		if ($address == '') {
			echo 'お問い合わせの内容が、入力されていません。<br>' . "\n";
		} else {
			echo 'お問い合わせの内容：' . $address . "\n";
		}
		echo '</li>' . "\n";
		echo '<li>';
		if ($university == '') {
			echo 'お問い合わせの内容が、入力されていません。<br>' . "\n";
		} else {
			echo 'お問い合わせの内容：' . $university . "\n";
		}
		echo '</li>' . "\n";
		echo '<li>';
		if ($phone == '') {
			echo 'お問い合わせの内容が、入力されていません。<br>' . "\n";
		} else {
			echo 'お問い合わせの内容：' . $phone . "\n";
		}
		echo '</li>' . "\n";
		echo '<li>';
		if ($birthday == '') {
			echo 'お問い合わせの内容が、入力されていません。<br>' . "\n";
		} else {
			echo 'お問い合わせの内容：' . $birthday . "\n";
		}
		echo '</li>' . "\n";
		echo '</ul>' . "\n";

		$sql = 'INSERT INTO inquiry(name,birthday,university,phone,address,email)VALUES("' . $name . '","' . $birthday . '","' . $university . '","' . $phone . '","' . $address . '","' . $email . '")';
		$stmt = $db->prepare($sql);
		$stmt->execute();



		$agencys = array();

		for ($i = 1; $i < 100; $i++) {
			if (isset($_POST['agency' . $i . ''])) {
				$sql = 'INSERT INTO inquiry_agency(phone,agency_id,progress)VALUES("' . $phone . '","' . $i . '","0")';
				$stmt = $db->prepare($sql);
				$stmt->execute();

				$stmt = $pdo->query("SELECT * FROM agency_information WHERE id =$i ");
				$stmt->execute();
				$inquiry_agency = $stmt->fetchAll();

				foreach ($inquiry_agency as $agency) {
					$mail_address = $agency->mail_address;
					print_r($mail_address);



					echo $name . '様<br>' . "\n";
					echo 'お問い合わせ、ありがとうございました。<br>' . "\n";
					echo 'お問い合わせ内容『' . $university . '』を<br>' . "\n";
					echo $email . 'にメールで送りましたのでご確認ください。' . "\n";

					$mail_sub = 'お問い合わせを受け付けました。';
					$mail_body = $name . '様、ご協力ありがとうございました。';
					$mail_body = html_entity_decode($mail_body, ENT_QUOTES, "UTF-8");
					$from = 'test@test.com';
					// $mail_header .= "MIME-Version: 1.0\n";
					// $mail_header .= "Content-Transfer-Encoding: BASE64\n";
					// $mail_header .= "Content-Type: text/plain; charset=UTF-8\n";
					$mail_header = "From: {$from}\nReply-To: {$from}\nContent-Type: text/plain;";


					mb_language('Japanese');
					mb_internal_encoding("UTF-8");

					if (mb_send_mail($mail_address, $mail_sub, $mail_body, $mail_header, "-f test@test.com")) {
						echo "メールを送信しました";
					} else {
						echo "メールの送信に失敗しました";
					};
				};
			}
		}

		// echo $name . '様<br>' . "\n";
		// echo 'お問い合わせ、ありがとうございました。<br>' . "\n";
		// echo 'お問い合わせ内容『' . $university . '』を<br>' . "\n";
		// echo $email . 'にメールで送りましたのでご確認ください。' . "\n";

		$mail_sub = 'お問い合わせを受け付けました。';
		$mail_body = $name . '様、ご協力ありがとうございました。';
		$mail_body = html_entity_decode($mail_body, ENT_QUOTES, "UTF-8");
		$from = 'test@test.com';
		// $mail_header .= "MIME-Version: 1.0\n";
		// $mail_header .= "Content-Transfer-Encoding: BASE64\n";
		// $mail_header .= "Content-Type: text/plain; charset=UTF-8\n";
		$mail_header = "From: {$from}\nReply-To: {$from}\nContent-Type: text/plain;";


		mb_language('Japanese');
		mb_internal_encoding("UTF-8");

		if (mb_send_mail($email, $mail_sub, $mail_body, $mail_header, "-f test@test.com")) {
			echo "メールを送信しました";
		} else {
			echo "メールの送信に失敗しました";
		};



		// echo phpinfo();

		?>
		<a href="../html/thanks.html">
			<button type="button" class="btn btn-success mt-5">上記で申し込む</button>
		</a>
	</div>
</body>

</html>