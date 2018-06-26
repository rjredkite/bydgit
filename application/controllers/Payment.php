<?php 
	class Payment extends CI_Controller{

		function __construct() {
			parent::__construct();
			$paypal_details = array(
				// you can get this from your Paypal account, or from your
				// test accounts in Sandbox
				'API_username' => 'breedyourdog_api1.hotmail.co.uk', 
				'API_signature' => 'AW8Bt5CFoXq0rnxdLpML5ykcLf7EAUBRtmCsKwEeSEf-G.4XdoV20xNp', 
				'API_password' => 'AFZCHLVKCZBFJYNS',
				// Paypal_ec defaults sandbox status to true
				// Change to false if you want to go live and
				// update the API credentials above
				'sandbox_status' => false,
			);
			$this->load->library('paypal_ec', $paypal_details);
		}
		
		public function payment(){
			redirect('payment/new');
		}

		public function us_payment(){
			redirect('us/payment/new');
		}

		public function cancelled(){

			$data['metatitle']          = 'Breed Your Dog';
            $data['metakeyword']        = '';
            $data['metadescription']    = '';
            $data['metarobots']         = '';

            $this->load->view('templates/header',$data);
            $this->load->view('templates/page-payment-cancelled',$data);
            $this->load->view('templates/footer',$data);

		}

		public function payment_credits(){

			if($this->input->post('credits')){

			if($this->uri->segment(1) == 'us'){
				$iploc['country'] = 'US - United States';
			}else{
				$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
			}

			if($iploc['country'] == 'US - United States'){
				$country_lang = 'us';
			}else{
				$country_lang = '';
			}

			if($country_lang == 'us'){
				$paypal_currency = 'USD';
				$paypal_currency_symbol = '$';
			}else{
				$paypal_currency = 'GBP';
				$paypal_currency_symbol = '£';
			}
			
			if($this->input->post('credits') == 1 && $country_lang == 'us'){
				$paypal_name = 'Credit';
				$paypal_desription = '1 Credit - $1.50';
				$paypal_price = 1.5;
			}elseif($this->input->post('credits') == 5 && $country_lang == 'us'){
				$paypal_name = 'Credits';
				$paypal_desription = '5 Credits - $6.00';
				$paypal_price = 6;
			}elseif($this->input->post('credits') == 1 && $country_lang != 'us'){
				$paypal_name = 'Credit';
				$paypal_desription = '1 Credit - £1.00';
				$paypal_price = 1;
			}else{
				$paypal_name = 'Credits';
				$paypal_desription = '5 Credits - £4.00';
				$paypal_price = 4;
			}

			$credits = $this->input->post('credits');

			$product = array(
				'Credits' => array('name' => $paypal_name, 'desc' => $paypal_desription, 'price' => $paypal_price));
			$currency = $paypal_currency; // currency for the transaction
			$ec_action = 'Sale'; // for PAYMENTREQUEST_0_PAYMENTACTION, it's either Sale, Order or Authorization

			$users_id_session = $this->session->userdata('user_id_byd');

			$currency_symbol = $paypal_currency_symbol;

			$description = $paypal_desription;

			$user_id = $users_id_session;

			$amount = $paypal_price;

			$payment_id = $this->payment_model->credit_payment($user_id,$amount,$currency,$currency_symbol,$description,$credits);

			$payment_session_id = array(
				'payment_session_id' => $payment_id
			);
			$this->session->set_userdata($payment_session_id);

			$to_buy = array(
				'desc' => 'Breed Your Dog', 
				'currency' => $currency, 
				'type' => $ec_action, 
				'return_URL' => site_url('payment/completed'), 
				// see below have a function for this -- function back()
				// whatever you use, make sure the URL is live and can process
				// the next steps
				'cancel_URL' => site_url('payment/cancelled'), // this goes to this controllers index()
				'shipping_amount' => 0, 
				'get_shipping' => false);
			// I am just iterating through $this->product from defined
			// above. In a live case, you could be iterating through
			// the content of your shopping cart.
			foreach($product as $p) {
				$temp_product = array(
					'name' => $p['name'], 
					'desc' => $p['desc'], 
					//'number' => $p['code'], 
					'quantity' => 1, // simple example -- fixed to 1
					'amount' => $p['price']);
					
				// add product to main $to_buy array
				$to_buy['products'][] = $temp_product;
			}
			// enquire Paypal API for token
			$set_ec_return = $this->paypal_ec->set_ec($to_buy);
			if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
				/* --------------------------
				* redirect to Paypal 
				-------------------------- */
				$this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
				/* -------------------------------------------------------------------------------------
				* You could detect your visitor's browser and redirect to Paypal's mobile checkout
				* if they are on a mobile device. Just add a true as the last parameter. It defaults
				* to false
				* $this->paypal_ec->redirect_to_paypal( $set_ec_return['TOKEN'], true);
				--------------------------------------------------------------------------------------*/

			} else {
				$this->_error($set_ec_return);
			}
				
			}else{

				redirect('payment/new');
				
			}
		}

		function completed() {

			$token = $_GET['token'];
			$payer_id = $_GET['PayerID'];

			$get_ec_return = $this->paypal_ec->get_ec($token);
			if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {

				$ec_details = array(
					'token' => $token, 
					'payer_id' => $payer_id,
					'currency' => $get_ec_return['PAYMENTREQUEST_0_CURRENCYCODE'], 
					'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 
					'IPN_URL' => site_url('payment/ipn'), 
					'type' => 'Sale');
					
				$do_ec_return = $this->paypal_ec->do_ec($ec_details);
				if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {

					$this->payment_model->credit_payment_update($this->session->userdata('payment_session_id'),$get_ec_return['TOKEN'],$get_ec_return['PAYERID'],$do_ec_return['PAYMENTINFO_0_TRANSACTIONID'],$do_ec_return['PAYMENTINFO_0_FEEAMT'],$do_ec_return['PAYMENTINFO_0_PAYMENTSTATUS']);

					if($get_ec_return['L_PAYMENTREQUEST_0_DESC0'] == '1 Credit - $1.50' || $get_ec_return['L_PAYMENTREQUEST_0_DESC0'] == '1 Credit - £1.00'){

						$credits = '1';

					}elseif($get_ec_return['L_PAYMENTREQUEST_0_DESC0'] == '5 Credits - $6.00' || $get_ec_return['L_PAYMENTREQUEST_0_DESC0'] == '5 Credits - £4.00'){

						$credits = '5';

					}

					if($do_ec_return['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed'){
						$this->payment_model->user_credits($this->session->userdata('user_id_byd'),$credits);
					}

					$this->session->set_flashdata('flashdata_success', 'Payment was successful');

					$iploc = geoCheckIP($this->input->ip_address());
    				$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
					if($iploc['country'] == 'US - United States'){
						redirect('us/user/dashboard');
					}else{
						redirect('user/dashboard');
					}

				} else {
					$this->_error($do_ec_return);

					$iploc = geoCheckIP($this->input->ip_address());
    				$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
					if($iploc['country'] == 'US - United States'){
						redirect('us/payment/new');
					}else{
						redirect('payment/new');
					}

				}
			} else {
				$this->_error($get_ec_return);

				$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
				if($iploc['country'] == 'US - United States'){
					redirect('us/payment/new');
				}else{
					redirect('payment/new');
				}
					
			}
		}
		
		/* -------------------------------------------------------------------------------------------------
		* The location for your IPN_URL that you set for $this->paypal_ec->do_ec(). obviously more needs to
		* be done here. this is just a simple logging example. The /ipnlog folder should the same level as
		* your CodeIgniter's index.php
		* --------------------------------------------------------------------------------------------------
		*/
		function ipn() {
			$logfile = 'ipnlog/' . uniqid() . '.html';
			$logdata = "<pre>\r\n" . print_r($_POST, true) . '</pre>';
			file_put_contents($logfile, $logdata);
		}
		
		/* -------------------------------------------------------------------------------------------------
		* a simple message to display errors. this should only be used during development
		* --------------------------------------------------------------------------------------------------
		*/
		function _error($ecd) {
			echo "<br>error at Express Checkout<br>";
			echo "<pre>" . print_r($ecd, true) . "</pre>";
			echo "<br>CURL error message<br>";
			echo 'Message:' . $this->session->userdata('curl_error_msg') . '<br>';
			echo 'Number:' . $this->session->userdata('curl_error_no') . '<br>';
		}


	}