<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $mockPlugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $mockPlugin->addResponse($this->getMockHttpResponse('PurchaseSuccess.txt'));
        $mockPlugin->addResponse($this->getMockHttpResponse('PurchaseFailure.txt'));

        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mockPlugin);

        $this->request = new PurchaseRequest($httpClient, $this->getHttpRequest());
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
            'returnUrl'     => 'http://localhost.dev/wp-content/plugins/omnipaywp/complete.php',
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('783276130', $data['account_id']);
        $this->assertSame('12345', $data['reference_id']);
        $this->assertSame('25.50', $data['amount']);
        $this->assertSame('USD', $data['currency']);
        $this->assertSame('A vacation home rental', $data['short_description']);
        $this->assertSame('payee', $data['fee']['fee_payer']);
        $this->assertSame('783276130', $data['account_id']);
        $this->assertSame('goods', $data['type']);
        $this->assertSame('http://localhost.dev/wp-content/plugins/omnipaywp/complete.php', $data['hosted_checkout']['redirect_uri']);
        $this->assertSame('Agbonghama Collins', $data['hosted_checkout']['prefill_info']['name']);
        $this->assertSame('me@w3guy.com', $data['hosted_checkout']['prefill_info']['email']);
    }

    public function testSendData()
    {
        $data = $this->request->getData();

        // Test PurchaseSuccess.txt
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WePay\Message\PurchaseResponse', get_class($response));

        // Test PurchaseFailure.txt
        $response = $this->request->sendData($data);

        $this->assertSame('Omnipay\WePay\Message\PurchaseResponse', get_class($response));
    }

}
