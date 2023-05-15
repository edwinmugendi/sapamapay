<?php

namespace Edwinmugendi\Sapamapay;

/**
 * 
 * New Safaricom MPESA API wrapper
 * 
 * @author Edwin Mugendi <edwinmugendi@gmail.com>
 */
class KcbApi
{

    private $configs;
    private $response;
    private $environment;
    private $sandbox_endpoint = 'https://uat.buni.kcbgroup.com/mm/api/request/1.0.0/';
    private $live_endpoint = 'https://uat.buni.kcbgroup.com/mm/api/request/1.0.0/';
    private $sandbox_token_endpoint = 'https://wso2-api-gateway-direct-kcb-wso2-gateway.apps.test.aro.kcbgroup.com/token';
    private $live_token_endpoint = 'https://wso2-api-gateway-direct-kcb-wso2-gateway.apps.test.aro.kcbgroup.com/token';
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

        'generate_token' => array(
            'name' => 'Generate Token',
            'description' => 'Gives you time bound access token to call allowed APIs',
            'endpoint' => '',
            'type' => 'post',
            'urlencoded'=>true,
            'group' => 'https://developer.safaricom.co.ke/oauth/apis',
            'link' => '',
            'parameters' => array(
                'generate_type' => array(
                    'name' => 'grant_type',
                    'required' => false,
                    'type' => 'string',
                    'sample_value' => 'client_credentials',
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
        'stkpush' => array(
            'name' => 'STK Push',
            'description' => 'STK push',
            'endpoint' => 'stkpush',
            'type' => 'post',
            'urlencoded'=>false,
            'group' => 'https://developer.safaricom.co.ke/oauth/apis',
            'link' => '',
            'parameters' => array(
                'phoneNumber' => array(
                    'name' => 'Phone Number',
                    'required' => true,
                    'type' => 'string',
                    'sample_value' => '254722906835',
                ),
                'amount' => array(
                    'name' => 'amount',
                    'required' => true,
                    'type' => 'string',
                    'sample_value' => '100',
                ),
                'invoiceNumber' => array(
                    'name' => 'Invoice Number',
                    'required' => true,
                    'type' => 'string',
                    'sample_value' => 'INV-10122',
                ),
                'sharedShortCode' => array(
                    'name' => 'Shared Short Code',
                    'required' => true,
                    'type' => 'string',
                    'sample_value' => 'true',
                ),
                'orgShortCode' => array(
                    'name' => 'Org Short Code',
                    'required' => true,
                    'type' => 'string',
                    'sample_value' => 174379,
                ),
                'orgPassKey' => array(
                    'name' => 'Org Pass Key',
                    'required' => true,
                    'type' => 'string',
                    'sample_value' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                ),
                'callbackUrl' => array(
                    'name' => 'Callback URL',
                    'required' => true,
                    'type' => 'string',
                    'sample_value' => 'https://posthere.io/f613-4b7f-b82b',
                ),
                'transactionDescription' => array(
                    'name' => 'Transaction Description',
                    'required' => true,
                    'type' => 'string',
                    'sample_value' => 'School fee payment',
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
    public function __construct()
    {
    }

    //E# __construct() function

    /**
     * S# call() function
     *  
     * Constructor
     * 
     */
    public function call($api, $configs, $parameters = array())
    {

        $this->parameters = $parameters;
        $this->configs = $configs;

        //Check environment
        if (!array_key_exists('Environment', $configs) || !in_array($configs['Environment'], array('sandbox', 'live'))) {
            return $this->respond(400, '"Environment" in configs array should be either "live" or "sandbox"', array());
        } //E# if else statement
      
        //Check api
        if (!array_key_exists($api, $this->apis)) {
            return $this->respond(400, $api . ' API does not exists', array());
        } //E# if else statement
        //Set api
        $this->actual_api = $this->apis[$api];
     
        $parameter_indexes = array();
        if (array_key_exists('parameters', $this->apis[$api])) {
            foreach ($this->apis[$api]['parameters'] as $key => $single_parameter) {
                if ($single_parameter['required'] && !array_key_exists($key, $parameters)) {
                    return $this->respond(400, 'Parameter ' . $single_parameter['name'] . ' is required', array());
                } //E# if statement
            } //E# foreach statement
        } //E# if else statement

        //die($api);
        if (array_key_exists('Url', $configs) && $configs['Url']) {
            $this->endpoint = $configs['Url'];
        } elseif ($configs['Environment'] == 'sandbox') {
            $this->endpoint = $api == 'generate_token' ? $this->sandbox_token_endpoint : $this->sandbox_endpoint;
        } else if ($configs['Environment'] == 'live') {
            $this->endpoint = $api == 'generate_token' ? $this->live_token_endpoint : $this->live_endpoint;
        } //E# if else statement

    //die($this->endpoint);
        //Verbose
        if (array_key_exists('Verbose', $configs)) {
            echo 'End point: '.$this->endpoint;
            echo 'API Name: ' . $api . '<p>';
            echo 'Configs <p>';
            var_dump($configs);
            echo 'Parameters <p>';
            var_dump($parameters);
        } //E# if statement

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
    public function request($api, $configs, $parameters)
    {
        $this->endpoint .= $this->actual_api['endpoint'];

        $header = array();

        if ($api == 'generate_token') {
            $password = $parameters['ConsumerKey'] . ':' . $parameters['ConsumerSecret'];

            //echo 'Password: '.$password;

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
                    } //E# if statement

                    $header[] = $key . ': ' . $value;
                } //E# if statement
            } //E# foreach statement
        } //E# if else statement

       // die($this->endpoint);

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
    private function curl_request($type, $url, $parameters, $header)
    {

        $fields_string = '';

        foreach ($parameters as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        } //E# foreach statement

        rtrim($fields_string, '&');

        // Get cURL resource
        $ch = curl_init();


        //echo "json\n\n\n";

       // echo json_encode($parameters);

       // echo "fields\n\n\n";
        //echo $fields_string;

        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        } //E# if statement

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if ($type == 'post') {
            //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

            $payload = array_key_exists('urlencoded',$this->actual_api) && $this->actual_api['urlencoded'] ? $fields_string: json_encode($parameters);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($parameters));
            curl_setopt($ch, CURLOPT_POSTFIELDS,  $payload);
        } elseif ($type == 'get') {
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $fields_string);
        } //E# if else statement

        $result = curl_exec($ch);

        $info = curl_getinfo($ch);

        if (curl_error($ch)) {
            $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $message = curl_error($ch);
            $result = array();
        } else {
            $message = '';
            $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        } //E# if else statement

        if (array_key_exists('Verbose', $this->configs)) {
            echo 'URL: ' . $url . ' <p>';
            echo 'Header: <p>';
            var_dump($header);
            echo 'API response<p>';
            var_dump($result);
        } //E# if statement

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
    private function respond($http_status_code, $message, $response)
    {
        if (!$message) {
            $message = $this->http_status_code[$http_status_code];
        } //E# if statement
        //Set http header
        http_response_code($http_status_code);

        if(is_array($response)){
            $response_json = $response;

        }else{
            $response_json = json_decode($response, true);
        }

        if ((!$response) || (json_last_error() !== 0)) {
            $response_json = array();
        } //E# if statement

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
