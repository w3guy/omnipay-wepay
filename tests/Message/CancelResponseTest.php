<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;

class CancelResponseTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new CancelRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'transactionReference' => '670902310',
            'cancelReason'         => 'Just because',
        ));
    }

    public function testFailure()
    {
        $httpResponse = $this->getMockHttpResponse('CancelFailure.txt');
        $response     = new CancelResponse($this->request, $httpResponse->json());
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(1004, $response->getCode());
        $this->assertSame('cancel_reason parameter is required', $response->getMessage());
        $this->assertNull($response->getTransactionReference());
    }

    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('CancelSuccess.txt');
        $response     = new CancelResponse($this->request, $httpResponse->json());
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame(783276130, $response->getTransactionReference());
        $this->assertSame('cancelled', $response->getState());
    }
}