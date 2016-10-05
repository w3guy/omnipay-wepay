<?php

namespace Omnipay\WePay\Message;

use Guzzle\Http\Exception\BadResponseException;

/**
 * WePay Cancel Request.
 */
class CancelRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return $this->getApiUrl().'checkout/cancel';
    }

    public function getData()
    {
        $this->validate('transactionReference');

        $data = array();
        $data['checkout_id'] = intval($this->getTransactionReference());

        if ($this->getCancelReason()) {
            $data['cancel_reason'] = $this->getCancelReason();
        } elseif ($this->getRefundReason()) {
            $data['cancel_reason'] = $this->getRefundReason();
        }

        return $data;
    }

    public function sendData($data)
    {
        try {
            $response = $this->httpClient->post(
                $this->getEndpoint(),
                $this->getApiHeader(),
                json_encode($data)
            )->send();

            return new CancelResponse($this, $response->json());
        } catch (BadResponseException $e) {
            $response = $e->getResponse();

            return new CancelResponse($this, $response->json());
        }
    }
}
