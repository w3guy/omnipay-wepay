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
        return $this->getApiUrl() . 'checkout/create';
    }

    public function getFeePayer()
    {
        return $this->getParameter('feePayer');
    }

    public function setFeePayer($value)
    {
        return $this->setParameter('feePayer', $value);
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


    public function getApiHeader()
    {
        return array(
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type'  => 'application/json'
        );
    }
}