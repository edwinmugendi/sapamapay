<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Edwinmugendi\Sapamapay\KcbApi;

$kcb_api = new KcbApi();

$configs = array(
    'AccessToken' => 'ACCESSTOKEN',
    'Environment' => 'live',
    'Content-Type' => 'application/json',
    //'Verbose' => '',
);

$passkey = '';
$shortcode = '';
$phone = '254722906835';
$consumer_key = 'wj7s3TbfJFKBipnM_uE1ium1tA8a';
$consumer_secret = '9ZElMj4Z6Ym1EVvJkfc3jnIPHyUa';

$timestamp = preg_replace('/\D/', '', date('Y-m-d H:i:s'));

$api = 'stkpush';

if ($api == 'stkpush') {
    //Sandbox
    $parameters = array(
        'phoneNumber' => '254722906835',
        'amount' => 1,
        'invoiceNumber' => 'INV-1013',
        'sharedShortCode' => true,
        'orgShortCode' => '174379',
        'orgPassKey' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
        'callbackUrl' => 'https://posthere.io/f613-4b7f-b82b',
        'transactionDescription' => 'School fees',
    );

    //KCB One till
    $parameters = array(
        'phoneNumber' => '254722906835',
        'amount' => 1,
        'invoiceNumber' => '7588377-001',//ONE TILL - Account Number. The whole invoice number should be 15 characters. 
        'sharedShortCode' => true,
        'orgShortCode' => '',//Empty
        'orgPassKey' => '',//Empty
        'callbackUrl' => 'https://posthere.io/4ff4-4721-b2ed',
        'transactionDescription' => 'School fees',
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
    'grant_type'=>'client_credentials'
);

//var_dump($access_token_parameters);

$response = $kcb_api->call('generate_token', $configs, $access_token_parameters);

var_dump($response);

if ($response['Response']['access_token']) {
    
    $configs['AccessToken'] = $response['Response']['access_token'];
    $configs['Verbose'] = true;
    echo $configs['AccessToken'];

    $response = $kcb_api->call($api, $configs, $parameters);

    var_dump($response);
}//E# if statement



die("asd");

echo 'JSON response: <p>';
echo json_encode($response);
echo '<p>Response var_dump:<p>';
var_dump($response);
var_dump($response['Response']['Response']);
