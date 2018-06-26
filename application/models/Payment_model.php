<?php 
	class Payment_model extends CI_Model{

		/*=================================================================================
		[-- USERS PAYED SUBCRIPTION IN PAYPAL --------------------------------------------]
	    =================================================================================*/
		public function subscription_payment(){
			$data = array(
				'plan_id' => $this->input->get('item_number', TRUE)
			);
			$this->db->where('id', $this->input->get('cm', TRUE));
			$this->db->update('users', $data);
		}

		/*=================================================================================
		[-- CUSTOMER SUBCRIPTION IN PAYPAL COMPLETED -------------------------------------]
	    =================================================================================*/
		public function subscription_active(){
			date_default_timezone_set("Europe/London");
			$datenow = date('Y-m-d H:i:s'); 
	    	$payment_date_add_month = strtotime( $datenow.' +1 month');
			$next_payment_date = date('Y-m-d H:i:s',$payment_date_add_month);

			$data = array(
				'user_id' 				=> $this->input->get('cm', TRUE),
				/*'paypal_id'				=> '',*/
				'start_date'			=> date('Y-m-d H:i:s'),
				'next_payment_date'		=> $next_payment_date,
				'status'				=> 'active',
				/*'error'					=> '',*/
				'created_at'			=> date('Y-m-d H:i:s'),
				'updated_at'			=> date('Y-m-d H:i:s')
			);
			return $this->db->insert('subscriptions',$data);
		}


		/*=====================================================================================================
		[-- GET SUBSCRIPTION USING USER ID -------------------------------------------------------------------]
	    =====================================================================================================*/
	    public function get_subscription($user_id){

			$this->db->where('user_id', $user_id);
	    	$query = $this->db->get('subscriptions');
	    	return $query->row_array();

		}


		/*=====================================================================================================
		[-- SUBSCRIPTION IPN EXPRESS CHECKOUT ----------------------------------------------------------------]
	    =====================================================================================================*/
	    public function subscription_ipn_ec($custom_id,$transaction_id,$payer_id){

			$data = array(

				'paypal_id'	=> $payer_id
				
			);

			$this->db->where('user_id',$custom_id);
			$this->db->where('paypal_id',$transaction_id);
	    	$this->db->update('subscriptions', $data);

		}

		/*============================================================================================================
		[-- SUBSCRIPTION IPN RECURRING CREATE -----------------------------------------------------------------------]
	    ============================================================================================================*/
	    public function subscription_ipn_rec_create($payer_id,$recurring_payment_id,$time_created,$next_payment_date,$status){

	    	date_default_timezone_set("Europe/London");

			$startdate = $time_created; 
			$payment_date_start_date = strtotime($startdate);
			$start_payment_date = date('Y-m-d H:i:s',$payment_date_start_date);

			$nextdate = $next_payment_date; 
			$payment_date_next_date = strtotime($nextdate);
			$next_payment_date = date('Y-m-d H:i:s',$payment_date_next_date);


			$data = array(

				'paypal_id'				=> $recurring_payment_id,
				'start_date'			=> $start_payment_date,
				'next_payment_date'		=> $next_payment_date,
				'status'				=> $status,
				'first_payment_taken'	=> 1,
				'created_at'			=> date('Y-m-d H:i:s'),
				'updated_at'			=> date('Y-m-d H:i:s')
				
			);

			$this->db->where('paypal_id',$payer_id);
	    	$this->db->update('subscriptions', $data);

		}


		/*============================================================================================================
		[-- SUBSCRIPTION IPN RECURRING PAYMENTS ---------------------------------------------------------------------]
	    ============================================================================================================*/
		public function subscription_ipn_recurring_paments($recurring_payment_id,$next_payment_date,$status){

			date_default_timezone_set("Europe/London");

			$nextdate = $next_payment_date; 
			$payment_date_next_date = strtotime($nextdate);
			$next_payment_date = date('Y-m-d H:i:s',$payment_date_next_date);


			$data = array(

				'next_payment_date'		=> $next_payment_date,
				'status'				=> $status,
				'updated_at'			=> date('Y-m-d H:i:s')

			);

			$this->db->where('paypal_id',$recurring_payment_id);
	    	$this->db->update('subscriptions', $data);



	    	/*if($status == 'Active'){

	    		$this->db->where('paypal_id', $recurring_payment_id);
				$this->db->order_by('id DESC');
				$query = $this->db->get('subscriptions');
				$sub_user = $query->row_array();

				$this->db->where('user_id', $sub_user['user_id']);
				$this->db->order_by('id DESC');
				$query = $this->db->get('audits');
				$audit_user = $query->row_array();

				if($sub_user['first_payment_taken'] == 1){

					$first_payment_taken_txt = 'true';

				}else{

					$first_payment_taken_txt = 'true';
				}


				$auditable_changes = "---\r\n user_id: ".$sub_user['user_id']."\r\n paypal_id: ".$sub_user['paypal_id']."\r\n start_date: ".$sub_user['start_date']."\r\n next_payment_date: ".$sub_user['next_payment_date']."\r\n status: ".$sub_user['status']."\r\n first_payment_taken: ".$first_payment_taken_txt."\r\n error: ".$sub_user['error'];

				$this->db->select('version');
				$this->db->order_by('version', 'DESC');
				$this->db->where('auditable_id', $id);
				$query = $this->db->get('audits');
				$version_query = $query->row_array();

				$version_sum = $version_query['version'] + 1;

				$data = array(
					'auditable_id'			=> $audit_user['auditable_id'],
					'auditable_type'		=> 'subscription',
					'user_id'				=> $sub_user['user_id'],
					'action'				=> 'update',
					'audited_changes'		=> $auditable_changes,
					'version'				=> $version_sum,
					'created_at'			=> date('Y-m-d H:i:s')
				);

				$this->db->insert('audits', $data);


	    	}*/


	    	if($status != 'Active'){

	    		$data = array(

					'first_payment_taken'	=> 0,
					'next_payment_date'		=> NULL

				);

				$this->db->where('paypal_id',$recurring_payment_id);
		    	$this->db->update('subscriptions', $data);


		    	$this->db->where('paypal_id',$recurring_payment_id);
	    		$query = $this->db->get('subscriptions');
	    		$user_subscription = $query->row_array();


		    	$data = array(

					'plan_id'	=> 1

				);

				$this->db->where('id',$user_subscription['user_id']);
		    	$this->db->update('users', $data);


		    	$this->db->where('user_id',$user_subscription['user_id']);
		    	$this->db->order_by('id', 'DESC');
	    		$query = $this->db->get('listings');
	    		$newest_listing = $query->row_array();



	    		$data = array(

					'published'			=> 0,
					'updated_at'		=> date('Y-m-d H:i:s')

				);

	    		$this->db->where('id !=', $newest_listing['id']);
				$this->db->where('user_id',$user_subscription['user_id']);
		    	$this->db->update('listings', $data);

	    	}

		}


		/*=====================================================================================================
		[-- SUBSCRIPTION IPN DELETE USER ID -----------------------------------------------------------------]
	    =====================================================================================================*/
	    public function subscription_delete_user_id($recurring_payment_id){

			$data = array(

				'user_id'	=> NULL

			);

			$this->db->where('paypal_id',$recurring_payment_id);
	    	$this->db->update('subscriptions', $data);

		}

		/*=====================================================================================================
		[-- SUBSCRIPTION IPN DOWNGRADE EMAIL -----------------------------------------------------------------]
	    =====================================================================================================*/
	    public function subscription_ipn_rec_email($recurring_payment_id){

			$this->db->where('paypal_id',$recurring_payment_id);
	    	$query = $this->db->get('subscriptions');
	    	$rec_user_id = $query->row_array();

	    	$this->db->where('id',$rec_user_id['user_id']);
	    	$query = $this->db->get('users');
	    	return $query->row_array();

		}

		

		/*=====================================================================================================
		[-- ADD HIGHLIGHT & FEATURED LISTINGS ----------------------------------------------------------------]
	    =====================================================================================================*/
	    public function listing_payment($user_id,$amount,$currency,$currency_symbol,$description,$listing_id){
	    	date_default_timezone_set("Europe/London");

	    	$data = array(
	    		'user_id' 			=> $user_id,
	    		'amount'			=> $amount,
	    		'currency'			=> $currency,
	    		'currency_symbol'	=> $currency_symbol,
	    		'description'		=> $description,
	    		'listing_id'		=> $listing_id,
	    		'created_at'		=> date('Y-m-d H:i:s'),
	    		'updated_at'		=> date('Y-m-d H:i:s')
	    	);

	    	$this->db->insert('payments',$data);
	    	return $this->db->insert_id();

	    }

	    /*===============================================================================================
		[-- UPDATE HIGHLIGHT & FEATURED LISTINGS -------------------------------------------------------]
	    ===============================================================================================*/
	    public function update_listing_payment($id,$token,$payer_id,$transaction_id,$fee,$status){
	    	date_default_timezone_set("Europe/London");

	    	$data = array(
	    		'token'				=>	$token,
	    		'payer_id'			=>	$payer_id,
	    		'transaction_id'	=>	$transaction_id,
	    		'fee'				=>	$fee,
	    		'status'			=>	$status,
	    		'updated_at'		=>	date('Y-m-d H:i:s')
	    	);

	    	$this->db->where('id',$id);
	    	$this->db->update('payments', $data);
	    }

	    /*===============================================================================================
		[-- UNPAID HIGHLIGHT & FEATURED LISTINGS ( NOT COMPLETED ) -------------------------------------]
	    ===============================================================================================*/
	    public function listing_highlight_featured_unpaid($listing_id,$highlights,$featured){
	    	date_default_timezone_set("Europe/London");
	    	$datenow = date('Y-m-d');
	    	
	    	if($highlights != 0 && $featured != 0){

		    	$highlights_addweeks = strtotime( $datenow.' + '.$highlights.' week');
				$hightlighted_until = date('Y-m-d',$highlights_addweeks);

		    	$featured_addweeks = strtotime( $datenow.' + '.$featured.' week');
				$featured_until = date('Y-m-d',$featured_addweeks);

				$data = array(
					'unpaid_featured_until' => $featured_until,
					'unpaid_highlight_until' => $hightlighted_until,
		    		'updated_at'	=>	date('Y-m-d H:i:s')
		    	);
		    	$this->db->where('id', $listing_id);
		    	$this->db->update('listings', $data);


	    	}else if($highlights != 0 && $featured == 0){
	    		$highlights_addweeks = strtotime( $datenow.' + '.$highlights.' week');
				$hightlighted_until = date('Y-m-d',$highlights_addweeks);

				$data = array(
					'unpaid_highlight_until' => $hightlighted_until,
		    		'updated_at'	=>	date('Y-m-d H:i:s')
		    	);
		    	$this->db->where('id', $listing_id);
		    	$this->db->update('listings', $data);

	    	}else if($highlights == 0 && $featured != 0){

	    		$featured_addweeks = strtotime( $datenow.' + '.$featured.' week');
				$featured_until = date('Y-m-d',$featured_addweeks);

				$data = array(
					'unpaid_featured_until' => $featured_until,
		    		'updated_at'	=>	date('Y-m-d H:i:s')
		    	);

		    	$this->db->where('id', $listing_id);
		    	$this->db->update('listings', $data);

	    	}	
	    }

	    /*===============================================================================================
		[-- UPDATE HIGHLIGHT & FEATURED LISTINGS ( COMPLETED ) -----------------------------------------]
	    ===============================================================================================*/
	    public function listing_highlight_featured($listing_id,$highlights,$featured){
	    	date_default_timezone_set("Europe/London");
	    	$datenow = date('Y-m-d');

	    	$this->db->where('id', $this->session->userdata('user_id_byd'));
			$users_query = $this->db->get('users');
			$users_info = $users_query->row_array();

			if($featured <= $users_info['featured_credits']){
				$this->db->set('featured_credits', 'featured_credits-'.$featured,FALSE);
				$this->db->where('id', $users_info['id']);
		   		$this->db->update('users');
			}


	    	if($highlights != 0 && $featured != 0){

		    	$highlights_addweeks = strtotime( $datenow.' + '.$highlights.' week');
				$hightlighted_until = date('Y-m-d',$highlights_addweeks);

		    	$featured_addweeks = strtotime( $datenow.' + '.$featured.' week');
				$featured_until = date('Y-m-d',$featured_addweeks);

				$data = array(
					'featured' => 1,
					'featured_until' => $featured_until,
					'highlight' => 1,
					'highlight_until' => $hightlighted_until,
		    		'updated_at'	=>	date('Y-m-d H:i:s')
		    	);
		    	$this->db->where('id', $listing_id);
		    	$this->db->update('listings', $data);

		    	$featured_txt = 'true';
		    	$featured_until_txt = $featured_until;
		    	$highlight_txt = 'true';
		    	$highlight_until_txt = $hightlighted_until;

	    	}else if($highlights != 0 && $featured == 0){
	    		$highlights_addweeks = strtotime( $datenow.' + '.$highlights.' week');
				$hightlighted_until = date('Y-m-d',$highlights_addweeks);

				$data = array(
					'highlight' => 1,
					'highlight_until' => $hightlighted_until,
		    		'updated_at'	=>	date('Y-m-d H:i:s')
		    	);
		    	$this->db->where('id', $listing_id);
		    	$this->db->update('listings', $data);

		    	$featured_txt = 'false';
		    	$featured_until_txt = '';
		    	$highlight_txt = 'true';
		    	$highlight_until_txt = $hightlighted_until;


	    	}else if($highlights == 0 && $featured != 0){

	    		$featured_addweeks = strtotime( $datenow.' + '.$featured.' week');
				$featured_until = date('Y-m-d',$featured_addweeks);

				$data = array(
					'featured' => 1,
					'featured_until' => $featured_until,
		    		'updated_at'	=>	date('Y-m-d H:i:s')
		    	);

		    	$this->db->where('id', $listing_id);
		    	$this->db->update('listings', $data);


		    	$featured_txt = 'true';
		    	$featured_until_txt = $featured_until;
		    	$highlight_txt = 'false';
		    	$highlight_until_txt = '';

	    	}

	    	$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $listing_id);
			$this->db->where('auditable_type', 'Listing');
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$auditable_changes = $version_query['audited_changes']."\r\n featured: ".$featured_txt."\r\n featured_until: ".$featured_until_txt."\r\n highlight: ".$highlight_txt."\r\n highlight_until: ".$highlight_until_txt."\r\n on_homepage: ".''."\r\n on_homepage_until: ".''."\r\n views: ".''."\r\n deleted_at: ".''."\r\n old_id: ".'';

			$data = array(
				'audited_changes'		=> $auditable_changes,
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->where('auditable_id',$listing_id);
			$this->db->where('auditable_type', 'Listing');
	    	$this->db->update('audits', $data);

	    }

	    /*===============================================================================================
		[-- UPDATE HIGHLIGHT & FEATURED LISTINGS AUDITS ( COMPLETED ) ----------------------------------]
	    ===============================================================================================*/
	    public function listing_highlight_featured_audits($listing_id){
	    	date_default_timezone_set("Europe/London");

			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $listing_id);
			$this->db->where('auditable_type', 'Listing');
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$auditable_changes = $version_query['audited_changes']."\r\n featured: ".'false'."\r\n featured_until: ".''."\r\n highlight: ".'false'."\r\n highlight_until: ".''."\r\n on_homepage: ".''."\r\n on_homepage_until: ".''."\r\n views: ".''."\r\n deleted_at: ".''."\r\n old_id: ".'';

			$data = array(
				'audited_changes'		=> $auditable_changes,
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->where('auditable_id',$listing_id);
			$this->db->where('auditable_type', 'Listing');
	    	$this->db->update('audits', $data);
	    }

	    /*===============================================================================================
		[-- UPDATE HIGHLIGHT & FEATURED LISTINGS ( COMPLETED ) EDIT ------------------------------------]
	    ===============================================================================================*/
	    public function listing_highlight_featured_edit($listing_id,$highlights,$featured){
	    	date_default_timezone_set("Europe/London");
	    	$datenow = date('Y-m-d');

	    	$this->db->where('id', $this->session->userdata('user_id_byd'));
			$users_query = $this->db->get('users');
			$users_info = $users_query->row_array();


			if($featured <= $users_info['featured_credits']){
				$this->db->set('featured_credits', 'featured_credits-'.$featured,FALSE);
				$this->db->where('id', $users_info['id']);
		   		$this->db->update('users');
			}


	    	if($highlights != 0 && $featured != 0){

		    	$highlights_addweeks = strtotime( $datenow.' + '.$highlights.' week');
				$hightlighted_until = date('Y-m-d',$highlights_addweeks);

		    	$featured_addweeks = strtotime( $datenow.' + '.$featured.' week');
				$featured_until = date('Y-m-d',$featured_addweeks);

				$data = array(
					'featured' => 1,
					'featured_until' => $featured_until,
					'highlight' => 1,
					'highlight_until' => $hightlighted_until,
		    		'updated_at'	=>	date('Y-m-d H:i:s')
		    	);
		    	$this->db->where('id', $listing_id);
		    	$this->db->update('listings', $data);

		    	$featured_txt = 'true';
		    	$featured_until_txt = $featured_until;
		    	$highlight_txt = 'true';
		    	$highlight_until_txt = $hightlighted_until;

	    	}else if($highlights != 0 && $featured == 0){
	    		$highlights_addweeks = strtotime( $datenow.' + '.$highlights.' week');
				$hightlighted_until = date('Y-m-d',$highlights_addweeks);

				$data = array(
					'highlight' => 1,
					'highlight_until' => $hightlighted_until,
		    		'updated_at'	=>	date('Y-m-d H:i:s')
		    	);
		    	$this->db->where('id', $listing_id);
		    	$this->db->update('listings', $data);

		    	$featured_txt = 'false';
		    	$featured_until_txt = '';
		    	$highlight_txt = 'true';
		    	$highlight_until_txt = $hightlighted_until;


	    	}else if($highlights == 0 && $featured != 0){

	    		$featured_addweeks = strtotime( $datenow.' + '.$featured.' week');
				$featured_until = date('Y-m-d',$featured_addweeks);

				$data = array(
					'featured' => 1,
					'featured_until' => $featured_until,
		    		'updated_at'	=>	date('Y-m-d H:i:s')
		    	);

		    	$this->db->where('id', $listing_id);
		    	$this->db->update('listings', $data);


		    	$featured_txt = 'true';
		    	$featured_until_txt = $featured_until;
		    	$highlight_txt = 'false';
		    	$highlight_until_txt = '';

	    	}

	    	$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $listing_id);
			$this->db->where('auditable_type', 'Listing');
			$query = $this->db->get('audits');
			$version_query = $query->row_array();


			$this->db->where('id', $listing_id);
			$query = $this->db->get('listings');
			$listing_query = $query->row_array();


			if($listing_query['on_homepage'] == 1){
				$on_homepage_txt = 'true';
			}else{
				$on_homepage_txt = 'false';
			}


			$auditable_changes = $version_query['audited_changes']."\r\n featured: ".$featured_txt."\r\n featured_until: ".$featured_until_txt."\r\n highlight: ".$highlight_txt."\r\n highlight_until: ".$highlight_until_txt."\r\n on_homepage: ".$on_homepage_txt."\r\n on_homepage_until: ".$listing_query['on_homepage_until']."\r\n views: ".$listing_query['views']."\r\n deleted_at: ".$listing_query['deleted_at']."\r\n old_id: ".$listing_query['old_id'];

			$data = array(
				'audited_changes'		=> $auditable_changes,
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->where('auditable_id',$listing_id);
			$this->db->where('auditable_type', 'Listing');
	    	$this->db->update('audits', $data);

	    }

	    /*===============================================================================================
		[-- UPDATE HIGHLIGHT & FEATURED LISTINGS AUDITS ( COMPLETED ) EDIT -----------------------------]
	    ===============================================================================================*/
	    public function listing_highlight_featured_audits_edit($listing_id){
	    	date_default_timezone_set("Europe/London");

			$this->db->order_by('version', 'DESC');
			$this->db->where('auditable_id', $listing_id);
			$this->db->where('auditable_type', 'Listing');
			$query = $this->db->get('audits');
			$version_query = $query->row_array();

			$this->db->where('id', $listing_id);
			$query = $this->db->get('listings');
			$listing_query = $query->row_array();


			if($listing_query['featured'] == 1){
				$featured_txt = 'true';
			}else{
				$featured_txt = 'false';
			}

			if($listing_query['highlight'] == 1){
				$highlight_txt = 'true';
			}else{
				$highlight_txt = 'false';
			}
			
			if($listing_query['on_homepage'] == 1){
				$on_homepage_txt = 'true';
			}else{
				$on_homepage_txt = 'false';
			}


			$auditable_changes = $version_query['audited_changes']."\r\n featured: ".$featured_txt."\r\n featured_until: ".$listing_query['featured_until']."\r\n highlight: ".$highlight_txt."\r\n highlight_until: ".$listing_query['highlight_until']."\r\n on_homepage: ".$on_homepage_txt."\r\n on_homepage_until: ".$listing_query['on_homepage_until']."\r\n views: ".$listing_query['views']."\r\n deleted_at: ".$listing_query['deleted_at']."\r\n old_id: ".$listing_query['old_id'];

			$data = array(
				'audited_changes'		=> $auditable_changes,
				'created_at'			=> date('Y-m-d H:i:s')
			);

			$this->db->where('auditable_id',$listing_id);
			$this->db->where('auditable_type', 'Listing');
	    	$this->db->update('audits', $data);
	    }


		/*==================================================================================================
		[-- ADD CUSTOMER CREDITS IN PAYMENT ---------------------------------------------------------------]
	    ==================================================================================================*/
	    public function credit_payment($user_id,$amount,$currency,$currency_symbol,$description,$credits){
	    	date_default_timezone_set("Europe/London");

	    	$data = array(
	    		'user_id' 			=> $user_id,
	    		'amount'			=> $amount,
	    		'currency'			=> $currency,
	    		'currency_symbol'	=> $currency_symbol,
	    		'description'		=> $description,
	    		'credits'			=> $credits,
	    		'created_at'		=> date('Y-m-d H:i:s'),
	    		'updated_at'		=> date('Y-m-d H:i:s')
	    	);

	    	$this->db->insert('payments',$data);
	    	return $this->db->insert_id();

	    }

	    /*============================================================================================
		[-- UPDATE CUSTOMER CREDITS IN PAYMENT -------------------------------------------------------]
	    =============================================================================================*/
	    public function credit_payment_update($id,$token,$payer_id,$transaction_id,$fee,$status){
	    	date_default_timezone_set("Europe/London");

	    	$data = array(
	    		'token'				=>	$token,
	    		'payer_id'			=>	$payer_id,
	    		'transaction_id'	=>	$transaction_id,
	    		'fee'				=>	$fee,
	    		'status'			=>	$status,
	    		'updated_at'		=>	date('Y-m-d H:i:s')
	    	);

	    	$this->db->where('id',$id);
	    	$this->db->update('payments', $data);
	    }

	    /*============================================================================================
		[-- UPDATE CUSTOMER CREDITS ( COMPLETED ) ---------------------------------------------------]
	    =============================================================================================*/
	    public function user_credits($user_id,$credits){
	    	date_default_timezone_set("Europe/London");

	    	$data = array(
	    		'updated_at'	=>	date('Y-m-d H:i:s')
	    	);
	    	$this->db->set('credits', 'credits+'.$credits,FALSE);
	    	$this->db->where('id', $user_id);
	    	$this->db->update('users', $data);
	    }

	}