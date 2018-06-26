<?php
	class Connections extends CI_Controller{

		public function user_connection(){
			if(!$this->session->userdata('userlogged_in')){
				$this->session->set_flashdata('flashdata_failed', 'You need log in to access this area');
	    		
	    		$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

				if($iploc['country'] == 'US - United States'){
					redirect(''.base_url('us').'');
				}else{
					redirect(''.base_url().'');
				}
	    	}

	    	$id = $this->session->userdata('user_id_byd');
	    	$checking = $this->users_model->checkinfo($id);

	    	if($checking['first_name'] == '' && $checking['last_name'] == '' && $checking['phone'] == '' && $checking['address'] == '' && $checking['post_code'] == ''){

	    		$this->session->set_flashdata('flashdata_danger', 'You must complete your account set up before you can create listings, or contact other listings.');
	    		$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
				if($iploc['country'] == 'US - United States'){
					redirect('us/user/edit');
				}else{
					redirect('user/edit');
				}
	    	}

			$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$users_id = $this->session->userdata('user_id_byd');

			$data['userconnections'] = $this->connection_model->get_user_connections($users_id);
			
			$this->load->view('templates/header',$data);
			$this->load->view('users/pages/connections',$data);
			$this->load->view('templates/footer',$data);

		}


		public function connection($connection_id){

			if(!$this->session->userdata('userlogged_in')){
				$this->session->set_flashdata('flashdata_failed', 'You need log in to access this area');

	    		$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];	

				if($iploc['country'] == 'US - United States'){
					redirect(''.base_url('us').'');
				}else{
					redirect(''.base_url().'');
				}
	    	}

			$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$users_id = $this->session->userdata('user_id_byd');

  			$listing_id = $connection_id;
  			$data['listing'] = $this->getdata_model->get_listing($listing_id);

  			$id = $data['listing']['user_id'];
  			$userinformations_listing = $this->users_model->user_info($id);

  			if($users_id == $data['listing']['user_id']){
  				$this->session->set_flashdata('flashdata_danger', 'You cannot connect with your own listing');
  				$slug_title = url_title($data['listing']['title'], 'dash', TRUE);

  				if($data['listing']['listing_type'] == 'dog'){
                  $listname = 'stud-dogs';
                }elseif($data['listing']['listing_type'] == 'pup'){
                  $listname = 'puppies';
                }elseif($data['listing']['listing_type'] == 'mem'){
                  $listname = 'memorials';
                }

                $iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

				if($iploc['country'] == 'US - United States'){
					redirect('us/'.$listname.'/'.$connection_id.'/'.$slug_title);
				}else{
					redirect($listname.'/'.$connection_id.'/'.$slug_title);
				}  
  				
  			}

  			foreach($userinformations_listing as $userinfo){
  				$plan_id = $userinfo['plan_id'];
  			}

  			$plan = $this->getdata_model->get_plans_id($plan_id);

  			if($plan['free_to_contact'] == 1){

				$connections = $this->connection_model->check_connections($users_id,$listing_id);

				if(empty($connections)){

					$connections_id = $this->connection_model->connection_paid_credits($listing_id,$users_id);
	    			$this->session->set_flashdata('flashdata_info', "The owner of this listing has a paid account, so you did not need to pay for these contact details.");

	    			$listing = $this->getdata_model->get_listing($connection_id);

	    			$owner = $this->users_model->get_users($listing['user_id']);

	    			$config['protocol'] = 'sendmail';
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';

					$this->email->initialize($config);

					/*$this->email->from('no-reply@breedyourdog.com');*/
					$this->email->from('byd@breedyourdog.com');
					$this->email->to($owner['email']);
					/*$this->email->cc('rj@page1europe.eu');*/
					$this->email->bcc('byd@breedyourdog.com');

					$this->email->subject('Breed Your Dog enquiry');

					$email_style = '<link href="'.base_url() .'assets/css/style-admin.min.css" rel="stylesheet" type="text/css">';

					if($listing['listing_type'] == 'dog'){
	                  $listing_type = 'Stud Dog / Bitch';
	                }elseif($listing['listing_type'] == 'pup'){
	                  $listing_type = 'Puppies';
	                }elseif($listing['listing_type'] == 'mem'){
	                  $listing_type = 'Memorials';
	                }

					$this->email->message('
						<!DOCTYPE html>
							<html>
							<head>
								<title>Welcome to Breed Your Dog</title>
								'.$email_style.'
								<style>
									body{
										font-family: "Montserrat Light";
										font-size: 14px;
									}
								</style>
							</head>
							<body>
								<p>Dear '.$owner['first_name'].',</p>
								<p>Great news! You have a connection!</p>
								<p>This means that a user has purchased a credit and used it to obtain the contact details for your '.$listing_type.' "'.$listing['title'].'" . </p>
								<p>This is how our site works and why BreedYourDog.com is as popular as it is today being the biggest and fastest-growing stud dog website with people making genuine enquiries about your dog. </p>
								<p>Please always check that you keep your contact details and your information up to date and inputted correctly so people don’t end up wasting time and money on incorrect or unobtainable connections. </p>
								<p>We hope you are contacted and that the result will be successful for both you and your dog!</p>
								<p>
									<i>
										Kind Regards<br>
										The Breed Your Dog Team 
									</i>
								</p>
								
							</body>
							</html>
						');

					$this->email->send();

				}else{

					$connections_id = $connections['id'];
	    			$this->session->set_flashdata('flashdata_info', "You have already paid for this listing's contact details, you have not been charged again.");
				}
  				
  				$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

				if($iploc['country'] == 'US - United States'){
					redirect('us/connections/'.$connections_id);
				}else{
					redirect('connections/'.$connections_id);
				}  


  			}else{

  				$connections = $this->connection_model->check_connections($users_id,$listing_id);

				if(empty($connections)){

	  				$this->load->view('templates/header',$data);
					$this->load->view('pages/listing-connection',$data);
					$this->load->view('templates/footer',$data);

				}else{

					$connections_id = $connections['id'];
	    			$this->session->set_flashdata('flashdata_info', "You have already paid for this listing's contact details, you have not been charged again.");

	    			$iploc = geoCheckIP($this->input->ip_address());
    				$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

					if($iploc['country'] == 'US - United States'){
						redirect('us/connections/'.$connections_id);
					}else{
						redirect('connections/'.$connections_id);
					} 

				}
  				
  			}

		}

		public function connection_credits($listing_id){

			if(!$this->session->userdata('userlogged_in')){
				$this->session->set_flashdata('flashdata_failed', 'You need log in to access this area');
				
	    		$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

				if($iploc['country'] == 'US - United States'){
					redirect(''.base_url('us').'');
				}else{
					redirect(''.base_url().'');
				} 
	    	}

	    	$users_id = $this->session->userdata('user_id_byd');

	    	$userinfo = $this->users_model->get_users($users_id);

	    	$connections = $this->connection_model->check_connections($users_id,$listing_id);


	    	$listing = $this->getdata_model->get_listing($listing_id);

	    	$owner = $this->users_model->get_users($listing['user_id']);

			if(empty($connections)){

		    	$credit_output = $userinfo['credits'] - 1;

		    	$connections_id = $this->connection_model->connection_paid_credits($listing_id,$users_id);
		    	$this->connection_model->connection_minus_credits($users_id,$credit_output);

		    	$this->session->set_flashdata('flashdata_info', "You can now contact the listing's owner through the contact details below.");

		    	$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';

				$this->email->initialize($config);

				/*$this->email->from('no-reply@breedyourdog.com');*/
				$this->email->to($owner['email']);
				/*$this->email->cc('rj@page1europe.eu');*/
				$this->email->bcc('byd@breedyourdog.com');

				$this->email->subject('Breed Your Dog enquiry');

				$email_style = '<link href="'.base_url() .'assets/css/style-admin.min.css" rel="stylesheet" type="text/css">';

				if($listing['listing_type'] == 'dog'){
                  $listing_type = 'Stud Dog / Bitch';
                }elseif($listing['listing_type'] == 'pup'){
                  $listing_type = 'Puppies';
                }elseif($listing['listing_type'] == 'mem'){
                  $listing_type = 'Memorials';
                }

				$this->email->message('
					<!DOCTYPE html>
						<html>
						<head>
							<title>Welcome to Breed Your Dog</title>
							'.$email_style.'
							<style>
								body{
									font-family: "Montserrat Light";
									font-size: 14px;
								}
							</style>
						</head>
						<body>
							<p>Dear '.$owner['first_name'].',</p>
							<p>Great news! You have a connection!</p>
							<p>This means that a user has purchased a credit and used it to obtain the contact details for your '.$listing_type.' "'.$listing['title'].'" . </p>
							<p>This is how our site works and why BreedYourDog.com is as popular as it is today being the biggest and fastest-growing stud dog website with people making genuine enquiries about your dog. </p>
							<p>Please always check that you keep your contact details and your information up to date and inputted correctly so people don’t end up wasting time and money on incorrect or unobtainable connections. </p>
							<p>We hope you are contacted and that the result will be successful for both you and your dog!</p>
							<p>
								<i>
									Kind Regards<br>
									The Breed Your Dog Team 
								</i>
							</p>
							
						</body>
						</html>
					');

				$this->email->send();

		    }else{

				$connections_id = $connections['id'];
    			$this->session->set_flashdata('flashdata_info', "You have already paid for this listing's contact details, you have not been charged again.");

			}

			$iploc = geoCheckIP($this->input->ip_address());
    		$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

			if($iploc['country'] == 'US - United States'){
				redirect('us/connections/'.$connections_id);
			}else{
				redirect('connections/'.$connections_id);
			} 

		}

		public function connection_info($connections_id){
			if(!$this->session->userdata('userlogged_in')){
				$this->session->set_flashdata('flashdata_failed', 'You need log in to access this area');

				$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

				if($iploc['country'] == 'US - United States'){
					redirect(''.base_url('us').'');
				}else{
					redirect(''.base_url().'');
				} 
	    		
	    	}

	    	$users_id = $this->session->userdata('user_id_byd');
	    	$connections_id;
	    	

	    	$connect_listing = $this->connection_model->get_connections($connections_id);

	    	$listing_id = $connect_listing['listing_id'];

	    	$connections = $this->connection_model->check_connections($users_id,$listing_id);

	    	if(empty($connections)){
	    		show_404();
	    	}

	    	$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$data['listing'] = $this->getdata_model->get_listing_connections($listing_id);

	    	$this->load->view('templates/header',$data);
			$this->load->view('pages/listing-connection-info',$data);
			$this->load->view('templates/footer',$data);

		}

	}
