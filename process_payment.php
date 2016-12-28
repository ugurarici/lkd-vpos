<?php
require "vendor/autoload.php";

//	bulmaca çözümü SESSION'da saklandığı için session'ı başlatıyoruz
session_start();

//	kullanıcının girdiği bulmaca yanıtı doğru değilse hata verip geri dönelim
if( $_POST["captchaText"] !== $_SESSION['captchaPhrase'] ) die( "Bulmaca yanıtı yanlış" );

echo "Yaşasın, bulmacayı çözmüşüz!";
die(var_dump($_POST));