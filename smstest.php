<?php
// Account details
$apiKey = urlencode('58d+5MYSApM-mOYGje3Azpw516dZWC6mC2j3Lj525G');
// Message details
$numbers = array(919246402455);
$sender = urlencode('SREEBB');
$message = rawurlencode('Dear Customer /n welcome to sree broadband');
 
$numbers = implode(',', $numbers);
 
// Prepare data for POST request
$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
// Send the POST request with cURL
$ch = curl_init('https://api.textlocal.in/send/');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
// Process your response here
echo $response;
?>
