<?php

namespace Omnipay\Cryptomus\Message;

use Omnipay\Common\Message\AbstractRequest as Request;

abstract class AbstractRequest extends Request
{
    protected $method = "";
    protected $productionUri = "";

    public function getEndpoint()
    {
        return $this->productionUri;
    }

    public function setSign($value) 
    {
        return $this->setParameter('sign', $value);
    }

    public function getSign() 
    {
        return $this->getParameter('sign');
    }

    public function setSecretKey($value)
    {
        return $this->setParameter("secretKey",$value);
    }

    public function getSecretKey()
    {
        return $this->getParameter("secretKey");
    }
    
    public function setShopId($value)
    {
        return $this->setParameter("shopId", $value);
    }

    public function getShopId() 
    {
        return $this->getParameter('shopId');
    }   
    
    public function setPaymentMethod($value)
    {
        return $this->setParameter("to_currency", $value);
    }

    public function getPaymentMethod() 
    {
        return $this->getParameter('to_currency');
    }

    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    public function getLocale() 
    {
        return $this->getParameter('lalocaleng');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter("return_url", $value);
    }

    public function getReturnUrl() 
    {
        return $this->getParameter('return_url');
    }

    public function setResultUrl($value)
    {
        return $this->setParameter("result_url", $value);
    }

    public function getResultUrl() 
    {
        return $this->getParameter('result_url');
    }

    public function setSuccessUrl($value)
    {
        return $this->setParameter("success_url", $value);
    }

    public function getSuccessUrl() 
    {
        return $this->getParameter('success_url');
    }
}
