<?php

namespace Omnipay\WePay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * WePay Complete Purchase Response.
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return is_string($this->getState())
               && in_array($this->getState(), array('authorized', 'reserved', 'captured'));
    }

    public function getState()
    {
        return isset($this->data['state']) ? $this->data['state'] : null;
    }

    public function getTransactionReference()
    {
        return isset($this->data['checkout_id']) ? $this->data['checkout_id'] : null;
    }

    public function getTransactionId()
    {
        return isset($this->data['reference_id']) ? $this->data['reference_id'] : null;
    }

    public function getCode()
    {
        return isset($this->data['error_code']) ? $this->data['error_code'] : null;
    }

    public function getMessage()
    {
        // when the state of a payment falls within these, no error message ($this->data['error_description'] is blank)
        // is returned hence these default error messages.
        /*
         * @todo include test for these. Just too lazy to write these test.
         */
        switch ($this->getState()) {
            case 'failed':
                $error = 'Payment failed. Try again.';
                break;
            case 'expired':
                $error = 'Checkout expired. Try again.';
                break;
            case 'cancelled':
                $error = 'Payment cancelled.';
                break;
            default:
                $error = isset($this->data['error_description']) ? $this->data['error_description'] : null;
        }

        return $error;
    }
}
