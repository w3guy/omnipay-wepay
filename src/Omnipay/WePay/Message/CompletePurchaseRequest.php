<?php

namespace Omnipay\WePay\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * WePay Complete Purchase Request
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        $return_parameter = $this->httpRequest->query->all();
        
        if (empty( $return_parameter )) {
            throw new InvalidResponseException;
        }

        return $this->httpRequest->query->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
