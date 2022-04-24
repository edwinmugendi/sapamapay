
![](https://cloud.githubusercontent.com/assets/829059/9216039/82be51cc-40f6-11e5-88f5-f0cbd07bcc39.png)

[![Build Status](https://img.shields.io/travis/dingo/api/master.svg?style=flat-square)](https://travis-ci.org/dingo/api)
[![License](https://img.shields.io/packagist/l/dingo/api.svg?style=flat-square)](LICENSE)
[![Development Version](https://img.shields.io/packagist/vpre/dingo/api.svg?style=flat-square)](https://packagist.org/packages/dingo/api)
[![Monthly Installs](https://img.shields.io/packagist/dm/dingo/api.svg?style=flat-square)](https://packagist.org/packages/dingo/api)
[![StyleCI](https://styleci.io/repos/18673522/shield)](https://styleci.io/repos/18673522)

## SapamaPay API
This library is an API wrapper to the following [Safaricom MPESA API's](https://developer.safaricom.co.ke/)

- [Lipa Na M-Pesa Online Payment API](https://developer.safaricom.co.ke/lipa-na-m-pesa-online/apis/post/stkpush/v1/processrequest)
- [Lipa Na M-Pesa Query Request API](https://developer.safaricom.co.ke/lipa-na-m-pesa-online/apis/post/stkpushquery/v1/query)
- [Account Balance Request](https://developer.safaricom.co.ke/account-balance/apis/post/query)
- [B2B Payment Request](https://developer.safaricom.co.ke/b2b/apis/post/paymentrequest)
- [B2C Payment Request](https://developer.safaricom.co.ke/b2c/apis/post/paymentrequest)
- [Transaction Status Request](https://developer.safaricom.co.ke/transaction-status/apis/post/query)
- [C2B Simulate Transaction](https://developer.safaricom.co.ke/c2b/apis/post/simulate)
- [C2B Register URL](https://developer.safaricom.co.ke/c2b/apis/post/registerurl)
- [Reversal](https://developer.safaricom.co.ke/reversal/apis/post/request)
- [Generate Token](https://developer.safaricom.co.ke/oauth/apis)

##Installation

###Requirements

PHP >=4.0.2

Add `edwinmugendi/sapamapay` to `composer.json`.
```
"edwinmugendi/sapamapay": "master"
```

Run `composer update` to pull down the latest version.

Or run
```
composer require edwinmugendi/sapamapay
```
Without composer. Download the source code and `require_once` the `autoload.php`

```
require_once __DIR__ . '/../vendor/autoload.php';
```
##Testing
Update the `$api` variable to the API you want to run. 

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Edwinmugendi\Sapamapay\MpesaApi;

$mpesa_api = new MpesaApi();
$configs = array(
    'AccessToken' => 'ACCESSTOKEN',
    'Environment' => 'sandbox',
    'Content-Type' => 'application/json',
    'Verbose' => 'true',
);

$api = 'generate_token';

if ($api == 'stk_push') {
    $parameters = array(
        'BusinessShortCode' => '603013',
        'Password' => 'TkNZpjhQ',
        'Timestamp' => '20171010101010',
        'TransactionType' => 'TransactionType',
        'Amount' => '10',
        'PartyA' => '254708374149',
        'PartyB' => '603013',
        'PhoneNumber' => '254708374149',
        'CallBackURL' => 'https://url',
        'AccountReference' => '1232',
        'TransactionDesc' => 'TESTING',
    );
} else if ($api == 'stk_query') {
    $parameters = array(
        'BusinessShortCode' => '603013',
        'Password' => 'TkNZpjhQ',
        'Timestamp' => '20171010101010',
        'CheckoutRequestID' => 'ws_co_123456789',
    );
} else if ($api == 'account_balance') {
    $parameters = array(
        'CommandID' => 'AccountBalance',
        'PartyA' => '603013',
        'IdentifierType' => '4',
        'Remarks' => 'Remarks',
        'Initiator' => 'apiop41',
        'SecurityCredential' => 'TkNZpjhQ',
        'QueueTimeOutURL' => 'https://url',
        'ResultURL' => 'https://url',
    );
} else if ($api == 'b2b_payment_request') {
    $parameters = array(
        'CommandID' => 'BusinessPayBill',
        'Amount' => '10',
        'PartyA' => '603013',
        'SenderIdentifierType' => '4',
        'PartyB' => '600000',
        'RecieverIdentifierType' => '4',
        'Remarks' => 'Remarks',
        'Initiator' => 'apiop41',
        'SecurityCredential' => 'TkNZpjhQ',
        'QueueTimeOutURL' => 'https://url',
        'ResultURL' => 'https://url',
        'AccountReference' => '12',
    );
} else if ($api == 'b2c_payment_request') {
    $parameters = array(
        'InitiatorName' => 'apiop41',
        'SecurityCredential' => 'TkNZpjhQ',
        'CommandID' => 'SalaryPayment',
        'Amount' => '10',
        'PartyA' => '603013',
        'PartyB' => '254708374149',
        'Remarks' => 'Remarks',
        'QueueTimeOutURL' => 'https://url',
        'ResultURL' => 'https://url',
        'Occasion' => '12',
    );
} else if ($api == 'reversal') {
    $parameters = array(
        'CommandID' => 'TransactionReversal',
        'ReceiverParty' => '254708374149',
        'RecieverIdentifierType' => '1',
        'Remarks' => 'remarks',
        'Initiator' => 'apiop41',
        'SecurityCredential' => 'TkNZpjhQ',
        'QueueTimeOutURL' => 'https://url',
        'ResultURL' => 'https://url',
        'TransactionID' => '11211',
        'Occasion' => '12',
        'Amount' => '10',
    );
} else if ($api == 'transaction_status_request') {
    $parameters = array(
        'CommandID' => 'TransactionStatusQuery',
        'PartyA' => '254708374149',
        'IdentifierType' => '603013',
        'Remarks' => 'remarks',
        'Initiator' => 'apiop41',
        'SecurityCredential' => 'TkNZpjhQ',
        'QueueTimeOutURL' => 'https://url',
        'ResultURL' => 'https://url',
        'TransactionID' => '11211',
        'Occasion' => '12',
    );
} else if ($api == 'c2b_register_url') {
    $parameters = array(
        'ValidationURL' => 'https://url',
        'ConfirmationURL' => 'https://url',
        'ResponseType' => 'Completed',
        'ShortCode' => '603013',
    );
} else if ($api == 'c2b_simulate') {

    $parameters = array(
        'CommandID' => 'CustomerPayBillOnline',
        'Amount' => '100',
        'Msisdn' => '254708374149',
        'BillRefNumber' => 'TESTING',
        'ShortCode' => '603013',
    );
} else if ($api == 'generate_token') {
    $parameters = array(
        'ConsumerKey' => 'CONSUMER_KEY',
        'ConsumerSecret' => 'CONSUMER_SECRET',
    );
}//E# if statement

$response = $mpesa_api->call($api, $configs, $parameters);
echo 'JSON response: <p>';
echo json_encode($response);
echo '<p>Response var_dump:<p>';
var_dump($response);

```
##Authentication
First call the `generate_token` to get the access token
After getting the access token, set it in the `AccessToken` index in the `$configs` to make other calls.

##Configurations
The `$configs` parameters has the following indices

- `AccessToken` - The access token. Get the access to ken by running calling the `generate_token' API 
- `Environment` - Can be `sandbox` (when testing your app) or `live` (when your app is in production) 
- `Content-Type` - Should always be `application/json`
- `Verbose` - (Optional) for easy debugging, set this index to run your code in verbose mode ie echo and var dump parameters
- `Url` - (Optional), this overrides the endpoint. By default we use https://sandbox.safaricom.co.ke/ and https://api.safaricom.co.ke/ for sandbox and live respecitvely. Don't forget the forward slush as the end(/)

```php
$configs = array(
    'AccessToken' => 'ACCESSTOKEN',
    'Environment' => 'sandbox',
    'Content-Type' => 'application/json',
    'Verbose' => 'true', //THIS
);
```

##Response
The response has the following indices

- `Environment` - live or sandbox
- `Name` - The name of the API called
- `HttpVerb` - get or post
- `HttpStatusCode` - HTTP status code
- `HttpStatusMessage` - HTTP status message
- `Message` - Custom Message
- `Response` - Response array
- `Endpoint` - URL called
- `Parameters` - Parameters passed to the URL
- `ExpectedResponse` - Expected Reponse Parameters as documents in the API


Sample Json
```json
{"Environment":"sandbox","Name":"Generate Token","HttpVerb":"get","HttpStatusCode":"200","HttpStatusMessage":"Success","Message":"Success","Response":{"access_token":"YdiXeOksM3G9WVgl7jR1pCtT2Ckt","expires_in":"3599"},"Endpoint":"https:\/\/sandbox.safaricom.co.ke\/oauth\/v1\/generate","Parameters":{"ConsumerKey":"Li2dKUeKhlX6Gw0Fpkbq6LEBndlpOuxZ","ConsumerSecret":"hX3Yyd0BGMBiYaln"},"ExpectedResponse":{"Expiry":{"name":"Token expiry time in seconds.","type":"Integer","sample_value":"3599"},"Access_Token":{"name":"Access token to access other APIs","type":"Alpha-Numeric","sample_value":"O22vJy6rnN2nRAnOPqZ8dkyGxmXG"}}}
```

Sample PHP Var dump

```php
array (size=10)
  'Environment' => string 'sandbox' (length=7)
  'Name' => string 'Generate Token' (length=14)
  'HttpVerb' => string 'get' (length=3)
  'HttpStatusCode' => string '200' (length=3)
  'HttpStatusMessage' => string 'Success' (length=7)
  'Message' => string 'Success' (length=7)
  'Response' => 
    array (size=2)
      'access_token' => string 'YdiXeOksM3G9WVgl7jR1pCtT2Ckt' (length=28)
      'expires_in' => string '3599' (length=4)
  'Endpoint' => string 'https://sandbox.safaricom.co.ke/oauth/v1/generate' (length=49)
  'Parameters' => 
    array (size=2)
      'ConsumerKey' => string 'Li2dKUeKhlX6Gw0Fpkbq6LEBndlpOuxZ' (length=32)
      'ConsumerSecret' => string 'hX3Yyd0BGMBiYaln' (length=16)
  'ExpectedResponse' => 
    array (size=2)
      'Expiry' => 
        array (size=3)
          'name' => string 'Token expiry time in seconds.' (length=29)
          'type' => string 'Integer' (length=7)
          'sample_value' => string '3599' (length=4)
      'Access_Token' => 
        array (size=3)
          'name' => string 'Access token to access other APIs' (length=33)
          'type' => string 'Alpha-Numeric' (length=13)
          'sample_value' => string 'O22vJy6rnN2nRAnOPqZ8dkyGxmXG' (length=28)
```

##Help
For API integration assistance, bugs or assistance, kindly reach me on <a href="mailto:edwinmugendi@gmail.com">edwinmugendi@gmail.com</a>
