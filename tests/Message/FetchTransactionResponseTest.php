<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;

class FetchTransactionResponseTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize(array(
            'transactionReference' => 1902960209
        ));
    }

    public function testFailure()
    {
        $httpResponse = $this->getMockHttpResponse('FetchTransactionFailure.txt');
        $response     = new FetchTransactionResponse($this->request, $httpResponse->json());
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(4001, $response->getCode());
        $this->assertSame('there is no checkout with that ID', $response->getMessage());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getTransactionId());
    }

    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('FetchTransactionSuccess.txt');
        $response     = new FetchTransactionResponse($this->request, $httpResponse->json());
        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('12345', $response->getTransactionId());
        $this->assertSame(1902960209, $response->getTransactionReference());
    }
}