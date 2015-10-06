<?php

namespace Omnipay\WePay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * WePay Purchase Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{

    public function isSuccessful()
    {
        return false;
    }

    public function getCode()
    {
        return isset( $this->data['error_code'] ) ? $this->data['error_code'] : null;
    }

    public function getMessage()
    {
        return isset( $this->data['error_description'] ) ? $this->data['error_description'] : null;
    }

    public function isRedirect()
    {
        return isset( $this->data['error'] ) ? false : true;
    }

    public function getRedirectUrl()
    {

        return isset( $this->data['hosted_checkout']['checkout_uri'] ) ? $this->data['hosted_checkout']['checkout_uri'] : null;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getTransactionId()
    {
        return isset( $this->data['reference_id'] ) ? $this->data['reference_id'] : null;
    }

    public function getTransactionReference()
    {
        return isset( $this->data['checkout_id'] ) ? $this->data['checkout_id'] : null;
    }

}