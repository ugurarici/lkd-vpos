<?php
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\CardScheme;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class PaymentInformationValidation
{
    private $_name;
    private $_surname;
    private $_paymentType;
    private $_email;
    private $_creditCard;
    private $_expMonth;
    private $_expYear;
    private $_cvc;
    private $_amount;
    
    private $_violations;
    
    private $_validator;
    
    public static function validateFromObject(Payment $payment)
    {
        $obj = new self(
            array(
                "name" => $payment->userName,
                "surname" => $payment->userSurname,
                "paymentType" => $payment->paymentType,
                "email" => $payment->userEmail,
                "creditCard" => $payment->cardNumber,
                "expMonth" => $payment->cardExpirtyMonth,
                "expYear" => $payment->cardExpirtyYear,
                "cvc" => $payment->cardCVV,
                "amount" => $payment->amount
                )
        );
        
        return $obj;
    }
        
    public function __construct($params=[])
    {
        $emptyParams = [
            "name" => "", 
            "surname" => "", 
            "paymentType" => "", 
            "email" => "", 
            "creditCard" => "", 
            "expMonth" => "", 
            "expYear" => "", 
            "cvc" => "", 
            "amount" => ""
        ];
        $finalParams = array_merge($emptyParams, $params);
        $this->_name = $finalParams['name'];
        $this->_surname = $finalParams['surname'];
        $this->_paymentType = $finalParams['paymentType'];
        $this->_email = $finalParams['email'];
        $this->_creditCard = $finalParams['creditCard'];
        $this->_expMonth = $finalParams['expMonth'];
        $this->_expYear = $finalParams['expYear'];
        $this->_cvc = $finalParams['cvc'];
        $this->_amount = $finalParams['amount'];
        
        $this->_violations = [];
        
        $this->_validator = Validation::createValidator();
        
        $this->validate();
    }
    
    private function validate()
    {
        $this->validateName();
        $this->validateSurname();
        $this->validatePaymentType();
        $this->validateEmail();
        $this->validateCreditCard();
        $this->validateExpMonth();
        $this->validateExpYear();
        $this->validateCvc();
        $this->validateAmount();
    }
    
    private function addToAllViolations($fieldViolations)
    {
        foreach ($fieldViolations as $fieldViolation) {
            $this->_violations[] = $fieldViolation;
        }
    }
    
    private function validateName()
    {
        $nameViolations = $this->_validator->validate(
            $this->_name,
            array(
                new NotBlank(array('message' => 'Ad alanı boş olamaz')),
                new Length(
                    array(
                    'min' => 2, 
                    'minMessage' => 'Ad alanı en az {{ limit }} karakter olmalıdır'
                    )
                ),
            )
        );
        $this->addToAllViolations($nameViolations);
    }
        
    private function validateSurname()
    {
        $surnameViolations = $this->_validator->validate(
            $this->_surname,
            array(
                new NotBlank(array('message' => 'Soyad alanı boş olamaz')),
                new Length(
                    array('min' => 2, 'minMessage' => 'Soyad alanı en az {{ limit }} karakter olmalıdır')
                ),
            )
        );
        $this->addToAllViolations($surnameViolations);
    }
        
    private function validatePaymentType()
    {
        $paymentTypeViolations = $this->_validator->validate(
            $this->_paymentType,
            array(
                new NotBlank(array('message' => 'Ödeme tipi boş olamaz')),
                new Choice(array('choices' => array('bagis', 'aidat'), 'message' => 'Ödeme tipi doğru değil')),
                )
        );
        $this->addToAllViolations($paymentTypeViolations);
    }
        
    private function validateEmail()
    {
        $emailViolations = $this->_validator->validate(
            $this->_email,
            array(
                new NotBlank(array('message' => 'E-posta boş olamaz')),
                new Email(array('message' => 'E-posta geçersiz')),
                )
        );
        $this->addToAllViolations($emailViolations);
    }
        
    private function validateCreditCard()
    {
        $creditCardViolations = $this->_validator->validate(
            $this->_creditCard,
            array(
                new NotBlank(array('message' => 'Kart numarası boş olamaz')),
                new CardScheme(array('schemes' => array('VISA', 'MASTERCARD', 'AMEX'), 'message' => 'Desteklenmeyen kart tipi ya da yanlış kart numarası')),
                )
        );
        $this->addToAllViolations($creditCardViolations);
    }
    
    private function validateExpMonth()
    {
        $expMonthViolations = $this->_validator->validate(
            $this->_expMonth,
            array(
                new NotBlank(array('message' => 'Kart son kullanma tarihi (ay) boş olamaz')),
                new Range(array('min' => 1, 'max' => 12, 'minMessage' => 'Kart son kullanma tarihi (ay) geçerli bir aralıkta olmalıdır (01-12)', 'maxMessage' => 'Kart son kullanma tarihi (ay) geçerli bir aralıkta olmalıdır (01-12)', 'invalidMessage' => 'Kart son kullanma tarihi (ay) geçerli bir aralıkta olmalıdır (01-12)')),
                )
        );
        $this->addToAllViolations($expMonthViolations);
    }
    
    private function validateExpYear()
    {
        $expYearViolations = $this->_validator->validate(
            $this->_expYear,
            array(
                new NotBlank(array('message' => 'Kart son kullanma tarihi (yıl) boş olamaz')),
                new GreaterThanOrEqual(array('value' => (int)date('Y'), 'message' => 'Kart son kullanma tarihi (yıl) geçersiz')),
                )
        );
        $this->addToAllViolations($expYearViolations);
    }
    
    private function validateCvc()
    {
        $cvcViolations = $this->_validator->validate(
            $this->_cvc,
            array(
                new NotBlank(array('message' => 'CVC (kart güvenlik kodu) boş olamaz')),
                new Length(array('min' => 3, 'max' => 4, 'exactMessage' => 'CVC (kart güvenlik kodu) {{ limit }} karakter olmalıdır', 'minMessage' => 'CVC (kart güvenlik kodu) en az {{ limit }} karakter olmalıdır', 'maxMessage' => 'CVC (kart güvenlik kodu) en fazla {{ limit }} karakter olmalıdır')),
                )
        );
        $this->addToAllViolations($cvcViolations);
    }
    
    private function validateAmount()
    {
        $amountViolations = $this->_validator->validate(
            $this->_amount,
            [
                new NotBlank(array('message' => 'Tutar boş olamaz')),
                new GreaterThanOrEqual(array('value' => 1, 'message' => 'Tutar en az {{ compared_value }} TL olmalıdır'))
                ]
        );
        $this->addToAllViolations($amountViolations);
    }
    
    public function isValid()
    {
        if(count($this->_violations)===0) return true;
        return false;
    }
    
    public function getViolations()
    {
        return $this->_violations;
    }
}