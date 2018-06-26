<?php 
	Class Admin extends CI_Controller{

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

		public function index(){ 

			if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}else{

				$data['metatitle'] 			= 'Breed Your Dog Admin';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';

		    	$this->load->view('admin/templates/header',$data);
		    	$this->load->view('admin/pages/dashboard',$data);
		    	$this->load->view('admin/templates/footer',$data);
			}

	    }
	    
	    function show_404(){
			$data['metatitle']          = 'Breed Your Dog';
            $data['metakeyword']        = 'Page Not found';
            $data['metadescription']    = 'Page Not found';
            $data['metarobots']         = 'NOINDEX, NOFOLLOW';

            $this->load->view('templates/header',$data);
            $this->load->view('templates/page-not-found',$data);
            $this->load->view('templates/footer',$data);
		}
	    
	    public function login(){

	    	if(!$this->session->userdata('adminlogged_in')){
				
				$data['metatitle'] 			= 'Breed Your Dog Admin';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';

		    	$this->form_validation->set_rules('username', 'Username', 'required');
		    	$this->form_validation->set_rules('password', 'Password', 'required');

		    	if($this->form_validation->run() === FALSE){
		    		$this->load->view('admin/login',$data);
		    	}else{
		    		$username = $this->input->post('username');
		    		$password = $this->input->post('password');
		    		$admin_id = $this->admin_model->login($username, $password);

		    		if($admin_id){
						$admin_data = array(
							'admin_id_byd' => $admin_id,
							'adminusername_byd' => $username,
							'adminlogged_in' => true
						);
						$this->session->set_userdata($admin_data);
						$this->admin_model->adminlast_login($admin_id);
						$this->session->set_flashdata('flashdata_success', 'You are now Logged In');

						redirect('admin/dashboard');
					}else{
						$this->session->set_flashdata('flashdata_failed', 'Invallid Username or Password');

						redirect('admin/login');
					}
				}

			}else{
				redirect('admin/dashboard');
	    	}
	    }

	    public function logout(){
			$this->session->unset_userdata('adminlogged_in');
			$this->session->unset_userdata('user_id_byd');
			$this->session->unset_userdata('username_byd');

			$this->session->set_flashdata('flashdata_info', 'You have been Logged Out');
			redirect('admin/login');
		}

	    public function dashboard(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/dashboard',$data);
	    	$this->load->view('admin/templates/footer',$data);

	    }

	    /*=====================================================
		[-- USERS SEARCH -------------------------------------]
	    ======================================================*/
	    public function users_search(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/users/search';
			$config['total_rows'] = $this->admin_model->count_users();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['users'] = $this->admin_model->get_users($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/users-search',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- ALL USERS ----------------------------------------]
	    ======================================================*/
	    public function all_users(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/users';
			$config['total_rows'] = $this->admin_model->count_users();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['users'] = $this->admin_model->get_users($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/users-all',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }


	    /*============================================================
		[-- USERS SUBSCRIPTIONS -------------------------------------]
	    ============================================================*/
	    public function users_subscription(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/users/search';
			$config['total_rows'] = $this->admin_model->count_users_subscription();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['subscriptions'] = $this->admin_model->get_users_subscription($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/users-subscription',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- USER EDIT ----------------------------------------]
	    ======================================================*/
	    public function user_edit($id){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$data['userinformations'] = $this->users_model->user_info($id);	

  			foreach( $data['userinformations'] as $userinfo){
  				if($this->input->post('email') != $userinfo['email']) {
				   $is_unique_email =  '|is_unique[users.email]';
				} else {
				   $is_unique_email =  '';
				}
  			}
  			
  			foreach( $data['userinformations'] as $userinfo){

  				if($userinfo['email'] != '') {
					  $this->form_validation->set_rules('email', 'Email', 'required'.$is_unique_email.'|valid_email',
		    		array('is_unique' => 'email has already been taken','required' => "Email can't be blank"));
				}
				
  			}
	    	
	    	$this->form_validation->set_rules('country_id', 'Country', 'required|integer',
	    		array('integer' => "Country can't be blank"));
	    	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

	    	if($this->form_validation->run() === FALSE){
	    		

				$data['user'] = $this->getdata_model->get_user($id);

				$data['stud'] = $this->getdata_model->get_user_listings_stud($id); 

				$data['pup'] = $this->getdata_model->get_user_listings_puppies($id); 

				$data['mem'] = $this->getdata_model->get_user_listings_memorial($id); 

				$data['countries'] = $this->getdata_model->get_countries();	

		    	$this->load->view('admin/templates/header',$data);
		    	$this->load->view('admin/pages/user-edit',$data);
		    	$this->load->view('admin/templates/footer',$data);
	    	}else{


	    		if($this->input->post('suspended') == 'on'){

		    		$getsub = $this->payment_model->get_subscription($id);

		    		if(!empty($getsub)){

		    			$this->paypal_recurring->change_subscription_status($getsub['paypal_id'],'Cancel');

                        $this->users_model->user_change_plan_delete_user_id($id);

                        $this->admin_model->change_plan_suspended_banned($id);
		    		}
		    		
		    	}
	    		
	    		if($this->input->post('banned') == 'on'){

		    		$getsub = $this->payment_model->get_subscription($id);

		    		if(!empty($getpsub)){
		    			
		    			$this->paypal_recurring->change_subscription_status($getsub['paypal_id'],'Cancel');

                        $this->users_model->user_change_plan_delete_user_id($id);

                        $this->admin_model->change_plan_suspended_banned($id);
		    		}

		    	}

	    		$this->admin_model->user_update($id);
	    		$this->session->set_flashdata('flashdata_success', 'Successfully Update User');
				redirect('admin/users/search');
	    	}
	    }

	    /*=======================================================
		[-- USER CREATE NEW ------------------------------------]
	    =======================================================*/
	    public function user_new(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

	    	$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]|valid_email',
	    		array('is_unique' => 'email has already been taken','required' => "Email can't be blank")
	    	);

	    	$this->form_validation->set_rules('password', 'Password', 'required',
	    		array('required' => "Password can't be blank"));
	    	$this->form_validation->set_rules('country_id', 'Country', 'required|integer',
	    		array('integer' => "Country can't be blank"));
	    	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

	    	if($this->form_validation->run() === FALSE){

	    		$data['countries'] = $this->getdata_model->get_countries();	

		    	$this->load->view('admin/templates/header',$data);
		    	$this->load->view('admin/pages/user-new',$data);
		    	$this->load->view('admin/templates/footer',$data);
	    	}else{
	    		$this->admin_model->user_add();
	    		$this->session->set_flashdata('flashdata_success', 'Successfully Create New User');
				redirect('admin/users/search');
	    	}
	    }

	    /*=======================================================
		[-- USER WITH MANY LISTINGS ----------------------------]
	    =======================================================*/
	    public function users_with_many_listings(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			if($this->input->get('number_of', TRUE) != ''){

			$config['base_url'] = base_url() . 'admin/users/with-many-listings';
			$config['total_rows'] = $this->admin_model->count_users_with_many_listings();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);

			}


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			if($this->input->get('number_of', TRUE) != ''){

				$data['users'] = $this->admin_model->users_with_many_listings($config['per_page'], $offset);

			}

	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/users-with-many-listings',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }


	    /*=======================================================
		[-- USER DELETE ----------------------------------------]
	    =======================================================*/
	    public function user_delete($id){

	    	$this->admin_model->user_delete($id);
	    	$this->session->set_flashdata('flashdata_danger', 'User Deleted');
	    	redirect('admin/users/search');

	    }

	    /*=======================================================
		[-- USER UNDELETE ----------------------------------------]
	    =======================================================*/
	    public function user_un_delete($id){

	    	$this->admin_model->user_un_delete($id);
	    	$this->session->set_flashdata('flashdata_success', 'User Un Deleted');
	    	redirect('admin/users/search');

	    }

	    /*=====================================================
		[-- USERS SEARCH LOGIN AS USERS ----------------------]
	    ======================================================*/
	    public function users_login_as_user($id){

	    	$user = $this->getdata_model->get_user($id);

    		$users_login_as = $this->users_model->userlogin_as($id);



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

					redirect('user/dashboard');

    			}
    			

			}else{
				$this->session->set_flashdata('flashdata_failed', 'Invallid Email or Password');
				redirect(''.base_url().'');
			}

	    }

	    /*=====================================================
		[-- USER BULK EMAIL ----------------------------------]
	    ======================================================*/
	    public function user_bulk_email(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$data['users'] = $this->admin_model->get_users_send_bulk();

			$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/users-bulk-email',$data);
	    	$this->load->view('admin/templates/footer',$data);

	    }


	    /*=====================================================
		[-- USER BULK EMAIL ----------------------------------]
	    ======================================================*/
	    public function user_send_to(){

	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$data['users'] = $this->admin_model->get_users_send_bulk();

			if($this->input->get('sent_to_email', TRUE) != '' && $this->input->get('subject', TRUE) != '' && $this->input->get('html-message', TRUE) != ''){

				$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';

				$this->email->initialize($config);


				$emailstring = $this->input->get('sent_to_email', TRUE);
				$list = explode(',', $emailstring);

				foreach ($list as $name => $address)
				{
			        $this->email->clear();

			        $this->email->to($address);
			       	/*$this->email->from('no-reply@breedyourdog.com');*/
					$this->email->from('byd@breedyourdog.com');
					/*$this->email->cc('rj@page1europe.eu');*/
					$this->email->bcc('byd@breedyourdog.com');

					$this->email->subject($this->input->get('subject', TRUE));

					$this->email->message('
						<!DOCTYPE html>
							<html>
							<head>
								<title>Welcome to Breed Your Dog</title>
							</head>
							<body>
								'.$this->input->get('html-message', TRUE).'
							</body>
							</html>
						');
					$this->email->send();
				}

				$this->session->set_flashdata('flashdata_success', 'Successfully Bulk Email Sent');
				redirect('admin/users/bulk_email');
			}
	    
	    	$this->form_validation->set_rules('sent_to_email', 'Email', 'required',
	    		array('required' => "Send to email can't be blank"));

	    	$this->form_validation->set_rules('subject', 'Subject', 'required',
	    		array('required' => "Subject can't be blank"));
	    	
	    	$this->form_validation->set_rules('html-message', 'HTML Message', 'required',
	    		array('required' => "HTML Content can't be blank"));
	    	
	    	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

	    	if($this->form_validation->run() === FALSE){

		    	$this->load->view('admin/templates/header',$data);
		    	$this->load->view('admin/pages/users-send-to',$data);
		    	$this->load->view('admin/templates/footer',$data);

		    }else{

		    	$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';

				$this->email->initialize($config);

				$emailstring = $this->input->post('sent_to_email', TRUE);
				$list = explode(',', $emailstring);

				foreach ($list as $name => $address)
				{
			        $this->email->clear();

			        $this->email->to($address);
			       	/*$this->email->from('no-reply@breedyourdog.com');*/
					$this->email->from('byd@breedyourdog.com');
					/*$this->email->cc('rj@page1europe.eu');*/
					$this->email->bcc('byd@breedyourdog.com');

					$this->email->subject($this->input->post('subject', TRUE));

					$this->email->message('
						<!DOCTYPE html>
							<html>
							<head>
								<title>Welcome to Breed Your Dog</title>
							</head>
							<body>
								'.$this->input->post('html-message', TRUE).'
							</body>
							</html>
						');
					$this->email->send();
				}

				$this->session->set_flashdata('flashdata_success', 'Successfully Bulk Email Sent');
				redirect('admin/users/bulk_email');

		    }
	    }

	    /*=====================================================
		[-- SEARCH LISTINGS ----------------------------------]
	    ======================================================*/
	    public function listings_search(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/listings/search';
			$config['total_rows'] = $this->admin_model->count_listings();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['listings'] = $this->admin_model->get_listings($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/listings-search',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- LISTINGS EDIT ------------------------------------]
	    ======================================================*/
	    public function listing_edit($id){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}
	    	
	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$data['listing'] = $this->getdata_model->get_user_listing_row($id);
			$data['user'] = $this->getdata_model->get_user($data['listing']['user_id']);
			$data['countries'] = $this->getdata_model->get_countries(); 
			$data['breeds'] = $this->getdata_model->get_breeds();


			$this->form_validation->set_rules('title', 'Listing Tilte', 'required');
			
			if($data['listing']['listing_type'] != 'pup'){
	    		$this->form_validation->set_rules('name', 'Dog name', 'required');
	    		$this->form_validation->set_rules('gender', 'Gender', 'required');
	    	}
			$this->form_validation->set_rules('breed_id', 'Breed', 'required');
			$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');
			$this->form_validation->set_rules('country_id', 'Country', 'required');
			$this->form_validation->set_rules('region', 'Region', 'required');
			$this->form_validation->set_rules('post_code', 'Post / Zip Code', 'required');

			if($this->form_validation->run() == FALSE){
				
		    	$this->load->view('admin/templates/header',$data);
		    	$this->load->view('admin/pages/listing-edit',$data);
		    	$this->load->view('admin/templates/footer',$data);

			}else{

				$this->admin_model->update_listing($id);

				$checkremove = $this->input->post('checkbox_remove[]');

				$checkr = 1;

				for($imgr = 0; $imgr < count($checkremove); $imgr++){

					$this->admin_model->delete_listing_images($checkremove[$imgr]);

					$path = './uploads/listing_images/'.$id.'/'.$checkremove[$imgr];
					
					if (!is_dir($path)){
					}else{
						delete_files($path);
					}
		
					$checkr++;
				}	

				if(!empty($_FILES['upload_images']['name'][0])){

					$this->load->library('image_lib');

	               	$_FILES['file[]']['name']     = $_FILES['upload_images']['name'][0];
	                $_FILES['file[]']['type']     = $_FILES['upload_images']['type'][0];
	                $_FILES['file[]']['tmp_name'] = $_FILES['upload_images']['tmp_name'][0];
	                $_FILES['file[]']['error']    = $_FILES['upload_images']['error'][0];
	                $_FILES['file[]']['size']     = $_FILES['upload_images']['size'][0]; 

	                $string_image = $_FILES['file[]']['name'];
					$new_string_image = pathinfo($string_image, PATHINFO_FILENAME) . '.' . strtolower(pathinfo($string_image, PATHINFO_EXTENSION));

	                $listing_image = strtr($new_string_image,' ','_');

	               	$listing_images_id =  $this->admin_model->listing_images($id,$listing_image,$img_num = 0);
	                
	                $path = "./uploads/listing_images/".$id."/".$listing_images_id;
		    		if (!is_dir($path)){
			    		mkdir($path,0755,TRUE);
			    	}

		    		$config['upload_path'] = './uploads/listing_images/'.$id.'/'.$listing_images_id;
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
		            'source_image'      => './uploads/listing_images/'.$id.'/'.$listing_images_id.'/'.$listing_image,
		            'new_image'         => './uploads/listing_images/'.$id.'/'.$listing_images_id.'/thumb_'.$listing_image,
		            'maintain_ration'   => true,
		            'overwrite'         => true,
		            'file_ext_tolower'  => true,
		            'quality'			=> '40%',
		            'width'             => 400,
		            'height'            => 300
		            );

		            $this->image_lib->initialize($config);
		            $this->image_lib->resize();
		            $this->image_lib->clear();

		            $config = array(
				        'source_image'      => './uploads/listing_images/'.$id.'/'.$listing_images_id.'/'.$listing_image,
				        'new_image'         => './uploads/listing_images/'.$id.'/'.$listing_images_id.'/thumb_small_'.$listing_image,
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
					$config['source_image'] = 'uploads/listing_images/'.$id.'/'.$listing_images_id.'/'.$listing_image;
					$config['new_image'] = 'uploads/listing_images/'.$id.'/'.$listing_images_id.'/big_'.$listing_image;
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

				$allimages = $this->users_model->get_listing_images_fixed_sort($id);

		        $sortimg = 1;
				foreach($allimages as $allimg){

					$img_id = $allimg['id'];
					$sort = $sortimg;
					$this->users_model->listing_images_sort($img_id,$sort);

					$sortimg++;

				}

				$this->session->set_flashdata('flashdata_success', 'Successfully Update Listing');
				redirect('admin/listings/search');

			}
	    }

	    /*=====================================================
		[-- LISTINGS STATISTICS ------------------------------]
	    ======================================================*/
	    public function listing_statistics($id){

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$data['listing'] = $this->getdata_model->get_user_listing_row($id);

			$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/listings-statistic',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }


	    /*=====================================================
		[-- LISTINGS ALL --------------------------------------]
	    ======================================================*/
	    public function listings_all(){	    
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/listings/search';
			$config['total_rows'] = $this->admin_model->count_listings();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['listings'] = $this->admin_model->get_listings($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/listings-all',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- LISTINGS CHECK ------------------------------------]
	    ======================================================*/
	    public function listings_check(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/listings/check';
			$config['total_rows'] = $this->admin_model->count_listings_check();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['listings'] = $this->admin_model->get_listings_check($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/listings-check',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- LISTINGS ALL DOGS ----------------------------------]
	    ======================================================*/
	    public function listings_dogs(){	    
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/listings/dogs';
			$config['total_rows'] = $this->admin_model->count_listings_dog();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['listings'] = $this->admin_model->get_listings_dog($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/listings-dog',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- LISTINGS ALL PUPPIES -----------------------------]
	    ======================================================*/
	    public function listings_puppies(){	    
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/listings/puppies';
			$config['total_rows'] = $this->admin_model->count_listings_pup();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['listings'] = $this->admin_model->get_listings_pup($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/listings-pup',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- LISTINGS ALL MEMORIALS ---------------------------]
	    ======================================================*/
	    public function listings_memorials(){	    
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/listings/memorials';
			$config['total_rows'] = $this->admin_model->count_listings_mem();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['listings'] = $this->admin_model->get_listings_mem($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/listings-mem',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }


	    /*=======================================================
		[-- LISTING DELETE -------------------------------------]
	    =======================================================*/
	    public function listing_delete($id){

	    	$this->admin_model->listing_delete($id);
	    	$this->session->set_flashdata('flashdata_danger', 'Listing Deleted');
	    	redirect('admin/listings/search');

	    }

	    /*=======================================================
		[-- LISTING UNDELETE -----------------------------------]
	    =======================================================*/
	    public function listing_un_delete($id){

	    	$this->admin_model->listing_un_delete($id);
	    	$this->session->set_flashdata('flashdata_success', 'Listing Un Deleted');
	    	redirect('admin/listings/search');

	    }

	    
	    /*=====================================================
		[-- CONNECTION ALL -----------------------------------]
	    ======================================================*/
	    public function connections_all(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/connections';
			$config['total_rows'] = $this->admin_model->count_connections();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['connections'] = $this->admin_model->get_connections($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/connections-all',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }


	    /*=====================================================
		[-- SEARCH CONNECTIONS -------------------------------]
	    ======================================================*/
	    public function connections_search(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/connections/search';
			$config['total_rows'] = $this->admin_model->count_connections();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['connections'] = $this->admin_model->get_connections($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/connections-search',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- CONNECTION VIEW ----------------------------------]
	    ======================================================*/

	    public function connection_view($id){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}
	    	
	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$data['connect'] = $this->getdata_model->get_connections($id);
		
	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/connections-view',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- CONNECTION UPDATE ----------------------------------]
	    ======================================================*/

	    public function connections_update($id){

	    	$this->admin_model->connection_update($id);

	    	$this->session->set_flashdata('flashdata_success', 'Successfully Update Notes');
			redirect('admin/connections');

	    }


	    /*=====================================================
		[-- BREEDS -------------------------------------------]
	    ======================================================*/
	    public function all_breeds(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 10;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/breeds';
			$config['total_rows'] = $this->admin_model->count_breeds();
			$config['per_page'] = 10;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;
			$this->pagination->initialize($config);


			$data['breeds'] = $this->admin_model->get_breeds($config['per_page'], $offset);

			$data['kennels'] = $this->getdata_model->get_kennelclub();

			$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/breeds-all',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- NEW BREEDS ---------------------------------------]
	    ======================================================*/

	    public function new_breed(){
	    	if(!$this->session->userdata('adminlogged_in')){
	    		redirect('admin/login');
	    	}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$this->form_validation->set_rules('breed_name', 'Breeds', 'required|is_unique[breeds.name]',
	    		array('is_unique' => 'has already been taken')
	    	);
			$this->form_validation->set_rules('kennel_club_group', 'Kennel Club Group', 'required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    	
			if($this->form_validation->run() === FALSE){

				$data['kennels'] = $this->getdata_model->get_kennelclub();

		    	$this->load->view('admin/templates/header',$data);
		    	$this->load->view('admin/pages/breeds-new',$data);
		    	$this->load->view('admin/templates/footer',$data);

		    }else{

		    	$id = $this->admin_model->add_breed();

		    	$path = "./uploads/breeds/".$id;
			    if (!is_dir($path)){
		    		mkdir($path,0755,TRUE);
		    	}
			 
		    	$config['upload_path'] = './uploads/breeds/'.$id;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				/*$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';*/
				$config['max_size'] = '99999999';
				$config['max_width'] = '2000000';
				$config['max_height'] = '2000000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors = array('error' => $this->upload->display_errors());
					$breed_image = '';

				} else {
					$data = array('upload_data' => $this->upload->data());
					$breed_image = strtr($_FILES['userfile']['name'],' ','_');

				}

				$this->admin_model->add_breed_image($breed_image,$id);


				$this->load->library('image_lib');

				$config = array(
	            'source_image'      => './uploads/breeds/'.$id.'/'.$breed_image,
	            'new_image'         => './uploads/breeds/'.$id.'/thumb_'.$breed_image,
	            'maintain_ration'   => true,
	            'overwrite'         => true,
	            'file_ext_tolower'  => true,
	            'quality'			=> '40%',
	            'width'             => 400,
	            'height'            => 300
	            );

	            $this->image_lib->initialize($config);
	            $this->image_lib->resize();
	            $this->image_lib->clear();

		    	$this->session->set_flashdata('flashdata_success', 'Successfully Add New Breed');
				redirect('admin/breeds');
		    }
	    }

	    /*=====================================================
		[-- EDIT BREEDS --------------------------------------]
	    ======================================================*/

	    public function breed_edit($id){
	    	if(!$this->session->userdata('adminlogged_in')){
	    		redirect('admin/login');
	    	}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$data['breededit'] = $this->admin_model->get_edit_breed_unique($id);

			if($this->input->post('breed_name') != $data['breededit']['name']) {
				$is_breed_name =  '|is_unique[breeds.name]';
			} else {
				$is_breed_name  =  '';
			}

			$this->form_validation->set_rules('breed_name', 'Breeds', 'required'.$is_breed_name,
	    		array('is_unique' => 'has already been taken')

	    	);

			$this->form_validation->set_rules('kennel_club_group', 'Kennel Club Group', 'required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    	
			if($this->form_validation->run() === FALSE){

				$data['kennels'] = $this->getdata_model->get_kennelclub();
				$data['breeds'] = $this->admin_model->get_breeds_id($id);

		    	$this->load->view('admin/templates/header',$data);
		    	$this->load->view('admin/pages/breeds-edit',$data);
		    	$this->load->view('admin/templates/footer',$data);

		    }else{

		    	$path = "./uploads/breeds/".$data['breededit']['id'];
		    	if (!is_dir($path)){
		    		mkdir($path,0755,TRUE);
		    	}

		    	$config['upload_path'] = './uploads/breeds/'.$data['breededit']['id'];
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '99999999';
				$config['max_width'] = '2000000';
				$config['max_height'] = '2000000';

				$this->load->library('upload', $config);

				if($this->input->post('remove_image') == '' && $_FILES['userfile']['name'] != ''){

					if($_FILES['userfile']['name'] != ''){

						if(!$this->upload->do_upload()){
							$errors = array('error' => $this->upload->display_errors());
							$breed_image = '';

						} else {
							$data = array('upload_data' => $this->upload->data());
							$breed_image = strtr($_FILES['userfile']['name'],' ','_');
						}
					}else{
						$breed_image = $data['breededit']['image'];
					}

				}else{
					
					$breed_image = '';

					$path = './uploads/breeds/'.$id;
				
					if (!is_dir($path)){
					}else{
						delete_files($path);
					}

				}

		    	$this->admin_model->update_breed($breed_image,$id);

		    	$this->load->library('image_lib');

				$config = array(
	            'source_image'      => './uploads/breeds/'.$id.'/'.$breed_image,
	            'new_image'         => './uploads/breeds/'.$id.'/thumb_'.$breed_image,
	            'maintain_ration'   => true,
	            'overwrite'         => true,
	            'file_ext_tolower'  => true,
	            'quality'			=> '40%',
	            'width'             => 400,
	            'height'            => 300
	            );

	            $this->image_lib->initialize($config);
	            $this->image_lib->resize();
	            $this->image_lib->clear();

		    	$this->session->set_flashdata('flashdata_success', 'Successfully Edit Breed with name of '.$data['breededit']['name']);
				redirect('admin/breeds');
		    }
	    }

	    /*=====================================================
		[-- DELETE BREEDS ------------------------------------]
	    ======================================================*/

	    public function breed_delete($id){
			if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$this->admin_model->delete_breed($id);
			$this->session->set_flashdata('flashdata_danger', 'Breed has been deleted');
			redirect('admin/breeds');
		}

	    /*=====================================================
		[-- PAGES --------------------------------------------]
	    ======================================================*/

	    public function pages_all(){
	    	if(!$this->session->userdata('adminlogged_in')){
	    		redirect('admin/login');
	    	}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

	    	$data['pages'] = $this->getdata_model->get_pages();

	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/pages-all',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- EDIT PAGES ---------------------------------------]
	    ======================================================*/

	    public function page_edit($id){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

	    		$data['pagesedits'] = $this->admin_model->get_edit_page($id);

	    		if(empty($data['pagesedits'])){
					show_404();
				}

				$data['metatitle'] 			= 'Breed Your Dog Admin';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';

				$this->form_validation->set_rules('page_title', 'Page Title', 'required');
		    	$this->form_validation->set_rules('page_url', 'Page Url', 'required');
		    	$this->form_validation->set_rules('page_template', 'Page Template', 'required');
		    	$this->form_validation->set_rules('page_language', 'Page Languange', 'required');

		    	if($this->form_validation->run() === FALSE){
		    		$this->load->view('admin/templates/header',$data);
			    	$this->load->view('admin/pages/pages-edit',$data);
			    	$this->load->view('admin/templates/footer',$data);
		    	}else{
		    		$this->admin_model->page_update($id);

		    		$this->session->set_flashdata('flashdata_success', 'Successfully Edit Page with ID of '.$id);

					redirect('admin/pages');
		    	}
	    }

	    /*=====================================================
		[-- DELETE PAGES -------------------------------------]
	    ======================================================*/

	    public function page_delete($id){
			if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$this->admin_model->delete_page($id);
			$this->session->set_flashdata('flashdata_danger', 'Page has been deleted');
			redirect('admin/pages');
		}


		/*=====================================================
		[-- NEW PAGES -----------------------------------------]
	    ======================================================*/

	    public function pages_new(){
	    	if(!$this->session->userdata('adminlogged_in')){
	    		redirect('admin/login');
	    	}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

	    	$this->form_validation->set_rules('page_title', 'Page Title', 'required');
	    	$this->form_validation->set_rules('page_url', 'Page Url', 'required');
	    	$this->form_validation->set_rules('page_template', 'Page Template', 'required');
	    	$this->form_validation->set_rules('page_language', 'Page Languange', 'required');

	    	if($this->form_validation->run() === FALSE){
	    		$this->load->view('admin/templates/header',$data);
		    	$this->load->view('admin/pages/pages-new',$data);
		    	$this->load->view('admin/templates/footer',$data);
	    	}else{
	    		$this->admin_model->page_add_new();

	    		$this->session->set_flashdata('flashdata_success', 'Successfully Add New Page');

				redirect('admin/pages');
	    	}
	    	
	    }

	    /*=====================================================
		[-- ORDERS -------------------------------------------]
	    ======================================================*/
	    public function all_orders(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/orders';
			$config['total_rows'] = $this->admin_model->count_orders();
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';
	    	
	    	$data['orders'] = $this->admin_model->get_orders($config['per_page'], $offset);

	    	$this->load->view('admin/templates/header',$data);
    		$this->load->view('admin/pages/orders',$data);
    		$this->load->view('admin/templates/footer',$data);
	    }


	    /*=====================================================
		[-- ORDERS VIEW --------------------------------------]
	    ======================================================*/
	    public function order_view($id){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';
	    	
	    	$data['order'] = $this->admin_model->get_order_view($id);

	    	$this->load->view('admin/templates/header',$data);
    		$this->load->view('admin/pages/order_view',$data);
    		$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- ADMINS -------------------------------------------]
	    ======================================================*/

	    public function admin_all(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';
	    	
	    	$data['admins'] = $this->getdata_model->get_admins();

	    	$this->load->view('admin/templates/header',$data);
    		$this->load->view('admin/pages/admin-all',$data);
    		$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- DELETE ADMINS ------------------------------------]
	    ======================================================*/

	    public function admin_delete($id){
			if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$this->admin_model->delete_admin($id);
			$this->session->set_flashdata('flashdata_danger', 'Admin has been deleted');
			redirect('admin/admins');
		}

		/*=====================================================
		[-- EDIT ADMINS --------------------------------------]
	    ======================================================*/

		public function admin_edit($id){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$data['adminedits'] = $this->admin_model->get_edit_admin_unique($id);

			if($this->input->post('admin_username') != $data['adminedits']['username']) {
			   $is_unique_admin =  '|is_unique[admins.username]';
			} else {
			   $is_unique_admin =  '';
			}

			if($this->input->post('admin_email') != $data['adminedits']['email']) {
			   $is_unique_email =  '|is_unique[admins.email]';
			} else {
			   $is_unique_email =  '';
			}

	    	$this->form_validation->set_rules('admin_username', 'Username', 'required'.$is_unique_admin,
	    		array('is_unique' => 'has already been taken')
	    	);
	    	$this->form_validation->set_rules('admin_password', 'Password', 'required');
	    	$this->form_validation->set_rules('admin_email', 'Email', 'required'.$is_unique_email.'|valid_email',
	    		array('is_unique' => 'has already been taken')
	    	);
	    	$this->form_validation->set_rules('admin_name', 'Name', 'required');
	    	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

	    	if($this->form_validation->run() === FALSE){

	    		
	    		$data['metatitle'] 			= 'Breed Your Dog Admin';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';
	    		
	    		$data['adminedits'] = $this->admin_model->get_edit_admin($id);

				$this->load->view('admin/templates/header',$data);
	    		$this->load->view('admin/pages/admin-edit',$data);
	    		$this->load->view('admin/templates/footer',$data);
			}else{
				
				$hash_password = hash('sha512', $this->input->post('admin_password'));

				$this->admin_model->admin_update($hash_password, $id);

				$this->session->set_flashdata('flashdata_success', 'Successfully  Edit Admin with ID of '.$id);

				redirect('admin/admins');
			}
	    }

	    /*=====================================================
		[-- NEW ADMINS ---------------------------------------]
	    ======================================================*/

	    public function admin_new(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

	    	$this->form_validation->set_rules('admin_username', 'Username', 'required|is_unique[admins.username]',
	    		array('is_unique' => 'has already been taken')
	    	);
	    	$this->form_validation->set_rules('admin_password', 'Password', 'required');
	    	$this->form_validation->set_rules('admin_email', 'Email', 'required|is_unique[admins.email]|valid_email',
	    		array('is_unique' => 'has already been taken')
	    	);
	    	$this->form_validation->set_rules('admin_name', 'Name', 'required');
	    	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

	    	if($this->form_validation->run() === FALSE){
				$this->load->view('admin/templates/header',$data);
	    		$this->load->view('admin/pages/admin-new',$data);
	    		$this->load->view('admin/templates/footer',$data);
			}else{

				$hash_password = hash('sha512', $this->input->post('admin_password'));

				$this->admin_model->admin_new($hash_password);

				$this->session->set_flashdata('flashdata_success', 'Successfully Add New Admin');

				redirect('admin/admins');
			}
	    }

	    /*=====================================================
		[-- IMAGES ALL ---------------------------------------]
	    ======================================================*/
	    public function images_all(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 100;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/images';
			$config['total_rows'] = $this->admin_model->count_images();
			$config['per_page'] = 100;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['images'] = $this->admin_model->get_images($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/images-all',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- IMAGES ALL ---------------------------------------]
	    ======================================================*/
	    public function images_on_homepage(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 100;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/images/homepage';
			$config['total_rows'] = $this->admin_model->count_images_on_homepage();
			$config['per_page'] = 100;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['images'] = $this->admin_model->get_images_on_homepage($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/images-on-homepage',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }

	    /*=====================================================
		[-- SEARCH LISTINGS ----------------------------------]
	    ======================================================*/
	    public function images_search(){
	    	if(!$this->session->userdata('adminlogged_in')){
				redirect('admin/login');
			}

			$offset = $this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 100;
			}else{
				$offset = 0;
			}

			$config['base_url'] = base_url() . 'admin/images/search';
			$config['total_rows'] = $this->admin_model->count_images_search();
			$config['per_page'] = 100;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);


	    	$data['metatitle'] 			= 'Breed Your Dog Admin';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';


			$data['images'] = $this->admin_model->get_images_search($config['per_page'], $offset);


	    	$this->load->view('admin/templates/header',$data);
	    	$this->load->view('admin/pages/images-search',$data);
	    	$this->load->view('admin/templates/footer',$data);
	    }


	    /*=====================================================
		[-- IMAGES SAVE HOME ---------------------------------]
	    ======================================================*/
	    public function images_home_save($id){

	    	$this->admin_model->image_save_on_home($id);
	    	$this->session->set_flashdata('flashdata_success', 'Successfully Update');
			redirect('admin/images');

	    }


	    /*=====================================================
		[-- IMAGES ROTATE ---------------------------------]
	    ======================================================*/
	    public function images_rotate($id,$direction){
	   
	    	$images = $this->getdata_model->get_listing_images($id);

	    	// File and rotation
			$rotateFilename = './uploads/listing_images/'.$images['listing_id'].'/'.$images['id'].'/thumb_'.$images['image']; // PATH
			if($direction == 'left'){
				$degrees = 90;
			}else{
				$degrees = -90;
			}
			
			$fileType = strtolower(substr('thumb_'.$images['image'], strrpos('thumb_'.$images['image'], '.') + 1));

			if($fileType == 'png' || $fileType == 'PNG'){
			   header('Content-type: image/png');
			   $source = imagecreatefrompng($rotateFilename);
			   $bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, $bgColor);
			   imagesavealpha($rotate, true);
			   imagepng($rotate,$rotateFilename);

			}

			if($fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'JPG' || $fileType == 'JPEG'){
			   header('Content-type: image/jpeg');
			   $source = @imagecreatefromjpeg($rotateFilename);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, 0);
			   imagejpeg($rotate,$rotateFilename);
			}

			// Free the memory
			imagedestroy($source);
			imagedestroy($rotate);

			// File and rotation
			$rotateFilename = './uploads/listing_images/'.$images['listing_id'].'/'.$images['id'].'/big_'.$images['image']; // PATH
			if($direction == 'left'){
				$degrees = 90;
			}else{
				$degrees = -90;
			}
			
			$fileType = strtolower(substr('big_'.$images['image'], strrpos('big_'.$images['image'], '.') + 1));

			if($fileType == 'png' || $fileType == 'PNG'){
			   header('Content-type: image/png');
			   $source = imagecreatefrompng($rotateFilename);
			   $bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, $bgColor);
			   imagesavealpha($rotate, true);
			   imagepng($rotate,$rotateFilename);

			}

			if($fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'JPG' || $fileType == 'JPEG'){
			   header('Content-type: image/jpeg');
			   $source = @imagecreatefromjpeg($rotateFilename);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, 0);
			   imagejpeg($rotate,$rotateFilename);
			}

			// Free the memory
			imagedestroy($source);
			imagedestroy($rotate);



			$rotateFilename = './uploads/listing_images/'.$images['listing_id'].'/'.$images['id'].'/thumb_small_'.$images['image']; // PATH
			if($direction == 'left'){
				$degrees = 90;
			}else{
				$degrees = -90;
			}
			
			$fileType = strtolower(substr('thumb_small_'.$images['image'], strrpos('thumb_small_'.$images['image'], '.') + 1));

			if($fileType == 'png' || $fileType == 'PNG'){
			   header('Content-type: image/png');
			   $source = imagecreatefrompng($rotateFilename);
			   $bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, $bgColor);
			   imagesavealpha($rotate, true);
			   imagepng($rotate,$rotateFilename);

			}

			if($fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'JPG' || $fileType == 'JPEG'){
			   header('Content-type: image/jpeg');
			   $source = @imagecreatefromjpeg($rotateFilename);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, 0);
			   imagejpeg($rotate,$rotateFilename);
			}

			// Free the memory
			imagedestroy($source);
			imagedestroy($rotate);

			// File and rotation
			$rotateFilename = './uploads/listing_images/'.$images['listing_id'].'/'.$images['id'].'/'.$images['image']; // PATH
			if($direction == 'left'){
				$degrees = 90;
			}else{
				$degrees = -90;
			}
			
			$fileType = strtolower(substr($images['image'], strrpos($images['image'], '.') + 1));

			if($fileType == 'png' || $fileType == 'PNG'){
			   header('Content-type: image/png');
			   $source = imagecreatefrompng($rotateFilename);
			   $bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, $bgColor);
			   imagesavealpha($rotate, true);
			   imagepng($rotate,$rotateFilename);

			}

			if($fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'JPG' || $fileType == 'JPEG'){
			   header('Content-type: image/jpeg');
			   $source = @imagecreatefromjpeg($rotateFilename);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, 0);
			   imagejpeg($rotate,$rotateFilename);
			}

			// Free the memory
			imagedestroy($source);
			imagedestroy($rotate);


			echo $this->input->post('images_rotate').uniqid();

			//$this->session->set_flashdata('flashdata_success', 'Successfully Update');
			//redirect('admin/images');

	    }

	    /*=====================================================
		[-- IMAGES ROTATE ------------------------------------]
	    ======================================================*/
	    public function images_rotate_on_homepage($id,$direction){

	    	$images = $this->getdata_model->get_listing_images($id);

	    	// File and rotation
			$rotateFilename = './uploads/listing_images/'.$images['listing_id'].'/'.$images['id'].'/thumb_small_'.$images['image']; // PATH
			if($direction == 'left'){
				$degrees = 90;
			}else{
				$degrees = -90;
			}
			
			$fileType = strtolower(substr('thumb_small_'.$images['image'], strrpos('thumb_small_'.$images['image'], '.') + 1));

			if($fileType == 'png' || $fileType == 'PNG'){
			   header('Content-type: image/png');
			   $source = imagecreatefrompng($rotateFilename);
			   $bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, $bgColor);
			   imagesavealpha($rotate, true);
			   imagepng($rotate,$rotateFilename);

			}

			if($fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'JPG' || $fileType == 'JPEG'){
			   header('Content-type: image/jpeg');
			   $source = @imagecreatefromjpeg($rotateFilename);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, 0);
			   imagejpeg($rotate,$rotateFilename);
			}

			// Free the memory
			imagedestroy($source);
			imagedestroy($rotate);

			// File and rotation
			$rotateFilename = './uploads/listing_images/'.$images['listing_id'].'/'.$images['id'].'/'.$images['image']; // PATH
			if($direction == 'left'){
				$degrees = 90;
			}else{
				$degrees = -90;
			}
			
			$fileType = strtolower(substr($images['image'], strrpos($images['image'], '.') + 1));

			if($fileType == 'png' || $fileType == 'PNG'){
			   header('Content-type: image/png');
			   $source = imagecreatefrompng($rotateFilename);
			   $bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, $bgColor);
			   imagesavealpha($rotate, true);
			   imagepng($rotate,$rotateFilename);

			}

			if($fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'JPG' || $fileType == 'JPEG'){
			   header('Content-type: image/jpeg');
			   $source = @imagecreatefromjpeg($rotateFilename);
			   // Rotate
			   $rotate = imagerotate($source, $degrees, 0);
			   imagejpeg($rotate,$rotateFilename);
			}

			// Free the memory
			imagedestroy($source);
			imagedestroy($rotate);

			$this->session->set_flashdata('flashdata_success', 'Successfully Update');
			redirect('admin/images/homepage');

	    }


	}