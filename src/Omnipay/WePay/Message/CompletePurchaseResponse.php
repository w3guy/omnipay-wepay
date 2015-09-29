<?php

namespace Omnipay\WePay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * WePay Complete Purchase Response
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset( $this->data['checkout_id'] );
    }

    public function getTransactionReference()
    {
        return isset( $this->data['checkout_id'] ) ? $this->data['checkout_id'] : null;
    }
}
