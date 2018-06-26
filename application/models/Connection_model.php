<?php 
	class Connection_model extends CI_Model{

		/*=====================================================
		[-- GET USERS CONNECTIONS LISTINGS -------------------]
	    ======================================================*/
	    public function get_user_connections($users_id){
	    	$this->db->order_by('id', 'DESC');
	    	$query = $this->db->get_where('connections', array('buyer_id' => $users_id));
			return $query->result_array();
	    }
		

		/*=====================================================
		[-- CONNECTIONS PAID CREDITS FOR LISTING ------------]
	    ======================================================*/
	    public function connection_paid_credits($listing_id,$users_id){
	    	date_default_timezone_set("Europe/London");
			
	    	$data = array(
	    		'listing_id'	=> $listing_id,
	    		'buyer_id'		=> $users_id,
	    		'created_at'	=> date('Y-m-d H:i:s'),
	    		'updated_at'	=> date('Y-m-d H:i:s')
	    	);

	    	$this->db->insert('connections',$data);
	    	return $this->db->insert_id();
	    }

	    /*==========================================================================
		[-- CONNECTIONS PAID CREDITS FOR LISTING MINUS CREDITS OF USER ------------]
	    ==========================================================================*/
	    public function connection_minus_credits($users_id,$credit_output){
	    	date_default_timezone_set("Europe/London");

	    	$data = array(
	    		'credits'		=>	$credit_output,
	    		'updated_at'	=>	date('Y-m-d H:i:s')
	    	);

	    	$this->db->where('id',$users_id);
	    	$this->db->update('users',$data);

	    }

	    /*===============================================================================
		[-- GET CONNECTIONS IF HAS MATCH -----------------------------------------------]
	    ================================================================================*/
	    public function get_connections($connections_id){
		 	$query = $this->db->get_where('connections', array('id' => $connections_id));
			return $query->row_array();
		}

	    /*===============================================================================
		[-- CHECK CONNECTIONS IF HAS MATCH ---------------------------------------------]
	    ================================================================================*/
	    public function check_connections($users_id,$listing_id){
		 	$query = $this->db->get_where('connections', array('listing_id' => $listing_id,'buyer_id' => $users_id));
			return $query->row_array();
		}

		/*===============================================================================
		[-- GET CONNECTIONS LISTING ----------------------------------------------------]
	    ================================================================================*/
		public function get_connection_listing($connect_id){
	    	$this->db->where('id', $connect_id);
			$query = $this->db->get('listings');
			return $query->row_array();
	    }

	}
