<?php
require "vendor/autoload.php";

$normalizedCardNumber = str_replace(" ", "", $_POST['cardNo']);
$expirtyDate = explode(" / ", $_POST['cardExpiryDate']);
$amount = floatval(str_replace(',', '.', $_POST['amount']));

try {
    Helpers::checkCaptcha($_POST["captcha"]);
    
    $payment = new Payment(
        array(
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
        )
    );
    
    $result = ["result"=>"success", "message"=>"İşlem başarılı, teşekkür ederiz."];
} catch (phpmailerException $e) {
    $result = [
        "result"=>"warning", 
        "message"=>"Ödeme işlemi başarılı ancak e-posta gönderiminde sorun yaşadık."
        ."Ödemeniz için teşekkür ederiz.<br>E-posta hatası: ".$e->errorMessage()
    ];
} catch (Exception $e) {
    $result = [
        "result"=>"error",
        "message"=>"İşlem başarısız. Lütfen tekrar deneyin."
        ."<br>HATA: ".$e->getMessage()
    ];
}

echo json_encode($result);