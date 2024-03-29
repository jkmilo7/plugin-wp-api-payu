<?php
/*
Plugin Name: Api PAYU Payment Gateway
Description: Un gateway de pago personalizado para integracion del API PAYU con WooCommerce.
Version: 2.0
Author: jkmilo8
*/

add_action('plugins_loaded', 'woocommerce_payu_latam_gateway_integration', 0);

function woocommerce_payu_latam_gateway_integration() {
	if(!class_exists('WC_Payment_Gateway')) return;
	
	class WC_Api_Payu_Payment_Gateway  extends WC_Payment_Gateway {
	
		/**
		 * Constructor de la pasarela de pago
		 *
		 * @access public
		 * @return void
		 */
		public function __construct(){
			$this->id					= 'payulatamapi';			
			$this->has_fields			= false;
			$this->method_title			= 'PayU Latam API';
			$this->method_description	= 'Integración de Woocommerce a el api de pagos de PayU Latam';
			
			$this->init_form_fields();
			$this->init_settings();
			
			$this->title = $this->settings['title'];
			$this->merchant_id = $this->settings['merchant_id'];
			$this->account_id = $this->settings['account_id'];
			$this->api_key = $this->settings['api_key'];
			$this->api_login = $this->settings['api_login'];
			$this->language = $this->settings['language'];
			$this->gateway_url = $this->settings['gateway_url'];
			$this->test = $this->settings['test'];
			$this->environment = $this->settings['environment'];			
			$this->response_page = $this->settings['response_page'];
			$this->confirmation_page = $this->settings['confirmation_page'];
			
			if (version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=' )) {
                add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( &$this, 'process_admin_options' ) );
             } else {
                add_action( 'woocommerce_update_options_payment_gateways', array( &$this, 'process_admin_options' ) );
            }
			add_action('woocommerce_receipt_payulatam', array(&$this, 'receipt_page'));
		}
		
		/**
		 * Funcion que define los campos que iran en el formulario en la configuracion
		 * de la pasarela de PayU Latam
		 *
		 * @access public
		 * @return void
		 */
		function init_form_fields() {
			$this->form_fields = array(
				'enabled' => array(
                    'title' => __('Habilitar/Deshabilitar', 'payu_latam'),
                    'type' => 'checkbox',
                    'label' => __('Habilita la pasarela de pago PayU Latam', 'payu_latam'),
                    'default' => 'no'),
                'title' => array(
                    'title' => __('Título', 'payu_latam'),
                    'type'=> 'text',
                    'description' => __('Título que el usuario verá durante checkout.', 'payu_latam'),
                    'default' => __('PayU Latam', 'payu_latam')),
                'merchant_id' => array(
                    'title' => __('Merchant ID', 'payu_latam'),
                    'type' => 'text',
                    'description' => __('ID único de usuario en PayU Latam.', 'payu_latam')),
                'account_id' => array(
                    'title' => __('Account ID', 'payu_latam'),
                    'type' => 'text',
                    'description' => __('ID de la cuenta en PayU Latam.', 'payu_latam')),
                'api_key' => array(
                    'title' => __('API Key', 'payu_latam'),
                    'type' => 'text',
                    'description' => __('Llave que sirve para encriptar la comunicación con PayU Latam.', 'payu_latam')),
				'api_login' => array(
					'title' => __('API Login', 'payu_latam'),
					'type' => 'text',
					'description' => __('Llave que sirve para comunicacion con PayU Latam.', 'payu_latam')),				
				'language' => array(
					'title' => __('Language', 'payu_latam'),
					'type' => 'text',
					'description' => __('Lenguaje del pago.', 'payu_latam'),
					'default' => __('es', 'payu_latam')),
                'gateway_url' => array(
                    'title' => __('Gateway URL', 'payu_latam'),
                    'type' => 'text',
					'description' => __('URL de la página que tiene llas opciones para los pagos. No olvide cambiar su dominio.', 'payu_latam'),
					'default' => __('http://su.dominio.com/wp-content/plugins/woocommerce-intregrate-with-api-payu/admin/pay_gateway.php', 'payu_latam')),
				'test' => array(
                    'title' => __('Transacciones en modo de prueba', 'payu_latam'),
                    'type' => 'checkbox',
                    'label' => __('Habilita las transacciones en modo de prueba.', 'payu_latam'),
                    'default' => 'no'),
				'environment' => array(
					'title' => __('Ambiente donde se ejecutra las transacciones', 'payu_latam'),
					'type' => 'text',
					'label' => __('Permite generar peticiones  amabiente de desarrollo o produccion (development o production).', 'payu_latam'),
					'default' => 'development'),
                'response_page' => array(
                    'title' => __('Página de respuesta'),
                    'type' => 'text',
                    'description' => __('URL de la página mostrada después de finalizar el pago. No olvide cambiar su dominio.', 'payu_latam'),
					'default' => __('http://su.dominio.com/wp-content/plugins/woocommerce-intregrate-with-api-payu/response.php', 'payu_latam')),
                'confirmation_page' => array(
                    'title' => __('Página de confirmación'),
                    'type' => 'text',
                    'description' => __('URL de la página que recibe la respuesta definitiva sobre los pagos. No olvide cambiar su dominio.', 'payu_latam'),
					'default' => __('http://su.dominio.com/wp-content/plugins/woocommerce-intregrate-with-api-payu/confirmation.php', 'payu_latam'))
			);
		}
		
		/**
         * Muestra el formulario en el admin con los campos de configuracion del gateway PayU Latam
		 * 
		 * @access public
         * @return void
         */
        public function admin_options() {
			echo '<h3>'.__('PayU API Latam Payment Gateway', 'payu_latam').'</h3>';
			echo '<table class="form-table">';
			$this -> generate_settings_html();
			echo '</table>';
		}
		
		/**
		 * Atiende el evento de checkout y genera la pagina con el formularion de pago.
		 * Solo para la versiones anteriores a la 2.1.0 de WC
         *
         * @access public
         * @return void
		 */
		function receipt_page($order){
			echo '<p>'.__('Gracias por su pedido, de clic en el botón que aparece para continuar el pago con PayU Latam.', 'payu_latam').'</p>';
			echo $this -> generate_payulatam_form($order);
		}
		
		/**
		 * Construye un arreglo con todos los parametros que seran enviados al gateway de PayU Latam
         *
         * @access public
         * @return void
		 */
		public function get_params_post($order_id){
			global $woocommerce;
			$order = new WC_Order( $order_id );
			$currency = get_woocommerce_currency();
			$amount = number_format(($order -> get_total()),2,'.','');
			$signature = md5($this -> api_key . '~' . $this -> merchant_id . '~' . $order -> id . '~' . $amount . '~' . $currency );
			$description = "";
			$products = $order->get_items();
			foreach($products as $product) {
				$description .= $product['name'] . ',';
			}
                        
                        if (strlen($description) > 255){
                            $description = substr($description,0,240).' y otros...';
                        }
                        
			$tax = number_format(($order -> get_total_tax()),2,'.','');
			$taxReturnBase = number_format(($amount - $tax),2,'.','');
			if ($tax == 0) $taxReturnBase = 0;
			
			$test = 0;
			if($this->test == 'yes') $test = 1;
			
			$parameters_args = array(
				'merchantId' => $this->merchant_id,
				'referenceCode' => $order -> id,
				'description' => trim($description, ','),
				'amount' => $amount,
				'tax' => $tax,
				'taxReturnBase' => $taxReturnBase,
				'signature' => $signature,
				'accountId' => $this->account_id,
				'currency' => $currency,
				'buyerEmail' => $order -> billing_email,
				'language' => $this->language,				
				'test' => $test,
				'environment' => $this->environment,
				'confirmationUrl' => $this->confirmation_page,
				'responseUrl' => $this->response_page,
				'shippingAddress' => $order->shipping_address_1,
				'shippingCountry' => $order->shipping_country,
				'shippingCity' => $order->shipping_city,
				'billingAddress' => $order->billing_address_1,
				'billingCountry' => $order->billing_country,
				'billingCity' => $order->billing_city,
				'extra1' => 'WOOCOMMERCE'
			);
			return $parameters_args;
		}
				
		/**
		 * Metodo que genera el formulario con los datos de pago
         *
         * @access public
         * @return void
		 */
		public function generate_payulatam_form($order_id){			
			$parameters_args = $this->get_params_post($order_id);
			
			$payu_args_array = array();
			foreach($parameters_args as $key => $value){
				$payu_args_array[] = $key . '=' . $value;
			}
			$params_post = implode('&', $payu_args_array);

			$payu_args_array = array();
			foreach($parameters_args as $key => $value){
			  $payu_args_array[] = "<input type='hidden' name='$key' value='$value'/>";
			}
			return '<form action="'.$this->gateway_url.'" method="post" id="payu_latam_form">' . implode('', $payu_args_array) 
				. '<input type="submit" id="submit_payu_latam" value="' .__('Pagar', 'payu_latam').'" /></form>';
		}
		
		/**
		 * Procesa el pago 
         *
         * @access public
         * @return void
		 */
		function process_payment($order_id) {
			global $woocommerce;
			$order = new WC_Order($order_id);
			$woocommerce->cart->empty_cart();
			if (version_compare(WOOCOMMERCE_VERSION, '2.0.19', '<=' )) {
				return array('result' => 'success', 'redirect' => add_query_arg('order',
					$order->id, add_query_arg('key', $order->order_key, get_permalink(get_option('woocommerce_pay_page_id'))))
				);
			} else {
			
				$parameters_args = $this->get_params_post($order_id);
				
				$payu_args_array = array();
				foreach($parameters_args as $key => $value){
					$payu_args_array[] = $key . '=' . $value;
				}
				$params_post = implode('&', $payu_args_array);
			
				return array(
					'result' => 'success',
					'redirect' =>  $order->get_checkout_payment_url( true )
				);
			}
		}
		
		/**
		 * Retorna la configuracion del api key
		 */
		function get_api_key() {
			return $this->settings['api_key'];
		}

		/**
		 * Retorna la configuracion del api key
		 */
		function get_api_login() {
			return $this->settings['api_login'];
		}
		
	}

	/**
	 * Ambas funciones son utilizadas para notifcar a WC la existencia de PayU Latam
	 */
	function add_payu_latam_integration($methods) {
		$methods[] = 'WC_Api_Payu_Payment_Gateway';
		return $methods;
	}
	add_filter('woocommerce_payment_gateways', 'add_payu_latam_integration' );	
}