<?php
	$countries = $this->getdata_model->get_countries(); 
	$breeds = $this->getdata_model->get_breeds();
?>
<div class="body-container">
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
    <?php if($this->session->flashdata('flashdata_success')) : ?>
		<?php echo '
		  <div class="alert alert-success alert-dismissable fade in">
		    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
		    .$this->session->flashdata('flashdata_success').
		'</div>'
		; ?>
    <?php endif; ?>
	<div class="search-container">
		<h1>Search Listings</h1>
		<hr>
		<button id="admin-search-button" class="search-fields-button" data-toggle="popovers" data-placement="right" title="Toggle Search Fields" data-content='Click this button to hide or show the search fields.' data-trigger="hover"><i class="fa fa-bars" aria-hidden="true"></i> Toggle Search fields</button> 
		<div class="admin-search-fields">
			<hr>
			<?php echo form_open('',array( 'method' => 'get')); ?>
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="textbox" name="id" placeholder="Listing ID" value="<?php echo $this->input->get('id', TRUE); ?>">
						<input type="text" class="textbox" name="keywords" placeholder="keywords" value="<?php echo  $this->input->get('keywords', TRUE); ?>">
						<select name="breed_id">
							<option value="all">Any Breed</option>
							<?php foreach($breeds as $breed): ?>
								<option value="<?php echo $breed['id']; ?>" <?php
		                      		if($this->input->get('breed_id', TRUE)){
		                      			if($this->input->get('breed_id', TRUE) == $breed['id']){
											echo 'selected';
										}
		                      		}
		                      	?>><?php echo $breed['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<select name="country_id">
							<option value="all">Any Country</option>
							<?php foreach($countries as $country): ?>
								<option value="<?php echo $country['id']; ?>" <?php
		                      		if($this->input->get('country_id', TRUE)){
		                      			if($this->input->get('country_id', TRUE) == $country['id']){
											echo 'selected';
										}
		                      		}
		                      	?>><?php echo $country['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<input type="text" class="textbox" name="post_code" placeholder="Zip/Postcode" value="<?php echo  $this->input->get('post_code', TRUE); ?>">
						<div class="date-calendar">
							<div class="input-group">
								<input type="text" class="datepicker" data-date-format="mm/dd/yyyy" name="date_listed_after" placeholder="Listed After" value="<?php echo  $this->input->get('date_listed_after', TRUE); ?>">
								<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="date-calendar">
							<div class="input-group">
								<input type="text" class="datepicker" data-date-format="mm/dd/yyyy" name="date_listed_before"  placeholder="Listed Before" value="<?php echo  $this->input->get('date_listed_before', TRUE); ?>">
								<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<select name="listing_type">
							<option value="all" <?php if($this->input->get('listing_type', TRUE) == 'all'){ echo 'selected';} ?>>Any Listings</option>
							<option value="dog" <?php if($this->input->get('listing_type', TRUE) == 'dog'){ echo 'selected';} ?>>Stud Dogs / Bitches</option>
							<option value="pup" <?php if($this->input->get('listing_type', TRUE) == 'pup'){ echo 'selected';} ?>>Litters</option>
							<option value="mem" <?php if($this->input->get('listing_type', TRUE) == 'mem'){ echo 'selected';} ?>>Memorials</option>
						</select>
						<select name="gender">
							<option value="all" <?php if($this->input->get('gender', TRUE) == 'all'){ echo 'selected';} ?>>Any Gender</option>
							<option value="m" <?php if($this->input->get('gender', TRUE) == 'm'){ echo 'selected';} ?>>Dog</option>
							<option value="f" <?php if($this->input->get('gender', TRUE) == 'f'){ echo 'selected';} ?>>Bitch</option>
						</select>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-4">
									<span>Pedigree</span>
								</div>
								<div class="col-sm-8">
									<label class="radio-inline">
								    	<input type="radio" name="pedigree" value="all" <?php if($this->input->get('pedigree', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="pedigree" value="1" <?php if($this->input->get('pedigree', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="pedigree" value="0" <?php if($this->input->get('pedigree', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-4">
									<span>Published</span>
								</div>
								<div class="col-sm-8">
									<label class="radio-inline">
								    	<input type="radio" name="published" value="all" <?php if($this->input->get('published', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="published" value="1" <?php if($this->input->get('published', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="published" value="0" <?php if($this->input->get('published', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-4">
									<span>Featured</span>
								</div>
								<div class="col-sm-8">
									<label class="radio-inline">
								    	<input type="radio" name="featured" value="all" <?php if($this->input->get('featured', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="featured" value="1" <?php if($this->input->get('featured', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="featured" value="0" <?php if($this->input->get('featured', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-4">
									<span>Highlighted</span>
								</div>
								<div class="col-sm-8">
									<label class="radio-inline">
								    	<input type="radio" name="highlight" value="all" <?php if($this->input->get('highlight', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="highlight" value="1" <?php if($this->input->get('highlight', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="highlight" value="0" <?php if($this->input->get('highlight', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-4">
									<span>On Homepage</span>
								</div>
								<div class="col-sm-8">
									<label class="radio-inline">
								    	<input type="radio" name="on_homepage" value="all" <?php if($this->input->get('on_homepage', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="on_homepage" value="1" <?php if($this->input->get('on_homepage', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="on_homepage" value="0" <?php if($this->input->get('on_homepage', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-4">
									<span>Deleted</span>
								</div>
								<div class="col-sm-8">
									<label class="radio-inline">
								    	<input type="radio" name="deleted" value="all" <?php if($this->input->get('deleted', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="deleted" value="1" <?php if($this->input->get('deleted', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="deleted" value="0" <?php if($this->input->get('deleted', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<hr>
				<button type="submit" class="btn button-primary">Search</button>
				<a href="<?php echo base_url('admin/images/search'); ?>" class="btn button-cancel">Cancel</a>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<?php if(
	$this->input->get('keywords', TRUE) != '' || 
	$this->input->get('id', TRUE) != '' || 
	$this->input->get('breed_id', TRUE) != '' || 
	$this->input->get('country_id', TRUE) != '' || 
	$this->input->get('post_code', TRUE) != '' || 
	$this->input->get('phone', TRUE) != '' || 
	$this->input->get('date_listed_after', TRUE) != '' || 
	$this->input->get('date_listed_before', TRUE) != '' || 
	$this->input->get('listing_type', TRUE) != '' || 
	$this->input->get('gender', TRUE) != '' || 
	$this->input->get('pedigree', TRUE) != '' || 
	$this->input->get('published', TRUE) != '' || 
	$this->input->get('featured', TRUE) != '' || 
	$this->input->get('highlight', TRUE) != '' || 
	$this->input->get('on_homepage', TRUE) != '' || 
	$this->input->get('deleted', TRUE) != '' || 
	$this->input->get('user_id', TRUE)
){ ?>

<?php if(!empty($images)): ?>

<div class="body-container">
	<div class="images-contianer">
		<h1>All Images</h1>
		<br>
		<?php if($this->pagination->create_links() != ''){ ?>
			<div class="pagination-links text-center">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		<?php } ?>

		<div class="row">
			<?php $ajaximages = 1; ?>
			<?php foreach($images as $image): ?>
				<?php $list = $this->getdata_model->get_user_listing_row($image['listing_id']); ?>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="image-collumn">
						<a href="<?php echo base_url('admin/listings/'.$image['listing_id'].'/edit'); ?>">
							<div class="image-border">
								<img id="image-replace<?php echo $ajaximages; ?>"  src="<?php echo base_url('uploads/listing_images/'.$image['listing_id'].'/'.$image['id'].'/thumb_small_'.$image['image'].'?'.uniqid()); ?>">
								<?php if($image['on_homepage'] != 1){ ?>
									<p class="not"><i class="fa fa-times" aria-hidden="true"></i> Not on Homepage</p>
								<?php }else{ ?>
									<p class="on"><i class="fa fa-check" aria-hidden="true"></i> On Homepage</p>
								<?php } ?>
								<?php if($image['dont_display'] == 1){ ?>
									<p class="not"><i class="fa fa-times" aria-hidden="true"></i> Not in Frontend</p>
								<?php }else{ ?>
									<p class="on"><i class="fa fa-check" aria-hidden="true"></i> in Frontend</p>
								<?php } ?>
							</div>
						</a>
						<div class="image-bottom">
							<a id="rotate-left<?php echo $ajaximages; ?>" class="button-normal"><i class="fa fa-undo" aria-hidden="true"></i></a>
							<a class="button-normal" data-toggle="modal" data-target="#<?php echo $image['id']; ?>images">Homepage</a>
							<a id="rotate-right<?php echo $ajaximages; ?>" class="button-normal"><i class="fa fa-repeat" aria-hidden="true"></i></a>
						</div>

						<script>
							$(document).ajaxStart(function(){
						        $("#imagerotatingmodal").modal("show");
						    });
						   
							$(document).ready(function(){
							    $("#rotate-left<?php echo $ajaximages; ?>").on('click',function(){

							        $.post("<?php echo base_url('admin/images_rotate/'.$image['id'].'/left');?>",
							        {
							          images_rotate: "<?php echo base_url('uploads/listing_images/'.$image['listing_id'].'/'.$image['id'].'/thumb_small_'.$image['image'].'?'); ?>",
							        },
							        function(data,status){
							            $('#image-replace<?php echo $ajaximages; ?>').attr('src',data);
							        });

							    });

							    $("#rotate-right<?php echo $ajaximages; ?>").click(function(){

							        $.post("<?php echo base_url('admin/images_rotate/'.$image['id'].'/right');?>",
							        {
							          images_rotate: "<?php echo base_url('uploads/listing_images/'.$image['listing_id'].'/'.$image['id'].'/thumb_small_'.$image['image'].'?'); ?>",
							        },
							        function(data,status){
							            $('#image-replace<?php echo $ajaximages; ?>').attr('src',data);
							        });

							    });
							});

							$(document).ajaxComplete(function(){
						        $("#imagerotatingmodal").modal("hide");
						    });

						</script>
						</script>
					</div>

				</div>
			
				<div id="<?php echo $image['id']; ?>images" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
						<?php echo form_open('admin/images_home_save/'.$image['id']); ?>
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4>Homepage Settings</h4>
							</div>
							<div class="modal-body">
								<h5>Listing Details</h5>
								<div class="row">
									<div class="col-sm-3 text-right">
										Title:
									</div>
									<div class="col-sm-9">
										<?php echo $list['title']; ?>
									</div>
								</div>
								<div class="row  space">
									<div class="col-sm-3 text-right">
										Description:
									</div>
									<div class="col-sm-9">
										<?php echo $list['description']; ?>
									</div>
								</div>
								<br><br>
								<hr>
								<h5>Homepage Options</h5>
								<div class="row">
									<div class="col-sm-3 text-right">
										On homepage
									</div>
									<div class="col-sm-9">
										<input type="checkbox" name="on_homepage" <?php if($image['on_homepage'] == '1'){ echo 'checked'; } ?>>
									</div>
								</div>
								<div class="row  space">
									<div class="col-sm-3 text-right">	
										Homepage title
									</div>
									<div class="col-sm-9">
										<input type="" class="textbox-nomargin" name="homepage_title" value="<?php echo $image['homepage_title']; ?>">
									</div>
								</div>
								<hr>
								<h5>Frontend Option</h5>
								<div class="row">
									<div class="col-sm-3 text-right">
										Not in Frontend
									</div>
									<div class="col-sm-9">
										<input type="checkbox" name="dont_display" <?php if($image['dont_display'] == '1'){ echo 'checked'; } ?>>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-success btn-green">Save</button>
							</div>
						<?php echo form_close(); ?>
						</div>
					</div>
				</div>
				<?php $ajaximages++ ;?>
			<?php endforeach; ?>
		</div>

		<?php if($this->pagination->create_links() != ''){ ?>
			<div class="pagination-links text-center">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		<?php } ?>
	</div>
</div>

<!-- Modal -->
<div id="imagerotatingmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-images"></i> Image Rotating</h4>
      </div>
      <div class="modal-body text-center">
       	<p>
       		<img src="<?php echo base_url('assets/img/loading.gif'); ?>" width="100" height="100" />
       	</p>
       	<p>
       		Image Rotating pls wait ...
       	</p>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<?php endif; ?>

<?php } ?>

