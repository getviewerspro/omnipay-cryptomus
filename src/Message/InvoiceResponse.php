<?php

namespace Omnipay\Cryptomus\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class InvoiceResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $request;

    public function __construct(InvoiceRequest $request, $data)
    {
        $this->request = $request;
        $this->data    = $data; 
    }
    
    public function isSuccessful()
    {
        if (!isset($this->data['state']) || empty($this->data['result'])) {
            return false;
        }
        
        return ($this->data['state'] == 0) ? true : false;

    }

    public function getInvoiceId()
    {
        return $this->data['result']['uuid'];
    }

    public function getInvoiceLink()
    {            
        return $this->data['result']['url'] ?? '';
    }

    public function getMessage()
    {
        return $this->data;
    }
    
    public function isRedirect()
    {
        return $this->isSuccessful();
    }

    public function getRedirectUrl()
    {
        return $this->getInvoiceLink();
    }
    
    public function getRedirectData()
    {
        return [
            'lang' => $this->request->getLocale()
        ];
    }
}
