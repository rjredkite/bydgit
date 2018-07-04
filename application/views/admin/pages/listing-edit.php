<?php 
	date_default_timezone_set("Europe/London");

	if($listing['listing_type'] == 'dog'){
		$listing_type = 'stud-dogs';
	}elseif($listing['listing_type'] == 'pup'){
		$listing_type = 'puppies';
	}else{
		$listing_type = 'memorials';
	}

	$slug_title = url_title($listing['title'], 'dash', TRUE);

?>
<div class="body-container">
	<div class="edit-container">
		<h1><?php
			if($listing['listing_type'] == 'dog'){
				echo 'Update Stud Dog / Bitch';
			}elseif($listing['listing_type'] == 'pup'){
				echo 'Update Litter';
			}elseif($listing['listing_type'] == 'mem'){
				echo 'Update Memorial';
			}
		?></h1>
		<hr>
		<?php echo form_open_multipart(''); ?>
			<div class="row">
				<div class="col-md-8">
					<div class="row space">
						<div class="col-sm-3">
							<label  for="listing-title">Listing Title *</label>
						</div>
						<div class="col-sm-9">
							<input id="listing-title" class="textbox" type="text" name="title" value="<?php echo $listing['title']; ?>" required>
						</div>
					</div>

					<?php if($listing['listing_type'] != 'pup'): ?>
						<div class="row space">
							<div class="col-sm-3">
								<label  for="listing-dog-name">Dog Name *</label>
							</div>
							<div class="col-sm-9">
								<input id="listing-dog-name" class="textbox" type="text" name="name" value="<?php echo $listing['name']; ?>" required>
							</div>
						</div>
						<div class="row space">
							<div class="col-sm-3">
								<label  for="listing-gender">Gender *</label>
							</div>
							<div class="col-sm-9">
								<select id="listing-gender" name="gender" required>
								<option value=""> - Please Choose - </option>
								<option value="m" <?php if($listing['gender'] == 'm'){ echo 'selected';} ?>>Dog</option>
								<option value="f" <?php if($listing['gender'] == 'f'){ echo 'selected';} ?>>Bitch</option>
							</select>
							</div>
						</div>
						<div class="row space">
							<div class="col-sm-3">
								<label  for="listing-kennel-club-name">Kennel Club Name</label>
							</div>
							<div class="col-sm-9">
								<input id="listing-kennel-club-name" class="textbox" type="text" name="kennel_club_name" value="<?php echo $listing['kennel_club_name']; ?>">
							</div>
						</div>
					<?php endif; ?>
					
					<div class="row space">
						<div class="col-sm-3">
							<label  for="listing-breed">Breed *</label>
						</div>
						<div class="col-sm-9">
							<select id="listing-breed" name="breed_id" required>
							<option value=""> - Please Choose - </option>
							<?php foreach($breeds as $breed): ?>
								<option value="<?php echo $breed['id']; ?>" <?php
		                      		if($listing['breed_id']){
		                      			if($listing['breed_id'] == $breed['id']){
											echo 'selected';
										}
		                      		}
		                      	?>><?php echo $breed['name']; ?></option>
							<?php endforeach; ?>
						</select>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="listing-date-of-birth">Date of Birth *</label>
						</div>
						<div class="col-sm-9">
							<div class="date-calendar">
								<div class="input-group">
									<input type="text" id="listing-date-of-birth" class="datepicker" data-date-format="yyyy-mm-dd" name="date_of_birth" placeholder="yyyy-mm-dd" value="<?php echo $listing['date_of_birth']; ?>" required>
									<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="listing-country">Country *</label>
						</div>
						<div class="col-sm-9">
							<select id="listing-country" name="country_id" required>
							<option value=""> - Please Choose - </option>
							<?php foreach($countries as $country): ?>
								<option value="<?php echo $country['id']; ?>" <?php
		                      		if($listing['country_id']){
		                      			if($listing['country_id'] == $country['id']){
											echo 'selected';
										}
		                      		}
		                      	?>><?php echo $country['name']; ?></option>
							<?php endforeach; ?>
						</select>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="listing-region">Region *</label>
						</div>
						<div class="col-sm-9">
							<input id="listing-region" class="textbox" type="text" name="region" value="<?php echo $listing['region']; ?>" required>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="listing-post-code">Post / Zip Code *</label>
						</div>
						<div class="col-sm-9">
							<input id="listing-post-code" class="textbox" type="text" name="post_code" value="<?php echo $listing['post_code']; ?>" required>
						</div>
					</div>
					<div class="radio-inputs">
						<div class="row space">
							<div class="col-sm-3">
								<label>Pedigree</label>
							</div>
							<div class="col-sm-9">
								<label class="radio-inline">
							      <input type="radio" name="pedigree" value="0" <?php if($listing['pedigree'] == '0'){ echo 'checked';} ?>>No
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="pedigree" value="1" <?php if($listing['pedigree'] == '1'){ echo 'checked';} ?>>Yes 
							    </label>
							</div>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label>Published ?</label>
						</div>
						<div class="col-sm-9">
							<label class="radio-inline">
						      <input type="radio" name="published" value="0" <?php if($listing['published'] == '0'){ echo 'checked';} ?>>No
						    </label>
						    <label class="radio-inline">
						      <input type="radio" name="published" value="1" <?php if($listing['published'] == '1'){ echo 'checked';} ?>>Yes 
						    </label>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label>Featured ?</label>
						</div>
						<div class="col-sm-9">
							<label class="radio-inline">
						      <input type="radio" name="featured" value="0" <?php if($listing['featured'] == '0'){ echo 'checked';} ?>>No
						    </label>
						    <label class="radio-inline">
						      <input type="radio" name="featured" value="1" <?php if($listing['featured'] == '1'){ echo 'checked';} ?>>Yes 
						    </label>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label for="listing-featured-until">Featured Until</label>
						</div>
						<div class="col-sm-9">
							<div class="date-calendar">
								<div class="input-group">
									<input type="text" id="listing-featured-until" class="datepicker" data-date-format="yyyy-mm-dd" name="featured_until" placeholder="yyyy-mm-dd" value="<?php echo $listing['featured_until']; ?>">
									<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label>Highlighted</label>
						</div>
						<div class="col-sm-9">
							<label class="radio-inline">
						      <input type="radio" name="highlight" value="0" <?php if($listing['highlight'] == '0'){ echo 'checked';} ?>>No
						    </label>
						    <label class="radio-inline">
						      <input type="radio" name="highlight" value="1" <?php if($listing['highlight'] == '1'){ echo 'checked';} ?>>Yes 
						    </label>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label for="listing-highlighted-until">Highlighted Until</label>
						</div>
						<div class="col-sm-9">
							<div class="date-calendar">
								<div class="input-group">
									<input type="text" id="listing-highlighted-until" class="datepicker" data-date-format="yyyy-mm-dd" name="highlight_until" placeholder="yyyy-mm-dd" value="<?php echo $listing['highlight_until']; ?>">
									<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label>On Homepage</label>
						</div>
						<div class="col-sm-9">
							<label class="radio-inline">
						      <input type="radio" name="on_homepage" value="0" <?php if($listing['on_homepage'] == '0'){ echo 'checked';} ?>>No
						    </label>
						    <label class="radio-inline">
						      <input type="radio" name="on_homepage" value="1" <?php if($listing['on_homepage'] == '1'){ echo 'checked';} ?>>Yes 
						    </label>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label for="listing-on-homepage-until">On Homepage Until</label>
						</div>
						<div class="col-sm-9">
							<div class="date-calendar">
								<div class="input-group">
									<input type="text" id="listing-on-homepage-until" class="datepicker" data-date-format="yyyy-mm-dd" name="on_homepage_until" placeholder="yyyy-mm-dd" value="<?php echo $listing['on_homepage_until']; ?>">
									<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<br>
					<h4 class="text-left">Additional Details</h4>
					<div class="row">
						<div class="col-sm-6">
							<p class="text-right">Owner</p>
						</div>
						<div class="col-sm-6">
							<?php if($user['email'] != ''){ ?>
								<a href="<?php echo base_url('admin/users/'.$listing['user_id'].'/edit'); ?>"><?php echo $user['email']; ?></a>
							<?php }else{ ?>
								Account Close
							<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<p class="text-right">Date Listed</p>
						</div>
						<div class="col-sm-6">
							<p><?php echo $listing['created_at']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<p class="text-right">View Listing</p>
						</div>
						<div class="col-sm-6">
							<a href="<?php echo base_url($listing_type.'/'.$listing['id'].'/'.$slug_title)?>">Click here to view</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<p class="text-right">Views <?php echo date("F Y"); ?></p>
						</div>
						<div class="col-sm-6">
							<a href="<?php echo base_url('admin/listings/'.$listing['id'].'/statistics')?>">Click here to view</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<?php 
				              $listing_imgs = $this->users_model->get_listing_images_result($listing['id']);
				            ?>
				            <?php foreach($listing_imgs as $list_img): ?>  
				            
				   
				                <?php if($list_img['image'] != ''): ?>
				                    <div class="row">
				                      <div class="col-xs-12">
				                      	<a href="<?php echo base_url('uploads/listing_images/'.$list_img['listing_id'].'/'.$list_img['id'].'/'.$list_img['image']); ?>" target="_blank">
				                      		<div class="listing-image">
						                        <img class="img-responsive" src="<?php echo base_url('uploads/listing_images/'.$list_img['listing_id'].'/'.$list_img['id'].'/'.$list_img['image']); ?>">
						                        <label class="float-none">
						                        <input type="checkbox" name="checkbox_remove[]" value="<?php echo $list_img['id']; ?>">
						                          	Remove this image
						                        </label>
						                    </div>
				                        </a>
				                      </div>
				                    </div>
				                <?php endif; ?>
				              
				            <?php endforeach; ?>

						</div>
					
						<div class="col-sm-12">
						<hr>
							<p>New Image</p>
							<input class="upload_images" type="file" name="upload_images[]">
						</div>

					</div>
				</div>
				<div class="col-md-12">
					<div class="row space">
						<div class="col-sm-2">
							<label  for="listing-description">Description</label>
						</div>
						<div class="col-sm-10">
							<textarea id="listing-description" name="description" rows="7" cols="50"><?php echo $listing['description']; ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<button type="submit" class="bnt button-primary">Save Changes</button>
			<a href="<?php echo base_url('admin/listings/search'); ?>" type="button" class="btn button-cancel">Cancel</a>
			<?php if($listing['deleted_at'] == NULL || $listing['deleted_at'] == '0000-00-00 00:00:00'){
				echo '<a class="btn button-delete" data-toggle="modal" data-target="#deletelisting">Delete Listing</a>';
			}else{
				echo '<a class="btn button-normal" data-toggle="modal" data-target="#undeletelisting">Un-Delete Listing</a>';
			}?>
		<?php echo form_close(); ?>

		<div id="deletelisting" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
				<?php echo form_open('/admin/listing_delete/'.$user['id']); ?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Delete Listing</h4>
					</div>
					<div class="modal-body">
						<p class="text-center">
							Are you sure you want to Delete this Listing ?
						</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-danger">Delete Listing</button>
					</div>
				<?php echo form_close(); ?>
				</div>
			</div>
		</div>

		<div id="undeletelisting" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
				<?php echo form_open('/admin/listing_un_delete/'.$user['id']); ?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Un Delete Listing</h4>
					</div>
					<div class="modal-body">
						<p class="text-center">
							Are you sure you want to Un delete this Listing ?
						</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-default">Un Delete Listing</button>
					</div>
				<?php echo form_close(); ?>
				</div>
			</div>
		</div>

	</div>	
</div>