<?php

namespace Omnipay\WePay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * WePay Purchase Response.
 */
class CustomCheckoutResponse extends AbstractResponse implements ResponseInterface
{
    public function getRequest()
    {
        return $this->request;
    }

    public function isSuccessful()
    {
        return isset($this->data['checkout_id']) && is_int($this->data['checkout_id']);
    }

    public function getCode()
    {
        return isset($this->data['error_code']) ? $this->data['error_code'] : null;
    }

    public function getMessage()
    {
        return isset($this->data['error_description']) ? $this->data['error_description'] : null;
    }

    public function isRedirect()
    {
        return false;
    }

    public function getTransactionId()
    {
        return isset($this->data['reference_id']) ? $this->data['reference_id'] : null;
    }

    public function getTransactionReference()
    {
        return isset($this->data['checkout_id']) ? $this->data['checkout_id'] : null;
    }
}
