<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'transactionId' => '12345',
            'amount'        => '25.50',
            'currency'      => 'USD',
            'description'   => 'A vacation home rental',
            'feePayer'      => 'payee',
            'accountId'     => '783276130',
            'type'          => 'goods',
            'card'          => array('firstName' => 'Agbonghama', 'lastName' => 'Collins', 'email' => 'me@w3guy.com'),
            'accessToken'   => 'STAGE_ca4cf9c5d2d4623d18dae0fc47b908f2d17b47654eecb1fc55bc8652945927cd',
            'returnUrl'     => 'http://localhost.dev/wepay/complete.php'
        ));
    }

    public function testFailure()
    {
        $httpResponse = $this->getMockHttpResponse('FetchTransactionFailure.txt');
        $response     = new CompletePurchaseResponse($this->request, $httpResponse->json());
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(4001, $response->getCode());
        $this->assertSame('there is no checkout with that ID', $response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
    }

    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('FetchTransactionSuccess.txt');
        $response     = new CompletePurchaseResponse($this->request, $httpResponse->json());
        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame(1902960209, $response->getTransactionReference());
        $this->assertSame('12345', $response->getTransactionId());
    }
}