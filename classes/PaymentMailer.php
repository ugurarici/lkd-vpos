<?php

class PaymentMailer{
	//	içine Payment objesi alır
	//	Payment'ın başarılı olması durumunda ödemeyi yapan kişiye ve derneğe e-postalar gönderilir
	//	e-posta gönderimi için PhpMailer kullanacağız
		//	ayar dosyasında SMTP ile mi yoksa çıplak olarak mı e-posta gönderimi yapılacağı belirtilebilmeli
		//	bu ayara göre bir PhpMailer objesi oluşturup o obje üzerinden e-posta gönderimlerimizi yapacağız

	const IS_SMTP = MAIL_IS_SMTP;
	const SMTP_AUTH = MAIL_SMTP_AUTH;
	const SMTP_SERVER = MAIL_SMTP_SERVER;
	const SMTP_PORT = MAIL_SMTP_PORT;
	const SMTP_SECURE = MAIL_SMTP_SECURE;
	const SMTP_USER = MAIL_SMTP_USER;
	const SMTP_PASS = MAIL_SMTP_PASS;
	const ADMINISTRATOR_EMAIL = MAIL_ADMINISTRATOR_EMAIL;
	const ADMINISTRATOR_FROM_EMAIL = MAIL_ADMINISTRATOR_FROM_EMAIL;
	const ADMINISTRATOR_FROM_NAME = MAIL_ADMINISTRATOR_FROM_NAME;
	const ADMINISTRATOR_SUBJECT = MAIL_ADMINISTRATOR_SUBJECT;
	const USER_SUBJECT = MAIL_USER_SUBJECT;
	const USER_FROM_EMAIL = MAIL_USER_FROM_EMAIL;
	const USER_FROM_NAME = MAIL_USER_FROM_NAME;

	private $payment;
	private $mailer;

	public function __construct(Payment $payment){
		$this->payment = $payment;
		$this->send();
	}

	private function initPhpMailer(){
		$this->mailer = null;
		$this->mailer = new PHPMailer(true);
		$this->mailer->CharSet = 'UTF-8';

		if(self::IS_SMTP) $this->mailer->isSmtp();
		if(self::SMTP_AUTH){
			$this->mailer->SMTPAuth = true;
			$this->mailer->Host = self::SMTP_SERVER;
			$this->mailer->Port = self::SMTP_PORT;
			$this->mailer->SMTPSecure = self::SMTP_SECURE;
			$this->mailer->Username = self::SMTP_USER;
			$this->mailer->Password = self::SMTP_PASS;
		}
	}

	private function prepareUserMailContent(){
		//	kullanıcıya gidecek e-posta hazırlanır
		$body = "Sayın ".$this->payment->userName." ".$this->payment->userSurname.",\r\nYaptığınız ödeme için teşekkür ederiz!,\r\nÖdeme Bilgileri Aşağıdadır.\r\nLinux Kullanıcıları Derneği\r\n";
		$body .= "Ad - Soyad: ".$this->payment->userName.' '.$this->payment->userSurname."\r\n";
		$body .= "Açıklama: ".$this->payment->paymentDescription."\r\n";
		$body .= "Ödeme Miktarı: ".number_format($this->payment->amount, 2, ",", ".")."\r\n";
		return $body;
	}

	private function prepareAdministratorMailContent(){
		//	dernek yetkililerine gidecek e-posta hazırlanır
		$ykbody = "Yeni Ödeme Yapıldı\r\n";
		$ykbody .= "Ad - Soyad: ".$this->payment->userName." ".$this->payment->userSurname."\r\n";
		$ykbody .= "Açıklama: ".$this->payment->paymentDescription."\r\n";
		$ykbody .= "Ödeme Miktarı: ".number_format($this->payment->amount, 2, ",", ".")."\r\n";
		return $ykbody;
	}

	private function sendMailToUser(){
		//	ödemeyi yapana e-posta gönderilir
		$this->initPhpMailer();
		$this->mailer->setFrom(self::USER_FROM_EMAIL, self::USER_FROM_NAME);
		$this->mailer->addAddress($this->payment->userEmail, $this->payment->userName." ".$this->payment->userSurname);
		$this->mailer->Subject = self::USER_SUBJECT;
		$this->mailer->Body = $this->prepareUserMailContent();
		// $this->mailer->AltBody = $this->prepareUserMailContent();
		if($this->mailer->send()){
			$this->payment->mailSent("user");
		}
	}

	private function sendMailToAdministrator(){
		//	dernek yetkililerine e-posta gönderilir
		$this->initPhpMailer();
		$this->mailer->setFrom(self::ADMINISTRATOR_FROM_EMAIL, self::ADMINISTRATOR_FROM_NAME);
		$this->mailer->addAddress(self::ADMINISTRATOR_EMAIL);
		$this->mailer->Subject = self::ADMINISTRATOR_SUBJECT;
		$this->mailer->Body = $this->prepareAdministratorMailContent();
		// $this->mailer->AltBody = $this->prepareAdministratorMailContent();
		if($this->mailer->send()){
			$this->payment->mailSent("admin");
		}
	}

	private function send(){
		$this->sendMailToAdministrator();
		$this->sendMailToUser();
	}

	// private function prepareMailContent($file, $params){
	// 	//	e-posta içeriğini barındıran taslak dosyası ve içinde bulunacak bilgileri alıp sonuç üretilecek
	// 	var_dump(file_get_contents("test.txt"));
	// }
}