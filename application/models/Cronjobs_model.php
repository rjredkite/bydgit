<?php
	class Cronjobs_model extends CI_Model{

		/*=======================================================================================
		[-- BACK TO ZERO FEATURED LISTINGS -----------------------------------------------------]
	    =======================================================================================*/
	    public function cronjobs_listings_featured(){
	    	date_default_timezone_set("Europe/London");
	    	$this->db->where('featured_until <', date('Y-m-d'));
			$query = $this->db->get('listings');
			$query->result_array();

			foreach($query->result_array() as $back_listings){

			    $listings[] = $back_listings['id'];

			}

			if(!empty($listings)){

				$data = array(
					'featured' => 0,
					'featured_until' => NULL
				);

				$this->db->where_in('id', $listings);
				$this->db->update('listings',$data);
			}
	    }

	    /*=========================================================================================
		[-- BACK TO ZERO  HIGHLIGHT LISTINGS -----------------------------------------------------]
	    ==========================================================================================*/
	    public function cronjobs_listings_highlight(){
	    	date_default_timezone_set("Europe/London");
	    	$this->db->where('highlight_until <', date('Y-m-d'));
			$query = $this->db->get('listings');
			$query->result_array();

			foreach($query->result_array() as $back_listings){

			    $highlight[] = $back_listings['id'];

			}

			if(!empty($highlight)){

				$data = array(
					'highlight' => 0,
					'highlight_until' => NULL
				);

				$this->db->where_in('id', $highlight);
				$this->db->update('listings',$data);
			}
	    }

	    /*============================================================================================
		[-- REMOVE DOGS 10 YEARS PLUS LISTINGS ------------------------------------------------------]
	    ============================================================================================*/
	    public function cronjobs_listings_dog10years_up(){
	    	date_default_timezone_set("Europe/London");

	    	$dateplus10y = strtotime(date('Y-m-d').' - 11 year');
			$dateafter10y = date('Y-m-d',$dateplus10y);
			$this->db->where('listing_type', 'dog');
	    	$this->db->where('date_of_birth <', $dateafter10y);
			$query = $this->db->get('listings');
			$query->result_array();

			foreach($query->result_array() as $dog10yafter){

			    $dogs10up[] = $dog10yafter['id'];

			}

			/* delete at */
			if(!empty($dogs10up)){

				$data = array(

					'deleted_at' => date('Y-m-d h:i:sa')

				);

				$this->db->where_in('id', $dogs10up);
				$this->db->update('listings',$data);
			}

			/* delete permanet */
			if(!empty($dogs10up)){

				//$this->db->where_in('id', $dogs10up);
				//$this->db->delete('listings',$data);
			}

	    }


	    /*===============================================================================================
		[-- REMOVE PUPPIES 6 MONTHS PLUS LISTINGS ------------------------------------------------------]
	    ===============================================================================================*/
	    public function cronjobs_listings_pup6months_up(){
	    	date_default_timezone_set("Europe/London");

	    	$dateplus6m = strtotime(date('Y-m-d').' - 6 month');
			$dateafter6m = date('Y-m-d',$dateplus6m);
			$this->db->where('listing_type', 'pup');
	    	$this->db->where('date_of_birth <', $dateafter6m);

			$query = $this->db->get('listings');
			$query->result_array();

			foreach($query->result_array() as $pup6mafter){

			    $pup6up[] = $pup6mafter['id'];

			}

			/* delete at */
			if(!empty($pup6up)){

				$data = array(

					'deleted_at' => date('Y-m-d h:i:sa')

				);

				$this->db->where_in('id', $pup6up);
				$this->db->update('listings',$data);
			}

			/* delete permanet */
			if(!empty($pup6up)){

				//$this->db->where_in('id', $pup6up);
				//$this->db->delete('listings',$data);
			}

	    }


	}