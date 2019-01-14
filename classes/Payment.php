<?php
class Payment
{
    public $id;
    public $transactionId;
    public $userName;
    public $userSurname;
    public $userPhone;
    public $userEmail;
    public $userAddress;
    public $userIp;
    public $paymentDate;
    public $paymentType;
    public $paymentDescription;
    public $amount;
    public $userCardInfo;
    public $isSuccess;
    public $paymentResultDescription;
    public $isUserMailSent;
    public $isAdminMailSent;
    
    public $cardNumber;
    public $cardExpirtyMonth;
    public $cardExpirtyYear;
    public $cardCVV;
    
    private $_con = null;
    
    public function __construct($new = null)
    {
        if (!is_null($new) ) {
            $this->userName = $new['userName'];
            $this->userSurname = $new['userSurname'];
            $this->userPhone = $new['userPhone'];
            $this->userEmail = $new['userEmail'];
            $this->userAddress = $new['userAddress'];
            $this->paymentType = $new['paymentType'];
            $this->paymentDescription = $new['paymentDescription'];
            $this->amount = $new['amount'];
            $this->cardNumber = $new['cardNumber'];
            $this->cardExpirtyMonth = $new['cardExpirtyMonth'];
            $this->cardExpirtyYear = $new['cardExpirtyYear'];
            $this->cardCVV = $new['cardCVV'];
            
            $this->userCardInfo = Helpers::ccMasking($this->cardNumber);
            $this->transactionId = md5(uniqid(mt_rand(), true));
            $this->userIp = $_SERVER['REMOTE_ADDR'];
            
            $this->validate();
            
            $this->save();
            
            $this->vposPayment();
            
            $this->sendEmails();
            // die(var_dump($this));
        }
    }
    
    private function validate()
    {
        $validator = PaymentInformationValidation::validateFromObject($this);
        if (! $validator->isValid() ) {
            // $validator->throwException();
            throw new Exception("Forma girilen bilgiler uygun formatta değil, lütfen kontrol edip tekrar deneyin. <br>" . implode(", <br>" ,$validator->getViolations()), 1);
        }
    }
    
    private function vposPayment()
    {
        $vpos = new PaymentVPOS($this);
        
        if (! $vpos->isSuccess() ) {
            throw new Exception("Bankadan onay alamadık", 1);
        }
    }
    
    private function sendEmails()
    {
        $mails = new PaymentMailer($this);
    }
    
    public function updateStatus($status, $message = null)
    {
        //  Burada gelen bilgilerle hem veritabanında hem de obje içinde durum 
        //  ve ödeme sonucu alanlarını güncelleyeceğiz
        $this->isSuccess = (bool)$status;
        if(! is_null($message) ) $this->paymentResultDescription = (string)$message;
        $this->save();
    }
    
    public function mailSent($userType)
    {
        if($userType==="user") $this->isUserMailSent = true;
        if($userType==="admin") $this->isAdminMailSent = true;
        $this->save();
    }
    
    public function save()
    {
        if (is_null($this->_con) ) $this->createConnection();
        
        if ($this->id > 0) {
            $this->updateOnDB();
        } else {
            $this->insertToDB();
        }
    }
    
    private function insertToDB()
    {
        //  Sorgu için hazırlık yapalım
        $createPaymentAttempt = $this->_con->prepare("INSERT INTO payment_attempts (transaction_id, user_name, user_surname, user_phone, user_email, user_address, user_ip, payment_type, payment_description, amount, user_card_info) VALUES (:transaction_id, :user_name, :user_surname, :user_phone, :user_email, :user_address, :user_ip, :payment_type, :payment_description, :amount, :user_card_info)");
        
        //  Sorgu içine gönderilecek değerleri hazırlayalım
        $queryValues = array(
            "transaction_id" => $this->transactionId,
            "user_name" => $this->userName,
            "user_surname" => $this->userSurname,
            "user_phone" => $this->userPhone,
            "user_email" => $this->userEmail,
            "user_address" => $this->userAddress,
            "user_ip" => $this->userIp,
            "payment_type" => $this->paymentType,
            "payment_description" => $this->paymentDescription,
            "amount" => $this->amount,
            "user_card_info" => $this->userCardInfo
        );
        
        //  Sorguyu çalıştıralım
        $isAdded = $createPaymentAttempt->execute($queryValues);
        
        //  Ekleme başarılı mı bi bakalım
        if ($isAdded) {
            $this->id = $this->_con->lastInsertId();
        } else {
            throw new Exception("Veritabanına eklenemedi :(", 1);
        }
    }
    
    private function updateOnDB()
    {
        //  Sorgu için hazırlık yapalım
        $updatePaymentAttempt = $this->_con->prepare("UPDATE payment_attempts SET transaction_id = :transaction_id, user_name = :user_name, user_surname = :user_surname, user_phone = :user_phone, user_email = :user_email, user_address = :user_address, user_ip = :user_ip, payment_type = :payment_type, payment_description = :payment_description, amount = :amount, user_card_info = :user_card_info, is_success = :is_success, payment_result_description = :payment_result_description, is_mail_to_user_sent = :is_mail_to_user_sent, is_mail_to_admin_sent = :is_mail_to_admin_sent WHERE id = :id");
        
        //  Sorgu içine gönderilecek değerleri hazırlayalım
        $queryValues = array(
            "id" => $this->id,
            "transaction_id" => $this->transactionId,
            "user_name" => $this->userName,
            "user_surname" => $this->userSurname,
            "user_phone" => $this->userPhone,
            "user_email" => $this->userEmail,
            "user_address" => $this->userAddress,
            "user_ip" => $this->userIp,
            "payment_type" => $this->paymentType,
            "payment_description" => $this->paymentDescription,
            "amount" => $this->amount,
            "user_card_info" => $this->userCardInfo,
            "is_success" => $this->isSuccess,
            "payment_result_description" => $this->paymentResultDescription,
            "is_mail_to_user_sent" => $this->isUserMailSent,
            "is_mail_to_admin_sent" => $this->isAdminMailSent
        );
        
        //  Sorguyu çalıştıralım
        $isUpdated = $updatePaymentAttempt->execute($queryValues);
        
        //  Güncelleme başarılı mı bi bakalım
        if (! $isUpdated) {
            throw new Exception("Veritabanında güncellenemedi :(", 1);
        }
    }
    
    private function createConnection()
    {
        $this->_con = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DATABASE.";charset=utf8", MYSQL_USER, MYSQL_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
}