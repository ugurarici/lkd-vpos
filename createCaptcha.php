<?php
// Formda gösterebilmek için captcha oluşturağız ve sonraki ekranda kontrol edebilmek adına içindeki veriyi de SESSION'a yerleştireceğiz
//	@Author: Uğur ARICI [m.ugurarici@gmail.com]
require "vendor/autoload.php";
echo Helpers::createCaptcha();