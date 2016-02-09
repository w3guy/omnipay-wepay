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
            $data['hosted_checkout']['redirect_uri'] = $this->getReturnUrl();
            $data['hosted_checkout']['mode'] = $this->getMode();
            $data['hosted_checkout']['fallback_uri'] = $this->getFallbackUri();
            $data['hosted_checkout']['shipping_fee'] = $this->getShippingFee();
            $data['hosted_checkout']['require_shipping'] = $this->getRequireShipping();
            $data['hosted_checkout']['funding_sources'] = $this->getFundingSources();

            if ($this->getCard()) {
                $data['hosted_checkout']['prefill_info'] = array(
                    'name' => $this->getCard()->getName(),
                    'email' => $this->getCard()->getEmail(),
                    'phone_number' => $this->getCard()->getEmail(),
                    'address' => $this->getCard()->getAddress1(),
                    'city' => $this->getCard()->getCity(),
                    'state' => $this->getCard()->getState(),
                    'region' => $this->getRegion(),
                    'country' => $this->getCard()->getCountry(),
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
