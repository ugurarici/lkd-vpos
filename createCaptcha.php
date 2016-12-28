<?php
// Formda gösterebilmek için captcha oluşturağız ve sonraki ekranda kontrol edebilmek adına içindeki veriyi de SESSION'a yerleştireceğiz
//	@Author: Uğur ARICI [m.ugurarici@gmail.com]
require "vendor/autoload.php";
$captchaBuilder = new Gregwar\Captcha\CaptchaBuilder;
$captchaBuilder->buildAgainstOCR($width = 240, $height = 60, $font = null);
session_start();
$_SESSION['captchaPhrase'] = $captchaBuilder->getPhrase();
echo $captchaBuilder->inline();