<?php 
	class Pages extends CI_Controller{

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

		function show_404(){
			$data['metatitle']          = 'Breed Your Dog';
            $data['metakeyword']        = 'Page Not found';
            $data['metadescription']    = 'Page Not found';
            $data['metarobots']         = 'NOINDEX, NOFOLLOW';

            $this->load->view('templates/header',$data);
            $this->load->view('templates/page-not-found',$data);
            $this->load->view('templates/footer',$data);
		}

		public function home($url = 'home'){	    
		  	$iploc = geoCheckIP($this->input->ip_address());
    		$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

		    if($iploc['country'] == 'US - United States'){
		    	$lang = 'us';
		    }else{
		    	$lang = 'en';
		    }    

			$data['page'] = $this->pages_model->get_home($url, $lang);

			if(empty($data['page'])){
				show_404();
			}

			$data['metatitle'] 			= $data['page']['meta_title'];
			$data['metakeyword'] 		= $data['page']['meta_keyword'];
			$data['metadescription'] 	= $data['page']['meta_description'];
			$data['metarobots'] 		= $data['page']['meta_robots'];

			$data['title'] 				= $data['page']['title'];
			$data['content']			= $data['page']['content'];
			$data['link'] 				= $data['page']['url'];
			$data['published'] 			= $data['page']['published'];

			
			$this->load->view('templates/header',$data);
			$this->load->view('pages/home',$data);
			$this->load->view('templates/footer',$data);

		}

		public function page($url = NULL){

			$iploc = geoCheckIP($this->input->ip_address());
    		$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
			
			if($this->input->get('country_id', TRUE) != ''){
				$countries = $this->getdata_model->get_countries();
				foreach($countries as $country):
				  if($this->input->get('country_id', TRUE) == $country['id']){
				   $country_code =  $country['code'];
				  }
				endforeach; 
			}

			$offset = @$this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = ($offset - 1) * 25;
			}else{
				$offset = 0;
			}

			// not used - handled by the home method
			if($url == 'home'){
				if($iploc['country'] == 'US - United States'){
					$lang = 'us';
				}else{
					$lang = 'en';
				} 
				
				$data['page'] = $this->pages_model->get_home($url, $lang);

				if(empty($data['page'])){
					show_404();
				}

				$data['metatitle'] 			= $data['page']['meta_title'];
				$data['metakeyword'] 		= $data['page']['meta_keyword'];
				$data['metadescription'] 	= $data['page']['meta_description'];
				$data['metarobots'] 		= $data['page']['meta_robots'];

				$data['title'] 				= $data['page']['title'];
				$data['content']			= $data['page']['content'];
				$data['link'] 				= $data['page']['url'];
				$data['published'] 			= $data['page']['published'];

				/*$this->load->library('image_lib');*/

				$featureds = $this->users_model->featured();

				/*=====================================================
				[-- LISTINGS CREATE SMALL THUBNAILS -------------------]
			    ======================================================*/
				/*foreach($featureds as $featured){

					$listing_id = $featured['id'];
					$listing_image = $this->users_model->get_listing_images($listing_id);

					$this->users_model->user_daily_views('index_homepage',$listing_id,'Listing');
					
					$new_image = './uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/thumb_small_'.$listing_image['image'];

					if(!empty($listing_image['image'])){
						$config = array(
				        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/'.$listing_image['image'],
				        'new_image'         => $new_image,
				        'maintain_ration'   => true,
				        'overwrite'         => true,
				        'quality'			=> '60%',
				        'width'             => 170,
				        'height'            => 150
				        );

				        $this->image_lib->initialize($config);
				        $this->image_lib->resize();
				        $this->image_lib->clear();
					}
				}*/

				$this->load->view('templates/header',$data);
				$this->load->view('pages/home',$data);
				$this->load->view('templates/footer',$data);

			}elseif($url == 'stud-dogs'){
				if($iploc['country'] == 'US - United States'){
					$config['base_url'] = base_url() . 'us/stud-dogs';
				}else{
					$config['base_url'] = base_url() . 'stud-dogs';
				} 
	 			
				$users_id_session = $this->session->userdata('user_id_byd');
				$id = $users_id_session;
				$info = $this->users_model->checkinfo($id);
				$country_code = $info['post_code'];


				if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

					if($this->input->get('post_code', TRUE) != ''){

						$address = strtr($this->input->get('post_code', TRUE),' ','+');

						$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						if($output->status != 'ZERO_RESULTS'){

							$latitude2 = $output->results[0]->geometry->location->lat;
							$longitude2 = $output->results[0]->geometry->location->lng;

						}


					}else if($country_code != '' && $country_code != 'NULL'){

						$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}

				}else{
					$latitude2 = NULL;
					$longitude2 = NULL;
				}

				$config['total_rows'] = $this->pages_model->count_stud_dogs($country_code,'NULL',$latitude2,$longitude2);
				$config['per_page'] = 25;
				$config['attributes'] = array('class' => 'pagination-link');
				$config['use_page_numbers'] = TRUE;
				$config['page_query_string'] = TRUE;
				$config['query_string_segment'] = 'page';
				$config['reuse_query_string'] = TRUE;

				$this->pagination->initialize($config);

				$data['metatitle'] 			= 'Over 16800 Stud Dogs Available Now - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= 'Find your perfect stud dog today, FREE to advertise, FREE to join, browse over 16800 stud dogs now.';
				$data['metarobots'] 		= '';
				
				$data['studdogs'] = $this->pages_model->get_stud_dogs($config['per_page'], $offset, $country_code,'NULL',$latitude2,$longitude2);
				$data['stud_images'] = $this->pages_model->first_images_for_listings($data['studdogs']);
				if(!empty($data['studdogs'])){
					if($this->input->get('sort_by', TRUE)){
						foreach ($data['studdogs'] as $daily_views_show){
							$this->users_model->user_daily_views('show',$daily_views_show['id'],'Listing');
						}
					}
				}

				$this->load->view('templates/header',$data);
				$this->load->view('pages/stud-dog',$data);
				$this->load->view('templates/footer',$data);

			}elseif($url == 'puppies'){
				if($iploc['country'] == 'US - United States'){
					$config['base_url'] = base_url() . 'us/puppies';
				}else{
					$config['base_url'] = base_url() . 'puppies';
				}

				$users_id_session = $this->session->userdata('user_id_byd');
				$id = $users_id_session;
				$info = $this->users_model->checkinfo($id);
				$country_code = $info['post_code'];

				if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

					if($this->input->get('post_code', TRUE) != ''){

						$address = strtr($this->input->get('post_code', TRUE),' ','+');

						$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						if($output->status != 'ZERO_RESULTS'){

							$latitude2 = $output->results[0]->geometry->location->lat;
							$longitude2 = $output->results[0]->geometry->location->lng;

						}


					}else if($country_code != '' && $country_code != 'NULL'){

						$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}

				}else{
					$latitude2 = NULL;
					$longitude2 = NULL;
				}
				
				$config['total_rows'] = $this->pages_model->count_puppies($country_code,'NULL',$latitude2,$longitude2);
				$config['per_page'] = 25;
				$config['attributes'] = array('class' => 'pagination-link');
				$config['use_page_numbers'] = TRUE;
				$config['page_query_string'] = TRUE;
				$config['query_string_segment'] = 'page';
				$config['reuse_query_string'] = TRUE;

				$this->pagination->initialize($config);

				$data['metatitle'] 			= 'Puppies For Sale - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= 'Find your perfect puppy today, FREE to advertise, FREE to join, browse puppies now.';
				$data['metarobots'] 		= '';

				$data['puppies'] = $this->pages_model->get_puppies($config['per_page'], $offset, $country_code,'NULL',$latitude2,$longitude2);
				$data['pup_images'] = $this->pages_model->first_images_for_listings($data['puppies']);

				if(!empty($data['puppies'])){
					if($this->input->get('sort_by', TRUE)){
						foreach ($data['puppies'] as $daily_views_show){
							$this->users_model->user_daily_views('show',$daily_views_show['id'],'Listing');
						}
					}
				}

				$this->load->view('templates/header',$data);
				$this->load->view('pages/puppies',$data);
				$this->load->view('templates/footer',$data);

			}elseif($url == 'memorials'){

				if($iploc['country'] == 'US - United States'){
					$config['base_url'] = base_url() . 'us/memorials';
				}else{
					$config['base_url'] = base_url() . 'memorials';
				} 
				
				$users_id_session = $this->session->userdata('user_id_byd');
				$id = $users_id_session;
				$info = $this->users_model->checkinfo($id);
				$country_code = $info['post_code'];

				if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

					if($this->input->get('post_code', TRUE) != ''){

						$address = strtr($this->input->get('post_code', TRUE),' ','+');

						$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						if($output->status != 'ZERO_RESULTS'){

							$latitude2 = $output->results[0]->geometry->location->lat;
							$longitude2 = $output->results[0]->geometry->location->lng;

						}


					}else if($country_code != '' && $country_code != 'NULL'){

						$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}

				}else{
					$latitude2 = NULL;
					$longitude2 = NULL;
				}

				$config['total_rows'] = $this->pages_model->count_memorials($country_code,$latitude2,$longitude2);
				$config['per_page'] = 25;
				$config['attributes'] = array('class' => 'pagination-link');
				$config['use_page_numbers'] = TRUE;
				$config['page_query_string'] = TRUE;
				$config['query_string_segment'] = 'page';
				$config['reuse_query_string'] = TRUE;

				$this->pagination->initialize($config);
				
				$data['metatitle'] 			= 'Stud Dog Memorials - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';

				$data['memorials'] = $this->pages_model->get_memorials($config['per_page'], $offset, $country_code,$latitude2,$longitude2);

				if(!empty($data['memorials'])){
					if($this->input->get('sort_by', TRUE)){
						foreach ($data['memorials'] as $daily_views_show){
							$this->users_model->user_daily_views('show',$daily_views_show['id'],'Listing');
						}
					}
				}

				$this->load->view('templates/header',$data);
				$this->load->view('pages/memorials',$data);
				$this->load->view('templates/footer',$data);

				
		
			}elseif($url == 'listings'){

				if($iploc['country'] == 'US - United States'){
					$config['base_url'] = base_url() . 'us/listings';
				}else{
					$config['base_url'] = base_url() . 'listings';
				} 

				$users_id_session = $this->session->userdata('user_id_byd');
				$id = $users_id_session;
				$info = $this->users_model->checkinfo($id);
				$country_code = $info['post_code'];
				
				if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

					if($this->input->get('post_code', TRUE) != ''){

						$address = strtr($this->input->get('post_code', TRUE),' ','+');

						$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						if($output->status != 'ZERO_RESULTS'){

							$latitude2 = $output->results[0]->geometry->location->lat;
							$longitude2 = $output->results[0]->geometry->location->lng;

						}


					}else if($country_code != '' && $country_code != 'NULL'){

						$country_address = strtr($country_code,' ','+');

						$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

						$output= json_decode($geocode);

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}

				}else{
					$latitude2 = NULL;
					$longitude2 = NULL;
				}


				$config['total_rows'] = $this->pages_model->count_listings($country_code,$latitude2,$longitude2);
				$config['per_page'] = 25;
				$config['attributes'] = array('class' => 'pagination-link');
				$config['use_page_numbers'] = TRUE;
				$config['page_query_string'] = TRUE;
				$config['query_string_segment'] = 'page';
				$config['reuse_query_string'] = TRUE;

				$this->pagination->initialize($config);


				$listings = $this->users_model->listings();
				
				$data['metatitle'] 			= 'Over '.count($listings).' Stud Dogs Available Now - Breed Your Dog';
				$data['metakeyword'] 		= 'Find your perfect stud dog today, FREE to advertise, FREE to join, browse over '.count($listings).' stud dogs now.';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';

				$data['listings'] = $this->pages_model->get_listings($config['per_page'], $offset, $country_code,$latitude2,$longitude2);

				if(!empty($data['listings'])){
					if($this->input->get('keywords', TRUE)){
						foreach ($data['listings'] as $daily_views_show){
							$this->users_model->user_daily_views('show',$daily_views_show['id'],'Listing');
						}
					}
				}

				$this->load->view('templates/header',$data);
				$this->load->view('pages/listings',$data);
				$this->load->view('templates/footer',$data);

				
			}elseif($url == 'breeds'){
				
				$data['metatitle'] 			= 'Stud Dog Breed Information - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';

				$data['kennels_sort'] = $this->getdata_model->get_kennelclub_sort();

				$this->load->view('templates/header',$data);
				$this->load->view('pages/breeds',$data);
				$this->load->view('templates/footer',$data);


			}elseif($url == 'cron-jobs'){

				$this->cronjobs_model->cronjobs_listings_featured();
				$this->cronjobs_model->cronjobs_listings_highlight();
				$this->cronjobs_model->cronjobs_listings_dog10years_up();
				$this->cronjobs_model->cronjobs_listings_pup6months_up();

				
				$data['metatitle']          = 'Breed Your Dog';
	            $data['metakeyword']        = 'Page Not found';
	            $data['metadescription']    = 'Page Not found';
	            $data['metarobots']         = 'NOINDEX, NOFOLLOW';

	            $this->load->view('templates/header',$data);
	            $this->load->view('templates/page-not-found',$data);
	            $this->load->view('templates/footer',$data);

			}elseif($url == 'cron-jobs-thumbnails'){

				/*=====================================================
				[-- START GENERATE THUMBS NAILS ----------------------]
			    ======================================================*/
	  			
		        $this->load->library('image_lib');

		        $userlistings = $this->getdata_model->get_listing_for_thumbnails_cron();

		        if(!empty($userlistings)){
		        	foreach($userlistings as $listing){

		        		$listing_id = $listing['id'];
			            $listing_image = $this->getdata_model->get_listing_images_for_thumbnails($listing_id);

						foreach($listing_image as $list_img){
					        if(!empty($list_img['image'])){   
								/*$config = array(
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
					            $this->image_lib->clear();*/


					            $config = array(
							        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$list_img['id'].'/'.$list_img['image'],
							        'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$list_img['id'].'/thumb_small_'.$list_img['image'],
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

			        	}
		        	}
		        }

		        /*=====================================================
				[-- END GENERATE THUMBS NAILS ------------------------]
			    ======================================================*/

				$data['metatitle']          = 'Breed Your Dog';
	            $data['metakeyword']        = 'Page Not found';
	            $data['metadescription']    = 'Page Not found';
	            $data['metarobots']         = 'NOINDEX, NOFOLLOW';

	            $this->load->view('templates/header',$data);
	            $this->load->view('templates/page-not-found',$data);
	            $this->load->view('templates/footer',$data);

			}elseif($url == 'cron-jobs-thumbnails-other'){

				/*=====================================================
				[-- START GENERATE THUMBS NAILS ----------------------]
			    ======================================================*/
	  			
		        $this->load->library('image_lib');

		        $userlistings = $this->getdata_model->get_listing_for_thumbnails_cron();

		        if(!empty($userlistings)){
		        	foreach($userlistings as $listing){

		        		$listing_id = $listing['id'];
			            $listing_image = $this->getdata_model->get_listing_images_for_thumbnails($listing_id);

						foreach($listing_image as $list_img){
					        if(!empty($list_img['image'])){   

					            $config = array(
						        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$list_img['id'].'/'.$list_img['image'],
						        'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$list_img['id'].'/thumb_small_'.$list_img['image'],
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
								$config['source_image'] = 'uploads/listing_images/'.$listing_id.'/'.$list_img['id'].'/'.$list_img['image'];
								$config['new_image'] = 'uploads/listing_images/'.$listing_id.'/'.$list_img['id'].'/big_'.$list_img['image'];
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
		        }

		        /*=====================================================
				[-- END GENERATE THUMBS NAILS ------------------------]
			    ======================================================*/

				$data['metatitle']          = 'Breed Your Dog';
	            $data['metakeyword']        = 'Page Not found';
	            $data['metadescription']    = 'Page Not found';
	            $data['metarobots']         = 'NOINDEX, NOFOLLOW';

	            $this->load->view('templates/header',$data);
	            $this->load->view('templates/page-not-found',$data);
	            $this->load->view('templates/footer',$data);

			}elseif($url == 'cron-jobs-thumbnails-featured'){

				/*=====================================================
				[-- START GENERATE THUMBS NAILS ----------------------]
			    ======================================================*/
	  			
		        $this->load->library('image_lib');

				$data['featureds'] = $this->users_model->cron_featured();

				/*=====================================================
				[-- LISTINGS CREATE SMALL THUBNAILS -------------------]
			    ======================================================*/
				foreach($data['featureds'] as $featured){

					$listing_id = $featured['id'];
					$listing_image = $this->users_model->get_listing_images($listing_id);

					$this->users_model->user_daily_views('index_homepage',$listing_id,'Listing');
					
					$new_image = './uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/thumb_small_'.$listing_image['image'];

					if(!empty($listing_image['image'])) {
						$config = array(
				        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/'.$listing_image['image'],
				        'new_image'         => $new_image,
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

				}

				$data['metatitle']          = 'Breed Your Dog';
	            $data['metakeyword']        = 'Page Not found';
	            $data['metadescription']    = 'Page Not found';
	            $data['metarobots']         = 'NOINDEX, NOFOLLOW';

	            $this->load->view('templates/header',$data);
	            $this->load->view('templates/page-not-found',$data);
	            $this->load->view('templates/footer',$data);

			}else{
				$data['page'] = $this->pages_model->get_pages($url);

				if(empty($data['page'])){
					show_404();
				}

				$data['metatitle'] 			= $data['page']['meta_title'];
				$data['metakeyword'] 		= $data['page']['meta_keyword'];
				$data['metadescription'] 	= $data['page']['meta_description'];
				$data['metarobots'] 		= $data['page']['meta_robots'];

				$data['title'] 			= $data['page']['title'];
				$data['content']		= $data['page']['content'];
				$data['link'] 			= $data['page']['url'];
				$data['published'] 		= $data['page']['published'];

				if( $data['published'] == 0 ){
					show_404();
				}

				$this->load->view('templates/header',$data);

				if($data['link'] == 'home'){
					$this->load->view('pages/home',$data);
				}else{
					$this->load->view('pages/pages',$data);
				}
				
				$this->load->view('templates/footer',$data);
			}
		}

		public function user_plans(){
			$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$data['basic'] =  $this->getdata_model->get_plans_id(1);
			$data['personal'] =  $this->getdata_model->get_plans_id(5);
			$data['business'] =  $this->getdata_model->get_plans_id(6);
			$data['ultimate'] =  $this->getdata_model->get_plans_id(7);

			$this->load->view('templates/header',$data);
			$this->load->view('pages/user-plans',$data);
			$this->load->view('templates/footer',$data);

		}

		public function user_change_plan(){

			if($this->input->post('plan_id') != ''){

				if($this->input->post('plan_id') == 1){

					$sub = $this->payment_model->get_subscription($this->session->userdata('user_id_byd'));

                    $this->paypal_recurring->change_subscription_status($sub['paypal_id'],'Cancel');

					$this->users_model->user_change_plan_basic($this->session->userdata('user_id_byd'));

					$this->session->set_flashdata('flashdata_success', 'Successfuly Change Plan into Basic');

					if($this->uri->segment(1) == 'us'){
						$iploc['country'] = 'US - United States';
					}else{
						$iploc = geoCheckIP($this->input->ip_address());
    					$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
					}
				
					if($iploc['country'] == 'US - United States'){
						redirect('us/user/dashboard');
					}else{
						redirect('user/dashboard');
					}   	

				}else{

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

					$plan = $this->getdata_model->get_plans_id($this->input->post('plan_id'));
					
					if($country_lang == 'us'){
						$price_payment = number_format($plan['price_us']/100,2);
						$description = $plan['name'].' - $ '.number_format($plan['price_us']/100,2).' / Month';
						$currency = 'USD';
					}else{
						$price_payment = number_format($plan['price_en']/100,2);
						$description = $plan['name'].' - £ '.number_format($plan['price_en']/100,2).' / Month';
						$currency = 'GBP';
					}

					$product = array(
						'Subscription' => array('name' => 'Subscription', 'desc' => $description, 'price' => $price_payment));
					//$currency = $paypal_currency; // currency for the transaction
					$ec_action = 'Sale'; // for PAYMENTREQUEST_0_PAYMENTACTION, it's either Sale, Order or Authorization

					$payment_session_id = array(
						'payment_session_id' => $this->session->userdata('user_id_byd'),
						'payment_sub_description'	=> $description,
						'payment_plan_id'	=> $this->input->post('plan_id'),
						'payment_subscription' => true,
						'payment_change_plan'	=>true
					);
					$this->session->set_userdata($payment_session_id);
					//'desc' => 'Breed Your Dog - Subscription', 
					$to_buy = array(
						'desc' => $description, 
						'currency' => $currency, 
						'type' => $ec_action, 
						'return_URL' => site_url('subscription'), 
						// see below have a function for this -- function back()
						// whatever you use, make sure the URL is live and can process
						// the next steps
						'cancel_URL' => site_url('subscription/cancelled'), // this goes to this controllers index()
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
					$set_ec_return = $this->paypal_recurring->set_ec($to_buy);
					if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
						/* --------------------------
						* redirect to Paypal 
						-------------------------- */
						$this->paypal_recurring->redirect_to_paypal($set_ec_return['TOKEN']);
						/* -------------------------------------------------------------------------------------
						* You could detect your visitor's browser and redirect to Paypal's mobile checkout
						* if they are on a mobile device. Just add a true as the last parameter. It defaults
						* to false
						* $this->paypal_recurring->redirect_to_paypal( $set_ec_return['TOKEN'], true);
						--------------------------------------------------------------------------------------*/

					} else {
						$this->_error($set_ec_return);
					}

				}


			}else{
				show_404();
			}

		}

		public function user_new_plans(){

			$data['basic'] =  $this->getdata_model->get_plans_id(1);
			$data['personal'] =  $this->getdata_model->get_plans_id(5);
			$data['business'] =  $this->getdata_model->get_plans_id(6);
			$data['ultimate'] =  $this->getdata_model->get_plans_id(7);

			$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]|valid_email',
				array('is_unique' => 'has already been taken'));
		    $this->form_validation->set_rules('password', 'Password', 'required');
		    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		    if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header' ,$data);
				$this->load->view('pages/user-new-plans');
				$this->load->view('templates/footer');
			}else{

				$hash_password = hash('sha512', $this->input->post('password'));

				$uniq = uniqid();

				$confirm = $uniq.hash('md5', $this->input->post('email'));

	    		$confirmcode = $confirm;

				$user_id = $this->users_model->users_new($hash_password,$confirmcode);

				$user_register = array(
					'user_email_register' => $this->input->post('email')
				);
				$this->session->set_userdata($user_register);

				$email_style = '<link href="'.base_url() .'assets/css/style-admin.min.css" rel="stylesheet" type="text/css">';

				$linkconfirmation_code = base_url('user/confirm/'.$confirmcode);


				/*$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';

				$this->email->initialize($config);

				$this->email->from('no-reply@breedyourdog.com');
				$this->email->to($this->input->post('email'));
				$this->email->bcc('byd@breedyourdog.com');

				$this->email->subject('Welcome to Breed Your Dog');

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
							<h1>Welcome to Breed Your Dog</h1>
							<p>Please click the following link to confirm your account</p>
							<a href="'.$linkconfirmation_code.'">'.$linkconfirmation_code.'</a>
							<p>If the above link is not clickable, please copy and paste it into your browser&#39;s address bar</p>
							<p><i>
								Kind Regards<br>
								The Breed Your Dog Team
							</i></p>
						</body>
						</html>
					');

				$this->email->send();*/

				if($this->input->post('plans') != 1){

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

					$plan = $this->getdata_model->get_plans_id($this->input->post('plans'));
					
					if($country_lang == 'us'){
						$price_payment = number_format($plan['price_us']/100,2);
						$description = $plan['name'].' - $ '.number_format($plan['price_us']/100,2).' / Month';
						$currency = 'USD';
					}else{
						$price_payment = number_format($plan['price_en']/100,2);
						$description = $plan['name'].' - £ '.number_format($plan['price_en']/100,2).' / Month';
						$currency = 'GBP';
					}

					$product = array(
						'Subscription' => array('name' => 'Subscription', 'desc' => $description, 'price' => $price_payment));
					//$currency = $paypal_currency; // currency for the transaction
					$ec_action = 'Sale'; // for PAYMENTREQUEST_0_PAYMENTACTION, it's either Sale, Order or Authorization

					$payment_session_id = array(
						'payment_session_id' => $user_id,
						'payment_sub_description'	=> $description,
						'payment_plan_id'	=> $this->input->post('plans'),
						'payment_subscription' => true
					);
					$this->session->set_userdata($payment_session_id);
					//'desc' => 'Breed Your Dog - Subscription', 
					$to_buy = array(
						'desc' => $description, 
						'currency' => $currency, 
						'type' => $ec_action, 
						'return_URL' => site_url('subscription'), 
						// see below have a function for this -- function back()
						// whatever you use, make sure the URL is live and can process
						// the next steps
						'cancel_URL' => site_url('subscription/cancelled'), // this goes to this controllers index()
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
					$set_ec_return = $this->paypal_recurring->set_ec($to_buy);
					if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
						/* --------------------------
						* redirect to Paypal 
						-------------------------- */
						$this->paypal_recurring->redirect_to_paypal($set_ec_return['TOKEN']);
						/* -------------------------------------------------------------------------------------
						* You could detect your visitor's browser and redirect to Paypal's mobile checkout
						* if they are on a mobile device. Just add a true as the last parameter. It defaults
						* to false
						* $this->paypal_recurring->redirect_to_paypal( $set_ec_return['TOKEN'], true);
						--------------------------------------------------------------------------------------*/

					} else {
						$this->_error($set_ec_return);
					}

				}else{

					if($this->uri->segment(1) == 'us'){
						$iploc['country'] = 'US - United States';
					}else{
						$iploc = geoCheckIP($this->input->ip_address());
    					$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
					}
					
					http://www.breedyourdog.com

					if($iploc['country'] == 'US - United States'){
						redirect('admin/users/'.$user_id.'/log_in_as');
					}else{
						redirect('admin/users/'.$user_id.'/log_in_as');
					} 	

					/*if($iploc['country'] == 'US - United States'){
						redirect('us/user');
					}else{
						redirect('user');
					} 	*/			
					
				}
			}
		}

		public function user(){
			$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			if($this->session->userdata('user_email_register') == ''){
				show_404();
			}

			$this->load->view('templates/header',$data);
			$this->load->view('pages/user',$data);
			$this->load->view('templates/footer',$data);
		}


		/*=====================================================
		[-- CUSTOMER / USERS EMAIL CONFIRM -------------------]
	    ======================================================*/
		public function user_confirm($id){

			$confirmed = $this->pages_model->user_confirmed($id);

			if(!empty($confirmed)){
				$this->pages_model->user_remove_confirm_code($confirmed['id']);

				$data['users'] = $this->users_model->get_users($confirmed['id']);
				$user_data = array(
					'user_id_byd' => $confirmed['id'],
					'userlogged_in' => true
				);
				$this->session->set_userdata($user_data);

				redirect('user/dashboard');

			}else{
				show_404();
			}
		}

		public function contact(){
			$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$this->form_validation->set_rules('email', 'Email', 'required|valid_email',
				array("required" => "can't be blank"));
		   	$this->form_validation->set_rules('message', 'Message', 'required',
				array("required" => "can't be blank"));

		   	$this->form_validation->set_rules('g-recaptcha-response', 'Recaptcha', 'required|callback_recapthca_validation',
				array("required" => "can't be blank"));

		    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		    if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header',$data);
				$this->load->view('pages/contact',$data);
				$this->load->view('templates/footer',$data);
			}else{

				$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';

				$this->email->initialize($config);

				/*$this->email->from('no-reply@breedyourdog.com');*/
				$this->email->from($this->input->post('email'));
				$this->email->to('byd@breedyourdog.com,breedyourdog@hotmail.co.uk');
				/*$this->email->cc('rj@page1europe.eu');*/
				//$this->email->bcc('byd@breedyourdog.com,breedyourdog@hotmail.co.uk');

				$this->email->subject('Contact Us');

				$email_style = '<link href="'.base_url() .'assets/css/style-admin.min.css" rel="stylesheet" type="text/css">';

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
							<p>Dear Breed Your Dog,</p>
							<p>First Name : '.$this->input->post('first_name').'</p>
							<p>Last Nanem : '.$this->input->post('last_name').'</p>
							<p>Email : '.$this->input->post('email').'</p>
							<p>Phone : '.$this->input->post('phone').'</p>
							<p>Message : '.$this->input->post('message').'</p>
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
				$this->session->set_flashdata('flashdata_success', 'Your message has been sent. We will respond as soon as possible.');
				redirect('contact');
			}	

		}


		public function newsletter_email(){

			if($this->input->post('email') == ''){
				show_404();
			}

			$this->form_validation->set_rules('email', 'Email', 'required|valid_email',
				array("required" => "can't be blank"));

			$this->form_validation->set_rules('g-recaptcha-response', 'Recaptcha', 'required|callback_recapthca_validation_newsletter',
				array("required" => "can't be blank"));

		    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		    if($this->form_validation->run() === FALSE){
				show_404();
			}else{

				$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';

				$this->email->initialize($config);

				/*$this->email->from('no-reply@breedyourdog.com');*/
				$this->email->from($this->input->post('email'));
				$this->email->to('byd@breedyourdog.com,breedyourdog@hotmail.co.uk');
				/*$this->email->cc('rj@page1europe.eu');*/
				//$this->email->bcc('byd@breedyourdog.com');

				$this->email->subject('Newsletter');

				$email_style = '<link href="'.base_url() .'assets/css/style-admin.min.css" rel="stylesheet" type="text/css">';

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
							<p>Dear Breed Your Dog,</p>
							
							<p>Newsletter : '.$this->input->post('email').'</p>
							
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
				$this->session->set_flashdata('flashdata_success_newsletter', 'Successfuly sent');
				redirect(''.base_url().'');
			}	

		}

		public function breeds($slug){

			$data['breed'] = $this->getdata_model->get_kennel_breeds_slug($slug);

			if(empty($data['breed'])){
				show_404();
			}

			$data['metatitle'] 			= $data['breed']['name'].' - Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$this->load->view('templates/header',$data);
			$this->load->view('pages/breed-single-page',$data);
			$this->load->view('templates/footer',$data);
		}

		public function stud_dogs_breed($slug){

			$data['breed_info'] = $this->getdata_model->get_kennel_breeds_slug($slug);
			$breed_id = $data['breed_info']['id'];

			if(empty($data['breed_info'])){
				show_404();
			}

			$offset = @$this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = $offset - 1;
			}else{
				$offset = 0;
			}

			$users_id_session = $this->session->userdata('user_id_byd');
			$id = $users_id_session;
			$info = $this->users_model->checkinfo($id);
			$country_code = $info['post_code'];

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				if($this->input->get('post_code', TRUE) != ''){

					$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}


				}else if($country_code != '' && $country_code != 'NULL'){

					$country_address = strtr($country_code,' ','+');

					$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					$latitude2 = $output->results[0]->geometry->location->lat;
					$longitude2 = $output->results[0]->geometry->location->lng;

				}

			}else{
				$latitude2 = NULL;
				$longitude2 = NULL;
			}

			$count_stud_dogs_num = $this->pages_model->count_stud_dogs($country_code,$breed_id,$latitude2,$longitude2);

			$config['base_url'] = base_url() . 'stud-dogs?breed_id='.$breed_id;
			$config['total_rows'] = $count_stud_dogs_num;
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);

			if($count_stud_dogs_num == 0){
				$studname = '';
			}else{
				$studname = $data['breed_info']['name'].' ';
			}
			
			$data['metatitle'] 			= $studname."Stud Dogs Available Now - Breed Your Dog";
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= 'Find your perfect stud dog today, FREE to advertise, FREE to join, browse '.$data['breed_info']['name'].' stud dogs now.';
			$data['metarobots'] 		= '';

			$data['studdogs'] = $this->pages_model->get_stud_dogs($config['per_page'], $offset, $country_code, $breed_id,$latitude2,$longitude2);

			$this->load->view('templates/header',$data);
			$this->load->view('pages/stud-dog-breeds',$data);
			$this->load->view('templates/footer',$data);
		}

		public function puppies_breed($slug){

			$data['breed_info'] = $this->getdata_model->get_kennel_breeds_slug($slug);
			$breed_id = $data['breed_info']['id'];

			if(empty($data['breed_info'])){
				show_404();
			}

			$offset = @$this->input->get('page', TRUE);
			
			if($offset  > 0){
				$offset = $offset - 1;
			}else{
				$offset = 0;
			}

			$users_id_session = $this->session->userdata('user_id_byd');
			$id = $users_id_session;
			$info = $this->users_model->checkinfo($id);
			$country_code = $info['post_code'];

			if($this->input->get('distance', TRUE) != '' && $this->input->get('distance', TRUE) != 'all'){

				if($this->input->get('post_code', TRUE) != ''){

					$address = strtr($this->input->get('post_code', TRUE),' ','+');

					$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					if($output->status != 'ZERO_RESULTS'){

						$latitude2 = $output->results[0]->geometry->location->lat;
						$longitude2 = $output->results[0]->geometry->location->lng;

					}


				}else if($country_code != '' && $country_code != 'NULL'){

					$country_address = strtr($country_code,' ','+');

					$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

					$output= json_decode($geocode);

					$latitude2 = $output->results[0]->geometry->location->lat;
					$longitude2 = $output->results[0]->geometry->location->lng;

				}

			}else{
				$latitude2 = NULL;
				$longitude2 = NULL;
			}

			$count_puppies_num = $this->pages_model->count_puppies($country_code,$breed_id,$latitude2,$longitude2);

			$config['base_url'] = base_url() . 'stud-dogs?breed_id='.$breed_id;
			$config['total_rows'] = $count_puppies_num;
			$config['per_page'] = 25;
			$config['attributes'] = array('class' => 'pagination-link');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['reuse_query_string'] = TRUE;

			$this->pagination->initialize($config);

			if($count_puppies_num == 0){
				$pupname = '';
			}else{
				$pupname = $data['breed_info']['name'].' ';
			}
			

			$data['metatitle'] 			= $pupname.'Puppies For Sale - Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= 'Find your perfect puppy today, FREE to advertise, FREE to join, browse '.$data['breed_info']['name'].' puppies now.';
			$data['metarobots'] 		= '';

			$data['puppies'] = $this->pages_model->get_puppies($config['per_page'], $offset, $country_code, $breed_id,$latitude2,$longitude2);

			$this->load->view('templates/header',$data);
			$this->load->view('pages/puppies-breeds',$data);
			$this->load->view('templates/footer',$data);
		}


		public function userlogin(){

	    	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	    	$this->form_validation->set_rules('password', 'Password', 'required');

	    	if($this->form_validation->run() === FALSE){

	    		$this->session->set_flashdata('flashdata_failed', 'Invallid Email or Password');
				redirect(''.base_url().'');
	    		
	    	}else{
	    	
	    		$email = $this->input->post('email');
	    		$password = $this->input->post('password');
	    		$users_id = $this->users_model->userlogin($email, $password);

	    		if($users_id != ''){

	    			$id = $users_id;
	    			$user_login = $this->getdata_model->get_user($id);

	    			if($user_login['banned'] == 1){

	    				$this->session->set_flashdata('flashdata_failed', 'You have been banned from Breed Your Dog.');
						redirect(''.base_url().'');

	    			}else if($user_login['confirm_code'] != ''){
	    				
						$iploc = geoCheckIP($this->input->ip_address());
    					$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

						if($iploc['country'] == 'US - United States'){
							redirect('us/needs-confirm');
						}else{
							redirect('needs-confirm');
						}  
						
	    			}else{
	    				$data['users'] = $this->users_model->get_users($users_id);

						$user_data = array(
							'user_id_byd' => $data['users']['id'],
							'userlogged_in' => true
						);
						$this->session->set_userdata($user_data);

						$iploc = geoCheckIP($this->input->ip_address());
    					$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

						if($iploc['country'] == 'US - United States'){
							redirect('us/user/dashboard');
						}else{
							redirect('user/dashboard');
						}  
	    			}

				}else{
					$this->session->set_flashdata('flashdata_failed', 'Invallid Email or Password');
					redirect(''.base_url().'');
				}
			}

	    }

	    public function validemail(){

	    	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

	    	if($this->form_validation->run() === FALSE){
	    		
	    	}
	    }

	    public function userloginmodal(){

	    	$email = $this->input->post('email');
    		$password = $this->input->post('password');
    		$users_id = $this->users_model->userlogin($email, $password);
    		$result = array();

	    	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

	    	if($this->form_validation->run() === FALSE){

	    		$result['status'] = 'failed';
					$result['errordisplay'] = '<div class="alert alert-danger alert-dismissable fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Please enter valid email.</div>';
					
					echo json_encode($result);

	    	}else{

	    		if($users_id != ''){

	    			$id = $users_id;
	    			$user_login = $this->getdata_model->get_user($id);

	    			if($user_login['banned'] == 1){

	    				$result['status'] = 'failed';
						$result['errordisplay'] = '<div class="alert alert-danger alert-dismissable fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>You have been banned from Breed Your Dog.</div>';
						
						echo json_encode($result);

	    			}elseif($user_login['confirm_code'] != ''){
	    				
						$iploc = geoCheckIP($this->input->ip_address());
						$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

						if($iploc['country'] == 'US - United States'){
							$redirect = 'us/needs-confirm';
						}else{
							$redirect = 'needs-confirm';
						} 

						$result['status'] = 'confirm';
						$result['url'] = base_url($redirect);
						
						echo json_encode($result);
						
	    			}else{
	    				$data['users'] = $this->users_model->get_users($users_id);

						$user_data = array(
							'user_id_byd' => $data['users']['id'],
							'userlogged_in' => true
						);
						$this->session->set_userdata($user_data);

						$iploc = geoCheckIP($this->input->ip_address());
						$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];

						if($iploc['country'] == 'US - United States'){
							$redirect = 'us/user/dashboard';
						}else{
							$redirect = 'user/dashboard';
						} 

						$result['status'] = 'success';
						$result['url'] = base_url($redirect);

						echo json_encode($result);
	    			}

				}else{

					$result['status'] = 'failed';
						$result['errordisplay'] = '<div class="alert alert-danger alert-dismissable fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Invallid Email or Password</div>';
						
						echo json_encode($result);
				}

	    	}


	    }

	    public function userlogout(){
			$this->session->unset_userdata('userlogged_in');
			$this->session->unset_userdata('user_id_byd');

			$this->session->set_flashdata('flashdata_info', 'You have been Logged Out');
			redirect(''.base_url().'');
		}


		/*=====================================================
		[-- USER PASSWORD LOST -------------------------------]
	    ======================================================*/
		public function user_lost(){
			$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

	    	if($this->form_validation->run() === FALSE){
	    		$this->load->view('templates/header',$data);
				$this->load->view('pages/user-lost',$data);
				$this->load->view('templates/footer',$data);	
	    	}else{

	    		$email_reset = $this->pages_model->user_email_reset($this->input->post('email'));

				//print_pre($email_reset);


	    		if(!empty($email_reset)){
				$this->session->set_flashdata('flashdata_success', 'Your password has been reset, and your new password emailed to you');
				redirect('user/reset');

				}else{
					$this->session->set_flashdata('flashdata_danger', 'The email address you entered was not recognised, please check it and try again');
					redirect('user/reset');
				}

	    	}
		}


		/*=====================================================
		[-- USER PASSWORD RESET ------------------------------]
	    ======================================================*/
	    public function user_reset(){
			$data['metatitle'] 			= 'Breed Your Dog';
			$data['metakeyword'] 		= '';
			$data['metadescription'] 	= '';
			$data['metarobots'] 		= '';

			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

	    	if($this->form_validation->run() === FALSE){
	    		$this->load->view('templates/header',$data);
				$this->load->view('pages/user-lost',$data);
				$this->load->view('templates/footer',$data);	
	    	}else{

	    		$email_reset = $this->pages_model->user_email_reset($this->input->post('email'));

				//print_pre($email_reset);


	    		if(!empty($email_reset)){

	    			$uniqid = uniqid();

					$hash_password = hash('sha512', $uniqid);
					$this->users_model->user_password_update($hash_password,$email_reset['id']);

	    			$config['protocol'] = 'sendmail';
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';

					$this->email->initialize($config);

					$this->email->from('no-reply@breedyourdog.com');
					/*$this->email->from('rj@page1europe.eu');*/
					$this->email->to($email_reset['email']);
					/*$this->email->cc('rj@page1europe.eu');*/
					$this->email->bcc('byd@breedyourdog.com');

					$this->email->subject('Breed Your Dog password reset');

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
								<p>Dear '.$email_reset['first_name'].',</p>
								<p>Your password for Breed Your Dog has been reset to: </p>
								<p>'.$uniqid.'</p>
								<p>We recommend you change this password, especially if you did not request this password reset. </p>
								
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


					$this->session->set_flashdata('flashdata_success', 'Your password has been reset, and your new password emailed to you');
					redirect('user/reset');

				}else{
					$this->session->set_flashdata('flashdata_danger', 'The email address you entered was not recognised, please check it and try again');
					redirect('user/reset');
				}

	    	}
	    }


	    /*=====================================================
		[-- RECAPTCHA VALIDATION -----------------------------]
	    ======================================================*/
	    public function recapthca_validation($check){

	    	$form_response=$this->input->post('g-recaptcha-response');
			$url="https://www.google.com/recaptcha/api/siteverify";
			$secretkey="6Lc5N0IUAAAAAIy8g9yjGLMsHKEE13q8RKJudmLg";
			$response=file_get_contents($url."?secret=".$secretkey."&response=".$form_response."&remoteip=".$_SERVER["REMOTE_ADDR"]);
			$data=json_decode($response);
			if(isset($data->success) && $data->success=="true"){
				return true;
			}else{
				$this->session->set_flashdata('flashdata_failed_recapthca', "reCAPTCHA can't be blank");
				return false;
			}

	    }

	    public function recapthca_validation_newsletter($check){

	    	$form_response=$this->input->post('g-recaptcha-response');
			$url="https://www.google.com/recaptcha/api/siteverify";
			$secretkey="6Lc5N0IUAAAAAIy8g9yjGLMsHKEE13q8RKJudmLg";
			$response=file_get_contents($url."?secret=".$secretkey."&response=".$form_response."&remoteip=".$_SERVER["REMOTE_ADDR"]);
			$data=json_decode($response);
			if(isset($data->success) && $data->success=="true"){
				return true;
			}else{
				$this->session->set_flashdata('flashdata_failed_newsletter', "reCAPTCHA can't be blank");
				return false;
			}

	    }
	}