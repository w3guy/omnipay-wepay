<?php

namespace Omnipay\WePay;

use Omnipay\Common\AbstractGateway;

/**
 * WePay Gateway.
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'WePay';
    }

    public function getDefaultParameters()
    {
        return array(
            'accountId' => '',
            'accessToken' => '',
            'type' => 'goods',
            'testMode' => false,
            'feePayer' => 'payee',
        );
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

    public function getFeePayer()
    {
        return $this->getParameter('feePayer');
    }

    public function setFeePayer($value)
    {
        return $this->setParameter('feePayer', $value);
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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WePay\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WePay\Message\RefundRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WePay\Message\CancelRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WePay\Message\CompletePurchaseRequest', $parameters);
    }

    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WePay\Message\FetchTransactionRequest', $parameters);
    }
}
