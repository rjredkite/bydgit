<?php 
	class Users extends CI_Controller{

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

		/*=====================================================
		[-- USERS DASHBOARD ----------------------------------]
	    ======================================================*/
		public function user_dashboard(){
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

			$id = $this->session->userdata('user_id_byd');
  			$data['userinformations'] = $this->users_model->user_info($id);

			$this->load->view('templates/header',$data);
			$this->load->view('users/pages/dashboard',$data);
			$this->load->view('templates/footer',$data);

		}

		/*=====================================================
		[-- USERS EDIT ---------------------------------------]
	    ======================================================*/
		public function user_edit(){
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

			$id = $this->session->userdata('user_id_byd');
  			$data['userinformations'] = $this->users_model->user_info($id);	

  			foreach( $data['userinformations'] as $userinfo){
  				if($this->input->post('user_email') != $userinfo['email']) {
				   $is_unique_email =  '|is_unique[users.email]';
				} else {
				   $is_unique_email =  '';
				}
  			}
  			
	    	$this->form_validation->set_rules('user_email', 'Email', 'required'.$is_unique_email.'|valid_email',
	    		array('is_unique' => 'email has already been taken')
	    	);
	    	$this->form_validation->set_rules('user_password', 'Password', 'trim');
	    	$this->form_validation->set_rules('user_confirmpassword', 'Confirm Password', 'trim|matches[user_password]');
	    	$this->form_validation->set_rules('user_firstname', 'First Name', 'required');
	    	$this->form_validation->set_rules('user_lastname', 'Last Name', 'required');
	    	$this->form_validation->set_rules('user_phone', 'Phone', 'required');
	    	$this->form_validation->set_rules('user_address', 'Address', 'required');
	    	$this->form_validation->set_rules('user_post_code', 'Post Code', 'required');
	    	$this->form_validation->set_rules('user_country', 'Country', 'required');
	    	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

	    	if($this->form_validation->run() === FALSE){

				$this->load->view('templates/header',$data);
				$this->load->view('users/pages/edit',$data);
				$this->load->view('templates/footer',$data);

	    	}else{

	    		foreach( $data['userinformations'] as $userinfo){
	  				
	    			if($userinfo['plan_id'] != 1 && $userinfo['plan_id'] != 7 ){
	    				$this->users_model->user_update_middle($id);
	    			}elseif($userinfo['plan_id'] == 7){
	    				$this->users_model->user_update_ultimate($id);
	    			}else{
	    				$this->users_model->user_update_basic($id);
	    			}

					if($this->input->post('user_password') != ''){
						$hash_password = hash('sha512', $this->input->post('user_password'));
						$this->users_model->user_password_update($hash_password,$id);
					}
				}

				$this->session->set_flashdata('flashdata_success', 'Your details have been updated');

				$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
				if($iploc['country'] == 'US - United States'){
					redirect('us/user/dashboard');
				}else{
					redirect('user/dashboard');
				}
				

	    	}
			
		}

		/*=====================================================
		[-- NEW PAYMENT --------------------------------------]
	    ======================================================*/
		public function new_payment(){
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

			$id = $this->session->userdata('user_id_byd');
  			$data['userinformations'] = $this->users_model->user_info($id);

			$this->load->view('templates/header',$data);
			$this->load->view('users/pages/payment-new',$data);
			$this->load->view('templates/footer',$data);
		}


		/*=====================================================
		[-- USERS LISTING NEW DOG ----------------------------]
	    ======================================================*/
		public function listings_new_dog(){
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


			$id = $this->session->userdata('user_id_byd');
  			$data['userinformations'] = $this->users_model->user_info($id);

  			foreach( $data['userinformations'] as $userinfo){

  				$users_id	=	$userinfo['id'];
  				$plan_id 	= 	$userinfo['plan_id'];

  				$plans = $this->getdata_model->get_plans_id($plan_id);

  				$userlisting_number = $this->getdata_model->get_published_listings_number($users_id);

  				if($plans['active_listings'] <= $userlisting_number){
  					$this->session->set_flashdata('flashdata_danger', 'You can not create any new listings as '.$plans['name'].'  account you can have a maximum of '.$plans['active_listings'].' active listings. To add more listings you need to upgrade to a paid account or unpublish some of your other listings.');
	    			$iploc = geoCheckIP($this->input->ip_address());
    				$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
					if($iploc['country'] == 'US - United States'){
						redirect('us/user/dashboard');
					}else{
						redirect('user/dashboard');
					}
	    			
  				}

  			}

			$this->form_validation->set_rules('listing_title', 'Listing Title', 'required');
			$this->form_validation->set_rules('dogname', 'Dogname', 'required');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('breed', 'Breed', 'required');
			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('listing_description', 'Listing Description', 'required|callback_listing_description_validate');
			$this->form_validation->set_rules('country', 'Country', 'required');
			$this->form_validation->set_rules('region', 'Region', 'required');
			$this->form_validation->set_rules('post_code', 'Post Code', 'required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header',$data);
				$this->load->view('users/pages/listings-new-dog',$data);
				$this->load->view('templates/footer',$data);
			}else{

				/*=====================================================
				[-- LISTINGS DOG ADD INPUTS DATA IN DATABASE ---------]
			    ======================================================*/
				$listing_id = $this->users_model->listingdog();

				/*=====================================================
				[-- LISTINGS DOG ADD IMAGES ---------]
			    ======================================================*/
	    		$files = $_FILES;

	    		$this->load->library('image_lib');

	    		foreach($files as $key => $value)
		        {   
		            $img_num = 1;
		            for($s = 0; $s < count($value['size']); $s++)
		            {

		            	if(!empty($value['name'][$s])){

			                $_FILES['file[]']['name']     = $value['name'][$s];
			                $_FILES['file[]']['type']     = $value['type'][$s];
			                $_FILES['file[]']['tmp_name'] = $value['tmp_name'][$s];
			                $_FILES['file[]']['error']    = $value['error'][$s];
			                $_FILES['file[]']['size']     = $value['size'][$s]; 

			                $string_image = $_FILES['file[]']['name'];
							$new_string_image = pathinfo($string_image, PATHINFO_FILENAME) . '.' . strtolower(pathinfo($string_image, PATHINFO_EXTENSION));

			                $listing_image = strtr($new_string_image,' ','_');

			               	$listing_images_id =  $this->users_model->listing_images($listing_id,$listing_image,$img_num);

			             	$img_num++;
			                
			                $path = "./uploads/listing_images/".$listing_id."/".$listing_images_id;
				    		if (!is_dir($path)){
					    		mkdir($path,0755,TRUE);
					    	}

				    		$config['upload_path'] = './uploads/listing_images/'.$listing_id.'/'.$listing_images_id;
			                $config['allowed_types'] = 'gif|jpg|png|jpeg';
							$config['max_size'] = '99999999';
							$config['max_width'] = '2000000';
							$config['max_height'] = '2000000';
							$config['overwrite'] = TRUE;
	            			$config['remove_spaces'] = TRUE;
	            			$config['file_ext_tolower'] = TRUE;

							$this->load->library('upload', $config);


							$this->upload->initialize($config);

							$this->upload->do_upload('file[]');

							/*$data = $this->upload->data();

							echo '<pre>';
							print_r($data);
							echo '</pre>';*/


							$config = array(
				            'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image,
				            'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/thumb_'.$listing_image,
				            'maintain_ration'   => true,
				            'overwrite'         => true,
				            'quality'			=> '40%',
				            'width'             => 400,
				            'height'            => 300
				            );

				            $this->image_lib->initialize($config);
				            $this->image_lib->resize();
				            $this->image_lib->clear();

				            $config = array(
						        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image,
						        'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/thumb_small_'.$listing_image,
						        'maintain_ration'   => true,
						        'overwrite'         => true,
						        'quality'			=> '100%',
						        'width'             => 300,
						        'height'            => 300
						    );

					        $this->image_lib->initialize($config);
					        $this->image_lib->resize();
					        $this->image_lib->clear();

					        $config['image_library'] = 'GD2';
							$config['source_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image;
							$config['new_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/big_'.$listing_image;
							$config['wm_type'] = 'overlay';
							$config['wm_overlay_path'] = 'assets/img/watermark_logo.png';
							$config['wm_opacity'] = '100';
							$config['quality'] = '60%';
							$config['wm_vrt_alignment'] = 'bottom'; 
							$config['wm_hor_alignment'] = 'left';
							$config['wm_hor_offset'] = '10';
							$config['wm_vrt_offset'] = '10';

							$this->image_lib->initialize($config);
							$this->image_lib->watermark();
							$this->image_lib->clear();

						}

		            }
		        }
		       
		        /*=====================================================
				[-- LISTINGS DOG FEATURED OR HIGHLIGHTED -------------]
			    ======================================================*/
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

    			$highlighted_listing = $this->input->post('highlighted_listing');
    			$featured_listing = $this->input->post('featured_listing');

    			if($userinfo['featured_credits'] != 0){

					if($country_lang == 'us'){

						if($featured_listing != 0 && $highlighted_listing == 0){ 

						  if($featured_listing <= $userinfo['featured_credits']){

						    if($highlighted_listing != 0){
						      $fl_sign = '$';
						      $fl_val = 1.50 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						    }else{
						      $listing_price = 'Free';
						    }

						  }else{

						    $fl_sign = '$';
						    $fl_val = 2.25 * $featured_listing;
						    $listing_price = $fl_sign.round($fl_val,2);
						    $price_payment = round($fl_val,2);

						  }

						}else if($featured_listing == 0 && $highlighted_listing != 0){

						  if($featured_listing == 0 && $highlighted_listing == 0){

						    $listing_price = 'Free';
						  
						  }else if($featured_listing == 0 && $highlighted_listing != 0){

						    if($featured_listing == 0 && $highlighted_listing == 0){
						      $listing_price = 'Free';
						    }else if($featured_listing != 0 && $highlighted_listing != 0){
						      $fl_sign = '$';
						      $fl_val = 1.50 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);

						    }else if($highlighted_listing != ''){
						      $fl_sign = '$';
						      $fl_val = 1.50 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						      
						    }else{
						      $listing_price = 'Free';
						    } 

						  }else{

						    $listing_price = 'Free';

						  }
						  
						}else if($featured_listing != 0 && $highlighted_listing != 0){

							if($featured_listing <= $userinfo['featured_credits']){

							    if($highlighted_listing != ''){
							      $fl_sign = '$';
							      $fl_val = 1.50 * $highlighted_listing;
							      $listing_price = $fl_sign.round($fl_val,2);
							      $price_payment = round($fl_val,2); 
							    }else{
							      $listing_price = 'Free';
							    }
							    
							}else{

								switch ([$highlighted_listing,$featured_listing]) {
									case ["1","1"]:
						            	$listing_price = $fl_sign.'3.40';
						            	$price_payment = '3.40';
						            break;
									case ["1","2"]:
										$listing_price = $fl_sign.'5.65';
										$price_payment = '5.65';
									break;
									case ["1","3"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["1","4"]:
										$listing_price = $fl_sign.'10.15';
										$price_payment = '10.15';
									break;
									case ["1","5"]:
										$listing_price = $fl_sign.'12.40';
										$price_payment = '12.40';
									break;
									case ["2","1"]:
										$listing_price = $fl_sign.'4.90';
										$price_payment = '4.90';
									break;
									case ["2","2"]:
										$listing_price = $fl_sign.'6.80';
										$price_payment = '6.80';
									break;
									case ["2","3"]:
										$listing_price = $fl_sign.'9.05';
										$price_payment = '9.05';
									break;
									case ["2","4"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["2","5"]:
										$listing_price = $fl_sign.'13.55';
										$price_payment = '13.55';
									break;
									case ["3","1"]:
										$listing_price = $fl_sign.'6.40';
										$price_payment = '6.40';
									break;
									case ["3","2"]:
										$listing_price = $fl_sign.'8.30';
										$price_payment = '8.30';
									break;
									case ["3","3"]:
										$listing_price = $fl_sign.'10.20';
										$price_payment = '10.20';
									break;
									case ["3","4"]:
										$listing_price = $fl_sign.'12.45';
										$price_payment = '12.45';
									break;
									case ["3","5"]:
										$listing_price = $fl_sign.'14.70';
										$price_payment = '14.70';
									break;
									case ["4","1"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["4","2"]:
										$listing_price = $fl_sign.'9.80';
										$price_payment = '9.80';
									break;
									case ["4","3"]:
										$listing_price = $fl_sign.'11.70';
										$price_payment = '11.70';
									break;
									case ["4","4"]:
										$listing_price = $fl_sign.'13.60';
										$price_payment = '13.60';
									break;
									case ["4","5"]:
										$listing_price = $fl_sign.'15.85';
										$price_payment = '15.85';
									break;
									case ["5","1"]:
										$listing_price = $fl_sign.'9.40';
										$price_payment = '9.40';
									break;
									case ["5","2"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["5","3"]:
										$listing_price = $fl_sign.'13.20';
										$price_payment = '13.20';
									break;
									case ["5","4"]:
										$listing_price = $fl_sign.'15.10';
										$price_payment = '15.10';
									break;
									case ["5","5"]:
										$listing_price = $fl_sign.'17.00';
										$price_payment = '17.00';
									break;
									default:
										$fl_val = 2.25 * $featured_listing;
										$listing_price = $fl_sign.round($fl_val,2);
										$price_payment = round($fl_val,2);
								}

							}

						}else{
						  $listing_price = 'Free';
						} 


					}else{

						if($featured_listing != 0 && $highlighted_listing == 0){ 

						  if($featured_listing <= $userinfo['featured_credits']){

						    if($highlighted_listing != 0){
						      $fl_sign = '£';
						      $fl_val = 1.00 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						    }else{
						      $listing_price = 'Free';
						    }

						  }else{

						    $fl_sign = '£';
						    $fl_val = 1.50 * $featured_listing;
						    $listing_price = $fl_sign.round($fl_val,2);
						    $price_payment = round($fl_val,2);

						  }

						}else if($featured_listing == 0 && $highlighted_listing != 0){

						  if($featured_listing == 0 && $highlighted_listing == 0){

						    $listing_price = 'Free';
						  
						  }else if($featured_listing == 0 && $highlighted_listing != 0){

						    if($featured_listing == 0 && $highlighted_listing == 0){
						      $listing_price = 'Free';
						    }else if($featured_listing != 0 && $highlighted_listing != 0){
						      $fl_sign = '£';
						      $fl_val = 1.00 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);

						    }else if($highlighted_listing != ''){
						      $fl_sign = '£';
						      $fl_val = 1.00 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						    }else{
						      $listing_price = 'Free';
						    } 

						  }else{

						    $listing_price = 'Free';

						  }
						  
						}else if($featured_listing != 0 && $highlighted_listing != 0){

							if($featured_listing <= $userinfo['featured_credits']){

							    if($highlighted_listing != ''){
							      $fl_sign = '£';
							      $fl_val = 1.00 * $highlighted_listing;
							      $listing_price = $fl_sign.round($fl_val,2);
							      $price_payment = round($fl_val,2);
							    }else{
							      $listing_price = 'Free';
							    }
							    
							}else{

								switch ([$highlighted_listing,$featured_listing]) {
								case ["1","1"]:
								  $listing_price = $fl_sign.'2.25';
								  $price_payment = '2.25';
								  break;
								case ["1","2"]:
								  $listing_price = $fl_sign.'3.75';
								  $price_payment = '3.75';
								  break;
								case ["1","3"]:
								  $listing_price = $fl_sign.'5.25';
								  $price_payment = '5.25';
								  break;
								case ["1","4"]:
								  $listing_price = $fl_sign.'6.75';
								  $price_payment = '6.75';
								  break;
								case ["1","5"]:
								  $listing_price = $fl_sign.'8.25';
								  $price_payment = '8.25';
								  break;
								case ["2","1"]:
								  $listing_price = $fl_sign.'3.25';
								  $price_payment = '3.25';
								  break;
								case ["2","2"]:
								  $listing_price = $fl_sign.'4.50';
								  $price_payment = '4.50';
								  break;
								case ["2","3"]:
								  $listing_price = $fl_sign.'6.00';
								  $price_payment = '6.00';
								  break;
								case ["2","4"]:
								  $listing_price = $fl_sign.'7.50';
								  $price_payment = '7.50';
								  break;
								case ["2","5"]:
								  $listing_price = $fl_sign.'9.00';
								  $price_payment = '9.00';
								  break;
								case ["3","1"]:
								  $listing_price = $fl_sign.'4.25';
								  $price_payment = '4.25';
								  break;
								case ["3","2"]:
								  $listing_price = $fl_sign.'5.50';
								  $price_payment = '5.50';
								  break;
								case ["3","3"]:
								  $listing_price = $fl_sign.'6.75';
								  $price_payment = '6.75';
								  break;
								case ["3","4"]:
								  $listing_price = $fl_sign.'8.25';
								  $price_payment = '8.25';
								  break;
								case ["3","5"]:
								  $listing_price = $fl_sign.'9.75';
								  $price_payment = '9.75';
								  break;
								case ["4","1"]:
								  $listing_price = $fl_sign.'5.25';
								  $price_payment = '5.25';
								  break;
								case ["4","2"]:
								  $listing_price = $fl_sign.'6.50';
								  $price_payment = '6.50';
								  break;
								case ["4","3"]:
								  $listing_price = $fl_sign.'7.75';
								  $price_payment = '7.75';
								  break;
								case ["4","4"]:
								  $listing_price = $fl_sign.'9.00';
								  $price_payment = '9.00';
								  break;
								case ["4","5"]:
								  $listing_price = $fl_sign.'10.50';
								  $price_payment = '10.50';
								  break;
								case ["5","1"]:
								  $listing_price = $fl_sign.'6.25';
								  $price_payment = '6.25';
								  break;
								case ["5","2"]:
								  $listing_price = $fl_sign.'7.50';
								  $price_payment = '7.50';
								  break;
								case ["5","3"]:
								  $listing_price = $fl_sign.'8.75';
								  $price_payment = '8.75';
								  break;
								case ["5","4"]:
								  $listing_price = $fl_sign.'10.00';
								  $price_payment = '10.00';
								  break;
								case ["5","5"]:
								  $listing_price = $fl_sign.'11.25';
								  $price_payment = '11.25';
								  break;
								  default:
								    $fl_sign = '£';
								    $fl_val = 1.50 * $featured_listing;
								    $listing_price = $fl_sign.round($fl_val,2);
								    $price_payment = round($fl_val,2);
								}

							}

						}else{
						  $listing_price = 'Free';
						} 

					}
    			
	    		}else{

	    			if($country_lang == 'us'){
	    				$fl_sign = '$';

						if($highlighted_listing != 0){

							if($featured_listing != 0){
								/* Highlights != 0 && != '' and Featured is != 0 && != '' */
								switch ([$highlighted_listing,$featured_listing]) {
									case ["1","1"]:
						            	$listing_price = $fl_sign.'3.40';
						            	$price_payment = '3.40';
						            break;
									case ["1","2"]:
										$listing_price = $fl_sign.'5.65';
										$price_payment = '5.65';
									break;
									case ["1","3"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["1","4"]:
										$listing_price = $fl_sign.'10.15';
										$price_payment = '10.15';
									break;
									case ["1","5"]:
										$listing_price = $fl_sign.'12.40';
										$price_payment = '12.40';
									break;
									case ["2","1"]:
										$listing_price = $fl_sign.'4.90';
										$price_payment = '4.90';
									break;
									case ["2","2"]:
										$listing_price = $fl_sign.'6.80';
										$price_payment = '6.80';
									break;
									case ["2","3"]:
										$listing_price = $fl_sign.'9.05';
										$price_payment = '9.05';
									break;
									case ["2","4"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["2","5"]:
										$listing_price = $fl_sign.'13.55';
										$price_payment = '13.55';
									break;
									case ["3","1"]:
										$listing_price = $fl_sign.'6.40';
										$price_payment = '6.40';
									break;
									case ["3","2"]:
										$listing_price = $fl_sign.'8.30';
										$price_payment = '8.30';
									break;
									case ["3","3"]:
										$listing_price = $fl_sign.'10.20';
										$price_payment = '10.20';
									break;
									case ["3","4"]:
										$listing_price = $fl_sign.'12.45';
										$price_payment = '12.45';
									break;
									case ["3","5"]:
										$listing_price = $fl_sign.'14.70';
										$price_payment = '14.70';
									break;
									case ["4","1"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["4","2"]:
										$listing_price = $fl_sign.'9.80';
										$price_payment = '9.80';
									break;
									case ["4","3"]:
										$listing_price = $fl_sign.'11.70';
										$price_payment = '11.70';
									break;
									case ["4","4"]:
										$listing_price = $fl_sign.'13.60';
										$price_payment = '13.60';
									break;
									case ["4","5"]:
										$listing_price = $fl_sign.'15.85';
										$price_payment = '15.85';
									break;
									case ["5","1"]:
										$listing_price = $fl_sign.'9.40';
										$price_payment = '9.40';
									break;
									case ["5","2"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["5","3"]:
										$listing_price = $fl_sign.'13.20';
										$price_payment = '13.20';
									break;
									case ["5","4"]:
										$listing_price = $fl_sign.'15.10';
										$price_payment = '15.10';
									break;
									case ["5","5"]:
										$listing_price = $fl_sign.'17.00';
										$price_payment = '17.00';
									break;
									default:
										$fl_val = 2.25 * $featured_listing;
										$listing_price = $fl_sign.round($fl_val,2);
										$price_payment = round($fl_val,2);
								}

							}else{

								if($highlighted_listing != ''){
									$fl_val = 1.50 * $highlighted_listing;
									$listing_price = $fl_sign.round($fl_val,2);
									$price_payment = round($fl_val,2);
									/* Highlights != 0 && != '' and Featured is == 0 && == '' */
								}else{
									$listing_price = 'Free';
								}
							}
						}else if($featured_listing != 0){
							$fl_val = 2.25 * $featured_listing;
							$listing_price = $fl_sign.round($fl_val,2);
							$price_payment = round($fl_val,2);
							/* Highlights == 0 && == '' and Featured is != 0 && != '' */
						}else{
							$listing_price = 'Free';
						}

					}else{

						$fl_sign = '£';

						if($highlighted_listing != 0){

							if($featured_listing != 0){
								/* Highlights != 0 && != '' and Featured is != 0 && != '' */
								switch ([$highlighted_listing,$featured_listing]) {
									case ["1","1"]:
										$listing_price = $fl_sign.'2.25';
										$price_payment = '2.25';
									break;
									case ["1","2"]:
										$listing_price = $fl_sign.'3.75';
										$price_payment = '3.75';
									break;
									case ["1","3"]:
										$listing_price = $fl_sign.'5.25';
										$price_payment = '5.25';
									break;
									case ["1","4"]:
										$listing_price = $fl_sign.'6.75';
										$price_payment = '6.75';
									break;
									case ["1","5"]:
										$listing_price = $fl_sign.'8.25';
										$price_payment = '8.25';
									break;
									case ["2","1"]:
										$listing_price = $fl_sign.'3.25';
										$price_payment = '3.25';
									break;
									case ["2","2"]:
										$listing_price = $fl_sign.'4.50';
										$price_payment = '4.50';
									break;
									case ["2","3"]:
										$listing_price = $fl_sign.'6.00';
										$price_payment = '6.00';
									break;
									case ["2","4"]:
										$listing_price = $fl_sign.'7.50';
										$price_payment = '7.50';
									break;
									case ["2","5"]:
										$listing_price = $fl_sign.'9.00';
										$price_payment = '9.00';
									break;
									case ["3","1"]:
										$listing_price = $fl_sign.'4.25';
										$price_payment = '4.25';
									break;
									case ["3","2"]:
										$listing_price = $fl_sign.'5.50';
										$price_payment = '5.50';
									break;
									case ["3","3"]:
										$listing_price = $fl_sign.'6.75';
										$price_payment = '6.75';
									break;
									case ["3","4"]:
										$listing_price = $fl_sign.'8.25';
										$price_payment = '8.25';
									break;
									case ["3","5"]:
										$listing_price = $fl_sign.'9.75';
										$price_payment = '9.75';
									break;
									case ["4","1"]:
										$listing_price = $fl_sign.'5.25';
										$price_payment = '5.25';
									break;
									case ["4","2"]:
										$listing_price = $fl_sign.'6.50';
										$price_payment = '6.50';
									break;
									case ["4","3"]:
										$listing_price = $fl_sign.'7.75';
										$price_payment = '7.75';
									break;
									case ["4","4"]:
										$listing_price = $fl_sign.'9.00';
										$price_payment = '9.00';
									break;
									case ["4","5"]:
										$listing_price = $fl_sign.'10.50';
										$price_payment = '10.50';
									break;
									case ["5","1"]:
										$listing_price = $fl_sign.'6.25';
										$price_payment = '6.25';
									break;
									case ["5","2"]:
										$listing_price = $fl_sign.'7.50';
										$price_payment = '7.50';
									break;
									case ["5","3"]:
										$listing_price = $fl_sign.'8.75';
										$price_payment = '8.75';
									break;
									case ["5","4"]:
										$listing_price = $fl_sign.'10.00';
										$price_payment = '10.00';
									break;
									case ["5","5"]:
										$listing_price = $fl_sign.'11.25';
										$price_payment = '11.25';
									break;
									default:
										$fl_val = 1.50 * $featured_listing;
										$listing_price = $fl_sign.round($fl_val,2);
										$price_payment = round($fl_val,2);
								}

							}else{

								if($highlighted_listing != ''){
									$fl_val = 1.00 * $highlighted_listing;
									$listing_price = $fl_sign.round($fl_val,2);
									$price_payment = round($fl_val,2);
									/* Highlights != 0 && != '' and Featured is == 0 && == '' */
								}else{
									$listing_price = 'Free';
								}
							}
						}else if($featured_listing != 0){
							$fl_val = 1.50 * $featured_listing;
							$listing_price = $fl_sign.round($fl_val,2);
							$price_payment = round($fl_val,2);
							/* Highlights == 0 && == '' and Featured is != 0 && != '' */
						}else{
							$listing_price = 'Free';
						}

		    		}

	    		}

	    		if($listing_price != 'Free'){

	    			if($fl_sign == '£'){
	    				$currency = 'GBP';
	    			}else{
	    				$currency = 'USD';
	    			}

	    			if($highlighted_listing != 0 && $featured_listing == 0){
	    				if($highlighted_listing == 1){
	    					$description = 'Highlighted for '.$highlighted_listing.' weeks - '.$listing_price;
    					}else{
    						$description = 'Highlighted for '.$highlighted_listing.' week - '.$listing_price;
    					}
	                }elseif($highlighted_listing == 0 && $featured_listing != 0){
	                	if($highlighted_listing == 1){
	    					$description = 'Featured for '.$featured_listing.' weeks - '.$listing_price;
    					}else{
    						$description = 'Featured for '.$featured_listing.' week - '.$listing_price;
    					}
	                }else{
	                	if($highlighted_listing == 1 && $highlighted_listing == 1){
	                		$description = 'Featured for '.$featured_listing.' week, Highlighted for '.$highlighted_listing.' week - '.$listing_price;
	                	}elseif($highlighted_listing == 1 && $highlighted_listing != 1){
	                		$description = 'Featured for '.$featured_listing.' week, Highlighted for '.$highlighted_listing.' weeks - '.$listing_price;
	                	}elseif($highlighted_listing != 1 && $highlighted_listing == 1){
	                		$description = 'Featured for '.$featured_listing.' weeks, Highlighted for '.$highlighted_listing.' week - '.$listing_price;
	                	}else{
	                		$description = 'Featured for '.$featured_listing.' weeks, Highlighted for '.$highlighted_listing.' weeks - '.$listing_price;
	                	}
	                }

					$product = array(
						'Listing' => array('name' => 'Listing', 'desc' => $description, 'price' => $price_payment));
					//$currency = $paypal_currency; // currency for the transaction
					$ec_action = 'Sale'; // for PAYMENTREQUEST_0_PAYMENTACTION, it's either Sale, Order or Authorization


					$payment_id = $this->payment_model->listing_payment($id,$price_payment,$currency,$fl_sign,$description,$listing_id);

					$payment_session_id = array(
						'payment_session_id' => $payment_id,
						'payment_listing_id' => $listing_id,
						'listing_highlights_value' => $highlighted_listing,
						'listing_featured_value' => $featured_listing
					);
					$this->session->set_userdata($payment_session_id);

					$to_buy = array(
						'desc' => 'Breed Your Dog', 
						'currency' => $currency, 
						'type' => $ec_action, 
						'return_URL' => site_url('users/completed'), 
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
						
	    		}

	    		if($listing_price == 'Free'){

	    			if($highlighted_listing != 0 || $featured_listing != 0 ){
	    				$this->payment_model->listing_highlight_featured($listing_id,$highlighted_listing,$featured_listing);
	    			}else{
	    				$this->payment_model->listing_highlight_featured_audits($listing_id);
	    			}

		    	}

				$this->session->set_flashdata('flashdata_success', 'Listing Created');

				if($iploc['country'] == 'US - United States'){
					redirect('us/listings/yours');
				}else{
					redirect('listings/yours');
				}
				

			}
		}

		/*=====================================================
		[-- USERS LISTINGS NEW LITTER ------------------------]
	    ======================================================*/
		public function listings_new_litter(){
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

			$id = $this->session->userdata('user_id_byd');
  			$data['userinformations'] = $this->users_model->user_info($id);

			foreach( $data['userinformations'] as $userinfo){

  				$users_id	=	$userinfo['id'];
  				$plan_id 	= 	$userinfo['plan_id'];

  				$plans = $this->getdata_model->get_plans_id($plan_id);

  				$userlisting_number = $this->getdata_model->get_published_listings_number($users_id);

  				if($plans['active_listings'] <= $userlisting_number){
  					$this->session->set_flashdata('flashdata_danger', 'You can not create any new listings as '.$plans['name'].'  account you can have a maximum of '.$plans['active_listings'].' active listings. To add more listings you need to upgrade to a paid account or unpublish some of your other listings.');
	    			$iploc = geoCheckIP($this->input->ip_address());
    				$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
					if($iploc['country'] == 'US - United States'){
						redirect('us/user/dashboard');
					}else{
						redirect('user/dashboard');
					}
  				}

  			}



			$id = $this->session->userdata('user_id_byd');
  			$data['userinformations'] = $this->users_model->user_info($id);

			$this->form_validation->set_rules('listing_title', 'Listing Title', 'required');
			$this->form_validation->set_rules('breed', 'Breed', 'required');
			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('listing_description', 'Listing Description', 'required|callback_listing_description_validate');
			$this->form_validation->set_rules('country', 'Country', 'required');
			$this->form_validation->set_rules('region', 'Region', 'required');
			$this->form_validation->set_rules('post_code', 'Post Code', 'required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header',$data);
				$this->load->view('users/pages/listings-new-litter',$data);
				$this->load->view('templates/footer',$data);
			}else{

				/*=====================================================
				[-- LISTINGS PUPPIES ADD INPUTS DATA IN DATABASE -----]
			    ======================================================*/
				$listing_id = $this->users_model->listingpuppies();

				/*=====================================================
				[-- LISTINGS PUPPIES ADD IMAGES ----------------------]
			    ======================================================*/
	    		$files = $_FILES;

	    		$this->load->library('image_lib');

	    		foreach($files as $key => $value)
		        {   
		            $img_num = 1;
		            for($s = 0; $s < count($value['size']); $s++)
		            {

		            	if(!empty($value['name'][$s])){

			                $_FILES['file[]']['name']     = $value['name'][$s];
			                $_FILES['file[]']['type']     = $value['type'][$s];
			                $_FILES['file[]']['tmp_name'] = $value['tmp_name'][$s];
			                $_FILES['file[]']['error']    = $value['error'][$s];
			                $_FILES['file[]']['size']     = $value['size'][$s]; 

			                $string_image = $_FILES['file[]']['name'];
							$new_string_image = pathinfo($string_image, PATHINFO_FILENAME) . '.' . strtolower(pathinfo($string_image, PATHINFO_EXTENSION));

			                $listing_image = strtr($new_string_image,' ','_');

			               	$listing_images_id =  $this->users_model->listing_images($listing_id,$listing_image,$img_num);

			             	$img_num++;
			                
			                $path = "./uploads/listing_images/".$listing_id."/".$listing_images_id;
				    		mkdir($path,0755,TRUE);

				    		$config['upload_path'] = './uploads/listing_images/'.$listing_id.'/'.$listing_images_id;
			                $config['allowed_types'] = 'gif|jpg|png|jpeg';
							$config['max_size'] = '99999999';
							$config['max_width'] = '2000000';
							$config['max_height'] = '2000000';
							$config['overwrite'] = TRUE;
	            			$config['remove_spaces'] = TRUE;
	            			$config['file_ext_tolower'] = TRUE;

							$this->load->library('upload', $config);


							$this->upload->initialize($config);

							$this->upload->do_upload('file[]');
							/*$data = $this->upload->data();

							echo '<pre>';
							print_r($data);
							echo '</pre>';*/

							$config = array(
				            'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image,
				            'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/thumb_'.$listing_image,
				            'maintain_ration'   => true,
				            'overwrite'         => true, 
				            'quality'			=> '40%',
				            'width'             => 400,
				            'height'            => 300
				            );

				            $this->image_lib->initialize($config);
				            $this->image_lib->resize();
				            $this->image_lib->clear();

				            $config = array(
						        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image,
						        'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/thumb_small_'.$listing_image,
						        'maintain_ration'   => true,
						        'overwrite'         => true,
						        'quality'			=> '100%',
						        'width'             => 300,
						        'height'            => 300
						    );

					        $this->image_lib->initialize($config);
					        $this->image_lib->resize();
					        $this->image_lib->clear();

					        $config['image_library'] = 'GD2';
							$config['source_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image;
							$config['new_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/big_'.$listing_image;
							$config['wm_type'] = 'overlay';
							$config['wm_overlay_path'] = 'assets/img/watermark_logo.png';
							$config['wm_opacity'] = '100';
							$config['quality'] = '60%';
							$config['wm_vrt_alignment'] = 'bottom'; 
							$config['wm_hor_alignment'] = 'left';
							$config['wm_hor_offset'] = '10';
							$config['wm_vrt_offset'] = '10';

							$this->image_lib->initialize($config);
							$this->image_lib->watermark();
							$this->image_lib->clear();

						}

		            }
		        }

		        /*=====================================================
				[-- LISTINGS DOG FEATURED OR HIGHLIGHTED -------------]
			    ======================================================*/
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

    			$highlighted_listing = $this->input->post('highlighted_listing');
    			$featured_listing = $this->input->post('featured_listing');

    			if($userinfo['featured_credits'] != 0){

					if($country_lang == 'us'){

						if($featured_listing != 0 && $highlighted_listing == 0){ 

						  if($featured_listing <= $userinfo['featured_credits']){

						    if($highlighted_listing != 0){
						      $fl_sign = '$';
						      $fl_val = 1.50 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						    }else{
						      $listing_price = 'Free';
						    }

						  }else{

						    $fl_sign = '$';
						    $fl_val = 2.25 * $featured_listing;
						    $listing_price = $fl_sign.round($fl_val,2);
						    $price_payment = round($fl_val,2);

						  }

						}else if($featured_listing == 0 && $highlighted_listing != 0){

						  if($featured_listing == 0 && $highlighted_listing == 0){

						    $listing_price = 'Free';
						  
						  }else if($featured_listing == 0 && $highlighted_listing != 0){

						    if($featured_listing == 0 && $highlighted_listing == 0){
						      $listing_price = 'Free';
						    }else if($featured_listing != 0 && $highlighted_listing != 0){
						      $fl_sign = '$';
						      $fl_val = 1.50 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);

						    }else if($highlighted_listing != ''){
						      $fl_sign = '$';
						      $fl_val = 1.50 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						      
						    }else{
						      $listing_price = 'Free';
						    } 

						  }else{

						    $listing_price = 'Free';

						  }
						  
						}else if($featured_listing != 0 && $highlighted_listing != 0){

							if($featured_listing <= $userinfo['featured_credits']){

							    if($highlighted_listing != ''){
							      $fl_sign = '$';
							      $fl_val = 1.50 * $highlighted_listing;
							      $listing_price = $fl_sign.round($fl_val,2);
							      $price_payment = round($fl_val,2); 
							    }else{
							      $listing_price = 'Free';
							    }
							    
							}else{

								switch ([$highlighted_listing,$featured_listing]) {
									case ["1","1"]:
						            	$listing_price = $fl_sign.'3.40';
						            	$price_payment = '3.40';
						            break;
									case ["1","2"]:
										$listing_price = $fl_sign.'5.65';
										$price_payment = '5.65';
									break;
									case ["1","3"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["1","4"]:
										$listing_price = $fl_sign.'10.15';
										$price_payment = '10.15';
									break;
									case ["1","5"]:
										$listing_price = $fl_sign.'12.40';
										$price_payment = '12.40';
									break;
									case ["2","1"]:
										$listing_price = $fl_sign.'4.90';
										$price_payment = '4.90';
									break;
									case ["2","2"]:
										$listing_price = $fl_sign.'6.80';
										$price_payment = '6.80';
									break;
									case ["2","3"]:
										$listing_price = $fl_sign.'9.05';
										$price_payment = '9.05';
									break;
									case ["2","4"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["2","5"]:
										$listing_price = $fl_sign.'13.55';
										$price_payment = '13.55';
									break;
									case ["3","1"]:
										$listing_price = $fl_sign.'6.40';
										$price_payment = '6.40';
									break;
									case ["3","2"]:
										$listing_price = $fl_sign.'8.30';
										$price_payment = '8.30';
									break;
									case ["3","3"]:
										$listing_price = $fl_sign.'10.20';
										$price_payment = '10.20';
									break;
									case ["3","4"]:
										$listing_price = $fl_sign.'12.45';
										$price_payment = '12.45';
									break;
									case ["3","5"]:
										$listing_price = $fl_sign.'14.70';
										$price_payment = '14.70';
									break;
									case ["4","1"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["4","2"]:
										$listing_price = $fl_sign.'9.80';
										$price_payment = '9.80';
									break;
									case ["4","3"]:
										$listing_price = $fl_sign.'11.70';
										$price_payment = '11.70';
									break;
									case ["4","4"]:
										$listing_price = $fl_sign.'13.60';
										$price_payment = '13.60';
									break;
									case ["4","5"]:
										$listing_price = $fl_sign.'15.85';
										$price_payment = '15.85';
									break;
									case ["5","1"]:
										$listing_price = $fl_sign.'9.40';
										$price_payment = '9.40';
									break;
									case ["5","2"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["5","3"]:
										$listing_price = $fl_sign.'13.20';
										$price_payment = '13.20';
									break;
									case ["5","4"]:
										$listing_price = $fl_sign.'15.10';
										$price_payment = '15.10';
									break;
									case ["5","5"]:
										$listing_price = $fl_sign.'17.00';
										$price_payment = '17.00';
									break;
									default:
										$fl_val = 2.25 * $featured_listing;
										$listing_price = $fl_sign.round($fl_val,2);
										$price_payment = round($fl_val,2);
								}

							}

						}else{
						  $listing_price = 'Free';
						} 


					}else{

						if($featured_listing != 0 && $highlighted_listing == 0){ 

						  if($featured_listing <= $userinfo['featured_credits']){

						    if($highlighted_listing != 0){
						      $fl_sign = '£';
						      $fl_val = 1.00 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						    }else{
						      $listing_price = 'Free';
						    }

						  }else{

						    $fl_sign = '£';
						    $fl_val = 1.50 * $featured_listing;
						    $listing_price = $fl_sign.round($fl_val,2);
						    $price_payment = round($fl_val,2);

						  }

						}else if($featured_listing == 0 && $highlighted_listing != 0){

						  if($featured_listing == 0 && $highlighted_listing == 0){

						    $listing_price = 'Free';
						  
						  }else if($featured_listing == 0 && $highlighted_listing != 0){

						    if($featured_listing == 0 && $highlighted_listing == 0){
						      $listing_price = 'Free';
						    }else if($featured_listing != 0 && $highlighted_listing != 0){
						      $fl_sign = '£';
						      $fl_val = 1.00 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);

						    }else if($highlighted_listing != ''){
						      $fl_sign = '£';
						      $fl_val = 1.00 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						    }else{
						      $listing_price = 'Free';
						    } 

						  }else{

						    $listing_price = 'Free';

						  }
						  
						}else if($featured_listing != 0 && $highlighted_listing != 0){

							if($featured_listing <= $userinfo['featured_credits']){

							    if($highlighted_listing != ''){
							      $fl_sign = '£';
							      $fl_val = 1.00 * $highlighted_listing;
							      $listing_price = $fl_sign.round($fl_val,2);
							      $price_payment = round($fl_val,2);
							    }else{
							      $listing_price = 'Free';
							    }
							    
							}else{

								switch ([$highlighted_listing,$featured_listing]) {
								case ["1","1"]:
								  $listing_price = $fl_sign.'2.25';
								  $price_payment = '2.25';
								  break;
								case ["1","2"]:
								  $listing_price = $fl_sign.'3.75';
								  $price_payment = '3.75';
								  break;
								case ["1","3"]:
								  $listing_price = $fl_sign.'5.25';
								  $price_payment = '5.25';
								  break;
								case ["1","4"]:
								  $listing_price = $fl_sign.'6.75';
								  $price_payment = '6.75';
								  break;
								case ["1","5"]:
								  $listing_price = $fl_sign.'8.25';
								  $price_payment = '8.25';
								  break;
								case ["2","1"]:
								  $listing_price = $fl_sign.'3.25';
								  $price_payment = '3.25';
								  break;
								case ["2","2"]:
								  $listing_price = $fl_sign.'4.50';
								  $price_payment = '4.50';
								  break;
								case ["2","3"]:
								  $listing_price = $fl_sign.'6.00';
								  $price_payment = '6.00';
								  break;
								case ["2","4"]:
								  $listing_price = $fl_sign.'7.50';
								  $price_payment = '7.50';
								  break;
								case ["2","5"]:
								  $listing_price = $fl_sign.'9.00';
								  $price_payment = '9.00';
								  break;
								case ["3","1"]:
								  $listing_price = $fl_sign.'4.25';
								  $price_payment = '4.25';
								  break;
								case ["3","2"]:
								  $listing_price = $fl_sign.'5.50';
								  $price_payment = '5.50';
								  break;
								case ["3","3"]:
								  $listing_price = $fl_sign.'6.75';
								  $price_payment = '6.75';
								  break;
								case ["3","4"]:
								  $listing_price = $fl_sign.'8.25';
								  $price_payment = '8.25';
								  break;
								case ["3","5"]:
								  $listing_price = $fl_sign.'9.75';
								  $price_payment = '9.75';
								  break;
								case ["4","1"]:
								  $listing_price = $fl_sign.'5.25';
								  $price_payment = '5.25';
								  break;
								case ["4","2"]:
								  $listing_price = $fl_sign.'6.50';
								  $price_payment = '6.50';
								  break;
								case ["4","3"]:
								  $listing_price = $fl_sign.'7.75';
								  $price_payment = '7.75';
								  break;
								case ["4","4"]:
								  $listing_price = $fl_sign.'9.00';
								  $price_payment = '9.00';
								  break;
								case ["4","5"]:
								  $listing_price = $fl_sign.'10.50';
								  $price_payment = '10.50';
								  break;
								case ["5","1"]:
								  $listing_price = $fl_sign.'6.25';
								  $price_payment = '6.25';
								  break;
								case ["5","2"]:
								  $listing_price = $fl_sign.'7.50';
								  $price_payment = '7.50';
								  break;
								case ["5","3"]:
								  $listing_price = $fl_sign.'8.75';
								  $price_payment = '8.75';
								  break;
								case ["5","4"]:
								  $listing_price = $fl_sign.'10.00';
								  $price_payment = '10.00';
								  break;
								case ["5","5"]:
								  $listing_price = $fl_sign.'11.25';
								  $price_payment = '11.25';
								  break;
								  default:
								    $fl_sign = '£';
								    $fl_val = 1.50 * $featured_listing;
								    $listing_price = $fl_sign.round($fl_val,2);
								    $price_payment = round($fl_val,2);
								}

							}

						}else{
						  $listing_price = 'Free';
						} 

					}
    			
	    		}else{

	    			if($country_lang == 'us'){
	    				$fl_sign = '$';

						if($highlighted_listing != 0){

							if($featured_listing != 0){
								/* Highlights != 0 && != '' and Featured is != 0 && != '' */
								switch ([$highlighted_listing,$featured_listing]) {
									case ["1","1"]:
						            	$listing_price = $fl_sign.'3.40';
						            	$price_payment = '3.40';
						            break;
									case ["1","2"]:
										$listing_price = $fl_sign.'5.65';
										$price_payment = '5.65';
									break;
									case ["1","3"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["1","4"]:
										$listing_price = $fl_sign.'10.15';
										$price_payment = '10.15';
									break;
									case ["1","5"]:
										$listing_price = $fl_sign.'12.40';
										$price_payment = '12.40';
									break;
									case ["2","1"]:
										$listing_price = $fl_sign.'4.90';
										$price_payment = '4.90';
									break;
									case ["2","2"]:
										$listing_price = $fl_sign.'6.80';
										$price_payment = '6.80';
									break;
									case ["2","3"]:
										$listing_price = $fl_sign.'9.05';
										$price_payment = '9.05';
									break;
									case ["2","4"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["2","5"]:
										$listing_price = $fl_sign.'13.55';
										$price_payment = '13.55';
									break;
									case ["3","1"]:
										$listing_price = $fl_sign.'6.40';
										$price_payment = '6.40';
									break;
									case ["3","2"]:
										$listing_price = $fl_sign.'8.30';
										$price_payment = '8.30';
									break;
									case ["3","3"]:
										$listing_price = $fl_sign.'10.20';
										$price_payment = '10.20';
									break;
									case ["3","4"]:
										$listing_price = $fl_sign.'12.45';
										$price_payment = '12.45';
									break;
									case ["3","5"]:
										$listing_price = $fl_sign.'14.70';
										$price_payment = '14.70';
									break;
									case ["4","1"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["4","2"]:
										$listing_price = $fl_sign.'9.80';
										$price_payment = '9.80';
									break;
									case ["4","3"]:
										$listing_price = $fl_sign.'11.70';
										$price_payment = '11.70';
									break;
									case ["4","4"]:
										$listing_price = $fl_sign.'13.60';
										$price_payment = '13.60';
									break;
									case ["4","5"]:
										$listing_price = $fl_sign.'15.85';
										$price_payment = '15.85';
									break;
									case ["5","1"]:
										$listing_price = $fl_sign.'9.40';
										$price_payment = '9.40';
									break;
									case ["5","2"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["5","3"]:
										$listing_price = $fl_sign.'13.20';
										$price_payment = '13.20';
									break;
									case ["5","4"]:
										$listing_price = $fl_sign.'15.10';
										$price_payment = '15.10';
									break;
									case ["5","5"]:
										$listing_price = $fl_sign.'17.00';
										$price_payment = '17.00';
									break;
									default:
										$fl_val = 2.25 * $featured_listing;
										$listing_price = $fl_sign.round($fl_val,2);
										$price_payment = round($fl_val,2);
								}

							}else{

								if($highlighted_listing != ''){
									$fl_val = 1.50 * $highlighted_listing;
									$listing_price = $fl_sign.round($fl_val,2);
									$price_payment = round($fl_val,2);
									/* Highlights != 0 && != '' and Featured is == 0 && == '' */
								}else{
									$listing_price = 'Free';
								}
							}
						}else if($featured_listing != 0){
							$fl_val = 2.25 * $featured_listing;
							$listing_price = $fl_sign.round($fl_val,2);
							$price_payment = round($fl_val,2);
							/* Highlights == 0 && == '' and Featured is != 0 && != '' */
						}else{
							$listing_price = 'Free';
						}

					}else{

						$fl_sign = '£';

						if($highlighted_listing != 0){

							if($featured_listing != 0){
								/* Highlights != 0 && != '' and Featured is != 0 && != '' */
								switch ([$highlighted_listing,$featured_listing]) {
									case ["1","1"]:
										$listing_price = $fl_sign.'2.25';
										$price_payment = '2.25';
									break;
									case ["1","2"]:
										$listing_price = $fl_sign.'3.75';
										$price_payment = '3.75';
									break;
									case ["1","3"]:
										$listing_price = $fl_sign.'5.25';
										$price_payment = '5.25';
									break;
									case ["1","4"]:
										$listing_price = $fl_sign.'6.75';
										$price_payment = '6.75';
									break;
									case ["1","5"]:
										$listing_price = $fl_sign.'8.25';
										$price_payment = '8.25';
									break;
									case ["2","1"]:
										$listing_price = $fl_sign.'3.25';
										$price_payment = '3.25';
									break;
									case ["2","2"]:
										$listing_price = $fl_sign.'4.50';
										$price_payment = '4.50';
									break;
									case ["2","3"]:
										$listing_price = $fl_sign.'6.00';
										$price_payment = '6.00';
									break;
									case ["2","4"]:
										$listing_price = $fl_sign.'7.50';
										$price_payment = '7.50';
									break;
									case ["2","5"]:
										$listing_price = $fl_sign.'9.00';
										$price_payment = '9.00';
									break;
									case ["3","1"]:
										$listing_price = $fl_sign.'4.25';
										$price_payment = '4.25';
									break;
									case ["3","2"]:
										$listing_price = $fl_sign.'5.50';
										$price_payment = '5.50';
									break;
									case ["3","3"]:
										$listing_price = $fl_sign.'6.75';
										$price_payment = '6.75';
									break;
									case ["3","4"]:
										$listing_price = $fl_sign.'8.25';
										$price_payment = '8.25';
									break;
									case ["3","5"]:
										$listing_price = $fl_sign.'9.75';
										$price_payment = '9.75';
									break;
									case ["4","1"]:
										$listing_price = $fl_sign.'5.25';
										$price_payment = '5.25';
									break;
									case ["4","2"]:
										$listing_price = $fl_sign.'6.50';
										$price_payment = '6.50';
									break;
									case ["4","3"]:
										$listing_price = $fl_sign.'7.75';
										$price_payment = '7.75';
									break;
									case ["4","4"]:
										$listing_price = $fl_sign.'9.00';
										$price_payment = '9.00';
									break;
									case ["4","5"]:
										$listing_price = $fl_sign.'10.50';
										$price_payment = '10.50';
									break;
									case ["5","1"]:
										$listing_price = $fl_sign.'6.25';
										$price_payment = '6.25';
									break;
									case ["5","2"]:
										$listing_price = $fl_sign.'7.50';
										$price_payment = '7.50';
									break;
									case ["5","3"]:
										$listing_price = $fl_sign.'8.75';
										$price_payment = '8.75';
									break;
									case ["5","4"]:
										$listing_price = $fl_sign.'10.00';
										$price_payment = '10.00';
									break;
									case ["5","5"]:
										$listing_price = $fl_sign.'11.25';
										$price_payment = '11.25';
									break;
									default:
										$fl_val = 1.50 * $featured_listing;
										$listing_price = $fl_sign.round($fl_val,2);
										$price_payment = round($fl_val,2);
								}

							}else{

								if($highlighted_listing != ''){
									$fl_val = 1.00 * $highlighted_listing;
									$listing_price = $fl_sign.round($fl_val,2);
									$price_payment = round($fl_val,2);
									/* Highlights != 0 && != '' and Featured is == 0 && == '' */
								}else{
									$listing_price = 'Free';
								}
							}
						}else if($featured_listing != 0){
							$fl_val = 1.50 * $featured_listing;
							$listing_price = $fl_sign.round($fl_val,2);
							$price_payment = round($fl_val,2);
							/* Highlights == 0 && == '' and Featured is != 0 && != '' */
						}else{
							$listing_price = 'Free';
						}

		    		}

	    		}

	    		if($listing_price != 'Free'){

	    			if($fl_sign == '£'){
	    				$currency = 'GBP';
	    			}else{
	    				$currency = 'USD';
	    			}

	    			if($highlighted_listing != 0 && $featured_listing == 0){
	    				if($highlighted_listing == 1){
	    					$description = 'Highlighted for '.$highlighted_listing.' weeks - '.$listing_price;
    					}else{
    						$description = 'Highlighted for '.$highlighted_listing.' week - '.$listing_price;
    					}
	                }elseif($highlighted_listing == 0 && $featured_listing != 0){
	                	if($highlighted_listing == 1){
	    					$description = 'Featured for '.$featured_listing.' weeks - '.$listing_price;
    					}else{
    						$description = 'Featured for '.$featured_listing.' week - '.$listing_price;
    					}
	                }else{
	                	if($highlighted_listing == 1 && $highlighted_listing == 1){
	                		$description = 'Featured for '.$featured_listing.' week, Highlighted for '.$highlighted_listing.' week - '.$listing_price;
	                	}elseif($highlighted_listing == 1 && $highlighted_listing != 1){
	                		$description = 'Featured for '.$featured_listing.' week, Highlighted for '.$highlighted_listing.' weeks - '.$listing_price;
	                	}elseif($highlighted_listing != 1 && $highlighted_listing == 1){
	                		$description = 'Featured for '.$featured_listing.' weeks, Highlighted for '.$highlighted_listing.' week - '.$listing_price;
	                	}else{
	                		$description = 'Featured for '.$featured_listing.' weeks, Highlighted for '.$highlighted_listing.' weeks - '.$listing_price;
	                	}
	                }

					$product = array(
						'Listing' => array('name' => 'Listing', 'desc' => $description, 'price' => $price_payment));
					//$currency = $paypal_currency; // currency for the transaction
					$ec_action = 'Sale'; // for PAYMENTREQUEST_0_PAYMENTACTION, it's either Sale, Order or Authorization


					$payment_id = $this->payment_model->listing_payment($id,$price_payment,$currency,$fl_sign,$description,$listing_id);

					$payment_session_id = array(
						'payment_session_id' => $payment_id,
						'payment_listing_id' => $listing_id,
						'listing_highlights_value' => $highlighted_listing,
						'listing_featured_value' => $featured_listing
					);
					$this->session->set_userdata($payment_session_id);

					$to_buy = array(
						'desc' => 'Breed Your Dog', 
						'currency' => $currency, 
						'type' => $ec_action, 
						'return_URL' => site_url('users/completed'), 
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
						
	    		}

	    		if($listing_price == 'Free'){

	    			if($highlighted_listing != 0 || $featured_listing != 0 ){
	    				$this->payment_model->listing_highlight_featured($listing_id,$highlighted_listing,$featured_listing);
	    			}else{
	    				$this->payment_model->listing_highlight_featured_audits($listing_id);
	    			}

		    	}

				$this->session->set_flashdata('flashdata_success', 'Listing Created');

				if($iploc['country'] == 'US - United States'){
					redirect('us/listings/yours');
				}else{
					redirect('listings/yours');
				}
				

			}
		}

		/*=====================================================
		[-- USERS LISTINGS YOURS -----------------------------]
	    ======================================================*/
		public function listings_yours(){
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

			$id = $this->session->userdata('user_id_byd');
  			$data['userinformations'] = $this->users_model->user_info($id);


  			/*=====================================================
			[-- START GENERATE THUMBS NAILS ----------------------]
		    ======================================================*/
  			
	        /*$this->load->library('image_lib');

	        $userlistings = $this->getdata_model->get_listing_for_thumbnails();

	        //$userlistings = $this->getdata_model->get_listing_user_id($this->session->userdata('user_id_byd'));

	        //print_pre($userlistings);

	        if(!empty($userlistings)){
	        	foreach($userlistings as $listing){

	        		$listing_id = $listing['id'];
		            $listing_image = $this->getdata_model->get_listing_images_for_thumbnails($listing_id);

					foreach($listing_image as $list_img){
				        if(!empty($list_img['image'])){   
							$config = array(
				            'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$list_img['id'].'/'.$list_img['image'],
				            'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$list_img['id'].'/thumb_'.$list_img['image'],
				            'maintain_ration'   => true,
				            'overwrite'         => true, 
				            'quality'			=> '40%',
				            'width'             => 400,
				            'height'            => 300
				            );

				            $this->image_lib->initialize($config);
				            $this->image_lib->resize();
				            $this->image_lib->clear();
		        		}
		        	}
	        	}
	        }*/

	        /*=====================================================
			[-- END GENERATE THUMBS NAILS ------------------------]
		    ======================================================*/

	       

			$this->load->view('templates/header',$data);
			$this->load->view('users/pages/listings-yours',$data);
			$this->load->view('templates/footer',$data);
		}

		/*=====================================================
		[-- USERS LISTING DELETE -----------------------------]
	    ======================================================*/
		public function listing_delete($id){
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

			$this->users_model->delete_listing($id);
			$this->session->set_flashdata('flashdata_danger', 'Listing has been deleted');
			$iploc = geoCheckIP($this->input->ip_address());
			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
			if($iploc['country'] == 'US - United States'){
				redirect('us/listings/yours');
			}else{
				redirect('listings/yours');
			}
			
		}

		/*=====================================================
		[-- USERS LISTINGS MEMORIAL --------------------------]
	    ======================================================*/
		public function listing_memorial($id){
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


			$this->users_model->listing_memorial($id);
			$this->session->set_flashdata('flashdata_success', 'Listing has been updated');
			$iploc = geoCheckIP($this->input->ip_address());
			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
			if($iploc['country'] == 'US - United States'){
				redirect('us/listings/yours');
			}else{
				redirect('listings/yours');
			}
		}

		/*=====================================================
		[-- USERS LISTINGS EDIT ------------------------------]
	    ======================================================*/
		public function listings_edit($listing_id){
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

			$data['listing'] =  $this->getdata_model->get_listing($listing_id);

			$id = $this->session->userdata('user_id_byd');
  			$data['userinformations'] = $this->users_model->user_info($id);

			foreach( $data['userinformations'] as $userinfo){

  				$users_id	=	$userinfo['id'];
  				$plan_id 	= 	$userinfo['plan_id'];

  				$plans = $this->getdata_model->get_plans_id($plan_id);

  				$userlisting_number = $this->getdata_model->get_published_listings_number($users_id);

  				/*if($plans['active_listings'] <= $userlisting_number){
  					$this->session->set_flashdata('flashdata_danger', 'You can not create any new listings as '.$plans['name'].'  account you can have a maximum of '.$plans['active_listings'].' active listings. To add more listings you need to upgrade to a paid account or unpublish some of your other listings.');
	    			$iploc = geoCheckIP($this->input->ip_address());
					if($iploc['country'] == 'US - United States'){
						redirect('us/user/dashboard');
					}else{
						redirect('user/dashboard');
					}
  				}*/

  			}

	    	$this->form_validation->set_rules('listing_title', 'Listing Title', 'required');

	    	if($data['listing']['listing_type'] != 'pup'){
	    		$this->form_validation->set_rules('dogname', 'Dog name', 'required');
	    		$this->form_validation->set_rules('gender', 'Gender', 'required');
	    	}
	    	
	    	$this->form_validation->set_rules('breed', 'Breed Name', 'required');
	    	$this->form_validation->set_rules('date', 'Date of Birth', 'required');
	    	$this->form_validation->set_rules('listing_description', 'Listing Description', 'required|callback_listing_description_validate');
	    	$this->form_validation->set_rules('country', 'Country Name', 'required');
	    	$this->form_validation->set_rules('region', 'Region', 'required');
	    	$this->form_validation->set_rules('post_code', 'Post Code', 'required');
	    
	    	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

	    	if($this->form_validation->run() === FALSE){

				$this->load->view('templates/header',$data);
				$this->load->view('users/pages/listings-edit',$data);
				$this->load->view('templates/footer',$data);

			}else{

				$listing =  $this->getdata_model->get_listing($listing_id);

				$userinformation = $this->getdata_model->get_user($listing['user_id']);

				if($this->input->post('published') != ''){

					$users_id	=	$listing['user_id'];

	  				$plans = $this->getdata_model->get_plans_id($userinformation['plan_id']);

	  				$userlisting_number = $this->getdata_model->get_published_listings_number($users_id);


	  				if($plans['active_listings'] < $userlisting_number){

	  					$this->session->set_flashdata('flashdata_danger', 'You can not create any new listings as '.$plans['name'].'  account you can have a maximum of '.$plans['active_listings'].' active listings. To add more listings you need to upgrade to a paid account or unpublish some of your other listings.');
		    			$iploc = geoCheckIP($this->input->ip_address());
		    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
						if($iploc['country'] == 'US - United States'){
							redirect('us/user/dashboard');
						}else{
							redirect('user/dashboard');
						}

	  				}
				}
			
				if($listing['listing_type'] == 'pup'){
					$this->users_model->update_listingpuppies($listing_id);
				}else{
					$this->users_model->update_listingdog($listing_id);
				}


				/*==============================================================================
				[-- LISTINGS DOG AND PUPPIES EDIT/DELETE IMAGES EXISTING ----------------------]
			    ==============================================================================*/

				if($this->input->post('listing_img_id') != ''){


					foreach ($this->input->post('listing_img_id') as $imgid){

						$imageid[] = $imgid;

					}

					$checkremove = $this->input->post('checkbox_remove[]');
					
					$this->load->library('image_lib');

					foreach ($_FILES['image_replace']['name'] as $key => $imgname){

						$imagename = $_FILES['image_replace']['name'];

						$checkr = 1;
			            $img_num = 0;
			            for($s = 0; $s < count($_FILES['image_replace']['name']); $s++){

			            	if(!empty($_FILES['image_replace']['name'][$s])){

				                $_FILES['file[]']['name']     = $_FILES['image_replace']['name'][$s];
				                $_FILES['file[]']['type']     = $_FILES['image_replace']['type'][$s];
				                $_FILES['file[]']['tmp_name'] = $_FILES['image_replace']['tmp_name'][$s];
				                $_FILES['file[]']['error']    = $_FILES['image_replace']['error'][$s];
				                $_FILES['file[]']['size']     = $_FILES['image_replace']['size'][$s]; 

				                $string_image = $_FILES['file[]']['name'];
								$new_string_image = pathinfo($string_image, PATHINFO_FILENAME) . '.' . strtolower(pathinfo($string_image, PATHINFO_EXTENSION));

			                	$listing_image = strtr($new_string_image,' ','_');

				                $listing_images_id =  $imageid[$img_num];

				                $path = "./uploads/listing_images/".$listing_id."/".$listing_images_id;
					    		if (!is_dir($path)){
						    		mkdir($path,0755,TRUE);
						    	}

					    		$config['upload_path'] = './uploads/listing_images/'.$listing_id.'/'.$listing_images_id;
				                $config['allowed_types'] = 'gif|jpg|png|jpeg';
								$config['max_size'] = '99999999';
								$config['max_width'] = '2000000';
								$config['max_height'] = '2000000';
								$config['overwrite'] = TRUE;
			        			$config['remove_spaces'] = TRUE;
			        			$config['file_ext_tolower'] = TRUE;
								

								$this->load->library('upload', $config);

								$this->upload->initialize($config);

								$this->upload->do_upload('file[]');

							
								$config = array(
					            'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image,
					            'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/thumb_'.$listing_image,
					            'maintain_ration'   => true,
					            'overwrite'         => true,
					            'quality'			=> '40%',
					            'width'             => 400,
					            'height'            => 300
					            );

					            $this->image_lib->initialize($config);
					            $this->image_lib->resize();
					            $this->image_lib->clear();

					            $config = array(
							        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image,
							        'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/thumb_small_'.$listing_image,
							        'maintain_ration'   => true,
							        'overwrite'         => true,
							        'quality'			=> '100%',
							        'width'             => 300,
							        'height'            => 300
							    );

						        $this->image_lib->initialize($config);
						        $this->image_lib->resize();
						        $this->image_lib->clear();

							}

							$img_num++;
							$checkr++;
			        	}


					}

					$checkr = 1;

					for($imgr = 0; $imgr < count($imagename); $imgr++){

						$idlistingimg = $imageid[$imgr];

						if(!empty($checkremove[$idlistingimg])){

							$id = $imageid[$imgr];

							$this->users_model->delete_listing_images($id);

							$path = './uploads/listing_images/'.$listing_id.'/'.$imageid[$imgr];

							if (!is_dir($path)){
							}else{
								delete_files($path);
							}

						}else{

							if($imagename[$imgr] != ''){

								$id = $imageid[$imgr];
								$name = strtr($imagename[$imgr],' ','_');
								$this->users_model->update_listing_images($id,$name);
							}

						}

						$checkr++;
					}	

				}
				
				/*=========================================================
				[-- LISTINGS DOG PUPPIES ADD IMAGES ----------------------]
			    =========================================================*/

			    $allimages = $this->users_model->get_listing_images_fixed_sort($listing_id);

		        $sortimg = 1;
				foreach($allimages as $allimg){

					$img_id = $allimg['id'];
					$sort = $sortimg;
					$this->users_model->listing_images_sort($img_id,$sort);

					$sortimg++;

				}


			    if(!empty($_FILES['userfile'])):

	 				$this->load->library('image_lib');

		            for($s = 0; $s < count($_FILES['userfile']['size']); $s++)
		            {
		            	if(!empty($_FILES['userfile']['name'][$s])){

			                $_FILES['file[]']['name']     = $_FILES['userfile']['name'][$s];
			                $_FILES['file[]']['type']     = $_FILES['userfile']['type'][$s];
			                $_FILES['file[]']['tmp_name'] = $_FILES['userfile']['tmp_name'][$s];
			                $_FILES['file[]']['error']    = $_FILES['userfile']['error'][$s];
			                $_FILES['file[]']['size']     = $_FILES['userfile']['size'][$s]; 

			                $string_image = $_FILES['file[]']['name'];
							$new_string_image = pathinfo($string_image, PATHINFO_FILENAME) . '.' . strtolower(pathinfo($string_image, PATHINFO_EXTENSION));

			                $listing_image = strtr($new_string_image,' ','_');

			               	$listing_images_id =  $this->users_model->edit_listing_images($listing_id,$listing_image);

			                
			                $path = "./uploads/listing_images/".$listing_id."/".$listing_images_id;
				    		if (!is_dir($path)){
					    		mkdir($path,0755,TRUE);
					    	}

				    		$config['upload_path'] = './uploads/listing_images/'.$listing_id.'/'.$listing_images_id;
			                $config['allowed_types'] = 'gif|jpg|png|jpeg';
							$config['max_size'] = '99999999';
							$config['max_width'] = '2000000';
							$config['max_height'] = '2000000';
							$config['overwrite'] = TRUE;
			    			$config['remove_spaces'] = TRUE;
			    			$config['file_ext_tolower'] = TRUE;

							$this->load->library('upload', $config);


							$this->upload->initialize($config);

							$this->upload->do_upload('file[]');


							$config = array(
				            'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image,
				            'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/thumb_'.$listing_image,
				            'maintain_ration'   => true,
				            'overwrite'         => true, 
				            'quality'			=> '40%',
				            'width'             => 400,
				            'height'            => 300
				            );

				            $this->image_lib->initialize($config);
				            $this->image_lib->resize();
				            $this->image_lib->clear();

				            $config = array(
						        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image,
						        'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/thumb_small_'.$listing_image,
						        'maintain_ration'   => true,
						        'overwrite'         => true,
						        'quality'			=> '100%',
						        'width'             => 300,
						        'height'            => 300
						    );

					        $this->image_lib->initialize($config);
					        $this->image_lib->resize();
					        $this->image_lib->clear();

					        $config['image_library'] = 'GD2';
							$config['source_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/'.$listing_image;
							$config['new_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_images_id.'/big_'.$listing_image;
							$config['wm_type'] = 'overlay';
							$config['wm_overlay_path'] = 'assets/img/watermark_logo.png';
							$config['wm_opacity'] = '100';
							$config['quality'] = '60%';
							$config['wm_vrt_alignment'] = 'bottom'; 
							$config['wm_hor_alignment'] = 'left';
							$config['wm_hor_offset'] = '10';
							$config['wm_vrt_offset'] = '10';

							$this->image_lib->initialize($config);
							$this->image_lib->watermark();
							$this->image_lib->clear();

						}

		            }

		        endif;

		        $allimages = $this->users_model->get_listing_images_fixed_sort($listing_id);

		        $sortimg = 1;
				foreach($allimages as $allimg){

					$img_id = $allimg['id'];
					$sort = $sortimg;
					$this->users_model->listing_images_sort($img_id,$sort);

					$sortimg++;

				}

				/*=====================================================
				[-- LISTINGS DOG FEATURED OR HIGHLIGHTED -------------]
			    ======================================================*/
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

    			$highlighted_listing = $this->input->post('highlighted_listing');
    			$featured_listing = $this->input->post('featured_listing');

    			if($userinfo['featured_credits'] != 0){

					if($country_lang == 'us'){

						if($featured_listing != 0 && $highlighted_listing == 0){ 

						  if($featured_listing <= $userinfo['featured_credits']){

						    if($highlighted_listing != 0){
						      $fl_sign = '$';
						      $fl_val = 1.50 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						    }else{
						      $listing_price = 'Free';
						    }

						  }else{

						    $fl_sign = '$';
						    $fl_val = 2.25 * $featured_listing;
						    $listing_price = $fl_sign.round($fl_val,2);
						    $price_payment = round($fl_val,2);

						  }

						}else if($featured_listing == 0 && $highlighted_listing != 0){

						  if($featured_listing == 0 && $highlighted_listing == 0){

						    $listing_price = 'Free';
						  
						  }else if($featured_listing == 0 && $highlighted_listing != 0){

						    if($featured_listing == 0 && $highlighted_listing == 0){
						      $listing_price = 'Free';
						    }else if($featured_listing != 0 && $highlighted_listing != 0){
						      $fl_sign = '$';
						      $fl_val = 1.50 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);

						    }else if($highlighted_listing != ''){
						      $fl_sign = '$';
						      $fl_val = 1.50 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						      
						    }else{
						      $listing_price = 'Free';
						    } 

						  }else{

						    $listing_price = 'Free';

						  }
						  
						}else if($featured_listing != 0 && $highlighted_listing != 0){

							if($featured_listing <= $userinfo['featured_credits']){

							    if($highlighted_listing != ''){
							      $fl_sign = '$';
							      $fl_val = 1.50 * $highlighted_listing;
							      $listing_price = $fl_sign.round($fl_val,2);
							      $price_payment = round($fl_val,2); 
							    }else{
							      $listing_price = 'Free';
							    }
							    
							}else{

								switch ([$highlighted_listing,$featured_listing]) {
									case ["1","1"]:
						            	$listing_price = $fl_sign.'3.40';
						            	$price_payment = '3.40';
						            break;
									case ["1","2"]:
										$listing_price = $fl_sign.'5.65';
										$price_payment = '5.65';
									break;
									case ["1","3"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["1","4"]:
										$listing_price = $fl_sign.'10.15';
										$price_payment = '10.15';
									break;
									case ["1","5"]:
										$listing_price = $fl_sign.'12.40';
										$price_payment = '12.40';
									break;
									case ["2","1"]:
										$listing_price = $fl_sign.'4.90';
										$price_payment = '4.90';
									break;
									case ["2","2"]:
										$listing_price = $fl_sign.'6.80';
										$price_payment = '6.80';
									break;
									case ["2","3"]:
										$listing_price = $fl_sign.'9.05';
										$price_payment = '9.05';
									break;
									case ["2","4"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["2","5"]:
										$listing_price = $fl_sign.'13.55';
										$price_payment = '13.55';
									break;
									case ["3","1"]:
										$listing_price = $fl_sign.'6.40';
										$price_payment = '6.40';
									break;
									case ["3","2"]:
										$listing_price = $fl_sign.'8.30';
										$price_payment = '8.30';
									break;
									case ["3","3"]:
										$listing_price = $fl_sign.'10.20';
										$price_payment = '10.20';
									break;
									case ["3","4"]:
										$listing_price = $fl_sign.'12.45';
										$price_payment = '12.45';
									break;
									case ["3","5"]:
										$listing_price = $fl_sign.'14.70';
										$price_payment = '14.70';
									break;
									case ["4","1"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["4","2"]:
										$listing_price = $fl_sign.'9.80';
										$price_payment = '9.80';
									break;
									case ["4","3"]:
										$listing_price = $fl_sign.'11.70';
										$price_payment = '11.70';
									break;
									case ["4","4"]:
										$listing_price = $fl_sign.'13.60';
										$price_payment = '13.60';
									break;
									case ["4","5"]:
										$listing_price = $fl_sign.'15.85';
										$price_payment = '15.85';
									break;
									case ["5","1"]:
										$listing_price = $fl_sign.'9.40';
										$price_payment = '9.40';
									break;
									case ["5","2"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["5","3"]:
										$listing_price = $fl_sign.'13.20';
										$price_payment = '13.20';
									break;
									case ["5","4"]:
										$listing_price = $fl_sign.'15.10';
										$price_payment = '15.10';
									break;
									case ["5","5"]:
										$listing_price = $fl_sign.'17.00';
										$price_payment = '17.00';
									break;
									default:
										$fl_val = 2.25 * $featured_listing;
										$listing_price = $fl_sign.round($fl_val,2);
										$price_payment = round($fl_val,2);
								}

							}

						}else{
						  $listing_price = 'Free';
						} 


					}else{

						if($featured_listing != 0 && $highlighted_listing == 0){ 

						  if($featured_listing <= $userinfo['featured_credits']){

						    if($highlighted_listing != 0){
						      $fl_sign = '£';
						      $fl_val = 1.00 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						    }else{
						      $listing_price = 'Free';
						    }

						  }else{

						    $fl_sign = '£';
						    $fl_val = 1.50 * $featured_listing;
						    $listing_price = $fl_sign.round($fl_val,2);
						    $price_payment = round($fl_val,2);

						  }

						}else if($featured_listing == 0 && $highlighted_listing != 0){

						  if($featured_listing == 0 && $highlighted_listing == 0){

						    $listing_price = 'Free';
						  
						  }else if($featured_listing == 0 && $highlighted_listing != 0){

						    if($featured_listing == 0 && $highlighted_listing == 0){
						      $listing_price = 'Free';
						    }else if($featured_listing != 0 && $highlighted_listing != 0){
						      $fl_sign = '£';
						      $fl_val = 1.00 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);

						    }else if($highlighted_listing != ''){
						      $fl_sign = '£';
						      $fl_val = 1.00 * $highlighted_listing;
						      $listing_price = $fl_sign.round($fl_val,2);
						      $price_payment = round($fl_val,2);
						    }else{
						      $listing_price = 'Free';
						    } 

						  }else{

						    $listing_price = 'Free';

						  }
						  
						}else if($featured_listing != 0 && $highlighted_listing != 0){

							if($featured_listing <= $userinfo['featured_credits']){

							    if($highlighted_listing != ''){
							      $fl_sign = '£';
							      $fl_val = 1.00 * $highlighted_listing;
							      $listing_price = $fl_sign.round($fl_val,2);
							      $price_payment = round($fl_val,2);
							    }else{
							      $listing_price = 'Free';
							    }
							    
							}else{

								switch ([$highlighted_listing,$featured_listing]) {
								case ["1","1"]:
								  $listing_price = $fl_sign.'2.25';
								  $price_payment = '2.25';
								  break;
								case ["1","2"]:
								  $listing_price = $fl_sign.'3.75';
								  $price_payment = '3.75';
								  break;
								case ["1","3"]:
								  $listing_price = $fl_sign.'5.25';
								  $price_payment = '5.25';
								  break;
								case ["1","4"]:
								  $listing_price = $fl_sign.'6.75';
								  $price_payment = '6.75';
								  break;
								case ["1","5"]:
								  $listing_price = $fl_sign.'8.25';
								  $price_payment = '8.25';
								  break;
								case ["2","1"]:
								  $listing_price = $fl_sign.'3.25';
								  $price_payment = '3.25';
								  break;
								case ["2","2"]:
								  $listing_price = $fl_sign.'4.50';
								  $price_payment = '4.50';
								  break;
								case ["2","3"]:
								  $listing_price = $fl_sign.'6.00';
								  $price_payment = '6.00';
								  break;
								case ["2","4"]:
								  $listing_price = $fl_sign.'7.50';
								  $price_payment = '7.50';
								  break;
								case ["2","5"]:
								  $listing_price = $fl_sign.'9.00';
								  $price_payment = '9.00';
								  break;
								case ["3","1"]:
								  $listing_price = $fl_sign.'4.25';
								  $price_payment = '4.25';
								  break;
								case ["3","2"]:
								  $listing_price = $fl_sign.'5.50';
								  $price_payment = '5.50';
								  break;
								case ["3","3"]:
								  $listing_price = $fl_sign.'6.75';
								  $price_payment = '6.75';
								  break;
								case ["3","4"]:
								  $listing_price = $fl_sign.'8.25';
								  $price_payment = '8.25';
								  break;
								case ["3","5"]:
								  $listing_price = $fl_sign.'9.75';
								  $price_payment = '9.75';
								  break;
								case ["4","1"]:
								  $listing_price = $fl_sign.'5.25';
								  $price_payment = '5.25';
								  break;
								case ["4","2"]:
								  $listing_price = $fl_sign.'6.50';
								  $price_payment = '6.50';
								  break;
								case ["4","3"]:
								  $listing_price = $fl_sign.'7.75';
								  $price_payment = '7.75';
								  break;
								case ["4","4"]:
								  $listing_price = $fl_sign.'9.00';
								  $price_payment = '9.00';
								  break;
								case ["4","5"]:
								  $listing_price = $fl_sign.'10.50';
								  $price_payment = '10.50';
								  break;
								case ["5","1"]:
								  $listing_price = $fl_sign.'6.25';
								  $price_payment = '6.25';
								  break;
								case ["5","2"]:
								  $listing_price = $fl_sign.'7.50';
								  $price_payment = '7.50';
								  break;
								case ["5","3"]:
								  $listing_price = $fl_sign.'8.75';
								  $price_payment = '8.75';
								  break;
								case ["5","4"]:
								  $listing_price = $fl_sign.'10.00';
								  $price_payment = '10.00';
								  break;
								case ["5","5"]:
								  $listing_price = $fl_sign.'11.25';
								  $price_payment = '11.25';
								  break;
								  default:
								    $fl_sign = '£';
								    $fl_val = 1.50 * $featured_listing;
								    $listing_price = $fl_sign.round($fl_val,2);
								    $price_payment = round($fl_val,2);
								}

							}

						}else{
						  $listing_price = 'Free';
						} 

					}
    			
	    		}else{

	    			if($country_lang == 'us'){
	    				$fl_sign = '$';

						if($highlighted_listing != 0){

							if($featured_listing != 0){
								/* Highlights != 0 && != '' and Featured is != 0 && != '' */
								switch ([$highlighted_listing,$featured_listing]) {
									case ["1","1"]:
						            	$listing_price = $fl_sign.'3.40';
						            	$price_payment = '3.40';
						            break;
									case ["1","2"]:
										$listing_price = $fl_sign.'5.65';
										$price_payment = '5.65';
									break;
									case ["1","3"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["1","4"]:
										$listing_price = $fl_sign.'10.15';
										$price_payment = '10.15';
									break;
									case ["1","5"]:
										$listing_price = $fl_sign.'12.40';
										$price_payment = '12.40';
									break;
									case ["2","1"]:
										$listing_price = $fl_sign.'4.90';
										$price_payment = '4.90';
									break;
									case ["2","2"]:
										$listing_price = $fl_sign.'6.80';
										$price_payment = '6.80';
									break;
									case ["2","3"]:
										$listing_price = $fl_sign.'9.05';
										$price_payment = '9.05';
									break;
									case ["2","4"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["2","5"]:
										$listing_price = $fl_sign.'13.55';
										$price_payment = '13.55';
									break;
									case ["3","1"]:
										$listing_price = $fl_sign.'6.40';
										$price_payment = '6.40';
									break;
									case ["3","2"]:
										$listing_price = $fl_sign.'8.30';
										$price_payment = '8.30';
									break;
									case ["3","3"]:
										$listing_price = $fl_sign.'10.20';
										$price_payment = '10.20';
									break;
									case ["3","4"]:
										$listing_price = $fl_sign.'12.45';
										$price_payment = '12.45';
									break;
									case ["3","5"]:
										$listing_price = $fl_sign.'14.70';
										$price_payment = '14.70';
									break;
									case ["4","1"]:
										$listing_price = $fl_sign.'7.90';
										$price_payment = '7.90';
									break;
									case ["4","2"]:
										$listing_price = $fl_sign.'9.80';
										$price_payment = '9.80';
									break;
									case ["4","3"]:
										$listing_price = $fl_sign.'11.70';
										$price_payment = '11.70';
									break;
									case ["4","4"]:
										$listing_price = $fl_sign.'13.60';
										$price_payment = '13.60';
									break;
									case ["4","5"]:
										$listing_price = $fl_sign.'15.85';
										$price_payment = '15.85';
									break;
									case ["5","1"]:
										$listing_price = $fl_sign.'9.40';
										$price_payment = '9.40';
									break;
									case ["5","2"]:
										$listing_price = $fl_sign.'11.30';
										$price_payment = '11.30';
									break;
									case ["5","3"]:
										$listing_price = $fl_sign.'13.20';
										$price_payment = '13.20';
									break;
									case ["5","4"]:
										$listing_price = $fl_sign.'15.10';
										$price_payment = '15.10';
									break;
									case ["5","5"]:
										$listing_price = $fl_sign.'17.00';
										$price_payment = '17.00';
									break;
									default:
										$fl_val = 2.25 * $featured_listing;
										$listing_price = $fl_sign.round($fl_val,2);
										$price_payment = round($fl_val,2);
								}

							}else{

								if($highlighted_listing != ''){
									$fl_val = 1.50 * $highlighted_listing;
									$listing_price = $fl_sign.round($fl_val,2);
									$price_payment = round($fl_val,2);
									/* Highlights != 0 && != '' and Featured is == 0 && == '' */
								}else{
									$listing_price = 'Free';
								}
							}
						}else if($featured_listing != 0){
							$fl_val = 2.25 * $featured_listing;
							$listing_price = $fl_sign.round($fl_val,2);
							$price_payment = round($fl_val,2);
							/* Highlights == 0 && == '' and Featured is != 0 && != '' */
						}else{
							$listing_price = 'Free';
						}

					}else{

						$fl_sign = '£';

						if($highlighted_listing != 0){

							if($featured_listing != 0){
								/* Highlights != 0 && != '' and Featured is != 0 && != '' */
								switch ([$highlighted_listing,$featured_listing]) {
									case ["1","1"]:
										$listing_price = $fl_sign.'2.25';
										$price_payment = '2.25';
									break;
									case ["1","2"]:
										$listing_price = $fl_sign.'3.75';
										$price_payment = '3.75';
									break;
									case ["1","3"]:
										$listing_price = $fl_sign.'5.25';
										$price_payment = '5.25';
									break;
									case ["1","4"]:
										$listing_price = $fl_sign.'6.75';
										$price_payment = '6.75';
									break;
									case ["1","5"]:
										$listing_price = $fl_sign.'8.25';
										$price_payment = '8.25';
									break;
									case ["2","1"]:
										$listing_price = $fl_sign.'3.25';
										$price_payment = '3.25';
									break;
									case ["2","2"]:
										$listing_price = $fl_sign.'4.50';
										$price_payment = '4.50';
									break;
									case ["2","3"]:
										$listing_price = $fl_sign.'6.00';
										$price_payment = '6.00';
									break;
									case ["2","4"]:
										$listing_price = $fl_sign.'7.50';
										$price_payment = '7.50';
									break;
									case ["2","5"]:
										$listing_price = $fl_sign.'9.00';
										$price_payment = '9.00';
									break;
									case ["3","1"]:
										$listing_price = $fl_sign.'4.25';
										$price_payment = '4.25';
									break;
									case ["3","2"]:
										$listing_price = $fl_sign.'5.50';
										$price_payment = '5.50';
									break;
									case ["3","3"]:
										$listing_price = $fl_sign.'6.75';
										$price_payment = '6.75';
									break;
									case ["3","4"]:
										$listing_price = $fl_sign.'8.25';
										$price_payment = '8.25';
									break;
									case ["3","5"]:
										$listing_price = $fl_sign.'9.75';
										$price_payment = '9.75';
									break;
									case ["4","1"]:
										$listing_price = $fl_sign.'5.25';
										$price_payment = '5.25';
									break;
									case ["4","2"]:
										$listing_price = $fl_sign.'6.50';
										$price_payment = '6.50';
									break;
									case ["4","3"]:
										$listing_price = $fl_sign.'7.75';
										$price_payment = '7.75';
									break;
									case ["4","4"]:
										$listing_price = $fl_sign.'9.00';
										$price_payment = '9.00';
									break;
									case ["4","5"]:
										$listing_price = $fl_sign.'10.50';
										$price_payment = '10.50';
									break;
									case ["5","1"]:
										$listing_price = $fl_sign.'6.25';
										$price_payment = '6.25';
									break;
									case ["5","2"]:
										$listing_price = $fl_sign.'7.50';
										$price_payment = '7.50';
									break;
									case ["5","3"]:
										$listing_price = $fl_sign.'8.75';
										$price_payment = '8.75';
									break;
									case ["5","4"]:
										$listing_price = $fl_sign.'10.00';
										$price_payment = '10.00';
									break;
									case ["5","5"]:
										$listing_price = $fl_sign.'11.25';
										$price_payment = '11.25';
									break;
									default:
										$fl_val = 1.50 * $featured_listing;
										$listing_price = $fl_sign.round($fl_val,2);
										$price_payment = round($fl_val,2);
								}

							}else{

								if($highlighted_listing != ''){
									$fl_val = 1.00 * $highlighted_listing;
									$listing_price = $fl_sign.round($fl_val,2);
									$price_payment = round($fl_val,2);
									/* Highlights != 0 && != '' and Featured is == 0 && == '' */
								}else{
									$listing_price = 'Free';
								}
							}
						}else if($featured_listing != 0){
							$fl_val = 1.50 * $featured_listing;
							$listing_price = $fl_sign.round($fl_val,2);
							$price_payment = round($fl_val,2);
							/* Highlights == 0 && == '' and Featured is != 0 && != '' */
						}else{
							$listing_price = 'Free';
						}

		    		}

	    		}

	    		if($listing_price != 'Free'){

	    			if($fl_sign == '£'){
	    				$currency = 'GBP';
	    			}else{
	    				$currency = 'USD';
	    			}

	    			if($highlighted_listing != 0 && $featured_listing == 0){
	    				if($highlighted_listing == 1){
	    					$description = 'Highlighted for '.$highlighted_listing.' weeks - '.$listing_price;
    					}else{
    						$description = 'Highlighted for '.$highlighted_listing.' week - '.$listing_price;
    					}
	                }elseif($highlighted_listing == 0 && $featured_listing != 0){
	                	if($highlighted_listing == 1){
	    					$description = 'Featured for '.$featured_listing.' weeks - '.$listing_price;
    					}else{
    						$description = 'Featured for '.$featured_listing.' week - '.$listing_price;
    					}
	                }else{
	                	if($highlighted_listing == 1 && $highlighted_listing == 1){
	                		$description = 'Featured for '.$featured_listing.' week, Highlighted for '.$highlighted_listing.' week - '.$listing_price;
	                	}elseif($highlighted_listing == 1 && $highlighted_listing != 1){
	                		$description = 'Featured for '.$featured_listing.' week, Highlighted for '.$highlighted_listing.' weeks - '.$listing_price;
	                	}elseif($highlighted_listing != 1 && $highlighted_listing == 1){
	                		$description = 'Featured for '.$featured_listing.' weeks, Highlighted for '.$highlighted_listing.' week - '.$listing_price;
	                	}else{
	                		$description = 'Featured for '.$featured_listing.' weeks, Highlighted for '.$highlighted_listing.' weeks - '.$listing_price;
	                	}
	                }

					$product = array(
						'Listing' => array('name' => 'Listing', 'desc' => $description, 'price' => $price_payment));
					//$currency = $paypal_currency; // currency for the transaction
					$ec_action = 'Sale'; // for PAYMENTREQUEST_0_PAYMENTACTION, it's either Sale, Order or Authorization


					$payment_id = $this->payment_model->listing_payment($id,$price_payment,$currency,$fl_sign,$description,$listing_id);

					$payment_session_id = array(
						'payment_session_id' => $payment_id,
						'payment_listing_id' => $listing_id,
						'listing_highlights_value' => $highlighted_listing,
						'listing_featured_value' => $featured_listing
					);
					$this->session->set_userdata($payment_session_id);

					$to_buy = array(
						'desc' => 'Breed Your Dog', 
						'currency' => $currency, 
						'type' => $ec_action, 
						'return_URL' => site_url('users/completed'), 
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
						
	    		}

	    		if($listing_price == 'Free'){

	    			if($highlighted_listing != 0 || $featured_listing != 0 ){
	    				$this->payment_model->listing_highlight_featured_edit($listing_id,$highlighted_listing,$featured_listing);
	    			}else{
	    				$this->payment_model->listing_highlight_featured_audits_edit($listing_id);
	    			}

		    	}

				$this->session->set_flashdata('flashdata_success', 'Listing Created');

				if($iploc['country'] == 'US - United States'){
					redirect('us/listings/yours');
				}else{
					redirect('listings/yours');
				}
				

			}

		}

		/*=====================================================
		[-- USERS STATISTICS ---------------------------------]
	    ======================================================*/
	    public function statistics(){
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

			$this->load->view('templates/header',$data);
			$this->load->view('users/pages/statistics',$data);
			$this->load->view('templates/footer',$data);
	    }

	    /*=====================================================
		[-- USERS STATISTICS VIEWS ---------------------------]
	    ======================================================*/
	    public function statistics_views($listing_id){
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

	    	$data['listing'] = $this->getdata_model->get_listing($listing_id);

			$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$this->load->view('templates/header',$data);
			$this->load->view('users/pages/statistics-view',$data);
			$this->load->view('templates/footer',$data);
	    }

	    /*=====================================================
		[-- USER CLOSE ACCOUNT -------------------------------]
	    ======================================================*/
	    public function close_account($id){
	    	$this->users_model->user_delete($id);

	    	$sub = $this->payment_model->get_subscription($id);


	    	if($sub){
	    		$this->paypal_recurring->change_subscription_status($sub['paypal_id'],'Cancel');
            	$this->users_model->user_change_plan_delete_user_id($id);
	    	}
	    	
	    	$this->session->unset_userdata('userlogged_in');
			$this->session->unset_userdata('user_id_byd');

	    	$this->session->set_flashdata('flashdata_info', 'Your account has been closed');
			$iploc = geoCheckIP($this->input->ip_address());
			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
			if($iploc['country'] == 'US - United States'){
				redirect(''.base_url('us').'');
			}else{
				redirect(''.base_url().'');
			}

	    }

	    /*===========================================================================
		[-- LISTING FEATURED & HIGHLIGHTS PAYMENT COMPLETED ------------------------]
	    ===========================================================================*/
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

					$this->payment_model->update_listing_payment($this->session->userdata('payment_session_id'),$get_ec_return['TOKEN'],$get_ec_return['PAYERID'],$do_ec_return['PAYMENTINFO_0_TRANSACTIONID'],$do_ec_return['PAYMENTINFO_0_FEEAMT'],$do_ec_return['PAYMENTINFO_0_PAYMENTSTATUS']);


					if($this->session->userdata('listing_featured_value') == ''){
						$featured_val = 0;
					}else{
						$featured_val = $this->session->userdata('listing_featured_value');
					}


					if($do_ec_return['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed'){
						$this->payment_model->listing_highlight_featured($this->session->userdata('payment_listing_id'),$this->session->userdata('listing_highlights_value'),$featured_val);
					}

					$this->session->set_flashdata('flashdata_success', 'Listing Created and Payment was successful');

					$iploc = geoCheckIP($this->input->ip_address());
    				$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
					if($iploc['country'] == 'US - United States'){
						redirect('us/listings/yours');
					}else{
						redirect('listings/yours');
					}

				} else {
					
					$iploc = geoCheckIP($this->input->ip_address());
    				$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
					if($iploc['country'] == 'US - United States'){
						redirect('us/user/dashboard');
					}else{
						redirect('user/dashboard');
					}

				}
			} else {
				
				$iploc = geoCheckIP($this->input->ip_address());
    			$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
				if($iploc['country'] == 'US - United States'){
					redirect('us/user/dashboard');
				}else{
					redirect('user/dashboard');
				}
					
			}

		}


		/*===========================================================================
		[-- CUSTOMIZE FORM VALIDATION ----------------------------------------------]
	    ===========================================================================*/

	    public function listing_description_validate($str){

	    	$regex = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/'; 

	    	$urlreg ='/(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,63}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?/';

	    	$numreg = '/[\+\(]{0,2}\d{1,4}[\.\-\s\(\)]*\d{1}[\.\-\s\(\)]*\d{1}[\.\-\s\(\)]*\d{1}[\.\-\s\(\)]*\d{1}[\.\-\s\(\)]*\d{1}[\.\-\s\(\)]*\d{1}/';

			if(preg_match($regex, $str, $email_is)){

				$this->form_validation->set_message('listing_description_validate', ' Appears to contain an email address - '.$email_is[0].', contact details must not be included in listings');
				return FALSE;

			}elseif(preg_match($urlreg, $str, $url_is)){

				$this->form_validation->set_message('listing_description_validate', ' Appears to contain an website address - '.$url_is[0].', contact details must not be included in listings');
				return FALSE;

			}elseif(preg_match($numreg , $str, $num_is)){

				$this->form_validation->set_message('listing_description_validate', ' Appears to contain an phone number - '.$num_is[0].', contact details must not be included in listings');
				return FALSE;

			}else{ 

				return TRUE;

				$userinfo = $this->users_model->checkinfo($this->session->userdata('user_id_byd'));

				if(stristr($str, $userinfo['first_name']) === FALSE && stristr($str, $userinfo['last_name']) === FALSE && stristr($str, $userinfo['email']) === FALSE && stristr($str, $userinfo['phone']) === FALSE && stristr($str, $userinfo['address']) === FALSE && stristr($str, $userinfo['post_code']) === FALSE && stristr($str, $userinfo['website']) === FALSE) {

					return TRUE;

				}else{
					 $this->form_validation->set_message('listing_description_validate', "It's Appears that you include your info in this listing, details must not be included in listings");
					return FALSE;
				}
				
			}

	    }

	}	
