<?php 
	$users_id_session = $this->session->userdata('user_id_byd');
	$id = $users_id_session;
	$info = $this->users_model->checkinfo($id);
	date_default_timezone_set("Europe/London");
	$datenow = date('Y-m-d');

	$country_code = $info['post_code'];

	if($this->input->get('country_id', TRUE) != ''){
		$countries = $this->getdata_model->get_countries();
		foreach($countries as $country):
		  if($this->input->get('country_id', TRUE) == $country['id']){
		   $country_code =  $country['code'];
		  }
		endforeach; 
	}

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

<?php
	$latitude2 = NULL;
	$longitude2 = NULL;

	if($this->input->get('post_code', TRUE) != '' || $info['post_code'] != ''){

		if($this->input->get('post_code', TRUE) != ''){
			$address = strtr($this->input->get('post_code', TRUE),' ','+');
		}else{
			$address = strtr($info['post_code'],' ','+');
		}

		$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

		$output= json_decode($geocode);
	
		if($output->status != 'ZERO_RESULTS'){

			$latitude2 = $output->results[0]->geometry->location->lat;
			$longitude2 = $output->results[0]->geometry->location->lng;

		}else{

			$countries = $this->getdata_model->get_countries();
				foreach($countries as $country):
				  if($info['country_id'] == $country['id']):
				    $country_code =  $country['code'];
				  endif;
				endforeach; 

			$country_address = strtr($country_code,' ','+');

			$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

			$output= json_decode($geocode);

			$latitude2 = $output->results[0]->geometry->location->lat;
			$longitude2 = $output->results[0]->geometry->location->lng;

		}
	
	}elseif($this->input->get('country_id', TRUE) != '' || $this->input->get('country_id', TRUE) != 'all' || $info['country_id'] != ''){

		if($this->input->get('country_id', TRUE) != '' && $this->input->get('country_id', TRUE) != 'all'){

			$countries = $this->getdata_model->get_countries();
				foreach($countries as $country):
				  if($this->input->get('country_id', TRUE) == $country['id']):
				    $country_code =  $country['code'];
				  endif;
				endforeach; 

			$country_address = strtr($country_code,' ','+');

			$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

			$output= json_decode($geocode);

			$latitude2 = $output->results[0]->geometry->location->lat;
			$longitude2 = $output->results[0]->geometry->location->lng;

		}elseif($this->input->get('country_id', TRUE) != 'all' && $this->input->get('country_id', TRUE) != ''){

			$countries = $this->getdata_model->get_countries();
				foreach($countries as $country):
				  if($info['country_id'] == $country['id']):
				    $country_code =  $country['code'];
				  endif;
				endforeach; 

			$country_address = strtr($country_code,' ','+');

			$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

			$output= json_decode($geocode);

			$latitude2 = $output->results[0]->geometry->location->lat;
			$longitude2 = $output->results[0]->geometry->location->lng;

		}

	}
?>

<div class="page-listing-container">
	<div class="header-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="page-listing-header">
						<h1>Search for Puppies</h1>
						<?php echo form_open('', array( 'method' => 'get', 'id' => 'form-puppies' )); ?>
							<select name="breed_id">
								<option value="all">All Breeds</option>
								<?php 
								$breeds = $this->getdata_model->get_breeds();
								foreach($breeds as $breed): 
								?>  
									<option value="<?php echo $breed['id']; ?>" <?php
										if($this->input->get('breed_id', TRUE) == $breed['id']){
											echo 'selected';
										}
									?>><?php echo $breed['name']; ?></option>
								<?php endforeach; ?>
							</select>
							<select name="country_id">
								<option value="all">Any Country</option>
								<?php $countries = $this->getdata_model->get_countries(); ?>
			                    <?php foreach($countries as $country): ?>
			                      	<option value="<?php echo $country['id']; ?>" <?php
			                      		if($this->input->get('country_id', TRUE) != ''){
			                      			if($this->input->get('country_id', TRUE) == $country['id']){
												echo 'selected';
											}
			                      		}else{
			                      			if($info['country_id'] == $country['id']){
												echo 'selected';
											}
			                      		}
			                      	?>><?php echo $country['name']; ?></option>
			                    <?php endforeach; ?>
							</select>
							<select name="gender">
								<option value="all" <?php if($this->input->get('gender', TRUE) == 'all'){echo 'selected'; } ?>>Any Gender</option>
								<option value="m" <?php if($this->input->get('gender', TRUE) == 'm'){echo 'selected'; } ?>>Dog (Male)</option>
	                			<option value="f" <?php if($this->input->get('gender', TRUE) == 'f'){echo 'selected'; } ?>>Bitch (Female)</option>
							</select>
							<input type="text" name="post_code" placeholder="Postcode" value="<?php

							if($this->input->get('post_code', TRUE) != ''){
								echo $this->input->get('post_code', TRUE);
							}else{
								echo $info['post_code'];
							}

							?>">
							<input type="text" name="keywords" placeholder="Keywords" value="<?php echo $this->input->get('keywords', TRUE); ?>">
							<select name="distance">
								<option value="all" <?php if($this->input->get('distance', TRUE) == 'all'){echo 'selected'; } ?>>Any Distance</option>
								<option value="5" <?php if($this->input->get('distance', TRUE) == '5'){echo 'selected'; } ?>>5 Miles</option>
								<option value="10" <?php if($this->input->get('distance', TRUE) == '10'){echo 'selected'; } ?>>10 Miles</option>
								<option value="25" <?php if($this->input->get('distance', TRUE) == '25'){echo 'selected'; } ?>>25 Miles</option>
								<option value="50" <?php if($this->input->get('distance', TRUE) == '50'){echo 'selected'; } ?>>50 Miles</option>
								<option value="100" <?php if($this->input->get('distance', TRUE) == '100'){echo 'selected'; } ?>>100 Miles</option>
								<option value="200" <?php if($this->input->get('distance', TRUE) == '200'){echo 'selected'; } ?>>200 Miles</option>
							</select>
								<button type="submit">Search</button>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" name="pedigree_only" <?php if($this->input->get('pedigree_only', TRUE) == 'on'){echo 'Checked'; } ?>> Pedigrees only</label>
						</div>
						<input id="search-sort-stud-dogs" type="hidden" name="sort_by" value="<?php 
							if(!empty($this->input->get('sort_by', TRUE))){
								echo $this->input->get('sort_by', TRUE);
							}else{
								echo 'newest';
							}
						?>">
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="page-listing-body-container">
					<div class="page-listing-body">
						<div class="row">
							<div class="col-sm-6">
							<?php if($this->pages_model->count_puppies($country_code, $breed_info['id'],$latitude2,$longitude2) == ''){

								echo 'No entries found';

							}elseif($this->pages_model->count_puppies($country_code, $breed_info['id'],$latitude2,$longitude2) <= 25){ 

								echo 'Displaying all '.$this->pages_model->count_puppies($country_code, $breed_info['id'],$latitude2,$longitude2);
								if($this->pages_model->count_puppies($country_code, $breed_info['id'],$latitude2,$longitude2) == 1){
									echo ' listing';
								}else{
									echo ' listings';
								}

							}else{ ?>

								<p>Displaying listings <?php

									if($this->input->get('page', TRUE) == ''){
										echo '1';
									}else{
										$page_num = $this->input->get('page', TRUE);
										$num =  1+(25*($page_num - 1));
										echo $num;
									}

								?>
								 - <?php
									if($this->input->get('page', TRUE) == ''){
										echo '25';
									}else{
								 		$page_num = $this->input->get('page', TRUE);
									 	$count_pup = count($puppies);
									 	$sum1 = 25*$page_num;
									 	$sum2 = 25-$count_pup;
									 	$num2 = $sum1 - $sum2;
									 	echo $num2;
									}

								?> of <?php echo $this->pages_model->count_puppies($country_code, $breed_info['id'],$latitude2,$longitude2); ?> in total</p>
							<?php } ?>
							</div>
							<div class="col-sm-6">
								<div class="text-right">
									<select id="sort-puppies" name="sort_by">
					                	<option value="newest" selected="" <?php if($this->input->get('sort_by', TRUE) == 'newest'){echo 'selected'; } ?>> Show Newest First</option>
					                    <option value="closest" <?php if($this->input->get('sort_by', TRUE) == 'closest'){echo 'selected'; } ?>> Show Closest First</option>
					                </select>
					            </div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-12">
								<?php foreach($puppies as $pup): ?>
									<div class="listing-container<?php

										$users_id = $pup['user_id'];
										$userinfo = $this->users_model->get_users($users_id);

										if($userinfo['plan_id'] == 7){
										echo ' ultimate-listing';
										}

										if($pup['featured'] == 1 && $pup['featured_until'] >= $datenow && $pup['highlight'] == 1 && $pup['highlight_until'] >= $datenow){

											echo ' featured-and-highlighted';

										}elseif($pup['featured'] == 1 && $pup['featured_until'] >= $datenow){

											echo ' featured';

										}elseif($pup['highlight'] == 1 && $pup['highlight_until'] >= $datenow || $userinfo['plan_id'] == 7 || $userinfo['plan_id'] == 6){

											echo ' highlighted';

										}
						          
						            ?>"> 

						            	<?php if($userinfo['plan_id'] == 1 || $userinfo['plan_id'] == 5){ ?>
		
											<?php
												if($pup['featured'] == 1 && $pup['featured_until'] >= $datenow && $pup['highlight'] == 1 && $pup['highlight_until'] >= $datenow){
											?>

												<img src="<?php echo base_url('assets/img/featured-highlighted.png'); ?>" class="listing-all-banner" alt="Featured and Highlighted Listing Banner">                

											<?php  
												}elseif($pup['featured'] == 1 && $pup['featured_until'] >= $datenow){
											?>

											  <img src="<?php echo base_url('assets/img/featured.png'); ?>" class="listing-banner" alt="Featured Listing Banner">

											<?php
												}elseif($pup['highlight'] == 1 && $pup['highlight_until'] >= $datenow){
											?>

											  <img src="<?php echo base_url('assets/img/highlighted.png'); ?>" class="listing-banner" alt="Highlighted Listing Banner">

											<?php
												}
											?>

										<?php }else{ ?>

											<?php
												if($pup['featured'] == 1 && $pup['featured_until'] >= $datenow){
											?>

												<img src="<?php echo base_url('assets/img/featured-highlighted.png'); ?>" class="listing-all-banner" alt="Featured and Highlighted Listing Banner">                

											<?php  
												}elseif($pup['highlight'] == 1){
											?>

												<img src="<?php echo base_url('assets/img/highlighted.png'); ?>" class="listing-banner" alt="Highlighted Listing Banner">

											<?php
												}
											?>

										<?php } ?>

									  <div class="row"> 
									    <div class="col-sm-11"> 
									      <h3><a <?php
					                        if($country_lang == 'us'){
					                          echo 'href="'.base_url('us/');
					                        }else{
					                          echo 'href="'.base_url();
					                        }
					                        if($pup['listing_type'] == 'dog'){
					                          echo 'stud-dogs';
					                        }elseif($pup['listing_type'] == 'pup'){
					                          echo 'puppies';
					                        }elseif($pup['listing_type'] == 'mem'){
					                          echo 'memorials';
					                        }

					                        $slug_title = url_title($pup['title'], 'dash', TRUE);

					                        echo '/'.$pup['id'].'/'.$slug_title;

					                        if($country_lang == 'us'){
					                          echo '"';
					                        }else{
					                          echo '"';
					                        }

					                      ?>><?php echo $pup['title']; ?></a></h3>
									    </div>
									    <div class="col-sm-4">
									    	<?php 
						                        $listing_id = $pup['id'];
						                        $listing_image = $this->users_model->get_listing_images($listing_id);
					                      	?>
					                      	<?php if($listing_image['image'] != ''): ?>
					                        	<img class="lazyload" src="<?php echo base_url('/uploads/listing_images/'.$listing_image['listing_id'].'/'.$listing_image['id'].'/thumb_'.$listing_image['image']); ?>" data-src="<?php echo base_url('/uploads/listing_images/'.$listing_image['listing_id'].'/'.$listing_image['id'].'/thumb_'.$listing_image['image']); ?>" alt="<?php echo $pup['title']; ?> Listing Image">
					                      	<?php else: ?>
					                        	<img src="<?php echo base_url('/uploads/noimage.png'); ?>" alt="<?php echo $pup['title']; ?> Listing Image">
					                      	<?php endif; ?>
									    </div>
									    <div class="col-sm-8">
									      <div class="listing-contents">
										      <div class="row">
										        <div class="col-xs-4">
										          <b>Location:</b>
										        </div>
										        <div class="col-xs-7">
										       		<?php
														$latitude1 = $pup['latitude'];
														$longitude1 = $pup['longitude'];

														if($this->input->get('post_code', TRUE) != '' || $info['post_code'] != ''){

															echo $pup['region'].' '.(int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true). ' Miles from you';
														
														}elseif($this->input->get('country_id', TRUE) != '' || $this->input->get('country_id', TRUE) != 'all' || $info['country_id'] != ''){

															if($this->input->get('country_id', TRUE) != '' && $this->input->get('country_id', TRUE) != 'all'){
															
																echo $pup['region'].' '.(int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true). ' Miles from you';

															}elseif($this->input->get('country_id', TRUE) != 'all' && $this->input->get('country_id', TRUE) != ''){

																echo $pup['region'].' '.(int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true). ' Miles from you';

															}else{
																echo $pup['region'];
															}

														}else{
															echo $pup['region'];
														}
													?>
										        </div>
										      </div>
										      
										      <div class="row">
										        <div class="col-xs-4"><b>Breed:</b></div>
											        <div class="col-xs-8">
											          <?php 
							                            $breed_id = $pup['breed_id'];
							                            $getbreed = $this->getdata_model->get_breed_id($breed_id);

							                            echo $getbreed['name'];
							                          ?>
											    </div>
										      </div>

											   	<div class="row">
											        <div class="col-xs-4">
											          <b>Age:</b>
											        </div>
											        <div class="col-xs-8">
											          <?php 
							                            $date1 = new DateTime($datenow);
							                            $date2 =  new DateTime($pup['date_of_birth']);
							                            $diff = $date1->diff($date2);

							                            echo $diff->y . " years, " . $diff->m." months, ".$diff->d." days "
							                          ?>
											        </div>
											    </div>

												<div class="row">
													<div class="col-xs-4"><b>Pedigree:</b></div>
													<div class="col-xs-8">
														<?php 
													    if($pup['pedigree'] == 1){
													      echo 'Yes';
													    }else{
													      echo 'No';
													    }
													?>
													</div>
												</div>
											  
										      	<p class="listing-description">
										       		<?php echo word_limiter($pup['description'], 25); ?>
										      	</p>
												<div class="listing-bottons">
													<?php if($this->session->userdata('userlogged_in') && $users_id_session == $pup['user_id']): ?>
													<a <?php
														if($country_lang == 'us'){
								                          echo 'href="'.base_url('us/listings/'.$pup['id'].'/edit').'"';
								                        }else{
								                          echo 'href="'.base_url('listings/'.$pup['id'].'/edit').'"';
								                        }
													?> type="button" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
													<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#listing-modal-<?php echo $pup['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
													<?php endif; ?>
													<a <?php
													if($country_lang == 'us'){
							                          echo 'href="'.base_url('us/');
							                        }else{
							                          echo 'href="'.base_url();
							                        }
													if($pup['listing_type'] == 'dog'){
													echo 'stud-dogs';
													}elseif($pup['listing_type'] == 'pup'){
													echo 'puppies';
													}elseif($pup['listing_type'] == 'mem'){
													echo 'memorials';
													}

													$slug_title = url_title($pup['title'], 'dash', TRUE);

													echo '/'.$pup['id'].'/'.$slug_title;

													if($country_lang == 'us'){
							                          echo '"';
							                        }else{
							                          echo '"';
							                        }

													?> type="button" class="btn btn-success">Read More</a>
												</div>
										    </div>
										</div>
									  </div>
									  <br>
									 
									</div>
	
									<div class="modal fade" id="listing-modal-<?php echo $pup['id']; ?>" role="dialog">
						                <div class="modal-dialog">
						                  <div class="modal-content">
						                    <div class="modal-header">
						                      <button type="button" class="close" data-dismiss="modal">&times;</button>
						                      <h4 class="modal-title">Delete Listing</h4>
						                    </div>
						                    <div class="modal-body">
						                      <p style="text-align: center;">Are you sure you want to permanently delete this listing ?</p>
						                    </div>
						                    <div class="modal-footer">
						                    <?php echo form_open('/users/listing_delete/'.$pup['id']); ?>

						                      <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>
						                      <button type="submit" class="btn btn-danger"> Delete Listing</button>
						                    
						                    <?php echo form_close(); ?>
						                    </div>
						                  </div>
						                </div>
						              </div>
						          
								<?php endforeach; ?>
								
								<?php if($this->pagination->create_links() != ''){ ?>
									<div class="pagination-links">
										<?php echo $this->pagination->create_links(); ?>
									</div>
								<?php } ?>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-lg-3">
				<?php 
			       $this->load->view('templates/sidebar');
			    ?>
			</div>
		</div>
	</div>
</div>