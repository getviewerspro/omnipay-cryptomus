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

/**
 * Cryptomus Complete Purchase Request.
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * Get the data for this request.
     * @return array request data
     */
    public function getData()
    {
        return $this->httpRequest->request->all();
    }

    /**
     * Send the request with specified data.
     * @param mixed $data The data to send
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
