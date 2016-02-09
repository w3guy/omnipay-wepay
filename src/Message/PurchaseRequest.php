<?php

namespace Omnipay\WePay\Message;

use Guzzle\Http\Exception\BadResponseException;

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
        // its important that unique and reference ID are strings else it becomes invalid
        $data['reference_id'] = (string) $this->getTransactionId();
        $data['amount'] = $this->getAmount();
        $data['type'] = $this->getType();
        $data['currency'] = $this->getCurrency();
        $data['short_description'] = $this->getDescription();
        $data['long_description'] = $this->getDescription();
        $data['fee'] = array('fee_payer' => $this->getFeePayer());

        $token = $this->getToken();
        if (isset($token) && !empty($token)) {
            // unique_id must be used with a preapproval or a tokenized credit card
            // this is highly encouraged to prevent duplicate transactions on a single order.
            // see footnote in https://www.wepay.com/developer/reference/checkout#create
            // its important that unique and reference ID are strings else it becomes invalid
            $data['unique_id'] = (string) $this->getTransactionId();
            $data['payment_method']['type'] = 'credit_card';
            $data['payment_method']['credit_card'] = array(
                'id' => $token,
            );
        } else {
            $data['hosted_checkout'] = array();

            $hosted_checkout_args = array(
                'redirect_uri' => $this->getReturnUrl(),
                'mode' => $this->getMode(),
                'fallback_uri' => $this->getFallbackUri(),
                'shipping_fee' => $this->getShippingFee(),
                'require_shipping' => $this->getRequireShipping(),
                'funding_sources' => $this->getFundingSources(),
            );

            foreach ($hosted_checkout_args as $key => $value) {
                if (isset($value)) {
                    $data['hosted_checkout'][$key] = $value;
                }
            }

            if ($this->getCard()) {
                $data['hosted_checkout']['prefill_info'] = array();

                $prefill_info = array(
                    'name' => $this->getCard()->getName(),
                    'email' => $this->getCard()->getEmail(),
                    'phone_number' => $this->getCard()->getPhone(),
                    'address' => $this->getCard()->getAddress1(),
                    'city' => $this->getCard()->getCity(),
                    'state' => $this->getCard()->getState(),
                    'region' => $this->getRegion(),
                    'country' => $this->getCard()->getCountry(),
                );

                foreach ($prefill_info as $key => $value) {
                    if (isset($value)) {
                        $data['hosted_checkout']['prefill_info'][$key] = $value;
                    }
                }
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

            // if credit card token is included in this transaction parameter, instantiate CustomCheckoutReponse
            if (isset($data['payment_method']['credit_card'])) {
                return new CustomCheckoutResponse($this, $response->json());
            } else {
                return new PurchaseResponse($this, $response->json());
            }
        } catch (BadResponseException $e) {
            $response = $e->getResponse();

            return new PurchaseResponse($this, $response->json());
        }
    }
}
