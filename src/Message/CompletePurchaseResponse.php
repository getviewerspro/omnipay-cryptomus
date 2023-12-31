<?php
/**
 * Cryptomus driver for Omnipay PHP payment library
 *
 * @link      https://github.com/getviewerspro/omnipay-cryptomus
 * @package   omnipay-cryptomus
 * @license   MIT
 * @copyright Copyright (c) 2023, getViewersPRO (https://getviewers.pro/)
 */

namespace Omnipay\Cryptomus\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Digiseller Complete Purchase Response.
 */
class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @var CompletePurchaseRequest|RequestInterface
     */
    protected $request;
    protected $customFields;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data    = request()->all();//$this->getData(); 

        if ($this->getSign() !== $this->calculateSignature()) {
            throw new InvalidResponseException('Invalid hash');
        }
    }

    public function isSuccessful()
    {
        return in_array($this->data['status'], ['paid', 'paid_over']);  //paid_over, confirm_check ?
    }

    public function getTransactionId()
    {
        return $this->data['order_id'];
    }

    public function getAmount()
    {
        return (string)$this->data['amount'];
    }  

    public function getCurrency()
    {
        return $this->data['currency'];
    }    
    
    public function getMoney()
    {
        return ($this->data['merchant_amount']*$this->data['payer_amount_exchange_rate']) . ' ' . $this->getCurrency();
    }

    public function getTransactionReference()
    {
        return $this->data['uuid'];
    }

    public function getSign()
    {
        return $this->data['sign'];
    }
    
    public function calculateSignature()
    {        
        $data = $this->data;
        unset($data['sign']);

        $signStr = json_encode($data, JSON_UNESCAPED_UNICODE);
    
        $sign = md5(base64_encode($signStr) . $this->request->getSecretKey());
        
        return $sign;
    }
}
