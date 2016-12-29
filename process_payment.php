<?php
require "vendor/autoload.php";
function ccMasking($number, $maskingCharacter = '*') {
	return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
}

//	bulmaca çözümü SESSION'da saklandığı için session'ı başlatıyoruz
session_start();
$captchaAnswer = $_SESSION['captchaPhrase'];
//	session_destroy();

//	kullanıcının girdiği bulmaca yanıtı doğru değilse hata verip geri dönelim
if( $_POST["captcha"] !== $captchaAnswer ) die( "Bulmaca yanıtı yanlış" );

echo "Yaşasın, bulmacayı çözmüşüz!<hr>";

//	gelen verileri bir de burada kontrol edelim (arayüzdeki kontrolleri aşabilirler neticede)

$normalizedCardNumber = str_replace(" ", "", $_POST['cardNo']);
$maskedCardNumber = ccMasking($normalizedCardNumber);
$expirtyDate = explode(" / ", $_POST['cardExpiryDate']);
$amount = floatval(str_replace(',', '.', $_POST['amount']));
$payment_id = uniqid();
$user_ip = $_SERVER['REMOTE_ADDR'];

$validator = new PaymentInformationValidation([
	"name" => $_POST['name'],
	"surname" => $_POST['surname'],
	"paymentType" => $_POST['payment_type'],
	"email" => $_POST['email'],
	"creditCard" => $normalizedCardNumber,
	"expMonth" => $expirtyDate[0],
	"expYear" => $expirtyDate[1],
	"cvc" => $_POST['cardCVC'],
	"amount" => $amount
	]);

if ( ! $validator->isValid() ) {
    // there are errors, now you can show them
	foreach ($validator->getViolations() as $violation) {
		echo $violation->getMessage().'<br>';
	}
	die("Lütfen geri gidip hataları giderin.");
}

echo "Veri doğrulamasından geçtik<hr>";

//	veritabanına ekleyelim
// bağlantıyı kuralım
try {
	$con = new PDO("mysql:host=localhost;dbname=lkd_vpos;charset=utf8", "root", "root");

} catch ( PDOException $e ){
	print $e->getMessage();
}

//	sorgu için hazırlık yapalım
$createPaymentAttempt = $con->prepare("INSERT INTO payment_attempts (payment_id, user_name, user_surname, user_phone, user_email, user_address, user_ip, payment_type, payment_description, amount, user_card_info) VALUES (:payment_id, :user_name, :user_surname, :user_phone, :user_email, :user_address, :user_ip, :payment_type, :payment_description, :amount, :user_card_info)");

//	sorgu içine gönderilecek değerleri hazırlayalım
$queryValues = array(
	"payment_id" => $payment_id,
	"user_name" => $_POST['name'],
	"user_surname" => $_POST['surname'],
	"user_phone" => $_POST['phone'],
	"user_email" => $_POST['email'],
	"user_address" => $_POST['address'],
	"user_ip" => $user_ip,
	"payment_type" => $_POST['payment_type'],
	"payment_description" => $_POST['description'],
	"amount" => $amount,
	"user_card_info" => $maskedCardNumber);

//	sorguyu çalıştıralım
$isAdded = $createPaymentAttempt->execute($queryValues);

//	ekleme başarılı mı bi bakalım
if($isAdded){
	echo "Veritabanına eklendi! ID: ".$con->lastInsertId()."<hr>";
}else{
	die("Veritabanına eklenemedi :(");
}

//	her şey hazır, ödemeyi deneyelim


die(var_dump($_POST));
