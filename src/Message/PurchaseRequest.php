<?php

namespace Omnipay\WePay\Message;

/**
 * WePay Purchase Request.
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionId', 'amount', 'currency', 'type', 'description', 'accountId');

        $data = array();
        $data['account_id'] = $this->getAccountId();

        // unique_id must be used with a preapproval or a tokenized credit card
        // this is highly encouraged to prevent duplicate transactions on a single order.
        // see footnote in https://www.wepay.com/developer/reference/checkout#create
        $data['unique_id'] = $this->getTransactionId();

        $data['reference_id'] = $this->getTransactionId();
        $data['amount'] = $this->getAmount();
        $data['type'] = $this->getType();
        $data['currency'] = $this->getCurrency();
        $data['short_description'] = $this->getDescription();
        $data['long_description'] = $this->getDescription();
        $data['fee'] = array('fee_payer' => $this->getFeePayer());

        $token = $this->getToken();
        if (isset($token) && !empty($token)) {
            $data['type'] = 'credit_card';
            $data['credit_card'] = array(
                'id' => $token,
            );
        } else {
            $data['hosted_checkout'] = array();
            $data['hosted_checkout']['redirect_uri'] = $this->getReturnUrl();

            if ($this->getCard()) {
                $data['hosted_checkout']['prefill_info'] = array(
                    'name' => $this->getCard()->getName(),
                    'email' => $this->getCard()->getEmail(),
                );
            }
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

            return new PurchaseResponse($this, $response->json());
        } catch (\Guzzle\Http\Exception\BadResponseException $e) {
            $response = $e->getResponse();

            return new PurchaseResponse($this, $response->json());
        }
    }
}
