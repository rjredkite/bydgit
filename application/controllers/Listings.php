<?php
	class Listings extends CI_Controller{

		public function index($id){

			$listing_id = $id;
			$listing = $this->getdata_model->get_listing($listing_id);

			$data['listing'] = $listing;

			$slug_title = url_title($listing['title'], 'dash', TRUE);

			if(empty($listing)){
				show_404();
			}

			if($listing['published'] == 0){
				show_404();
			}

			if($listing['id'] != $id){
				show_404();
			}

			if($this->input->get('context', TRUE)){

				$this->users_model->user_daily_views($this->input->get('context', TRUE),$id,'Listing');

			}

			/*=====================================================
			[-- LISTINGS CREATE SMALL THUBNAILS -------------------]
		    ======================================================*/

			$listing_id = $listing['id'];
			$listing_image_result = $this->users_model->get_listing_images_result($listing_id);

			$this->load->library('image_lib');

			/*foreach($listing_image_result as $listing_image){

				if(!empty($listing_image['image'])){
					$config = array(
			        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/'.$listing_image['image'],
			        'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/thumb_small_'.$listing_image['image'],
			        'maintain_ration'   => true,
			        'overwrite'         => true,
			        'quality'			=> '70%',
			        'width'             => 100,
			        'height'            => 100
			        );

			        $this->image_lib->initialize($config);
			        $this->image_lib->resize();
			        $this->image_lib->clear();

			        $config['image_library'] = 'GD2';
					$config['source_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/'.$listing_image['image'];
					$config['new_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/big_'.$listing_image['image'];
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
			}*/

			/*=====================================================
			[-- DONT DISPLAY IF SUSPENDED ------------------------]
		    ======================================================*/
			$id = $listing['user_id'];
			$user = $this->getdata_model->get_user($id);
			if($user['suspended'] == 1):
		  	  show_404();
		    endif;

			if($listing['listing_type'] == 'dog'){
				$data['metatitle'] 			= 'Stud Dog - '.$listing['title'].' - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';
			}elseif($listing['listing_type'] == 'pup'){
				$data['metatitle'] 			= 'Puppies For Sale - '.$listing['title'].' - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';
			}else{
				$data['metatitle'] 			= 'Memorial - '.$listing['title'].' - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';
			}

			$this->load->view('templates/header',$data);
			$this->load->view('pages/listing-single-page',$data);
			$this->load->view('templates/footer',$data);
		}

		public function listing_type($id,$title){
			
			$listing_id = $id;
			$listing = $this->getdata_model->get_listing($listing_id);

			$data['listing'] = $listing;

			$slug_title = url_title($listing['title'], 'dash', TRUE);

			if(empty($listing)){
				show_404();
			}

			if($listing['published'] == 0){
				show_404();
			}

			if($listing['id'] != $id || $slug_title != $title){
				show_404();
			}

			$this->users_model->user_daily_views('index',$id,'Listing');
			
			/*=====================================================
			[-- DONT DISPLAY IF SUSPENDED ------------------------]
		    ======================================================*/
			$id = $listing['user_id'];
			$user = $this->getdata_model->get_user($id);
			if($user['suspended'] == 1):
		  	  show_404();
		    endif;

		    /*=====================================================
			[-- LISTINGS CREATE SMALL THUBNAILS -------------------]
		    ======================================================*/

			$listing_id = $listing['id'];
			$listing_image_result = $this->users_model->get_listing_images_result($listing_id);

			$this->load->library('image_lib');

			foreach($listing_image_result as $listing_image){

				if(!empty($listing_image['image'])){

					/* QUICK FIX FOR IMGCOPY ERROR

					$config = array(
			        'source_image'      => './uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/'.$listing_image['image'],
			        'new_image'         => './uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/thumb_small_'.$listing_image['image'],
			        'maintain_ration'   => true,
			        'overwrite'         => true,
			        'quality'			=> '70%',
			        'width'             => 100,
			        'height'            => 100
			        );

			        $this->image_lib->initialize($config);
			        $this->image_lib->resize();
			        $this->image_lib->clear();

			        $config['image_library'] = 'GD2';
					$config['source_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/'.$listing_image['image'];
					$config['new_image'] = 'uploads/listing_images/'.$listing_id.'/'.$listing_image['id'].'/big_'.$listing_image['image'];
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

					*/
				}
			}
			
			

			if($listing['listing_type'] == 'dog'){
				$data['metatitle'] 			= 'Stud Dog - '.$listing['title'].' - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';
			}elseif($listing['listing_type'] == 'pup'){
				$data['metatitle'] 			= 'Puppies For Sale - '.$listing['title'].' - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';
			}else{
				$data['metatitle'] 			= 'Memorial - '.$listing['title'].' - Breed Your Dog';
				$data['metakeyword'] 		= '';
				$data['metadescription'] 	= '';
				$data['metarobots'] 		= '';
			}
			
			$this->load->view('templates/header',$data);
			$this->load->view('pages/listing-single-page',$data);
			$this->load->view('templates/footer',$data);

		}

	}