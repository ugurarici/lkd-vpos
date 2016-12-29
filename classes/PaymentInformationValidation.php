<?php
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\CardScheme;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class PaymentInformationValidation{
	private $name;
	private $surname;
	private $paymentType;
	private $email;
	private $creditCard;
	private $expMonth;
	private $expYear;
	private $cvc;
	private $amount;

	private $violations;

	private $validator;

	public function __construct($params=[]){
		$emptyParams = ["name" => "", "surname" => "", "paymentType" => "", "email" => "", "creditCard" => "", "expMonth" => "", "expYear" => "", "cvc" => "", "amount" => ""];
		$finalParams = array_merge($emptyParams, $params);
		$this->name = $finalParams['name'];
		$this->surname = $finalParams['surname'];
		$this->paymentType = $finalParams['paymentType'];
		$this->email = $finalParams['email'];
		$this->creditCard = $finalParams['creditCard'];
		$this->expMonth = $finalParams['expMonth'];
		$this->expYear = $finalParams['expYear'];
		$this->cvc = $finalParams['cvc'];
		$this->amount = $finalParams['amount'];

		$this->violations = [];

		$this->validator = Validation::createValidator();

		$this->validate();
	}

	private function validate(){
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

	private function addToAllViolations($fieldViolations){
		foreach ($fieldViolations as $fieldViolation) {
			$this->violations[] = $fieldViolation;
		}
	}

	private function validateName(){
		$nameViolations = $this->validator->validate(
			$this->name,
			array(
				new NotBlank(array('message' => 'Ad alanı boş olamaz')),
				new Length(array('min' => 2, 'minMessage' => 'Ad alanı en az {{ limit }} karakter olmalıdır')),
				)
			);
		$this->addToAllViolations($nameViolations);
	}

	private function validateSurname(){
		$surnameViolations = $this->validator->validate(
			$this->surname,
			array(
				new NotBlank(array('message' => 'Soyad alanı boş olamaz')),
				new Length(array('min' => 2, 'minMessage' => 'Soyad alanı en az {{ limit }} karakter olmalıdır')),
				)
			);
		$this->addToAllViolations($surnameViolations);
	}

	private function validatePaymentType(){
		$paymentTypeViolations = $this->validator->validate(
			$this->paymentType,
			array(
				new NotBlank(array('message' => 'Ödeme tipi boş olamaz')),
				new Choice(array('choices' => array('bagis', 'aidat'), 'message' => 'Ödeme tipi doğru değil')),
				)
			);
		$this->addToAllViolations($paymentTypeViolations);
	}

	private function validateEmail(){
		$emailViolations = $this->validator->validate(
			$this->email,
			array(
				new NotBlank(array('message' => 'E-posta boş olamaz')),
				new Email(array('message' => 'E-posta geçersiz')),
				)
			);
		$this->addToAllViolations($emailViolations);
	}

	private function validateCreditCard(){
		$creditCardViolations = $this->validator->validate(
			$this->creditCard,
			array(
				new NotBlank(array('message' => 'Kart numarası boş olamaz')),
				new CardScheme(array('schemes' => array('VISA', 'MASTERCARD', 'AMEX'), 'message' => 'Desteklenmeyen kart tipi ya da yanlış kart numarası')),
				)
			);
		$this->addToAllViolations($creditCardViolations);
	}

	private function validateExpMonth(){
		$expMonthViolations = $this->validator->validate(
			$this->expMonth,
			array(
				new NotBlank(array('message' => 'Kart son kullanma tarihi (ay) boş olamaz')),
				new Range(array('min' => 1, 'max' => 12, 'minMessage' => 'Kart son kullanma tarihi (ay) geçerli bir aralıkta olmalıdır (01-12)', 'maxMessage' => 'Kart son kullanma tarihi (ay) geçerli bir aralıkta olmalıdır (01-12)', 'invalidMessage' => 'Kart son kullanma tarihi (ay) geçerli bir aralıkta olmalıdır (01-12)')),
				)
			);
		$this->addToAllViolations($expMonthViolations);
	}

	private function validateExpYear(){
		$expYearViolations = $this->validator->validate(
			$this->expYear,
			array(
				new NotBlank(array('message' => 'Kart son kullanma tarihi (yıl) boş olamaz')),
				new GreaterThanOrEqual(array('value' => (int)date('Y'), 'message' => 'Kart son kullanma tarihi (yıl) geçersiz')),
				)
			);
		$this->addToAllViolations($expYearViolations);
	}

	private function validateCvc(){
		$cvcViolations = $this->validator->validate(
			$this->cvc,
			array(
				new NotBlank(array('message' => 'CVC (kart güvenlik kodu) boş olamaz')),
				new Length(array('min' => 3, 'max' => 3, 'exactMessage' => 'CVC (kart güvenlik kodu) {{ limit }} karakter olmalıdır', 'minMessage' => 'CVC (kart güvenlik kodu) en az {{ limit }} karakter olmalıdır', 'maxMessage' => 'CVC (kart güvenlik kodu) en fazla {{ limit }} karakter olmalıdır')),
				)
			);
		$this->addToAllViolations($cvcViolations);
	}

	private function validateAmount(){
		$amountViolations = $this->validator->validate(
			$this->amount,
			array(
				new NotBlank(array('message' => 'Tutar boş olamaz')),
				new GreaterThanOrEqual(array('value' => 1, 'message' => 'Tutar en az {{ compared_value }} TL olmalıdır')),
				)
			);
		$this->addToAllViolations($amountViolations);
	}

	public function isValid(){
		if(count($this->violations)===0) return true;
		return false;
	}

	public function getViolations(){
		return $this->violations;
	}
}