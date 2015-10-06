<?php

require __DIR__ . '/vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create( 'WePay' );
$gateway->setAccountId( '783276130' );
$gateway->setAccessToken( 'STAGE_ca4cf9c5d2d4623d18dae0fc47b908f2d17b47654eecb1fc55bc8652945927cd' );
$gateway->setTestMode( true );

$formData = array( 'firstName' => 'Agbonghama', 'lastName' => 'Collins', 'email' => 'me@w3guy.com' );

$response = $gateway->completePurchase(
    array(
        'transactionId' => '12345',
        'amount'            => '25.50',
        'currency'          => 'USD',
        'description' => 'A vacation home rental' . "\n" . 'A vacation home rental2',
        'returnUrl'         => 'http://localhost.dev/wp-content/plugins/omnipaywp/complete.php',
        'card'              => $formData
    )
)->send();


var_dump($response->getMessage());