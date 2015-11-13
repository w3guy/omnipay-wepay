<?php
namespace Omnipay\WePay\Message;

use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
{
    private $request, $httpClient;

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest(array('checkout_id' => '1902960209'));

        $this->httpClient = $this->getHttpClient();

        $this->request = new CompletePurchaseRequest($this->httpClient, $httpRequest);
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
            'returnUrl'     => 'http://localhost.dev/wepay/complete.php',
        ));
    }

    public function testException()
    {
        $httpRequest   = new HttpRequest();
        $this->request = new CompletePurchaseRequest($this->httpClient, $httpRequest);
        try {
            $this->request->getData();
        }
        catch (\Exception $e) {
            $this->assertEquals('Omnipay\Common\Exception\InvalidResponseException', get_class($e));
        }
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('1902960209', $data['checkout_id']);
    }

    public function testSendData()
    {
        $data     = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WePay\Message\CompletePurchaseResponse', get_class($response));
    }

}
