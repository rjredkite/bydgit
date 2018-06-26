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
							<option value="all">Any Listings</option>
							<option value="dog">Stud Dogs / Bitches</option>
							<option value="pup" selected>Litters</option>
							<option value="mem">Memorials</option>
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
				<a href="<?php echo base_url('admin/listings/puppies'); ?>" class="btn button-cancel">Cancel</a>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="body-container">
	<div class="table-max">
		<p>
			<?php echo $this->admin_model->count_listings_pup(); ?> <?php 
				if($this->admin_model->count_listings_pup() <= 1){
					echo 'Listing Found';
				}else{
					echo 'Listings Found';
				}
			?>
		</p>

		<div class="table-responsive">

			<?php if($this->pagination->create_links() != ''){ ?>
				<div class="pagination-links">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			<?php } ?>

			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Type</th>
						<th>Title</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Breed</th>
						<th>Country</th>
						<th>Pedigree</th>
						<th>Published</th>
						<th>Option</th> 
					</tr>
				</thead>
				<tbody>
					<?php foreach($listings as $list): ?>
						<tr>
							<td><?php echo $list['id'] ;?></td>
							<td><?php
								if($list['listing_type'] == 'dog'){
		                          echo 'Stud Dog / Bitch';
		                        }elseif($list['listing_type'] == 'pup'){
		                          echo 'Litter';
		                        }elseif($list['listing_type'] == 'mem'){
		                          echo 'Memorial';
		                        }
							?>
							</td>
							<td><?php echo $list['title'] ;?></td>
							<td><?php echo $list['name'] ;?></td>
							<td><?php 
								if($list['gender'] = 'm'){
									echo 'Dog';
								}else{
									echo 'Bitch';
								}
							?></td>
							<td><?php 
									$breed_id = $list['breed_id'];
									$breed = $this->getdata_model->get_breed_id($breed_id);
									echo $breed['name'];
							;?></td>
							<td><?php 
									$country_id = $list['country_id'];
									$country = $this->getdata_model->get_countries_id($country_id);
									echo $country['name'];
							;?></td>
							<td><?php 
								if($list['pedigree'] == 0){
									echo 'No';
								}else{
									echo 'Yes';
								}
							?></td>
							<td><?php 
								if($list['published'] == 0){
									echo 'No';
								}else{
									echo 'Yes';
								}
							?></td>
							<td class="text-center">
								<a href="<?php echo base_url('/admin/listings/'.$list['id'].'/edit'); ?>" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
								<a href="<?php echo base_url('/admin/connections?listing_id='.$list['id']); ?>" class="btn btn-default"><i class="fa fa-exchange" aria-hidden="true"></i> Connections</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
			<?php if($this->pagination->create_links() != ''){ ?>
				<div class="pagination-links">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			<?php } ?>

		</div>
	</div>
</div>
