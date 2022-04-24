<?php

//Set the api_key, api_secret and endpoint as configs in the system that can be setup during configuration
$api_key = 'key';
$api_secret = 'secret';
$endpoint = 'http://sapamacash.com/api/update_transaction';

//Data to send a query string
$data = array(
    'format' => 'json',
    'id' => 1,
    'ipned' => 'success',
    'api_key' => $api_key,
    'api_secret' => $api_secret,
);
//Sort by keys in ascending order
ksort($data);

//Implode the string
$string_to_hash = implode($data, '.');

echo 'String to hash: ' . $string_to_hash . '<p>';

//Generate hash
$hash = hash('sha256', $string_to_hash, false);

echo 'Generated hash: ' . $hash . '<p>';

//IMPORTANT: REMEMBER TO ADD THE GENERATED HASH TO TO THE DATA
$data['hash'] = $hash;

//IMPORTANT: REMEMBER TO REMOVE THE API SECRET FROM THE DATA HASHED
unset($data['api_secret']);
var_dump($data);

$fields_string = '';
foreach ($data as $key => $value) {
    $fields_string .= $key . '=' . $value . '&';
}//E# foreach statement

rtrim($fields_string, '&');

echo 'Query string: ' . $fields_string . '<p>';

echo 'Full url: ' . $endpoint . '?' . $fields_string . '<p>';

// Get cURL resource
$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_POST, count($data));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

$result = curl_exec($ch);
echo 'Result in JSON<p>' . $result . '<p>';

$decoded_data = json_decode($result, true);
echo 'Decoded array<p>';

var_dump($decoded_data);

if ($decoded_data['httpStatusCode'] == 200 && array_key_exists('data', $decoded_data['data'])) {
    echo '<p>Success<p>';
    $index = 0;
    foreach ($decoded_data['data']['data'] as $single_transaction) {
        echo "<p>Transaction " . $index . '<p>';
        var_dump($single_transaction);
        $index++;
    }//E# foreach statement
} else {
    echo "<p>HTTP Status Code: " . $decoded_data['httpStatusCode'] . '<p>';
    echo "System Code: " . $decoded_data['systemCode'] . '<p>';
    echo "Message: " . $decoded_data['systemCode'] . '<p>';
}
