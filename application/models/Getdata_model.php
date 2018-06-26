<?php 
	class Getdata_model extends CI_Model{

		/*=====================================================
		[-- GET USER  ----------------------------------------]
	    ======================================================*/
	    public function user(){
	    	$query = $this->db->get('users');
			return $query->row_array();	
	    }

		/*=====================================================
		[-- GET USERS  ---------------------------------------]
	    ======================================================*/
	    public function get_user($id){
	    	$this->db->where('id', $id);
	    	$query = $this->db->get('users');
	    	return $query->row_array();
	    }

	    /*=====================================================
		[-- GET USERS NUM ------------------------------------]
	    ======================================================*/
	    public function get_user_num(){
	    	$query = $this->db->get('users');
	    	return $query->num_rows();
	    }

		/*=====================================================
		[-- BREEDS -------------------------------------------]
	    ======================================================*/
		public function get_breeds(){
			$this->db->order_by('name');
			$query = $this->db->get('breeds');
			return $query->result_array();
		}


		/*=====================================================
		[-- GET BREEDS BY SLUG -------------------------------]
	    ======================================================*/
		public function get_kennel_breeds_slug($slug){	
			$this->db->where('url_name', $slug);
			$this->db->order_by('name ASC');
			$query = $this->db->get('breeds');
			return $query->row_array();
		}

		/*=====================================================
		[-- BREEDS ID ----------------------------------------]
	    ======================================================*/
		public function get_breed_id($breed_id){
			$query = $this->db->get_where('breeds', array('id' => $breed_id));
			return $query->row_array();
		}

		/*=====================================================
		[-- GET BREEDS BY KENNEL GROUP------------------------]
	    ======================================================*/
		public function get_kennel_breeds($id){	
			$this->db->where('kennel_club_group_id', $id);
			$this->db->order_by('name ASC');
			$query = $this->db->get('breeds');
			return $query->result_array();
		}

		/*=====================================================
		[-- KENNEL CLUB GROUP --------------------------------]
	    ======================================================*/
	    public function get_kennelclub(){
			$this->db->order_by('id');
			$query = $this->db->get('kennel_club_groups');
			return $query->result_array();
		}

		/*=====================================================
		[-- KENNEL CLUB GROUP SORT ---------------------------]
	    ======================================================*/
	    public function get_kennelclub_sort(){
			$this->db->order_by('name');
			$query = $this->db->get('kennel_club_groups');
			return $query->result_array();
		}

		/*=====================================================
		[-- PAGES -------------------------------------------]
	    ======================================================*/

	    public function get_pages(){
			$this->db->order_by('id');
			$query = $this->db->get('pages');
			return $query->result_array();
		}


		/*=====================================================
		[-- PAGES URL ----------------------------------------]
	    ======================================================*/

	    public function get_pages_url($id){
	    	$this->db->select('url');
			$this->db->where('id', $id);
			$query = $this->db->get('pages');
			return $query->row_array();
		}


		/*=====================================================
		[-- ADMINS -------------------------------------------]
	    ======================================================*/

		public function get_admins(){
			$this->db->order_by('id');
			$query = $this->db->get('admins');
			return $query->result_array();
		}

		/*=====================================================
		[-- COUNTRIES -----------------------------------------]
	    ======================================================*/

		public function get_countries(){
			$this->db->order_by('sort');
			$query = $this->db->get('countries');
			return $query->result_array();
		}

		/*=====================================================
		[-- GET COUNTRY BY ID --------------------------------]
	    ======================================================*/

		public function get_countries_id($country_id){
			$this->db->order_by('sort');
			$query = $this->db->get_where('countries', array('id' => $country_id));
			return $query->row_array();
		}

		/*=====================================================
		[-- PLANS --------------------------------------------]
	    ======================================================*/

		public function get_plans(){
			$this->db->order_by('id');
			$this->db->where('available', 1);
			$query = $this->db->get('plans');
			return $query->result_array();
		}

		/*=====================================================
		[-- GET PLAN WITH ID ---------------------------------]
	    ======================================================*/
		public function get_plans_id($plan_id){
			$query = $this->db->get_where('plans', array('id' => $plan_id));
			return $query->row_array();
		}

		/*=====================================================
		[-- GET USER LISTING ---------------------------------]
		[-- 1. GET BY USER ID , GET NUMBER OF LISTINGS -------]
		[-- 2. GET BY USER ID , GET LISTINGS -----------------]
		[-- 3. GET BY LISTING ID , GET LISTING ---------------]
		[-- 4. WHAT!!! SAME FROM NO. 1 -----------------------]
	    ======================================================*/
	    
	    public function get_listings_number($users_id){
	    	$this->db->where('user_id', $users_id);
	    	$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');
	    	return $query->num_rows();
	    }

	    public function get_user_listing($users_id){
	    	$this->db->where('user_id', $users_id);
	    	$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');

	    	if($query->num_rows() != 0){
				return $query->result_array();
			}else{
				return false;
			}
	    }

	    public function get_listing($listing_id){
	    	$this->db->where('id', $listing_id);
	    	$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');

	    	return $query->row_array();
	    }

	    public function get_listing_user_id($user_id){
	    	$this->db->where('user_id', $user_id);
	    	$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');

	    	return $query->result_array();
	    }


	    public function get_user_listing_number($users_id){
	    	$this->db->where('user_id', $users_id);
	    	$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');

	    	return $query->num_rows();
	    }

	    /*=====================================================
		[-- ACTIVE PUBLISHED LISTINGS LISTINGS CONNECTIONS ---]
	    ======================================================*/
	    public function get_published_listings_number($users_id){
	    	$this->db->where('user_id', $users_id);
	    	$this->db->where('published', 1);
	    	$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');
	    	return $query->num_rows();
	    }

	    /*=====================================================
		[-- LISTINGS CONNECTIONS -----------------------------]
	    ======================================================*/
	    public function get_listing_connections($listing_id){
	    	$this->db->where('id', $listing_id);
			$query = $this->db->get('listings');

	    	return $query->row_array();
	    }


	    /*=====================================================
		[-- LISTINGS FOR ADMIN 1 RESULT ROW ------------------]
	    ======================================================*/
	    public function get_user_listing_row($id){
	    	$this->db->where('id', $id);
	    	$query = $this->db->get('listings');

	    	return $query->row_array();
	    }


	    /*=====================================================
		[-- LISTINGS FOR ADMIN USER ID -----------------------]
	    ======================================================*/
	    public function get_user_listings($id){
	    	$this->db->where('user_id', $id);
	    	$query = $this->db->get('listings');

	    	return $query->result_array();
	    }	    


	    /*=====================================================
		[-- LISTINGS FOR ADMIN STUD DOG -----------------------]
	    ======================================================*/
	    public function get_user_listings_stud($id){
	    	$this->db->where('user_id', $id);
	    	$this->db->where('listing_type', 'dog');
	    	$query = $this->db->get('listings');

	    	return $query->result_array();
	    }

	    /*=====================================================
		[-- LISTINGS FOR ADMIN PUPPIES -----------------------]
	    ======================================================*/
	    public function get_user_listings_puppies($id){
	    	$this->db->where('user_id', $id);
	    	$this->db->where('listing_type', 'pup');
	    	$query = $this->db->get('listings');

	    	return $query->result_array();
	    }

	    /*=====================================================
		[-- LISTINGS FOR ADMIN MEMORIAL ----------------------]
	    ======================================================*/
	    public function get_user_listings_memorial($id){
	    	$this->db->where('user_id', $id);
	    	$this->db->where('listing_type', 'mem');
	    	$query = $this->db->get('listings');

	    	return $query->result_array();
	    }

	    /*=====================================================
		[-- GENERATE THUMBNAILS ------------------------------]
	    ======================================================*/
	    public function get_listing_for_thumbnails(){
			$this->db->where('deleted_at', NULL);
			$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$query = $this->db->get('listings');

	    	return $query->result_array();
	    }

	    /*===============================================================
		[-- GENERATE THUMBNAILS CRON JOBS ------------------------------]
	    ===============================================================*/
	    public function get_listing_for_thumbnails_cron(){
			$this->db->where('deleted_at', NULL);
			$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->order_by('id', 'RANDOM');
			$this->db->limit(500);
			$query = $this->db->get('listings');

	    	return $query->result_array();
	    }

	    public function get_listing_images_for_thumbnails($listing_id){
			$this->db->order_by('sort', 'ASC');
			$query = $this->db->get_where('listing_images', array('listing_id' => $listing_id));
			return $query->result_array();
		}

		/*=====================================================
		[-- GET CONNECTIONS ----------------------------------]
	    ======================================================*/
	    public function get_connections($id){
	    	$this->db->where('id', $id);
			$query = $this->db->get('connections');

	    	return $query->row_array();
	    }

	    /*=====================================================
		[-- LISTINGS IMAGES ----------------------------------]
	    ======================================================*/
	    public function get_listing_images($id){
	    	$this->db->where('id', $id);
			$query = $this->db->get('listing_images');

	    	return $query->row_array();
	    }

	}