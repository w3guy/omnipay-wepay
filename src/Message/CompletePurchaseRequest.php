<?php

namespace Omnipay\WePay\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * WePay Complete Purchase Request.
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        // GET parameter returned by WePay
        $data = $this->httpRequest->query->all();

        if (empty($data)) {
            throw new InvalidResponseException();
        }

        return $data;
    }

    public function sendData($data)
    {
        $checkout_id = $data['checkout_id'];
        $fetchTransaction = new FetchTransactionRequest($this->httpClient, $this->httpRequest);
        $fetchTransaction->setAccountId($this->getAccountId());
        $fetchTransaction->setTestMode($this->getTestMode());
        $fetchTransaction->setAccessToken($this->getAccessToken());
        $fetchTransaction->setTransactionReference($checkout_id);
        $response = $fetchTransaction->send();

        return new CompletePurchaseResponse($this, $response->getData());
    }
}
