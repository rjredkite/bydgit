<?php
	$countries = $this->getdata_model->get_countries(); 
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
		<h1>Search Users</h1>
		<hr>
		<button id="admin-search-button" class="search-fields-button" data-toggle="popovers" data-placement="right" title="Toggle Search Fields" data-content='Click this button to hide or show the search fields.' data-trigger="hover"><i class="fa fa-bars" aria-hidden="true"></i> Toggle Search fields</button> 
		<div class="admin-search-fields">
			<hr>
			<?php echo form_open('admin/users/search',array( 'method' => 'get')); ?>
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="textbox" name="id" placeholder="User ID" value="<?php echo $this->input->get('id', TRUE); ?>">
						<input type="email" class="textbox" name="email" placeholder="Email" value="<?php echo  $this->input->get('email', TRUE); ?>">
						<input type="text" class="textbox" name="name" placeholder="Name" value="<?php echo  $this->input->get('name', TRUE); ?>">
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
						<input type="text" class="textbox" name="phone" placeholder="Phone" value="<?php echo  $this->input->get('phone', TRUE); ?>">
					</div>
					<div class="col-md-6">
						<div class="date-calendar">
							<div class="input-group">
								<input type="text" class="datepicker" data-date-format="mm/dd/yyyy" name="join_date_after" placeholder="Joined After" value="<?php echo  $this->input->get('join_date_after', TRUE); ?>">
								<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="date-calendar">
							<div class="input-group">
								<input type="text" class="datepicker" data-date-format="mm/dd/yyyy" name="join_date_before"  placeholder="Joined Before" value="<?php echo  $this->input->get('join_date_before', TRUE); ?>">
								<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Newsletter</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="newsletter" value="all" <?php if($this->input->get('newsletter', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="newsletter" value="1" <?php if($this->input->get('newsletter', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="newsletter" value="0" <?php if($this->input->get('newsletter', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Banned</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="banned" value="all" <?php if($this->input->get('banned', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="banned" value="1" <?php if($this->input->get('banned', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="banned" value="0" <?php if($this->input->get('banned', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Suspended</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="suspended" value="all" <?php if($this->input->get('suspended', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="suspended" value="1" <?php if($this->input->get('suspended', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="suspended" value="0" <?php if($this->input->get('suspended', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Deleted</span>
								</div>
								<div class="col-sm-9">
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
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Paying</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="paying" value="all" <?php if($this->input->get('paying', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="paying" value="1" <?php if($this->input->get('paying', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="paying" value="0" <?php if($this->input->get('paying', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Confirmed</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="confirmed" value="all" <?php if($this->input->get('confirmed', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="confirmed" value="1" <?php if($this->input->get('confirmed', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="confirmed" value="0" <?php if($this->input->get('confirmed', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<button type="submit" class="button-primary">Search</button>
				<a href="<?php echo base_url('admin/users/search'); ?>" class="button-cancel">Cancel</a>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="body-container">
	<div class="table-max">
		<p>
			<?php echo $this->admin_model->count_users(); ?> <?php 
				if($this->admin_model->count_users() <= 1){
					echo 'User Found';
				}else{
					echo 'Users Found';
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
						<th>Email</th>
						<th>Name</th>
						<th>Country</th>
						<th>Plan</th>
						<th>Credits</th>
						<th style="width: 100px;">Joined</th>
						<th>Suspended</th>
						<th>Banned</th>
						<th>Confirmed</th>
						<th>Option</th> 
					</tr>
				</thead>
				<tbody>
					<?php foreach($users as $user): ?>
						<tr>
							<td><?php echo $user['id'] ;?></td>
							<td><?php echo $user['email'] ;?></td>
							<td><?php echo $user['first_name'] .' '. $user['last_name'] ;?></td>
							<td><?php 
									$country_id = $user['country_id'];
									$country = $this->getdata_model->get_countries_id($country_id);
									echo $country['name'];
							;?></td>
							<td><?php 
								$plan_id = $user['plan_id'];
								$plan = $this->getdata_model->get_plans_id($plan_id);
								echo $plan['name'];
							?></td>
							<td><?php echo $user['credits'] ;?></td>
							<td><?php 
								$date_joined=date_create($user['created_at']);
								echo date_format($date_joined,"Y-m-d");
							?></td>
							<td><?php 
								if($user['suspended'] == 0){
									echo 'No';
								}else{
									echo 'Yes';
								}
							?></td>
							<td><?php 
								if($user['banned'] == 0){
									echo 'No';
								}else{
									echo 'Yes';
								}
							?></td>
							<td><?php 
								if(!empty($user['confirm_code'])){
									echo 'No';
								}else{
									echo 'Yes';
								}
							?></td>
							<td class="text-center">
								<a href="<?php echo base_url('/admin/users/'.$user['id'].'/edit'); ?>" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
								<a href="<?php echo base_url('/admin/users/'.$user['id'].'/log_in_as'); ?>" class="btn btn-default"><i class="fa fa-sign-in" aria-hidden="true"></i> Log In As User</a>
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
