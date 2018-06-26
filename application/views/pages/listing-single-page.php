<?php
  
  if($listing['views'] == 0 || $listing['views'] == ''){
  	$listing_id = $listing['id'];
  	$this->users_model->listing_views_zero($listing_id);
  }else{
  	$listing_id = $listing['id'];
  	$this->users_model->listing_views($listing_id);
  }

  $users_id = $this->session->userdata('user_id_byd');
  $userinfo = $this->users_model->get_users($users_id);
  $userlistings = $this->getdata_model->get_user_listing($users_id);
  $userlistings_number = $this->getdata_model->get_user_listing_number($users_id);
  date_default_timezone_set("Europe/London");
  $datenow = date('Y-m-d');
      
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
  
?>

<div class="listing-page-container">
	<div class="header-container">
		<div class="container">
			<div class="listing-page-header">
				<h1><?php echo $listing['title']; ?></h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="alert-container">
		   <?php if($this->session->flashdata('flashdata_success')) : ?>
		      <?php echo '
		          <div class="alert alert-success alert-dismissable fade in">
		            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
		            .$this->session->flashdata('flashdata_success').
		        '</div>'
		      ; ?>
		      <?php endif; ?>
		      <?php if($this->session->flashdata('flashdata_danger')) : ?>
		      <?php echo '
		          <div class="alert alert-danger alert-dismissable fade in">
		            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
		            .$this->session->flashdata('flashdata_danger').
		        '</div>'
		      ; ?>
		    <?php endif; ?>
		    <?php if($this->session->flashdata('flashdata_info')) : ?>
		      <?php echo '
		          <div class="alert alert-info alert-dismissable fade in">
		            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
		            .$this->session->flashdata('flashdata_info').
		        '</div>'
		      ; ?>
		    <?php endif; ?>
		</div>
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="listing-page-body">
					<div class="row">
						<div class="col-sm-4">
							<?php 
		                        $listing_id = $listing['id'];
		                        $listing_image = $this->users_model->get_listing_images($listing_id);
		                  	?>
		                  	<a data-toggle="modal" data-target="#viewimages">
			                  	<?php if($listing_image['image'] != ''): ?>
			                    	<img class="lazyload thumbnail-img" src="<?php echo base_url('/uploads/listing_images/'.$listing_image['listing_id'].'/'.$listing_image['id'].'/thumb_'.$listing_image['image']); ?>" data-src="<?php echo base_url('/uploads/listing_images/'.$listing_image['listing_id'].'/'.$listing_image['id'].'/thumb_'.$listing_image['image']); ?>" alt="<?php echo $listing['title']; ?> Listing Image">
			                  	<?php else: ?>
			                    	<img class="thumbnail-img" src="<?php echo base_url('/uploads/noimage.png'); ?>" alt="<?php echo $listing['title']; ?> Listing Image">
			                  	<?php endif; ?>
		                  	</a>
							
							<p class="view-images">
								<?php 
									$listing_id = $listing['id'];
			                        $listing_image_results = $this->users_model->get_listing_images_result_frontend($listing_id);
			                        $numberimages = count($listing_image_results);

			                        if($numberimages <= 1){
			                        	echo $numberimages.' Image';
			                        }else{
			                        	echo $numberimages.' Images';
			                        }
								?>	

								, <a data-toggle="modal" data-target="#viewimages"><i>View all</i></a>
							</p>

							<div class="modal fade" id="viewimages" role="dialog">
								<div class="modal-dialog modal-lg">
								  <div class="modal-content">
								    <div class="modal-header">
								      <button type="button" class="close" data-dismiss="modal">&times;</button>
								      <h4 class="modal-title"><i class="fa fa-file-image-o" aria-hidden="true"></i> <?php 
								      	if($numberimages <= 1){
				                        	echo 'Image';
				                        }else{
				                        	echo 'Images';
				                        }
								      ?></h4>
								    </div>
								    <div class="modal-body">
								    	<div class="modal-listing-body">
											<div class="owl-carousel owl-listingpage-carousel owl-theme">
												<?php if(!empty($listing_image_results)){ ?>
													<?php foreach($listing_image_results as $listingimage){ ?>
														<div class="item" data-hash="img<?php echo $listingimage['id']; ?>">
														<?php if($listingimage['image'] != ''){ ?>	

															<?php $this->users_model->user_daily_views('show',$listingimage['id'],'ListingImage'); ?>

														    <a href="<?php echo base_url('/uploads/listing_images/'.$listingimage['listing_id'].'/'.$listingimage['id'].'/big_'.$listingimage['image']); ?>" target="_blank"><img src="<?php echo base_url('/uploads/listing_images/'.$listingimage['listing_id'].'/'.$listingimage['id'].'/big_'.$listingimage['image']); ?>" alt="<?php echo $listing['title']; ?> Listing Image Big" class="listing-img"></a>

														<?php }else{ ?>
															<img src="<?php echo base_url('/uploads/noimage.png'); ?>" alt="<?php echo $listing['title']; ?> Listing Image Big" class="listing-img">
														<?php } ?>
														</div>
													<?php } ?>
												<?php }else{ ?>
													<img src="<?php echo base_url('/uploads/noimage.png'); ?>" alt="<?php echo $listing['title']; ?> Listing Image Big" class="listing-img">
												<?php } ?>
											</div>

											<hr>
											<?php if(!empty($listing_image_results)): ?>
												<?php foreach($listing_image_results as $listingimage){ ?>
													<?php if($listingimage['image'] != ''){ ?>	

											          <a href="#img<?php echo $listingimage['id']; ?>"><img src="<?php echo base_url('/uploads/listing_images/'.$listingimage['listing_id'].'/'.$listingimage['id'].'/thumb_small_'.$listingimage['image']); ?>" alt="<?php echo $listing['title']; ?> Listing Image Thumbnail" class="listing-img-thumbnail"></a> 

											      	<?php }else{ ?>
		
														<a href="#img<?php echo $listingimage['id']; ?>"><img src="<?php echo base_url('/uploads/thumb_small_noimage.png'); ?>" alt="<?php echo $listing['title']; ?> No Listing Image Thumbnail" class="listing-img-thumbnail"></a>

													<?php } ?>  

										        <?php } ?>

										    <?php else: ?>
		
												<a href="#img"><img src="<?php echo base_url('/uploads/noimage.png'); ?>" alt="<?php echo $listing['title']; ?> Listing Image Thumbnail" class="listing-img-thumbnail"></a>

											<?php endif; ?>  
									      
										</div>
								    </div>
								    <div class="modal-footer">
								      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
								    </div>
								  </div>
								</div>
							</div>


		                </div>
		                <div class="col-sm-8">
							<p>
								<div class="row">
							        <div class="col-xs-5">
							          <b>Location:</b>
							        </div>
							        <div class="col-xs-7">
							       		<?php
							       			if($users_id != ''){
												$latitude1 = $listing['latitude'];
												$longitude1 = $listing['longitude'];

												$address = strtr($userinfo['post_code'],' ','+');

												$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

												$output= json_decode($geocode);

												if($output->status != 'ZERO_RESULTS'){

													$latitude2 = $output->results[0]->geometry->location->lat;
                                					$longitude2 = $output->results[0]->geometry->location->lng;

												}else{

													$countries = $this->getdata_model->get_countries();
									                  	foreach($countries as $country):
									                        if($listing['country_id'] == $country['id']):
									                          $country_code =  $country['code'];
									                       	endif;
									                  	endforeach; 

													$country_address = strtr($country_code,' ','+');

													$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

													$output= json_decode($geocode);

													$latitude2 = $output->results[0]->geometry->location->lat;
                                					$longitude2 = $output->results[0]->geometry->location->lng;

												}

												echo $listing['region'].' '.(int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true). ' Miles from you';  
							       			}else{
							       				echo $listing['region'];
							       			}

										?>
							        </div>
							    </div>
						    </p>
						    <?php if($listing['listing_type'] != 'pup' && $listing['kennel_club_name'] != ''): ?>
						    <p>
								<div class="row">
									<div class="col-xs-5"><b>Kennel club name:</b></div>
									<div class="col-xs-7">
										<?php 
										echo $listing['kennel_club_name'];
										?>
									</div>
								</div>
							</p>
							<?php endif; ?>
						    <p>
							    <div class="row">
							        <div class="col-xs-5">
							          <b>Breed:</b>
							        </div>
							        <div class="col-xs-7">
							       		<?php 
			                              $breed_id = $listing['breed_id'];
			                              $getbreed = $this->getdata_model->get_breed_id($breed_id);

			                              echo $getbreed['name'];
			                            ?>
							        </div>
							    </div>
						    </p>
						    <p>
							    <div class="row">
							        <div class="col-xs-5">
							          <b>Date of Birth:</b>
							        </div>
							        <div class="col-xs-7">
							        	<?php $date_birth = date_create($listing['date_of_birth']);?>
							       		<?php echo date_format($date_birth,"d F Y"); ?>
							        </div>
							    </div>
						    </p>
						    <p>
							    <div class="row">
							        <div class="col-xs-5">
							          <b>Age:</b>
							        </div>
							        <div class="col-xs-7">
							       		<?php 
			                              $date1 = new DateTime($datenow);
			                              $date2 =  new DateTime($listing['date_of_birth']);
			                              $diff = $date1->diff($date2);

			                              echo $diff->y . " years, " . $diff->m." months, ".$diff->d." days "
			                            ?>
							        </div>
							    </div>
						    </p>
						    <p>
							    <div class="row">
							        <div class="col-xs-5">
							          <b>Date Listed:</b>
							        </div>
							        <div class="col-xs-7">
							       		<?php $date_listed = date_create($listing['created_at']);?>
							       		<?php echo date_format($date_listed,"d F Y"); ?>
							        </div>
							    </div>
						    </p>
						    <?php if($listing['listing_type'] != 'pup'): ?>
							    <p>
								    <div class="row">
								        <div class="col-xs-5">
								          <b>Gender:</b>
								        </div>
								        <div class="col-xs-7">
								       		<?php 
				                                if($listing['gender'] == 'm'){
				                                  echo 'Dog (male)';
				                                }else{
				                                  echo 'Bitch (female)';
				                                }
				                            ?>
								        </div>
								    </div>
							    </p>
							<?php endif; ?>
						    <p>
							    <div class="row">
							        <div class="col-xs-5">
							          <b>Pedigree:</b>
							        </div>
							        <div class="col-xs-7">
							       		<?php 
			                              if($listing['pedigree'] == 1){
			                                echo 'Yes';
			                              }else{
			                                echo 'No';
			                              }
			                            ?>
							        </div>
							    </div>
						    </p>
						    <?php
						    	$userinfo_listing = $this->users_model->get_users($listing['user_id']);
						    	if($userinfo_listing['website'] != '' && $userinfo_listing['plan_id'] == 7): 
						    ?>
							    <p>
								    <div class="row">
								        <div class="col-xs-5">
								          <b>Breeder's Website:</b>
								        </div>
								        <div class="col-xs-7">
								       		<?php 
				                               echo '<a href="http://'.$userinfo_listing['website'].'">'.$userinfo_listing['website'].'</a>'
				                            ?>
								        </div>
								    </div>
							    </p>
							<?php endif; ?>
		               	</div>
		               	<div class="col-sm-12">
		               	<br>
							<p><b>Details:</b></p>
							<p><?php echo $listing['description']; ?></p>
		               	</div>
		            </div>
				</div>
			</div>
			<div class="col-md-3 col-lg-3">
			<?php if($listing['listing_type'] != 'mem'): ?>

				<div class="listing-page-contact">
					<p>Options</p>
					<a <?php 
						if($country_lang == 'us'){
                          echo 'href="'.base_url('us/listings/'.$listing['id'].'/connections/new').'"';
                        }else{
                          echo 'href="'.base_url('listings/'.$listing['id'].'/connections/new').'"';
                        }
					?> class="button"><i class="fa fa-exchange" aria-hidden="true"></i>  Contact Owner</a>
				</div>
				<div class="listing-page-map">
					<div id="googleMap" style="width:100%;height:200px;"></div>
				</div>

			<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script>
function myMap() {
var mapProp= {
    center:new google.maps.LatLng(<?php echo $listing['latitude'];?>,<?php echo $listing['longitude'];?>),
    zoom:5,
};
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMHEujoDfANtSifMphdiF4S73K6urtgSY&callback=myMap"></script>