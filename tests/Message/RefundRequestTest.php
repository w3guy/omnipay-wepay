<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $mockPlugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $mockPlugin->addResponse($this->getMockHttpResponse('RefundSuccess.txt'));
        $mockPlugin->addResponse($this->getMockHttpResponse('RefundFailure.txt'));

        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mockPlugin);

        $this->request  = new RefundRequest($httpClient, $this->getHttpRequest());

        $this->request->initialize(array(
            'transactionReference' => '670902310',
            'refundReason'         => 'Just because',
            'amount'               => '25.50',
            'applicationFee'              => '2.13',
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame(670902310, $data['checkout_id']);
        $this->assertSame('Just because', $data['refund_reason']);
        $this->assertSame('25.50', $data['amount']);
        $this->assertSame('2.13', $data['app_fee']);
    }

    public function testSendData()
    {
        $data  = $this->request->getData();

        // Test RefundSuccess.txt
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WePay\Message\RefundResponse', get_class($response));

        // Test RefundFailure.txt
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WePay\Message\RefundResponse', get_class($response));
    }

}
