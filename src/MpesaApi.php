<?php

namespace Edwinmugendi\Sapamapay;

/**
 * 
 * New Safaricom MPESA API wrapper
 * 
 * @author Edwin Mugendi <edwinmugendi@gmail.com>
 */
class MpesaApi {

    private $configs;
    private $response;
    private $environment;
    private $sandbox_endpoint = 'https://sandbox.safaricom.co.ke/';
    private $live_endpoint = 'https://api.safaricom.co.ke/';
    private $endpoint = '';
    private $parameters = array();
    private $actual_api = array();
    private $apis = array(
        'draft' => array(
            'name' => '',
            'description' => '',
            'endpoint' => '',
            'type' => '',
            'group' => '',
            'link' => '',
            'parameters' => array(
                '' => array(
                    'name' => '',
                    'required' => true,
                    'type' => '',
                    'possible_value' => '',
                ),
            ),
            'response' => array(
                'Expiry' => array(
                    'name' => '',
                    'type' => '',
                    'sample_value' => '',
                ),
            )
        ),
        'stkpush' => array(
            'name' => 'Lipa Na M-Pesa Online Payment API',
            'description' => 'API to initiate online payment on behalf of a customer.',
            'endpoint' => 'mpesa/stkpush/v1/processrequest',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/lipa-na-m-pesa-online/apis',
            'link' => 'https://developer.safaricom.co.ke/lipa-na-m-pesa-online/apis/post/stkpush/v1/processrequest',
            'parameters' => array(
                'BusinessShortCode' => array(
                    'name' => 'Business Short Code',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'Shortcode (6 digits)',
                ),
                'Password' => array(
                    'name' => 'Password',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'base64.encode(ShortcodePasskeyTimestamp)',
                ),
                'Timestamp' => array(
                    'name' => 'Timestamp',
                    'required' => true,
                    'type' => 'Timestamp',
                    'possible_value' => 'yyyymmddhhiiss',
                ),
                'TransactionType' => array(
                    'name' => 'The transaction type to be used for the request \'CustomerPayBillOnline\'',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'CustomerPayBillOnline',
                ),
                'Amount' => array(
                    'name' => 'The amount to be transacted',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '1',
                ),
                'PartyA' => array(
                    'name' => 'The entity sending the funds',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'MSISDN (12 digits)',
                ),
                'PartyB' => array(
                    'name' => 'The organization receiving the funds',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'Shortcode (6 digits)',
                ),
                'PhoneNumber' => array(
                    'name' => 'The MSISDN sending the funds',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'MSISDN (12 digits)',
                ),
                'CallBackURL' => array(
                    'name' => 'Call Back URL',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'AccountReference' => array(
                    'name' => 'Account Reference',
                    'required' => true,
                    'type' => 'Alpha-Numeric',
                    'possible_value' => 'Any combinations of letters and numbers',
                ),
                'TransactionDesc' => array(
                    'name' => 'Description of the transaction',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'Any string of less then 20 characters',
                ),
            ),
            'response' => array(
                'MerchantRequestID' => array(
                    'name' => 'Merchant Request ID',
                    'type' => 'Numeric',
                    'sample_value' => '1234-1234-1',
                ),
                'CheckoutRequestID' => array(
                    'name' => 'Check out Request ID',
                    'type' => 'String',
                    'sample_value' => 'ws_co_123456789',
                ),
                'ResponseDescription' => array(
                    'name' => 'Response Description message',
                    'type' => 'String',
                    'sample_value' => '-The service request has failed <br>
                                        -The service request has been accepted successfully',
                ),
                'ResponseCode' => array(
                    'name' => 'Response Code',
                    'type' => 'Numeric',
                    'sample_value' => '0<br>
                                        Error codes',
                ),
                'CustomerMessage' => array(
                    'name' => 'Customer Message',
                    'type' => 'String',
                    'sample_value' => 'A sequence of less then 20 characters',
                ),
            )
        ),
        'stk_query' => array(
            'name' => 'Lipa Na M-Pesa Query Request API',
            'description' => 'API to check the status of a Lipa Na M-Pesa Online Payment.',
            'endpoint' => 'mpesa/stkpushquery/v1/query',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/lipa-na-m-pesa-online/apis',
            'link' => 'https://developer.safaricom.co.ke/lipa-na-m-pesa-online/apis/post/stkpushquery/v1/query',
            'parameters' => array(
                'BusinessShortCode' => array(
                    'name' => 'Business Short Code',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'Shortcode (6 digits)',
                ),
                'Password' => array(
                    'name' => 'Password',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'base64.encode(ShortcodePasskeyTimestamp)',
                ),
                'Timestamp' => array(
                    'name' => 'Timestamp',
                    'required' => true,
                    'type' => 'Timestamp',
                    'possible_value' => 'yyyymmddhhiiss',
                ),
                'CheckoutRequestID' => array(
                    'name' => 'Checkout RequestID',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'ws_co_123456789',
                ),
            ),
            'response' => array(
                'MerchantRequestID' => array(
                    'name' => 'Merchant Request ID',
                    'type' => 'Numeric',
                    'sample_value' => '1234-1234-1',
                ),
                'CheckoutRequestID' => array(
                    'name' => 'Check out Request ID',
                    'type' => 'String',
                    'sample_value' => 'ws_co_123456789',
                ),
                'ResponseCode' => array(
                    'name' => 'Response Code',
                    'type' => 'Numeric',
                    'sample_value' => '0<br>
                                        Error codes',
                ),
                'ResultDesc' => array(
                    'name' => 'Result Desc',
                    'type' => 'String',
                    'sample_value' => 'String',
                ),
                'ResponseDescription' => array(
                    'name' => 'Response Description message',
                    'type' => 'String',
                    'sample_value' => '-The service request has failed <br>
                                        -The service request has been accepted successfully',
                ),
                'ResultCode' => array(
                    'name' => 'Result Code',
                    'type' => 'Numeric',
                    'sample_value' => '1032',
                ),
            )
        ),
        'account_balance' => array(
            'name' => 'Account Balance Request',
            'description' => 'API to enquire the balance on an M-Pesa BuyGoods (Till Number).',
            'endpoint' => 'mpesa/accountbalance/v1/query',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/account-balance/apis',
            'link' => 'https://developer.safaricom.co.ke/account-balance/apis/post/query',
            'parameters' => array(
                'CommandID' => array(
                    'name' => 'Takes only \'AccountBalance\' CommandID',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'AccountBalance',
                ),
                'PartyA' => array(
                    'name' => 'Type of organization receiving the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'XXXXXX',
                ),
                'IdentifierType' => array(
                    'name' => 'Type of organization receiving the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '1 – MSISDN<br>
                                         2 – Till Number<br>
                                         4 – Organization short code',
                ),
                'Initiator' => array(
                    'name' => 'This is the credential/username used to authenticate the transaction request.',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'This is the credential/username used to authenticate the transaction request',
                ),
                'SecurityCredential' => array(
                    'name' => 'This is the encrypted password to autheticate the transaction request',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'Encrypted password for the initiator to authenticate using the request',
                ),
                'QueueTimeOutURL' => array(
                    'name' => 'The path that stores information of time out transaction',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'ResultURL' => array(
                    'name' => 'The path that stores information of transactions',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
            ),
            'response' => array(
                'OriginatorConverstionID' => array(
                    'name' => 'The unique request ID for tracking a transaction',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => 'Alpha-numeric string of less then 20 characters',
                ),
                'ConversationID' => array(
                    'name' => 'The unique request ID returned by mpesa for each request made',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => '- Error codes - 500 OK',
                ),
                'ResponseDescription' => array(
                    'name' => 'Response Description message',
                    'type' => 'String',
                    'sample_value' => '- The service request has failed - The service request has been accepted successfully',
                ),
            )
        ),
        'b2b_payment_request' => array(
            'name' => 'B2B Payment Request',
            'description' => 'Api to transit Mpesa Transaction from one company to another.',
            'endpoint' => 'mpesa/b2b/v1/paymentrequest',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/b2b/apis',
            'link' => 'https://developer.safaricom.co.ke/b2b/apis/post/paymentrequest',
            'parameters' => array(
                'CommandID' => array(
                    'name' => 'The command id used to carry out a B2B payment',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'BusinessPayBill,<br>
                                         BusinessBuyGoods,<br>
                                         DisburseFundsToBusiness,<br>
                                         BusinessToBusinessTransfer,<br>
                                         BusinessTransferFromMMFToUtility,<br>
                                         BusinessTransferFromUtilityToMMF,<br>
                                         MerchantToMerchantTransfer,<br>
                                         MerchantTransferFromMerchantToWorking<br>
                                         MerchantServicesMMFAccountTransfer<br>
                                         AgencyFloatAdvance',
                ),
                'Amount' => array(
                    'name' => 'The amount been transacted',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '1',
                ),
                'PartyA' => array(
                    'name' => 'Organization Sending the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'Shortcode (6 digits)',
                ),
                'SenderIdentifierType' => array(
                    'name' => 'Type of organization sending the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '1 – MSISDN<br>
                                         2 – Till Number<br>
                                         4 – Organization short code',
                ),
                'PartyB' => array(
                    'name' => 'Organization Receiving the funds',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'Shortcode (6 digits)',
                ),
                'RecieverIdentifierType' => array(
                    'name' => 'Type of organization receiving the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '1 – MSISDN<br>
                                         2 – Till Number<br>
                                         4 – Organization short code',
                ),
                'Remarks' => array(
                    'name' => 'Comments that are sent along with the transaction. ',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'String of less then 100 characters',
                ),
                'Initiator' => array(
                    'name' => 'This is the credential/username used to authenticate the transaction request.',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'This is the credential/username used to authenticate the transaction request',
                ),
                'SecurityCredential' => array(
                    'name' => 'This is the encrypted password to autheticate the transaction request',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'Encrypted password for the initiator to authenticate using the request',
                ),
                'QueueTimeOutURL' => array(
                    'name' => 'The path that stores information of time out transaction',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'ResultURL' => array(
                    'name' => 'The path that stores information of transactions',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'AccountReference' => array(
                    'name' => 'Account Reference mandatory for "BussinessPaybill" CommandID',
                    'required' => true,
                    'type' => 'Alpha-Numeric',
                    'possible_value' => 'String of less then 20 characters',
                ),
            ),
            'response' => array(
                'OriginatorConverstionID' => array(
                    'name' => 'The unique request ID for tracking a transaction',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => 'Alpha-numeric string of less then 20 characters',
                ),
                'ConversationID' => array(
                    'name' => 'The unique request ID returned by mpesa for each request made',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => '- Error codes - 500 OK',
                ),
                'ResponseDescription' => array(
                    'name' => 'Response Description message',
                    'type' => 'String',
                    'sample_value' => '- The service request has failed - The service request has been accepted successfully',
                ),
            )
        ),
        'b2c_payment_request' => array(
            'name' => 'B2C Payment Request',
            'description' => 'API to transact between an M-Pesa short code to a phone number registered on M-Pesa.',
            'endpoint' => 'mpesa/b2c/v1/paymentrequest',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/b2c/apis',
            'link' => 'https://developer.safaricom.co.ke/b2c/apis/post/paymentrequest',
            'parameters' => array(
                'InitiatorName' => array(
                    'name' => 'The name of the initiator initiating the request',
                    'required' => true,
                    'type' => 'Alpha-numeric',
                    'possible_value' => 'This is the credential/username used to authenticate the transaction request',
                ),
                'SecurityCredential' => array(
                    'name' => 'Encrypted Credential of user getting transaction amount',
                    'required' => true,
                    'type' => 'Alpha-numeric',
                    'possible_value' => 'Encrypted password for the initiator to authenticate the transaction request',
                ),
                'CommandID' => array(
                    'name' => 'Unique command for each transaction type<br>SalaryPayment<br>BusinessPayment<br>PromotionPayment',
                    'required' => true,
                    'type' => 'Alpha-numeric',
                    'possible_value' => '-SalaryPayment<br>-BusinessPayment<br>-PromotionPayment',
                ),
                'Amount' => array(
                    'name' => 'The amount been transacted',
                    'required' => true,
                    'type' => 'Numbers',
                    'possible_value' => '00',
                ),
                'PartyA' => array(
                    'name' => 'Organization /MSISDN sending the transaction',
                    'required' => true,
                    'type' => 'Numbers',
                    'possible_value' => '-Shortcode (6 digits)<br>-MSISDN (12 digits)',
                ),
                'PartyB' => array(
                    'name' => 'MSISDN sending the transaction',
                    'required' => true,
                    'type' => 'Phone number - Country code (254) without the plus sign',
                    'possible_value' => '-MSISDN (12 digits)',
                ),
                'Remarks' => array(
                    'name' => 'Comments that are sent along with the transaction.',
                    'required' => true,
                    'type' => 'Alpha-numeric',
                    'possible_value' => 'Sequence of characters upto 100',
                ),
                'QueueTimeOutURL' => array(
                    'name' => 'The path that stores information of time out transaction',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'ResultURL' => array(
                    'name' => 'The path that stores information of transactions',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'Occassion' => array(
                    'name' => 'Optional Parameter',
                    'required' => false,
                    'type' => 'Alpha-numeric',
                    'possible_value' => 'Sequence of characters up to 100',
                ),
            ),
            'response' => array(
                'OriginatorConverstionID' => array(
                    'name' => 'The unique request ID for tracking a transaction',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => 'Alpha-numeric string of less then 20 characters',
                ),
                'ConversationID' => array(
                    'name' => 'The unique request ID returned by mpesa for each request made',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => '- Error codes - 500 OK',
                ),
                'ResponseDescription' => array(
                    'name' => 'Response Description message',
                    'type' => 'String',
                    'sample_value' => '- The service request has failed - The service request has been accepted successfully',
                ),
            )
        ),
        'transaction_status_request' => array(
            'name' => 'Transaction Status Request',
            'description' => 'Check the transaction status.',
            'endpoint' => 'mpesa/transactionstatus/v1/query',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/transaction-status/apis',
            'link' => 'https://developer.safaricom.co.ke/transaction-status/apis/post/query',
            'parameters' => array(
                'CommandID' => array(
                    'name' => 'Takes only \'TransactionStatusQuery\' command id',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'TransactionStatusQuery',
                ),
                'PartyA' => array(
                    'name' => 'Organization/MSISDN sending the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '-Shortcode (6 digits),<br> -MSISDN (12 Digits)',
                ),
                'IdentifierType' => array(
                    'name' => 'Type of organization receiving the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '1 – MSISDN,<br> 2 – Till Number,<br> 4 – Organization short code',
                ),
                'Remarks' => array(
                    'name' => 'Comments that are sent along with the transaction',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'Sequence of characters up to 100',
                ),
                'Initiator' => array(
                    'name' => 'The name of Initiator to initiating  the request',
                    'required' => true,
                    'type' => 'Alpha-Numeric',
                    'possible_value' => 'This is the credential/username used to authenticate the transaction request',
                ),
                'SecurityCredential' => array(
                    'name' => 'Encrypted Credential of user getting transaction amount',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'Encrypted password for the initiator to authenticate the transaction request',
                ),
                'QueueTimeOutURL' => array(
                    'name' => 'The path that stores information of time out transaction',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'ResultURL' => array(
                    'name' => '	The path that stores information of transaction',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'TransactionID' => array(
                    'name' => 'Unique identifier to identify a transaction on M-Pesa',
                    'required' => true,
                    'type' => 'Alpha-Numeric',
                    'possible_value' => 'LKXXXX1234',
                ),
                'Occasion' => array(
                    'name' => 'Optional Parameter ',
                    'required' => false,
                    'type' => 'String',
                    'possible_value' => 'Sequence of characters up to 100',
                ),
            ),
            'response' => array(
                'OriginatorConverstionID' => array(
                    'name' => 'The unique request ID for tracking a transaction',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => 'Alpha-numeric string of less then 20 characters',
                ),
                'ConversationID' => array(
                    'name' => 'The unique request ID returned by mpesa for each request made',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => '- Error codes - 500 OK',
                ),
                'ResponseDescription' => array(
                    'name' => 'Response Description message',
                    'type' => 'String',
                    'sample_value' => '- The service request has failed - The service request has been accepted successfully',
                ),
            )
        ),
        'c2b_simulate' => array(
            'name' => 'C2B Simulate Transaction',
            'description' => 'Simulate a C2B transaction',
            'endpoint' => 'mpesa/c2b/v1/simulate',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/c2b/apis',
            'link' => 'https://developer.safaricom.co.ke/c2b/apis/post/simulate',
            'parameters' => array(
                'CommandID' => array(
                    'name' => 'Unique command for each transaction type. For C2B dafult ',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => '- CustomerPayBillOnline - CustomerBuyGoodsOnline',
                ),
                'Amount' => array(
                    'name' => 'The amount being transacted',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '1',
                ),
                'Msisdn' => array(
                    'name' => 'Phone number (msisdn) initiating the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'MSISDN(12 digits) - 254XXXXXXXXX',
                ),
                'BillRefNumber' => array(
                    'name' => 'Bill Reference Number (Optional)',
                    'required' => false,
                    'type' => 'Alpha-Numeric',
                    'possible_value' => 'Alpha-Numeric less then 20 digits ',
                ),
                'ShortCode' => array(
                    'name' => 'Short Code receiving the amount being transacted',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => 'Shortcode (6 digits) - XXXXXX',
                ),
            ),
            'response' => array(
                'OriginatorConverstionID' => array(
                    'name' => 'The unique request ID for tracking a transaction',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => 'Alpha-numeric string of less then 20 characters',
                ),
                'ConversationID' => array(
                    'name' => 'The unique request ID returned by mpesa for each request made',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => '- Error codes - 500 OK',
                ),
                'ResponseDescription' => array(
                    'name' => 'Response Description message',
                    'type' => 'String',
                    'sample_value' => '- The service request has failed - The service request has been accepted successfully',
                ),
            )
        ),
        'c2b_register_url' => array(
            'name' => 'C2B Register URL',
            'description' => 'Register validation and confirmation URLs on M-Pesa ',
            'endpoint' => 'mpesa/c2b/v1/registerurl',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/c2b/apis',
            'link' => 'https://developer.safaricom.co.ke/c2b/apis/post/registerurl',
            'parameters' => array(
                'ValidationURL' => array(
                    'name' => 'Validation URL for the client',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'ConfirmationURL' => array(
                    'name' => 'Confirmation URL for the client',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'ResponseType' => array(
                    'name' => 'Default response type for timeout. Incase a tranaction times out, Mpesa will by default Complete or Cancel the transaction',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'Completed',
                ),
                'ShortCode' => array(
                    'name' => 'The short code of the organization.',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '123456',
                ),
            ),
            'response' => array(
                'OriginatorConverstionID' => array(
                    'name' => 'The unique request ID for tracking a transaction',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => 'Alpha-numeric string of less then 20 characters',
                ),
                'ConversationID' => array(
                    'name' => 'The unique request ID returned by mpesa for each request made',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => '- Error codes - 500 OK',
                ),
                'ResponseDescription' => array(
                    'name' => 'Response Description message',
                    'type' => 'String',
                    'sample_value' => '- The service request has failed - The service request has been accepted successfully',
                ),
            )
        ),
        'pull_register_url' => array(
            'name' => 'Pull API Register URL',
            'description' => 'Register Pull API',
            'endpoint' => 'pulltransactions/v1/register',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/c2b/apis',
            'link' => 'https://documenter.getpostman.com/view/1724456/SVtTy8sd?version=latest',
            'parameters' => array(
                'ShortCode' => array(
                    'name' => 'Organization ShortCode that was used during Go-Live process',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '123456',
                ),
                'RequestType' => array(
                    'name' => 'Defines the type of operation, default value is Pull.',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'Pull',
                ),
                'NominatedNumber' => array(
                    'name' => 'This is Safaricom MSISDN associated with the organization account using Pull API(07XXXXXXXX or 2547XXXXXXX)',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '0722906835',
                ),
                'CallBackURL' => array(
                    'name' => 'A CallBack URL is a valid secure URL that is used to receive notifications.',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://domain/path',
                ),
            ),
            'response' => array(
                'ResponseRefID' => array(
                    'name' => 'ResponseRefID',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => '18633-7271215-1',
                ),
                'Response Status' => array(
                    'name' => 'Response Status',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => '1001',
                ),
                'ShortCode' => array(
                    'name' => 'ShortCode',
                    'type' => 'String',
                    'sample_value' => 'ShortCode already Registered',
                ),
            )
        ),
        'reversal' => array(
            'name' => 'Reversal',
            'description' => 'Transaction Reversal API reverses a M-Pesa transaction.',
            'endpoint' => 'mpesa/reversal/v1/request',
            'type' => 'post',
            'group' => 'https://developer.safaricom.co.ke/reversal/apis',
            'link' => 'https://developer.safaricom.co.ke/reversal/apis/post/request',
            'parameters' => array(
                'Amount' => array(
                    'name' => 'Amount of the transaction',
                    'required' => true,
                    'type' => 'Number',
                    'possible_value' => '10',
                ),
                'CommandID' => array(
                    'name' => 'Takes only \'TransactionReversal\' Command id',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'TransactionReversal',
                ),
                'ReceiverParty' => array(
                    'name' => 'Organization /MSISDN sending the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '-Shortcode (6 digits)<br>-MSISDN (12 Digits)',
                ),
                'RecieverIdentifierType' => array(
                    'name' => 'Type of organization receiving the transaction',
                    'required' => true,
                    'type' => 'Numeric',
                    'possible_value' => '1 – MSISDN,<br>2 – Till Number,<br>4 – Organization short code',
                ),
                'Remarks' => array(
                    'name' => 'Comments that are sent along with the transaction.',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'Sequence of characters up to 100',
                ),
                'Initiator' => array(
                    'name' => 'The name of Initiator to initiating  the request	',
                    'required' => true,
                    'type' => 'Alpha-Numeric',
                    'possible_value' => 'This is the credential/username used to authenticate the transaction request',
                ),
                'SecurityCredential' => array(
                    'name' => 'Encrypted Credential of user getting transaction amount',
                    'required' => true,
                    'type' => 'String',
                    'possible_value' => 'Encrypted password for the initiator to authenticate the transaction request',
                ),
                'QueueTimeOutURL' => array(
                    'name' => 'The path that stores information of time out transaction',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'ResultURL' => array(
                    'name' => '	The path that stores information of transaction',
                    'required' => true,
                    'type' => 'URL',
                    'possible_value' => 'https://ip or domain:port/path',
                ),
                'TransactionID' => array(
                    'name' => 'Unique identifier to identify a transaction on M-Pesa',
                    'required' => true,
                    'type' => 'Alpha-Numeric',
                    'possible_value' => 'LKXXXX1234',
                ),
                'Occasion' => array(
                    'name' => 'Optional Parameter ',
                    'required' => false,
                    'type' => 'String',
                    'possible_value' => 'Sequence of characters up to 100',
                ),
            )
        ),
        'generate_token' => array(
            'name' => 'Generate Token',
            'description' => 'Gives you time bound access token to call allowed APIs',
            'endpoint' => 'oauth/v1/generate',
            'type' => 'get',
            'group' => 'https://developer.safaricom.co.ke/oauth/apis',
            'link' => '',
            'parameters' => array(
                'ConsumerKey' => array(
                    'name' => 'Consumer Key',
                    'required' => true,
                    'type' => 'Alpha-Numeric',
                    'possible_value' => 'sfewrEwewersd',
                ),
                'ConsumerSecret' => array(
                    'name' => 'Consumer Secret',
                    'required' => true,
                    'type' => 'Alpha-Numeric',
                    'possible_value' => 'sfewrEwewersd112',
                ),
            ),
            'response' => array(
                'Expiry' => array(
                    'name' => 'Token expiry time in seconds.',
                    'type' => 'Integer',
                    'sample_value' => '3599',
                ),
                'Access_Token' => array(
                    'name' => 'Access token to access other APIs',
                    'type' => 'Alpha-Numeric',
                    'sample_value' => 'O22vJy6rnN2nRAnOPqZ8dkyGxmXG',
                ),
            )
        ),
    );
    private $http_status_code = array(
        200 => 'Success',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable – You requested a format that isn’t json',
        429 => 'Too Many Requests – You’re requesting too many kittens! Slow down!',
        500 => 'Internal Server Error – We had a problem with our server. Try again later.',
        503 => 'Service Unavailable – We’re temporarily offline for maintenance. Please try again later.'
    );

    /**
     * S# __construct() function
     *  
     * Constructor
     * 
     */
    public function __construct() {
        
    }

//E# __construct() function

    /**
     * S# call() function
     *  
     * Constructor
     * 
     */
    public function call($api, $configs, $parameters = array()) {

        $this->parameters = $parameters;
        $this->configs = $configs;

        //Check environment
        if (!array_key_exists('Environment', $configs) || !in_array($configs['Environment'], array('sandbox', 'live'))) {
            return $this->respond(400, '"Environment" in configs array should be either "live" or "sandbox"', array());
        }//E# if else statement
        //Check api
        if (!array_key_exists($api, $this->apis)) {
            return $this->respond(400, $api . ' API does not exists', array());
        }//E# if else statement
        //Set api
        $this->actual_api = $this->apis[$api];

        $parameter_indexes = array();
        if (array_key_exists('parameters', $this->apis[$api])) {
            foreach ($this->apis[$api]['parameters'] as $key => $single_parameter) {
                if ($single_parameter['required'] && !array_key_exists($key, $parameters)) {
                    return $this->respond(400, 'Parameter ' . $single_parameter['name'] . ' is required', array());
                }//E# if statement
            }//E# foreach statement
        }//E# if else statement

        if (array_key_exists('Url', $configs) && $configs['Url']) {
            $this->endpoint = $configs['Url'];
        } elseif ($configs['Environment'] == 'sandbox') {
            $this->endpoint = $this->sandbox_endpoint;
        } else if ($configs['Environment'] == 'live') {
            $this->endpoint = $this->live_endpoint;
        }//E# if else statement
        //Verbose
        if (array_key_exists('Verbose', $configs)) {
            echo 'API Name: ' . $api . '<p>';
            echo 'Configs <p>';
            var_dump($configs);
            echo 'Parameters <p>';
            var_dump($parameters);
        }//E# if statement

        return $this->request($api, $configs, $parameters);
    }

//E# call() function

    /**
     * S# request() function 
     * 
     * request
     * 
     * @param array $parameters Parameter
     * 
     */
    public function request($api, $configs, $parameters) {
        $this->endpoint .= $this->actual_api['endpoint'];

        $header = array();

        if ($api == 'generate_token') {
            $password = $parameters['ConsumerKey'] . ':' . $parameters['ConsumerSecret'];

            $credentials = base64_encode($password);

            $header = ['Authorization: Basic ' . $credentials];

            $parameters = array(
                'grant_type' => 'client_credentials',
            );
        } else {
            foreach ($configs as $key => $value) {
                if (in_array($key, array('AccessToken', 'Content-Type'))) {
                    if ($key == 'AccessToken') {
                        $key = 'Authorization';
                        $value = 'Bearer ' . $value;
                    }//E# if statement
                    $header[] = $key . ': ' . $value;
                }//E# if statement
            }//E# foreach statement
        }//E# if else statement

        $response = $this->curl_request($this->actual_api['type'], $this->endpoint, $parameters, $header);

        return $response;
    }

//E# request() function

    /**
     * S# curl_request() function
     * 
     * Make a post or get curl request
     * 
     * @param str $type Type
     * @param str $url URL
     * @param array $parameters parameters
     * @param array $header Header
     * 
     * @return object
     */
    private function curl_request($type, $url, $parameters, $header) {

        $fields_string = '';

        foreach ($parameters as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }//E# foreach statement

        rtrim($fields_string, '&');

        // Get cURL resource
        $ch = curl_init();


        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }//E# if statement

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if ($type == 'post') {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($parameters));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
        } elseif ($type == 'get') {
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $fields_string);
        }//E# if else statement

        $result = curl_exec($ch);

        $info = curl_getinfo($ch);

        if (curl_error($ch)) {
            $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $message = curl_error($ch);
            $result = array();
        } else {
            $message = '';
            $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }//E# if else statement

        if (array_key_exists('Verbose', $this->configs)) {
            echo 'URL: ' . $url . ' <p>';
            echo 'Header: <p>';
            var_dump($header);
            echo 'API response<p>';
            var_dump($result);
        }//E# if statement

        curl_close($ch);

        return $this->respond($http_status_code, $message, $result);
    }

//E# curl_request() function

    /**
     * S# respond() function
     * 
     * Respond
     * 
     * @param str $http_status_code Http status code
     * @param str $message Message
     * @param array $parameters Parameters
     * @param array $response response
     */
    private function respond($http_status_code, $message, $response) {

        if (!$message) {
            $message = $this->http_status_code[$http_status_code];
        }//E# if statement
        //Set http header
        http_response_code($http_status_code);

        $response_json = json_decode($response, true);

        if ((!$response) || (json_last_error() !== 0)) {
            $response_json = array();
        }//E# if statement

        $this->response = array(
            'Environment' => $this->configs['Environment'],
            'Name' => $this->actual_api['name'],
            'HttpVerb' => $this->actual_api['type'],
            'HttpStatusCode' => '' . $http_status_code,
            'HttpStatusMessage' => $this->http_status_code[$http_status_code],
            'Message' => $message,
            'Response' => $response_json,
            'Endpoint' => $this->endpoint,
            'Parameters' => $this->parameters,
            'ExpectedResponse' => $this->actual_api['response']
        );

        return $this->response;
    }

//E# respond() function 
}

//E# Mpesa() class
