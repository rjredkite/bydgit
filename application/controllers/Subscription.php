<?php 
      class Subscription extends CI_Controller{

            function __construct() {
                  parent::__construct();
                  $paypal_details = array(
                        // you can get this from your Paypal account, or from your
                        // test accounts in Sandbox
                        'API_username' => 'breedyourdog_api1.hotmail.co.uk', 
                        'API_signature' => 'AW8Bt5CFoXq0rnxdLpML5ykcLf7EAUBRtmCsKwEeSEf-G.4XdoV20xNp', 
                        'API_password' => 'AFZCHLVKCZBFJYNS',
                        // Paypal_recurring defaults sandbox status to true
                        // Change to false if you want to go live and
                        // update the API credentials above
                        'sandbox_status' => false,
                  );
                  $this->load->library('paypal_recurring', $paypal_details);
            }

            /*===========================================================================
            [-- SUBSCRIPTION PAYMENT SHOW  ---------------------------------------------]
            ===========================================================================*/
            public function show(){

                  $data['metatitle']          = 'Breed Your Dog';
                  $data['metakeyword']        = '';
                  $data['metadescription']    = '';
                  $data['metarobots']         = '';

                  if(isset($_GET['token'])){
                        $this->load->view('templates/header',$data);
                        $this->load->view('templates/page-subscription-show',$data);
                        $this->load->view('templates/footer',$data);
                  }else{
                        show_404();
                  }

            }


            /*===========================================================================
            [-- SUBSCRIPTION PAYMENT COMPLETED -----------------------------------------]
            ===========================================================================*/
            function completed() {

                  $token = $_GET['token'];
                  $payer_id = $_GET['PayerID'];

                  $get_ec_return = $this->paypal_recurring->get_ec($token);

                  if($this->session->userdata('payment_change_plan')){

                        $sub = $this->payment_model->get_subscription($this->session->userdata('user_id_byd'));

                        $this->paypal_change_subscription->change_subscription_status($sub['paypal_id'],'Cancel');

                        $this->users_model->user_change_plan_delete_user_id($this->session->userdata('user_id_byd'));
                  }

                  if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {

                        $ec_details = array(
                              'token' => $token, 
                              'payer_id' => $payer_id,
                              'currency' => $get_ec_return['PAYMENTREQUEST_0_CURRENCYCODE'], 
                              'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 
                              'custom_id' => $this->session->userdata('payment_session_id'),
                              'IPN_URL' => site_url('payment/ipn'), 
                              'type' => 'Sale');
                              
                        $do_ec_return = $this->paypal_recurring->do_ec($ec_details);

                        if($do_ec_return['PAYMENTINFO_0_ACK'] == 'Success'){
                              $this->users_model->subscription_completed_ec($this->session->userdata('payment_session_id'),$do_ec_return['PAYMENTINFO_0_TRANSACTIONID']);
                        }

                        if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {

                              $rec_details = array(

                                    'token'     =>    $token,
                                    'payer_id'  =>    $get_ec_return['PAYERID'],
                                    'profile_start_date'     => $do_ec_return['TIMESTAMP'],
                                    'description'     => $this->session->userdata('payment_sub_description'),
                                    'billing_period'     => 'Month',
                                    'billing_frequency'     => 1,  
                                    'total_billing_cycles'     => 0, 
                                    'max_failed_payments'     => 1, 
                                    'amount'     =>  $ec_details['amount'],
                                    'currency_code'     => $ec_details['currency'],
                                    'paymentrequest_item_category'     =>  'Digital',
                                    'paymentrequest_name'     =>   'Breedyourdog Subscription',
                                    'paymentrequest_amount'     =>   $ec_details['amount'],
                                    'paymentrequest_qty'     =>   '1',
                                    'IPN_URL' => site_url('payment/ipn'), 

                              );

                              $do_rec_return = $this->paypal_recurring->do_rec($rec_details);

                              $plan = $this->getdata_model->get_plans_id($this->session->userdata('payment_plan_id'));

                              if($do_rec_return['ACK'] == 'Success'){

                                    $this->users_model->users_new_payment($this->session->userdata('payment_session_id'),$this->session->userdata('payment_plan_id'),$plan['free_featured_weeks']);
                            

                                    $user = $this->getdata_model->get_user($this->session->userdata('payment_session_id'));

                                    $users_login_as = $this->users_model->userlogin_as($this->session->userdata('payment_session_id'));

                                    $this->users_model->update_subscription_login_as($this->session->userdata('payment_session_id'));

                                    if($users_login_as){

                                          if($users_login_as['banned'] == 1){

                                                $this->session->set_flashdata('flashdata_failed', 'You have been banned from Breed Your Dog.');
                                                      redirect(''.base_url().'');

                                          }else{

                                                $users_id = $users_login_as['id']; 

                                                $data['users'] = $this->users_model->get_users($users_id);
                                                $user_data = array(
                                                      'user_id_byd' => $data['users']['id'],
                                                      'userlogged_in' => true
                                                );
                                                $this->session->set_userdata($user_data);


                                                if($this->session->userdata('payment_change_plan')){

                                                      $plan = $this->getdata_model->get_plans_id($this->session->userdata('payment_plan_id'));

                                                      $this->session->set_flashdata('flashdata_success', 'Successfuly Change Plan into '.$plan['name']);
                                                      if($this->uri->segment(1) == 'us'){
                                                            $iploc['country'] = 'US - United States';
                                                      }else{
                                                            $iploc = geoCheckIP($this->input->ip_address());
                                                            $iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
                                                      }
                                                
                                                      if($iploc['country'] == 'US - United States'){
                                                            redirect('us/user/dashboard');
                                                      }else{
                                                            redirect('user/dashboard');
                                                      }     

                                                }else{
                                                      $this->session->set_flashdata('flashdata_info', 'Your subscription has been activated');

                                                      $iploc = geoCheckIP($this->input->ip_address());
                                                      $iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

                                                      if($this->uri->segment(1) == 'us'){
                                                            $iploc['country'] = 'US - United States';
                                                      }else{
                                                            $iploc = geoCheckIP($this->input->ip_address());
                                                            $iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
                                                      }
                                                
                                                      if($iploc['country'] == 'US - United States'){
                                                          redirect('us/user/edit');
                                                      }else{
                                                          redirect('user/edit');
                                                      } 
                                                }


                                          }
                                          

                                    }else{
                                          $this->session->set_flashdata('flashdata_failed', 'Invallid Email or Password');
                                          redirect(''.base_url().'');
                                    }

                              }else{ 
                                    echo 'error';
                              }                   

                        } else {
                              
                              $iploc = geoCheckIP($this->input->ip_address());
                              $iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
                              if($this->uri->segment(1) == 'us'){
                                    $iploc['country'] = 'US - United States';
                              }else{
                                    $iploc = geoCheckIP($this->input->ip_address());
                                    $iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
                              }
                        
                              if($iploc['country'] == 'US - United States'){
                                    redirect('us/user');
                              }else{
                                    redirect('user');
                              }                                        

                        }
                  } else {
                        
                        $iploc = geoCheckIP($this->input->ip_address());
                        $iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
                        if($iploc['country'] == 'US - United States'){
                              redirect('us/user/new');
                        }else{
                              redirect('user/new');
                        }
                              
                  }

            }
            
            public function cancelled(){

                  $data['metatitle']          = 'Breed Your Dog';
                  $data['metakeyword']        = '';
                  $data['metadescription']    = '';
                  $data['metarobots']         = '';

                  if(isset($_GET['token'])){
                        $this->load->view('templates/header',$data);
                        $this->load->view('templates/page-subscription-cancelled',$data);
                        $this->load->view('templates/footer',$data);
                  }else{
                        show_404();
                  }

            }

            public function ipn_back(){

                  /*// STEP 1: Read POST data

                  // reading posted data from directly from $_POST causes serialization 
                  // issues with array data in POST
                  // reading raw POST data from input stream instead. 
                  $raw_post_data = file_get_contents('php://input');
                  $raw_post_array = explode('&', $raw_post_data);
                  $myPost = array();
                  foreach ($raw_post_array as $keyval) {
                    $keyval = explode ('=', $keyval);
                    if (count($keyval) == 2)
                       $myPost[$keyval[0]] = urldecode($keyval[1]);
                  }
                  // read the post from PayPal system and add 'cmd'
                  $req = 'cmd=_notify-validate';
                  if(function_exists('get_magic_quotes_gpc')) {
                     $get_magic_quotes_exists = true;
                  } 
                  foreach ($myPost as $key => $value) {        
                     if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
                          $value = urlencode(stripslashes($value)); 
                     } else {
                          $value = urlencode($value);
                     }
                     $req .= "&$key=$value";
                  }

                  // STEP 2: Post IPN data back to paypal to validate

                  $ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr'); // change to [...]sandbox.paypal[...] when using sandbox to test
                  curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                  curl_setopt($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                  curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

                  // In wamp like environments that do not come bundled with root authority certificates,
                  // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
                  // of the certificate as shown below.
                  // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
                  if( !($res = curl_exec($ch)) ) {
                      // error_log("Got " . curl_error($ch) . " when processing IPN data");
                      curl_close($ch);
                      exit;
                  }
                  curl_close($ch);*/

                  // STEP 1: read POST data
                  // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
                  // Instead, read raw POST data from the input stream.
                  $raw_post_data = file_get_contents('php://input');
                  $raw_post_array = explode('&', $raw_post_data);
                  $myPost = array();
                  foreach ($raw_post_array as $keyval) {
                    $keyval = explode ('=', $keyval);
                    if (count($keyval) == 2)
                      $myPost[$keyval[0]] = urldecode($keyval[1]);
                  }
                  // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
                  $req = 'cmd=_notify-validate';
                  if (function_exists('get_magic_quotes_gpc')) {
                    $get_magic_quotes_exists = true;
                  }
                  foreach ($myPost as $key => $value) {
                    if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                      $value = urlencode(stripslashes($value));
                    } else {
                      $value = urlencode($value);
                    }
                    $req .= "&$key=$value";
                  }

                  // Step 2: POST IPN data back to PayPal to validate
                  $ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
                  curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                  curl_setopt($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                  curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
                  // In wamp-like environments that do not come bundled with root authority certificates,
                  // please download 'cacert.pem' from "https://curl.haxx.se/docs/caextract.html" and set
                  // the directory path of the certificate as shown below:
                  // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
                  if ( !($res = curl_exec($ch)) ) {
                    // error_log("Got " . curl_error($ch) . " when processing IPN data");
                    curl_close($ch);
                    exit;
                  }
                  curl_close($ch);


                  // STEP 3: Inspect IPN validation result and act accordingly

                  if (strcmp ($res, "VERIFIED") == 0) {
                      // check whether the payment_status is Completed
                      // check that txn_id has not been previously processed
                      // check that receiver_email is your Primary PayPal email
                      // check that payment_amount/payment_currency are correct
                      // process payment

                      // assign posted variables to local variables

                        if($_POST['txn_type'] == 'express_checkout'){

                              $custom_id = $_POST['custom'];
                              $transaction_id = $_POST['txn_id'];
                              $payer_id = $_POST['payer_id'];
                              $this->payment_model->subscription_ipn_ec($custom_id,$transaction_id,$payer_id);  

                        }else if($_POST['txn_type'] == 'recurring_payment_profile_created'){

                              $payer_id = $_POST['payer_id'];
                              $recurring_payment_id = $_POST['recurring_payment_id'];
                              $time_created = $_POST['time_created'];
                              $next_payment_date = $_POST['next_payment_date'];
                              $status = $_POST['profile_status'];
                              $this->payment_model->subscription_ipn_rec_create($payer_id,$recurring_payment_id,$time_created,$next_payment_date,$status);  

                        }else if($_POST['txn_type'] == 'recurring_payment'){

                              $recurring_payment_id = $_POST['recurring_payment_id'];
                              $next_payment_date = $_POST['next_payment_date'];
                              $status = $_POST['profile_status'];

                              $this->payment_model->subscription_ipn_recurring_paments($recurring_payment_id,$next_payment_date,$status);

                              if($status != 'Active'){
                                    $rec_email = $this->payment_model->subscription_ipn_rec_email($recurring_payment_id);

                                    $plan_active = $this->getdata_model->get_plans_id($rec_email['plan_id']);

                                    $config['protocol'] = 'sendmail';
                                    $config['charset'] = 'utf-8';
                                    $config['wordwrap'] = TRUE;
                                    $config['mailtype'] = 'html';

                                    $this->email->initialize($config);

                                    $this->email->from('no-reply@breedyourdog.com');
                                    $this->email->to($rec_email['email']);
                                    $this->email->bcc('byd@breedyourdog.com');

                                    $this->email->subject('Expired');

                                    $email_style = '<link href="'.base_url() .'assets/css/style-admin.min.css" rel="stylesheet" type="text/css">';

                                    $this->email->message('
                                          <!DOCTYPE html>
                                                <html>
                                                <head>
                                                      <title>Breed Your Dog</title>
                                                      '.$email_style.'
                                                      <style>
                                                            body{
                                                                  font-family: "Montserrat Light";
                                                                  font-size: 14px;
                                                            }
                                                      </style>
                                                </head>
                                                <body>
                                                     <p>Hi '.$rec_email['first_name'].',</p>

                                                      <p>
                                                        Your Breed Your Dog paid subscription has expired, and your account has been downgraded to the Basic (Free) level.
                                                      </p>

                                                      <p>
                                                            If you had more than '.$plan_active['active_listings'].' active listings, the aditional listings will have been disabled, as the free account has a limit of '.$plan_active['active_listings'].' active listings per user.
                                                      </p>

                                                      <p><i>
                                                        Kind Regards<br />
                                                        The Breed Your Dog Team
                                                      </i></p>
                                                      
                                                </body>
                                                </html>
                                          ');

                                    $this->email->send();
                                    $this->payment_model->subscription_delete_user_id($recurring_payment_id);
                              }

                        }else if($_POST['txn_type'] == 'recurring_payment_suspended'){

                              $recurring_payment_id = $_POST['recurring_payment_id'];
                              $next_payment_date = $_POST['next_payment_date'];
                              $status = $_POST['profile_status'];

                              $this->payment_model->subscription_ipn_recurring_paments($recurring_payment_id,$next_payment_date,$status);

                              if($status != 'Active'){
                                    $rec_email = $this->payment_model->subscription_ipn_rec_email($recurring_payment_id);

                                    $plan_active = $this->getdata_model->get_plans_id($rec_email['plan_id']);

                                    $config['protocol'] = 'sendmail';
                                    $config['charset'] = 'utf-8';
                                    $config['wordwrap'] = TRUE;
                                    $config['mailtype'] = 'html';

                                    $this->email->initialize($config);

                                    $this->email->from('no-reply@breedyourdog.com');
                                    $this->email->to($rec_email['email']);
                                    $this->email->bcc('byd@breedyourdog.com');

                                    $this->email->subject('Expired');

                                    $email_style = '<link href="'.base_url() .'assets/css/style-admin.min.css" rel="stylesheet" type="text/css">';

                                    $this->email->message('
                                          <!DOCTYPE html>
                                                <html>
                                                <head>
                                                      <title>Breed Your Dog</title>
                                                      '.$email_style.'
                                                      <style>
                                                            body{
                                                                  font-family: "Montserrat Light";
                                                                  font-size: 14px;
                                                            }
                                                      </style>
                                                </head>
                                                <body>
                                                     <p>Hi '.$rec_email['first_name'].',</p>

                                                      <p>
                                                        Your Breed Your Dog paid subscription has expired, and your account has been downgraded to the Basic (Free) level.
                                                      </p>

                                                      <p>
                                                            If you had more than '.$plan_active['active_listings'].' active listings, the aditional listings will have been disabled, as the free account has a limit of '.$plan_active['active_listings'].' active listings per user.
                                                      </p>

                                                      <p><i>
                                                        Kind Regards<br />
                                                        The Breed Your Dog Team
                                                      </i></p>
                                                      
                                                </body>
                                                </html>
                                          ');

                                    $this->email->send();
                                    $this->payment_model->subscription_delete_user_id($recurring_payment_id);
                              }


                        }else if($_POST['txn_type'] == 'recurring_payment_profile_cancel'){

                              $recurring_payment_id = $_POST['recurring_payment_id'];
                              $next_payment_date = $_POST['next_payment_date'];
                              $status = $_POST['profile_status'];

                              $this->payment_model->subscription_ipn_recurring_paments($recurring_payment_id,$next_payment_date,$status);
                        }

                  } else if (strcmp ($res, "INVALID") == 0) {
                      // log for manual investigation
                        show_404();

                  }

            }

            /* -------------------------------------------------------------------------------------------------
            * The location for your IPN_URL that you set for $this->paypal_recurring->do_ec(). obviously more needs to
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