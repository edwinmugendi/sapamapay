<?php

//Set the api_key, api_secret and endpoint as configs in the system that can be setup during configuration
$api_key = '8LVNSZZVHSIKZY6WGBUWWM1SVOFQYXWTB39LDIRWZADBSRKM';
$api_secret = 'TUP2RAYFMUDVCHZWP2IKV4GMCOT1I5H99ADLVYNFMDCFTSEX';

$endpoint = 'http://localhost/sapamacash/public/api/post_transaction';
$endpoint = 'http://sapamacash.com/api/post_transaction';
//Convert your code into this array

$mysqli = new mysqli("localhost", "root", "root", "petro");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$sql = "SELECT *
        FROM pumpSales
        WHERE _processed != 'y'
        LIMIT 10";

//$res = mysqli_query($mysqli, $sql) or die(mysqli_error());

if (!$res = $mysqli->query($sql)) {
    die('There was an error running query[' . $mysqli->error . ']');
}

var_dump($res);
$results = array();

while ($row = mysqli_fetch_assoc($res)) {
    // var_dump($row);

    echo $row['id'] . '<p>';

    $transactions[] = array(
        'first_name' => $row['_grade_id'],
        'middle_name' => '',
        'last_name' => '',
        'trans_type' => $row['_paymentType'],
        'trans_id' => $row['id'],
        'trans_time' => $row['_end_date'] . ' ' . $row['_end_time'],
        'trans_amount' => $row['_money'],
        'short_code' => '706335177',
        'org_account_balance' => 0,
        'phone' => $row['_pump_id'],
        'bill_ref_number' => $row['id'],
        'invoice_number' => $row['id'],
        'description' => 'Grade: ' . $row['_grade_id'] . ' Volume: ' . $row['_volume'] . ' PPU: ' . $row['_ppu'] . ' Pump: ' . $row['_pump_id'] . ', Intial volume: ' . number_format($row['_initial_volume'], 2) . ', Final volume: ' . number_format($row['_final_volume'], 2),
        'third_party_trans_id' => $row['id'],
    );
}


/*
  $transactions = array(
  array(
  'first_name' => 'first_name',
  'middle_name' => 'middle_name',
  'last_name' => 'last_name',
  'trans_type' => 'trans_type',
  'trans_id' => 'trans_id1',
  'trans_time' => '2019-11-18 11:34:20',
  'trans_amount' => '100',
  'short_code' => '830830',
  'org_account_balance' => '123',
  'phone' => 'phone',
  'bill_ref_number' => 'bill_ref_number',
  'invoice_number' => 'invoice_number',
  'description' => 'description',
  'third_party_trans_id' => 'third_party_trans_id',
  ),
  array(
  'first_name' => 'first_name',
  'middle_name' => 'middle_name',
  'last_name' => 'last_name',
  'trans_type' => 'trans_type',
  'trans_id' => 'trans_id',
  'trans_time' => '2019-11-18 11:34:20',
  'trans_amount' => '100',
  'short_code' => '830830',
  'org_account_balance' => '123',
  'phone' => 'phone',
  'bill_ref_number' => 'bill_ref_number',
  'invoice_number' => 'invoice_number',
  'description' => 'description',
  'third_party_trans_id' => 'third_party_trans_id',
  )
  );
 * 
 */
//Data to send a query string
$data = array(
    'format' => 'json',
    'api_key' => $api_key,
    'api_secret' => $api_secret,
    'transactions' => json_encode($transactions)
);
//Sort by keys in ascending order
ksort($data);

//Implode the string
$string_to_hash = implode($data, '.');

//$data['transactions'] = $transactions;

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

if ($decoded_data['httpStatusCode'] == 200 && array_key_exists('data', $decoded_data)) {
    echo '<p>Success<p>';
    $index = 0;
    foreach ($decoded_data['data'] as $single_transaction) {
        echo "<p>Transaction " . $index . '<p>';
        var_dump($single_transaction);

        //TODO: Update that this transaction is processed so that in the next query it's not returned

        $sql = "UPDATE pumpSales SET _processed='y' WHERE id=" . $single_transaction['third_party_trans_id'];

        if ($mysqli->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $sql->error;
        }
        $index++;
    }//E# foreach statement
} else {
    echo "<p>HTTP Status Code: " . $decoded_data['httpStatusCode'] . '<p>';
    echo "System Code: " . $decoded_data['systemCode'] . '<p>';
    echo "Message: " . $decoded_data['systemCode'] . '<p>';
}
