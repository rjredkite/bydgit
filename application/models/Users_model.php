<?php 
	class Users_model extends CI_Model{

		/*=====================================================
		[-- USERS --------------------------------------------]
	    ======================================================*/

	    public function users(){
			$query = $this->db->get('users');
			return $query->result_array();
		}

		public function users_remove(){
			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);
			$query = $this->db->get('users');
			return $query->num_rows();
		}

		public function checkinfo($id){
			$query = $this->db->get_where('users', array('id' => $id));
			return $query->row_array();
		}

		public function user_info($id){
			$query = $this->db->get_where('users', array('id' => $id));
			return $query->result_array();
		}

		/*=====================================================
		[-- USERS NEW -----------------------------------------]
	    ======================================================*/
		public function users_new($hash_password,$confirmcode){
			date_default_timezone_set("Europe/London");
			if($this->input->post('newsletter') != ''){
	    		$newsletter = 1;
	    		$newsletter_txt = 'true';
	    	}else{
	    		$newsletter = 0;
	    		$newsletter_txt = 'false';
	    	}

			/*$data = array(
				
				'email'			=> $this->input->post('email'),
				'password_hash'	=> $hash_password,
				'country_id'	=> 1,
				'plan_id'		=> 1,
				'newsletter'	=> $newsletter,
				'created_at'	=> date('Y-m-d H:i:s'),
				'ip'			=> $this->input->ip_address(),
				'confirm_code'	=> $confirmcode

			);*/

			$data = array(
				
				'email'			=> $this->input->post('email'),
				'password_hash'	=> $hash_password,
				'country_id'	=> 1,
				'plan_id'		=> 1,
				'newsletter'	=> $newsletter,
				'created_at'	=> date('Y-m-d H:i:s'),
				'ip'			=> $this->input->ip_address()

			);

			$this->db->insert('users', $data);
			$user_new_id = $this->db->insert_id();


			$auditable_changes = "---\r\n first_name: \r\n last_name: \r\n username: \r\n email: ".$this->input->post('email')."\r\n phone: \r\n address: \r\n post_code: \r\n country_id: 1\r\n newsletter: ".$newsletter_txt."\r\n suspended: false\r\n banned: false\r\n notes: \r\n deleted_at: \r\n ip: ".$this->input->ip_address()."\r\n ip: ".$confirmcode;
			

			$data = array(
				'auditable_id'			=> $user_new_id,
				'auditable_type'		=> 'User',
				'user_id'				=> $user_new_id,
				'user_type'				=> 'User',
				'action'				=> 'create',
				'audited_changes'		=> $auditable_changes,
				'version'				=> 1,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

			return $user_new_id;

		}


		public function users_new_payment($id,$plan_id,$featured_credits){
			$data = array(
				
				'plan_id'		=> $plan_id,
				'featured_credits'	=> $featured_credits

			);

			$this->db->where('id', $id);
			$this->db->update('users', $data);
		}

		public function subscription_completed_ec($user_id,$transaction_id){
			$data = array(
				'user_id'			=> $user_id,
				'paypal_id'		=> $transaction_id
			);

			$this->db->insert('subscriptions', $data);

			$subscription_id = $this->db->insert_id();

			/*============================================================
			[-- AUDITS USER ---------------------------------------------]
		    ============================================================*/
			$auditable_changes = "---\r\n user_id: ".$user_id."\r\n paypal_id: \r\n start_date: \r\n next_payment_date:  \r\n status:  \r\n error: ";

			$data = array(
				'auditable_id'			=> $subscription_id,
				'auditable_type'		=> 'Subscription',
				'user_id'				=> $user_id,
				'user_type'				=> 'User',
				'action'				=> 'create',
				'audited_changes'		=> $auditable_changes,
				'version'				=> 1,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

		}

		public function subscription_completed(){

		}


		public function update_subscription_login_as($id){
			$data = array(
				
				'confirm_code'		=> '',
				
			);

			$this->db->where('id', $id);
			$this->db->update('users', $data);
		}


		public function userlogin($email, $password){

			$this->db->from('users');
			$this->db->where('email', $email);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$result = $this->db->get()->result();

			foreach ($result as $login)
			{  
				$id = $login->id;
				$hash = $login->password_hash;

			}

			if(!empty($result)){
				if($hash == hash('sha512', $password)){

					return $id;

				}else{

					return false;

				}
			}else{
				return false;
			}
			
		}


		public function userlogin_as($id){

			$this->db->where('id', $id);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$query = $this->db->get('users');
			return $query->row_array();

		}


		public function user_update_basic($id){

			if($this->input->post('user_newsletter') != ''){
	    		$user_newsletter = 1;
	    		$user_newsletter_txt = 'true';
	    	}else{
	    		$user_newsletter = 0;
	    		$user_newsletter_txt = 'false';
	    	}

			date_default_timezone_set("Europe/London");
			$data = array(
				'first_name'		=> $this->input->post('user_firstname'),
				'last_name'			=> $this->input->post('user_lastname'),
				'email'				=> $this->input->post('user_email'),
				'phone'				=> $this->input->post('user_phone'),
				'address'			=> $this->input->post('user_address'),
				'post_code'			=> $this->input->post('user_post_code'),
				'country_id'		=> $this->input->post('user_country'),
				'newsletter'		=> $user_newsletter,
				'updated_at'		=> date('Y-m-d H:i:s'),
				'ip'				=> $this->input->ip_address()
				
			);
			$this->db->where('id', $id);
			$this->db->update('users', $data);


			$auditable_changes = "---\r\n first_name: ".$this->input->post('user_firstname')."\r\n last_name: ".$this->input->post('user_lastname')."\r\n email: ".$this->input->post('user_email')."\r\n phone: ".$this->input->post('user_phone')."\r\n address: ".$this->input->post('user_address')."\r\n post_code: ".$this->input->post('user_post_code')."\r\n country_id: ".$this->input->post('user_country')."\r\n newsletter: ".$user_newsletter_txt."\r\n ip: ".$this->input->ip_address();

			$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'User',
				'user_id'				=> $id,
				'user_type'				=> 'User',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

		}

		public function user_update_middle($id){

			if($this->input->post('user_newsletter') != ''){
	    		$user_newsletter = 1;
	    		$user_newsletter_txt = 'true';
	    	}else{
	    		$user_newsletter = 0;
	    		$user_newsletter_txt = 'false';
	    	}


	    	if($this->input->post('user_monthly_report') != ''){
	    		$user_monthly_report = 1;
	    		$user_monthly_txt = 'true';
	    	}else{
	    		$user_monthly_report = 0;
	    		$user_monthly_txt = 'false';
	    	}
	    	

			date_default_timezone_set("Europe/London");
			$data = array(
				'first_name'		=> $this->input->post('user_firstname'),
				'last_name'			=> $this->input->post('user_lastname'),
				'email'				=> $this->input->post('user_email'),
				'phone'				=> $this->input->post('user_phone'),
				'address'			=> $this->input->post('user_address'),
				'post_code'			=> $this->input->post('user_post_code'),
				'country_id'		=> $this->input->post('user_country'),
				'newsletter'		=> $user_newsletter,
				'monthly_report'	=> $user_monthly_report,
				'updated_at'		=> date('Y-m-d H:i:s'),
				'ip'				=> $this->input->ip_address()
				
			);
			$this->db->where('id', $id);
			$this->db->update('users', $data);


			$auditable_changes = "---\r\n first_name: ".$this->input->post('user_firstname')."\r\n last_name: ".$this->input->post('user_lastname')."\r\n email: ".$this->input->post('user_email')."\r\n phone: ".$this->input->post('user_phone')."\r\n address: ".$this->input->post('user_address')."\r\n post_code: ".$this->input->post('user_post_code')."\r\n country_id: ".$this->input->post('user_country')."\r\n newsletter: ".$user_newsletter_txt."\r\n monthly_report: ".$user_monthly_txt."\r\n ip: ".$this->input->ip_address();

			$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'User',
				'user_id'				=> $id,
				'user_type'				=> 'User',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

		}

		public function user_update_ultimate($id){

			if($this->input->post('user_newsletter') != ''){
	    		$user_newsletter = 1;
	    		$user_newsletter_txt = 'true';
	    	}else{
	    		$user_newsletter = 0;
	    		$user_newsletter_txt = 'false';
	    	}


	    	if($this->input->post('user_monthly_report') != ''){
	    		$user_monthly_report = 1;
	    		$user_monthly_txt = 'true';
	    	}else{
	    		$user_monthly_report = 0;
	    		$user_monthly_txt = 'false';
	    	}
	    	
			date_default_timezone_set("Europe/London");
			$data = array(
				'first_name'		=> $this->input->post('user_firstname'),
				'last_name'			=> $this->input->post('user_lastname'),
				'email'				=> $this->input->post('user_email'),
				'phone'				=> $this->input->post('user_phone'),
				'address'			=> $this->input->post('user_address'),
				'post_code'			=> $this->input->post('user_post_code'),
				'country_id'		=> $this->input->post('user_country'),
				'website'			=> $this->input->post('user_website'),
				'newsletter'		=> $user_newsletter,
				'monthly_report'	=> $user_monthly_report,
				'updated_at'		=> date('Y-m-d H:i:s'),
				'ip'				=> $this->input->ip_address()
				
			);
			$this->db->where('id', $id);
			$this->db->update('users', $data);


			$auditable_changes = "---\r\n first_name: ".$this->input->post('user_firstname')."\r\n last_name: ".$this->input->post('user_lastname')."\r\n email: ".$this->input->post('user_email')."\r\n phone: ".$this->input->post('user_phone')."\r\n address: ".$this->input->post('user_address')."\r\n post_code: ".$this->input->post('user_post_code')."\r\n country_id: ".$this->input->post('user_country')."\r\n website: ".$this->input->post('user_website')."\r\n newsletter: ".$user_newsletter_txt."\r\n monthly_report: ".$user_monthly_txt."\r\n ip: ".$this->input->ip_address();

			$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'User',
				'user_id'				=> $id,
				'user_type'				=> 'User',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

		}

		
		public function user_password_update($hash_password,$id){

			$data = array(
				'password_hash'		=> $hash_password
			);
			$this->db->where('id', $id);
			$this->db->update('users', $data);
		}

		public function get_users($users_id){

			$query = $this->db->get_where('users', array('id' => $users_id));
			return $query->row_array();
		}


		/*=====================================================
		[-- LISTINGS -----------------------------------------]
	    ======================================================*/

		public function listingdog(){

			date_default_timezone_set("Europe/London");

			if($this->input->post('pedigree') != ''){
	    		$pedigree = 1;
	    		$pedigree_txt = 'true';
	    	}else{
	    		$pedigree = 0;
	    		$pedigree_txt = 'false';
	    	}
	    	
	    	if($this->input->post('published') != ''){
	    		$published = 1;
	    		$published_txt = 'true';
	    	}else{
	    		$published = 0;
	    		$published_txt = 'false';
	    	}

			$address = strtr($this->input->post('post_code'),' ','+');

			$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

			$output= json_decode($geocode);

			if($output->status != 'ZERO_RESULTS'){

				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;

			}else{

				$countries = $this->getdata_model->get_countries();
                  	foreach($countries as $country):
                        if($this->input->post('country') == $country['id']):
                          $country_code =  $country['code'];
                       	endif;
                  	endforeach; 

				$country_address = strtr($country_code,' ','+');

				$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

				$output= json_decode($geocode);

				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;

			}


			$date = date_create($this->input->post('date'));


			/*============================================================
			[-- ADD LISTING DOG  ----------------------------------------]
		    ============================================================*/
			$data = array(
				'listing_type' 			=>	'dog',
				'title'					=>	$this->input->post('listing_title'),
				'name'					=>	$this->input->post('dogname'),
				'kennel_club_name'		=>	$this->input->post('kennel'),
				'gender'				=>	$this->input->post('gender'),
				'breed_id'				=>	$this->input->post('breed'),	
				'date_of_birth'			=>	date_format($date,'Y-m-d'),
				'description'			=>	$this->input->post('listing_description'),
				'country_id'			=>	$this->input->post('country'),
				'region'				=>	$this->input->post('region'),
				'post_code'				=>	$this->input->post('post_code'),
				'latitude'				=>	$latitude,
				'longitude'				=>	$longitude,
				'pedigree'				=>	$pedigree,
				'published'				=>	$published,
				'user_id'				=>	$this->session->userdata('user_id_byd'),
				'created_at'			=>	date('Y-m-d H:i:s'),
				'updated_at'			=>	date('Y-m-d H:i:s')
			);

			$this->db->insert('listings', $data);

			$listing_id = $this->db->insert_id();

			/*============================================================
			[-- AUDITS LISTING ------------------------------------------]
		    ============================================================*/
		    $auditable_changes = "--- \r\n listing_type: ".'dog'."\r\n title: ".$this->input->post('listing_title')."\r\n name: ".$this->input->post('dogname')."\r\n kennel_club_name: ".$this->input->post('kennel')."\r\n gender: ".$this->input->post('gender')."\r\n breed_id: ".$this->input->post('breed')."\r\n date_of_birth: ".date_format($date,'Y-m-d')."\r\n description: ".$this->input->post('listing_description')."\r\n country_id: ".$this->input->post('country')."\r\n region: ".$this->input->post('region')."\r\n post_code: ".$this->input->post('post_code')."\r\n latitude: ".$latitude."\r\n longitude: ".$longitude."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$this->session->userdata('user_id_byd');

			$data = array(
				'auditable_id'			=> $listing_id,
				'auditable_type'		=> 'Listing',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'create',
				'audited_changes'		=> $auditable_changes,
				'version'				=> 1,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

			return $listing_id;

		}


		public function listingpuppies(){

			date_default_timezone_set("Europe/London");

			if($this->input->post('pedigree') != ''){
	    		$pedigree = 1;
	    		$pedigree_txt = 'true';
	    	}else{
	    		$pedigree = 0;
	    		$pedigree_txt = 'false';
	    	}
	    	
	    	if($this->input->post('published') != ''){
	    		$published = 1;
	    		$published_txt = 'true';
	    	}else{
	    		$published = 0;
	    		$published_txt = 'false';
	    	}

			$address = strtr($this->input->post('post_code'),' ','+');

			$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

			$output= json_decode($geocode);
			
			if($output->status != 'ZERO_RESULTS'){

				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;

			}else{

				$countries = $this->getdata_model->get_countries();
                  	foreach($countries as $country):
                        if($this->input->post('country') == $country['id']):
                          $country_code =  $country['code'];
                       	endif;
                  	endforeach; 

				$country_address = strtr($country_code,' ','+');

				$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

				$output= json_decode($geocode);

				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;

			}


			$date = date_create($this->input->post('date'));
	    	
			$data = array(
				'listing_type' 			=>	'pup',
				'title'					=>	$this->input->post('listing_title'),
				'breed_id'				=>	$this->input->post('breed'),	
				'date_of_birth'			=>	date_format($date,'Y-m-d'),
				'description'			=>	$this->input->post('listing_description'),
				'country_id'			=>	$this->input->post('country'),
				'region'				=>	$this->input->post('region'),
				'post_code'				=>	$this->input->post('post_code'),
				'latitude'				=>	$latitude,
				'longitude'				=>	$longitude,
				'pedigree'				=>	$pedigree,
				'published'				=>	$published,
				'user_id'				=>	$this->session->userdata('user_id_byd'),
				'created_at'			=>	date('Y-m-d H:i:s'),
				'updated_at'			=>	date('Y-m-d H:i:s')
			);

			$this->db->insert('listings', $data);
			$listing_id = $this->db->insert_id();

			/*============================================================
			[-- AUDITS LISTING ------------------------------------------]
		    ============================================================*/
		    $auditable_changes = "--- \r\n listing_type: ".'pup'."\r\n title: ".$this->input->post('listing_title')."\r\n breed_id: ".$this->input->post('breed')."\r\n date_of_birth: ".date_format($date,'Y-m-d')."\r\n description: ".$this->input->post('listing_description')."\r\n country_id: ".$this->input->post('country')."\r\n region: ".$this->input->post('region')."\r\n post_code: ".$this->input->post('post_code')."\r\n latitude: ".$latitude."\r\n longitude: ".$longitude."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$this->session->userdata('user_id_byd');

			$data = array(
				'auditable_id'			=> $listing_id,
				'auditable_type'		=> 'Listing',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'create',
				'audited_changes'		=> $auditable_changes,
				'version'				=> 1,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

			return $listing_id;

		}

		public function delete_listing($id){

			date_default_timezone_set("Europe/London");

			$data  = array(
				'deleted_at' =>	date('Y-m-d H:i:s')
			);

			$this->db->where('id', $id);
			$this->db->update('listings', $data);

			/*============================================================
			[-- AUDITS LISTING ------------------------------------------]
		    ============================================================*/

		    $this->db->where('id', $id);
			$query = $this->db->get('listings');
	    	$listing =  $query->row_array();

	    	if($listing['featured'] == 1){
				$featured_txt = 'true';
			}else{
				$featured_txt = 'false';
			}

			if($listing['highlight'] == 1){
				$highlight_txt = 'true';
			}else{
				$highlight_txt = 'false';
			}

			if($listing['pedigree'] == 1){
	    		$pedigree = 1;
	    		$pedigree_txt = 'true';
	    	}else{
	    		$pedigree = 0;
	    		$pedigree_txt = 'false';
	    	}
	    	
	    	if($listing['published'] == 1){
	    		$published = 1;
	    		$published_txt = 'true';
	    	}else{
	    		$published = 0;
	    		$published_txt = 'false';
	    	}

	    	if($listing['on_homepage'] == 1){
				$on_homepage_txt = 'true';
			}else{
				$on_homepage_txt = 'false';
			}

			if($listing['listing_type'] == 'pup'){

		    	$auditable_changes = "--- \r\n listing_type: ".$listing['listing_type']."\r\n title: ".$listing['title']."\r\n breed_id: ".$listing['breed_id']."\r\n date_of_birth: ".$listing['date_of_birth']."\r\n description: ".$listing['description']."\r\n country_id: ".$listing['country_id']."\r\n region: ".$listing['region']."\r\n post_code: ".$listing['post_code']."\r\n latitude: ".$listing['latitude']."\r\n longitude: ".$listing['longitude']."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$this->session->userdata('user_id_byd')."\r\n featured: ".$featured_txt."\r\n featured_until: ".$listing['featured_until']."\r\n highlight: ".$highlight_txt."\r\n highlight_until: ".$listing['highlight_until']."\r\n on_homepage: ".$on_homepage_txt."\r\n on_homepage_until: ".$listing['on_homepage_until']."\r\n views: ".$listing['views']."\r\n deleted_at: ".$listing['deleted_at']."\r\n old_id: ".$listing['old_id'];
			
			}else{

		    	$auditable_changes = "--- \r\n listing_type: ".$listing['listing_type']."\r\n title: ".$listing['title']."\r\n name: ".$listing['name']."\r\n kennel_club_name: ".$listing['kennel_club_name']."\r\n gender: ".$listing['gender']."\r\n breed_id: ".$listing['breed_id']."\r\n date_of_birth: ".$listing['date_of_birth']."\r\n description: ".$listing['description']."\r\n country_id: ".$listing['country_id']."\r\n region: ".$listing['region']."\r\n post_code: ".$listing['post_code']."\r\n latitude: ".$listing['latitude']."\r\n longitude: ".$listing['longitude']."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$this->session->userdata('user_id_byd')."\r\n featured: ".$featured_txt."\r\n featured_until: ".$listing['featured_until']."\r\n highlight: ".$highlight_txt."\r\n highlight_until: ".$listing['highlight_until']."\r\n on_homepage: ".$on_homepage_txt."\r\n on_homepage_until: ".$listing['on_homepage_until']."\r\n views: ".$listing['views']."\r\n deleted_at: ".$listing['deleted_at']."\r\n old_id: ".$listing['old_id'];
				
			}

		    $this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'Listing',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'destroy',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

		}

		public function listing_memorial($id){
			date_default_timezone_set("Europe/London");

			$date = date_create($this->input->post('memorial_date'));

			$data  = array(
				'listing_type' 	=>	'mem',
				'date_of_death'	=>	date_format($date,'Y-m-d')
			);

			$this->db->where('id', $id);
			$this->db->update('listings', $data);


			/*============================================================
			[-- AUDITS LISTING ------------------------------------------]
		    ============================================================*/

		    $this->db->where('id', $id);
			$query = $this->db->get('listings');
	    	$listing =  $query->row_array();

	    	if($listing['featured'] == 1){
				$featured_txt = 'true';
			}else{
				$featured_txt = 'false';
			}

			if($listing['highlight'] == 1){
				$highlight_txt = 'true';
			}else{
				$highlight_txt = 'false';
			}

			if($listing['pedigree'] == 1){
	    		$pedigree = 1;
	    		$pedigree_txt = 'true';
	    	}else{
	    		$pedigree = 0;
	    		$pedigree_txt = 'false';
	    	}
	    	
	    	if($listing['published'] == 1){
	    		$published = 1;
	    		$published_txt = 'true';
	    	}else{
	    		$published = 0;
	    		$published_txt = 'false';
	    	}

	    	if($listing['on_homepage'] == 1){
				$on_homepage_txt = 'true';
			}else{
				$on_homepage_txt = 'false';
			}


			$auditable_changes = "--- \r\n listing_type: ".$listing['listing_type']."\r\n title: ".$listing['title']."\r\n name: ".$listing['name']."\r\n kennel_club_name: ".$listing['kennel_club_name']."\r\n gender: ".$listing['gender']."\r\n breed_id: ".$listing['breed_id']."\r\n date_of_birth: ".$listing['date_of_birth']."\r\n description: ".$listing['description']."\r\n country_id: ".$listing['country_id']."\r\n region: ".$listing['region']."\r\n post_code: ".$listing['post_code']."\r\n latitude: ".$listing['latitude']."\r\n longitude: ".$listing['longitude']."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$this->session->userdata('user_id_byd')."\r\n featured: ".$featured_txt."\r\n featured_until: ".$listing['featured_until']."\r\n highlight: ".$highlight_txt."\r\n highlight_until: ".$listing['highlight_until']."\r\n on_homepage: ".$on_homepage_txt."\r\n on_homepage_until: ".$listing['on_homepage_until']."\r\n views: ".$listing['views']."\r\n deleted_at: ".$listing['deleted_at']."\r\n old_id: ".$listing['old_id'];
				

		    $this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'Listing',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);


		}


		public function listing_images($listing_id,$listing_image,$img_num){

			date_default_timezone_set("Europe/London");

			$data = array(
				'listing_id' 	=>	$listing_id,
				'image'			=>	$listing_image,
				'sort'			=>	$img_num,
				'created_at'	=>	date('Y-m-d H:i:s'),
				'updated_at'	=>	date('Y-m-d H:i:s')
			);

			$this->db->insert('listing_images',$data);
	    	
	    	$listing_image_id =  $this->db->insert_id();

			/*============================================================
			[-- AUDITS LISTING IMAGE ------------------------------------]
		    ============================================================*/
			$auditable_changes = "---\r\n listing_id: ".$listing_image_id."\r\n image: ".$listing_image."\r\n sort: ".$img_num."\r\n watermark: true \r\n on_homepage:  \r\n homepage_title:  \r\n image_version: 0";

			$data = array(
				'auditable_id'			=> $listing_image_id,
				'auditable_type'		=> 'ListingImage',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'create',
				'audited_changes'		=> $auditable_changes,
				'version'				=> 1,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

			return $listing_image_id;

		}

		/*=====================================================
		[-- LISTING IMAGE ------------------------------------]
	    ======================================================*/

		public function get_listing_images_result_frontend($listing_id){
			$this->db->order_by('sort', 'ASC');
			$this->db->where('dont_display', 0);
			$query = $this->db->get_where('listing_images', array('listing_id' => $listing_id));
			return $query->result_array();
		}

		public function get_listing_images($listing_id){
			$this->db->order_by('sort', 'ASC');
			$this->db->where('dont_display', 0);
			$query = $this->db->get_where('listing_images', array('listing_id' => $listing_id));
			return $query->row_array();
		}

		public function get_listing_images_result($listing_id){
			$this->db->order_by('sort', 'ASC');
			$query = $this->db->get_where('listing_images', array('listing_id' => $listing_id));
			return $query->result_array();
		}


		/*=====================================================
		[-- UPDATE LISTINGS ----------------------------------]
	    ======================================================*/

		public function update_listingdog($listing_id){

			date_default_timezone_set("Europe/London");

			if($this->input->post('pedigree') != ''){
	    		$pedigree = 1;
	    		$pedigree_txt = 'true';
	    	}else{
	    		$pedigree = 0;
	    		$pedigree_txt = 'false';
	    	}
	    	
	    	if($this->input->post('published') != ''){
	    		$published = 1;
	    		$published_txt = 'true';
	    	}else{
	    		$published = 0;
	    		$published_txt = 'false';
	    	}


			$address = strtr($this->input->post('post_code'),' ','+');

			$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

			$output= json_decode($geocode);

			if($output->status != 'ZERO_RESULTS'){

				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;

			}else{

				$countries = $this->getdata_model->get_countries();
                  	foreach($countries as $country):
                        if($this->input->post('country') == $country['id']):
                          $country_code =  $country['code'];
                       	endif;
                  	endforeach; 

				$country_address = strtr($country_code,' ','+');

				$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

				$output= json_decode($geocode);

				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;

			}


			$date = date_create($this->input->post('date'));

			$data = array(
				'title'					=>	$this->input->post('listing_title'),
				'name'					=>	$this->input->post('dogname'),
				'kennel_club_name'		=>	$this->input->post('kennel'),
				'gender'				=>	$this->input->post('gender'),
				'breed_id'				=>	$this->input->post('breed'),	
				'date_of_birth'			=>	date_format($date,'Y-m-d'),
				'description'			=>	$this->input->post('listing_description'),
				'country_id'			=>	$this->input->post('country'),
				'region'				=>	$this->input->post('region'),
				'post_code'				=>	$this->input->post('post_code'),
				'pedigree'				=>	$pedigree,
				'published'				=>	$published,
				'user_id'				=>	$this->session->userdata('user_id_byd'),
				'updated_at'			=>	date('Y-m-d H:i:s')
			);

			$this->db->where('id', $listing_id);
			$this->db->update('listings', $data);


			/*============================================================
			[-- AUDITS LISTING ------------------------------------------]
		    ============================================================*/

		    $this->db->where('id', $listing_id);
			$query = $this->db->get('listings');
	    	$listing_type = $query->row_array();

	    	if($listing_type['listing_type'] == 'mem'){

	    		$auditable_changes = "--- \r\n listing_type: ".$listing_type['listing_type']."\r\n title: ".$this->input->post('listing_title')."\r\n name: ".$this->input->post('dogname')."\r\n kennel_club_name: ".$this->input->post('kennel')."\r\n gender: ".$this->input->post('gender')."\r\n breed_id: ".$this->input->post('breed')."\r\n date_of_birth: ".$listing_type['date_of_birth']."\r\n date_of_death: ".$listing_type['date_of_death']."\r\n description: ".$this->input->post('listing_description')."\r\n country_id: ".$this->input->post('country')."\r\n region: ".$this->input->post('region')."\r\n post_code: ".$this->input->post('post_code')."\r\n latitude: ".$latitude."\r\n longitude: ".$longitude."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$this->session->userdata('user_id_byd');

	    	}else{

		    	$auditable_changes = "--- \r\n listing_type: ".$listing_type['listing_type']."\r\n title: ".$this->input->post('listing_title')."\r\n name: ".$this->input->post('dogname')."\r\n kennel_club_name: ".$this->input->post('kennel')."\r\n gender: ".$this->input->post('gender')."\r\n breed_id: ".$this->input->post('breed')."\r\n date_of_birth: ".$listing_type['date_of_birth']."\r\n description: ".$this->input->post('listing_description')."\r\n country_id: ".$this->input->post('country')."\r\n region: ".$this->input->post('region')."\r\n post_code: ".$this->input->post('post_code')."\r\n latitude: ".$latitude."\r\n longitude: ".$longitude."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$this->session->userdata('user_id_byd');
	    		
	    	}

		    $this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $listing_id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $listing_id,
				'auditable_type'		=> 'Listing',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

		}

		public function update_listingpuppies($listing_id){

			date_default_timezone_set("Europe/London");

			if($this->input->post('pedigree') != ''){
	    		$pedigree = 1;
	    		$pedigree_txt = 'true';
	    	}else{
	    		$pedigree = 0;
	    		$pedigree_txt = 'false';
	    	}
	    	
	    	if($this->input->post('published') != ''){
	    		$published = 1;
	    		$published_txt = 'true';
	    	}else{
	    		$published = 0;
	    		$published_txt = 'false';
	    	}

			$address = strtr($this->input->post('post_code'),' ','+');

			$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

			$output= json_decode($geocode);

			if($output->status != 'ZERO_RESULTS'){

				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;

			}else{

				$countries = $this->getdata_model->get_countries();
                  	foreach($countries as $country):
                        if($this->input->post('country') == $country['id']):
                          $country_code =  $country['code'];
                       	endif;
                  	endforeach; 

				$country_address = strtr($country_code,' ','+');

				$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

				$output= json_decode($geocode);

				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;

			}
			

			$date = date_create($this->input->post('date'));

			$data = array(
				'title'					=>	$this->input->post('listing_title'),
				'breed_id'				=>	$this->input->post('breed'),	
				'date_of_birth'			=>	date_format($date,'Y-m-d'),
				'description'			=>	$this->input->post('listing_description'),
				'country_id'			=>	$this->input->post('country'),
				'region'				=>	$this->input->post('region'),
				'post_code'				=>	$this->input->post('post_code'),
				'pedigree'				=>	$pedigree,
				'published'				=>	$published,
				'user_id'				=>	$this->session->userdata('user_id_byd'),
				'updated_at'			=>	date('Y-m-d H:i:s')
			);

			$this->db->where('id', $listing_id);
			$this->db->update('listings', $data);


			/*============================================================
			[-- AUDITS LISTING ------------------------------------------]
		    ============================================================*/
		    $auditable_changes = "--- \r\n listing_type: ".'pup'."\r\n title: ".$this->input->post('listing_title')."\r\n breed_id: ".$this->input->post('breed')."\r\n date_of_birth: ".date_format($date,'Y-m-d')."\r\n description: ".$this->input->post('listing_description')."\r\n country_id: ".$this->input->post('country')."\r\n region: ".$this->input->post('region')."\r\n post_code: ".$this->input->post('post_code')."\r\n latitude: ".$latitude."\r\n longitude: ".$longitude."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$this->session->userdata('user_id_byd');

		    $this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $listing_id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;


			$data = array(
				'auditable_id'			=> $listing_id,
				'auditable_type'		=> 'Listing',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

		}

		public function delete_listing_images($id){

			/*============================================================
			[-- AUDITS LISTING IMAGE ------------------------------------]
		    ============================================================*/

		    $this->db->where('id', $id);
			$query = $this->db->get('listing_images');
	    	$listingimage_audit = $query->row_array();

	    	if($listingimage_audit['watermark'] == 1){
	    		$watermark = 'true';
	    	}else{
	    		$watermark = 'false';
	    	}

	    	if($listingimage_audit['on_homepage'] == 1){
	    		$on_homepage = 'true';
	    	}else{
	    		$on_homepage = 'false';
	    	}

	    	if($listingimage_audit['dont_display'] == 1){
	    		$dont_display = 'true';
	    	}else{
	    		$dont_display = 'false';
	    	}

			$auditable_changes = "---\r\n listing_id: ".$listingimage_audit['listing_id']."\r\n image: ".$listingimage_audit['image']."\r\n sort: ".$listingimage_audit['sort']."\r\n watermark: ".$watermark."\r\n on_homepage: ".$on_homepage."\r\n dont_display: ".$dont_display."\r\n homepage_title: ".$listingimage_audit['homepage_title']."\r\n image_version: ".$listingimage_audit['image_version'];


			$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $listingimage_audit['id']);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $listingimage_audit['id'],
				'auditable_type'		=> 'ListingImage',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'destroy',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);


			/*============================================================
			[-- DELETE LISITNG IMAGE ------------------------------------]
		    ============================================================*/
			$this->db->where('id', $id);
			$this->db->delete('listing_images');
			return true;
		}

		public function update_listing_images($id,$name){
			date_default_timezone_set("Europe/London");

	    	$data = array(
				'image'	=> $name,
				'updated_at'	=>	date('Y-m-d H:i:s')
			);
			$this->db->set('image_version', 'image_version+1',FALSE);
			$this->db->where('id', $id);
			$this->db->update('listing_images', $data);

			/*============================================================
			[-- AUDITS LISTING IMAGE ------------------------------------]
		    ============================================================*/

		    $this->db->where('id', $id);
			$query = $this->db->get('listing_images');
	    	$listingimage_audit = $query->row_array();

	    	if($listingimage_audit['watermark'] == 1){
	    		$watermark = 'true';
	    	}else{
	    		$watermark = 'false';
	    	}

	    	if($listingimage_audit['on_homepage'] == 1){
	    		$on_homepage = 'true';
	    	}else{
	    		$on_homepage = 'false';
	    	}

	    	if($listingimage_audit['dont_display'] == 1){
	    		$dont_display = 'true';
	    	}else{
	    		$dont_display = 'false';
	    	}

			$auditable_changes = "---\r\n listing_id: ".$listingimage_audit['listing_id']."\r\n image: ".$listingimage_audit['image']."\r\n sort: ".$listingimage_audit['sort']."\r\n watermark: ".$watermark."\r\n on_homepage: ".$on_homepage."\r\n dont_display: ".$dont_display."\r\n homepage_title: ".$listingimage_audit['homepage_title']."\r\n image_version: ".$listingimage_audit['image_version'];


			$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $listingimage_audit['id']);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $listingimage_audit['id'],
				'auditable_type'		=> 'ListingImage',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

		}

		public function edit_listing_images($listing_id,$listing_image){

			date_default_timezone_set("Europe/London");

			$data = array(
				'listing_id' 	=>	$listing_id,
				'image'			=>	$listing_image,
				'created_at'	=>	date('Y-m-d H:i:s'),
				'updated_at'	=>	date('Y-m-d H:i:s')
			);

			$this->db->insert('listing_images',$data);

	    	$listing_image_id =  $this->db->insert_id();

			/*============================================================
			[-- AUDITS LISTING IMAGE ------------------------------------]
		    ============================================================*/

		    $this->db->select('sort');
		    $this->db->where('listing_id', $listing_id);
		    $this->db->where('sort !=',NULL);
		    $this->db->order_by('id', 'DESC');
	    	$query = $this->db->get('listing_images');
	    	$image_sort = $query->row_array();

	    	if(empty($image_sort)){
	    		echo $sort = 1;
	    	}else{
	    		echo $sort = $image_sort['sort'];
	    	}

			$auditable_changes = "---\r\n listing_id: ".$listing_image_id."\r\n image: ".$listing_image."\r\n sort: ".$sort."\r\n watermark: true \r\n on_homepage:  \r\n homepage_title:  \r\n image_version: 0";

			$data = array(
				'auditable_id'			=> $listing_image_id,
				'auditable_type'		=> 'ListingImage',
				'user_id'				=> $this->session->userdata('user_id_byd'),
				'user_type'				=> 'User',
				'action'				=> 'create',
				'audited_changes'		=> $auditable_changes,
				'version'				=> 1,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

			return $listing_image_id;
		}

		public function get_listing_images_fixed_sort($listing_id){
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get_where('listing_images', array('listing_id' => $listing_id));
			return $query->result_array();
		}

		public function listing_images_sort($img_id,$sort){
			date_default_timezone_set("Europe/London");
			$data = array(
				'sort'	=> $sort,
				'updated_at'	=>	date('Y-m-d H:i:s')
			);	
			$this->db->where('id', $img_id);
			$this->db->update('listing_images', $data);


			/*===================================================================
			[-- UPDATE AUDITS LISTING IMAGE LIKE -------------------------------]
		    ===================================================================*/

		    $this->db->where('id', $img_id);
			$query = $this->db->get('listing_images');
	    	$listingimage_audit = $query->row_array();

	    	if($listingimage_audit['watermark'] == 1){
	    		$watermark = 'true';
	    	}else{
	    		$watermark = 'false';
	    	}

	    	if($listingimage_audit['on_homepage'] == 1){
	    		$on_homepage = 'true';
	    	}else{
	    		$on_homepage = 'false';
	    	}

	    	if($listingimage_audit['dont_display'] == 1){
	    		$dont_display = 'true';
	    	}else{
	    		$dont_display = 'false';
	    	}

			$auditable_changes = "---\r\n listing_id: ".$listingimage_audit['listing_id']."\r\n image: ".$listingimage_audit['image']."\r\n sort: ".$sort."\r\n watermark: ".$watermark."\r\n on_homepage: ".$on_homepage."\r\n dont_display: ".$dont_display."\r\n homepage_title: ".$listingimage_audit['homepage_title']."\r\n image_version: ".$listingimage_audit['image_version'];


			$data = array(
				'audited_changes'		=> $auditable_changes
			);

			$this->db->like("audited_changes", "sort: \r\n watermark");
			$this->db->where('auditable_id', $img_id);
			$this->db->where('action', 'create');
			$this->db->update('audits', $data);

		}

		/*=====================================================
		[-- LISTINGS STUD DOGS -------------------------------]
	    ======================================================*/
	    public function get_stud_dogs(){
			
			$this->db->order_by('listings.id', 'DESC');
			$this->db->order_by('listings.featured', 'DESC');
			$this->db->where('listings.listing_type', 'dog');
			$this->db->where('listings.published', 1);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$this->db->join('listings', 'listings.user_id = users.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);

			$query = $this->db->get('users');

			return $query->num_rows();

		}	

		/*=====================================================
		[-- LISTINGS PUPPIES  --------------------------------]
	    ======================================================*/
	    public function get_puppies(){

			$this->db->order_by('listings.id', 'DESC');
			$this->db->order_by('listings.featured', 'DESC');
			$this->db->where('listings.listing_type', 'pup');
			$this->db->where('listings.published', 1);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$this->db->join('listings', 'listings.user_id = users.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);

			$query = $this->db->get('users');

			return $query->num_rows();

		}

		/*=====================================================
		[-- LISTINGS MEMORIALS  --------------------------------]
	    ======================================================*/
	    public function memorial(){
			$this->db->order_by('listings.id', 'DESC');
			$this->db->order_by('listings.featured', 'DESC');
			$this->db->where('listings.listing_type', 'mem');
			$this->db->where('listings.published', 1);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$this->db->join('listings', 'listings.user_id = users.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);

			$query = $this->db->get('users');

			return $query->num_rows();
		}

		/*=====================================================
		[-- LISTINGS VIEWS  ----------------------------------]
	    ======================================================*/
	    public function listing_views($listing_id){
	    	$this->db->set('views', 'views+1',FALSE);
			$this->db->where('id', $listing_id);
			$this->db->update('listings');
	    }

	    /*=====================================================
		[-- LISTINGS VIEWS NULL VALUE ------------------------]
	    ======================================================*/
	    public function listing_views_zero($listing_id){
	    	$this->db->set('views', '1');
			$this->db->where('id', $listing_id);
			$this->db->update('listings');
	    }


	    /*=====================================================
		[-- Legacy method possibly used by cron job?  -------------------------------]
	    ======================================================*/
	    public function cron_featured(){

			$this->db->order_by('listings.id', 'RANDOM');
			$this->db->limit(4);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			
			$this->db->where('listings.published', 1);

			$this->db->join('listings', 'listings.user_id = users.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);

			$query = $this->db->get('users');

			return $query->result_array();
		}
	    /*=====================================================
		[-- Featured listings for homepage  -------------------------------]
	    ======================================================*/
	    public function featured(){

	    $this->db->select('listings.id, listings.title, breeds.name AS breed_name, listing_images.id AS image_id, listing_images.image');
			$this->db->order_by('listings.id', 'RANDOM');
			$this->db->limit(4);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			
			$this->db->where('listings.published', 1);

			$this->db->join('listings', 'listings.user_id = users.id');
			$this->db->join('breeds', 'listings.breed_id = breeds.id');
			$this->db->join('listing_images', 'listings.id = listing_images.listing_id');

			$this->db->group_by('listings.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);
			$this->db->where('listing_images.dont_display', 0);

			$query = $this->db->get('users');

			return $query->result_array();
		}

		/*=====================================================
		[-- ALL LISTINGS -------------------------------------]
	    ======================================================*/
	    public function listings(){
	    	
			$this->db->order_by('listings.id', 'DESC');
			$this->db->order_by('listings.featured', 'DESC');
			$this->db->where('listings.published', 1);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$this->db->join('listings', 'listings.user_id = users.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);

			$query = $this->db->get('users');

			return $query->result_array();
		}


		/*=====================================================
		[-- USERS DAILY --------------------------------------]
	    ======================================================*/
	    public function daily_views(){
	    	$query = $this->db->get('daily_views');
	    	return $query->result_array();
	    }

		/*=====================================================
		[-- USERS DAILY VIEWS --------------------------------]
	    ======================================================*/
		public function user_daily_views($context,$trackable_id,$trackable_type){

			date_default_timezone_set("Europe/London");
			$this->db->where('on', date('Y-m-d'));
			$this->db->where('context', $context);
			$this->db->where('daily_views_trackable_id', $trackable_id);
			$this->db->where('daily_views_trackable_type', $trackable_type);
			$same_daily_views = $this->db->get('daily_views');

			$result = $same_daily_views->result();

			if(!empty($result)){

				$data = array(
				
					'updated_at'	=> date('Y-m-d H:i:s')
				
				);

				$this->db->set('views', 'views+1',FALSE);
				$this->db->where('on', date('Y-m-d'));
				$this->db->where('context', $context);
				$this->db->where('daily_views_trackable_id', $trackable_id);
				$this->db->where('daily_views_trackable_type', $trackable_type);
				return $this->db->update('daily_views', $data);

			}else{

				$data = array(
				
					'on'							=> date('Y-m-d'),
					'context'						=> $context,
					'daily_views_trackable_id'		=> $trackable_id,
					'daily_views_trackable_type'	=> $trackable_type,
					'views'							=> 1,
					'created_at'					=> date('Y-m-d H:i:s'),
					'updated_at'					=> date('Y-m-d H:i:s')
				
				);

				return $this->db->insert('daily_views', $data);

			}

		} 

		/*===========================================================================================
		[-- USERS DAILY VIEWS RESULTS ( Times shown in search results ) ----------------------------]
	    ============================================================================================*/
	    public function daily_views_result_show($date,$list_id){

	    	date_default_timezone_set("Europe/London");

	    	$lastday = strtotime($date, TRUE);
  			$lastday_add = strtotime(date('Y-m-t', $lastday).' +1 day');

  			$this->db->select_sum('views');
	    	$this->db->where('on >=', $date);
	    	$this->db->where('on <', date('Y-m-d',$lastday_add));	
	    	$this->db->where('context', 'show');
	    	$this->db->where('daily_views_trackable_id', $list_id);
	    	$query = $this->db->get('daily_views');

	    	return $query->row_array();

	    }

	    /*===========================================================================================
		[-- USERS DAILY VIEWS RESULTS ( Times clicked from search results ) ------------------------]
	    ============================================================================================*/
	    public function daily_views_result_click($date,$list_id){

	    	date_default_timezone_set("Europe/London");

	    	$lastday = strtotime($date, TRUE);
  			$lastday_add = strtotime(date('Y-m-t', $lastday).' +1 day');

  			$this->db->select_sum('views');
	    	$this->db->where('on >=', $date);
	    	$this->db->where('on <', date('Y-m-d',$lastday_add));	
	    	$this->db->where('context', 'index');
	    	$this->db->where('daily_views_trackable_id', $list_id);
	    	$query = $this->db->get('daily_views');

	    	return $query->row_array();	
	    }


	    /*===========================================================================================
		[-- USERS DAILY VIEWS RESULTS GRAPH ( Times shown in search results ) ----------------------]
	    ============================================================================================*/
	    public function daily_views_result_show_graph($date,$list_id){
	    	date_default_timezone_set("Europe/London");

	    	$this->db->where('on', $date);
	    	$this->db->where('context', 'show');
	    	$this->db->where('daily_views_trackable_id', $list_id);
	    	$query = $this->db->get('daily_views');

	    	return $query->row_array();

	    }

	    /*===========================================================================================
		[-- USERS DAILY VIEWS RESULTS GRAPH ( Times clicked from search results ) ------------------]
	    ============================================================================================*/
	    public function daily_views_result_click_graph($date,$list_id){
	    	date_default_timezone_set("Europe/London");
	    	
	    	$this->db->where('on', $date);
	    	$this->db->where('context', 'index');
	    	$this->db->where('daily_views_trackable_id', $list_id);
	    	$query = $this->db->get('daily_views');

	    	return $query->row_array();	
	    }


	    /*===========================================================================================
		[-- USERS DAILY VIEWS OF LISTINGS IMAGES ----------------------------------------------------]
	    ============================================================================================*/
	    public function daily_views_listing_image($date,$list_id){
	    	date_default_timezone_set("Europe/London");
	    	
	    	$this->db->where('on', $date);
	    	$this->db->where('context', 'show');
	    	$this->db->where('daily_views_trackable_type', 'ListingImage');
	    	$this->db->where('daily_views_trackable_id', $list_id);
	    	$query = $this->db->get('daily_views');

	    	return $query->row_array();	
	    }

	    /*===========================================================================================
		[-- USERS CHANGES PLAN ---------------------------------------------------------------------]
	    ============================================================================================*/
	    public function user_change_plan_basic($user_id){
	    	date_default_timezone_set("Europe/London");
	    	$data = array(
				
				'plan_id'		=> 1,
				'updated_at'		=> date('Y-m-d H:i:s')

			);

			$this->db->where('id', $user_id);
			$this->db->update('users', $data);


			$this->db->where('user_id',$user_id);
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
	    	$this->db->order_by('id', 'DESC');
    		$query = $this->db->get('listings');
    		$newest_listing = $query->row_array();

    		$data = array(

				'published'	=> 0

			);

    		$this->db->where('id !=', $newest_listing['id']);
			$this->db->where('user_id',$user_id);
	    	$this->db->update('listings', $data);


	    	$data = array(

				'user_id'	=> NULL,
				'status'	=> 'Cancelled'

			);

			$this->db->where('user_id',$user_id);
	    	$this->db->update('subscriptions', $data);

	    }


	    /*===========================================================================================
		[-- USERS CHANGES PLAN DELETE USER ID -------------------------------------------------------]
	    ============================================================================================*/
	    public function user_change_plan_delete_user_id($user_id){
	    	$data = array(

				'user_id'	=> NULL,
				'status'	=> 'Cancelled'

			);

			$this->db->where('user_id',$user_id);
	    	$this->db->update('subscriptions', $data);
	    }

	    /*===========================================================================================
		[-- USERS CLOSE -------------------------------------------------------]
	    ============================================================================================*/
	    public function user_delete($user_id){
	    	$data = array(

	    		'email'	=> '',
				'deleted_at' =>	date('Y-m-d H:i:s')

			);

			$this->db->where('id',$user_id);
	    	$this->db->update('users', $data);
	    }

	}

	