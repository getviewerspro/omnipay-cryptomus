<?php

namespace Omnipay\Cryptomus;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{

    public function getName()
    {
        return "Cryptomus";
    }

    public function getDefaultParameters()
    {
        return [
            'lang' => 'en'
        ];
    }

    public function setSecretKey($value)
    {
        return $this->setParameter("secretKey", $value);
    }

    public function getSecretKey()
    {
        return $this->getParameter("secretKey");
    }
 
    public function setPaymentMethod($value)
    {
        return $this->setParameter("to_currency", $value);
    }

    public function getPaymentMethod() {
        return $this->getParameter('to_currency');
    }
    
    public function setShopId($value)
    {
        return $this->setParameter("shopId", $value);
    }

    public function getShopId() {
        return $this->getParameter('shopId');
    }
    
    public function setLocale($value)
    {
        info('set locale:'.$value);
        return $this->setParameter('lang', $value);
    }

    public function getLocale() 
    {
        return $this->getParameter('lang');
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

    public function createInvoice(array $options = [])
    {
        return $this->createRequest('\Omnipay\Cryptomus\Message\InvoiceRequest', $options);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Cryptomus\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createInvoice($parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Cryptomus\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = [])
    {
        info($parameters);
        return $this->createRequest('\Omnipay\Cryptomus\Message\CompletePurchaseRequest', $parameters);
    }

}
