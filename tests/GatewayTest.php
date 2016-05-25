<?php
namespace Omnipay\WePay;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setAccountId('783276130');
        $this->gateway->setAccessToken('STAGE_ca4cf9c5d2d4623d18dae0fc47b908f2d17b47654eecb1fc55bc8652945927cd');
        $this->gateway->setTestMode(true);
        $this->gateway->setFeePayer('payee');
    }

    public function testGateway()
    {
        $this->assertSame('783276130', $this->gateway->getAccountId());
        $this->assertSame('STAGE_ca4cf9c5d2d4623d18dae0fc47b908f2d17b47654eecb1fc55bc8652945927cd', $this->gateway->getAccessToken());
        $this->assertSame('payee', $this->gateway->getFeePayer());

        $this->gateway->setMode('regular');
        $this->assertSame('regular', $this->gateway->getMode());

        $this->gateway->setRegion('GA');
        $this->assertSame('GA', $this->gateway->getRegion());

        $this->gateway->setFallbackUri('http://localhost.dev/wepay/fallback.php');
        $this->assertSame('http://localhost.dev/wepay/fallback.php', $this->gateway->getFallbackUri());

        $this->gateway->setShippingFee('5.34');
        $this->assertSame('5.34', $this->gateway->getShippingFee());

        $this->gateway->setRequireShipping(true);
        $this->assertSame(true, $this->gateway->getRequireShipping());

        $this->gateway->setRequireShipping(false);
        $this->assertSame(false, $this->gateway->getRequireShipping());

        $this->gateway->setFundingSources(array("credit_card"));
        $this->assertEquals(array("credit_card"), $this->gateway->getFundingSources());
    }

    public function testPurchase()
    {
        $formData = array('firstName' => 'Agbonghama', 'lastName' => 'Collins', 'email' => 'me@w3guy.com');

        $request = $this->gateway->purchase(array(
            'transactionId' => '12345',
            'amount'        => '25.50',
            'applicationFee'=> '2.13',
            'currency'      => 'USD',
            'description'   => 'A vacation home rental',
            'returnUrl'     => 'http://localhost.dev/wepay/complete.php',
            'callbackUri'   => 'http://localhost.dev/wepay/hook.php',
            'card'          => $formData
        ));

        $this->assertSame('12345', $request->getTransactionId());
        $this->assertSame('25.50', $request->getAmount());
        $this->assertSame('2.13', $request->getApplicationFee());
        $this->assertSame('USD', $request->getCurrency());
        $this->assertSame('A vacation home rental', $request->getDescription());
        $this->assertSame('http://localhost.dev/wepay/complete.php', $request->getReturnUrl());
        $this->assertSame('http://localhost.dev/wepay/hook.php', $request->getCallbackUri());
        $this->assertSame('Agbonghama Collins', $request->getCard()->getName());
        $this->assertSame('me@w3guy.com', $request->getCard()->getEmail());
    }

    public function testCompletePurchase()
    {

        $formData = array('firstName' => 'Agbonghama', 'lastName' => 'Collins', 'email' => 'me@w3guy.com');

        $request = $this->gateway->completePurchase(array(
            'transactionId' => '12345',
            'amount'        => '25.50',
            'applicationFee'=> '2.13',
            'currency'      => 'USD',
            'description'   => 'A vacation home rental',
            'returnUrl'     => 'http://localhost.dev/wepay/complete.php',
            'callbackUri'   => 'http://localhost.dev/wepay/hook.php',
            'card'          => $formData
        ));

        $this->assertSame('12345', $request->getTransactionId());
        $this->assertSame('25.50', $request->getAmount());
        $this->assertSame('2.13', $request->getApplicationFee());
        $this->assertSame('USD', $request->getCurrency());
        $this->assertSame('A vacation home rental', $request->getDescription());
        $this->assertSame('http://localhost.dev/wepay/complete.php', $request->getReturnUrl());
        $this->assertSame('http://localhost.dev/wepay/hook.php', $request->getCallbackUri());
        $this->assertSame('Agbonghama Collins', $request->getCard()->getName());
        $this->assertSame('me@w3guy.com', $request->getCard()->getEmail());
    }

    public function testRefund()
    {
        $request = $this->gateway->refund(array(
            'transactionReference' => '670902310',
            'refundReason'         => 'Just because',
            'amount'               => '25.50',
            'applicationFee'       => '2.13',
        ));

        $this->assertSame('670902310', $request->getTransactionReference());
        $this->assertSame('Just because', $request->getRefundReason());
        $this->assertSame('25.50', $request->getAmount());
        $this->assertSame('2.13', $request->getApplicationFee());
    }

    public function testVoid()
    {
        $request = $this->gateway->void(array(
            'transactionReference' => '670902310',
            'cancelReason'         => 'Just because',
        ));

        $this->assertSame('670902310', $request->getTransactionReference());
        $this->assertSame('Just because', $request->getCancelReason());
    }


    public function testFetchTransactionRequest()
    {
        $request = $this->gateway->fetchTransaction(array('transactionReference' => '670902310'));

        $this->assertSame('670902310', $request->getTransactionReference());
    }
}
