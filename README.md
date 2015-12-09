# Omnipay: WePay

**WePay driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/collizo4sky/omnipay-wepay.png?branch=master)](https://travis-ci.org/collizo4sky/omnipay-wepay)
[![Coverage Status](https://coveralls.io/repos/collizo4sky/omnipay-wepay/badge.svg?branch=master&service=github)](https://coveralls.io/github/collizo4sky/omnipay-wepay?branch=master)
[![Code Climate](https://codeclimate.com/github/Collizo4sky/omnipay-wepay/badges/gpa.svg)](https://codeclimate.com/github/Collizo4sky/omnipay-wepay)
[![Dependency Status](https://www.versioneye.com/user/projects/561676d2a1933400150005b8/badge.png)](https://www.versioneye.com/user/projects/561676d2a1933400150005b8)

[![Latest Stable Version](https://poser.pugx.org/collizo4sky/omnipay-wepay/version.png)](https://packagist.org/packages/collizo4sky/omnipay-wepay)
[![Total Downloads](https://poser.pugx.org/collizo4sky/omnipay-wepay/d/total.png)](https://packagist.org/packages/collizo4sky/omnipay-wepay)
[![License](https://poser.pugx.org/collizo4sky/omnipay-wepay/license)](https://packagist.org/packages/collizo4sky/omnipay-wepay)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements WePay support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "collizo4sky/omnipay-wepay": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* WePay

You need to set your accountId and accessToken. Setting testMode to true will use the sandbox environment.

This gateway supports WePay off-site and on-site purchase. The on-site purchase is possible through a credit card ID. You can generate the ID through the [JavaScript SDK](https://www.wepay.com/developer/process_payments/tokenization-custom-checkout):

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

### On-site Payment Setup with Credit Card ID

```
$gateway = Omnipay::create('WePay');
$gateway->setAccountId('583276666');
$gateway->setAccessToken('STAGE_ca4cf9c5d209343d18dae0fc47b908f2d17b47654eecb1fc55bc8652946kdirl');
$gateway->setTestMode(true);

$formData = array('firstName' => 'Foo', 'lastName' => 'Baz', 'email' => 'hello@mailinator.com');

$response = $gateway->purchase(
    array(
        'token' => '3843295557',
        'transactionId' => '12345678',
        'amount'        => '25.50',
        'currency'      => 'USD',
        'description'   => 'A vacation home rental',
        'returnUrl'     => 'http://localhost.dev/wepay/complete.php'
    )
)->send();
```


### Off-site Payment Setup without Credit Card ID

```
$gateway = Omnipay::create('WePay');
$gateway->setAccountId('583276666');
$gateway->setAccessToken('STAGE_ca4cf9c5d209343d18dae0fc47b908f2d17b47654eecb1fc55bc8652946kdirl');
$gateway->setTestMode(true);

$formData = array('firstName' => 'Foo', 'lastName' => 'Baz', 'email' => 'hello@mailinator.com');

$response = $gateway->purchase(
    array(
        'transactionId' => '12345678',
        'amount'        => '25.50',
        'currency'      => 'USD',
        'description'   => 'A vacation home rental',
        'returnUrl'     => 'http://localhost.dev/wepay/complete.php'
    )
)->send();
```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/collizo4sky/omnipay-wepay/issues),
or better yet, fork the library and submit a pull request.
