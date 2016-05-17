<?php

namespace Omnipay\WePay\Message;

use Guzzle\Http\Exception\BadResponseException;

/**
 * WePay Refund Request.
 */
class RefundRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return $this->getApiUrl().'checkout/refund';
    }

    public function getData()
    {
        $this->validate('transactionReference', 'refundReason');

        $data = array();
        $data['checkout_id'] = intval($this->getTransactionReference());
        $data['refund_reason'] = $this->getRefundReason();

        $amount = $this->getAmount();
        if (isset($amount) && !empty($amount)) {
            $data['amount'] = $amount;
        }

        $appFee = $this->getApplicationFee();
        if (isset($appFee) && !empty($appFee)) {
            $data['app_fee'] = $appFee;
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

            return new RefundResponse($this, $response->json());
        } catch (BadResponseException $e) {
            $response = $e->getResponse();

            return new RefundResponse($this, $response->json());
        }
    }
}
