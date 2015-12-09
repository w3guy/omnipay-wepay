<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;

class CustomCheckoutResponseTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'transactionId' => '12345',
            'amount'        => '25.50',
            'currency'      => 'USD',
            'token'         => '3827187391',
            'description'   => 'A vacation home rental',
            'feePayer'      => 'payee',
            'accountId'     => '783276130',
            'type'          => 'goods',
            'card'          => array('firstName' => 'Agbonghama', 'lastName' => 'Collins', 'email' => 'me@w3guy.com'),
            'accessToken'   => 'STAGE_ca4cf9c5d2d4623d18dae0fc47b908f2d17b47654eecb1fc55bc8652945927cd'
        ));
    }

    public function testFailure()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseFailure.txt');
        $response     = new CustomCheckoutResponse($this->request, $httpResponse->json());
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(1004, $response->getCode());
        $this->assertSame('account_id parameter is required', $response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
    }

    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('CustomCheckoutPurchaseSuccess.txt');
        $response     = new CustomCheckoutResponse($this->request, $httpResponse->json());
        $this->assertTrue($response->isSuccessful());
        $this->assertSame($this->request, $response->getRequest());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('12345', $response->getTransactionId());
        $this->assertSame(1202252646, $response->getTransactionReference());
    }
}