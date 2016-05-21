<?php

namespace Omnipay\WePay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * WePay Cancel Response.
 */
class CancelResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return is_string($this->getState())
        && $this->getState() == 'cancelled';
    }

    public function getState()
    {
        return isset($this->data['state']) ? $this->data['state'] : null;
    }

    public function getTransactionReference()
    {
        return isset($this->data['checkout_id']) ? $this->data['checkout_id'] : null;
    }

    public function getCode()
    {
        return isset($this->data['error_code']) ? $this->data['error_code'] : null;
    }

    public function getMessage()
    {
        return isset($this->data['error_description']) ? $this->data['error_description'] : null;
    }
}
