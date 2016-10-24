
<?php
/** OAUTH 
<?php

function sign($method, $url, $data, $consumerSecret, $tokenSecret)
{
  $url = urlEncodeAsZend($url);
 
  $data = urlEncodeAsZend(http_build_query($data, '', '&'));
  $data = implode('&', [$method, $url, $data]);
 
  $secret = implode('&', [$consumerSecret, $tokenSecret]);
 
  return base64_encode(hash_hmac('sha1', $data, $secret, true));
}
 
function urlEncodeAsZend($value)
{
  $encoded = rawurlencode($value);
  $encoded = str_replace('%7E', '~', $encoded);
  return $encoded;
}
 
// REPLACE WITH YOUR ACTUAL DATA OBTAINED WHILE CREATING NEW INTEGRATION
$consumerKey = '';
$consumerSecret = '';
$accessToken = '';
$accessTokenSecret = '';
 
$method = 'GET';
$url = 'http://localhost/rest/V1/customers/1';
 
//
$data = [
  'oauth_consumer_key' => $consumerKey,
  'oauth_nonce' => md5(uniqid(rand(), true)),
  'oauth_signature_method' => 'HMAC-SHA1',
  'oauth_timestamp' => time(),
  'oauth_token' => $accessToken,
  'oauth_version' => '1.0',
];
 
$data['oauth_signature'] = sign($method, $url, $data, $consumerSecret, $accessTokenSecret);
 
$curl = curl_init();
 
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
  CURLOPT_HTTPHEADER => [
    'Authorization: OAuth ' . http_build_query($data, '', ',')
  ]
]);
 
$result = curl_exec($curl);
curl_close($curl);
var_dump($result);

?>
*/

$userData = array("username" => "admin", "password" => "");
$ch = curl_init("http://localhost/rest/V1/integration/admin/token");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Lenght: " . strlen(json_encode($userData))));
 
$token = curl_exec($ch);

//all products
$ch = curl_init("http://localhost/rest/V1/products?searchCriteria=");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));
 
$result = curl_exec($ch);
 
echo($result);

echo "Sales Orders";
// all all orders
$ch = curl_init("http://localhost/rest/V1/orders/items/?searchCriteria=");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));
 
$result = curl_exec($ch);
echo($result);
?>
