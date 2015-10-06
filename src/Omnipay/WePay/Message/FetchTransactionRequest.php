<?php

namespace Omnipay\WePay\Message;

/**
 * WePay Purchase Request
 */

class FetchTransactionRequest extends AbstractRequest
{

    public function getEndpoint()
    {
        return $this->getApiUrl() . 'checkout';
    }


    public function getData()
    {
        $this->validate('transactionReference');

        $data                = array();
        $data['checkout_id'] = $this->getTransactionReference();

        return $data;
    }

    public function sendData($data)
    {

        try {

            $response = $this->httpClient->post($this->getEndpoint(), $this->getApiHeader(), json_encode($data))->send();

            return new FetchTransactionResponse($this, $response->json());
        }
        catch (\Exception $e) {
            $response = $e->getResponse();

            return new FetchTransactionResponse($this, $response->json());
        }
    }
}
