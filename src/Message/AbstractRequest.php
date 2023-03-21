<?php

namespace Omnipay\bitBanker\Message;

use Omnipay\Common\Message\AbstractRequest as Request;

abstract class AbstractRequest extends Request
{
    protected $method = "";
    protected $productionUri = "";

    public function getEndpoint()
    {
        return $this->productionUri;
    }

    public function setHeaders($value) {
        return $this->setParameter('headers',$value);
    }

    public function getHeaders() {
        return $this->getParameter('headers');
    }

    public function setSign($value) {
        return $this->setParameter('sign', $value);
    }

    public function getSign() {
        return $this->getParameter('sign');
    }

    public function setApiKey($value)
    {
        return $this->setParameter("apiKey", $value);
    }

    public function getApiKey()
    {
        return $this->getParameter("apiKey");
    }

    public function setShopId($value)
    {
        return $this->setParameter("shopId", $value);
    }

    public function getShopId() {
        return $this->getParameter('shopId');
    }

    public function setPaymentMethods($value)
    {
        return $this->setParameter("includeService", $value);
    }

    public function getPaymentMethods() {
        return $this->getParameter('includeService');
    }

    public function send()
    {
        $data = $this->getData();

        $response = $this->getClient($data);

        $result = json_decode($response->getBody()->getContents(),1);

        return $this->sendData($result);
    }

    protected function getClient($data)
    {
        return $this->httpClient->request(
          $this->method,
          $this->getEndpoint(),
          $this->getHeaders(),
          json_encode($data)
        );
    }

}