<?php

namespace Omnipay\WePay;

use Omnipay\Common\AbstractGateway;

/**
 * WePay Gateway
 *
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
            'accountId'   => '',
            'accessToken' => '',
            'type'        => 'goods',
            'testMode'    => false,
            'feePayer'    => 'payee'
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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WePay\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WePay\Message\CompletePurchaseRequest', $parameters);
    }
}
