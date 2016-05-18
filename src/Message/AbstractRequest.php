<?php

namespace Omnipay\WePay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://wepayapi.com/v2/';
    protected $testEndpoint = 'https://stage.wepayapi.com/v2/';

    public function getApiUrl()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function getEndpoint()
    {
        return $this->getApiUrl().'checkout/create';
    }

    public function getFeePayer()
    {
        return $this->getParameter('feePayer');
    }

    public function setFeePayer($value)
    {
        return $this->setParameter('feePayer', $value);
    }

    public function getApplicationFee()
    {
        return $this->getParameter('applicationFee');
    }

    public function setApplicationFee($value)
    {
        return $this->setParameter('applicationFee', $value);
    }

    public function getType()
    {
        return $this->getParameter('type');
    }

    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    public function getAccessToken()
    {
        return $this->getParameter('accessToken');
    }

    public function setAccessToken($value)
    {
        return $this->setParameter('accessToken', $value);
    }

    public function getRegion()
    {
        return $this->getParameter('region');
    }

    public function setRegion($value)
    {
        return $this->setParameter('region', $value);
    }

    public function getMode()
    {
        return $this->getParameter('mode');
    }

    public function setMode($value)
    {
        return $this->setParameter('mode', $value);
    }

    public function getFallbackUri()
    {
        return $this->getParameter('fallbackUri');
    }

    public function setFallbackUri($value)
    {
        return $this->setParameter('fallbackUri', $value);
    }

    public function getCallbackUri()
    {
        return $this->getParameter('callbackUri');
    }

    public function setCallbackUri($value)
    {
        return $this->setParameter('callbackUri', $value);
    }

    public function getShippingFee()
    {
        return $this->getParameter('shippingFee');
    }

    public function setShippingFee($value)
    {
        return $this->setParameter('shippingFee', $value);
    }

    public function getRequireShipping()
    {
        return $this->getParameter('requireShipping');
    }

    public function setRequireShipping($value)
    {
        return $this->setParameter('requireShipping', $value);
    }

    public function getFundingSources()
    {
        return $this->getParameter('fundingSources');
    }

    public function setFundingSources($value)
    {
        return $this->setParameter('fundingSources', $value);
    }

    public function getTransactionReference()
    {
        return $this->getParameter('transactionReference');
    }

    public function setTransactionReference($value)
    {
        return $this->setParameter('transactionReference', $value);
    }

    public function getRefundReason()
    {
        return $this->getParameter('refundReason');
    }

    public function setRefundReason($value)
    {
        return $this->setParameter('refundReason', $value);
    }

    public function getCancelReason()
    {
        return $this->getParameter('cancelReason');
    }

    public function setCancelReason($value)
    {
        return $this->setParameter('cancelReason', $value);
    }

    public function getApiHeader()
    {
        return array(
            'Authorization' => 'Bearer '.$this->getAccessToken(),
            'Content-Type' => 'application/json',
        );
    }
}
