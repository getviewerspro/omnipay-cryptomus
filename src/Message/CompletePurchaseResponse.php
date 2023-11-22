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
        
        info(['Cryptomus webhook data (CompletePurchaseResponse): ', $this->data]);

        if ($this->getSign() !== $this->calculateSignature()) {
            throw new InvalidResponseException('Invalid hash');
        }
    }

    public function isSuccessful()
    {
        return $this->data['status'] === 'paid';  //paid, confirm_check ?
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
        return (string)$this->data['merchant_amount'];
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

        info(['calculateSignature', $data, $sign]);
        
        return $sign;
    }
}
