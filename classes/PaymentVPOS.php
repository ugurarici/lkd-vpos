<?php

class PaymentVPOS{
	const MERCHANTID = '000100000013621';
	const PASSWORD = 'Sa47Pwz3';
	const TERMINALNO = 'VP000593';
	const POXURL = 'https://onlineodemetest.vakifbank.com.tr:4443/VposService/v3/Vposreq.aspx';

	private $payment;

	private $is_success = null;

	public function __construct(Payment $payment){
		$this->payment = $payment;
		
		$this->sendToBank();
	}

	private function createRequestXML(){
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><VposRequest></VposRequest>');
		$xml->addChild('MerchantId', self::MERCHANTID);
		$xml->addChild('Password', self::PASSWORD);
		$xml->addChild('TerminalNo', self::TERMINALNO);
		$xml->addChild('TransactionType', 'Sale');
		$xml->addChild('TransactionId', $this->payment->transactionId);
		$xml->addChild('CurrencyAmount', number_format($this->payment->amount, 2, '.', ''));
		$xml->addChild('CurrencyCode', 949);
		$xml->addChild('Pan', $this->payment->cardNumber);
		$xml->addChild('Cvv', $this->payment->cardCVV);
		$xml->addChild('Expiry', $this->payment->cardExpirtyYear.$this->payment->cardExpirtyMonth);
		$xml->addChild('ClientIp', $this->payment->userIp);
		$xml->addChild('TransactionDeviceSource', 0);
		$xmlCustomItems = $xml->addChild('CustomItems');
		$xmlName = $xmlCustomItems->addChild('Item');
		$xmlName->addAttribute('name', 'İsim');
		$xmlName->addAttribute('value', $this->payment->userName);
		$xmlSurname = $xmlCustomItems->addChild('Item');
		$xmlSurname->addAttribute('name', 'Soyisim');
		$xmlSurname->addAttribute('value', $this->payment->userSurname);
		$xmlPhone = $xmlCustomItems->addChild('Item');
		$xmlPhone->addAttribute('name', 'Telefon');
		$xmlPhone->addAttribute('value', $this->payment->userPhone);
		$xmlEmail = $xmlCustomItems->addChild('Item');
		$xmlEmail->addAttribute('name', 'E-posta');
		$xmlEmail->addAttribute('value', $this->payment->userEmail);
		$xmlPaymentType = $xmlCustomItems->addChild('Item');
		$xmlPaymentType->addAttribute('name', 'Ödeme Tipi');
		$xmlPaymentType->addAttribute('value', $this->payment->paymentType);
		$xmlDescription = $xmlCustomItems->addChild('Item');
		$xmlDescription->addAttribute('name', 'Üye Açıklaması');
		$xmlDescription->addAttribute('value', $this->payment->paymentDescription);

		return $xml->asXML();
	}

	private function sendToBank(){
		$curl = new Curl\Curl();
		$curl->post(self::POXURL, ['prmstr' => $this->createRequestXML()]);

		if ($curl->error) {
			throw new Exception("Error Processing CURL ".$curl->error_code , 1);
		}
		else {
			$paymentVPOSResult = simplexml_load_string($curl->response);
			if((string)$paymentVPOSResult->ResultCode==="0000"){
				$this->is_success = true;
				$this->payment->updateStatus(1, $paymentVPOSResult->ResultDetail);
			}else{
				$this->is_success = false;
				$this->payment->updateStatus(0, $paymentVPOSResult->ResultCode . " - " .$paymentVPOSResult->ResultDetail);
				
				throw new Exception("Karttan ödeme alınamadı. Açıklama: " . $paymentVPOSResult->ResultCode . " - " .$paymentVPOSResult->ResultDetail, 1);
			}
		}
	}

	public function isSuccess(){
		return $this->is_success;
	}
}