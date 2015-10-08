<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;

class FetchTransactionRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $httpResponse = $this->getMockHttpResponse('FetchTransactionSuccess.txt');

        $mockPlugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $mockPlugin->addResponse($httpResponse);

        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mockPlugin);

        $this->request = new FetchTransactionRequest($httpClient, $this->getHttpRequest());
        /*
         * This works too.
         * $this->request->setTransactionReference('1549070253');
         */
        $this->request->initialize(array(
            'transactionReference' => '1549070253'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('1549070253', $data['checkout_id']);
    }

    public function testSendData()
    {
        $data     = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WePay\Message\FetchTransactionResponse', get_class($response));
    }

}
