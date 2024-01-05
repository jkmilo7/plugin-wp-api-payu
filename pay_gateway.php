<?php
// require_once '../../../wp-blog-header.php';
require_once './api_payu_payment_gateway.php';
require_once './controllers/ApiController.php';
require_once './utils/Order.php';
// get_header('shop');

if(isset($_POST['merchantId'])){
	$merchantId = $_POST['merchantId'];
} else {
	$merchantId = '508029';
}

if(isset($_POST['referenceCode'])){
	$referenceCode = $_POST['referenceCode'];
} else {
	$referenceCode = '8819';
}

if(isset($_POST['description'])){
	$description = $_POST['description'];
} else {
	$description = 'Promoción Paquete Depilación Láser Áxilas Para Mujer';
}

if(isset($_POST['amount'])){
	$amount = $_POST['amount'];
} else {
	$amount = '99000.00';
}

if(isset($_POST['tax'])){
	$tax = $_POST['tax'];
} else {
	$tax = '0.00';
}

if(isset($_POST['taxReturnBase'])){
	$taxReturnBase = $_POST['taxReturnBase'];
} else {
	$taxReturnBase = '0';
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
	$buyerEmail = 'prueba.test@prueba.com';
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
	$test = ( $_POST['test'] === '1') ? 'true' : 'false';    
} else {
	$test = 'true';
}

if(isset($_POST['confirmationUrl'])){
	$confirmationUrl = $_POST['confirmationUrl'];
} else {
    $confirmationUrl = 'http://localhost:63287/confirmation.php';
	//$confirmationUrl = 'https://www.espacolaser.com.co/wp-content/plugins/woocommerce-intregrate-with-api-payu/confirmation.php';
}

if(isset($_POST['responseUrl'])){
	$responseUrl = $_POST['responseUrl'];
} else {
    $responseUrl = 'http://localhost:63287/response.php';;
	//$responseUrl = 'https://www.espacolaser.com.co/wp-content/plugins/woocommerce-intregrate-with-api-payu/response.php';;
}

if(isset($_POST['shippingAddress'])){
	$shippingAddress = $_POST['shippingAddress'];
} else {
	$shippingAddress = '';
}

if(isset($_POST['shippingCountry'])){
	$shippingCountry = $_POST['shippingCountry'];
} else {
	$shippingCountry = 'CO';
}

if(isset($_POST['shippingCity'])){
	$shippingCity = $_POST['shippingCity'];
} else {
	$shippingCity = '';
}

if(isset($_POST['billingAddress'])){
	$billingAddress = $_POST['billingAddress'];
} else {
	$billingAddress = 'calle siempre viva';
}

if(isset($_POST['billingCountry'])){
	$billingCountry = $_POST['billingCountry'];
} else {
	$billingCountry = 'CO';
}

if(isset($_POST['billingCity'])){
	$billingCity = $_POST['billingCity'];
} else {
	$billingCity = 'bogota';
}

if(isset($_POST['cellPhone'])){
	$cellPhone = $_POST['cellPhone'];
} else {
	$cellPhone = '3202701111';
}

$currentDate = date("Y-m-d");


//Obtenemos el apiKey y el ApiLogin
// $payu = new WC_Api_Payu_Payment_Gateway;
//  $apiKey = $payu->get_api_key();
//  $apiLogin = $payu->get_api_login();

$apiKey = '4Vj8eK4rloUd272L48hsrarnUA';
$apiLogin = 'pRRXKOl8ikMmt9u';

if(isset($_POST['signature'])){
	$signature = $_POST['signature'];
} else {
	$signature = md5($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $amount . "~" . $currency);
}

// Formatea el valor como moneda
$formattedAmount = number_format($amount, 2, ',', '.');

$apiModel = new ApiModel('');
$apiController = new ApiController($apiModel, $apiLogin, $apiKey, $accountId, $merchantId, $billingCountry, $language, $test, $currency);

$apiController->setEnvironment($environment);

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    try 
	{
        $ip = $_POST['ip'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $order = new Order([
            'payu_order_id' => null,
            'transaction_id' => null,
            'reference' => $referenceCode,
            'description' => $description,
            'amount' => $amount,
            'tax' => $tax,
            'taxReturnBase' => $taxReturnBase,
            'user_id' => uniqid(time())
        ]);

        $session = md5(session_id().microtime());

        switch ($_SERVER['REQUEST_URI']) 
		{   
            case '/pay_gateway.php/creditcard-payment':
                        
                // Recupera los datos del formulario
                $payerName = $_POST['creditcard_payer_name'];
                $typeDocument = $_POST['creditcard_type_document'];
                $documentNumber = $_POST['creditcard_document_number'];
                $creditCardNumber = $_POST['credit_card_number'];
                $cvv = $_POST['cvv'];
                $monthExp = $_POST['month_exp'];
                $yearExp = $_POST['year_exp'];
                $fees = $_POST['fees'];
                $cellPhone = $_POST['creditcard_cell_phone'];
                $paymentMethod = $_POST['creditcard_payment_method'];
                
                $url_response = $responseUrl . '?merchantId=' . $merchantId .
                '&merchant_name=CORP%C3%93REOS+COLOMBIA+S.A.S&merchant_address=KR+11++84++09+LC+3&telephone=7429660&merchant_url=https%3A%2F%2Fwww.espacolaser.com.co%2F' . 
                '&referenceCode='. $order->getReference() .
                '&description=' . $order->getDescription() .
                '&trazabilityCode=&cus=&orderLanguage='. $language .'&extra1=WOOCOMMERCE&extra2=&extra3=' . 
                '&signature=' . $signature .
                '&lapPaymentMethod='. $paymentMethod .'&polPaymentMethodType=2&lapPaymentMethodType=CREDIT_CARD&installmentsNumber='. $fees . 
                '&TX_VALUE='. $order->getAmount() .'&TX_TAX='. $order-> getTax() .'&currency='. $currency .
                '&lng='. $language .'&pseCycle=&buyerEmail='. $buyerEmail .'&pseBank=&pseReference1=&pseReference2=&pseReference3=&authorizationCode='.
                '&TX_ADMINISTRATIVE_FEE=.00&TX_TAX_ADMINISTRATIVE_FEE=.00&TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE='. $order-> getTaxReturnBase() .
                '&processingDate=' . $currentDate;

                $response_api = json_decode($apiController->setCreditCardPaymentAPI($payerName, $typeDocument, $documentNumber, $creditCardNumber, $cvv, $monthExp, $yearExp, $fees, $cellPhone, $buyerEmail, $shippingAddress, $shippingCountry, $shippingCity, $billingAddress, $billingCountry, $billingCity, $paymentMethod, $order, $signature, $session, $ip, $userAgent, $shippingCountry), true);
                
                if ($response_api['code'] === "SUCCESS") {

                    $url_response = $url_response . 
                    '&polResponseCode='. (isset($response_api['transactionResponse']['paymentNetworkResponseCode']) ? $response_api['transactionResponse']['paymentNetworkResponseCode'] : '5') . 
                    '&lapResponseCode='. (isset($response_api['transactionResponse']['responseCode']) ? $response_api['transactionResponse']['responseCode'] : '') .
                    '&risk=&polPaymentMethod=44&transactionState=6'.
                    '&lapTransactionState='. (isset($response_api['transactionResponse']['state']) ? $response_api['transactionResponse']['state'] : 'DECLINED').
                    '&message='. (isset($response_api['transactionResponse']['state']) ? $response_api['transactionResponse']['state'] : 'DECLINED') .
                    '&reference_pol='. (isset($response_api['transactionResponse']['orderId']) ? $response_api['transactionResponse']['orderId'] : '') .
                    '&transactionId='. (isset($response_api['transactionResponse']['transactionId']) ? $response_api['transactionResponse']['transactionId'] : '') .
                    '&polTransactionState=6';

                    if ($response_api['transactionResponse']['state'] === "APPROVED") {
                        
                        $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
                        $order->setTransactionId($response_api['transactionResponse']['transactionId']);
                        $response = [
                            'status' => 'ok',
                            'message' => 'APPROVED',
                            'responseUrl' => $url_response
                        ];
                    } else if ($response_api['transactionResponse']['state'] === "PENDING") {
                        
                        $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
                        $order->setTransactionId($response_api['transactionResponse']['transactionId']);

                        $response = [
                            'status' => 'ok',
                            'message' => 'PENDING',
                            'responseUrl' => $url_response,
                            'url' => $response_api['transactionResponse']['extraParameters']['BANK_URL']
                        ];  
                    } else {

                        $response = [
                            'status' => 'error',
                            'message' => 'DECLINED ' . $response_api['transactionResponse']['responseCode'] . " / " . $response_api['transactionResponse']['paymentNetworkResponseErrorMessage'],
                            'responseUrl' => $url_response
                        ];  
                    }
                } else {                    
                    $response["status"] = "error";
                    $response["message"] = $response_api['error'];
                }
                
            break;
            case '/pay_gateway.php/pse-payment':
                        
                // Recupera los datos del formulario
                $bank = $_POST['pse_bank'];
                $payerName = $_POST['pse_payer_name'];
                $typePerson = $_POST['pse_type_person'];
                $typeDocument = $_POST['pse_type_document'];
                $documentNumber = $_POST['pse_document_number'];
                $cellPhone = $_POST['pse_cell_phone'];
                                
                $response_api = json_decode($apiController->setPSEPaymentAPI($bank, $payerName, $typePerson, $typeDocument, $documentNumber, $cellPhone, $buyerEmail, $shippingAddress, $shippingCountry, $shippingCity, $billingAddress, $billingCountry, $billingCity, $order, $signature, $session, $ip, $userAgent), true);
                
                if ($response_api['code'] === "SUCCESS") {
                    if ($response_api['transactionResponse']['state'] === "APPROVED") {
                        
                        $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
                        $order->setTransactionId($response_api['transactionResponse']['transactionId']);
                        $response = [
                            'status' => 'ok',
                            'message' => 'APPROVED'
                        ];
                    } else if ($response_api['transactionResponse']['state'] === "PENDING") {
                        
                        $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
                        $order->setTransactionId($response_api['transactionResponse']['transactionId']);

                        $response = [
                            'status' => 'ok',
                            'message' => 'PENDING',
                            'url' => $response_api['transactionResponse']['extraParameters']['BANK_URL']
                        ];  
                    } else { 
                        $response = [
                            'status' => 'error',
                            'message' => 'DECLINED ' . $response_api['transactionResponse']['responseCode'] . " / " . $response_api['transactionResponse']['paymentNetworkResponseErrorMessage'] 
                        ];  
                    }
                } else {                    
                    $response["status"] = "error";
                    $response["message"] = $response_api['error'];
                }               
                
            break;
            case '/pay_gateway.php/cash-payment':
                
                // Recupera los datos del formulario                
                $payerName = $_POST['cash_payer_name'];                
                $typeDocument = $_POST['cash_type_document'];
                $documentNumber = $_POST['cash_document_number'];
                $paymentMethod = $_POST['payment_method_cash'];
                
                //validamos rango de pagos
                if($paymentMethod === 'EFECTY')
                {
                    if (!($order->getAmount() >= 20000 && $order->getAmount() <= 6000000)) {
                        $response = [
                            'status' =>  'error',
                            'message' => 'Rangos no permitidos para el pago por Efecty.'
                        ];                        
                        break;
                    }
                }
                else
                {
                    if (!($order->getAmount() >= 1000 && $order->getAmount() <= 4000000)) {
                        $response = [
                            'status' =>  'error',
                            'message' => 'Rangos no permitidos para pagos en efectivo.'
                        ];                        
                        break;
                    }
                }                

                $response_api = json_decode($apiController->setCashOrBankPaymentAPI($payerName, $typeDocument, $documentNumber, $paymentMethod, $buyerEmail, $shippingAddress, $shippingCountry, $shippingCity, $billingAddress, $billingCountry, $billingCity, $order, $signature, $session, $ip, $userAgent, $cellPhone), true);
                
                if ($response_api['code'] === "SUCCESS") {                    
                    if ($response_api['transactionResponse']['state'] === "APPROVED") {
                        
                        $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
                        $order->setTransactionId($response_api['transactionResponse']['transactionId']);
                        $response = [
                            'status' =>  'ok',
                            'message' => 'APPROVED'
                        ];

                    } else if ($response_api['transactionResponse']['state'] === "PENDING") {
                        
                        $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
                        $order->setTransactionId($response_api['transactionResponse']['transactionId']);

                        $response = [
                            'status' => 'ok',
                            'message' => 'PENDING ',
                            'url' => $response_api['transactionResponse']['extraParameters']['URL_PAYMENT_RECEIPT_HTML']
                        ]; 
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'DECLINED ' . $response_api['transactionResponse']['responseCode']
                        ];                        
                    }
                } else {                    
                    $response["status"] = "error";
                    $response["message"] = $response_api['error'];
                    
                }

            break;
            case '/pay_gateway.php/banks-payment':
                
                // Recupera los datos del formulario                
                $payerName = $_POST['bank_payer_name'];                
                $typeDocument = $_POST['bank_type_document'];
                $documentNumber = $_POST['bank_document_number'];
                $paymentMethod = $_POST['payment_method_banks'];
   
                $response_api = json_decode($apiController->setCashOrBankPaymentAPI($payerName, $typeDocument, $documentNumber, $paymentMethod, $buyerEmail, $shippingAddress, $shippingCountry, $shippingCity, $billingAddress, $billingCountry, $billingCity, $order, $signature, $session, $ip, $userAgent, $cellPhone), true);

                if ($response_api['code'] === "SUCCESS") {
                    
                    if ($response_api['transactionResponse']['state'] === "APPROVED") {
                        
                        $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
                        $order->setTransactionId($response_api['transactionResponse']['transactionId']);
                        $response = [
                            'status' =>  'ok',
                            'message' => 'APPROVED'
                        ];
                        
                    } else if ($response_api['transactionResponse']['state'] === "PENDING") {
                        
                        $order->setPayuOrderId($response_api['transactionResponse']['orderId']);
                        $order->setTransactionId($response_api['transactionResponse']['transactionId']);

                        $response = [
                            'status' => 'ok',
                            'message' => 'PENDING ',
                            'url' => $response_api['transactionResponse']['extraParameters']['URL_PAYMENT_RECEIPT_HTML']
                        ];  
                        
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'DECLINED ' . $response_api['transactionResponse']['responseCode']
                        ];  
                        
                    }
                } else {                    
                    $response["status"] = "error";
                    $response["message"] = $response_api['error'];                    
                }               
                
            break;
        }

        echo json_encode($response);

    } catch (Exception $exc) {
        $response = [
            'status' => 'error',
            'message' => $exc->getMessage()
        ];

        // Imprime la respuesta JSON para AJAX
        echo json_encode($response);
    }
    exit;
}

    //get list bank PSE
    $resultBankList = null;
    $resultBankList = json_decode($apiController->getBankListAPI('PSE', $billingCountry), true);

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

    // $resultPing = null;
    // $resultPing = $apiController->pingAPI(); 

    // $resultPaymentMethods = null;
    // $resultPaymentMethods = $apiController->getPaymentMethodsAPI();

    //return years
    $currentYear = date('Y');
    $endYear = $currentYear + 20;
    $years = range($currentYear, $endYear);

    //return fees
    $fees = range(1, 36);

    // Incluir la vista
    require_once 'views/formulario.php';

// get_footer('shop');
?>