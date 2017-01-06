<?php 

class Helpers{
	static function ccMasking($number, $maskingCharacter = '*') {
		return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
	}

	static function checkCaptcha($userAnswer){
		//	bulmaca çözümü SESSION'da saklandığı için session'ı başlatıyoruz
		session_start();
		$captchaAnswer = $_SESSION['captchaPhrase'];
		//	session_destroy();

		//	kullanıcının girdiği bulmaca yanıtı doğru değilse hata verip geri dönelim
		if( $userAnswer !== $captchaAnswer )
			throw new Exception("Bulmaca yanıtı yanlış", 1);
	}
}