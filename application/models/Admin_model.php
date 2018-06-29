<?php
	class Admin_model extends CI_Model{
		public function __construct(){
			$this->load->database();
		}


		/*===========================================================================
		[-- USERS SEARCH FIELDS WITH PAGINATION-------------------------------------]
	    ===========================================================================*/
	    public function count_users(){
	    	date_default_timezone_set("Europe/London");

	     	if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if($this->input->get('email', TRUE)){
				$this->db->where('email', $this->input->get('email', TRUE)); 
			}

			if($this->input->get('name', TRUE)){
				$this->db->like('CONCAT(first_name," ",last_name)',$this->db->escape_like_str($this->input->get('name', TRUE)));
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}



			if($this->input->get('join_date_after', TRUE) != '' && $this->input->get('join_date_before', TRUE) == ''){
			
				$join_date_after = date_create($this->input->get('join_date_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($join_date_after,'Y-m-d')));
			
			}elseif($this->input->get('join_date_after', TRUE) == '' && $this->input->get('join_date_before', TRUE) != ''){
			
				$join_date_before = date_create($this->input->get('join_date_before', TRUE));
				$date = date_format($join_date_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			
			}elseif($this->input->get('join_date_after', TRUE) != '' && $this->input->get('join_date_before', TRUE) != ''){

				$join_date_after = date_create($this->input->get('join_date_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($join_date_after,'Y-m-d')));

				$join_date_before = date_create($this->input->get('join_date_before', TRUE));
				$date = date_format($join_date_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
				
			}

			if(is_numeric($this->input->get('newsletter', TRUE))){
				$this->db->where('newsletter', $this->input->get('newsletter', TRUE)); 
			}

			if(is_numeric($this->input->get('banned', TRUE))){
				$this->db->where('banned', $this->input->get('banned', TRUE)); 
			}

			if(is_numeric($this->input->get('suspended', TRUE))){
				$this->db->where('suspended', $this->input->get('suspended', TRUE)); 
			}


			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
			}

			if(is_numeric($this->input->get('paying', TRUE))){

	     		if($this->input->get('paying', TRUE) == 0){
	     			$this->db->where('plan_id', '1');
	     		}else{
	     			$this->db->where('plan_id !=', '1');
	     		}
			}

			if(is_numeric($this->input->get('confirmed', TRUE))){

	     		if($this->input->get('confirmed', TRUE) == 1){
	     			$this->db->where('confirm_code', '');
	     		}else{
				 	$this->db->where('confirm_code !=', '');
				}
			}

			$this->db->order_by('id','DESC');
			$query = $this->db->get('users');
			return $query->num_rows();

	    }

	    public function get_users($limit = FALSE, $offset = FALSE){

	    	date_default_timezone_set("Europe/London");



	    	if($limit){
				$this->db->limit($limit, $offset);
			}


			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if($this->input->get('email', TRUE)){
				$this->db->where('email', $this->input->get('email', TRUE)); 
			}

			if($this->input->get('name', TRUE)){
				$this->db->like('CONCAT(first_name," ",last_name)',$this->db->escape_like_str($this->input->get('name', TRUE)));
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('join_date_after', TRUE) != '' && $this->input->get('join_date_before', TRUE) == ''){
			
				$join_date_after = date_create($this->input->get('join_date_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($join_date_after,'Y-m-d')));
			
			}elseif($this->input->get('join_date_after', TRUE) == '' && $this->input->get('join_date_before', TRUE) != ''){
			
				$join_date_before = date_create($this->input->get('join_date_before', TRUE));
				$date = date_format($join_date_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			
			}elseif($this->input->get('join_date_after', TRUE) != '' && $this->input->get('join_date_before', TRUE) != ''){

				$join_date_after = date_create($this->input->get('join_date_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($join_date_after,'Y-m-d')));

				$join_date_before = date_create($this->input->get('join_date_before', TRUE));
				$date = date_format($join_date_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			if(is_numeric($this->input->get('newsletter', TRUE))){
				$this->db->where('newsletter', $this->input->get('newsletter', TRUE)); 
			}

			if(is_numeric($this->input->get('banned', TRUE))){
				$this->db->where('banned', $this->input->get('banned', TRUE)); 
			}

			if(is_numeric($this->input->get('suspended', TRUE))){
				$this->db->where('suspended', $this->input->get('suspended', TRUE)); 
			}

			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}

			if(is_numeric($this->input->get('paying', TRUE))){

	     		if($this->input->get('paying', TRUE) == 0){
	     			$this->db->where('plan_id', '1');
	     		}else{
	     			$this->db->where('plan_id !=', '1');
	     		}
				 
			}

	     	
	     	if(is_numeric($this->input->get('confirmed', TRUE))){

	     		if($this->input->get('confirmed', TRUE) == 1){
	     			$this->db->where('confirm_code', '');
	     		}else{
				 	$this->db->where('confirm_code !=', '');
				}
			}

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('users');
			return $query->result_array();

		}

		/*===========================================================================
		[-- USERS SUBSCRIPTIONS ----------------------------------------------------]
	    ===========================================================================*/
		public function count_users_subscription(){
	    	date_default_timezone_set("Europe/London");

	     	$this->db->where('plan_id',$this->input->get('plan_id', TRUE));
			$users_query = $this->db->get('users');
			$users_suspended = $users_query->result_array();

			foreach($users_query->result_array() as $user_item){

			    $array[] = $user_item['id'];

			}

			if(!empty($array)){

				$this->db->group_start();
					$subscription_array = array_chunk($array,100);

					foreach($subscription_array as $subarray){

						$this->db->or_where_in('user_id', $subarray);
					}

				$this->db->group_end();

			}


			if($this->input->get('id', TRUE)){
				$this->db->where('user_id', $this->input->get('id', TRUE)); 
			}

			if($this->input->get('start_date_after', TRUE) != '' && $this->input->get('start_date_before', TRUE) == ''){
			
				$start_date_after = date_create($this->input->get('start_date_after', TRUE));
				$this->db->where('start_date >=',$this->db->escape_like_str(date_format($start_date_after,'Y-m-d')));
			
			}elseif($this->input->get('start_date_after', TRUE) == '' && $this->input->get('start_date_before', TRUE) != ''){
			
				$start_date_before = date_create($this->input->get('start_date_before', TRUE));
				$date = date_format($start_date_before,'Y-m-d');
				$start_date_before_add = strtotime($date.' +1 day');
				$this->db->where('start_date <',$this->db->escape_like_str(date('Y-m-d',$start_date_before_add)));
			
			}elseif($this->input->get('start_date_after', TRUE) != '' && $this->input->get('start_date_before', TRUE) != ''){

				$start_date_after = date_create($this->input->get('start_date_after', TRUE));
				$this->db->where('start_date >=',$this->db->escape_like_str(date_format($start_date_after,'Y-m-d')));

				$start_date_before = date_create($this->input->get('start_date_before', TRUE));
				$date = date_format($start_date_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('start_date <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
				
			}

			if(is_numeric($this->input->get('paypal_id', TRUE))){
				$this->db->where('paypal_id', $this->input->get('paypal_id', TRUE)); 
			}

			if(is_numeric($this->input->get('active', TRUE))){
				if($this->input->get('active', TRUE) == 0){
	     			$this->db->where('status !=', 'Active');
	     			$this->db->group_start();
						$this->db->where('status !=', 'Active');
						$this->db->or_where('status !=', NULL);
					$this->db->group_end();
	     		}else{
	     			$this->db->where('status', 'Active');
	     		}
			}
	
			$this->db->where('user_id !=','');
			$this->db->order_by('id','DESC');
			$query = $this->db->get('subscriptions');
			return $query->num_rows();

	    }

	    public function get_users_subscription($limit = FALSE, $offset = FALSE){

	    	date_default_timezone_set("Europe/London");


	    	if($limit){
				$this->db->limit($limit, $offset);
			}

			$this->db->where('plan_id',$this->input->get('plan_id', TRUE));
			$users_query = $this->db->get('users');
			$users_suspended = $users_query->result_array();

			foreach($users_query->result_array() as $user_item){

			    $array[] = $user_item['id'];

			}

			if(!empty($array)){

				$this->db->group_start();
					$subscription_array = array_chunk($array,100);

					foreach($subscription_array as $subarray){

						$this->db->or_where_in('user_id', $subarray);
					}

				$this->db->group_end();
			}


			if($this->input->get('id', TRUE)){
				$this->db->where('user_id', $this->input->get('id', TRUE)); 
			}

			if($this->input->get('start_date_after', TRUE) != '' && $this->input->get('start_date_before', TRUE) == ''){
			
				$start_date_after = date_create($this->input->get('start_date_after', TRUE));
				$this->db->where('start_date >=',$this->db->escape_like_str(date_format($start_date_after,'Y-m-d')));
			
			}elseif($this->input->get('start_date_after', TRUE) == '' && $this->input->get('start_date_before', TRUE) != ''){
			
				$start_date_before = date_create($this->input->get('start_date_before', TRUE));
				$date = date_format($start_date_before,'Y-m-d');
				$start_date_before_add = strtotime($date.' +1 day');
				$this->db->where('start_date <',$this->db->escape_like_str(date('Y-m-d',$start_date_before_add)));
			
			}elseif($this->input->get('start_date_after', TRUE) != '' && $this->input->get('start_date_before', TRUE) != ''){

				$start_date_after = date_create($this->input->get('start_date_after', TRUE));
				$this->db->where('start_date >=',$this->db->escape_like_str(date_format($start_date_after,'Y-m-d')));

				$start_date_before = date_create($this->input->get('start_date_before', TRUE));
				$date = date_format($start_date_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('start_date <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
				
			}

			if(is_numeric($this->input->get('paypal_id', TRUE))){
				$this->db->where('paypal_id', $this->input->get('paypal_id', TRUE)); 
			}

			if(is_numeric($this->input->get('active', TRUE))){
				if($this->input->get('active', TRUE) == 0){
	     			$this->db->where('status !=', 'Active');
	     			$this->db->group_start();
						$this->db->where('status !=', 'Active');
						$this->db->or_where('status !=', NULL);
					$this->db->group_end();
	     		}else{
	     			$this->db->where('status', 'Active');
	     		}
			}

			$this->db->where('user_id !=','');
			//$this->db->order_by('id','DESC');
			$query = $this->db->get('subscriptions');
			return $query->result_array();

		}

		/*===========================================================================
		[-- USERS WITH MANY LISTINGS -----------------------------------------------]
	    ===========================================================================*/
	    public function count_users_with_many_listings(){
	    	$this->db->select('*,COUNT("listings.user_id")');
			$this->db->from('users');
			$this->db->join('listings', 'listings.user_id = users.id');

			if($this->input->get('listing_type', TRUE)){
	     		$this->db->where('listing_type',  $this->input->get('listing_type', TRUE));
			}

			$this->db->group_by("listings.user_id");

			$this->db->having( 'COUNT("listings.user_id") >', $this->input->get('number_of', TRUE));

			$query = $this->db->get();

			return $query->num_rows();
	    }

	    public function users_with_many_listings($limit = FALSE, $offset = FALSE){
	    	
	    	$this->db->select('*,COUNT("listings.user_id")');
			$this->db->from('users');
			$this->db->join('listings', 'users.id = listings.user_id');

			if($this->input->get('listing_type', TRUE)){
	     		$this->db->where('listing_type',  $this->input->get('listing_type', TRUE));
			}

			$this->db->group_by("listings.user_id");

			if($this->input->get('number_of', TRUE) != ''){
				$this->db->having( 'COUNT("listings.user_id") >', $this->input->get('number_of', TRUE));
			}

			$query = $this->db->get();

			return $query->result_array();

	    }


	    /*===========================================================================
		[-- USERS SEND BULK EMAIL --------------------------------------------------]
	    ===========================================================================*/
	    public function get_users_send_bulk(){

	    	date_default_timezone_set("Europe/London");

			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if($this->input->get('email', TRUE)){
				$this->db->where('email', $this->input->get('email', TRUE)); 
			}

			if($this->input->get('name', TRUE)){
				$this->db->like('CONCAT(first_name," ",last_name)',$this->db->escape_like_str($this->input->get('name', TRUE)));
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('join_date_after', TRUE) != '' && $this->input->get('join_date_before', TRUE) == ''){
			
				$join_date_after = date_create($this->input->get('join_date_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($join_date_after,'Y-m-d')));
			
			}elseif($this->input->get('join_date_after', TRUE) == '' && $this->input->get('join_date_before', TRUE) != ''){
			
				$join_date_before = date_create($this->input->get('join_date_before', TRUE));
				$date = date_format($join_date_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			
			}elseif($this->input->get('join_date_after', TRUE) != '' && $this->input->get('join_date_before', TRUE) != ''){

				$join_date_after = date_create($this->input->get('join_date_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($join_date_after,'Y-m-d')));

				$join_date_before = date_create($this->input->get('join_date_before', TRUE));
				$date = date_format($join_date_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			if(is_numeric($this->input->get('newsletter', TRUE))){
				$this->db->where('newsletter', $this->input->get('newsletter', TRUE)); 
			}

			if(is_numeric($this->input->get('banned', TRUE))){
				$this->db->where('banned', $this->input->get('banned', TRUE)); 
			}

			if(is_numeric($this->input->get('suspended', TRUE))){
				$this->db->where('suspended', $this->input->get('suspended', TRUE)); 
			}

			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}

			if(is_numeric($this->input->get('paying', TRUE))){

	     		if($this->input->get('paying', TRUE) == 0){
	     			$this->db->where('plan_id', '1');
	     		}else{
	     			$this->db->where('plan_id !=', '1');
	     		}
				 
			}

	     	
	     	if(is_numeric($this->input->get('confirmed', TRUE))){

	     		if($this->input->get('confirmed', TRUE) == 1){
	     			$this->db->where('confirm_code', '');
	     		}
			}

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('users');
			return $query->result_array();

		}

		/*===========================================================================
		[-- USERS EDIT UPDATE ------------------------------------------------------]
	    ===========================================================================*/
	    public function user_update($id){
	    	if($this->input->post('newsletter') != ''){
	    		$newsletter = 1;
	    	}else{
	    		$newsletter = 0;
	    	}

	    	if($this->input->post('monthly_report') != ''){
	    		$monthly_report = 1;
	    	}else{
	    		$monthly_report = 0;
	    	}

	    	if($this->input->post('suspended') != ''){
	    		$suspended = 1;
	    	}else{
	    		$suspended = 0;
	    	}

	    	if($this->input->post('banned') != ''){
	    		$banned = 1;
	    	}else{
	    		$banned = 0;
	    	}
	    	
			date_default_timezone_set("Europe/London");

			if($this->input->post('password') != ''){
				$hash_password = hash('sha512', $this->input->post('password'));
				$data = array(
					'password_hash'		=> $hash_password
				);
				$this->db->where('id', $id);
				$this->db->update('users', $data);
			}

			$data = array(
				'first_name'		=> $this->input->post('firstname'),
				'last_name'			=> $this->input->post('lastname'),
				'email'				=> $this->input->post('email'),
				'phone'				=> $this->input->post('phone'),
				'address'			=> $this->input->post('address'),
				'post_code'			=> $this->input->post('post_code'),
				'country_id'		=> $this->input->post('country_id'),
				'website'			=> $this->input->post('website'),
				'credits'			=> $this->input->post('credits'),
				'featured_credits'	=> $this->input->post('free_featured_week'),
				'newsletter'		=> $newsletter,
				'monthly_report'	=> $monthly_report,
				'suspended'			=> $suspended,
				'banned'			=> $banned,
				'notes'				=> $this->input->post('notes'),
				'confirm_code'		=> $this->input->post('confirm_code'),
				'updated_at'		=> date('Y-m-d H:i:s')
			);
			$this->db->where('id', $id);
			$this->db->update('users', $data);


			if($newsletter == 1){
				$newsletter_txt = 'true';
			}else{
				$newsletter_txt = 'false';
			}

			if($monthly_report == 1){
				$monthly_report_txt = 'true';
			}else{
				$monthly_report_txt = 'false';
			}

			if($suspended == 1){
				$suspended_txt = 'true';
			}else{
				$suspended_txt = 'false';
			}

			if($banned == 1){
				$banned_txt = 'true';
			}else{
				$banned_txt = 'false';
			}

			$auditable_changes = "---\r\n first_name: ".$this->input->post('firstname')."\r\n last_name: ".$this->input->post('lastname')."\r\n email: ".$this->input->post('email')."\r\n phone: ".$this->input->post('phone')."\r\n address: ".$this->input->post('address')."\r\n post_code: ".$this->input->post('post_code')."\r\n country_id: ".$this->input->post('country_id')."\r\n website: ".$this->input->post('website')."\r\n credits: ".$this->input->post('credits')."\r\n featured_credits: ".$this->input->post('free_featured_week')."\r\n newsletter: ".$newsletter_txt."\r\n monthly_report: ".$monthly_report_txt."\r\n suspended: ".$suspended_txt."\r\n banned: ".$banned_txt."\r\n notes: ".$this->input->post('notes')."\r\n ip: ".$this->input->ip_address()."\r\n confirm_code: ".$this->input->post('confirm_code');

			$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;


			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'User',
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			return  $this->db->insert('audits', $data);

	    }

	    /*===========================================================================
		[-- USERS CREATE NEW -------------------------------------------------------]
	    ===========================================================================*/
	    public function user_add(){
	    	if($this->input->post('newsletter') != ''){
	    		$newsletter = 1;
	    	}else{
	    		$newsletter = 0;
	    	}

	    	if($this->input->post('monthly_report') != ''){
	    		$monthly_report = 1;
	    	}else{
	    		$monthly_report = 0;
	    	}

	    	if($this->input->post('suspended') != ''){
	    		$suspended = 1;
	    	}else{
	    		$suspended = 0;
	    	}

	    	if($this->input->post('banned') != ''){
	    		$banned = 1;
	    	}else{
	    		$banned = 0;
	    	}
	    	
			date_default_timezone_set("Europe/London");

			$hash_password = hash('sha512', $this->input->post('password'));
			
			$data = array(
				'first_name'		=> $this->input->post('firstname'),
				'last_name'			=> $this->input->post('lastname'),
				'email'				=> $this->input->post('email'),
				'password_hash'		=> $hash_password,
				'phone'				=> $this->input->post('phone'),
				'address'			=> $this->input->post('address'),
				'post_code'			=> $this->input->post('post_code'),
				'country_id'		=> $this->input->post('country_id'),
				'website'			=> $this->input->post('website'),
				'credits'			=> $this->input->post('credits'),
				'featured_credits'	=> $this->input->post('free_featured_week'),
				'newsletter'		=> $newsletter,
				'monthly_report'	=> $monthly_report,
				'suspended'			=> $suspended,
				'banned'			=> $banned,
				'notes'				=> $this->input->post('notes'),
				'ip'				=> $this->input->ip_address(),
				'confirm_code'		=> $this->input->post('confirm_code'),
				'created_at'		=> date('Y-m-d H:i:s')
			);
			$this->db->insert('users', $data);
			$new_user_id = $this->db->insert_id();

			if($newsletter == 1){
				$newsletter_txt = 'true';
			}else{
				$newsletter_txt = 'false';
			}

			if($monthly_report == 1){
				$monthly_report_txt = 'true';
			}else{
				$monthly_report_txt = 'false';
			}

			if($suspended == 1){
				$suspended_txt = 'true';
			}else{
				$suspended_txt = 'false';
			}

			if($banned == 1){
				$banned_txt = 'true';
			}else{
				$banned_txt = 'false';
			}

			$auditable_changes = "---\r\n first_name: ".$this->input->post('firstname')."\r\n last_name: ".$this->input->post('lastname')."\r\n email: ".$this->input->post('email')."\r\n phone: ".$this->input->post('phone')."\r\n address: ".$this->input->post('address')."\r\n post_code: ".$this->input->post('post_code')."\r\n country_id: ".$this->input->post('country_id')."\r\n website: ".$this->input->post('website')."\r\n credits: ".$this->input->post('credits')."\r\n featured_credits: ".$this->input->post('free_featured_week')."\r\n newsletter: ".$newsletter_txt."\r\n monthly_report: ".$monthly_report_txt."\r\n suspended: ".$suspended_txt."\r\n banned: ".$banned_txt."\r\n notes: ".$this->input->post('notes')."\r\n ip: ".$this->input->ip_address()."\r\n confirm_code: ".$this->input->post('confirm_code');

			$data = array(
				'auditable_id'			=> $new_user_id,
				'auditable_type'		=> 'User',
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'create',
				'audited_changes'		=> $auditable_changes,
				'version'				=> 1,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			return  $this->db->insert('audits', $data);

	    }

	    /*===========================================================================
		[-- USERS DELETE -----------------------------------------------------------]
	    ===========================================================================*/
	    public function user_delete($id){
	    	date_default_timezone_set("Europe/London");

	    	$data = array(
	    		'updated_at'		=> date('Y-m-d H:i:s'),
	    		'deleted_at'		=> date('Y-m-d H:i:s')
	    	);
	    	$this->db->where('id', $id);
			$this->db->update('users', $data);


			$auditable_changes = "---\r\n deleted_at: ".date('Y-m-d H:i:s');

			$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;


			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'User',
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

	    }

	    /*===========================================================================
		[-- USERS UN DELETE --------------------------------------------------------]
	    ===========================================================================*/
	    public function user_un_delete($id){
	    	date_default_timezone_set("Europe/London");
	    	$data = array(
	    		'updated_at'		=> date('Y-m-d H:i:s'),
	    		'deleted_at'		=> NULL
	    	);
	    	$this->db->where('id', $id);
			$this->db->update('users', $data);


			$auditable_changes = "---\r\n un_deleted_at: ".date('Y-m-d H:i:s');

			$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;


			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'User',
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

	    }


	    /*===========================================================================
		[-- LISTINGS SEARCH FIELDS WITH PAGINATION----------------------------------]
	    ===========================================================================*/
	     public function count_listings(){

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('name', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
			}


			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
			
				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
			
			}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
			
				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$date_listed_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
			
			}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			if($this->input->get('listing_type', TRUE) != '' && $this->input->get('listing_type', TRUE) != 'all'){
	     		$this->db->where('listing_type',  $this->input->get('listing_type', TRUE));
			}

			if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
	     		$this->db->where('gender',  $this->input->get('gender', TRUE));
			}


			if(is_numeric($this->input->get('pedigree', TRUE))){
				$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
			}

			if(is_numeric($this->input->get('published', TRUE))){
				$this->db->where('published', $this->input->get('published', TRUE)); 
			}

			if(is_numeric($this->input->get('featured', TRUE))){
				$this->db->where('featured', $this->input->get('featured', TRUE)); 
			}

			if(is_numeric($this->input->get('highlight', TRUE))){
				$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
			}

			if(is_numeric($this->input->get('on_homepage', TRUE))){
				$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
			}
			
			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}	 

			if(is_numeric($this->input->get('user_id', TRUE))){
				$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
			}         

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('listings');
			return $query->num_rows();

	    }

	    public function get_listings($limit = FALSE, $offset = FALSE){

	    	date_default_timezone_set("Europe/London");

	    	if($limit){
				$this->db->limit($limit, $offset);
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('name', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
			}


			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
			
				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
			
			}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
			
				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$date_listed_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
			
			}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			if($this->input->get('listing_type', TRUE) != '' && $this->input->get('listing_type', TRUE) != 'all'){
	     		$this->db->where('listing_type',  $this->input->get('listing_type', TRUE));
			}

			if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
	     		$this->db->where('gender',  $this->input->get('gender', TRUE));
			}


			if(is_numeric($this->input->get('pedigree', TRUE))){
				$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
			}

			if(is_numeric($this->input->get('published', TRUE))){
				$this->db->where('published', $this->input->get('published', TRUE)); 
			}

			if(is_numeric($this->input->get('featured', TRUE))){
				$this->db->where('featured', $this->input->get('featured', TRUE)); 
			}

			if(is_numeric($this->input->get('highlight', TRUE))){
				$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
			}

			if(is_numeric($this->input->get('on_homepage', TRUE))){
				$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
			}
			
			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}	  

			if(is_numeric($this->input->get('user_id', TRUE))){
				$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
			}   
			
			if($this->input->get('keywords', TRUE) == '0' || $this->input->get('keywords', TRUE) == 'zero'){
				$this->db->join('listings', 'listings.user_id = users.id');
				$this->db->where('users.banned !=', 1);
				$this->db->where('users.suspended !=', 1);
				$query = $this->db->get('users');

				return $query->result_array();

			}else{
				//$this->db->order_by('id','DESC');
				$query = $this->db->get('listings');
				return $query->result_array();

			}
			

		}


		/*===========================================================================
		[-- CHECK LISTINGS WITH PAGINATION -----------------------------------------]
	    ===========================================================================*/
	    public function count_listings_check(){



			$this->db->join('users', 'users.id = listings.user_id');

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('description', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('include_paid_accounts', TRUE) == 'true'){
				 
			}else{
				$this->db->where('plan_id', 1);
			}
			
			//$this->db->order_by('id','DESC');
			$query = $this->db->get('listings');
			return $query->num_rows();

	    }

	    public function get_listings_check($limit = FALSE, $offset = FALSE){

	    	if($limit){
				$this->db->limit($limit, $offset);
			}

			$this->db->select('*');
			$this->db->select('listings.id as listing_id');

	    	$this->db->join('users', 'users.id = listings.user_id');

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('description', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('include_paid_accounts', TRUE) == 'true'){
				 
			}else{
				$this->db->where('plan_id', 1);
			}

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('listings');
			return $query->result_array();

		}


		/*===========================================================================
		[-- LISTINGS DOGS SEARCH FIELDS WITH PAGINATION-----------------------------]
	    ===========================================================================*/
	     public function count_listings_dog(){

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('name', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
			}


			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
			
				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
			
			}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
			
				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$date_listed_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
			
			}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			
	     	$this->db->where('listing_type',  'dog');
			

			if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
	     		$this->db->where('gender',  $this->input->get('gender', TRUE));
			}


			if(is_numeric($this->input->get('pedigree', TRUE))){
				$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
			}

			if(is_numeric($this->input->get('published', TRUE))){
				$this->db->where('published', $this->input->get('published', TRUE)); 
			}

			if(is_numeric($this->input->get('featured', TRUE))){
				$this->db->where('featured', $this->input->get('featured', TRUE)); 
			}

			if(is_numeric($this->input->get('highlight', TRUE))){
				$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
			}

			if(is_numeric($this->input->get('on_homepage', TRUE))){
				$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
			}
			
			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}	 

			if(is_numeric($this->input->get('user_id', TRUE))){
				$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
			}         

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('listings');
			return $query->num_rows();

	    }

	    public function get_listings_dog($limit = FALSE, $offset = FALSE){

	    	date_default_timezone_set("Europe/London");

	    	if($limit){
				$this->db->limit($limit, $offset);
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('name', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
			}


			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
			
				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
			
			}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
			
				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$date_listed_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
			
			}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			$this->db->where('listing_type',  'dog');

			if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
	     		$this->db->where('gender',  $this->input->get('gender', TRUE));
			}


			if(is_numeric($this->input->get('pedigree', TRUE))){
				$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
			}

			if(is_numeric($this->input->get('published', TRUE))){
				$this->db->where('published', $this->input->get('published', TRUE)); 
			}

			if(is_numeric($this->input->get('featured', TRUE))){
				$this->db->where('featured', $this->input->get('featured', TRUE)); 
			}

			if(is_numeric($this->input->get('highlight', TRUE))){
				$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
			}

			if(is_numeric($this->input->get('on_homepage', TRUE))){
				$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
			}
			
			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}	  

			if(is_numeric($this->input->get('user_id', TRUE))){
				$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
			}   

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('listings');
			return $query->result_array();

		}

		/*===========================================================================
		[-- LISTINGS PUPPIES SEARCH FIELDS WITH PAGINATION--------------------------]
	    ===========================================================================*/
	     public function count_listings_pup(){

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('name', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
			}


			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
			
				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
			
			}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
			
				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$date_listed_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
			
			}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			
	     	$this->db->where('listing_type',  'pup');
			

			if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
	     		$this->db->where('gender',  $this->input->get('gender', TRUE));
			}


			if(is_numeric($this->input->get('pedigree', TRUE))){
				$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
			}

			if(is_numeric($this->input->get('published', TRUE))){
				$this->db->where('published', $this->input->get('published', TRUE)); 
			}

			if(is_numeric($this->input->get('featured', TRUE))){
				$this->db->where('featured', $this->input->get('featured', TRUE)); 
			}

			if(is_numeric($this->input->get('highlight', TRUE))){
				$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
			}

			if(is_numeric($this->input->get('on_homepage', TRUE))){
				$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
			}
			
			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}	 

			if(is_numeric($this->input->get('user_id', TRUE))){
				$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
			}         

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('listings');
			return $query->num_rows();

	    }

	    public function get_listings_pup($limit = FALSE, $offset = FALSE){

	    	date_default_timezone_set("Europe/London");

	    	if($limit){
				$this->db->limit($limit, $offset);
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('name', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
			}


			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
			
				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
			
			}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
			
				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$date_listed_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
			
			}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			$this->db->where('listing_type',  'pup');

			if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
	     		$this->db->where('gender',  $this->input->get('gender', TRUE));
			}


			if(is_numeric($this->input->get('pedigree', TRUE))){
				$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
			}

			if(is_numeric($this->input->get('published', TRUE))){
				$this->db->where('published', $this->input->get('published', TRUE)); 
			}

			if(is_numeric($this->input->get('featured', TRUE))){
				$this->db->where('featured', $this->input->get('featured', TRUE)); 
			}

			if(is_numeric($this->input->get('highlight', TRUE))){
				$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
			}

			if(is_numeric($this->input->get('on_homepage', TRUE))){
				$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
			}
			
			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}	  

			if(is_numeric($this->input->get('user_id', TRUE))){
				$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
			}   

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('listings');
			return $query->result_array();

		}

		/*===========================================================================
		[-- LISTINGS MEMORIALS SEARCH FIELDS WITH PAGINATION------------------------]
	    ===========================================================================*/
	     public function count_listings_mem(){

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('name', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
			
				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
			
			}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
			
				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$date_listed_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
			
			}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			
	     	$this->db->where('listing_type',  'mem');
			

			if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
	     		$this->db->where('gender',  $this->input->get('gender', TRUE));
			}


			if(is_numeric($this->input->get('pedigree', TRUE))){
				$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
			}

			if(is_numeric($this->input->get('published', TRUE))){
				$this->db->where('published', $this->input->get('published', TRUE)); 
			}

			if(is_numeric($this->input->get('featured', TRUE))){
				$this->db->where('featured', $this->input->get('featured', TRUE)); 
			}

			if(is_numeric($this->input->get('highlight', TRUE))){
				$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
			}

			if(is_numeric($this->input->get('on_homepage', TRUE))){
				$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
			}
			
			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}	 

			if(is_numeric($this->input->get('user_id', TRUE))){
				$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
			}         

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('listings');
			return $query->num_rows();

	    }

	    public function get_listings_mem($limit = FALSE, $offset = FALSE){

	    	date_default_timezone_set("Europe/London");

	    	if($limit){
				$this->db->limit($limit, $offset);
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->group_start();
					$this->db->like('title', $this->input->get('keywords', TRUE));
					$this->db->or_like('name', $this->input->get('keywords', TRUE));
				$this->db->group_end();
			}

			if($this->input->get('id', TRUE)){
				$this->db->where('id', $this->input->get('id', TRUE)); 
			}

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
			}


			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('post_code', TRUE)){
				$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
			}

			if($this->input->get('phone', TRUE)){
				$this->db->where('phone', $this->input->get('phone', TRUE)); 
			}

			if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
			
				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
			
			}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
			
				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$date_listed_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
			
			}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

				$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
				$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

				$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
				$date = date_format($date_listed_before,'Y-m-d');
				$join_date_before_add = strtotime($date.' +1 day');
				$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
			}

			$this->db->where('listing_type',  'mem');

			if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
	     		$this->db->where('gender',  $this->input->get('gender', TRUE));
			}


			if(is_numeric($this->input->get('pedigree', TRUE))){
				$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
			}

			if(is_numeric($this->input->get('published', TRUE))){
				$this->db->where('published', $this->input->get('published', TRUE)); 
			}

			if(is_numeric($this->input->get('featured', TRUE))){
				$this->db->where('featured', $this->input->get('featured', TRUE)); 
			}

			if(is_numeric($this->input->get('highlight', TRUE))){
				$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
			}

			if(is_numeric($this->input->get('on_homepage', TRUE))){
				$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
			}
			
			if(is_numeric($this->input->get('deleted', TRUE))){

	     		if($this->input->get('deleted', TRUE) == 0){
	     			$this->db->group_start();
						$this->db->where('deleted_at', NULL);
						$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
					$this->db->group_end();
	     		}else{
	     			$this->db->where('deleted_at !=', '');
	     		}
				 
			}	  

			if(is_numeric($this->input->get('user_id', TRUE))){
				$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
			}   

			//$this->db->order_by('id','DESC');
			$query = $this->db->get('listings');
			return $query->result_array();

		}

		/*===========================================================================
		[-- LISTINGS EDIT UPDATE ---------------------------------------------------]
	    ===========================================================================*/

		public function update_listing($id){
			
	    	$data = array(
	    		'title'					=> $this->input->post('title'),
	    		'name'					=> $this->input->post('name'),
	    		'kennel_club_name'		=> $this->input->post('kennel_club_name'),
	    		'gender'				=> $this->input->post('gender'),
	    		'breed_id'				=> $this->input->post('breed_id'),
	    		'date_of_birth'			=> $this->input->post('date_of_birth'),
	    		'description'			=> $this->input->post('description'),
	    		'country_id'			=> $this->input->post('country_id'),
	    		'region'				=> $this->input->post('region'),
	    		'post_code'				=> $this->input->post('post_code'),
	    		'pedigree'				=> $this->input->post('pedigree'),
	    		'published'				=> $this->input->post('published'),
	    		'featured'				=> $this->input->post('featured'),
	    		'featured_until'		=> $this->input->post('featured_until'),
	    		'highlight'				=> $this->input->post('highlight'),
	    		'highlight_until'		=> $this->input->post('highlight_until'),
	    		'on_homepage'			=> $this->input->post('on_homepage'),
	    		'on_homepage_until'		=> $this->input->post('on_homepage_until')
	    	);

	    	$this->db->where('id', $id);
	    	$this->db->update('listings',$data);

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

		    	$auditable_changes = "--- \r\n listing_type: ".$listing['listing_type']."\r\n title: ".$listing['title']."\r\n breed_id: ".$listing['breed_id']."\r\n date_of_birth: ".$listing['date_of_birth']."\r\n description: ".$listing['description']."\r\n country_id: ".$listing['country_id']."\r\n region: ".$listing['region']."\r\n post_code: ".$listing['post_code']."\r\n latitude: ".$listing['latitude']."\r\n longitude: ".$listing['longitude']."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$listing['user_id']."\r\n featured: ".$featured_txt."\r\n featured_until: ".$listing['featured_until']."\r\n highlight: ".$highlight_txt."\r\n highlight_until: ".$listing['highlight_until']."\r\n on_homepage: ".$on_homepage_txt."\r\n on_homepage_until: ".$listing['on_homepage_until']."\r\n views: ".$listing['views']."\r\n deleted_at: ".$listing['deleted_at']."\r\n old_id: ".$listing['old_id'];
			
			}elseif($listing['listing_type'] == 'mem'){

		    	$auditable_changes = "--- \r\n listing_type: ".$listing['listing_type']."\r\n title: ".$listing['title']."\r\n name: ".$listing['name']."\r\n kennel_club_name: ".$listing['kennel_club_name']."\r\n gender: ".$listing['gender']."\r\n breed_id: ".$listing['breed_id']."\r\n date_of_birth: ".$listing['date_of_birth']."\r\n date_of_death: ".$listing['date_of_death']."\r\n description: ".$listing['description']."\r\n country_id: ".$listing['country_id']."\r\n region: ".$listing['region']."\r\n post_code: ".$listing['post_code']."\r\n latitude: ".$listing['latitude']."\r\n longitude: ".$listing['longitude']."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$listing['user_id']."\r\n featured: ".$featured_txt."\r\n featured_until: ".$listing['featured_until']."\r\n highlight: ".$highlight_txt."\r\n highlight_until: ".$listing['highlight_until']."\r\n on_homepage: ".$on_homepage_txt."\r\n on_homepage_until: ".$listing['on_homepage_until']."\r\n views: ".$listing['views']."\r\n deleted_at: ".$listing['deleted_at']."\r\n old_id: ".$listing['old_id'];
				
			}else{

				$auditable_changes = "--- \r\n listing_type: ".$listing['listing_type']."\r\n title: ".$listing['title']."\r\n name: ".$listing['name']."\r\n kennel_club_name: ".$listing['kennel_club_name']."\r\n gender: ".$listing['gender']."\r\n breed_id: ".$listing['breed_id']."\r\n date_of_birth: ".$listing['date_of_birth']."\r\n description: ".$listing['description']."\r\n country_id: ".$listing['country_id']."\r\n region: ".$listing['region']."\r\n post_code: ".$listing['post_code']."\r\n latitude: ".$listing['latitude']."\r\n longitude: ".$listing['longitude']."\r\n pedigree: ".$pedigree_txt."\r\n published: ".$published_txt."\r\n user_id: ".$listing['user_id']."\r\n featured: ".$featured_txt."\r\n featured_until: ".$listing['featured_until']."\r\n highlight: ".$highlight_txt."\r\n highlight_until: ".$listing['highlight_until']."\r\n on_homepage: ".$on_homepage_txt."\r\n on_homepage_until: ".$listing['on_homepage_until']."\r\n views: ".$listing['views']."\r\n deleted_at: ".$listing['deleted_at']."\r\n old_id: ".$listing['old_id'];

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
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);



	    }


	    /*===========================================================================
		[-- LISTING DELETE ---------------------------------------------------------]
	    ===========================================================================*/
	    public function listing_delete($id){
	    	date_default_timezone_set("Europe/London");
	    	$data = array(
	    		'deleted_at'		=> date('Y-m-d H:i:s')
	    	);
	    	$this->db->where('id', $id);
			$this->db->update('listings', $data);
	    }

	    /*===========================================================================
		[-- LISTING UN DELETE ------------------------------------------------------]
	    ===========================================================================*/
	    public function listing_un_delete($id){
	    	date_default_timezone_set("Europe/London");
	    	$data = array(
	    		'deleted_at'		=> NULL
	    	);
	    	$this->db->where('id', $id);
			$this->db->update('listings', $data);
	    }


	    /*===========================================================================
		[-- ADD LISTING IMAGE ------------------------------------------------------]
	    ===========================================================================*/
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
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'create',
				'audited_changes'		=> $auditable_changes,
				'version'				=> 1,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

			return $listing_image_id;

		}


	    /*===========================================================================
		[-- DELETE LISTING IMAGE ---------------------------------------------------]
	    ===========================================================================*/
	    public function delete_listing_images($id){

			/*============================================================
			[-- DELETE LISITNG IMAGE ------------------------------------]
		    ============================================================*/
			$this->db->where('id', $id);
			$this->db->delete('listing_images');
			
			$auditable_changes = "---\r\n deleted_at: ".date('Y-m-d H:i:s');

			$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;


			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'ListingImage',
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);

			return true;

		}


	    /*===========================================================================
		[-- CONNECTIONS SEARCH FIELDS WITH PAGINATION ------------------------------]
	    ===========================================================================*/
	    public function count_connections(){

			$this->db->select('*');

			if($this->input->get('breeder_id', TRUE)){
				$this->db->where('id', $this->input->get('breeder_id', TRUE)); 
			}

			if($this->input->get('breeder_name', TRUE)){
				$this->db->like('CONCAT(first_name," ",last_name)',$this->db->escape_like_str($this->input->get('breeder_name', TRUE))); 
			}

			if($this->input->get('breeder_email', TRUE)){
				$this->db->where('email', $this->input->get('breeder_email', TRUE)); 
			}

			if($this->input->get('breeder_phone', TRUE)){
				$this->db->where('phone', $this->input->get('breeder_phone', TRUE)); 
			}

			if($this->input->get('breeder_email', TRUE)){
				$this->db->where('email', $this->input->get('breeder_email', TRUE)); 
			}

			if($this->input->get('breeder_', TRUE)){
				$this->db->where('email', $this->input->get('breeder_email', TRUE)); 
			}

			$users_query = $this->db->get('users');
			$users_suspended = $users_query->result_array();

			foreach($users_query->result_array() as $user_item){

			    $array[] = $user_item['id'];

			}

			$this->db->select('*');
			$this->db->select('connections.id as connect_id');

			if(!empty($array)){
				$this->db->group_start();
					$connection_array = array_chunk($array,100);

					foreach($connection_array as $conn){

						$this->db->or_where_in('user_id', $conn);
					}

				$this->db->group_end();
			}

			$this->db->join('listings', 'listings.id = connections.listing_id');

			$this->db->join('users', 'users.id = connections.buyer_id');

			if($this->input->get('listing_id', TRUE)){
				$this->db->where('listing_id', $this->input->get('listing_id', TRUE)); 
			}

			if($this->input->get('buyer_id', TRUE)){
				$this->db->where('users.id', $this->input->get('buyer_id', TRUE)); 
			}

			if($this->input->get('buyer_name', TRUE)){
				$this->db->like('CONCAT(first_name," ",last_name)',$this->db->escape_like_str($this->input->get('buyer_name', TRUE))); 
			}

			if($this->input->get('buyer_email', TRUE)){
				$this->db->where('users.email', $this->input->get('buyer_email', TRUE)); 
			}

			if($this->input->get('buyer_phone', TRUE)){
				$this->db->where('users.phone', $this->input->get('buyer_phone', TRUE)); 
			}

			if($this->input->get('buyer_email', TRUE)){
				$this->db->where('users.email', $this->input->get('buyer_email', TRUE)); 
			}

			if($this->input->get('buyer_', TRUE)){
				$this->db->where('users.email', $this->input->get('buyer_email', TRUE)); 
			}

			$this->db->order_by('connections.id','DESC');

			$query = $this->db->get('connections');
			return $query->num_rows();

	    }

	    public function get_connections($limit = FALSE, $offset = FALSE){

			$this->db->select('*');

			if($this->input->get('breeder_id', TRUE)){
				$this->db->where('id', $this->input->get('breeder_id', TRUE)); 
			}

			if($this->input->get('breeder_name', TRUE)){
				$this->db->like('CONCAT(first_name," ",last_name)',$this->db->escape_like_str($this->input->get('breeder_name', TRUE))); 
			}

			if($this->input->get('breeder_email', TRUE)){
				$this->db->where('email', $this->input->get('breeder_email', TRUE)); 
			}

			if($this->input->get('breeder_phone', TRUE)){
				$this->db->where('phone', $this->input->get('breeder_phone', TRUE)); 
			}

			if($this->input->get('breeder_email', TRUE)){
				$this->db->where('email', $this->input->get('breeder_email', TRUE)); 
			}

			if($this->input->get('breeder_', TRUE)){
				$this->db->where('email', $this->input->get('breeder_email', TRUE)); 
			}

			$users_query = $this->db->get('users');
			$users_suspended = $users_query->result_array();

			foreach($users_query->result_array() as $user_item){

			    $array[] = $user_item['id'];

			}		

			$this->db->select('*');
			$this->db->select('connections.id as connect_id');

	    	if($limit){
				$this->db->limit($limit, $offset);
			}

			if(!empty($array)){

				$this->db->group_start();
					$connection_array = array_chunk($array,100);

					foreach($connection_array as $conn){

						$this->db->or_where_in('user_id', $conn);
					}

				$this->db->group_end();
		
			}

			$this->db->join('listings', 'listings.id = connections.listing_id');

			$this->db->join('users', 'users.id = connections.buyer_id');

			if($this->input->get('listing_id', TRUE)){
				$this->db->where('listing_id', $this->input->get('listing_id', TRUE)); 
			}
			
			if($this->input->get('buyer_id', TRUE)){
				$this->db->where('users.id', $this->input->get('buyer_id', TRUE)); 
			}

			if($this->input->get('buyer_name', TRUE)){
				$this->db->like('CONCAT(first_name," ",last_name)',$this->db->escape_like_str($this->input->get('buyer_name', TRUE))); 
			}

			if($this->input->get('buyer_email', TRUE)){
				$this->db->where('users.email', $this->input->get('buyer_email', TRUE)); 
			}

			if($this->input->get('buyer_phone', TRUE)){
				$this->db->where('users.phone', $this->input->get('buyer_phone', TRUE)); 
			}

			if($this->input->get('buyer_email', TRUE)){
				$this->db->where('users.email', $this->input->get('buyer_email', TRUE)); 
			}

			if($this->input->get('buyer_', TRUE)){
				$this->db->where('users.email', $this->input->get('buyer_email', TRUE)); 
			}

			$this->db->order_by('connections.id','DESC');

			$query = $this->db->get('connections');

			return $query->result_array();

		}


		/*=====================================================
		[-- CONNECTIONS UPDATE --------------------------------]
	    ======================================================*/

		public function connection_update($id){

	    	$data = array(
	    		'notes'	=> $this->input->post('notes')
	    	);

	    	$this->db->where('id', $id);
	    	$this->db->update('connections',$data);
	    }


		/*=====================================================
		[-- KENNEL CLUB GROUP --------------------------------]
	    ======================================================*/

		public function get_kennel_with_id($kennel_id){
		 	$query = $this->db->get_where('kennel_club_groups', array('id' => $kennel_id));
			return $query->row_array();
		}



		/*===========================================================================
		[-- BREEDS SEARCH FIELDS WITH PAGINATION -----------------------------------]
	    ===========================================================================*/
	    public function count_breeds(){

			if($this->input->get('breed_name', TRUE)){
				$this->db->like('name', $this->input->get('breed_name', TRUE)); 
			}

			if(is_numeric($this->input->get('kennel_club_group', TRUE))){
				$this->db->where('kennel_club_group_id', $this->input->get('kennel_club_group', TRUE)); 
			}
		
			$query = $this->db->get('breeds');

			return $query->num_rows();

	    }

	    public function get_breeds($limit = FALSE, $offset = FALSE){

	    	if($limit){
				$this->db->limit($limit, $offset);
			}

			if($this->input->get('breed_name', TRUE)){
				$this->db->like('name', $this->input->get('breed_name', TRUE)); 
			}

			if(is_numeric($this->input->get('kennel_club_group', TRUE))){
				$this->db->where('kennel_club_group_id', $this->input->get('kennel_club_group', TRUE)); 
			}
		
			$query = $this->db->get('breeds');

			return $query->result_array();

		}


		/*=====================================================
		[-- BREEDS -------------------------------------------]
	    ======================================================*/
	    
		public function get_breeds_id($id){
			$query = $this->db->get_where('breeds', array('id' => $id));
			return $query->result_array();
		}

	    public function add_breed(){

	    	$slug = url_title($this->input->post('breed_name'), 'dash', TRUE);
	    	date_default_timezone_set("Europe/London");
			
	    	$data = array(
	    		'name'						=> $this->input->post('breed_name'),
	    		'url_name'					=> $slug,
	    		'created_at'				=> date('Y-m-d H:i:s'),
	    		'kennel_club_group_id'		=> $this->input->post('kennel_club_group'),
	    		'dog_size'					=> $this->input->post('dog_size'),
	    		'bitch_size'				=> $this->input->post('bitch_size'),
	    		'dog_weight'				=> $this->input->post('dog_weight'),
	    		'bitch_weight'				=> $this->input->post('bitch_weight'),
	    		'description'				=> $this->input->post('general_description'),
	    		'health'					=> $this->input->post('general_health'),
	    		'illnesses'					=> $this->input->post('hereditary_illnesses'),
	    		'temperament'				=> $this->input->post('character_temperament'),
	    		'food'						=> $this->input->post('food'),
	    		'exercise'					=> $this->input->post('exercise'),
	    		'grooming'					=> $this->input->post('grooming'),
	    		'litter_size'				=> $this->input->post('litter_size'),
	    		'life_expectancy'			=> $this->input->post('life_expectancy'),
	    		'origin'					=> $this->input->post('origin'),
	    		'other_info'				=> $this->input->post('other_info'),
	    		'puppy_price'				=> $this->input->post('puppy_price')
	    	);

	    	$this->db->insert('breeds',$data);
	    	return $this->db->insert_id();
	    }

	    public function add_breed_image($breed_image,$id){

	    	$data = array(
	    		'image'	=> $breed_image
	    	);

	    	$this->db->where('id', $id);
	    	$this->db->update('breeds',$data);
	    }

	    public function update_breed($breed_image,$id){

	    	$slug = url_title($this->input->post('breed_name'), 'dash', TRUE);
	    	date_default_timezone_set("Europe/London");
			
	    	$data = array(
	    		'name'						=> $this->input->post('breed_name'),
	    		'url_name'					=> $slug,
	    		'updated_at'				=> date('Y-m-d H:i:s'),
	    		'kennel_club_group_id'		=> $this->input->post('kennel_club_group'),
	    		'dog_size'					=> $this->input->post('dog_size'),
	    		'bitch_size'				=> $this->input->post('bitch_size'),
	    		'dog_weight'				=> $this->input->post('dog_weight'),
	    		'bitch_weight'				=> $this->input->post('bitch_weight'),
	    		'description'				=> $this->input->post('general_description'),
	    		'health'					=> $this->input->post('general_health'),
	    		'illnesses'					=> $this->input->post('hereditary_illnesses'),
	    		'temperament'				=> $this->input->post('character_temperament'),
	    		'food'						=> $this->input->post('food'),
	    		'exercise'					=> $this->input->post('exercise'),
	    		'grooming'					=> $this->input->post('grooming'),
	    		'litter_size'				=> $this->input->post('litter_size'),
	    		'life_expectancy'			=> $this->input->post('life_expectancy'),
	    		'origin'					=> $this->input->post('origin'),
	    		'other_info'				=> $this->input->post('other_info'),
	    		'puppy_price'				=> $this->input->post('puppy_price'),
	    		'image'						=> $breed_image
	    	);

	    	$this->db->where('id', $id);
	    	$this->db->update('breeds',$data);

	    }

	    public function get_edit_breed_unique($id){
			$this->db->from('breeds');
			$this->db->where('id', $id);
			$result = $this->db->get();
			return $result->row_array();
		}

		public function delete_breed($id){
			$this->db->where('id', $id);
			$this->db->delete('breeds');
			return true;
		}

		/*=====================================================
		[-- PAGES -------------------------------------------]
	    ======================================================*/

		public function get_edit_page($id){
			$this->db->from('pages');
			$this->db->where('id', $id);
			$result = $this->db->get();
			return $result->result_array();
		}

		public function page_update($id){

	    	if($this->input->post('page_index') == 1){
	    		$page_index = 'INDEX';

	    	}else{
	    		$page_index = 'NOINDEX';
	    	}

	    	if($this->input->post('page_follow') == 1){
	    		$page_follow = 'FOLLOW';

	    	}else{
	    		$page_follow = 'NOFOLLOW';
	    	}

	    	$meta_robots = $page_index . ',' . $page_follow;

	    	if($this->input->post('page_published') != ''){
	    		$page_published = 1;
	    	}else{
	    		$page_published = 0;
	    	}

	    	date_default_timezone_set("Europe/London");
	    	$data = array(
	    		'title'				=> $this->input->post('page_title'),
	    		'content'			=> $this->input->post('page_content'),
	    		'updated_at'		=> date('Y-m-d H:i:s'),
	    		'url'				=> $this->input->post('page_url'),
	    		'language'			=> $this->input->post('page_language'),
	    		'description'		=> $this->input->post('page_description'),
	    		'published'			=> $page_published,
	    		'template'			=> $this->input->post('page_template'),
	    		'meta_title'		=> $this->input->post('page_seo_title'),
	    		'meta_keyword'		=> $this->input->post('page_meta_keyword'),
	    		'meta_description'	=> $this->input->post('page_meta_description'),
	    		'meta_robots'		=> $meta_robots
	    	);

	    	$this->db->where('id', $id);
	    	$this->db->update('pages',$data);

	    	if($page_published == 1){
	    		$published_txt = 'true';
	    	}else{
	    		$published_txt = 'false';
	    	}

	    	$auditable_changes = "---\r\n title: ".$this->input->post('page_title')."\r\n content: ".$this->input->post('page_content')."\r\n url: ".$this->input->post('page_url')."\r\n language: ".$this->input->post('page_language')."\r\n description: ".$this->input->post('page_description')."\r\n published: ".$published_txt."\r\n template: ".$this->input->post('page_template')."\r\n meta_title: ".$this->input->post('page_seo_title')."\r\n meta_keyword: ".$this->input->post('page_meta_keyword')."\r\n meta_description: ".$this->input->post('page_meta_description')."\r\n meta_robots: ".$meta_robots;

	    	$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'Page',
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'update',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			return  $this->db->insert('audits', $data);

	    }

	    public function delete_page($id){

			$this->db->where('id', $id);
	    	$query = $this->db->get('pages');
	    	$audits_page = $query->row_array();

	    	if($audits_page['published'] == 1){
	    		$published_txt = 'true';
	    	}else{
	    		$published_txt = 'false';
	    	}

			$auditable_changes = "---\r\n title: ".$audits_page['title']."\r\n content: ".$audits_page['content']."\r\n url: ".$audits_page['url']."\r\n language: ".$audits_page['language']."\r\n description: ".$audits_page['description']."\r\n published: ".$published_txt."\r\n template: ".$audits_page['template']."\r\n meta_title: ".$audits_page['meta_title']."\r\n meta_keyword: ".$audits_page['meta_keyword']."\r\n meta_description: ".$audits_page['meta_description']."\r\n meta_robots: ".$audits_page['meta_robots'];

	    	$this->db->select('version');
			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $id);
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$version_sum = $version_query['version'] + 1;

			$data = array(
				'auditable_id'			=> $id,
				'auditable_type'		=> 'Page',
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'destroy',
				'audited_changes'		=> $auditable_changes,
				'version'				=> $version_sum,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->insert('audits', $data);


			$this->db->where('id', $id);
			$this->db->delete('pages');
			return true;
		}

	    public function page_add_new(){

	    	if($this->input->post('page_index') == 1){
	    		$page_index = 'INDEX';

	    	}else{
	    		$page_index = 'NOINDEX';
	    	}

	    	if($this->input->post('page_follow') == 1){
	    		$page_follow = 'FOLLOW';

	    	}else{
	    		$page_follow = 'NOFOLLOW';
	    	}

	    	$meta_robots = $page_index . ',' . $page_follow;

	    	if($this->input->post('page_published') != ''){
	    		$page_published = 1;
	    	}else{
	    		$page_published = 0;
	    	}

	    	date_default_timezone_set("Europe/London");
	    	$data = array(
	    		'title'				=> $this->input->post('page_title'),
	    		'content'			=> $this->input->post('page_content'),
	    		'created_at'		=> date('Y-m-d H:i:s'),
	    		'url'				=> $this->input->post('page_url'),
	    		'language'			=> $this->input->post('page_language'),
	    		'description'		=> $this->input->post('page_description'),
	    		'published'			=> $page_published,
	    		'template'			=> $this->input->post('page_template'),
	    		'meta_title'		=> $this->input->post('page_seo_title'),
	    		'meta_keyword'		=> $this->input->post('page_meta_keyword'),
	    		'meta_description'	=> $this->input->post('page_meta_description'),
	    		'meta_robots'		=> $meta_robots
	    	);

	    	$this->db->insert('pages',$data);
	    	$new_page_id = $this->db->insert_id();

	    	if($page_published == 1){
	    		$published_txt = 'true';
	    	}else{
	    		$published_txt = 'false';
	    	}

	    	$auditable_changes = "---\r\n title: ".$this->input->post('page_title')."\r\n content: ".$this->input->post('page_content')."\r\n url: ".$this->input->post('page_url')."\r\n language: ".$this->input->post('page_language')."\r\n description: ".$this->input->post('page_description')."\r\n published: ".$published_txt."\r\n template: ".$this->input->post('page_template')."\r\n meta_title: ".$this->input->post('page_seo_title')."\r\n meta_keyword: ".$this->input->post('page_meta_keyword')."\r\n meta_description: ".$this->input->post('page_meta_description')."\r\n meta_robots: ".$meta_robots;


			$data = array(
				'auditable_id'			=> $new_page_id,
				'auditable_type'		=> 'Page',
				'user_id'				=> $this->session->userdata('admin_id_byd'),
				'user_type'				=> 'Admin',
				'action'				=> 'create',
				'audited_changes'		=> $auditable_changes,
				'version'				=> 1,
				'remote_address'		=> $this->input->ip_address(),
				'created_at'			=> date('Y-m-d H:i:s')
			);

			return  $this->db->insert('audits', $data);

	    }


	    /*=====================================================
		[-- ORDERS -------------------------------------------]
	    ======================================================*/
	    public function count_orders(){
	    	$this->db->order_by('id','DESC');
	    	$this->db->where('status','Completed');
	    	$query = $this->db->get('payments');
			return $query->num_rows();	
	    }

	    public function get_orders($limit = FALSE, $offset = FALSE){
	     	if($limit){
				$this->db->limit($limit, $offset);
			}

	     	$this->db->order_by('id','DESC');
	    	$this->db->where('status','Completed');
	    	$query = $this->db->get('payments');
			return $query->result_array();	
	    }

	    /*=====================================================
		[-- ORDERS VIEW --------------------------------------]
	    ======================================================*/
	    public function get_order_view($id){
	     	$this->db->from('payments');
			$this->db->where('id', $id);
			$result = $this->db->get();
			return $result->row_array();	
	    }

		/*=====================================================
		[-- ADMINS -------------------------------------------]
	    ======================================================*/

		public function get_edit_admin($id){
			$this->db->from('admins');
			$this->db->where('id', $id);
			$result = $this->db->get();
			return $result->result_array();
		}

		public function get_edit_admin_unique($id){
			$this->db->from('admins');
			$this->db->where('id', $id);
			$result = $this->db->get();
			return $result->row_array();
		}

		public function admin_new($hash_password){
			date_default_timezone_set("Europe/London");
			$data = array(
				'username'		=> $this->input->post('admin_username'),
				'email'			=> $this->input->post('admin_email'),
				'password_hash'	=> $hash_password,
				'name'			=> $this->input->post('admin_name'),
				'ip'			=> $this->input->ip_address(),
				'last_login'	=> date('Y-m-d H:i:s'),
				'created_at'	=> date('Y-m-d H:i:s')
			);

			return $this->db->insert('admins', $data);

		}

		public function admin_update($hash_password, $id){

			date_default_timezone_set("Europe/London");
			$data = array(
				'username'		=> $this->input->post('admin_username'),
				'email'			=> $this->input->post('admin_email'),
				'password_hash'	=> $hash_password,
				'name'			=> $this->input->post('admin_name'),
				'ip'			=> $this->input->ip_address(),
				'updated_at'	=> date('Y-m-d H:i:s')
			);
			$this->db->where('id', $id);
			$this->db->update('admins', $data);
		}

		public function delete_admin($id){
			$this->db->where('id', $id);
			$this->db->delete('admins');
			return true;
		}

		public function login($username, $password){
			$this->db->from('admins');
			$this->db->where('username', $username);

			$result = $this->db->get()->result();

			foreach ($result as $login)
			{  
				$id = $login->id;
				$hash = $login->password_hash;

			}

			if($hash == hash('sha512', $password)){

				return $id;

			}else{

				return false;

			}
		}

		public function adminlast_login($user_id){ 
			date_default_timezone_set("Europe/London");
			$data = array(
			     'last_login' => date('Y-m-d H:i:s')
			);
			$this->db->where('id', $user_id);
			$this->db->update('admins', $data);
		}


		/*===========================================================================
		[-- ALL IMAGES WITH PAGINATION ---------------------------------------------]
	    ===========================================================================*/
	    public function count_images(){

			$this->db->order_by('id','DESC');

			$query = $this->db->get('listing_images');

			return $query->num_rows();

	    }

	    public function get_images($limit = FALSE, $offset = FALSE){

	    	if($limit){
				$this->db->limit($limit, $offset);
			}

			$this->db->order_by('id','DESC');

			$query = $this->db->get('listing_images');

			return $query->result_array();

		}


		/*===========================================================================
		[-- ALL IMAGES WITH PAGINATION ON HOME PAGE --------------------------------]
	    ===========================================================================*/
		    public function count_images_on_homepage(){

				$this->db->order_by('id','DESC');

				$this->db->where('on_homepage', 1);

				$query = $this->db->get('listing_images');

				return $query->num_rows();

		    }

		    public function get_images_on_homepage($limit = FALSE, $offset = FALSE){

		    	if($limit){
					$this->db->limit($limit, $offset);
				}

				$this->db->order_by('id','DESC');

				$this->db->where('on_homepage', 1);

				$query = $this->db->get('listing_images');

				return $query->result_array();

			}

		/*===========================================================================
		[-- LISTINGS SEARCH FIELDS WITH PAGINATION----------------------------------]
	    ===========================================================================*/
		    public function count_images_search(){

				if($this->input->get('keywords', TRUE) != ''){
					$this->db->group_start();
						$this->db->like('title', $this->input->get('keywords', TRUE));
						$this->db->or_like('name', $this->input->get('keywords', TRUE));
					$this->db->group_end();
				}

				if($this->input->get('id', TRUE)){
					$this->db->where('id', $this->input->get('id', TRUE)); 
				}

				if(is_numeric($this->input->get('breed_id', TRUE))){
					$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
				}


				if(is_numeric($this->input->get('country_id', TRUE))){
					$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
				}

				if($this->input->get('post_code', TRUE)){
					$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
				}

				if($this->input->get('phone', TRUE)){
					$this->db->where('phone', $this->input->get('phone', TRUE)); 
				}

				if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
				
					$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
					$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
				
				}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
				
					$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
					$date = date_format($date_listed_before,'Y-m-d');
					$date_listed_before_add = strtotime($date.' +1 day');
					$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
				
				}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

					$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
					$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

					$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
					$date = date_format($date_listed_before,'Y-m-d');
					$join_date_before_add = strtotime($date.' +1 day');
					$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
				}

				if($this->input->get('listing_type', TRUE) != '' && $this->input->get('listing_type', TRUE) != 'all'){
		     		$this->db->where('listing_type',  $this->input->get('listing_type', TRUE));
				}

				if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
		     		$this->db->where('gender',  $this->input->get('gender', TRUE));
				}


				if(is_numeric($this->input->get('pedigree', TRUE))){
					$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
				}

				if(is_numeric($this->input->get('published', TRUE))){
					$this->db->where('published', $this->input->get('published', TRUE)); 
				}

				if(is_numeric($this->input->get('featured', TRUE))){
					$this->db->where('featured', $this->input->get('featured', TRUE)); 
				}

				if(is_numeric($this->input->get('highlight', TRUE))){
					$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
				}

				if(is_numeric($this->input->get('on_homepage', TRUE))){
					$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
				}
				
				if(is_numeric($this->input->get('deleted', TRUE))){

		     		if($this->input->get('deleted', TRUE) == 0){
		     			$this->db->group_start();
							$this->db->where('deleted_at', NULL);
							$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
						$this->db->group_end();
		     		}else{
		     			$this->db->where('deleted_at !=', '');
		     		}
					 
				}	 

				if(is_numeric($this->input->get('user_id', TRUE))){
					$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
				}         

				$query = $this->db->get('listings');

				foreach($query->result_array() as $image_item){

				    $array[] = $image_item['id'];

				}

				if(!empty($array)){
					$this->db->group_start();
						$image_search = array_chunk($array,100);

						foreach($image_search as $imgs){

							$this->db->or_where_in('listing_id', $imgs);
						}
					$this->db->group_end();
				}else{
					$this->db->where('sort', 'NULL');
				}

				$this->db->order_by('id','DESC');

				$query = $this->db->get('listing_images');

				return $query->num_rows();

		    }

		    public function get_images_search($limit = FALSE, $offset = FALSE){

		    	date_default_timezone_set("Europe/London");

				if($this->input->get('keywords', TRUE) != ''){
					$this->db->group_start();
						$this->db->like('title', $this->input->get('keywords', TRUE));
						$this->db->or_like('name', $this->input->get('keywords', TRUE));
					$this->db->group_end();
				}

				if($this->input->get('id', TRUE)){
					$this->db->where('id', $this->input->get('id', TRUE)); 
				}

				if(is_numeric($this->input->get('breed_id', TRUE))){
					$this->db->where('breed_id', $this->input->get('breed_id', TRUE)); 
				}


				if(is_numeric($this->input->get('country_id', TRUE))){
					$this->db->where('country_id', $this->input->get('country_id', TRUE)); 
				}

				if($this->input->get('post_code', TRUE)){
					$this->db->where('post_code', $this->input->get('post_code', TRUE)); 
				}

				if($this->input->get('phone', TRUE)){
					$this->db->where('phone', $this->input->get('phone', TRUE)); 
				}

				if($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) == ''){
				
					$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
					$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));
				
				}elseif($this->input->get('date_listed_after', TRUE) == '' && $this->input->get('date_listed_before', TRUE) != ''){
				
					$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
					$date = date_format($date_listed_before,'Y-m-d');
					$date_listed_before_add = strtotime($date.' +1 day');
					$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$date_listed_before_add)));
				
				}elseif($this->input->get('date_listed_after', TRUE) != '' && $this->input->get('date_listed_before', TRUE) != ''){

					$date_listed_after = date_create($this->input->get('date_listed_after', TRUE));
					$this->db->where('created_at >=',$this->db->escape_like_str(date_format($date_listed_after,'Y-m-d')));

					$date_listed_before = date_create($this->input->get('date_listed_before', TRUE));
					$date = date_format($date_listed_before,'Y-m-d');
					$join_date_before_add = strtotime($date.' +1 day');
					$this->db->where('created_at <',$this->db->escape_like_str(date('Y-m-d',$join_date_before_add)));
				}

				if($this->input->get('listing_type', TRUE) != '' && $this->input->get('listing_type', TRUE) != 'all'){
		     		$this->db->where('listing_type',  $this->input->get('listing_type', TRUE));
				}

				if($this->input->get('gender', TRUE) != '' && $this->input->get('gender', TRUE) != 'all'){
		     		$this->db->where('gender',  $this->input->get('gender', TRUE));
				}


				if(is_numeric($this->input->get('pedigree', TRUE))){
					$this->db->where('pedigree', $this->input->get('pedigree', TRUE)); 
				}

				if(is_numeric($this->input->get('published', TRUE))){
					$this->db->where('published', $this->input->get('published', TRUE)); 
				}

				if(is_numeric($this->input->get('featured', TRUE))){
					$this->db->where('featured', $this->input->get('featured', TRUE)); 
				}

				if(is_numeric($this->input->get('highlight', TRUE))){
					$this->db->where('highlight', $this->input->get('highlight', TRUE)); 
				}

				if(is_numeric($this->input->get('on_homepage', TRUE))){
					$this->db->where('on_homepage', $this->input->get('on_homepage', TRUE)); 
				}
				
				if(is_numeric($this->input->get('deleted', TRUE))){

		     		if($this->input->get('deleted', TRUE) == 0){
		     			$this->db->group_start();
							$this->db->where('deleted_at', NULL);
							$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
						$this->db->group_end();
		     		}else{
		     			$this->db->where('deleted_at !=', '');
		     		}
					 
				}	  

				if(is_numeric($this->input->get('user_id', TRUE))){
					$this->db->where('user_id', $this->input->get('user_id', TRUE)); 
				}   

				$query = $this->db->get('listings');

				foreach($query->result_array() as $image_item){

				    $array[] = $image_item['id'];

				}

				if(!empty($array)){
					$this->db->group_start();
						$image_search = array_chunk($array,100);

						foreach($image_search as $imgs){

							$this->db->or_where_in('listing_id', $imgs);
						}
					$this->db->group_end();
				}else{
					$this->db->where('sort', 'NULL');
				}

				if($limit){
					$this->db->limit($limit, $offset);
				}

				$this->db->order_by('id','DESC');

				$query = $this->db->get('listing_images');

				return $query->result_array();

			}

		/*===========================================================================
		[-- SAVE IMAGES ON HOMEPAGE ------------------------------------------------]
	    ===========================================================================*/
	    public function image_save_on_home($id){
	    	if($this->input->post('on_homepage') != ''){
	    		$on_home = 1;
	    	}else{
	    		$on_home = 0;
	    	}

	    	if($this->input->post('dont_display') != ''){
	    		$dont_display = 1;
	    	}else{
	    		$dont_display = 0;
	    	}

	    	$data = array(
	    		'on_homepage' => $on_home,
	    		'dont_display' => $dont_display,
	    		'homepage_title' => $this->input->post('homepage_title')
	    	);
	    	$this->db->where('id', $id);
			$this->db->update('listing_images', $data);

	    }

	    /*===========================================================================================
		[-- BACK USER PLAN TO FREE (SUSPENDED OR BANNED) -------------------------------------------------]
	    ============================================================================================*/

	    public function change_plan_suspended_banned($user_id){
	    	$data = array(

				'plan_id'	=> 1

			);

			$this->db->where('id',$user_id);
	    	$this->db->update('users', $data);
	    }
		

	}
