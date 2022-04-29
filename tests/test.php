<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Edwinmugendi\Sapamapay\MpesaApi;

$mpesa_api = new MpesaApi();

$configs = array(
    'AccessToken' => 'ACCESSTOKEN',
    'Environment' => 'live',
    'Content-Type' => 'application/json',
    'Verbose' => '',
);

$passkey = '';
$shortcode = '';
$phone = '254722906835';
$consumer_key = '';
$consumer_secret = '';

$timestamp = preg_replace('/\D/', '', date('Y-m-d H:i:s'));


$api = 'pull_transaction_api';

if ($api == 'stkpush') {
    $parameters = array(
        'BusinessShortCode' => $shortcode,
        'Password' => base64_encode($shortcode . $passkey . $timestamp),
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => '1',
        'PartyA' => $phone,
        'PartyB' => $shortcode,
        'PhoneNumber' => $phone,
        'CallBackURL' => 'http://sapamacash.com/api/mpesa_stkpush_callback',
        'AccountReference' => 'Sapama ERP 123',
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
        'PartyA' => '830830',
        'IdentifierType' => '830830',
        'Remarks' => 'remarks',
        'Initiator' => 'SAPAMA',
        'SecurityCredential' => 'TkNZpjhQ',
        'QueueTimeOutURL' => 'https://url',
        'ResultURL' => 'https://url',
        'TransactionID' => 'QDO9WMW6YD',
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
} else if ($api == 'pull_register_url') {

    $parameters = array(
        'ShortCode' => '830830',
        'RequestType' => 'Pull',
        'NominatedNumber' => $phone,
        'CallBackURL' => 'https://pullapi',
    );
} else if ($api == 'pull_transaction_api') {

    $days_ago = date('Y-m-d H:i:s', strtotime('-1 days', strtotime(date('Y-m-d'))));

    $parameters = array(
        'ShortCode' => '830830',
        'StartDate' => $days_ago,
        'EndDate' => date('Y-m-d H:i:s'),
        'OffSetValue' => '0',
    );
} else if ($api == 'generate_token') {
    $parameters = array(
        'ConsumerKey' => '',
        'ConsumerSecret' => '',
    );
}//E# if statement
//$response = $mpesa_api->call($api, $configs, $parameters);

$access_token_parameters = array(
    'ConsumerKey' => $consumer_key,
    'ConsumerSecret' => $consumer_secret,
);

$response = $mpesa_api->call('generate_token', $configs, $access_token_parameters);

if ($response['Response']['access_token']) {
    $configs['AccessToken'] = $response['Response']['access_token'];

    $response = $mpesa_api->call($api, $configs, $parameters);
}//E# if statement


echo 'JSON response: <p>';
echo json_encode($response);
echo '<p>Response var_dump:<p>';
var_dump($response);
var_dump($response['Response']['Response']);
