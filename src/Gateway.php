<?php

namespace Omnipay\Lava;

use Omnipay\Lava\Message\CompletePurchaseRequest;
use Omnipay\Lava\Message\Notification;
use Omnipay\Common\AbstractGateway;
use Omnipay\Lava\Message\InvoiceRequest;


class Gateway extends AbstractGateway
{

    public function getName()
    {
        return "Lava";
    }

    public function getDefaultParameters()
    {
        return [
            'locale' => 'en'
        ];
    }

    public function setSecretKey($value)
    {
        return $this->setParameter("secretKey",$value);
    }

    public function getSecretKey()
    {
        return $this->getParameter("secretKey");
    }

    public function setSecretKeyAdd($value)
    {
        return $this->setParameter("secretKeyAdd",$value);
    }

    public function getSecretKeyAdd()
    {
        return $this->getParameter("secretKeyAdd");
    }
    
    public function setPaymentMethod($value)
    {
        return $this->setParameter("paymentMethod", $value);
    }

    public function getPaymentMethod() {
        return $this->getParameter('paymentMethod');
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
        return $this->setParameter("locale", $value);
    }

    public function getLocale() {
        return $this->getParameter('locale');
    }

    public function createInvoice(array $options = [])
    {
        return $this->createRequest(InvoiceRequest::class, $options);
    }

    /**
        Alias for createInvoice
     */
    public function purchase(array $options = array()): \Omnipay\Common\Message\RequestInterface
    {
        return $this->createInvoice($options);
    }

    public function acceptNotification(array $options = array()): \Omnipay\Common\Message\NotificationInterface
    {
        return $this->responseHandler($options);
    }

    public function completePurchase(array $options = array()): \Omnipay\Common\Message\RequestInterface
    {
        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }

    private function  responseHandler(array $options = array())
    {
        $obj = new Notification();

        $obj->initialize(array_replace($this->getParameters(),$options));

        return $obj->getData();
    }
}
