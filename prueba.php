<?php
//require_once '../api_payu_payment_gateway.php';
//require_once 'controllers/ApiController.php';
//require_once 'utils/Order.php';
//require_once 'utils/User.php';

$merchantId = $_POST['merchantId'];
$referenceCode = $_POST['referenceCode'];
$description = $_POST['description'];
$amount = $_POST['amount'];
$tax = $_POST['tax'];
$taxReturnBase = $_POST['taxReturnBase'];
$signature = $_POST['signature'];
$accountId = $_POST['accountId'];
$currency = $_POST['currency'];
$buyerEmail = $_POST['buyerEmail'];
$language = $_POST['language'];
$test = $_POST['test'];
$environment = $_POST['environment'];
$confirmationUrl = $_POST['confirmationUrl'];
$responseUrl = $_POST['responseUrl'];
$shippingAddress = $_POST['shippingAddress'];
$shippingCountry = $_POST['shippingCountry'];
$shippingCity = $_POST['shippingCity'];
$billingAddress = $_POST['billingAddress'];
$billingCountry = $_POST['billingCountry'];
$billingCity = $_POST['billingCity'];
$extra1 = $_POST['extra1'];

// Imprimir los valores
echo "merchantId: $merchantId<br>";
echo "referenceCode: $referenceCode<br>";
echo "description: $description<br>";
echo "amount: $amount<br>";
echo "tax: $tax<br>";
echo "taxReturnBase: $taxReturnBase<br>";
echo "signature: $signature<br>";
echo "accountId: $accountId<br>";
echo "currency: $currency<br>";
echo "buyerEmail: $buyerEmail<br>";
echo "language: $language<br>";
echo "test: $test<br>";
echo "environment: $environment<br>";
echo "confirmationUrl: $confirmationUrl<br>";
echo "responseUrl: $responseUrl<br>";
echo "shippingAddress: $shippingAddress<br>";
echo "shippingCountry: $shippingCountry<br>";
echo "shippingCity: $shippingCity<br>";
echo "billingAddress: $billingAddress<br>";
echo "billingCountry: $billingCountry<br>";
echo "billingCity: $billingCity<br>";
echo "extra1: $extra1<br>";

?>
