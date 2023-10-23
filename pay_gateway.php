<?php
require_once '../../../wp-blog-header.php';
require_once './api_payu_payment_gateway.php';
require_once './controllers/ApiController.php';
require_once './utils/Order.php';
require_once './utils/User.php';
get_header('shop');

if(isset($_POST['merchantId'])){
	$merchantId = $_POST['merchantId'];
} else {
	$merchantId = '508029';
}

if(isset($_POST['referenceCode'])){
	$referenceCode = $_POST['referenceCode'];
} else {
	$referenceCode = 'referenceCode';
}

if(isset($_POST['description'])){
	$referenceCode = $_POST['description'];
} else {
	$referenceCode = 'descripcion';
}

if(isset($_POST['amount'])){
	$amount = $_POST['amount'];
} else {
	$amount = '99000';
}

if(isset($_POST['tax'])){
	$tax = $_POST['tax'];
} else {
	$tax = '0';
}

if(isset($_POST['taxReturnBase'])){
	$taxReturnBase = $_POST['taxReturnBase'];
} else {
	$taxReturnBase = '';
}

if(isset($_POST['accountId'])){
	$accountId = $_POST['accountId'];
} else {
	$accountId = '512321';
}

if(isset($_POST['currency'])){
	$currency = $_POST['currency'];
} else {
	$currency = 'COP';
}

if(isset($_POST['buyerEmail'])){
	$buyerEmail = $_POST['buyerEmail'];
} else {
	$buyerEmail = 'user@tests.com';
}

if(isset($_POST['language'])){
	$language = $_POST['language'];
} else {
	$language = 'es';
}

if(isset($_POST['environment'])){
	$environment = $_POST['environment'];
} else {
	$environment = 'development';
}

if(isset($_POST['test'])){
	$test = $_POST['test'];
} else {
	$test = 'true';
}

if(isset($_POST['confirmationUrl'])){
	$confirmationUrl = $_POST['confirmationUrl'];
} else {
	$confirmationUrl = 'https://www.espacolaser.com.co/wp-content/plugins/woocommerce-intregrate-with-api-payu/confirmation.php';
}

if(isset($_POST['responseUrl'])){
	$responseUrl = $_POST['responseUrl'];
} else {
	$responseUrl = 'https://www.espacolaser.com.co/wp-content/plugins/woocommerce-intregrate-with-api-payu/response.php';;
}

if(isset($_POST['shippingAddress'])){
	$shippingAddress = $_POST['shippingAddress'];
} else {
	$shippingAddress = 'Cr 23 No. 53-50';
}

if(isset($_POST['shippingCountry'])){
	$shippingCountry = $_POST['shippingCountry'];
} else {
	$shippingCountry = 'CO';
}

if(isset($_POST['shippingCity'])){
	$shippingCity = $_POST['shippingCity'];
} else {
	$shippingCity = 'Bogotá';
}

if(isset($_POST['billingAddress'])){
	$billingAddress = $_POST['billingAddress'];
} else {
	$billingAddress = 'Cr 23 No. 53-50';
}

if(isset($_POST['billingCountry'])){
	$billingCountry = $_POST['billingCountry'];
} else {
	$billingCountry = 'CO';
}

if(isset($_POST['billingCity'])){
	$billingCity = $_POST['billingCity'];
} else {
	$billingCity = 'Bogotá';
}

//Obtenemos el apiKey y el ApiLogin
$payu = new WC_Api_Payu_Payment_Gateway;
$apiKey = $payu->get_api_key();
$apiLogin = $payu->get_api_login();

if(isset($_POST['signature'])){
	$signature = $_POST['signature'];
} else {
	$signature = md5($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $amount . "~" . $currency);
}


$apiModel = new ApiModel('');
$apiController = new ApiController($apiModel, $apiLogin, $apiKey, $accountId, $merchantId, $shippingCountry, $language, $test, $currency);

$apiController->setEnvironment($environment);

// if ($_SERVER['REQUEST_METHOD'] === 'POST')
// {
//     try {
//         $ip = $_POST['ip'];
//         $userAgent = $_SERVER['HTTP_USER_AGENT'];
//         $user = getUser();
//         $order = getOrder();
//         $session = md5(session_id().microtime());

//         switch ($_SERVER['REQUEST_URI']) {   
//             case '/index.php/creditcard-payment':
                        
//                 // Recupera los datos del formulario
//                 $payerName = $_POST['payer_name'];
//                 $typeDocument = $_POST['type_document'];
//                 $documentNumber = $_POST['document_number'];
//                 $creditCardNumber = $_POST['credit_card_number'];
//                 $cvv = $_POST['cvv'];
//                 $monthExp = $_POST['month_exp'];
//                 $yearExp = $_POST['year_exp'];
//                 $fees = $_POST['fees'];
//                 $cellPhone = $_POST['cell-phone'];
//                 $paymentMethod = $_POST['payment_method'];
                
//                 $response_api = json_decode($apiController->setCreditCardPaymentAPI($payerName, $typeDocument, $documentNumber, $creditCardNumber, $cvv, $monthExp, $yearExp, $fees, $cellPhone, $paymentMethod, $user, $order, $session, $ip, $userAgent), true);
                
//                 if ($response_api['code'] === "SUCCESS") {
//                     if ($response_api['transactionResponse']['state'] === "APPROVED") {
                        
//                         $order->setPayuOrderId($resporesponse_apinse['transactionResponse']['orderId']);
//                         $order->setTransactionId($response_api['transactionResponse']['transactionId']);
//                         $response = [
//                             'status' =>     'ok',
//                             'message' => 'APPROVED'
//                         ];
//                     } else {
//                         $response = [
//                             'status' => 'error',
//                             'message' => 'DECLINED ' . $response_api['transactionResponse']['responseCode']
//                         ];  
//                     }
//                 } else {                    
//                     $response["status"] = "error";
//                     $response["message"] = $response_api['error'];
//                 }               
                
//             break;
//             case '/index.php/pse-payment':
                        
//                 // Recupera los datos del formulario
//                 $bank = $_POST['bank'];
//                 $payerName = $_POST['payer_name'];
//                 $typePerson = $_POST['type_person'];
//                 $typeDocument = $_POST['type_document'];
//                 $documentNumber = $_POST['document_number'];
//                 $cellPhone = $_POST['cell-phone'];
                
//                 $response_api = json_decode($apiController->setPSEPaymentAPI($bank, $payerName, $typePerson, $typeDocument, $documentNumber, $cellPhone, $user, $order, $session, $ip, $userAgent), true);
                
//                 if ($response_api['code'] === "SUCCESS") {
//                     if ($response_api['transactionResponse']['state'] === "APPROVED") {
                        
//                         $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
//                         $order->setTransactionId($response_api['transactionResponse']['transactionId']);
//                         $response = [
//                             'status' => 'ok',
//                             'message' => 'APPROVED'
//                         ];
//                     } else if ($response_api['transactionResponse']['state'] === "PENDING") {
                        
//                         $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
//                         $order->setTransactionId($response_api['transactionResponse']['transactionId']);

//                         $response = [
//                             'status' => 'ok',
//                             'message' => 'PENDING',
//                             'url' => $response_api['transactionResponse']['extraParameters']['BANK_URL']
//                         ];  
//                     } else { 
//                         $response = [
//                             'status' => 'error',
//                             'message' => 'DECLINED ' . $response_api['transactionResponse']['responseCode']
//                         ];  
//                     }
//                 } else {                    
//                     $response["status"] = "error";
//                     $response["message"] = $response_api['error'];
//                 }               
                
//             break;
//             case '/index.php/cash-payment':
                
//                 // Recupera los datos del formulario                
//                 $payerName = $_POST['payer_name'];                
//                 $typeDocument = $_POST['type_document'];
//                 $documentNumber = $_POST['document_number'];
//                 $paymentMethod = $_POST['payment_method_cash'];
                
//                 //validamos rango de pagos
//                 if($paymentMethod === 'EFECTY')
//                 {
//                     if (!($order->getValue() >= 20000 && $order->getValue() <= 6000000)) {
//                         $response = [
//                             'status' =>  'error',
//                             'message' => 'Rangos no permitidos para el pago por Efecty.'
//                         ];
//                         break;
//                     }
//                 }
//                 else
//                 {
//                     if (!($order->getValue() >= 1000 && $order->getValue() <= 4000000)) {
//                         $response = [
//                             'status' =>  'error',
//                             'message' => 'Rangos no permitidos para pagos en efectivo.'
//                         ];
//                         break;
//                     }
//                 }                

//                 $response_api = json_decode($apiController->setCashOrBankPaymentAPI($payerName, $typeDocument, $documentNumber, $paymentMethod, $user, $order, $session, $ip, $userAgent), true);
                
//                 if ($response_api['code'] === "SUCCESS") {
//                     if ($response_api['transactionResponse']['state'] === "APPROVED") {
                        
//                         $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
//                         $order->setTransactionId($response_api['transactionResponse']['transactionId']);
//                         $response = [
//                             'status' =>  'ok',
//                             'message' => 'APPROVED'
//                         ];
//                     } else if ($response_api['transactionResponse']['state'] === "PENDING") {
                        
//                         $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
//                         $order->setTransactionId($response_api['transactionResponse']['transactionId']);

//                         $response = [
//                             'status' => 'ok',
//                             'message' => 'PENDING ',
//                             'url' => $response_api['transactionResponse']['extraParameters']['URL_PAYMENT_RECEIPT_HTML']
//                         ];  
//                     } else {
//                         $response = [
//                             'status' => 'error',
//                             'message' => 'DECLINED ' . $response_api['transactionResponse']['responseCode']
//                         ];  
//                     }
//                 } else {                    
//                     $response["status"] = "error";
//                     $response["message"] = $response_api['error'];
//                 }               
                
//             break;
//             case '/index.php/banks-payment':
                
//                 // Recupera los datos del formulario                
//                 $payerName = $_POST['payer_name'];                
//                 $typeDocument = $_POST['type_document'];
//                 $documentNumber = $_POST['document_number'];
//                 $paymentMethod = $_POST['payment_method_banks'];
   
//                 $response_api = json_decode($apiController->setCashOrBankPaymentAPI($payerName, $typeDocument, $documentNumber, $paymentMethod, $user, $order, $session, $ip, $userAgent), true);
                
//                 if ($response_api['code'] === "SUCCESS") {
//                     if ($response_api['transactionResponse']['state'] === "APPROVED") {
                        
//                         $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
//                         $order->setTransactionId($response_api['transactionResponse']['transactionId']);
//                         $response = [
//                             'status' =>  'ok',
//                             'message' => 'APPROVED'
//                         ];
//                     } else if ($response_api['transactionResponse']['state'] === "PENDING") {
                        
//                         $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
//                         $order->setTransactionId($response_api['transactionResponse']['transactionId']);

//                         $response = [
//                             'status' => 'ok',
//                             'message' => 'PENDING ',
//                             'url' => $response_api['transactionResponse']['extraParameters']['URL_PAYMENT_RECEIPT_HTML']
//                         ];  
//                     } else {
//                         $response = [
//                             'status' => 'error',
//                             'message' => 'DECLINED ' . $response_api['transactionResponse']['responseCode']
//                         ];  
//                     }
//                 } else {                    
//                     $response["status"] = "error";
//                     $response["message"] = $response_api['error'];
//                 }               
                
//             break;
//         }
//     } catch (Exception $exc) {
//         $response = [
//             'status' => 'error',
//             'message' => $exc->getMessage()
//         ];
//     }
//     echo json_encode($response);
// }
// else
// {
    //get list bank PSE
    $resultBankList = null;
    $resultBankList = json_decode($apiController->getBankListAPI('PSE', $shippingCountry), true);

    if ($resultBankList['code'] === 'SUCCESS') {
        $banksInfo = array_map(function($bank) {
            return array(
                'description' => $bank['description'],
                'pseCode' => $bank['pseCode']
            );
        }, $resultBankList['banks']);
        
    } else {
        echo "Error al obtener la lista de bancos";
    }

    $resultPing = null;
    $resultPing = $apiController->pingAPI();  

    $resultPaymentMethods = null;
    $resultPaymentMethods = $apiController->getPaymentMethodsAPI();

    //return years
    $currentYear = date('Y');
    $endYear = $currentYear + 20;
    $years = range($currentYear, $endYear);

    //return fees
    $fees = range(1, 36);

    // Incluir la vista
    require_once 'views/formulario.php';

// }

// function getUser()
// {
//     return new User([
//         'name' => 'Taylor Otwell',
//         'email' => 'user@tests.com',
//         'identification' => '1000100100',
//         'street1' => 'Cr 23 No. 53-50',
//         'street2' => '5555487',
//         'city' => 'Bogotá',
//         'state' => 'Bogotá D.C.',
//         'postalCode' =>  '000000',
//         'cellPhone' =>  '7563126'
//     ]);
// }

// function getOrder()
// {
//     return new Order([
//         'payu_order_id' => null,
//         'transaction_id' => null,
//         'reference' => uniqid(time()),
//         'description' => 'Depilacion laser hombre',
//         'value' => 65000,
//         'user_id' => 1
//     ]);
// }

get_footer('shop');
?>