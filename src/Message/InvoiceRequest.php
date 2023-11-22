<?php

namespace Omnipay\Cryptomus\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class InvoiceRequest extends AbstractRequest
{
    protected $method     = 'POST';
    public $productionUri = "https://api.cryptomus.com/v1/payment";

    /**
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'shopId',
            'secretKey',
            'amount',
            'transactionId'
        );

        return $this->prepareSign()->getRequestBody();
    }

    public function sendData($result)
    {
        return new InvoiceResponse($this, $result);
    }

    private function getRequestBody()
    {
        $return =  array_filter([
            'amount'            => $this->getAmount(),
            'order_id'          => $this->getTransactionId(),
            'to_currency'       => $this->getPaymentMethod(),
            'currency'          => $this->getCurrency(),
            'url_return'        => $this->getReturnUrl(),
            'url_success'       => $this->getSuccessUrl(),
            'url_callback'      => $this->getResultUrl(),
        ]);
        
        info(['Cryptomus request body: ', $return]);
        
        return $return;
    }

    public function prepareSign() 
    {
        $signStr = json_encode($this->getRequestBody(), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        
        return $this->setSign(
            md5(base64_encode($signStr) . $this->getSecretKey())
        );
    }
    
    public function send()
    {
        $data = $this->getData();
        
        $response = $this->getClient($data);
        $result = json_decode($response, 1);
        
        return $this->sendData($result);
    }
    
    protected function getClient($data)
    {        
        $data = json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        $sign = $this->getSign();
        $shopId = $this->getShoId();

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getEndpoint(), 
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true, 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => 'POST', 
            CURLOPT_POSTFIELDS => $data, 
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json', 'Content-Type: application/json', 'sign: '.$sign, 'merchant: '.shopId
            ), 
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        return $response;
    }

}
