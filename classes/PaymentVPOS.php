<?php

class PaymentVPOS
{
    const MERCHANTID = VPOS_MERCHANTID;
    const PASSWORD = VPOS_PASSWORD;
    const TERMINALNO = VPOS_TERMINALNO;
    const POXURL = VPOS_POXURL;
    
    private $_payment;
    
    private $_is_success = null;
    
    public function __construct(Payment $payment)
    {
        $this->_payment = $payment;
        
        $this->_sendToBank();
    }
    
    private function _createRequestXML()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><VposRequest></VposRequest>');
        $xml->addChild('MerchantId', self::MERCHANTID);
        $xml->addChild('Password', self::PASSWORD);
        $xml->addChild('TerminalNo', self::TERMINALNO);
        $xml->addChild('TransactionType', 'Sale');
        $xml->addChild('TransactionId', $this->_payment->transactionId);
        $xml->addChild('CurrencyAmount', number_format($this->_payment->amount, 2, '.', ''));
        $xml->addChild('CurrencyCode', 949);
        $xml->addChild('Pan', $this->_payment->cardNumber);
        $xml->addChild('Cvv', $this->_payment->cardCVV);
        $xml->addChild('Expiry', $this->_payment->cardExpirtyYear.$this->_payment->cardExpirtyMonth);
        $xml->addChild('ClientIp', $this->_payment->userIp);
        $xml->addChild('TransactionDeviceSource', 0);
        $xmlCustomItems = $xml->addChild('CustomItems');
        $xmlName = $xmlCustomItems->addChild('Item');
        $xmlName->addAttribute('name', 'İsim');
        $xmlName->addAttribute('value', $this->_payment->userName);
        $xmlSurname = $xmlCustomItems->addChild('Item');
        $xmlSurname->addAttribute('name', 'Soyisim');
        $xmlSurname->addAttribute('value', $this->_payment->userSurname);
        $xmlPhone = $xmlCustomItems->addChild('Item');
        $xmlPhone->addAttribute('name', 'Telefon');
        $xmlPhone->addAttribute('value', $this->_payment->userPhone);
        $xmlEmail = $xmlCustomItems->addChild('Item');
        $xmlEmail->addAttribute('name', 'E-posta');
        $xmlEmail->addAttribute('value', $this->_payment->userEmail);
        $xmlPaymentType = $xmlCustomItems->addChild('Item');
        $xmlPaymentType->addAttribute('name', 'Ödeme Tipi');
        $xmlPaymentType->addAttribute('value', $this->_payment->paymentType);
        $xmlDescription = $xmlCustomItems->addChild('Item');
        $xmlDescription->addAttribute('name', 'Üye Açıklaması');
        $xmlDescription->addAttribute('value', $this->_payment->paymentDescription);
        
        return $xml->asXML();
    }
    
    private function _sendToBank()
    {
        $curl = new Curl\Curl();
        $curl->post(self::POXURL, ['prmstr' => $this->_createRequestXML()]);
        
        if ($curl->error) {
            throw new Exception("Error Processing CURL ".$curl->error_code, 1);
        } else {
            $paymentVPOSResult = simplexml_load_string($curl->response);
            if ((string)$paymentVPOSResult->ResultCode==="0000") {
                $this->_is_success = true;
                $this->_payment->updateStatus(1, $paymentVPOSResult->ResultDetail);
            } else {
                $this->_is_success = false;
                $this->_payment->updateStatus(0, $paymentVPOSResult->ResultCode . " - " .$paymentVPOSResult->ResultDetail);
                
                throw new Exception("Karttan ödeme alınamadı. Açıklama: " . $paymentVPOSResult->ResultCode . " - " .$paymentVPOSResult->ResultDetail, 1);
            }
        }
    }
    
    public function isSuccess()
    {
        return $this->_is_success;
    }
}