<?php
require "vendor/autoload.php";

//	bulmaca çözümü SESSION'da saklandığı için session'ı başlatıyoruz
session_start();
$captchaAnswer = $_SESSION['captchaPhrase'];
session_destroy();

//	kullanıcının girdiği bulmaca yanıtı doğru değilse hata verip geri dönelim
if( $_POST["captchaText"] !== $captchaAnswer ) die( "Bulmaca yanıtı yanlış" );

echo "Yaşasın, bulmacayı çözmüşüz!";

//	gelen verileri bir de burada kontrol edelim (arayüzdeki kontrolleri aşabilirler neticede)

$normalizedCardNumber = str_replace(" ", "", $_POST['cardNoText']);
$expirtyDate = explode(" / ", $_POST['cardExpiryDate']);

$validator = new PaymentInformationValidation([
	"name" => $_POST['nameText'],
	"surname" => $_POST['surnameText'],
	"paymentType" => $_POST['optionsRadios'],
	"email" => $_POST['emailText'],
	"creditCard" => $normalizedCardNumber,
	"expMonth" => $expirtyDate[0],
	"expYear" => $expirtyDate[1],
	"cvc" => $_POST['cardCVC'],
	"amount" => $_POST['tutarText']
	]);

if ( ! $validator->isValid() ) {
    // there are errors, now you can show them
	foreach ($validator->getViolations() as $violation) {
		echo $violation->getMessage().'<br>';
	}
}

die(var_dump($_POST));
