
<?php
/**
 * Copyright Magento 2012
 * Example of products list retrieve using Customer account via Magento
REST API. OAuth authorization is used
 */
/*
$callbackUrl = "http://localhost:8081/index.php";
$temporaryCredentialsRequestUrl =
"http://localhost/oauth/initiate?oauth_callback=" .
urlencode($callbackUrl);
$adminAuthorizationUrl = 'http://localhost/oauth/authorize';
$accessTokenRequestUrl = 'http://localhos/oauth/token';
$apiUrl = 'http://localhos/rest';
$consumerKey = '98duvfuq624ykppnkth0n4009itt88aa';
$consumerSecret = '73m5ldi0himbryq0g99m641gr5kk9pjg';
session_start();
if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) &&
$_SESSION['state'] == 1) {
   $_SESSION['state'] = 0;
}
try {
   $authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION
: OAUTH_AUTH_TYPE_URI;
   $oauthClient = new OAuth($consumerKey, $consumerSecret,
OAUTH_SIG_METHOD_HMACSHA1, $authType);
   $oauthClient->enableDebug();
   if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
       $requestToken =
$oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
       $_SESSION['secret'] = $requestToken['oauth_token_secret'];
       $_SESSION['state'] = 1;
       header('Location: ' . $adminAuthorizationUrl . '?oauth_token=' .
$requestToken['oauth_token']);
       exit;
   } else if ($_SESSION['state'] == 1) {
       $oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
       $accessToken =
$oauthClient->getAccessToken($accessTokenRequestUrl);
       $_SESSION['state'] = 2;
       $_SESSION['token'] = $accessToken['oauth_token'];
       $_SESSION['secret'] = $accessToken['oauth_token_secret'];
       header('Location: ' . $callbackUrl);
       exit;
   } else {
       $oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);
       $resourceUrl = "$apiUrl/products";
       $oauthClient->fetch($resourceUrl);
       $productsList = json_decode($oauthClient->getLastResponse());
       print_r($productsList);
   }
} catch (OAuthException $e) {
   print_r($e);
}
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