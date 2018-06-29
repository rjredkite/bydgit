<?php 
	class Pages_model extends CI_Model{
		public function __construct(){
			$this->load->database();
		}

		public function get_home($url, $lang){
			$query = $this->db->get_where('pages', array('url' => $url, 'language' => $lang));
			return $query->row_array();
		}

		public function get_pages($url = FALSE){
			if($url === FALSE){
				$this->db->order_by('id','DESC');
				$query = $this->db->get('pages');
				return $query->result_array();
			}

			$query = $this->db->get_where('pages', array('url' => $url));
			return $query->row_array();
			
		}


		/*=============================================================================================
		[-- USER EMAIL CONFIRMED ---------------------------------------------------------------------]
	    ==============================================================================================*/
	    public function user_confirmed($id){
	    	$this->db->where('confirm_code', $id);
	    	$query = $this->db->get('users');
	    	return $query->row_array();
	    }

	    /*=============================================================================================
		[-- USER REMOVE CONFIRMED CODE ---------------------------------------------------------------]
	    ==============================================================================================*/
	    public function user_remove_confirm_code($id){
	    	$data = array(
	    		'confirm_code' => ''
	    	);
	    	$this->db->where('id', $id);
	    	$this->db->update('users', $data);
	    }

	    /*=============================================================================================
		[-- USER EMAIL RESER -------------------------------------------------------------------------]
	    ==============================================================================================*/
	    public function user_email_reset($email){
	    	$this->db->where('email', $email);
	    	$query = $this->db->get('users');
	    	return $query->row_array();
	    }

		/*=============================================================================================
		[-- LISTINGS STUD DOGS PAGES FOR SEARCH FIELDS WITH PAGINATION -------------------------------]
	    ==============================================================================================*/
	    public function count_stud_dogs($country_code = 'NULL', $breed_id = 'NULL',$latitude2 = NULL,$longitude2 = NULL){

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				$this->db->order_by('featured', 'DESC');
				$this->db->order_by('id', 'DESC');
				$this->db->where('listing_type', 'dog');
				$this->db->where('published', 1);
				$this->db->group_start();
					$this->db->where('deleted_at', NULL);
					$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
				$this->db->group_end();

				$query = $this->db->get('listings');

				if($this->input->get('post_code', TRUE) != ''){

					/*$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}*/

					foreach($query->result_array() as $result){

						$latitude1 = $result['latitude'];
						$longitude1 = $result['longitude'];

						$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

						if($miles >= $this->input->get('distance', TRUE)){
							$array_miles[] = $result['id'];
						}

					}

				}else{
					

					if($country_code != '' && $country_code != 'NULL'){

						/*$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;*/

						foreach($query->result_array() as $result){

							$latitude1 = $result['latitude'];
							$longitude1 = $result['longitude'];

							$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

							if($miles >= $this->input->get('distance', TRUE)){
								$array_miles[] = $result['id'];
							}
							
						}
						
					}
												
				}

			}


			if(!empty($array_miles)){
				$this->db->group_start();
					$miles_array = array_chunk($array_miles,500);

					foreach($miles_array as $milesarray){
						$this->db->where_not_in('listings.id', $milesarray);
					}
				$this->db->group_end();
			}
			
			$this->db->order_by('listings.featured', 'DESC');
	
			if($this->input->get('sort_by', TRUE) != 'closest'){
				$this->db->order_by('listings.id', 'DESC');
			}

			$this->db->order_by('listings.featured', 'DESC');

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('listings.breed_id', $this->input->get('breed_id', TRUE)); 
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('listings.country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('gender', TRUE) != 'all' && $this->input->get('gender', TRUE) != ''){
				$this->db->where('listings.gender', $this->input->get('gender', TRUE)); 
			}

			if($this->input->get('distance', TRUE) == '' && $this->input->get('distance', TRUE) == 'all'){
				if($this->input->get('listings.post_code', TRUE) != ''){
					$this->db->where('listings.post_code', $this->input->get('post_code', TRUE)); 
				}
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->like('listings.title', $this->input->get('keywords', TRUE));
			}

			if($this->input->get('pedigree_only', TRUE) == 'on'){
				$this->db->where('listings.pedigree', 1); 
			}

			if($this->input->get('listings.distance', TRUE) != ''){
				
			}

			if($breed_id != 'NULL'){
				$this->db->where('listings.breed_id', $breed_id);
			}


			$this->db->where('listings.listing_type', 'dog');
			$this->db->where('listings.published', 1);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			
			$this->db->join('listings', 'listings.user_id = users.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);
	    	$this->db->select('COUNT(*) as count', FALSE);

			$query = $this->db->get('users');

			return $query->result_array()[0]['count'];

	    }

	    public function get_stud_dogs($limit = FALSE, $offset = FALSE, $country_code = 'NULL' ,$breed_id = 'NULL',$latitude2,$longitude2){

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				$this->db->order_by('featured', 'DESC');
				$this->db->order_by('id', 'DESC');
				$this->db->where('listing_type', 'dog');
				$this->db->where('published', 1);
				$this->db->group_start();
					$this->db->where('deleted_at', NULL);
					$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
				$this->db->group_end();

				$query = $this->db->get('listings');

				if($this->input->get('post_code', TRUE) != ''){

					/*$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}
*/
					foreach($query->result_array() as $result){

						$latitude1 = $result['latitude'];
						$longitude1 = $result['longitude'];

						$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

						if($miles >= $this->input->get('distance', TRUE)){
							$array_miles[] = $result['id'];
						}

					}

				}else{
					

					if($country_code != '' && $country_code != 'NULL'){

						/*$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;
*/
						foreach($query->result_array() as $result){

							$latitude1 = $result['latitude'];
							$longitude1 = $result['longitude'];

							$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

							if($miles >= $this->input->get('distance', TRUE)){
								$array_miles[] = $result['id'];
							}
							
						}
						
					}
												
				}

			}


			if(!empty($array_miles)){
				$this->db->group_start();
					$miles_array = array_chunk($array_miles,500);

					foreach($miles_array as $milesarray){
						$this->db->where_not_in('listings.id', $milesarray);
					}
				$this->db->group_end();
			}
			
			$this->db->order_by('listings.featured', 'DESC');


			if($limit){
				$this->db->limit($limit, $offset);
			}
	
			if($this->input->get('sort_by', TRUE) != 'closest'){
				$this->db->order_by('listings.id', 'DESC');
			}

			$this->db->order_by('listings.featured', 'DESC');

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('listings.breed_id', $this->input->get('breed_id', TRUE)); 
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('listings.country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('gender', TRUE) != 'all' && $this->input->get('gender', TRUE) != ''){
				$this->db->where('listings.gender', $this->input->get('gender', TRUE)); 
			}

			if($this->input->get('distance', TRUE) == '' && $this->input->get('distance', TRUE) == 'all'){
				if($this->input->get('post_code', TRUE) != ''){
					$this->db->where('listings.post_code', $this->input->get('post_code', TRUE)); 
				}
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->like('listings.title', $this->input->get('keywords', TRUE));
			}

			if($this->input->get('pedigree_only', TRUE) == 'on'){
				$this->db->where('listings.pedigree', 1); 
			}

			if($this->input->get('listings.distance', TRUE) != ''){
				
			}

			if($breed_id != 'NULL'){
				$this->db->where('listings.breed_id', $breed_id);
			}

			$this->db->where('listings.listing_type', 'dog');
			$this->db->where('listings.published', 1);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$this->db->join('listings', 'listings.user_id = users.id');
			$this->db->join('breeds', 'listings.breed_id = breeds.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);

			$this->db->select('users.*, listings.*, breeds.name AS breed_name');

			$query = $this->db->get('users');

			return $query->result_array();
		}

		public function first_images_for_listings($listings) {
			$listing_ids = array();

			foreach ($listings as $row) {
				$listing_ids[] = $row['id'];
			}

			$this->db->select('id, image, listing_id');
			$this->db->where_in('listing_id', $listing_ids);
			$this->db->where('dont_display', 0);
			$this->db->group_by('listing_id');
			$this->db->order_by('sort',  'ASC');
			
			$query = $this->db->get('listing_images');

			$images_by_listing_id = array();

			foreach ($query->result_array() as $row) {
				$images_by_listing_id[$row['listing_id']] = $row;
			}

			return $images_by_listing_id;
			die(print_r($query->result_array()));
		}

		/*=============================================================================================
		[-- LISTINGS PUPPIES PAGES FOR SEARCH FIELDS WITH PAGINATION ---------------------------------]
	    ==============================================================================================*/
	     public function count_puppies($country_code = 'NULL', $breed_id = 'NULL',$latitude2,$longitude2){

	     	$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
	     	$this->db->where('listing_type', 'pup');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$query = $this->db->get('listings');

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				if($this->input->get('post_code', TRUE) != ''){

					/*$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}*/

					foreach($query->result_array() as $result){

						$latitude1 = $result['latitude'];
						$longitude1 = $result['longitude'];

						$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

						if($miles >= $this->input->get('distance', TRUE)){
							$array_miles[] = $result['id'];
						}

					}

				}else{
					

					if($country_code != '' && $country_code != 'NULL'){

						/*$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;
*/
						foreach($query->result_array() as $result){

							$latitude1 = $result['latitude'];
							$longitude1 = $result['longitude'];

							$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

							if($miles >= $this->input->get('distance', TRUE)){
								$array_miles[] = $result['id'];
							}
							
						}
						
					}
												
				}

			}


			if(!empty($array_miles)){
				$this->db->group_start();
					$miles_array = array_chunk($array_miles,500);

					foreach($miles_array as $milesarray){
						$this->db->where_not_in('listings.id', $milesarray);
					}
				$this->db->group_end();
			}

			$this->db->order_by('listings.featured', 'DESC');
	
			if($this->input->get('sort_by', TRUE) != 'closest'){
				$this->db->order_by('listings.id', 'DESC');
			}

			$this->db->order_by('listings.featured', 'DESC');

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('listings.breed_id', $this->input->get('breed_id', TRUE)); 
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('listings.country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('gender', TRUE) != 'all' && $this->input->get('gender', TRUE) != ''){
				$this->db->where('listings.gender', $this->input->get('gender', TRUE)); 
			}

			if($this->input->get('distance', TRUE) == '' && $this->input->get('distance', TRUE) == 'all'){
				if($this->input->get('post_code', TRUE) != ''){
					$this->db->where('listings.post_code', $this->input->get('post_code', TRUE)); 
				}
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->like('listings.title', $this->input->get('keywords', TRUE));
			}

			if($this->input->get('pedigree_only', TRUE) == 'on'){
				$this->db->where('listings.pedigree', 1); 
			}

			if($this->input->get('listings.distance', TRUE) != ''){
				
			}

			if($breed_id != 'NULL'){
				$this->db->where('listings.breed_id', $breed_id);
			}

			$this->db->where('listings.listing_type', 'pup');
			$this->db->where('listings.published', 1);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$this->db->join('listings', 'listings.user_id = users.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);
      $this->db->select('COUNT(*) as count', FALSE);

			$query = $this->db->get('users');

			return $query->result_array()[0]['count'];

	    }

	    public function get_puppies($limit = FALSE, $offset = FALSE, $country_code = 'NULL', $breed_id = 'NULL',$latitude2,$longitude2){
	    	
	    	$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
			$this->db->where('listing_type', 'pup');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();


			$query = $this->db->get('listings');

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				if($this->input->get('post_code', TRUE) != ''){

					/*$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}*/

					foreach($query->result_array() as $result){

						$latitude1 = $result['latitude'];
						$longitude1 = $result['longitude'];

						$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

						if($miles >= $this->input->get('distance', TRUE)){
							$array_miles[] = $result['id'];
						}

					}

				}else{
					

					if($country_code != '' && $country_code != 'NULL'){

						/*$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;*/

						foreach($query->result_array() as $result){

							$latitude1 = $result['latitude'];
							$longitude1 = $result['longitude'];

							$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

							if($miles >= $this->input->get('distance', TRUE)){
								$array_miles[] = $result['id'];
							}
							
						}
						
					}
												
				}

			}


			if(!empty($array_miles)){
				$this->db->group_start();
					$miles_array = array_chunk($array_miles,500);

					foreach($miles_array as $milesarray){
						$this->db->where_not_in('listings.id', $milesarray);
					}
				$this->db->group_end();
			}

			$this->db->order_by('listings.featured', 'DESC');


			if($limit){
				$this->db->limit($limit, $offset);
			}
	
			if($this->input->get('sort_by', TRUE) != 'closest'){
				$this->db->order_by('listings.id', 'DESC');
			}

			$this->db->order_by('listings.featured', 'DESC');

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('listings.breed_id', $this->input->get('breed_id', TRUE)); 
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('listings.country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('gender', TRUE) != 'all' && $this->input->get('gender', TRUE) != ''){
				$this->db->where('listings.gender', $this->input->get('gender', TRUE)); 
			}

			if($this->input->get('distance', TRUE) == '' && $this->input->get('distance', TRUE) == 'all'){
				if($this->input->get('post_code', TRUE) != ''){
					$this->db->where('listings.post_code', $this->input->get('post_code', TRUE)); 
				}
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->like('listings.title', $this->input->get('keywords', TRUE));
			}

			if($this->input->get('pedigree_only', TRUE) == 'on'){
				$this->db->where('listings.pedigree', 1); 
			}

			if($this->input->get('listings.distance', TRUE) != ''){
				
			}

			if($breed_id != 'NULL'){
				$this->db->where('listings.breed_id', $breed_id);
			}

			$this->db->where('listings.listing_type', 'pup');
			$this->db->where('listings.published', 1);
			$this->db->group_start();
				$this->db->where('listings.deleted_at', NULL);
				$this->db->or_where('listings.deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$this->db->join('listings', 'listings.user_id = users.id');
			$this->db->join('breeds', 'listings.breed_id = breeds.id');

			$this->db->where('users.banned !=', 1);
			$this->db->where('users.suspended !=', 1);

			$this->db->select('users.*, listings.*, breeds.name AS breed_name');

			$query = $this->db->get('users');
			
			return $query->result_array();
		}

		/*=============================================================================================
		[-- LISTINGS MEMORIALS PAGES FOR SEARCH FIELDS WITH PAGINATION -------------------------------]
	    ==============================================================================================*/
	     public function count_memorials($country_code = 'NULL',$latitude2,$longitude2){

	     	$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
	     	$this->db->where('listing_type', 'mem');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$query = $this->db->get('listings');

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				if($this->input->get('post_code', TRUE) != ''){

					/*$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}*/

					foreach($query->result_array() as $result){

						$latitude1 = $result['latitude'];
						$longitude1 = $result['longitude'];

						$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

						if($miles >= $this->input->get('distance', TRUE)){
							$array_miles[] = $result['id'];
						}

					}

				}else{
					

					if($country_code != '' && $country_code != 'NULL'){

						/*$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;*/

						foreach($query->result_array() as $result){

							$latitude1 = $result['latitude'];
							$longitude1 = $result['longitude'];

							$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

							if($miles >= $this->input->get('distance', TRUE)){
								$array_miles[] = $result['id'];
							}
							
						}
						
					}
												
				}

			}


			if(!empty($array_miles)){
				$this->db->group_start();
					$miles_array = array_chunk($array_miles,500);

					foreach($miles_array as $milesarray){
						$this->db->where_not_in('listings.id', $milesarray);
					}
				$this->db->group_end();
			}

			$this->db->order_by('featured', 'DESC');
	
			if($this->input->get('sort_by', TRUE) != 'closest'){
				$this->db->order_by('listings.id', 'DESC');
			}

			$this->db->order_by('featured', 'DESC');

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('listings.breed_id', $this->input->get('breed_id', TRUE)); 
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('listings.country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('gender', TRUE) != 'all' && $this->input->get('gender', TRUE) != ''){
				$this->db->where('listings.gender', $this->input->get('gender', TRUE)); 
			}

			if($this->input->get('distance', TRUE) == '' && $this->input->get('distance', TRUE) == 'all'){
				if($this->input->get('post_code', TRUE) != ''){
					$this->db->where('listings.post_code', $this->input->get('post_code', TRUE)); 
				}
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->like('listings.title', $this->input->get('keywords', TRUE));
			}

			if($this->input->get('pedigree_only', TRUE) == 'on'){
				$this->db->where('listings.pedigree', 1); 
			}

			if($this->input->get('listings.distance', TRUE) != ''){
				
			}

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

	    public function get_memorials($limit = FALSE, $offset = FALSE, $country_code,$latitude2,$longitude2){
	    
	    	$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
			$this->db->where('listing_type', 'mem');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$query = $this->db->get('listings');

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				if($this->input->get('post_code', TRUE) != ''){

					/*$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}*/

					foreach($query->result_array() as $result){

						$latitude1 = $result['latitude'];
						$longitude1 = $result['longitude'];

						$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

						if($miles >= $this->input->get('distance', TRUE)){
							$array_miles[] = $result['id'];
						}

					}

				}else{
					

					if($country_code != '' && $country_code != 'NULL'){
/*
						$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;
*/
						foreach($query->result_array() as $result){

							$latitude1 = $result['latitude'];
							$longitude1 = $result['longitude'];

							$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

							if($miles >= $this->input->get('distance', TRUE)){
								$array_miles[] = $result['id'];
							}
							
						}
						
					}
												
				}

			}


			if(!empty($array_miles)){
				$this->db->group_start();
					$miles_array = array_chunk($array_miles,500);

					foreach($miles_array as $milesarray){
						$this->db->where_not_in('listings.id', $milesarray);
					}
				$this->db->group_end();
			}

			$this->db->order_by('listings.featured', 'DESC');


			if($limit){
				$this->db->limit($limit, $offset);
			}
	
			if($this->input->get('sort_by', TRUE) != 'closest'){
				$this->db->order_by('listings.id', 'DESC');
			}

			$this->db->order_by('listings.featured', 'DESC');

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('listings.breed_id', $this->input->get('breed_id', TRUE)); 
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('listings.country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('gender', TRUE) != 'all' && $this->input->get('gender', TRUE) != ''){
				$this->db->where('listings.gender', $this->input->get('gender', TRUE)); 
			}

			if($this->input->get('distance', TRUE) == '' && $this->input->get('distance', TRUE) == 'all'){
				if($this->input->get('post_code', TRUE) != ''){
					$this->db->where('listings.post_code', $this->input->get('post_code', TRUE)); 
				}
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->like('listings.title', $this->input->get('keywords', TRUE));
			}

			if($this->input->get('pedigree_only', TRUE) == 'on'){
				$this->db->where('listings.pedigree', 1); 
			}

			if($this->input->get('listings.distance', TRUE) != ''){
				
			}

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
			
			return $query->result_array();
		}

		/*=============================================================================================
		[-- LISTINGS LISTINGS PAGES FOR SEARCH FIELDS WITH PAGINATION --------------------------------]
	    ==============================================================================================*/
	     public function count_listings($country_code = 'NULL',$latitude2,$longitude2){
	     	
	     	$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$query = $this->db->get('listings');

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				if($this->input->get('post_code', TRUE) != ''){

					/*$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}*/

					foreach($query->result_array() as $result){

						$latitude1 = $result['latitude'];
						$longitude1 = $result['longitude'];

						$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

						if($miles >= $this->input->get('distance', TRUE)){
							$array_miles[] = $result['id'];
						}

					}

				}else{
					

					if($country_code != '' && $country_code != 'NULL'){

						/*$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;
*/
						foreach($query->result_array() as $result){

							$latitude1 = $result['latitude'];
							$longitude1 = $result['longitude'];

							$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

							if($miles >= $this->input->get('distance', TRUE)){
								$array_miles[] = $result['id'];
							}
							
						}
						
					}
												
				}

			}


			if(!empty($array_miles)){
				$this->db->group_start();
					$miles_array = array_chunk($array_miles,500);

					foreach($miles_array as $milesarray){
						$this->db->where_not_in('listings.id', $milesarray);
					}
				$this->db->group_end();
			}

			$this->db->order_by('listings.featured', 'DESC');
	
			if($this->input->get('sort_by', TRUE) != 'closest'){
				$this->db->order_by('listings.id', 'DESC');
			}

			$this->db->order_by('listings.featured', 'DESC');

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('listings.breed_id', $this->input->get('breed_id', TRUE)); 
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('listings.country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('gender', TRUE) != 'all' && $this->input->get('gender', TRUE) != ''){
				$this->db->where('listings.gender', $this->input->get('gender', TRUE)); 
			}

			if($this->input->get('distance', TRUE) == '' && $this->input->get('distance', TRUE) == 'all'){
				if($this->input->get('post_code', TRUE) != ''){
					$this->db->where('listings.post_code', $this->input->get('post_code', TRUE)); 
				}
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->like('listings.title', $this->input->get('keywords', TRUE));
			}

			if($this->input->get('pedigree_only', TRUE) == 'on'){
				$this->db->where('listings.pedigree', 1); 
			}

			if($this->input->get('listings.distance', TRUE) != ''){
				
			}

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

	    public function get_listings($limit = FALSE, $offset = FALSE, $country_code,$latitude2,$longitude2){

	    	$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();

			$query = $this->db->get('listings');

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				if($this->input->get('post_code', TRUE) != ''){

					/*$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}
*/
					foreach($query->result_array() as $result){

						$latitude1 = $result['latitude'];
						$longitude1 = $result['longitude'];

						$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

						if($miles >= $this->input->get('distance', TRUE)){
							$array_miles[] = $result['id'];
						}

					}

				}else{
					

					if($country_code != '' && $country_code != 'NULL'){

						/*$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;*/

						foreach($query->result_array() as $result){

							$latitude1 = $result['latitude'];
							$longitude1 = $result['longitude'];

							$miles = (int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true);  

							if($miles >= $this->input->get('distance', TRUE)){
								$array_miles[] = $result['id'];
							}
							
						}
						
					}
												
				}

			}


			if(!empty($array_miles)){
				$this->db->group_start();
					$miles_array = array_chunk($array_miles,500);

					foreach($miles_array as $milesarray){
						$this->db->where_not_in('listings.id', $milesarray);
					}
				$this->db->group_end();
			}
			
			$this->db->order_by('listings.featured', 'DESC');


			if($limit){
				$this->db->limit($limit, $offset);
			}
	
			if($this->input->get('sort_by', TRUE) != 'closest'){
				$this->db->order_by('listings.id', 'DESC');
			}

			$this->db->order_by('listings.featured', 'DESC');

			if(is_numeric($this->input->get('breed_id', TRUE))){
				$this->db->where('listings.breed_id', $this->input->get('breed_id', TRUE)); 
			}

			if(is_numeric($this->input->get('country_id', TRUE))){
				$this->db->where('listings.country_id', $this->input->get('country_id', TRUE)); 
			}

			if($this->input->get('gender', TRUE) != 'all' && $this->input->get('gender', TRUE) != ''){
				$this->db->where('listings.gender', $this->input->get('gender', TRUE)); 
			}

			if($this->input->get('distance', TRUE) == '' && $this->input->get('distance', TRUE) == 'all'){
				if($this->input->get('listings.post_code', TRUE) != ''){
					$this->db->where('listings.post_code', $this->input->get('post_code', TRUE)); 
				}
			}

			if($this->input->get('keywords', TRUE) != ''){
				$this->db->like('listings.title', $this->input->get('keywords', TRUE));
			}

			if($this->input->get('listings.pedigree_only', TRUE) == 'on'){
				$this->db->where('listings.pedigree', 1); 
			}

			if($this->input->get('listings.distance', TRUE) != ''){
				
			}

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

		/*=============================================================================================
		[-- LISTINGS STUD DOGS PAGES FOR BREEDS ------------------------------------------------------]
	    ==============================================================================================*/
	    public function count_stud_dogs_breeds($breed_id){

	    	/*====================================================
			[-- USERS SUSPENDED ---------------------------------]
	    	====================================================*/
			$this->db->where('suspended', 1);
	    	$this->db->or_where('banned', 1);
	    	$query = $this->db->get('users');
			$notuser = $query->result_array();


			foreach($notuser as $nuser){
				$array_user[] = $nuser['id'];
			}

			if(!empty($array_user)){
				$this->db->group_start();
					$users_array = array_chunk($array_user,50);
					foreach($users_array as $userarray){
						$this->db->or_where_not_in('user_id', $userarray);
					}
				$this->db->group_end();
			}

	     	$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
			$this->db->where('breed_id', $breed_id);
	     	$this->db->where('listing_type', 'dog');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');
			return $query->num_rows();
		}

		public function get_stud_dogs_breeds($limit, $offset, $breed_id){

			if($limit){
				$this->db->limit($limit, $offset);
			}


			/*====================================================
			[-- USERS SUSPENDED ---------------------------------]
	    	====================================================*/
			$this->db->where('suspended', 1);
	    	$this->db->or_where('banned', 1);
	    	$query = $this->db->get('users');
			$notuser = $query->result_array();


			foreach($notuser as $nuser){
				$array_user[] = $nuser['id'];
			}

			if(!empty($array_user)){
				$this->db->group_start();
					$users_array = array_chunk($array_user,50);
					foreach($users_array as $userarray){
						$this->db->or_where_not_in('user_id', $userarray);
					}
				$this->db->group_end();
			}

			$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
			$this->db->where('breed_id', $breed_id);
	     	$this->db->where('listing_type', 'dog');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');
			return $query->result_array();
		}

		/*=============================================================================================
		[-- LISTINGS PUPPIES PAGES FOR BREEDS ------------------------------------------------------]
	    ==============================================================================================*/
	    public function count_puppies_breeds($breed_id){

	    	/*====================================================
			[-- USERS SUSPENDED ---------------------------------]
	    	====================================================*/
			$this->db->where('suspended', 1);
	    	$this->db->or_where('banned', 1);
	    	$query = $this->db->get('users');
			$notuser = $query->result_array();


			foreach($notuser as $nuser){
				$array_user[] = $nuser['id'];
			}

			if(!empty($array_user)){
				$this->db->group_start();
					$users_array = array_chunk($array_user,50);
					foreach($users_array as $userarray){
						$this->db->or_where_not_in('user_id', $userarray);
					}
				$this->db->group_end();
			}


	     	$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
			$this->db->where('breed_id', $breed_id);
	     	$this->db->where('listing_type', 'pup');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');
			return $query->num_rows();
		}

		public function get_puppies_breeds($limit, $offset, $breed_id){

			if($limit){
				$this->db->limit($limit, $offset);
			}

			/*====================================================
			[-- USERS SUSPENDED ---------------------------------]
	    	====================================================*/
			$this->db->where('suspended', 1);
	    	$this->db->or_where('banned', 1);
	    	$query = $this->db->get('users');
			$notuser = $query->result_array();


			foreach($notuser as $nuser){
				$array_user[] = $nuser['id'];
			}

			if(!empty($array_user)){
				$this->db->group_start();
					$users_array = array_chunk($array_user,50);
					foreach($users_array as $userarray){
						$this->db->or_where_not_in('user_id', $userarray);
					}
				$this->db->group_end();
			}

			
			$this->db->order_by('featured', 'DESC');
			$this->db->order_by('id', 'DESC');
			$this->db->where('breed_id', $breed_id);
	     	$this->db->where('listing_type', 'pup');
			$this->db->where('published', 1);
			$this->db->group_start();
				$this->db->where('deleted_at', NULL);
				$this->db->or_where('deleted_at', '0000-00-00 00:00:00');
			$this->db->group_end();
			$query = $this->db->get('listings');
			return $query->result_array();
		}

	}

