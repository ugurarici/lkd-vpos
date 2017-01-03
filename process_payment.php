<?php
require "vendor/autoload.php";

//	bulmaca çözümü SESSION'da saklandığı için session'ı başlatıyoruz
session_start();
$captchaAnswer = $_SESSION['captchaPhrase'];
//	session_destroy();

//	kullanıcının girdiği bulmaca yanıtı doğru değilse hata verip geri dönelim
if( $_POST["captcha"] !== $captchaAnswer ) die( "Bulmaca yanıtı yanlış" );

$normalizedCardNumber = str_replace(" ", "", $_POST['cardNo']);
$expirtyDate = explode(" / ", $_POST['cardExpiryDate']);
$amount = floatval(str_replace(',', '.', $_POST['amount']));

try {
	$payment = new Payment(array(
		"userName" => $_POST['name'],
		"userSurname" => $_POST['surname'],
		"userPhone" => $_POST['phone'],
		"userEmail" => $_POST['email'],
		"userAddress" => $_POST['address'],
		"paymentType" => $_POST['payment_type'],
		"paymentDescription" => $_POST['description'],
		"amount" => $amount,	
		"cardNumber" => $normalizedCardNumber,
		"cardExpirtyMonth" => $expirtyDate[0],
		"cardExpirtyYear" => $expirtyDate[1],
		"cardCVV" => $_POST['cardCVC'],
		));
} catch (Exception $e) {
	die(var_dump($e));
}