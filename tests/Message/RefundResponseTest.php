<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;

class RefundResponseTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'transactionReference' => '670902310',
            'refundReason'         => 'Just because',
            'amount'               => '25.50',
            'app_fee'              => '2.13',
        ));
    }

    public function testFailure()
    {
        $httpResponse = $this->getMockHttpResponse('RefundFailure.txt');
        $response     = new RefundResponse($this->request, $httpResponse->json());
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(1004, $response->getCode());
        $this->assertSame('refund_reason parameter is required', $response->getMessage());
        $this->assertNull($response->getTransactionReference());
    }

    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('RefundSuccess.txt');
        $response     = new RefundResponse($this->request, $httpResponse->json());
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame(783276130, $response->getTransactionReference());
        $this->assertSame('refunded', $response->getState());
    }
}