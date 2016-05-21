<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;

class CancelRequestTest extends TestCase
{
    /** @var object cancelReason set */
    private $request;

    /** @var object refundReason set */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $mockPlugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $mockPlugin->addResponse($this->getMockHttpResponse('CancelSuccess.txt'));
        $mockPlugin->addResponse($this->getMockHttpResponse('CancelFailure.txt'));

        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mockPlugin);

        $this->request  = new CancelRequest($httpClient, $this->getHttpRequest());

        $this->request->initialize(array(
            'transactionReference' => '670902310',
            'cancelReason'         => 'We needed to',
        ));

        $this->request2  = new CancelRequest($httpClient, $this->getHttpRequest());

        $this->request2->initialize(array(
            'transactionReference' => '670902310',
            'refundReason'         => 'Just because',
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame(670902310, $data['checkout_id']);
        $this->assertSame('We needed to', $data['cancel_reason']);

        $data = $this->request2->getData();

        $this->assertSame(670902310, $data['checkout_id']);
        $this->assertSame('Just because', $data['cancel_reason']);
    }

    public function testSendData()
    {
        $data  = $this->request->getData();

        // Test CancelSuccess.txt
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WePay\Message\CancelResponse', get_class($response));

        // Test CancelFailure.txt
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WePay\Message\CancelResponse', get_class($response));
    }

}
