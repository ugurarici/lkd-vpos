<?php
/**
 *  İçine Payment objesi alır
 * 
 *  Payment'ın başarılı olması durumunda ödemeyi yapan kişiye
 *      ve derneğe e-postalar gönderilir
 * 
 *  E-posta gönderimi için PhpMailer kullanacağız
 * 
 *  Ayar dosyasında SMTP ile mi yoksa çıplak olarak mı
 *      e-posta gönderimi yapılacağı belirtilebilmeli
 * 
 *  Bu ayara göre bir PhpMailer objesi oluşturup
 *      o obje üzerinden e-posta gönderimlerimizi yapacağız
 * 
 */
class PaymentMailer
{
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
    
    private $_payment;
    private $_mailer;
    
    public function __construct(Payment $payment)
    {
        $this->_payment = $payment;
        $this->send();
    }
    
    private function initPhpMailer()
    {
        $this->_mailer = null;
        $this->_mailer = new PHPMailer(true);
        $this->_mailer->CharSet = 'UTF-8';
        
        if (self::IS_SMTP) {
            $this->_mailer->isSmtp();
        }
        
        if (self::SMTP_AUTH) {
            $this->_mailer->SMTPAuth = true;
            $this->_mailer->Host = self::SMTP_SERVER;
            $this->_mailer->Port = self::SMTP_PORT;
            $this->_mailer->SMTPSecure = self::SMTP_SECURE;
            $this->_mailer->Username = self::SMTP_USER;
            $this->_mailer->Password = self::SMTP_PASS;
        }
    }
    
    private function prepareUserMailContent()
    {
        //  Kullanıcıya gidecek e-posta hazırlanır
        $body = "Sayın ".$this->_payment->userName." ".$this->_payment->userSurname
        .",\r\nYaptığınız ödeme için teşekkür ederiz!,\r\n"
        ."Ödeme Bilgileri Aşağıdadır.\r\nLinux Kullanıcıları Derneği\r\n"
        ."Ad - Soyad: "
        .$this->_payment->userName.' '
        .$this->_payment->userSurname
        ."\r\n"
        ."Açıklama: "
        .$this->_payment->paymentDescription
        ."\r\n"
        ."Ödeme Miktarı: "
        .number_format($this->_payment->amount, 2, ",", ".")
        ."\r\n";
        return $body;
    }
    
    private function prepareAdministratorMailContent()
    {
        //  Dernek yetkililerine gidecek e-posta hazırlanır
        $ykbody = "Yeni Ödeme Yapıldı\r\n"
        ."Ad - Soyad: ".$this->_payment->userName
        ." ".$this->_payment->userSurname."\r\n"
        ."Açıklama: ".$this->_payment->paymentDescription."\r\n"
        ."Ödeme Miktarı: "
        .number_format($this->_payment->amount, 2, ",", ".")
        ."\r\n";
        return $ykbody;
    }
    
    private function sendMailToUser()
    {
        //  Ödemeyi yapana e-posta gönderilir
        $this->initPhpMailer();
        $this->_mailer->setFrom(self::USER_FROM_EMAIL, self::USER_FROM_NAME);
        $this->_mailer->addAddress(
            $this->_payment->userEmail, 
            $this->_payment->userName." ".$this->_payment->userSurname
        );
        $this->_mailer->Subject = self::USER_SUBJECT;
        $this->_mailer->Body = $this->prepareUserMailContent();
        // $this->_mailer->AltBody = $this->prepareUserMailContent();
        if ($this->_mailer->send()) {
            $this->_payment->mailSent("user");
        }
    }
    
    private function sendMailToAdministrator()
    {
        //  dernek yetkililerine e-posta gönderilir
        $this->initPhpMailer();
        $this->_mailer->setFrom(
            self::ADMINISTRATOR_FROM_EMAIL, 
            self::ADMINISTRATOR_FROM_NAME
        );
        $this->_mailer->addAddress(self::ADMINISTRATOR_EMAIL);
        $this->_mailer->Subject = self::ADMINISTRATOR_SUBJECT;
        $this->_mailer->Body = $this->prepareAdministratorMailContent();
        // $this->_mailer->AltBody = $this->prepareAdministratorMailContent();
        if ($this->_mailer->send()) {
            $this->_payment->mailSent("admin");
        }
    }
    
    private function send()
    {
        $this->sendMailToAdministrator();
        $this->sendMailToUser();
    }
    
    // private function prepareMailContent($file, $params){
        //  e-posta içeriğini barındıran taslak dosyası ve 
        //  içinde bulunacak bilgileri alıp sonuç üretilecek
        //  var_dump(file_get_contents("test.txt"));
        // }
}